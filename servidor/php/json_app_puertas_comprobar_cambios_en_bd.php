<?php
	ob_start(); //Linea para permitir enviar flujo de datos por url al redireccionar la pagina
	header("access-control-allow-origin: *");
	include ("conexion_BD.php");

	$codigo_inspector = $_POST['inspector'];

	session_start();
	$time = time() - $_SESSION['question_start'];

	/*=============================================
	* MIENTRAS LA CANTIDAD DE INSPECCIONES A puertas MODIFICADAS SEA MENOR O IGUAL A CERO LA EJECUCION SE QUEDA EN EL CICLO WHILE 
	* (PENDIENTE) ESPERANDO A QUE SE HAGA UNA MODIFICACION EN ALGUNA INSPECCION PARA QUE EL CAMPO 'o_actualizar_inspeccion' PASE AL VALOR DE 
	* 'Si'; OCURRIENDO ESTO LA CANTIDAD DE INSPECCIONES PASARA A SER DIFERENTE DE CERO Y POR ENDE SE ROMPE EL CICLO WHILE Y CONTINUA LA 
	* EJECUCION DEL SCRIPT PERMITIENDO DEVOLVER AL CLIENTE LA CANTIDAD DE INSPECCIONES MODIFICADAS
	*==============================================*/
	while( $count_puertas <= 0 ){	
		$sql = "SELECT COUNT(*) count_puertas FROM auditoria_inspecciones_puertas WHERE k_codusuario=".$codigo_inspector." AND o_actualizar_inspeccion='Si'";
		$result = mysqli_query($con, $sql);
		$row=mysqli_fetch_array($result);
		
		usleep(100000); //Retrasar la ejecucion por (1) segundo
		clearstatcache(); //Borrar Cache 
		$count_puertas = $row['count_puertas'];
		if ($time > 30) {
			break; /* Sale del switch y del while. */
		}
	}

	/*=============================================
	* SI SE SALE DEL CICLO WHILE SE PROCEDE A REALIZAR LA CONSULTA SQL QUE DEVUELVE LA CANTIDAD DE INSPECCIONES QUE SE MODIFICARON
	*==============================================*/
	$sql = "SELECT COUNT(*) count_puertas FROM auditoria_inspecciones_puertas WHERE k_codusuario=".$codigo_inspector." AND o_actualizar_inspeccion='Si'";
	mysqli_set_charset($con, "utf8"); //formato de datos utf8

	if(!$result = mysqli_query($con, $sql)) die();

	$actualizar_bd = array(); //creamos un array

	while($row = mysqli_fetch_array($result)){ 
	    $count_puertas = $row['count_puertas'];
	    
	    $actualizar_bd[] = array('count_puertas'=> $count_puertas);
	}
	    
	//desconectamos la base de datos
	$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

	//Creamos el JSON
	$json_string = json_encode($actualizar_bd);
	echo $json_string;
	ob_end_flush();
?>