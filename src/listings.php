<?php
    function parse_color($text){
        $final_html = "";
        $skip = false;

        $special = "";

        for ($i = 0; $i < strlen($text); $i++){
            $char = $text[$i];

            if($char=="&" && $i<strlen($text)-1){
                $code = strtolower($text[$i+1]);

                if(preg_match("/[a-f,k-r,0-9]/", $code)){

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
        echo "<br>";
        return $final_html;
    }
?>