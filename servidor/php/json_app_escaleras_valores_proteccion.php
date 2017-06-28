<?php
header("access-control-allow-origin: *");
include ("conexion_BD.php");

$codigo_inspector = $_POST['inspector'];

//generamos la consulta
$sql = "SELECT * from escaleras_valores_proteccion v,auditoria_inspecciones_escaleras a WHERE v.k_codusuario=".$codigo_inspector." AND v.k_codusuario=a.k_codusuario AND v.k_codinspeccion=a.k_codinspeccion AND a.o_actualizar_inspeccion='Si'";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$escaleras_valores_proteccion = array(); //creamos un array

while($row = mysqli_fetch_array($result)){ 
    $k_codusuario = $row['k_codusuario'];
    $k_codinspeccion = $row['k_codinspeccion'];
    $k_coditem = $row['k_coditem'];
    $v_sele_inspector = $row['v_sele_inspector'];
    $v_sele_empresa = $row['v_sele_empresa'];
    $o_observacion = $row['o_observacion'];
    
    $escaleras_valores_proteccion[] = array('k_codusuario'=> $k_codusuario,
									 'k_codinspeccion'=> $k_codinspeccion,
									 'k_coditem'=> $k_coditem,
									 'v_sele_inspector'=> $v_sele_inspector,
									 'v_sele_empresa'=> $v_sele_empresa,
									 'o_observacion'=> $o_observacion);
}
    
//desconectamos la base de datos
$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

//Creamos el JSON
$json_string = json_encode($escaleras_valores_proteccion);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
    

?>