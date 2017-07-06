<?php
header("access-control-allow-origin: *");

include ("conexion_BD.php");

$codigo_inspector = $_POST['inspector'];
$codigo_inspeccion = $_POST['inspeccion'];

/*=============================================
* CONSULTA QUE PERMITE OBTENER EL CODIGO DEL CLIENTE ASOCIADO A LA INSPECCION
*==============================================*/
$sql = "SELECT * FROM auditoria_inspecciones_puertas WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
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
$sql = "SELECT * FROM puertas_valores_iniciales WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$puertas_valores_iniciales = array(); //creamos un array

while($row = mysqli_fetch_array($result)){
    $textCliente = $row['n_cliente'];
	$textEquipo = $row['n_equipo'];
	$textEmpresaMantenimiento = $row['n_empresamto'];
	$text_desc_puerta = $row['o_desc_puerta'];
	$text_tipoPuerta = $row['o_tipo_puerta'];
	$text_motorizacion = $row['o_motorizacion'];
	$text_acceso = $row['o_acceso'];
	$text_accionamiento = $row['o_accionamiento'];
	$text_operador = $row['o_operador'];
	$text_hoja = $row['o_hoja'];
	$text_transmision = $row['o_transmision'];
	$text_identificacion = $row['o_identificacion'];
	$textFecha = $row['f_fecha'];
	$text_ultimo_mto = $row['ultimo_mto'];
	$text_inicio_servicio = $row['inicio_servicio'];
	$text_ultima_inspec = $row['ultima_inspeccion'];
	$text_ancho = $row['v_ancho'];
	$text_alto = $row['v_alto'];
	$consecutivo = $row['o_consecutivoinsp'];
    
    $puertas_valores_iniciales[] = array('n_cliente'=> $textCliente,
										 'o_direccion_cliente'=> $o_direccion_cliente,
										 'n_equipo'=> $textEquipo,
										 'n_empresamto'=> $textEmpresaMantenimiento,
										 'o_desc_puerta'=> $text_desc_puerta,
										 'o_tipo_puerta'=> $text_tipoPuerta,
										 'o_motorizacion'=> $text_motorizacion,
										 'o_acceso'=> $text_acceso,
										 'o_accionamiento'=> $text_accionamiento,
										 'o_operador'=> $text_operador,
										 'o_hoja'=> $text_hoja,
										 'o_transmision'=> $text_transmision,
										 'o_identificacion'=> $text_identificacion,
										 'f_fecha'=> $textFecha,
										 'ultimo_mto'=> $text_ultimo_mto,
										 'inicio_servicio'=> $text_inicio_servicio,
										 'ultima_inspeccion'=> $inicio_servicio,
										 'v_ancho'=> $text_ancho,
										 'v_alto'=> $text_alto,
										 'o_consecutivoinsp'=> $consecutivo);
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