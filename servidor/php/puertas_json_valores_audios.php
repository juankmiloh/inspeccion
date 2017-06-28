<?php
	header("access-control-allow-origin: *");

	include ("conexion_BD.php");

	$codigo_inspector = $_POST['inspector'];
	$codigo_inspeccion = $_POST['inspeccion'];

	//generamos la consulta
	$sql = "SELECT * FROM puertas_valores_audios WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
	mysqli_set_charset($con, "utf8"); //formato de datos utf8

	if(!$result = mysqli_query($con, $sql)) die();

	$puertas_valores_audios = array(); //creamos un array

	while($row = mysqli_fetch_array($result)){ 
	    $nombre_archivo = $row['n_audio'];
	    $puertas_valores_audios[] = array('valor'=> $codigo_inspector,
	    						           'texto'=> $nombre_archivo);
	}
	    
	//desconectamos la base de datos
	$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

	//Creamos el JSON
	$json_string = json_encode($puertas_valores_audios);
	echo $json_string;
?>