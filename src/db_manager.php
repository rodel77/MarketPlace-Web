<?php
    function db_connect(){
        if(!isset($GLOBALS["currentConnection"])){
            $GLOBALS["currentConnection"] = new PDO("mysql:host=".DB_HOST.";dbname=".DB_DATABASE, DB_USER, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }

        return $GLOBALS["currentConnection"];
    }
?>