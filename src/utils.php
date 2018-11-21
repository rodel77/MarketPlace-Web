<?php
    function get_main_path(){
        return CONTEXT=="main" ? "./" : "../";
    }

    function get_path($file){
        return "./".$file.FILE_SUFIX;
    }

    function random_token($length = 32){
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
        
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
        }

        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        }
    }
?>