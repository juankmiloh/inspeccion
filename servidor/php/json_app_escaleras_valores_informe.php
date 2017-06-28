<?php
header("access-control-allow-origin: *");
include ("conexion_BD.php");

$codigo_inspector = $_POST['inspector'];

//generamos la consulta
$sql = "SELECT * from informe i,auditoria_inspecciones_escaleras a WHERE a.k_codusuario=".$codigo_inspector." AND i.k_codusuario=a.k_codusuario AND i.k_codinforme=a.k_codinforme AND a.o_actualizar_inspeccion='Si' ORDER BY i.f_informe DESC LIMIT 1";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$informe = array(); //creamos un array

while($row = mysqli_fetch_array($result)){ 
    $k_codinforme = $row['k_codinforme'];
    $v_consecutivoinforme = $row['v_consecutivoinforme'];
    $k_codusuario = $row['k_codusuario'];
    $f_informe = $row['f_informe'];
    
    $informe[] = array('k_codinforme'=> $k_codinforme,
					 'v_consecutivoinforme'=> $v_consecutivoinforme,
					 'k_codusuario'=> $k_codusuario,
					 'f_informe'=> $f_informe);
}
    
//desconectamos la base de datos
$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

//Creamos el JSON
$json_string = json_encode($informe);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
    

?>