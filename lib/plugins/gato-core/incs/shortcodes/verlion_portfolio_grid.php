<?php


/* Shortcode ---------------------------------------------------------------- */

add_shortcode('verlion_portfolio_grid', 'verlion_portfolio_grid_function');

function verlion_portfolio_grid_function( $atts ){
   
    extract(shortcode_atts([
        'num_posts',
        'portfolio_category',
        'grid_cols',
        'grid_gap',
        'padding',
        'animated_thumb',
        'lazy_img',
        'lazy_vid',
        'order_by',
        'order_dir' 
    ], $atts));

    // Assign Variables
    $post_type = 'portfolio';
    $class     = 'verlion_portfolio_grid';
    $taxonomy  = 'portfolio-category';
    $meta_key  = '';
    $num_posts = (isset($atts["num_posts"]) && intval($atts["num_posts"]) > 0 ) ? intval($atts['num_posts']) : -1;  
    $port_cate = (isset($atts["portfolio_category"])) ? $atts["portfolio_category"] : '0';
    $grid_cols = (isset($atts["grid_cols"])) ? $atts["grid_cols"] : '3';
    $grid_gap  = (isset($atts["grid_gap"])) ? $atts["grid_gap"] : '10px';
    $padding   = (isset($atts["padding"])) ? $atts["padding"] : '10px';
    $animate   = (isset($atts["animated_thumb"])) ? $atts["animated_thumb"]  : false;
    $lazy_img  = (isset($atts["lazy_img"])) ? $atts["lazy_img"] : false;
    $lazy_vid  = (isset($atts["lazy_vid"])) ? $atts["lazy_vid"] : false;
    $order_by  = (isset($atts["order_by"])) ? $atts["order_by"] : 'date';
    $order_dir = (isset($atts["order_dir"])) ? $atts["order_dir"] : 'ASC'; 
    $show_titles = (isset($atts["show_titles"])) ? $atts["show_titles"] : false;
 
    if ($order_by === 'meta_rank'){
        $order_by = 'meta_value';
        $meta_key = 'verlion_rank_meta';
    }
    
    $query_args = [
        'post_type'        => $post_type,
        'numberposts'      => $num_posts,
        'meta_key'         => $meta_key,
        'orderby'          => $order_by,
        'order'            => $order_dir,
        'tax_query'        => [
        
            'taxonomy' => $taxonomy,
            'field'    => 'id',
            'terms'    => $port_cate
        
        ]
    ];
    

    $posts = get_posts($query_args);

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


        .<?php echo $class ?> h3{
            text-align: center;
            font-size: 18px;
            margin: 11px;
        }
    </style>

    <?php

    echo "<div class='{$class}'>";
        // Build post html
        foreach($posts as $post){
            echo verlion_build_portfolio_post_html($post, $class, 'medium', $lazy_img, $lazy_vid, $animate, $show_titles );
        }
    echo "</div>";

}






/* VC Map ---------------------------------------------------------------- */

function verlion_portfolio_grid_vc_map(){

    $default = [
        'id'    => '',
        'value' => 'All' 
    ];
    
    $portfolioCategorySelect = [];

    array_push($portfolioCategorySelect, $default);
    // dd($postCategorySelect);

    $portfolioCategories =  get_terms([
        'taxonomy' => 'portfolio-category',
        'hide_empty' => false,
    ]);
    
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
                'heading'     => 'Number of Post To Display',
                'description' => 'Choose the amount of posts you would like to display (leave blank to display all)',
                'type'        => 'textfield',
                'holder'      => 'div',
                'param_name'  => 'num_posts',
                'value'       => '3',
            ],
            [
                'heading'     => 'Portfolio Category', 
                'description' => 'Choose the portfolio category you wish to display',
                'admin_label' => 'Category',
                'holder'      => 'div',
                'param_name'  => 'portfolio_category',
                'type'        => 'dropdown',
                'value'       => $portfolioCategorySelect,
                'dependency'    => [
                    'element'   => 'post_type',
                    'value'     => 'portfolio'
                ],
                'edit_field_class' => 'vc_col-sm-6'
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
                    'True'              =>  '1',
                    'False'             =>  '0'
                ],
                'edit_field_class' => 'vc_col-sm-6'
            ],
            [
                'heading'     => 'Grid Column',
                'description' => 'Choose the number of columns to display the images in',
                'type'        => 'textfield',
                'holder'      => 'div',
                'param_name'  => 'grid_cols',
                'value'       => '3',
                'group'       => 'Grid Styling'
            ],
            [
                'heading'     => 'Grid Gap',
                'description' => 'Enter the gap size in px amount eg 10px',
                'type'        => 'textfield',
                'holder'      => 'div',
                'param_name'  => 'grid_gap',
                'value'       => '10px',
                'group'       => 'Grid Styling',
                'edit_field_class' => 'vc_col-sm-6'
            ],
            [
                'heading'     => 'Padding',
                'description' => 'Enter the padding amount in px amount eg 10px',
                'type'        => 'textfield',
                'holder'      => 'div',
                'param_name'  => 'padding',
                'value'       => '10px',
                'group'       => 'Grid Styling',
                'edit_field_class' => 'vc_col-sm-6'
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
                    'True'              =>  '1',
                    'False'             =>  '0'
                ],
                'group'       => 'Lazy Loading'
            ],
            [
                'heading'     => 'Show Titles', 
                'description' => 'Would you like to display the title below the post?',
                'admin_label' => 'Category',
                'holder'      => 'div',
                'param_name'  => 'show_titles',
                'type'        => 'dropdown',
                'value'       => [
                    'Select an option'  =>  '',
                    'True'              =>  '1',
                    'False'             =>  '0'
                ],
                'edit_field_class' => 'vc_col-sm-6'
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
                    'True'              =>  '1',
                    'False'             =>  '0'
                ],
                'group'       => 'Lazy Loading'
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
                    'Ranking'           =>  'meta_rank',
                    'Date'             =>  'date'
                ],
                'group'       => 'Ordering'
            ],
            [
                'heading'     => 'Order Direction', 
                'description' => 'Choose the direction to order',
                'admin_label' => 'Order Direction',
                'holder'      => 'div',
                'param_name'  => 'order_dir',
                'type'        => 'dropdown',
                'value'       => [
                    'Select an option'  =>  '',
                    'Ascending'           =>  'ASC',
                    'Descending'          =>  'DESC'
                ],
                'group'       => 'Ordering'
            ]
        ]
    ]);
}