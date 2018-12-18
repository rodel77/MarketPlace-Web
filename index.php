<!DOCTYPE html>
<?php 
    define("PAGE", "Main");
    define("CONTEXT", "main");
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

    <div class="container-fluid" style="height:100vh;">
        <div class="col col-12">
            <div class="inventory">
                
                <div class="title">Latest Items</div>

                <?php
                    fetch_main();
                ?>
        </div>
    </div>
</body>
</html>