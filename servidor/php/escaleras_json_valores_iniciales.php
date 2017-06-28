<?php
header("access-control-allow-origin: *");

include ("conexion_BD.php");

$codigo_inspector = $_POST['inspector'];
$codigo_inspeccion = $_POST['inspeccion'];

//generamos la consulta
$sql = "SELECT * FROM escaleras_valores_iniciales WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$escaleras_valores_iniciales = array(); //creamos un array

while($row = mysqli_fetch_array($result)){
    $textCliente = $row['n_cliente'];
	$textEquipo = $row['n_equipo'];
	$textEmpresaMantenimiento = $row['n_empresamto'];
	$text_velocidad = $row['v_velocidad'];
	$text_tipoEquipo = $row['o_tipo_equipo'];
	$text_inclinacion = $row['v_inclinacion'];
	$text_ancho_paso = $row['v_ancho_paso'];
	$textFecha = $row['f_fecha'];
	$text_ultimo_mto = $row['ultimo_mto'];
	$text_inicio_servicio = $row['inicio_servicio'];
	$text_ultima_inspec = $row['ultima_inspeccion'];
	$consecutivo = $row['o_consecutivoinsp'];
    
    $escaleras_valores_iniciales[] = array('n_cliente'=> $textCliente,
										 'n_equipo'=> $textEquipo,
										 'n_empresamto'=> $textEmpresaMantenimiento,
										 'v_velocidad'=> $text_velocidad,
										 'o_tipo_equipo'=> $text_tipoEquipo,
										 'v_inclinacion'=> $text_inclinacion,
										 'v_ancho_paso'=> $text_ancho_paso,
										 'f_fecha'=> $textFecha,
										 'ultimo_mto'=> $text_ultimo_mto,
										 'inicio_servicio'=> $text_inicio_servicio,
										 'ultima_inspeccion'=> $text_ultima_inspec,
										 'o_consecutivoinsp'=> $consecutivo);
}
    
//desconectamos la base de datos
$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

//Creamos el JSON
$json_string = json_encode($escaleras_valores_iniciales);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
    

?>