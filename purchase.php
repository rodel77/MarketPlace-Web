<!DOCTYPE html>
<?php 
    define("PAGE", "Listing Details");
    define("CONTEXT", "listing");
    include("head.php");
    ses_start();
    validate_session();
?>
<body>
    <div id="minetip-tooltip" style="display:none;">
        <span class="name"></span><br>
        <span class="lore"></span>
    </div>
    <script src="items/bukkit2icon.js"></script>
    <script src="js/index.js"></script>

    <div class="container" style="height:100vh;">
    <div class="row align-items-center justify-content-center" style="height:100vh;">
        <div class="col col-12 col-lg-9 col-xl-6">
            <div class="card bg-inventory text-light">
                <div class="card-body">
                    <?php
                        if(!isset($_POST["id"])) {
                            echo '<div class="alert alert-danger mt-4 color-c minefont" role="alert">Invalid listing!</div>';
                            die(); 
                        }
                        
                        if(!is_numeric($_POST["id"])){
                            echo '<div class="alert alert-danger mt-4 color-c minefont" role="alert">Listing id must be number</div>';
                            die();
                        }

                        if(!$GLOBALS["logged"]) {
                            echo '<div class="alert alert-danger mt-4 color-c minefont" role="alert">Sorry but you are not logged!</div>';
                            die(); 
                        }

                        if(!isset($_POST["token"]) || !isset($_SESSION["token"]) || $_POST["token"]!=$_SESSION["token"]) {
                            echo '<div class="alert alert-danger mt-4 color-c minefont" role="alert">Invalid token, please try again</div>';
                            die(); 
                        }
                        
                        unset($_SESSION["token"]);
                        
                        $listing = fetch_item($_POST["id"]);
                        
                        if($listing==NULL){
                            echo '<div class="alert alert-danger mt-4 color-c minefont" role="alert">Invalid item, please try with another listing</div>';
                            die(); 
                        }
                        
                        if($listing["seller"]==$GLOBALS["account"]->uuid){
                            echo '<div class="alert alert-danger mt-4 color-c minefont" role="alert">You are the seller of this item</div>';
                            die();
                        }
                        
                        if($GLOBALS["account"]->money<$listing["price"]){
                            echo '<div class="alert alert-danger mt-4 color-c minefont" role="alert">You don\'t have money to acquire this item</div>';
                            die();
                        }
                        
                        if(!purchase_item($GLOBALS["account"]->uuid, $GLOBALS["account"]->name, $_POST["id"])){
                            echo '<div class="alert alert-danger mt-4 color-c minefont" role="alert">Error while purchasing the listing, please try later</div>';
                            die(); 
                        }
                    ?>

                    <h3 class="card-title color-f minefont">Order Completed!</h3>
                    <span class="color-f minefont">Now you can claim your item ingame</span>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>