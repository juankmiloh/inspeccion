<?php
header("access-control-allow-origin: *");

include ("conexion_BD.php");

//generamos la consulta
$sql = "SELECT * FROM puertas_items_mecanicos";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$puertas_items_mecanicos = array(); //creamos un array

while($row = mysqli_fetch_array($result)){ 
    $k_coditem_puertas = $row['k_coditem_puertas'];
    $v_item = $row['v_item'];
    $o_descripcion = $row['o_descripcion'];
    $v_clasificacion = $row['v_clasificacion'];
    
    $puertas_items_mecanicos[] = array('k_coditem_puertas'=> $k_coditem_puertas,
									'o_descripcion'=> $o_descripcion,
									'v_clasificacion'=> $v_clasificacion);
}
    
//desconectamos la base de datos
$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

//Creamos el JSON
$json_string = json_encode($puertas_items_mecanicos);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
?>