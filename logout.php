<?php
    include("core.php");
    start_session();
    validate_session();
    ses_close();


    header("Location: ".get_main_path());
    die();
?>