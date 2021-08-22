<?php 

add_shortcode('verlion_social_icons', 'verlion_social_icons_function');


function verlion_social_icons_function( $atts ){

    extract(shortcode_atts([

    ], $atts));

    return 'test';

}


// function verlion_social_icons_vc_map(){
//     return null;
// }