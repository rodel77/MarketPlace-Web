<!DOCTYPE html>
<?php 
    define("PAGE", "Main");
    include("head.php");
    include("src/db_manager.php");
    include("src/accounts.php");
    include("src/session_manager.php");
    ses_start();
    validate_session();
?>
<body>
    <?php include("nav.php") ?>
</body>
</html>