<?php
    function start_session(){
        if(WEB_ACCOUNTS_ENABLED){
            session_start();
        }
    }

    function close_session(){
        if(WEB_ACCOUNTS_ENABLED){
            session_destroy();
            $_SESSION = array();
            if(ini_get("session.use_cookies")){
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]);
            }
        }
    }

    function validate_session(){
        if(WEB_ACCOUNTS_ENABLED){
            $GLOBALS["logged"] = false;
            if(isset($_SESSION["uuid"]) && isset($_SESSION["hash"])){
                $uuid = $_SESSION["uuid"];
                $hash = $_SESSION["hash"];
                
                $account = new Account($uuid);
                if($account->hash!=$hash){
                    session_close();
                }else{
                    $GLOBALS["logged"] = true;
                    $GLOBALS["account"] = $account;
                }
            }
        }
    }

    function login_user($account){
        if(WEB_ACCOUNTS_ENABLED){
            $_SESSION["uuid"] = $account->uuid;
            $_SESSION["hash"] = $account->hash;
        }
    }

    function set_token($token){
        if(WEB_ACCOUNTS_ENABLED){
            $_SESSION["token"] = $token;
            return $token;
        }
    }
?>