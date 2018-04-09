<?php
    function getItemImage(){

    }
    // MCGSoft Addition New Parsing NBT
    function getlore($nbt){
    
    preg_match("(({Lore:)\[(.*?)\])",$nbt,$firstmatch,PREG_OFFSET_CAPTURE);
    preg_match_all('("(.*?)")',$firstmatch[2][0],$secondmatch);

   
    return $secondmatch[1];
    }
    function getname($nbt){
        
         preg_match('(Name:"(.*?)")',$nbt,$name,PREG_OFFSET_CAPTURE);
        
        
        return filtercolorcodes($name[1]);
    }
    function filtercolorcodes($nbt){
        $filtered = preg_replace("(§[a-z,0-9])"," ",$nbt);
       
        return  $filtered;
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
    function SearchTools($tools,$material) {
        foreach ($tools as $tool){
            $exp = explode('#',$tool);
                if ($material == $exp[0]){
                    return true;
                }
                
                
            
            
            
            
        }
    return false;
    }
?>