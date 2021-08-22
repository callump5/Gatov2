<?php


/*** Define Assets ***/
$assets = [
    'styles' => [
        'main' => [
            'path' => '/public/css/main.css',
            'dep'  => [],
            'defer' => false,
        ],
        'tailwind' => [
            'path' => '/public/css/tailwind.css',
            'dep'  => [],
            'defer' => true,
        ]
    ],
    'scripts' => [
        'jQuery'  => [
            'path'    => '/public/js/jquery.js',
            'defer'   => false,
            'dep'     => [],
            'enabled' => false

        ],
        'particleJS' => [
            'path'     => '/public/js/particles.min.js',
            'defer'    => true,
            'dep'      => [],
            'enabled'  => true
        ]
    ]
];


$shortcodes = [
    'recent_posts',
    'social_icons'
];



// Register theme shortcodes 
function verlion_add_shortcodes(){

    global $shortcodes;

    foreach($shortcodes as $shortcode){
        $filename =  dirname( __FILE__ ) .'/incs/shortcodes/verlion_' . $shortcode . '.php';
        if(file_exists($filename)){
            require($filename);
        }
    }
}
// Register the VC maps for the shortcodes 
function verlion_vc_mapping(){

    global $shortcodes;

    foreach($shortcodes as $shortcode){
        $vc_map_function = 'verlion_' . $shortcode . '_vc_map';
        if(function_exists($vc_map_function)){
            $vc_map_function();
        }
    }
}



/*** Enqueue All Assets ***/
function verlion_enqueue_assets(){

    global $assets;

    foreach ($assets['styles'] as $label => $asset){

        if($asset['defer'] !== true){
            wp_enqueue_style(
                $handle = $label,
                $src    = get_template_directory_uri() . $asset['path'],
                $deps   = $asset['dep'],
                $ver    = 1,
                $media  = 'all'
            );
        }
        
    }

    foreach ($assets['scripts'] as $label => $asset){

        if($asset['enabled'] === true){
            wp_enqueue_script(
                $handle    = $label,
                $src       = get_template_directory_uri() . $asset['path'],
                $deps      = $asset['dep'],
                $ver       = 1,
                $in_footer = $asset['defer']
            );
        }
    }

}





function verlion_enqueue_deferred_styles(){

    global $assets;

    foreach ($assets['styles'] as $label => $asset){

        if($asset['defer'] === true) {
            wp_enqueue_style(
                $handle = $label,
                $src    = get_template_directory_uri() . $asset['path'],
                $deps   = $asset['dep'],
                $ver    = 1,
                $media  = 'all'
            );
        }
    }
}




/*** Theme Support ***/
function verlion_theme_support(){

    // Nav Menus
    register_nav_menus([
        'left-menu' => __('Left Nav Menu', 'verlion'),
        'right-menu' => __('Right Nav Menu', 'verlion')
    ]);

    // Custom Background
    add_theme_support('custom-background');

    // Featured Images
    add_theme_support('post-thumbnails');

    // Custom Logo
    add_theme_support( 'custom-logo', [
            'height' => 800,
            'width' => 800,
            'flex-height' => true,
            'flex-width' => true
        ]
    );
}





/*** Theme Actions ***/
add_action('init',               'verlion_add_shortcodes');
add_action('vc_before_init',     'verlion_vc_mapping' );
add_action('wp_enqueue_scripts', 'verlion_enqueue_assets');
add_action('get_footer',         'verlion_enqueue_deferred_styles' );
add_action('after_setup_theme',  'verlion_theme_support' );







