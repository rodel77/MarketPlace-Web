<?php 
    define("PAGE", "Profile");
    define("CONTEXT", "profile");

    include("core.php");
    start_session();
    validate_session();


    $selfaccount = false;

    if(isset($_GET["user"])){
        $userp = $_GET["user"];

        $webaccount = new Account($userp);

        // If not account, then find a listing where this user appears either buyer or seller
        if(empty($webaccount->uuid)){
            $found_listing = find_listing_user($userp);
            $u_uuid = $found_listing[0];
            $u_name = $found_listing[1];
        }
    }elseif(!$GLOBALS["logged"]){
        // @Warning: Not Tested,
        // this type of routes cause problems
        // if the web is on a parent folder
        header("Location: ".get_main_path());
        exit();
    }else{
        $webaccount = $GLOBALS["account"];
        $selfaccount = true;
    }
    
    if(!empty($webaccount->uuid)){
        $u_uuid = $webaccount->uuid;
        $u_name = $webaccount->name;
    }
    include("head.php");
?>
<!DOCTYPE html>
<body>
    <?php include("nav.php") ?>
    <div id="minetip-tooltip" style="display:none;">
        <span class="name"></span><br>
        <span class="lore"></span><br>
        <span class="color-7">Total Price: <span class="color-6 price"></span></span>
    </div>
    <script src="items/bukkit2icon.js"></script>
    <script src="js/index.js"></script>

<div class="container my-5">
    <div class="row align-items-center justify-content-center">
        <div class="col col-10">
            <div class="card bg-inventory text-light">
                <div class="card-body">
                    <?php if(empty($u_uuid)) { ?>
                        <h2 class="text-center color-f minefont">User not found</h2>
                        <h4 class="text-center color-6 minefont">This user haven't used the market or created an account</h4>
                    <?php } else { ?>

                    <h3 class="card-title color-a minefont"><img src="https://cravatar.eu/avatar/<?php echo $u_uuid; ?>/32.png"> <?php echo $u_name; ?></h3>
                    <hr>

                    <!-- @Warning: Add the listings of the player there... -->

                    <?php if(WEB_ACCOUNTS_ENABLED){ ?>
                        <?php if($selfaccount && $pending_claims>0){ ?>
                        <div class="alert alert-success color-a minefont" role="alert">You have <?php echo $pending_claims; ?> items pending to claim ingame</div>
                        <?php } ?>

                        <h5 class="color-6 minefont">Web Account: <?php if($webaccount->uuid){ ?> <span class="color-a minefont">✔</span> <?php }else{ ?> <span class="color-4 minefont">✖</span> <?php } ?></h5>
                        <?php if($webaccount->uuid){ ?>
                        <h5 class="color-6 minefont">Wallet: <span class="color-a minefont"><?php echo $webaccount->money; ?></span></h5>
                        <?php } ?>
                        <hr>
                    <?php } ?>


                    <h5 class="color-6 minefont">Items on sale: <span class="color-a minefont"> <?php echo items_on_sale($u_uuid); ?></span></h5>
                    <h5 class="color-6 minefont">Items sold: <span class="color-a minefont"> <?php echo items_sold($u_uuid); ?></span></h5>
                    <h5 class="color-6 minefont">Items purchased: <span class="color-a minefont"> <?php echo items_purchased($u_uuid); ?></span></h5>
                    <?php } ?>

                    <?php fetch_profile($u_uuid); ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>