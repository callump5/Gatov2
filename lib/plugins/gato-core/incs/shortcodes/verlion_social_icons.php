<?php 
GATO_PLUGIN_DIR . '/incs/models/DatabaseHandler.php';

use Gato\Models\DatabaseHandler;

add_shortcode('verlion_social_icons', 'verlion_social_icons_function');

function verlion_social_icons_function($atts) {

    $dbHandler = new DatabaseHandler;

    extract($atts);


    $socials = [];
    $iconHtml = "";

    foreach($atts as $key => $enabled) {

        $link = $dbHandler->getValue('gato-core-socials-'. $key);
                
        $icon_path = "/wp-content/plugins/gato-core/public/icons/";

        switch ($key) {
            case "behance":
                $icon = $icon_path . "Behance-Beige.png";
                break;
            case "fiver":
                $icon = $icon_path . "Fiverr-Beige.png";
                break;
            case "facebook":
            case "twitter":
            case "instagram":
                $icon = $icon_path . "Instagram-Beige.png";
                break;
            default:
                $icon = "";
                break;
        }

        $maxWidth = "";
        $margin = "";

        if(isset($max_img_width)) {
            $maxWidth = "style='max-width:{$max_img_width}px'";
        }

        if(isset($img_margin)){
            $margin = "style='margin:{$img_margin}px'";
        }




        $iconHtml .= "
            <a href='{$link}' {$margin} target='_blank' class='verlion_socials__icon'>
                <img {$maxWidth} src='{$icon}'>
            </a>
        ";
    }

    $html = "

        <div class='verlion_socials'>
            {$iconHtml}
        </div>;
    ";

    return $html;
}


function verlion_social_icons_vc_map($shortcode){
    $params = [
        [
            'heading'     => 'Max image width without the px (currently 150)',
            'type'        => 'textfield',
            'holder'      => 'div',
            'param_name'  => 'max_img_width',
            'value'       => '150',
        ],
        [
            'heading'     => 'Margin for the icons without the px (currently 20)',
            'type'        => 'textfield',
            'holder'      => 'div',
            'param_name'  => 'img_margin',
            'value'       => '20',
        ],
    ];

    foreach($shortcode['fields'] as $field){

        $heading = "Display {$field['label']}";

        $params[] = [
            'heading'     => $heading,
            'type'        => 'checkbox',
            'holder'      => 'div',
            'param_name'  => $field['name'],
            'value'       => true
        ];

    }


    // dd($params);
    
    vc_map([
        "name"        => "Verlion's Socials",
        "description" => "This will display your socials",
        "base"        => "verlion_social_icons",
        "class"       => "",
        "category"    => "Verlion",
        "params"      => $params
    ]);
    
    return;
}