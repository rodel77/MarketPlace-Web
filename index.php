
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
            <th scope="col"><form class="form-inline" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            
            <label class="col-md-4 control-label" for="filteroptions">Filters</label>
              <select value='<? echo $_GET["filteroptions"]; ?>' id="filteroptions" name="filteroptions" class="form-control form-control-sm">
              <option value="0">None</option>
              <option value="1">Damaged Items</option>
              <option value="2">Tools and Weapons</option>
              <option value="3">Price Below Target</option>
              <option value="4">Price Above Target</option>
              <option value="5">Single Item</option>
              <option value="6">0-16 Items</option>
              <option value="7">16-32 Items</option>
              <option value="8">32-48 Items</option>
              <option value="9">48-64 Items</option>
              <option value="10">Full Stacks</option>
            </select> ~ 
            
            
              <input id="pricetarget" name="pricetarget" value='<? echo $_GET["pricetarget"]; ?>' placeholder="0.00" class="form-control form-control-sm" type="text"> ~ 
                
                
                  
              <button type="submit" class="btn btn-primary">Apply</button>
           
              </form>
              </th>
        </thead>
        <tbody>
            <?php
                include("config.php");
                include("items.php");
                if (isset($_GET['filteroptions'])){
                $filter = $_GET['filteroptions'];
                $thp = 0;
                   }else {
                $filter = 0;
                $thp = 0;
                   }
                $tools = array("CARROT_STICK#26","FISHING_ROD#65", "FLINT_AND_STEEL#65", "GOLD_AXE#33", "GOLD_BOOTS#92","GOLD_CHESTPLATE#113","GOLD_HELMET#78","GOLD_HOE#33","GOLD_LEGGINGS#106","GOLD_PICKAXE#33","GOLD_SPADE#33","GOLD_SWORD#33","IRON_AXE#251","IRON_BOOTS#196","IRON_CHESTPLATE#241","IRON_HELMET#166","IRON_HOE#251","IRON_LEGGINGS#226","IRON_PICKAXE#251","IRON_SPADE#251","IRON_SWORD#251","LEATHER_BOOTS#66","LEATHER_CHESTPLATE#81","LEATHER_HELMET#56","LEATHER_LEGGINGS#76","STONE_AXE#132","STONE_HOE#132","STONE_PICKAXE#132","STONE_SPADE#132","STONE_SWORD#132","WOOD_AXE#60","WOOD_HOE#60","WOOD_PICKAXE#60","WOOD_SPADE#60","WOOD_SWORD#60","BOW#385","CHAINMAIL_BOOTS#196","CHAINMAIL_CHESTPLATE#241","CHAINMAIL_HELMET#166","CHAINMAIL_LEGGINGS#226","DIAMOND_AXE#1562","DIAMOND_BOOTS#430","DIAMOND_CHESTPLATE#529","DIAMOND_HELMET#364","DIAMOND_HOE#1562","DIAMOND_LEGGINGS#496","DIAMOND_PICKAXE#1562","DIAMOND_SPADE#1562","DIAMOND_SWORD#1562","SHEARS#239");
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
                    $thp = 0;
                    $entry = $result->fetch_array();

                    if($entry==null){
                        break;
                    }

                    $nbt = $entry["item_nbt"];
                    $name = getname($nbt);
                    $lore = getlore($nbt);
                    $durability = $entry["item_durability"];
                    $type = $entry["item_type"];
                    $isTool = isTool($tools, $type);
                    
                    // Strip & parse lore
                    $loreparsed = "";

                    foreach ($lore as $line){
                        $res = filtercolorcodes($line);
                        $loreparsed = $loreparsed . htmlspecialchars($res) . "</br>";
                    }
                  
                    if (strlen($loreparsed) > (int)MAX_LORE_LENGTH){
                        $loreparsed = substr($loreparsed, 0,(int)MAX_LORE_LENGTH);
                        $loreparsed = $loreparsed."...";
                    }
                    
                    // Durability
                    if ($durability > 0 && $isTool){
                        $loreparsed = $loreparsed."Damaged: ".$durability;
                        if ($filter == 1){
                            $tooldurability = getMaxdurability($tools,$type);
                            $low = ($tooldurability / 100 * LOW_DURABILITY);
                            $mid = ($tooldurability / 100 * MID_DURABILITY);
                            $high = ($tooldurability / 100 * GOOD_DURABILITY);
                            $damage = ($tooldurability - $durability);
                            
                            if ($damage < $low){
                                echo '<tr class="table-danger">';
                                $thp = 1;
                            }elseif ($damage < $mid){
                                 echo '<tr class="table-warning">';
                                 $thp = 1;
                            }else {
                                echo '<tr class="table-success">';
                                $thp = 1;
                            }
                        }elseif ($filter == 2){
                            echo '<tr class="table-info">';
                            $thp = 1;
                        }
                    }

                    if (strlen($name) > (int) MAX_NAME_LENGTH){
                        $name = substr($name, 0,(int)MAX_NAME_LENGTH);
                        $name = $name."...";
                    }
                  
                    $name = htmlspecialchars($name, ENT_QUOTES, "UTF-8");

                    $amount = $entry["item_amount"];

                    if ($filter == 5 && $amount == 1){
                        echo '<tr class="table-success">';
                        $thp = 1;
                    }
                    if ($filter == 6 && $amount < 17){
                        echo '<tr class="table-success">';
                        $thp = 1;
                    }
                    if ($filter == 7 && $amount < 33 && $amount > 15){
                        echo'<tr class="table-success">';
                        $thp = 1;
                    }

                    if ($filter == 8 && $amount < 49 && $amount > 31){
                        echo'<tr class="table-success">';
                        $thp = 1;
                    }

                    if ($filter == 9 && $amount < 65 && $amount > 47){
                        echo '<tr class="table-success">';
                        $thp = 1;
                    }

                    if ($filter == 10 && $amount == 64){
                        echo '<tr class="table-success">';
                        $thp = 1;
                    }
                   
                    $price = $entry["price"];
                    if ($filter == 3 && isset($_GET['pricetarget'])){
                        $target = $_GET['pricetarget'];
                        if ($price < $target){
                            echo'<tr class="table-success">';
                            $thp = 1;
                        }else {
                            echo'<tr>';
                            $thp = 1;
                        }
                    }

                    if ($filter == 4 && isset($_GET['pricetarget'])){
                        $target = $_GET['pricetarget'];
                        if ($price > $target){
                            echo'<tr class="table-success">';
                            $thp = 1;
                        }else {
                            echo '<tr>';
                            $thp = 1;
                        }
                    }
                
                    if ($amount > 1){
                        $peritem = ($price / $amount);
                        $price = $price." ($".$peritem." Per Item)";
                    }
        
                    if ($thp == 0){
                            echo '<tr>';
                            $thp = 1;
                    }
                    

                    echo "<th><img class='head-image' data-player='". $entry["seller"] ."' data-name='". $entry["seller_name"] ."' src='img/loader.svg'><span class='name'></span></img></th>";
                    echo "<th><img class='item-image' data-tool='".($isTool ? "true" : "false")."' data-item='". $type ."' data-name='". $name ."' data-amount='". $amount ."' data-durability='". $durability ."' data-nbt='". $nbt ."' src='img/loader.svg'></img><span class='name ".(empty($name) ? "" : "done")."'>".(empty($name) ? "" : $name)."</span></th>";


                    if(empty($loreparsed)){
                        echo "<th>Base Item</th>";
                    }else {
                        echo "<th>".$loreparsed."</th>";
                    }

                    echo "<th>".$amount."</th>";
                    echo "<th>$". $price ."</th>";
                    echo "<th class='date-moment'>". $entry["publish_date"] ."</th>";
                    echo "<th></th>";
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