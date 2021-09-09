<?php

function verlion_build_post_html($item, $class, $size, $lazy_img = false, $lazy_vid = false, $animate = false){

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
    $post_link        = get_permalink($item);
    
    $id = 'asset_' . $post_id;
    
    if($lazy_img === true and $featured_img_url){ 
        $img_class .= 'verlion-lazy-loaded';
        $src        = $placeholder;
        $data_src   = $featured_img_url;
    } else {
        $src        = $featured_img_url;
    }

    $asset_html = "<img id='{$id}' class='{$img_class}' title='{$asset_title}' data-src='{$data_src}' src='{$src}' height='{$height}' width='{$width}'/>";


    if($animate === true){
        $lazy_attrs = '';
        if($lazy_vid === true){
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

  
    $item_html = "<a href={$post_link} class={$className}>";
    $item_html .= $asset_html;
    $item_html .= "</a>";

    return $item_html;
}
