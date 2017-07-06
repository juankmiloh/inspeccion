<?php
header("access-control-allow-origin: *");

include ("conexion_BD.php");

$codigo_inspector = $_POST['inspector'];
$codigo_inspeccion = $_POST['inspeccion'];

/*=============================================
* CONSULTA QUE PERMITE OBTENER EL CODIGO DEL CLIENTE ASOCIADO A LA INSPECCION
*==============================================*/
$sql = "SELECT * FROM auditoria_inspecciones_ascensores WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
$result=mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result)){
	$k_codcliente = $row['k_codcliente'];
}

/*=============================================
* CONSULTA QUE PERMITE OBTENER LA DIRECCION DEL CLIENTE
*==============================================*/
$sql = "SELECT * FROM cliente WHERE k_codusuario=".$codigo_inspector." AND k_codcliente=".$k_codcliente."";
$result=mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result)){
	$o_direccion_cliente = $row['o_direccion'];
}

//generamos la consulta
$sql = "SELECT * FROM ascensor_valores_iniciales WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$ascensor_valores_iniciales = array(); //creamos un array

while($row = mysqli_fetch_array($result)){ 
    $cliente = $row['n_cliente'];
	$nombre_equipo = $row['n_equipo'];
	$empresa_mto = $row['n_empresamto'];
	$accionamiento = $row['o_tipoaccion'];
	$capac_person = $row['v_capacperson'];
	$capac_peso = $row['v_capacpeso'];
	$fecha = $row['f_fecha'];
	$num_paradas = $row['v_paradas'];
	$consecutivo = $row['o_consecutivoinsp'];
	$ultimo_mto = $row['ultimo_mto'];
	$inicio_servicio = $row['inicio_servicio'];
	$ultima_inspeccion = $row['ultima_inspeccion'];
    
    $ascensor_valores_iniciales[] = array('n_cliente'=> $cliente,
									 'o_direccion_cliente'=> $o_direccion_cliente,
									 'n_equipo'=> $nombre_equipo,
									 'n_empresamto'=> $empresa_mto,
									 'o_tipoaccion'=> $accionamiento,
									 'v_capacperson'=> $capac_person,
									 'v_capacpeso'=> $capac_peso,
									 'f_fecha'=> $fecha,
									 'v_paradas'=> $num_paradas,
									 'o_consecutivoinsp'=> $consecutivo,
									 'ultimo_mto'=> $ultimo_mto,
									 'inicio_servicio'=> $inicio_servicio,
									 'ultima_inspeccion'=> $ultima_inspeccion);
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