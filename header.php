<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo get_bloginfo('name'); ?></title>

    <!-- Chris` current font
    <link href="https://fonts.googleapis.com/css2?family=Cinzel+Decorative&family=Recursive:wght@300&display=swap" rel="stylesheet"> -->
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<div id="rks-page-loader" class="rks-page__loader">
    <?php
        if ( function_exists( 'the_custom_logo' ) ) {
            the_custom_logo();
        }
    ?>
</div>

<div class="rks-page__overlay"></div>


<?php echo get_template_part('/template-parts/navigation'); ?>