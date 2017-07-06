<?php
	header("access-control-allow-origin: *");

	include ("conexion_BD.php");

	$codigo_inspector = $_POST['inspector'];
	$codigo_inspeccion = $_POST['inspeccion'];
	$n_cliente=$_POST['n_cliente'];
	$cliente_direccion = $_POST['cliente_direccion'];
	$n_equipo=$_POST['n_equipo'];
	$n_empresamto=$_POST['n_empresamto'];
	$o_desc_puerta=$_POST['o_desc_puerta'];
	$o_tipo_puerta=$_POST['o_tipo_puerta'];
	$o_motorizacion=$_POST['o_motorizacion'];
	$o_acceso=$_POST['o_acceso'];
	$o_accionamiento=$_POST['o_accionamiento'];
	$o_operador=$_POST['o_operador'];
	$o_hoja=$_POST['o_hoja'];
	$o_transmision=$_POST['o_transmision'];
	$o_identificacion=$_POST['o_identificacion'];
	$f_fecha=$_POST['f_fecha'];
	$v_ancho=$_POST['v_ancho'];
	$v_alto=$_POST['v_alto'];
	$v_codigo=$_POST['v_codigo'];
	$o_consecutivoinsp=$_POST['o_consecutivoinsp'];
	$ultimo_mto=$_POST['ultimo_mto'];
	$inicio_servicio=$_POST['inicio_servicio'];
	$ultima_inspeccion=$_POST['ultima_inspeccion'];
	$h_hora=$_POST['h_hora'];
	$o_tipo_informe = $_POST['o_tipo_informe'];

	$bandera_sql = 0;

	//generamos la consulta
	$sql = "UPDATE puertas_valores_iniciales SET n_cliente='".$n_cliente."',
												 n_equipo='".$n_equipo."',
												 n_empresamto='".$n_empresamto."',
												 o_desc_puerta='".$o_desc_puerta."',
												 o_tipo_puerta='".$o_tipo_puerta."',
												 o_motorizacion='".$o_motorizacion."',
												 o_acceso='".$o_acceso."',
												 o_accionamiento='".$o_accionamiento."',
												 o_operador='".$o_operador."',
												 o_hoja='".$o_hoja."',
												 o_transmision='".$o_transmision."',
												 o_identificacion='".$o_identificacion."',
												 f_fecha='".$f_fecha."',
												 v_ancho=".$v_ancho.",
												 v_alto=".$v_alto.",
												 v_codigo='".$v_codigo."',
												 o_consecutivoinsp='".$o_consecutivoinsp."',
												 ultimo_mto='".$ultimo_mto."',
												 inicio_servicio='".$inicio_servicio."',
												 ultima_inspeccion='".$ultima_inspeccion."',
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

	/*=============================================
	* CONSULTA QUE PERMITE OBTENER EL CODIGO DEL CLIENTE ASOCIADO A LA INSPECCION
	*==============================================*/
	$sql = "SELECT * FROM auditoria_inspecciones_puertas WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
	$result=mysqli_query($con, $sql);
	while($row = mysqli_fetch_array($result)){
		$k_codcliente = $row['k_codcliente'];
	}

	//generamos la consulta de actualizacion de la direccion del cliente
	$sql = "UPDATE cliente SET o_direccion = '".$cliente_direccion."' 
			WHERE k_codusuario=".$codigo_inspector." 
			AND k_codcliente=".$k_codcliente."";
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