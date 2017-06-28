<?php
header("access-control-allow-origin: *");
include ("conexion_BD.php");

$codigo_inspector = $_POST['inspector'];

//generamos la consulta
$sql = "SELECT * from auditoria_inspecciones_ascensores a WHERE k_codusuario=".$codigo_inspector." AND o_actualizar_inspeccion='Si'";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$auditoria_inspecciones_ascensores = array(); //creamos un array

while($row = mysqli_fetch_array($result)){ 
    $k_codusuario = $row['k_codusuario'];
    $k_codinspeccion = $row['k_codinspeccion'];
    $o_consecutivoinsp = $row['o_consecutivoinsp'];
    $o_estado_envio = $row['o_estado_envio'];
    $o_revision = $row['o_revision'];
    $v_item_nocumple = $row['v_item_nocumple'];
    $k_codcliente = $row['k_codcliente'];
    $k_codinforme = $row['k_codinforme'];
    $k_codusuario_modifica = $row['k_codusuario_modifica'];
    $o_actualizar_inspeccion = $row['o_actualizar_inspeccion'];
    
    $auditoria_inspecciones_ascensores[] = array('k_codusuario'=> $k_codusuario,
									 'k_codinspeccion'=> $k_codinspeccion,
									 'o_consecutivoinsp'=> $o_consecutivoinsp,
									 'o_estado_envio'=> $o_estado_envio,
									 'o_revision'=> $o_revision,
									 'v_item_nocumple'=> $v_item_nocumple,
									 'k_codcliente'=> $k_codcliente,
                                     'k_codinforme'=> $k_codinforme,
									 'k_codusuario_modifica'=> $k_codusuario_modifica,
                                     'o_actualizar_inspeccion'=> $o_actualizar_inspeccion);
}
    
//desconectamos la base de datos
$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

//Creamos el JSON
$json_string = json_encode($auditoria_inspecciones_ascensores);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
    

?>