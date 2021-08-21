<div class="rks-header">
    <div class="rks-header__container container mx-auto">
        <?php 
            wp_nav_menu([
                'theme_location'      => 'left-menu',
                'container'           => 'nav',
                'container_class'     => 'rks-header__nav rks-header__nav--left',
                'items_wrap'          => '<ul id="%1$s" class="%2$s">%3$s</ul>'
            ]);
        ?>
            
        <div class="rks-header__logo">
            <div class="rks-header__logo__text">
                <h2>
                    <span class="rks-header__logo__text--site-title">Eye of Echo</span>
                    <span class="rks-header__logo__text--tagline">A Mask for Your Vision</span>
                    <span class="rks-header__logo__text--author">. By Verlion D'Gorche .</span>
                </h2>
            </div>
            <?php
                if ( function_exists( 'the_custom_logo' ) ) {
                    the_custom_logo();
                }
            ?>
        </div>

        <?php
            wp_nav_menu([
                'theme_location'      => 'right-menu',
                'container'           => 'nav',
                'container_class'     => 'rks-header__nav rks-header__nav--right',
                'items_wrap'          => '<ul id="%1$s" class="%2$s">%3$s</ul>'    
            ]); 
        ?>

        <div id="rks-header__toggle">
            <div class="one"></div>
            <div class="two"></div>
            <div class="three"></div>
        </div>
    </div>
</div>

