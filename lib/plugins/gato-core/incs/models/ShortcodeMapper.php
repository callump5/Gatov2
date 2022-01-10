<?php

namespace Gato\Models;

class ShortcodeMapper {

    // Specify shortcode slugs here and they'll be pulled in
    public function __construct(
        AdminArea $adminArea
    ) {
        $this->adminArea = $adminArea;
    }

    // Register theme shortcodes using the global shortcodes array
    function addShortcodes(){
        foreach($this->adminArea->modules as $shortcode){
            if($shortcode["shortcode"]){
                $filename =   GATO_PLUGIN_DIR . '/incs/shortcodes/verlion_' . $shortcode["shortcode"] . '.php';

                if(file_exists($filename)){
                    require_once($filename);
                }
            }
        }
    }

    // Register the VC maps for the shortcodes
    function vcMmapping(){  
        foreach($this->adminArea->modules as $shortcode){
            if($shortcode["shortcode"]){
                $vc_map_function = 'verlion_' . $shortcode["shortcode"] . '_vc_map';
        
                if(function_exists($vc_map_function)){
                    $vc_map_function($shortcode);
                }
            }
        }
    }
}