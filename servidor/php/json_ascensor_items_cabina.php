<?php
header("access-control-allow-origin: *");

include ("conexion_BD.php");

//generamos la consulta
$sql = "SELECT * FROM ascensor_items_cabina";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$ascensor_items_cabina = array(); //creamos un array

while($row = mysqli_fetch_array($result)){ 
    $k_coditem_cabina = $row['k_coditem_cabina'];
    $v_item = $row['v_item'];
    $o_descripcion = $row['o_descripcion'];
    $v_clasificacion = $row['v_clasificacion'];
    
    $ascensor_items_cabina[] = array('k_coditem_cabina'=> $k_coditem_cabina,
									 'v_item'=> $v_item,
									 'o_descripcion'=> $o_descripcion,
									 'v_clasificacion'=> $v_clasificacion);
}
    
//desconectamos la base de datos
$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

//Creamos el JSON
$json_string = json_encode($ascensor_items_cabina);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
    

?>