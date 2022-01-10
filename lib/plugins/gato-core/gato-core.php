<?php
/*
Plugin Name: Gato Core
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: This adds the settings for Gato's theme.
Version: 1.0
Author: Cal
License: A "Slug" license name e.g. GPL2
Text Domain: gato-core
*/

// Define plugin Constants
define("GATO_VERSION", "1.0.0");
define("GATO_REQUIRED_WP_VERSION", "5.4");
define("GATO_PLUGIN", __FILE__);
define("GATO_PLUGIN_DIR", untrailingslashit( dirname( GATO_PLUGIN )));
define("GATO_TABLE_NAME", "gato_core_settings");

require_once('incs/models/GatoCore.php');

// Pull in classes
use Gato\Models\GatoCore;


// Run plugin
function runGatoCorePlugin()
{
    $gatoCore = new GatoCore();
    $gatoCore->runPlugin();
}

// Activation Hook
function runGatoCoreActivationHook(){
    $gatoCore = new GatoCore();
    $gatoCore->dbHandler->activateDatabase();
}

// De-activation Hook
function runGatoCoreDeactivationHook(){
    $gatoCore = new GatoCore();
    $gatoCore->dbHandler->deactivateDatabase();
}

function registerShortcodes(){
    $gatoCore = new GatoCore();
    $gatoCore->registerShortcodes();
}


// Base actions and hooks
add_action('init', 'runGatoCorePlugin');
add_action('vc_before_init', 'registerShortcodes');


register_activation_hook( __FILE__, "runGatoCoreActivationHook" );
register_deactivation_hook( __FILE__, 'runGatoCoreDeactivationHook' );