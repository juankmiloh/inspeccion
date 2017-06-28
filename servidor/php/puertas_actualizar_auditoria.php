<?php
	header("access-control-allow-origin: *");

	include ("conexion_BD.php");

	$codigo_inspector = $_POST['inspector'];
	$codigo_inspeccion = $_POST['inspeccion'];
	$consecutivo_insp = $_POST['consecutivo_insp'];
	$estado_revision = $_POST['estado_revision'];
	$cantidad_nocumple = $_POST['cantidad_nocumple'];
	$o_actualizar_inspeccion = $_POST['o_actualizar_inspeccion'];

	$bandera_sql = 0;

	//generamos la consulta
	$sql = "UPDATE auditoria_inspecciones_puertas SET o_actualizar_inspeccion = '".$o_actualizar_inspeccion."',
													  o_revision = '".$estado_revision."',
			                                          v_item_nocumple = '".$cantidad_nocumple."' 
			                                         WHERE 
			                                          k_codusuario=".$codigo_inspector." AND 
			                                          k_codinspeccion=".$codigo_inspeccion."";
	mysqli_set_charset($con, "utf8"); //formato de datos utf8

	if (mysqli_query($con,$sql) == true){
		echo "Registros guardados correctamente.";
		//$bandera_sql += 1;
	}else{
	  	echo $con->error."\nerror: ". $sql . "<br>";
	  	$bandera_sql += 1;
	}

	echo $bandera_sql;
	    
	//desconectamos la base de datos
	$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
?>