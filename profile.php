<!DOCTYPE html>
<?php 
    define("PAGE", "Profile");
    define("CONTEXT", "profile");
    include("head.php");
    ses_start();
    validate_session();

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
        header("Location: ../");
        exit();
    }else{
        $webaccount = $GLOBALS["account"];
        $selfaccount = true;
    }
    
    if(!empty($webaccount->uuid)){
        $u_uuid = $webaccount->uuid;
        $u_name = $webaccount->name;
    }


?>
<body>
    <?php include("nav.php") ?>

<div class="container my-5">
    <div class="row align-items-center justify-content-center">
        <div class="col col-10">
            <div class="card bg-dark text-light">
                <div class="card-body">
                    <?php if(empty($u_uuid)) { ?>
                        <h2 class="text-center">User not found</h2>
                        <h4 class="text-center text-white-50">This user haven't used the market or created an account</h4>
                    <?php } else { ?>

                    <h3 class="card-title"><img src="https://cravatar.eu/avatar/<?php echo $u_uuid; ?>/32.png"> <?php echo $u_name; ?></h3>
                    <hr>

                    <?php if($selfaccount && $pending_claims>0){ ?>
                    <div class="alert alert-success" role="alert">You have <?php echo $pending_claims; ?> items pending to claim ingame</div>
                    <?php } ?>

                    <h5>Web Account: <?php if($webaccount->uuid){ ?> <i class="fas fa-check text-success"></i> <?php }else{ ?> <i class="fas fa-times text-danger"></i> <?php } ?></h5>
                    <?php if($webaccount->uuid){ ?>
                    <h5>Wallet: <?php echo $webaccount->money; ?></h5>
                    <?php } ?>

                    <hr>

                    <h5>Items on sale: <?php echo items_on_sale($u_uuid); ?></h5>
                    <h5>Items sold: <?php echo items_sold($u_uuid); ?></h5>
                    <h5>Items purchased: <?php echo items_purchased($u_uuid); ?></h5>

                    <hr>

                    <b>Wallet:</b> <?php echo $GLOBALS["profile"]->money; ?>

                    <br>

                    
                    <?php
                        $connection = db_connect();
                        $sql = "select count(*) from `".DB_TABLE_CATALOG."` where `seller` = :uuid";
                        $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                        $ps->execute(array(":uuid"=>$GLOBALS["profile"]->uuid));
                        $result = $ps->fetchAll();
                        print_r(var_dump($result));
                    
                        // $text = "Hey ñ &c&lred&3 &iyou!&";

                        // echo $text."<br>";
                        // echo parse_color($text);
                    ?>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>