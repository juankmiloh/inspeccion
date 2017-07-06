<?php
	header("access-control-allow-origin: *");

	include ("conexion_BD.php");

	$codigo_inspector = $_POST['inspector'];
	$codigo_inspeccion = $_POST['inspeccion'];
	$cliente = $_POST['cliente'];
	$cliente_direccion = $_POST['cliente_direccion'];
	$equipo = $_POST['equipo'];
	$empresa_mto = $_POST['empresa_mto'];
	$accionamiento = $_POST['accionamiento'];
	$capac_person = $_POST['capac_person'];
	$capac_peso = $_POST['capac_peso'];
	$num_paradas = $_POST['num_paradas'];
	$fecha = $_POST['fecha'];
	$ultimo_mto = $_POST['ultimo_mto'];
	$inicio_servicio = $_POST['inicio_servicio'];
	$ultima_inspec = $_POST['ultima_inspec'];
	$hora = $_POST['hora'];
	$tipo_informe = $_POST['tipo_informe'];

	$bandera_sql = 0;

	//generamos la consulta de actualizacion de los valores iniciales
	$sql = "UPDATE ascensor_valores_iniciales SET n_cliente = '".$cliente."',
                                                  n_equipo = '".$equipo."',
                                                  n_empresamto = '".$empresa_mto."',
                                                  o_tipoaccion = '".$accionamiento."',
                                                  v_capacperson = ".$capac_person.",
                                                  v_capacpeso = ".$capac_peso.",
                                                  v_paradas = ".$num_paradas.",
                                                  f_fecha = '".$fecha."',
                                                  ultimo_mto = '".$ultimo_mto."',
                                                  inicio_servicio = '".$inicio_servicio."',
                                                  ultima_inspeccion = '".$ultima_inspec."',
                                                  h_hora = '".$hora."',
                                                  o_tipo_informe = '".$tipo_informe."' 
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
	$sql = "SELECT * FROM auditoria_inspecciones_ascensores WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
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