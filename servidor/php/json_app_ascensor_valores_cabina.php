<?php
header("access-control-allow-origin: *");
include ("conexion_BD.php");

$codigo_inspector = $_POST['inspector'];

//generamos la consulta
$sql = "SELECT * from ascensor_valores_cabina v,auditoria_inspecciones_ascensores a WHERE v.k_codusuario=".$codigo_inspector." AND v.k_codusuario=a.k_codusuario AND v.k_codinspeccion=a.k_codinspeccion AND a.o_actualizar_inspeccion='Si'";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$rowcount=mysqli_num_rows($result);

$ascensor_valores_cabina = array(); //creamos un array

while($row = mysqli_fetch_array($result)){ 
    $k_codusuario = $row['k_codusuario'];
    $k_codinspeccion = $row['k_codinspeccion'];
    $k_coditem_cabina = $row['k_coditem_cabina'];
    $n_calificacion = $row['n_calificacion'];
    $v_calificacion = $row['v_calificacion'];
    $o_observacion = $row['o_observacion'];
    
    $ascensor_valores_cabina[] = array('k_codusuario'=> $k_codusuario,
									 'k_codinspeccion'=> $k_codinspeccion,
									 'k_coditem_cabina'=> $k_coditem_cabina,
									 'n_calificacion'=> $n_calificacion,
									 'v_calificacion'=> $v_calificacion,
									 'o_observacion'=> $o_observacion,
									 'cantidad_filas'=> $rowcount);
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