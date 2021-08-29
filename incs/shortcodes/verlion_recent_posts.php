<?php

add_shortcode('verlion_recent_posts', 'verlion_recent_posts_function');

function verlion_build_post_html($item, $class, $size){

    $className = $class . '__item';

    $post_id = $item->ID;
    $featured_img = get_the_post_thumbnail($post_id, $size);

    $item_html = "<div class={$className}>";
    $item_html .= $featured_img;
    $item_html .= "</div>";

    return $item_html;
}

function verlion_recent_posts_function( $atts ){
   
    extract(shortcode_atts([
        'title',
        'post_category',
        'num_posts'
    ], $atts));


    // Assign Variables
    $num_posts = (isset($atts["num_posts"]))     ? $atts['num_posts']     : '3';  
    $category  = (isset($atts["post_category"])) ? $atts["post_category"] : '';
    $class     = 'verlion_recent_posts';

    // Create widget title
    if(isset($atts["title"])){
        $_title_html = '<h2>' . $atts['title'] . '</h2>';
    }

    // Get posts
    $posts = get_posts([
        'numberposts'      => intval($num_posts),
        'category'         => $category,
        'orderby'          => 'date',
        'order'            => 'DESC',
        'include'          => [],
        'exclude'          => [],
        'meta_key'         => '',
        'meta_value'       => '',
        'post_type'        => 'portfolio',
    ]);


    $post_count = count($posts);
    $grid_cols = ($post_count < $num_posts) ? $post_count : $num_posts;


    ?>


    <style>
        .<?php echo $class ?>{
            display: grid;
            grid-gap: 10px;
            grid-template-columns: repeat(<?php echo $grid_cols; ?>, 1fr) !important;
            padding: 10px;
            
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
            echo verlion_build_post_html($post, $class, 'medium');
        }
    echo "</div>";








}


function verlion_recent_posts_vc_map(){

    vc_map([
        "name"        => "Verlion's Recent Posts",
        "description" => "This will display a grid of you selected post type",
        "base"        => "verlion_recent_posts",
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
                'heading'     => 'Category', 
                'description' => 'Choose the post category you wish to display',
                'admin_label' => 'Category',
                'holder'      => 'div',
                'param_name'  => 'post_category',
                'type'        => 'dropdown',
                'value'       => [
                    'option1label' => 'option1value',
                ],
             
            ]
        ]
    ]);
}