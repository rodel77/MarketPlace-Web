<?php
    include("head.php");
    ses_start();
    validate_session();
    ses_close();

    header("Location: ../");
    die();
?>