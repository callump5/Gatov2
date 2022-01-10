<?php

if ( ! current_user_can( 'manage_options' ) ) {
    return;
}

if(isset($_POST['gato-core-submit'])){
    $this->dbHandler->processData();
}

//Get the active tab from the $_GET param

$tab = isset($_GET['tab']) ? $_GET['tab'] : null;
?>

    <!-- Our admin page content should all be inside .wrap -->
    <div class="wrap">

        <!-- Settings Section -->
        <div class="gato-settings">


            <nav class="gato-settings__nav">

                <li class='gato-settings__nav__item {$active}'>
                    <a class='gato-settings__nav__item__link' href='?page=gato-theme-settings'>Gato Theme Settings</a>
                </li>

                <?php

                    $active = "";


                    foreach($this->modules as $key => $item){
                        if($item['enabled'] && $item['settings']){
                            if($tab === $key){
                                $active = "active";
                            } else {
                                $active = "";
                            }

                            echo "
                                <li class='gato-settings__nav__item {$active}'>
                                    <a class='gato-settings__nav__item__link' href='?page=gato-theme-settings&tab={$key}'> 
                                        <span class='gato-settings__nav__item__icon dashicons dashicons-{$item['icon']}'></span>
                                        {$item['label']}
                                    </a>
                                </li>
                            ";
                        }
                    }
                ?>
            </nav>

            <div class="gato-settings__content">
                <?php
                    if ($tab === NULL){
                        include_once(GATO_PLUGIN_DIR . "/public/views/dashboard/panels/info.php");
                    } else {
                        include_once(GATO_PLUGIN_DIR . "/public/views/dashboard/panels/panel.php");
                    }                 
                ?>
            </div>
        </div>
    </div>
<?php