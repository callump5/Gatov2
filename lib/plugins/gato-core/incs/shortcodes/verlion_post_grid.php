<?php


/* Shortcode ---------------------------------------------------------------- */

add_shortcode('verlion_post_grid', 'verlion_post_grid_function');

function verlion_post_grid_function($atts, $fields){

    extract(shortcode_atts([
        'post_type',
        'num_posts',
        'post_category',
        'grid_cols',
        'row_gap',
        'padding',
        'animated_thumb',
        'lazy_img',
        'lazy_vid',
    ], $atts));

    // Assign Variables
    $post_type   = 'post';
    $taxonomy    = 'category';
    $class       = 'verlion_post_grid';
    $order_by    = 'date';
    $order_dir   = 'DESC'; 
    $grid_cols   =  '1';
    $meta_key    = '';
    $num_posts   = (isset($atts["num_posts"]) && intval($atts["num_posts"]) > 0 ) ? intval($atts['num_posts']) : -1;  
    $post_cate   = (isset($atts["post_category"])) ? $atts["post_category"] : '0';
    $row_gap     = (isset($atts["row_gap"])) ? $atts["row_gap"] : '120px';
    $lazy_img    = (isset($atts["lazy_img"])) ?  $atts["lazy_img"] : false;
    $show_titles = (isset($atts["show_titles"])) ? $atts["show_titles"] : false;

    $query_args = [
        'post_type'        => $post_type,
        'numberposts'      => $num_posts,
        'meta_key'         => $meta_key,
        'orderby'          => $order_by,
        'order'            => $order_dir,
        'category'         => $post_cate,
    ];

    $posts = get_posts($query_args);

    ?>

    <style>
        .<?php echo $class ?>{
            display: grid;
            row-gap: <?php echo $row_gap ?>;
            grid-template-columns: repeat(<?php echo $grid_cols; ?>, 1fr) !important;
        }

        .<?php echo $class ?>__item{
            display: inline-flex;
            flex-direction: column;
            justify-content:center;
            align-items: center;

        }
 
        .<?php echo $class ?>__item--img{
            transition: all .2s;
            box-shadow: 0px 4px 10px 2px #ffffff00;   
            border-radius: 80%;
            height:200px;
            width: 400px;
            filter: grayscale(1);
            transition: all .8s ease;
            border: 5px solid #9f9d63;

        }
        .<?php echo $class ?>__item--img:hover{
            filter: grayscale(0);

        }

        .<?php echo $class ?> img:hover{
            box-shadow: 0 7px 10px -2px #ffffff70;
            transform: translateY(-10px) scale(1.03);
            z-index: 123123;
        }

        .<?php echo $class ?> h3{
            text-align: center;
            font-size: 22px;
            margin: 14px;
        }
    </style>

    <?php

    echo "<div class='{$class}'>";
        // Build post html
        foreach($posts as $post){
            echo verlion_build_post_html($post, $class, 'medium', $show_titles);
        }
    echo "</div>";

}

/* VC Map ---------------------------------------------------------------- */ 

function verlion_post_grid_vc_map(){

    $postCategorySelect = [];

    $default = [
        'id'    => '',
        'value' => 'All' 
    ];
    
    array_push($postCategorySelect, $default);

    $postCategories = get_categories();

    foreach($postCategories as $category){
        $i = [
            'id'    => $category->term_id,
            'value' => $category->name
        ];
        array_push($postCategorySelect, $i);
    }

    vc_map([
        "name"        => "Verlion's Posts",
        "description" => "This will display your posts",
        "base"        => "verlion_post_grid",
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
                'heading'     => 'Post Category', 
                'description' => 'Choose the post category you wish to display',
                'admin_label' => 'Category',
                'holder'      => 'div',
                'param_name'  => 'post_category',
                'type'        => 'dropdown',
                'value'       => $postCategorySelect,
                'edit_field_class' => 'vc_col-sm-6'
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
                'heading'     => 'Row Gap', 
                'description' => 'This is the verticle spacing between the posts',
                'type'        => 'textfield',
                'holder'      => 'div',
                'param_name'  => 'row_gap',
                'value'       => '70px',
                'edit_field_class' => 'vc_col-sm-6'
            ],
            // [
            //     'heading'     => 'Lazy Load Images', 
            //     'description' => 'Defer loading of images until visible on screen, speeds up page if lots of assets present',
            //     'admin_label' => 'Lazy Load Images',
            //     'holder'      => 'div',
            //     'param_name'  => 'lazy_img',
            //     'type'        => 'dropdown',
            //     'value'       => [
            //         'Select an option'  =>  '',
            //         'True'              =>  '1',
            //         'False'             =>  '0'
            //     ],
            //     'group'       => 'Lazy Loading'
            // ],
        ]
    ]);
}




