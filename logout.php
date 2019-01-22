<?php
    include("head.php");
    ses_start();
    validate_session();
    ses_close();

    header("Location: ".get_main_path());
    die();
?>