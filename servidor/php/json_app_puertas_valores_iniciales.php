<?php
header("access-control-allow-origin: *");
include ("conexion_BD.php");

$codigo_inspector = $_POST['inspector'];

//generamos la consulta
$sql = "SELECT * from puertas_valores_iniciales v,auditoria_inspecciones_puertas a WHERE v.k_codusuario=".$codigo_inspector." AND v.k_codusuario=a.k_codusuario AND v.k_codinspeccion=a.k_codinspeccion AND a.o_actualizar_inspeccion='Si'";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$puertas_valores_iniciales = array(); //creamos un array

while($row = mysqli_fetch_array($result)){
	$k_codusuario = $row['k_codusuario'];
    $k_codinspeccion = $row['k_codinspeccion'];
    $n_cliente=$row['n_cliente'];
	$n_equipo=$row['n_equipo'];
	$n_empresamto=$row['n_empresamto'];
	$o_desc_puerta=$row['o_desc_puerta'];
	$o_tipo_puerta=$row['o_tipo_puerta'];
	$o_motorizacion=$row['o_motorizacion'];
	$o_acceso=$row['o_acceso'];
	$o_accionamiento=$row['o_accionamiento'];
	$o_operador=$row['o_operador'];
	$o_hoja=$row['o_hoja'];
	$o_transmision=$row['o_transmision'];
	$o_identificacion=$row['o_identificacion'];
	$f_fecha=$row['f_fecha'];
	$v_ancho=$row['v_ancho'];
	$v_alto=$row['v_alto'];
	$v_codigo=$row['v_codigo'];
	$o_consecutivoinsp=$row['o_consecutivoinsp'];
	$ultimo_mto=$row['ultimo_mto'];
	$inicio_servicio=$row['inicio_servicio'];
	$ultima_inspeccion=$row['ultima_inspeccion'];
	$h_hora=$row['h_hora'];
	$o_tipo_informe = $row['o_tipo_informe'];
    
    $puertas_valores_iniciales[] = array('k_codusuario'=> $k_codusuario,
									 'k_codinspeccion'=> $k_codinspeccion,
									 'n_cliente'=> $n_cliente,
									 'n_equipo'=> $n_equipo,
									 'n_empresamto'=> $n_empresamto,
									 'o_desc_puerta'=> $o_desc_puerta,
									 'o_tipo_puerta'=> $o_tipo_puerta,
									 'o_motorizacion'=> $o_motorizacion,
									 'o_acceso'=> $o_acceso,
									 'o_accionamiento'=> $o_accionamiento,
									 'o_operador'=> $o_operador,
									 'o_hoja'=> $o_hoja,
									 'o_transmision'=> $o_transmision,
									 'o_identificacion'=> $o_identificacion,
									 'f_fecha'=> $f_fecha,
									 'v_ancho'=> $v_ancho,
									 'v_alto'=> $v_alto,
									 'v_codigo'=> $v_codigo,
									 'o_consecutivoinsp'=> $o_consecutivoinsp,
									 'ultimo_mto'=> $text_ultimo_mto,
									 'inicio_servicio'=> $text_inicio_servicio,
									 'ultima_inspeccion'=> $inicio_servicio,
									 'h_hora'=> $h_hora,
									 'o_tipo_informe'=> $o_tipo_informe);
}
    
//desconectamos la base de datos
$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

//Creamos el JSON
$json_string = json_encode($puertas_valores_iniciales);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
    

?>