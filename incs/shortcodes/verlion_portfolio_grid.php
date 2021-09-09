<?php


// TODO: Line 57 categories dyanmic select
// TODO: Line 66 Meta value 
// TODO: Skin Select
// TODO: Group the VC maps fields on tabs 
// TODO: Refactor

add_shortcode('verlion_portfolio_grid', 'verlion_portfolio_grid_function');

function verlion_portfolio_grid_function( $atts ){
   
    extract(shortcode_atts([
        'title',
        'portfolio_category',
        'num_posts',
        'grid_cols',
        'grid_gap',
        'padding',
        'animated_thumb',
        'class',
        'lazy_img',
        'lazy_vid',
        'order_by',
        'order_direction'
    ], $atts));


    // Assign Variables

    $post_type = (isset($atts['post_type'])) ? $atts['post_type'] : 'portfolio';
    $num_posts = (isset($atts["num_posts"]) && intval($atts["num_posts"]) > 0 ) ? intval($atts['num_posts']) : -1;  
    $category  = (isset($atts["portfolio_category"])) ? $atts["portfolio_category"] : '0';
    $grid_cols = (isset($atts["grid_cols"])) ? $atts["grid_cols"] : '3';
    $grid_gap  = (isset($atts["grid_gap"])) ? $atts["grid_gap"] : '10px';
    $padding   = (isset($atts["padding"])) ? $atts["padding"] : '10px';
    $class     = (isset($atts["class"])) ? $atts["class"] : 'verlion_portfolio_grid';
    $lazy_img  = (isset($atts["lazy_img"])) ? (bool) $atts["lazy_img"] : false;
    $lazy_vid  = (isset($atts["lazy_vid"])) ? (bool) $atts["lazy_vid"] : false;
    $animate   = (isset($atts["animated_thumb"]) && (bool) $atts["animated_thumb"] === true) ? true : false;
    $order_by  = (isset($atts["order_by"])) ? $atts["order_by"] : 'meta_value';
    $order_direction = (isset($atts["order_direction"])) ? $atts["order_direction"] : 'ASC'; 
    
    // Create widget title
    if(isset($atts["title"])){
        $_title_html = '<h2>' . $atts['title'] . '</h2>';
    }

    // Get posts
    if($category > 0){
        $posts = get_posts([
            'post_type'        => $post_type,
            'numberposts'      => $num_posts,
            'meta_key'         => 'verlion_rank_meta',
            'orderby'          => $order_by,
            'order'            => $order_direction,
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
            'numberposts'      => $num_posts,
            'meta_key'         => 'verlion_rank_meta',
            'orderby'          => $order_by,
            'order'            => $order_direction,
        ]);
    }


    dd($posts);
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
            echo verlion_build_post_html($post, $class, 'medium', $lazy_img, $lazy_vid, $animate);
        }
    echo "</div>";

}

function verlion_portfolio_grid_vc_map(){

    $default = [
        'id'    => '',
        'value' => 'Select a category' 
    ];
    
    $portfolioCategorySelect = [];
    $postCategorySelect = [];

    array_push($portfolioCategorySelect, $default);
    array_push($postCategorySelect, $default);
    // dd($postCategorySelect);

    $portfolioCategories =  get_terms([
        'taxonomy' => 'portfolio-category',
        'hide_empty' => false,
    ]);

    $portfolioCategorySelect = [
        [
            'id'    => '',
            'value' => 'Select a category' 
        ]
    ];

    foreach($portfolioCategories as $category){
        $i = [
            'id'    => $category->term_id,
            'value' => $category->name
        ];
        array_push($portfolioCategorySelect, $i);
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
                'heading'     => 'Post Type', 
                'description' => 'What would you like to display?',
                'admin_label' => 'Post Type',
                'holder'      => 'div',
                'param_name'  => 'post_type',
                'type'        => 'dropdown',
                'value'       => [
                    'Select an option'  =>  '',
                    'Posts'             =>  'posts',
                    'Portfolio'         =>  'portfolio'
                ]
            ],
            [
                'heading'     => 'Portfolio Category', 
                'description' => 'Choose the portfolio category you wish to display',
                'admin_label' => 'Category',
                'holder'      => 'div',
                'param_name'  => 'portfolio_category',
                'type'        => 'dropdown',
                'value'       => $portfolioCategorySelect,
                'dependency'    => array(
                    'element'   => 'post_type',
                    'value'     => 'portfolio'
                ),
            ],
            [
                'heading'     => 'Post Category', 
                'description' => 'Choose the post category you wish to display',
                'admin_label' => 'Category',
                'holder'      => 'div',
                'param_name'  => 'post_category',
                'type'        => 'dropdown',
                'value'       => $postCategorySelect,
                'dependency'    => array(
                    'element'   => 'post_type',
                    'value'     => 'posts'
                ),
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
            ],
            [
                'heading'     => 'Lazy Load Images', 
                'description' => 'Defer loading of images until visiable on screen, speeds up page if lots of assets present',
                'admin_label' => 'Lazy Load Images',
                'holder'      => 'div',
                'param_name'  => 'lazy_img',
                'type'        => 'dropdown',
                'value'       => [
                    'Select an option'  =>  '',
                    'True'              =>  'true',
                    'False'             =>  'false'
                ]
            ],
            [
                'heading'     => 'Lazy Load Videos', 
                'description' => 'Defer loading of videos until visiable on screen, speeds up page if lots of assets present.',
                'admin_label' => 'Lazy Load Videos',
                'holder'      => 'div',
                'param_name'  => 'lazy_vid',
                'type'        => 'dropdown',
                'value'       => [
                    'Select an option'  =>  '',
                    'True'              =>  'true',
                    'False'             =>  'false'
                ]
            ],
            [
                'heading'     => 'Order By', 
                'description' => 'Choose what you would like to order the posts by',
                'admin_label' => 'Order By',
                'holder'      => 'div',
                'param_name'  => 'order_by',
                'type'        => 'dropdown',
                'value'       => [
                    'Select an option'  =>  '',
                    'Ranking'           =>  'meta_value',
                    'Date'             =>  'date'
                ]
            ],
            [
                'heading'     => 'Order Direction', 
                'description' => 'Choose the direction to order',
                'admin_label' => 'Order Direction',
                'holder'      => 'div',
                'param_name'  => 'order_direction',
                'type'        => 'dropdown',
                'value'       => [
                    'Select an option'  =>  '',
                    'Ascending'           =>  'ASC',
                    'Descending'          =>  'DESC'
                ]
            ]
        ]
    ]);
}