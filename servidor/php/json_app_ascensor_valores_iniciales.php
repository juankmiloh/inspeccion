<?php
header("access-control-allow-origin: *");
include ("conexion_BD.php");

$codigo_inspector = $_POST['inspector'];

//generamos la consulta
$sql = "SELECT * from ascensor_valores_iniciales v,auditoria_inspecciones_ascensores a WHERE v.k_codusuario=".$codigo_inspector." AND v.k_codusuario=a.k_codusuario AND v.k_codinspeccion=a.k_codinspeccion AND a.o_actualizar_inspeccion='Si'";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$ascensor_valores_iniciales = array(); //creamos un array

while($row = mysqli_fetch_array($result)){
	$k_codusuario = $row['k_codusuario'];
    $k_codinspeccion = $row['k_codinspeccion'];
    $cliente = $row['n_cliente'];
	$nombre_equipo = $row['n_equipo'];
	$empresa_mto = $row['n_empresamto'];
	$accionamiento = $row['o_tipoaccion'];
	$capac_person = $row['v_capacperson'];
	$capac_peso = $row['v_capacpeso'];
	$fecha = $row['f_fecha'];
	$v_codigo = $row['v_codigo'];
	$num_paradas = $row['v_paradas'];
	$consecutivo = $row['o_consecutivoinsp'];
	$ultimo_mto = $row['ultimo_mto'];
	$inicio_servicio = $row['inicio_servicio'];
	$ultima_inspeccion = $row['ultima_inspeccion'];
	$h_hora = $row['h_hora'];
	$o_tipo_informe = $row['o_tipo_informe'];
    
    $ascensor_valores_iniciales[] = array('k_codusuario'=> $k_codusuario,
									 'k_codinspeccion'=> $k_codinspeccion,
									 'n_cliente'=> $cliente,
									 'n_equipo'=> $nombre_equipo,
									 'n_empresamto'=> $empresa_mto,
									 'o_tipoaccion'=> $accionamiento,
									 'v_capacperson'=> $capac_person,
									 'v_capacpeso'=> $capac_peso,
									 'f_fecha'=> $fecha,
									 'v_codigo'=> $v_codigo,
									 'v_paradas'=> $num_paradas,
									 'o_consecutivoinsp'=> $consecutivo,
									 'ultimo_mto'=> $ultimo_mto,
									 'inicio_servicio'=> $inicio_servicio,
									 'ultima_inspeccion'=> $ultima_inspeccion,
									 'h_hora'=> $h_hora,
									 'o_tipo_informe'=> $o_tipo_informe);
}
    
//desconectamos la base de datos
$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

//Creamos el JSON
$json_string = json_encode($ascensor_valores_iniciales);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
    

?>