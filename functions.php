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
add_action('wp_enqueue_scripts', 'verlion_enqueue_assets');



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
add_action( 'get_footer', 'verlion_enqueue_deferred_styles' );


/*** Nav Menu ***/
function verlion_register_menus(){
    register_nav_menus([
        'left-menu' => __('Left Nav Menu', 'verlion'),
        'right-menu' => __('Right Nav Menu', 'verlion')
    ]);
}
add_action('after_setup_theme', 'verlion_register_menus');



/*** Theme Support ***/
function verlion_theme_support(){

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
add_action( 'after_setup_theme', 'verlion_theme_support' );







