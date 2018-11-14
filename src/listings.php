<?php
    // Find user UUID, even if the selector is an UUID,
    // it will help to know if the user exists at all
    function find_listing_user($selector){
        $connection = db_connect();
        $sql = "select `seller`, `seller_name` from `".DB_TABLE_CATALOG."` where `seller` = :selector or `seller_name` like :selector limit 1";
        $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $ps->execute(array(":selector"=>$selector));
        $result = $ps->fetchAll();
        
        if(count($result)>0){
            return array($result[0][0], $result[0][1]);
        }
        
        $sql = "select `buyer`, `buyer_name` from `".DB_TABLE_CATALOG."` where `buyer` = :selector or `buyer_name` like :selector limit 1";
        $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $ps->execute(array(":selector"=>$selector));
        $result = $ps->fetchAll();
        
        if(count($result)>0){
            return array($result[0][0], $result[0][1]);
        }

        return null;
    }

    function items_on_sale($uuid){
        $connection = db_connect();
        $sql = "select count(*) from `".DB_TABLE_CATALOG."` where `seller` = :uuid and `buyer` is null and `cancelled`=0 and (`expire_time`>NOW() or `expire_time` is null)";
        $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $ps->execute(array(":uuid"=>$uuid));
        $result = $ps->fetchAll();
        return count($result)>0 ? $result[0][0] : 0;
    }

    function items_sold($uuid){
        $connection = db_connect();
        $sql = "select count(*) from `".DB_TABLE_CATALOG."` where `seller` = :uuid and `buyer` is not null";
        $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $ps->execute(array(":uuid"=>$uuid));
        $result = $ps->fetchAll();
        return count($result)>0 ? $result[0][0] : 0;
    }

    function items_purchased($uuid){
        $connection = db_connect();
        $sql = "select count(*) from `".DB_TABLE_CATALOG."` where `buyer` = :uuid";
        $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $ps->execute(array(":uuid"=>$uuid));
        $result = $ps->fetchAll();
        return count($result)>0 ? $result[0][0] : 0;
    }

    function pending_to_claim(){
        if($GLOBALS["logged"]){
            $connection = db_connect();
            $sql = "select count(*) from `".DB_TABLE_CATALOG."` where `seller` = :uuid and `buyer` is not null and `claimed`=0";
            $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $ps->execute(array(":uuid"=>$GLOBALS["account"]->uuid));
            $result = $ps->fetchAll();
            return count($result)>0 ? $result[0][0] : 0;
        }

        return 0;
    }

    function fetch_main(){
        $connection = db_connect();
        $sql = "select * from `".DB_TABLE_CATALOG."` where `buyer` is null and `cancelled`=0 and (`expire_time`>NOW() or `expire_time` is null) order by `publish_date` DESC limit 20";
        $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $ps->execute();
        $result = $ps->fetchAll();

        foreach ($result as $key => $value) {
            $name = htmlspecialchars(getname($value["item_nbt"]));
            $lore = getlore($value["item_nbt"]);
            $lore_count = count($lore);
            $lore_data = array();
            $head = ConvertTextureData($value["item_nbt"]);

            foreach($lore as $idx=>$line){
                array_push($lore_data, 'data-lore-'.$idx.'="'.htmlspecialchars($line).'"');
            }

            echo '<span class="invslot" onmouseenter="showTooltip(event)" onmouseleave="hideTooltip(event)" onmousemove="handleTooltip(event)" onload="item_loaded"><span class="invslot-item"><span class="inv-sprite" data-bukkit="'.$value["item_type"].'" data-id="'.$value["id"].'" data-durability="'.$value["item_durability"].'" data-amount="'.$value["item_amount"].'" data-head="'.$head.'" data-name="'.$name.'" data-lore="'.$lore_count.'" '.implode(" ", $lore_data).'"><br></span></span></span>';
        }
    }

    function parse_color($text){
        $final_html = "";
        $skip = false;

        $special = "";
        $color = "";

        for ($i = 0; $i < strlen($text); $i++){
            $char = $text[$i];

            if($char=="@" && $i<strlen($text)-1){
                $code = strtolower($text[$i+1]);
                
                if(preg_match("/[a-f,k-r,0-9]/", $code)){
                    if(preg_match("/[a-f,0-9]/", $code)){
                        $final_html = "<span class='color-$code'>";
                    }

                    if($code=="l"){
                        if(!empty($special)){
                            $final_html .= "</b>";
                        }
                        $final_html .= "<b>";
                        $special = "bold";
                    }

                    $skip = true;
                    continue;
                }
            }

            if($skip){
                $skip = false;
                continue;
            }

            // echo $char;
            $final_html .= $char;
        }
        return $final_html;
    }
?>