<?php
header("access-control-allow-origin: *");
include ("conexion_BD.php");

$codigo_inspector = $_POST['inspector'];

//generamos la consulta
$sql = "SELECT * from cliente c,auditoria_inspecciones_puertas a WHERE a.k_codusuario=".$codigo_inspector." AND c.k_codusuario=a.k_codusuario AND c.k_codcliente=a.k_codcliente AND a.o_actualizar_inspeccion='Si' ORDER BY c.consecutivo DESC LIMIT 1";
mysqli_set_charset($con, "utf8"); //formato de datos utf8

if(!$result = mysqli_query($con, $sql)) die();

$cliente = array(); //creamos un array

while($row = mysqli_fetch_array($result)){ 
    $k_codcliente = $row['k_codcliente'];
    $v_consecutivocliente = $row['v_consecutivocliente'];
    $k_codusuario = $row['k_codusuario'];
    $n_cliente = $row['n_cliente'];
    $n_contacto = $row['n_contacto'];
    $v_nit = $row['v_nit'];
    $o_direccion = $row['o_direccion'];
    $o_telefono = $row['o_telefono'];
    $o_correo = $row['o_correo'];
    
    $cliente[] = array('k_codcliente'=> $k_codcliente,
					 'v_consecutivocliente'=> $v_consecutivocliente,
					 'k_codusuario'=> $k_codusuario,
					 'n_cliente'=> $n_cliente,
					 'n_contacto'=> $n_contacto,
					 'v_nit'=> $v_nit,
					 'o_direccion'=> $o_direccion,
					 'o_telefono'=> $o_telefono,
					 'o_correo'=> $o_correo);
}
    
//desconectamos la base de datos
$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

//Creamos el JSON
$json_string = json_encode($cliente);
echo $json_string;

//Si queremos crear un archivo json, sería de esta forma:
/*
$file = 'clientes.json';
file_put_contents($file, $json_string);
*/
    

?>