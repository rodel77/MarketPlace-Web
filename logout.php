<?php
    include("core.php");
    start_session();
    validate_session();
    close_session();


    header("Location: ".get_main_path());
    die();
?>
