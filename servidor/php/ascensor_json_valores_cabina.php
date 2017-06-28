<?php
header("access-control-allow-origin: *");

include ("conexion_BD.php");

$codigo_inspector = $_POST['inspector'];
$codigo_inspeccion = $_POST['inspeccion'];

//generamos la consulta
$sql = "SELECT * FROM ascensor_valores_cabina WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion." ORDER BY k_coditem_cabina";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$ascensor_valores_cabina = array(); //creamos un array

while($row = mysqli_fetch_array($result)){ 
    $v_calificacion = $row['v_calificacion'];
    $o_observacion = $row['o_observacion'];
    
    $ascensor_valores_cabina[] = array('v_calificacion'=> $v_calificacion,
									   'o_observacion'=> $o_observacion);
}
    
//desconectamos la base de datos
$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

//Creamos el JSON
$json_string = json_encode($ascensor_valores_cabina);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
    

?>