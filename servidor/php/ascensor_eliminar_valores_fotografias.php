<?php
	header("access-control-allow-origin: *");

	include ("conexion_BD.php");

	$codigo_inspector = $_POST['inspector'];
	$codigo_inspeccion = $_POST['inspeccion'];
	$cod_item = $_POST['item'];
	$nombre_foto = $_POST['foto'];

	$bandera_sql = 0;

	//generamos la consulta
	$sql = "DELETE FROM ascensor_valores_fotografias WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion." AND n_fotografia='".$nombre_foto."' AND k_coditem=".$cod_item."";
	mysqli_set_charset($con, "utf8"); //formato de datos utf8

	if (mysqli_query($con,$sql) == true){
		unlink("../ascensores/inspector_".$codigo_inspector."/fotografias/".$codigo_inspeccion."/".$nombre_foto);
		echo $bandera_sql;
		//echo "Registros guardados correctamente.";
		//$bandera_sql += 1;
	}else{
	  	//echo $con->error."\nerror: ". $sql . "<br>";
	  	$bandera_sql += 1;
	  	echo $bandera_sql;
	}
	    
	//desconectamos la base de datos
	$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

	//echo $bandera_sql;
?>