<?php
    // Instructions:
    // This is the default configuration, you should create a "config.php" file
    // and then put all the nodes you want to configure over there
    // (Example: If you only need to change user and password, then just copy those values)
    // any undefined config in your "config.php" file will fallback here,
    // is not recommended edit this file since the git pull update method will
    // cause problems.

    return array(
        // This configuration should be the same as the one on the MarketPlace plugin
        "DB_HOST"           => "localhost",
        "DB_USER"           => "user",
        "DB_PASSWORD"       => "123",
        "DB_DATABASE"       => "marketplace",
        "DB_TABLE_CATALOG"  => "catalog",
        "DB_TABLE_ACCOUNTS" => "webaccounts", // If you don't enable "WEB_ACCOUNTS_ENABLED" you don't need to worry about this

        // If you server has configured pages without .php sufix just remove it there:
        "FILE_SUFIX"        => ".php",

        "WEB_ACCOUNTS_ENABLED" => false, // true = Enabled, false = Disabled
    );
?>