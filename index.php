<!DOCTYPE html>
<?php 
    define("PAGE", "Main");
    define("CONTEXT", "main");
    include("core.php");
    ses_start();
    validate_session();

    $current_page = 1;
    if(isset($_GET["page"])){
        $current_page = max(abs(floatval($_GET["page"])), 1);
    }

    include("head.php");
?>
<body>
    <?php include("src/tooltip.php"); ?>
    <script src="items/bukkit2icon.js"></script>
    <script src="js/index.js"></script>

    <?php include("nav.php"); ?>

    <div class="container-fluid" style="height:100vh;">
        <div class="col col-12">
            <div class="inventory">
                
                <div class="title">Latest Items</div>

                <?php
                    fetch_main($current_page);
                ?>

                <div class="page-slider mt-3">
                    <a href="?page=<?php echo max($current_page-1, 1); ?>"><i class="fas fa-arrow-left"></i></a>
                    <span class="minefont"><?php echo $current_page; ?></span>
                    <a href="?page=<?php echo $current_page+1; ?>"><i class="fas fa-arrow-right"></i></a>
                </div>
        </div>
    </div>
</body>
</html>