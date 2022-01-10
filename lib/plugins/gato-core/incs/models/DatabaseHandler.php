<?php

namespace Gato\Models;

class DatabaseHandler {

    function __construct(){
        global $wpdb;

        $this->table_name = $wpdb->prefix . GATO_TABLE_NAME;
    }

    public function processData(){
        $data = $_POST;

        foreach($data as $key => $value){
            if($key === "gato-core-submit"){return;}

            $id = $this->findRow($key);

//            if(strlen($value) > 0){
                if($id){
                    $this->updateRow($id, $value);
                } else {
                    $this->addRow($key, $value);
                }
//            }
        }
    }

    public function findRow($key){
        global $wpdb;

        return $wpdb->get_var("SELECT * FROM `{$this->table_name}` WHERE name = '{$key}'");
    }

    public function getValue($handle){
        global $wpdb;

        return $wpdb->get_var("SELECT value FROM `{$this->table_name}` WHERE name = '{$handle}'");
    }

    public function addRow($key, $value){

        global $wpdb;

        $sql = $wpdb->insert($this->table_name, ["name" => $key, "value" => $value], ["%s"]);

        $wpdb->query($sql);

        // get the inserted record id.
        $id = $wpdb->insert_id;

        return $id;
    }

    public function updateRow($id, $value){
        global $wpdb;

        $sql = $wpdb->update($this->table_name, ["value" => $value], ["ID"=> $id], ["%s"]);

        $wpdb->query($sql);

        // get the inserted record id.
        $id = $wpdb->insert_id;

        return $id;
    }


    public function activateDatabase(){
        // Create the custom table
        global $wpdb;

        $table_name = $wpdb->prefix . GATO_TABLE_NAME;

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(244),
            value VARCHAR(244)
        ) $charset_collate;";

        require_once( ABSPATH . "wp-admin/includes/upgrade.php" );
        dbDelta( $sql );
    }

    public function deactivateDatabase(){
        global $wpdb;
        $table_name = $wpdb->prefix . GATO_TABLE_NAME ;
        $sql = "DROP TABLE IF EXISTS $table_name";
        $wpdb->query($sql);
    }
}