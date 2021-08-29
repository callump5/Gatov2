<?php get_header(); ?>



<?php 
    if ( have_posts() ) {
        while( have_posts() ) {
            the_post();
            if (is_single() && $post->post_type == 'portfolio' ){
                    echo get_template_part('/template-parts/posts/portfolio', 'single');
            } else {?>
            <!-- <h1 style='font-size:28px; margin-bottom: 10px'><?php the_title(); ?></h1> -->
            <?php the_content( ); ?>

            <?php }
        }
    } else {
        echo '<h2>There currently are no posts</h2>';
    }
?>

<?php get_footer(); ?>
