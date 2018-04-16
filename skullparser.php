<?
if ($_GET['e'] == 1){
$file = $_GET['u'];
$srcp = imagecreatefrompng($file);
$destp = imagecreate(32, 32);
imagecopyresampled($destp, $srcp, 0, 0, 8, 8, 32,32, 8,8);

header('Content-type: image/png');
imagepng($destp);
    
}else {
   $file = $_GET['u'];
$srcp = imagecreatefrompng("imgcache/".$file);
$destp = imagecreate(32, 32);
imagecopyresampled($destp, $srcp, 0, 0, 8, 8, 32,32, 8,8);

header('Content-type: image/png');
imagepng($destp); 
    
}
?>