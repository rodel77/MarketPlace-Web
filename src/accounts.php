<?php
    class Account {
        public $uuid;
        public $name;
        public $money;
        public $deliveries;
        public $password;
        public $salt;
        public $hash;
        public $permission;

        function __construct($selector){
            try {
                $connection = db_connect();

                $sql = "select * from `".DB_TABLE_ACCOUNTS."` where `name` = :name or `uuid` = :uuid";
                $ps = $connection->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
                $ps->execute(array(":name" => $selector, ":uuid" => $selector));
                $result = $ps->fetchAll();

                if(count($result)>0){
                    $user = $result[0];

                    $this->uuid       = $user["uuid"];
                    $this->name       = $user["name"];
                    $this->money      = $user["money"];
                    $this->deliveries = $user["deliveries"];
                    $this->password   = $user["password"];
                    $this->permission = $user["permission"];

                    $temp_pwd = array_chunk(unpack("C*", $this->password), 32);
                    $this->salt = $temp_pwd[0];
                    $this->hash = bin2hex(substr($this->password, 32, 32));
                }
            } catch (PDOException $e){
                print "An internal database!";
                die();
            }
        }

        function compare_password($password){
            $pwd = unpack("C*", $password);
            $phash = array();
            array_push($phash, ...$this->salt, ...$pwd);
            
            return hash("sha256", implode(array_map("chr", $phash)))==$this->hash;
        }
    }
?>