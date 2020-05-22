<?php
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
    function convertTextureData($nbt){
        if(isset($nbt["SkullOwner"])){
            $value = json_decode(base64_decode($nbt["SkullOwner"]["Properties"]["textures"][0]["Value"]));

            return $value->textures->SKIN->url;
        }
        return "";
    }
?>