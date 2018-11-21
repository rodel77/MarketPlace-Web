<?php
    // Instructions:
    // This is the default configuration, you should create a "config.php" file
    // in the same path, copy the info right here and then modify it on the new file, 
    // so when you install a new version you will just have to add the keys you want to edit
    // in the new file or leave them by default

    // This configuration should be the same as the one on the MarketPlace plugin
    define("DB_HOST", "localhost");
    define("DB_USER", "root");
    define("DB_PASSWORD", "localito");
    define("DB_DATABASE", "mc");
    define("DB_TABLE_CATALOG", "catalog");
    define("DB_TABLE_ACCOUNTS", "webaccounts");
    // define("ITEMS_PER_PAGE", 10);
    // define("MAX_LORE_LENGTH", 100);
    // define("MAX_NAME_LENGTH", 25);
    // define("SHOWSKULL", true);

    // If you server has configured pages without .php sufix just remove it there:
    define("FILE_SUFIX", ".php");
?>