<?php
    // MCGSoft Addition New Parsing NBT
    function getlore($nbt){
        preg_match("(({Lore:)\[(.*?)\])",$nbt,$firstmatch,PREG_OFFSET_CAPTURE);

        if(sizeof($firstmatch)>2){
            preg_match_all('("(.*?)")',$firstmatch[2][0],$secondmatch);
            return $secondmatch[1];
        }
    
        return array();
    }

    function getname($nbt){
        preg_match('({Name:"(.*?)")',$nbt,$name,PREG_OFFSET_CAPTURE);
        if (empty($name)){
            preg_match('(Name:"(.*?)")',$nbt,$name,PREG_OFFSET_CAPTURE);
        }
        return sizeof($name)<2 ? "" : $name[1][0];
    }

    function stripColors($nbt){
        return  preg_replace("(§[a-z,0-9])","",$nbt);
    }

    function getMaxdurability($tools,$material) {
        foreach ($tools as $tool){
            $exp = explode('#',$tool);
            if ($material == $exp[0]){
                return $exp[1];
            }
        }
        return 0;
    }
    
    function isTool($tools, $material) {
        foreach ($tools as $tool){
            $toolID = explode('#', $tool);
            if ($material == $toolID[0]){
                return true;
            }
        }

        return false;
    }

    // MCGSoft Addition New SkullBuilder from NBT
    function ConvertTextureData($nbt){
        preg_match('(Value:"(.*?)")',$nbt,$texturedata,PREG_OFFSET_CAPTURE);

        if(sizeof($texturedata)<2){
            return "";
        }

        $decoded = base64_decode($texturedata[1][0]);
        preg_match('(url":"(.*?)")',$decoded,$textureurl,PREG_OFFSET_CAPTURE);

        if (empty($textureurl)){
            $decoded = base64_decode($texturedata[1][0]);
            preg_match('(url:"(.*?)")',$decoded,$textureurl,PREG_OFFSET_CAPTURE); 
        }
       
        return $textureurl[1][0];
    }
?>