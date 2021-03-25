<?php
    $default_config = include("default-config.php");

    define("MP_PROTOCOL", "3");

    if(file_exists("config.php")){
        $loaded_config = include("config.php");

        foreach ($loaded_config as $key => $value) {
            define($key, $value);
        }
    }
    
    foreach ($default_config as $key => $value) {
        if(!defined($key)){
            define($key, $value);
        }
    }

    include("src/nbt.class.php");
    include("src/utils.php");
    include("src/db_manager.php");
    include("src/accounts.php");
    include("src/sync_info.php");
    include("src/listings.php");
    include("src/session_manager.php");
    include("src/items.php");
?>