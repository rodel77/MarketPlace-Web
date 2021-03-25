<?php
    const enchantments_ids = array(
        "0" => "protection",
        "1" => "fire_protection",
        "2" => "feather_falling",
        "3" => "blast_protection",
        "4" => "projectile_protection",
        "5" => "respiration",
        "6" => "aqua_affinity",
        "7" => "thorns",
        "8" => "depth_strider",
        "9" => "frost_walker",
        "10" => "binding_curse",
        "16" => "sharpness",
        "17" => "smite",
        "18" => "bane_of_arthropods",
        "19" => "knockback",
        "20" => "fire_aspect",
        "21" => "looting",
        "22" => "sweeping",
        "32" => "efficiency",
        "33" => "silk_touch",
        "34" => "unbreaking",
        "35" => "fortune",
        "48" => "power",
        "49" => "punch",
        "50" => "flame",
        "51" => "infinity",
        "61" => "luck_of_the_sea",
        "62" => "lure",
        "70" => "mending",
        "71" => "vanishing_curse",
    );

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

    function get_enchantments($nbt){
        if(array_key_exists("ench", $nbt)){
            $enchantments = array();
            foreach($nbt["ench"] as $enchantment) {
                array_push($enchantments, array(
                    "lvl" => $enchantment["lvl"],
                    "id"  => "minecraft:".enchantments_ids[strval($enchantment["id"])],
                ));
            }
            return json_encode($enchantments);
        }
        if(array_key_exists("Enchantments", $nbt)) return json_encode($nbt["Enchantments"]);

        return "";

        // $enchantments = array_key ? $nbt["ench"] : $nbt["Enchantments"];
        // if($enchantments==null) return false;
        // print_r($enchantments);
        
        // if($nbt)
        // return json_encode($nbt["Enchantments"] || $nbt["ench"]);
        // return json_encode();
    }
?>