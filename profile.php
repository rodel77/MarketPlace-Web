<!DOCTYPE html>
<?php 
    define("PAGE", "Dashboard");
    include("head.php");
    include("src/db_manager.php");
    include("src/accounts.php");
    include("src/listings.php");
    include("src/session_manager.php");
    ses_start();
    validate_session();
    if(!$GLOBALS["logged"]){
        header("Location: ../");
        exit();
    }
?>
<body>
    <?php include("nav.php") ?>

<div class="container my-5">
    <div class="row align-items-center justify-content-center">
        <div class="col col-10">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <h3 class="card-title"><img src="https://cravatar.eu/avatar/<?php echo $GLOBALS["account"]->uuid; ?>/32.png"> Profile - <?php echo $GLOBALS["account"]->name; ?></h3>
                    <hr>
                    <b>Wallet:</b> <?php echo $GLOBALS["account"]->money; ?>

                    <br>
                    <?php
                        $text = "Hey ñ &c&lred&3 &iyou!&";

                        echo $text."<br>";
                        echo parse_color($text);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>