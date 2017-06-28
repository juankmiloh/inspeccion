<?php
header("access-control-allow-origin: *");
include ("conexion_BD.php");

$codigo_inspector = $_POST['inspector'];

//generamos la consulta
$sql = "SELECT * from escaleras_valores_iniciales v,auditoria_inspecciones_escaleras a WHERE v.k_codusuario=".$codigo_inspector." AND v.k_codusuario=a.k_codusuario AND v.k_codinspeccion=a.k_codinspeccion AND a.o_actualizar_inspeccion='Si'";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$escaleras_valores_iniciales = array(); //creamos un array

while($row = mysqli_fetch_array($result)){
	$k_codusuario = $row['k_codusuario'];
    $k_codinspeccion = $row['k_codinspeccion'];
	$n_cliente = $row['n_cliente'];
	$n_equipo = $row['n_equipo'];
	$n_empresamto = $row['n_empresamto'];
	$v_velocidad = $row['v_velocidad'];
	$o_tipo_equipo = $row['o_tipo_equipo'];
	$v_inclinacion = $row['v_inclinacion'];
	$v_ancho_paso = $row['v_ancho_paso'];
	$f_fecha = $row['f_fecha'];
	$ultimo_mto = $row['ultimo_mto'];
	$inicio_servicio = $row['inicio_servicio'];
	$ultima_inspeccion = $row['ultima_inspeccion'];
	$v_codigo = $row['v_codigo'];
	$o_consecutivoinsp = $row['o_consecutivoinsp'];
	$h_hora = $row['h_hora'];
	$o_tipo_informe = $row['o_tipo_informe'];
    
    $escaleras_valores_iniciales[] = array('k_codusuario'=> $k_codusuario,
									 'k_codinspeccion'=> $k_codinspeccion,
									 'n_cliente'=> $n_cliente,
									 'n_equipo'=> $n_equipo,
									 'n_empresamto'=> $n_empresamto,
									 'v_velocidad'=> $v_velocidad,
									 'o_tipo_equipo'=> $o_tipo_equipo,
									 'v_inclinacion'=> $v_inclinacion,
									 'v_ancho_paso'=> $v_ancho_paso,
									 'f_fecha'=> $f_fecha,
									 'v_codigo'=> $v_codigo,
									 'o_consecutivoinsp'=> $o_consecutivoinsp,
									 'ultimo_mto'=> $ultimo_mto,
									 'inicio_servicio'=> $inicio_servicio,
									 'ultima_inspeccion'=> $ultima_inspeccion,
									 'h_hora'=> $h_hora,
									 'o_tipo_informe'=> $o_tipo_informe);
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