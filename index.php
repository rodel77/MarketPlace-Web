
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MarketPlace Web</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <table class="table">
        <thead>
            <th scope="col">Seller</th>
            <th scope="col">Item</th>
            <th scope="col">Price</th>
            <th scope="col">Published</th>
        </thead>
        <tbody>
            <?php
                include("config.php");
                include("items.php");
                
                $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
                $page = isset($_GET["page"]) ? $_GET["page"] : 1;
                
                // Only ints
                if(is_numeric($page)){
                    $page = intval($page);
                }else{
                    $page = 1;
                }

                $page = max(1, $page);

                $query = "select * from ".DB_TABLE_CATALOG." where `buyer` is null order by `publish_date` desc limit ". (($page - 1) * ITEMS_PER_PAGE) .",". ITEMS_PER_PAGE;

                
                $result = $connection->query($query);

                while(true){
                    $entry = $result->fetch_array();

                    if($entry==null){
                        break;
                    }

                    echo "<tr>";
                    echo "<th><img class='head-image' data-player='". $entry["seller"] ."' data-name='". $entry["seller_name"] ."' src='img/loader.svg'><span class='name'></span></img></th>";
                    echo "<th><img class='item-image' data-item='". $entry["item_type"] ."' data-amount='". $entry["item_amount"] ."' data-durability='". $entry["item_durability"] ."' data-nbt='". $entry["item_nbt"] ."' src='img/loader.svg'><span class='name'></span></img></th>";
                    echo "<th>$". $entry["price"] ."</th>";
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