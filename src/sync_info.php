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
?>