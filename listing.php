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

    <?php include("nav.php") ?>

    <div class="container" style="height:100vh;">
        <div class="col col-12">
            <div class="listing">
            <?php
                if(isset($_GET["id"])){
                    $listing = find_item_by_id($_GET["id"]);
                    
                    if(count($listing)==0){
                        header("Location: ".get_main_path());
                    }else{
                        $listing = $listing[0];
                        if(getname($listing["item_nbt"])==""){ ?>
                            <span class="title bukkit2name color-f"><?php echo $listing["item_type"]; ?></span>
                        <?php }else{ ?>
                            <span class="title colorize"><?php echo htmlspecialchars(getname($listing["item_nbt"])); ?></span>
                        <?php } ?>
                    <?php } ?>
            <?php 
                }else{
                    header("Location: ".get_main_main());
                } ?>

                        <hr style="border-top-width:2px;">

                        <div class="container">
                            <div class="row align-items-center details">
                                <div class="col col-4 col-lg-3">
                                    <?php
                                        echo get_item($listing);

                                        $buy_tax = raw_purchase_tax();
                                        $total_price = $listing["price"] + $buy_tax*$listing["price"];
                                    ?>
                                </div>
                                <div class="col col-8 col-lg-9 lore">
                                </div>
                            </div>
                        </div>

                        <hr style="border-top-width:2px;">

                        <div class="listing-info">
                            <span class="color-f minefont">Seller: <a href="<?php echo get_path("profile"); ?>?user=<?php echo $listing["seller"]; ?>" class="color-6 color-n"><?php echo $listing["seller_name"]; ?></a></span></span>
                            <span class="color-f minefont">Published: <span class="date-moment color-6"><?php echo $listing["publish_date"]; ?></span></span>
                            <span class="color-f minefont">Price: <span class="color-6"><?php echo price_format($listing["price"]); ?></span></span>
                            <?php if($buy_tax) { ?>
                                <span class="color-f minefont">Tax: <span class="color-6"><?php echo price_format(purchase_tax($listing["price"])); ?></span></span>
                                <span class="color-a minefont">Total: <span class="color-6"><?php echo price_format($total_price); ?></span></span>
                            <?php } ?>
                            
                            <?php 
                            // @Warning: Horrible identation...
                            if(WEB_ACCOUNTS_ENABLED && $GLOBALS["logged"]) {
                                if(!item_available($listing)){ ?>
                                    <div class="alert alert-danger mt-4 color-c minefont" role="alert">So but this listing is no longer available!</div>
                            <?php 
                                }else{ 
                                    $can_acquire = floatval($GLOBALS["account"]->money)>=$total_price;
                                    ?>

                            <form action=<?php echo get_path("purchase"); ?> method="POST">
                                <input type="hidden" name="id" value="<?php echo $listing["id"]; ?>">
                                <input type="hidden" name="token" value="<?php echo set_token(random_token()); ?>">
                                <?php if($GLOBALS["logged"]) {
                                        if($listing["seller"]!=$GLOBALS["account"]->uuid) {
                                            if($can_acquire){?>
                                            <button type="submit" class="btn btn-success color-f minefont order-button">Order</button>
                                        <?php }else { ?>
                                            <div class="alert alert-danger mt-4 color-c minefont" role="alert">You don't have money to acquire this item</div>
                                        <?php } ?>
                                    <?php } else { ?>
                                            <button type="submit" class="btn btn-danger color-f minefont order-button" disabled>Cancel (WIP)</button>
                                    <?php } ?>
                                <?php } ?>
                            </form>
                            <?php } ?>
                        <?php } ?>

                        </div>
        </div>
    </div>
</body>
</html>