<?php
    function ses_start(){
        session_start();
    }

    function ses_close(){
        session_destroy();
        $_SESSION = array();
        if(ini_get("session.use_cookies")){
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]);
        }
    }

    function validate_session(){
        $GLOBALS["logged"] = false;
        if(isset($_SESSION["uuid"]) && isset($_SESSION["hash"])){
            $uuid = $_SESSION["uuid"];
            $hash = $_SESSION["hash"];
            
            $account = new Account($uuid);
            if($account->hash!=$hash){
                ses_close();
            }else{
                $GLOBALS["logged"] = true;
                $GLOBALS["account"] = $account;
            }
        }
    }

    function login_user($account){
        $_SESSION["uuid"] = $account->uuid;
        $_SESSION["hash"] = $account->hash;
    }
?>