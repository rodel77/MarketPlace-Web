<?php
    include("head.php");
    close_session();

    header("Location: ".get_main_path());
    die();
?>