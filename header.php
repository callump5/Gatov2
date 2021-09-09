<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo get_bloginfo('name'); ?></title>

    <style>

        @keyframes example {
          0% {opacity: 0.5;}
          50% {opacity: 0.3;}
          100% {opacity: .5;}
        }
    </style>
    <!-- Chris` current font
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative&family=Recursive:wght@300&display=swap" rel="stylesheet"> -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

    <div id="rks-page-loader" class="rks-page__loader" style='position: fixed; inset: 0; background: #0a0a0a; display: flex; align-items: center; justify-content: center; transition: all 1s; z-index: 999999 !important;'>
        <?php

            $custom_logo_id = get_theme_mod( 'custom_logo' );
            $custom_logo = wp_get_attachment_image_src( $custom_logo_id , 'full' )[0];
            
            echo "<img src='{$custom_logo}' alt='' style='max-height: 50vh; width: auto; animation-name: example; animation-duration: 2.4s; animation-timing-function: ease; animation-iteration-count: infinite; opacity: 1;'>";
        ?>
    </div>
    <div class="rks-page__overlay" style='position: fixed; inset: 0; background:#00000090; z-index: 12382430; opacity: 0; pointer-events: none; transition: all .3s;'></div>

    <?php echo get_template_part('/template-parts/navigation'); ?>

        
    <div class='rks-page__content'>
        <div class="u-container rks-page__container">