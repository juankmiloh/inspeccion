<?php
	header("access-control-allow-origin: *");

	include ("conexion_BD.php");

	$codigo_inspector = $_POST['inspector'];
	$codigo_inspeccion = $_POST['inspeccion'];
	$n_cliente = $_POST['n_cliente'];
	$n_equipo = $_POST['n_equipo'];
	$n_empresamto = $_POST['n_empresamto'];
	$v_velocidad = $_POST['v_velocidad'];
	$o_tipo_equipo = $_POST['o_tipo_equipo'];
	$v_inclinacion = $_POST['v_inclinacion'];
	$v_ancho_paso = $_POST['v_ancho_paso'];
	$f_fecha = $_POST['f_fecha'];
	$ultimo_mto = $_POST['ultimo_mto'];
	$inicio_servicio = $_POST['inicio_servicio'];
	$ultima_inspeccion = $_POST['ultima_inspeccion'];
	$v_codigo = $_POST['v_codigo'];
	$o_consecutivoinsp = $_POST['o_consecutivoinsp'];
	$h_hora = $_POST['h_hora'];
	$o_tipo_informe = $_POST['o_tipo_informe'];

	$bandera_sql = 0;

	//generamos la consulta
	$sql = "UPDATE escaleras_valores_iniciales SET n_cliente='".$n_cliente."',
												 n_equipo='".$n_equipo."',
												 n_empresamto='".$n_empresamto."',
												 v_velocidad='".$v_velocidad."',
												 o_tipo_equipo='".$o_tipo_equipo."',
												 v_inclinacion='".$v_inclinacion."',
												 v_ancho_paso='".$v_ancho_paso."',
												 f_fecha='".$f_fecha."',
												 ultimo_mto='".$ultimo_mto."',
												 inicio_servicio='".$inicio_servicio."',
												 ultima_inspeccion='".$ultima_inspeccion."',
												 v_codigo='".$v_codigo."',
												 o_consecutivoinsp='".$o_consecutivoinsp."',
												 h_hora='".$h_hora."',
                                                 o_tipo_informe = '".$o_tipo_informe."' 
                                               	WHERE 
                                                 k_codusuario=".$codigo_inspector." AND 
                                                 k_codinspeccion=".$codigo_inspeccion."";
	mysqli_set_charset($con, "utf8"); //formato de datos utf8

	if (mysqli_query($con,$sql) == true){
		//echo "Registros guardados correctamente.";
		//$bandera_sql += 1;
	}else{
	  	//echo $con->error."\nerror: ". $sql . "<br>";
	  	$bandera_sql += 1;
	}

	echo $bandera_sql;
	    
	//desconectamos la base de datos
	$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
?>