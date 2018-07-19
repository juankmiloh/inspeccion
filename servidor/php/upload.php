<?php
header("access-control-allow-origin: *");
include("conexion_BD.php");
$headers = array();
foreach($_SERVER as $key => $value) {
    if(strpos($key, 'HTTP_') === 0) {
        $headers = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
        echo $headers." : ". $i[$headers] = $value . "<br>";
    }
}
$target_dir = "uploads/";
$target_file = $target_dir . $_FILES["file"]["name"];
move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
?>