
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MarketPlace Web</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <table class="table table-striped">
        <thead class="thead-dark">
            <th scope="col">Seller</th>
            <th scope="col">Name</th>
            <th scope="col">Details</th>
            <th scope="col">Amount</th>
            <th scope="col">Price</th>
            <th scope="col">Published</th>
        </thead>
        <tbody>
            <?php
                include("config.php");
                include("items.php");
                $tools = array("FISHING_ROD", "FLINT_AND_STEEL", "GOLD_AXE", "GOLD_BOOTS","GOLD_CHESTPLATE","GOLD_HELMET","GOLD_HOE","GOLD_LEGGINGS","GOLD_PICKAXE","GOLD_SPADE","GOLD_SWORD","IRON_AXE","IRON_BOOTS","IRON_CHESTPLATE","IRON_HELMET","IRON_HOE","IRON_LEGGINGS","IRON_PICKAXE","IRON_SPADE","IRON_SWORD","LEATHER_BOOTS","LEATHER_CHESTPLATE","LEATHER_HELMET","LEATHER_LEGGINGS","STONE_AXE","STONE_HOE","STONE_PICKAXE","STONE_SPADE","STONE_SWORD","WOOD_AXE","WOOD_HOE","WOOD_PICKAXE","WOOD_SPADE","WOOD_SWORD","BOW","CHAINMAIL_BOOTS","CHAINMAIL_CHESTPLATE","CHAINMAIL_HELMET","CHAINMAIL_LEGGINGS","DIAMOND_AXE","DIAMOND_BOOTS","DIAMOND_CHESTPLATE","DIAMOND_HELMET","DIAMOND_HOE","DIAMOND_LEGGINGS","DIAMOND_PICKAXE","DIAMOND_SPADE","DIAMOND_SWORD","SHEARS","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0","0");
                $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
                $page = isset($_GET["page"]) ? $_GET["page"] : 1;
                
                // Only ints
                if(is_numeric($page)){
                    $page = intval($page);
                }else{
                    $page = 1;
                }

                $page = max(1, $page);
                mysqli_set_charset($connection,'utf8');
                $query = "select * from ".DB_TABLE_CATALOG." where `buyer` is null order by `publish_date` desc limit ". (($page - 1) * ITEMS_PER_PAGE) .",". ITEMS_PER_PAGE;

                
                $result = $connection->query($query);

                while(true){
                    $entry = $result->fetch_array();

                    if($entry==null){
                        break;
                    }
                    $nbt = $entry["item_nbt"];
                    $name = getname($entry["item_nbt"])[0];
                    $lore = getlore($entry["item_nbt"]);
                    $durability = $entry["item_durability"];
                    $type = $entry["item_type"];
                    
                    foreach ($lore as $line){
                        $res = filtercolorcodes($line);
                        $loreparsed = $loreparsed . htmlspecialchars($res, ENT_QUOTES, "UTF-8") . "</br>";

                    }
                  
                    if (strlen($loreparsed) > (int)MAX_LORE_LENGTH){
                        $loreparsed = substr($loreparsed, 0,(int)MAX_LORE_LENGTH);
                        $loreparsed = $loreparsed."...";
                    }
                  
                    if ($durability > 0 && in_array($type,$tools)){
                        $loreparsed = $loreparsed."</br> Damaged: ".$durability;
                    }
                        
                    
                    if (empty($name)){
                        $name = str_replace("_"," ",strtolower ($type)); 
                    }
                    if (strlen($name) > (int) MAX_NAME_LENGTH){
                        $name = substr($name, 0,(int)MAX_NAME_LENGTH);
                        $name = $name."...";
                    }
                    $name = htmlspecialchars($name, ENT_QUOTES, "UTF-8");

                    $amount = $entry["item_amount"];
                   
                    $price = $entry["price"];

                    if ($amount > 1){
                       $peritem = ($price / $amount);
                       $price = $price." ($".$peritem." Per Item)";
                    }
                   
                    echo "<tr>";
                    echo "<th><img class='head-image' data-player='". $entry["seller"] ."' data-name='". $entry["seller_name"] ."' src='img/loader.svg'><span class='name'></span></img></th>";
                    echo "<th><img class='item-image' data-item='". $type ."' data-amount='". $amount ."' data-durability='". $durability ."' data-nbt='". $nbt ."' src='img/loader.svg'></img>".$name."</th>";
                    if (count($lore) < 2){
                    echo "<th>Base Item</th>";
                    }else {
                        echo "<th>".$loreparsed."</th>";
                        
                    }
                    echo "<th>".$amount."</th>";
                    echo "<th>$". $price ."</th>";
                    echo "<th class='date-moment'>". $entry["publish_date"] ."</th>";
                    echo "</tr>";
                }

            ?>
        </tbody>
    </table>

    <div class="container">
        <div class="row">
            <div class="col-4 offset-4 offset-md-5">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group mr-2" role="group">
                        <a role="button" class="btn btn-dark text-white <?php if($page-1<1) {echo "disabled";} ?>" href="?page=<?php echo $page-1<1 ? $page : $page-1 ?>"><?php echo "<"; ?></a>
                        <a role="button" class="btn btn-primary text-white"><?php echo $page; ?></a>
                        <a role="button" class="btn btn-dark text-white <?php if($result->num_rows<ITEMS_PER_PAGE) {echo "disabled";} ?>" href="?page=<?php echo $page+1 ?>"><?php echo ">"; ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Localization -->
    <script src=""></script>
    <!-- Localization -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>
    <script src="js/items.js?v=1"></script>
    <script src="js/main.js"></script>
</body>
</html>