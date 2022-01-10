<?php

namespace Gato\Models;

class GatoCore
{

    public function __construct()
    {
        // Pull in bootstraps file;
        require_once (GATO_PLUGIN_DIR . '/incs/helpers/bootstrap.php');

        // Init instance of DB Handler
        $this->dbHandler = new \Gato\Models\DatabaseHandler;

        // Init instance of Admin Area
        $this->adminArea = new \Gato\Models\AdminArea($this->dbHandler);

        // Init instance of Shortcode Mapper
        $this->shortcodes = new \Gato\Models\ShortcodeMapper($this->adminArea);
    }

    public function runPlugin(){
        // Run init functions
        $this->adminArea->setAdminArea();

        // Enqueue all assets
        $this->adminArea->setAdminAreaAssets();
    }

    public function registerShortcodes(){
        // Add Shortcodes
        $this->shortcodes->addShortcodes();
        $this->shortcodes->vcMmapping();
    }
}