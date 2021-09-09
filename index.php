<?php get_header(); ?>

<?php 
    if ( have_posts() ) {
        while( have_posts() ) {
            the_post();

            $featured_img = get_the_post_thumbnail_url();

            if($featured_img){
                echo "<img width='300' height='300' class='rks-featured-img' src='{$featured_img}' alt=''>";
            }

            the_content( );
            
        }
    } else {
        echo '<h2>There currently are no posts</h2>';
    }
?>

<?php get_footer(); ?>