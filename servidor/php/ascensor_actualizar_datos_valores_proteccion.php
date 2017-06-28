<?php
	header("access-control-allow-origin: *");

	include ("conexion_BD.php");

	$codigo_inspector = $_POST['inspector'];
	$codigo_inspeccion = $_POST['inspeccion'];
	$cod_item = $_POST['cod_item'];
	$sele_inspector = $_POST['sele_inspector'];
	$sele_empresa = $_POST['sele_empresa'];
	$observacion = $_POST['observacion'];

	$bandera_sql = 0;

	//generamos la consulta
	$sql = "UPDATE ascensor_valores_proteccion SET v_sele_inspector = '".$sele_inspector."',
												   v_sele_empresa = '".$sele_empresa."',
                                                   o_observacion = '".$observacion."' 
                                               	WHERE 
                                                   k_codusuario=".$codigo_inspector." AND 
                                                   k_codinspeccion=".$codigo_inspeccion." AND k_coditem =".$cod_item."";
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