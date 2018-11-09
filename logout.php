<?php
    include("config.php");
    include("src/db_manager.php");
    include("src/accounts.php");
    include("src/session_manager.php");

    ses_start();
    validate_session();
    ses_close();

    header("Location: ../");
    die();
?>