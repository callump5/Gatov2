<?php

namespace Gato\Models;

class AdminArea {

    function __construct(
        DatabaseHandler $dbHandler
    ){
        $this->dbHandler = $dbHandler;

        $this->assets = [
            'styles' => [
                'gato-core-css' => [
                    'path'      =>  '/wp-content/plugins/gato-core/public/css/gato-core-admin.css',
                    'enabled'   => true,
                    'dep'       => [],
                ],
            ],
        ];

        $this->modules = [
            "particleJs"    => [
                "enabled"   => true,
                "settings"  => true,
                "label"     => "Particle JS",
                "icon"      => "rest-api",
                "shortcode" => "",
                "fields"    => [
                    [
                        "label" => "Enabled",
                        "description" => '',
                        "name"  => "particle-enabled",
                        "type" => "radio",
                        "options" => [
                            'Enabled',
                            'Disabled'
                        ]
                    ],
                    [
                        "label" => "Particle Count",
                        "description" => 'A larger value will increase the particle count (0-600)',
                        "name"  => "particle-count",
                        "type" => "number"
                    ],
//                    [
//                        "label" => "Density",
//                        "description" => 'A larger value will result in the particle being spread out',
//                        "name"  => "particle-density",
//                        "type" => "number"
//                    ],
                    [
                        "label" => "Color",
                        "description" => 'Color of the particle in hex value. There was no option for opacity so after you put your hex in if you want it transparent you can put the % after e.g. white at 40% = #ffffff40, black at 20% = #00000020.',
                        "name"  => "particle-color",
                        "type" => "text"
                    ],
//                    [
//                        "label" => "Opactity",
//                        "description" => 'Opactity of the particle',
//                        "name"  => "particle-opacity",
//                        "type" => "number"
//                    ],
                    [
                        "label" => "Speed",
                        "description" => 'Speed of the particle (0-200)',
                        "name"  => "particle-speed",
                        "type" => "number"
                    ],
                ]
            ],
            "socials"       => [
                "enabled"   => true,
                "settings"  => true,
                "label"     => "Socials",
                "icon"      => "buddicons-activity",
                "shortcode" => "social_icons",
                "fields"    => [
                    [
                        "label" => "Link To Facebook",
                        "name"  => "facebook"
                    ],
                    [
                        "label" => "Link To Insta",
                        "name"  => "instagram"
                    ],
                    [
                        "label" => "Link To Twitter",
                        "name"  => "twitter"
                    ],
                    [
                        "label" => "Link To Fiver",
                        "name"  => "fiver"
                    ],
                    [
                        "label" => "Link To Behance",
                        "name"  => "behance"
                    ]
                ]
            ],
            "postGrid"      => [
                "enabled"   => true,
                "settings"  => false,
                "label"     => "Post Grid",
                "icon"      => "",
                "shortcode" => "post_grid",
                "fields"    => []
            ],
            "portfolioGrid" => [
                "enabled"   => true,
                "settings"  => false,
                "label"     => "Portfolio Grid",
                "icon"      => "",
                "shortcode" => "portfolio_grid",
                "fields"    => []
            ],
        ];
    }

    // Set all pages for the admin area views
    public function setAdminArea()
    {
        add_action('admin_menu', function () {
            add_menu_page("Gato Theme", "Gato Theme", 'manage_options', 'gato-theme-settings', [$this, 'getDashboard'], 'dashicons-drumstick', '70');
        });
    }

    // Set the assets for the admin area
    public function setAdminAreaAssets(){
        add_action("admin_enqueue_scripts", function () {
            foreach ($this->assets['styles'] as $label => $asset) {
                wp_enqueue_style(
                    $handle = $label,
                    $src =  $asset['path'],
                    $deps = $asset['dep'],
                    $ver = 1,
                    $media = 'all'
                );
            }
        });
    }


    public function getSettingsTitle($tab){
        return "<h2>{$this->modules[$tab]["label"]} Settings</h2>";
    }


    public function getSettingsField($tab, $field){

        $panel = strtolower(str_replace(" ", "-", $this->modules[$tab]["label"]));

        $handle = "gato-core-{$panel}-{$field['name']}";

        $description= "";
        $type = "text";

        $value = $this->dbHandler->getValue($handle);

        if(isset($field['description'])){
            $description = "<p>{$field['description']}</p>";
        }

        if(isset($field['type'])){
            $type = $field['type'];
        }

        $input = "";

        if($type === "radio"){


            foreach($field["options"] as $option){

                if($value === $option) {
                    $checked = "checked='checked'";
                } else {
                    $checked = "";
                }

                $input .= "<input type='{$type}' {$checked} name='{$handle}' value='{$option}'><span style='margin-right:5px'>{$option}</span>";
            }
        } else {
            $input = "<input type='{$type}' step='.01' name='{$handle}' value='{$value}'>";
        }





        return "
            <div class='gato-settings__field'>
                <label for='{$field['name']}'>{$field['label']}</label>
                {$description}
                {$input}
            </div>
        ";


    }

    // Get admin dashboard
    public function getDashboard() {

        include_once(GATO_PLUGIN_DIR . "/public/views/dashboard/index.php");
    }


}