<?php
    function get_protocol(){
        $connection = db_connect();
        $sql = "select `value` from `".DB_TABLE_SYNCINFO."` where `key`='protocol'";
        $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $ps->execute();
        $result = $ps->fetchAll();

        return !empty($result) ? $result[0]["value"] : "(missing syncinfo table)";
    }
    
    function raw_purchase_tax(){
        if(!WEB_ACCOUNTS_ENABLED){
            return 0;
        }

        $connection = db_connect();
        $sql = "select `value` from `".DB_TABLE_SYNCINFO."` where `key`='tax'";
        $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $ps->execute();
        $result = $ps->fetchAll();

        return !empty($result) ? floatval($result[0]["value"])/100 : 0;
    }

    function purchase_tax($price){
        if(!WEB_ACCOUNTS_ENABLED){
            return 0;
        }

        $connection = db_connect();
        $sql = "select `value` from `".DB_TABLE_SYNCINFO."` where `key`='tax'";
        $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $ps->execute();
        $result = $ps->fetchAll();
    
        return !empty($result) ? $price*raw_purchase_tax() : 0;
    }

    function send_webhook($buyer, $item, $price, $seller){
        $connection = db_connect();
        $sql = "select * from `".DB_TABLE_SYNCINFO."`";
        $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $ps->execute();
        $result = $ps->fetchAll();

        $info = array();
        foreach($result as $row){
            $info[$row["key"]] = $row["value"];
        }

        $str = str_replace("{buyer}", $buyer, $info["webhook_purchase_description"]);
        $str = str_replace("{item}", $item, $str);
        $str = str_replace("{price}", $price, $str);
        $str = str_replace("{seller}", $seller, $str);

        if($info["webhook_enabled"] && $info["webhook_purchase_enabled"]){
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $info["webhook_url"]);
            curl_setopt($curl, CURLOPT_POST, TRUE);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-Type:application/json;"));
            $data = array(
                "username" => $info["webhook_botname"],
                "avatar_url" => $info["webhook_botavatar"],
                "embeds" => array(array(
                    "color" => $info["webhook_purchase_color"],
                    "fields" => array(array(
                        "name" => $info["webhook_purchase_title"],
                        "value" => $str,
                    )),
                )),
            );
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_exec($curl);
            curl_close($curl);
        }
    }
?>