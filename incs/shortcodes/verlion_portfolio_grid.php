<?php

add_shortcode('verlion_portfolio_grid', 'verlion_portfolio_grid_function');

function verlion_build_post_html($item, $class, $size, $lazy_load = false, $animate = false){

    $className        = $class . '__item';
    $post_id          = $item->ID;
    $placeholder      = '/wp-content/themes/gatov2/public/imgs/placeholder.jpg';
    $featured_img     = get_the_post_thumbnail_url($post_id, $size);
    $featured_img_url = ($featured_img) ? $featured_img : $placeholder;
    $height           = (get_option( "{$size}_size_w" )) ? get_option( "{$size}_size_w" ) : '300';
    $width            = (get_option( "{$size}_size_h" )) ? get_option( "{$size}_size_h" ) : '300';
    $img_class        = '';
    $data_src         = '';
    $asset_title      = get_the_title($post_id) . ' album artwork preview';
    
    $id = 'asset_' . $post_id;

    if($lazy_load === true and $featured_img_url){
        $img_class .= 'verlion-lazy-loaded';
        $src        = $placeholder;
        $data_src   = $featured_img_url;
    } else {
        $src        = $featured_img_url;
    }

    $asset_html = "<img id='{$id}' class='{$img_class}' title='{$asset_title}' data-src='{$data_src}' src='{$src}' height='{$height}' width='{$width}'/>";

    if($animate === true){
        $lazy_attrs = '';
        if($lazy_load === true){
            $lazy_attrs = "preload='none' poster='{$placeholder}'";
        }
        $post_video_thumb  = get_post_meta($post_id, 'verlion_video_meta', true);

        if($post_video_thumb){
            $asset_html  = "<video id='{$id}' class='verlion-lazy-loaded' {$lazy_attrs} title='{$asset_title}' autoplay loop>";
            $asset_html .= "<source src='{$post_video_thumb}' type='video/mp4'>";
            $asset_html .= "</video>";
        }
    }


    // dd($featured_img);

    $item_html = "<div class={$className}>";
    $item_html .= $asset_html;
    $item_html .= "</div>";

    return $item_html;
}

function verlion_portfolio_grid_function( $atts ){
   
    extract(shortcode_atts([
        'title',
        'post_category',
        'num_posts',
        'grid_cols',
        'grid_gap',
        'padding',
        'animated_thumb',
        'class'
    ], $atts));


    // Assign Variables
    $num_posts = (isset($atts["num_posts"]) && intval($atts["num_posts"]) > 0 ) ? intval($atts['num_posts']) : -1;  
    $category  = (isset($atts["post_category"])) ? $atts["post_category"] : '0';
    $grid_cols = (isset($atts["grid_cols"])) ? $atts["grid_cols"] : '3';
    $grid_gap  = (isset($atts["grid_gap"])) ? $atts["grid_gap"] : '10px';
    $padding   = (isset($atts["padding"])) ? $atts["padding"] : '10px';
    $animate   = ($atts["animated_thumb"] === 'true') ? true : false;
    $class     = (isset($atts["class"])) ? $atts["class"] : 'verlion_portfolio_grid';

    
    // Create widget title
    if(isset($atts["title"])){
        $_title_html = '<h2>' . $atts['title'] . '</h2>';
    }

    // Get posts
    if($category > 0){
        $posts = get_posts([
            'post_type'        => 'portfolio',
            'numberposts'      => $num_posts,
            'meta_key'         => 'verlion_rank_meta',
            'orderby'          => 'meta_value',
            'order'            => 'ASC',
            'tax_query' => [
                [
                    'taxonomy' => 'portfolio-category',
                    'field'    => 'id',
                    'terms'    => $category
                ]
            ]
        ]);
    } else {
        $posts = get_posts([
            'post_type'        => 'portfolio',
            'numberposts'      => $num_posts,
            'meta_key'         => 'verlion_rank_meta',
            'orderby'          => 'meta_value',
            'order'            => 'ASC',
        ]);
    }
    ?>

    <style>
        .<?php echo $class ?>{
            display: grid;
            grid-gap: <?php echo $grid_gap ?>;
            grid-template-columns: repeat(<?php echo $grid_cols; ?>, 1fr) !important;
            padding: <?php echo $padding ?>;
        }
 
        .<?php echo $class ?> img{
            transition: all .2s;
            box-shadow: 0px 4px 10px 2px #ffffff00;
            
        }

        .<?php echo $class ?> img:hover{
            box-shadow: 0 7px 10px -2px #ffffff70;
            transform: translateY(-10px) scale(1.03);
            z-index: 123123;
        }
    </style>

    <?php

    echo "<div class='{$class}'>";
        // Build post html
        foreach($posts as $post){
            echo verlion_build_post_html($post, $class, 'medium', true, $animate);
        }
    echo "</div>";

}

function verlion_portfolio_grid_vc_map(){

    $categories =  get_terms([
        'taxonomy' => 'portfolio-category',
        'hide_empty' => false,
    ]);

    $categorySelect = [
        [
            'id'    => '',
            'value' => 'Select a category' 
        ]
    ];

    foreach($categories as $category){
        $i = [
            'id'    => $category->term_id,
            'value' => $category->name
        ];
        array_push($categorySelect, $i);
    }



    vc_map([
        "name"        => "Verlion's Portfolio",
        "description" => "This will display a grid of your portfolio items",
        "base"        => "verlion_portfolio_grid",
        "class"       => "",
        "category"    => "Verlion",
        "params"      => [
            [
                'heading'     => 'Title',
                'description' => 'Enter a title for the widget (optional)',
                'type'        => 'textfield',
                'holder'      => 'div',
                'param_name'  => 'title',
                'value'       => '',
            ],
            [
                'heading'     => 'Number of Post',
                'description' => 'Choose the amount of posts you would like to display',
                'type'        => 'textfield',
                'holder'      => 'div',
                'param_name'  => 'num_posts',
                'value'       => '3',
            ],
            [
                'heading'     => 'Grid Column',
                'description' => 'Choose the number of columns to display the images in',
                'type'        => 'textfield',
                'holder'      => 'div',
                'param_name'  => 'grid_cols',
                'value'       => '3',
            ],
            [
                'heading'     => 'Grid Gap',
                'description' => 'Enter the gap size in px amount eg 10px',
                'type'        => 'textfield',
                'holder'      => 'div',
                'param_name'  => 'grid_gap',
                'value'       => '10px',
            ],
            [
                'heading'     => 'Padding',
                'description' => 'Enter the padding amount in px amount eg 10px',
                'type'        => 'textfield',
                'holder'      => 'div',
                'param_name'  => 'padding',
                'value'       => '10px',
            ],
            [
                'heading'     => 'Category', 
                'description' => 'Choose the post category you wish to display',
                'admin_label' => 'Category',
                'holder'      => 'div',
                'param_name'  => 'post_category',
                'type'        => 'dropdown',
                'value'       => $categorySelect
            ],
            [
                'heading'     => 'Animated Thumbnails', 
                'description' => 'If you have uploaded video thumbnails this setting will display them',
                'admin_label' => 'Animated Thumbnails',
                'holder'      => 'div',
                'param_name'  => 'animated_thumb',
                'type'        => 'dropdown',
                'value'       => [
                    'Select an option'  =>  '',
                    'True'              =>  'true',
                    'False'             =>  'false'
                ]
            ]
        ]
    ]);
}