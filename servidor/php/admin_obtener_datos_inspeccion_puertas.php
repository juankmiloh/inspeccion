<?php
	header("access-control-allow-origin: *");

	include ("conexion_BD.php");

	$codigo_inspector = $_POST['inspector'];
	$codigo_inspeccion = $_POST['inspeccion'];

	/*=============================================
	* SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA SABER CUANTAS INSPECCIONES A REALIZADO EL INSPECTOR
	*==============================================*/
	$sql="SELECT * FROM auditoria_inspecciones_puertas WHERE k_codusuario=".$codigo_inspector."";
    $result=mysqli_query($con, $sql);
    $numero_inspecciones=mysqli_num_rows($result);
    if (mysqli_query($con,$sql) == true){
      //echo "Consulta exitosa 1";
      //$bandera_sql += 1;
    }else{
      echo $con->error."\nerror: ". $sql . "<br>";
      $bandera_sql += 1;
    }

    /*=============================================
	* SE HACE UN SELECT A LA TABLA DE VALORES INICIALES PARA OBTENER LA FECHA DE LA INSPECCION
	*==============================================*/
    $sql="SELECT f_fecha FROM puertas_valores_iniciales WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
    $result=mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result)){
    	$fecha_inspeccion = $row['f_fecha'];
    }
    if (mysqli_query($con,$sql) == true){
      //echo "Consulta exitosa 2";
      //$bandera_sql += 1;
    }else{
      echo $con->error."\nerror: ". $sql . "<br>";
      $bandera_sql += 1;
    }

    /*=============================================
	* SE HACE UN PRIMER SELECT A LA TABLA DE AUDITORIA PARA OBTENER EL CODIGO DEL USUARIO QUE MODIFICA LA INSPECCIÓN
	* SI ESTA SE HA MODIFICADO ALGUNA VEZ CLARO ESTA, SINO SERA EL MISMO CODIGO ORIGINAL DEL INSPECTOR
	* TAMBIEN SE OBTIENE EL CODIGO DEL INFORME AL CUAL QUEDO LIGADA LA ULTIMA VEZ QUE SE HIZO LA INSPECCION
	*==============================================*/
	$sql = "SELECT * FROM auditoria_inspecciones_puertas WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
	$result=mysqli_query($con, $sql);
    while($row = mysqli_fetch_array($result)){
    	$k_codinforme = $row['k_codinforme'];
    	$k_codusuario_modifica = $row['k_codusuario_modifica'];
    }
    if (mysqli_query($con,$sql) == true){
      //echo "Consulta exitosa 3";
      //$bandera_sql += 1;
    }else{
      echo $con->error."\nerror: ". $sql . "<br>";
      $bandera_sql += 1;
    }

    /*=============================================
	* SE HACE UNA CONSULTA PARA OBTENER LOS NOMBRES DE LOS AUDIOS DEL INFORME GENERADO EL DIA DE LA INSPECCION
	* EL RESULTADO LO GUARDAMOS EN UN ARRAY PARA PODERLO CARGAR EN EL SELECT DE AUDIOS
	*==============================================*/
    $sql="SELECT informe_audios.n_audio nombre_audio FROM informe_valores_audios informe_audios,auditoria_inspecciones_puertas auditoria WHERE auditoria.k_codusuario_modifica=".$k_codusuario_modifica." AND auditoria.k_codinspeccion=".$codigo_inspeccion." AND informe_audios.k_codusuario=".$k_codusuario_modifica." AND auditoria.k_codinforme=informe_audios.k_codinforme AND informe_audios.k_codinforme=".$k_codinforme."";
    mysqli_set_charset($con, "utf8"); //formato de datos utf8

	if(!$result = mysqli_query($con, $sql)) die();

	$archivos_audio = array(); //creamos un array

	while($row = mysqli_fetch_array($result)){ 
	    $nombre_archivo = $row['nombre_audio'];
	    $archivos_audio[] = array('valor'=> $k_codusuario_modifica,
	    						  'texto'=> $nombre_archivo);
	}
	if (mysqli_query($con,$sql) == true){
      //echo "Consulta exitosa 4";
      //$bandera_sql += 1;
    }else{
      echo $con->error."\nerror: ". $sql . "<br>";
      $bandera_sql += 1;
    }
	//Creamos el JSON
	//$json_audios_informe = json_encode($archivos_audio);

	/*=============================================
	* SE HACE UN SELECT A LA TABLA DE FOTOGRAFIAS PARA SABER CUANTAS FOTOS HAY DE LA INSPECCION
	*==============================================*/
	$sql="SELECT * FROM puertas_valores_fotografias WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
    $result=mysqli_query($con, $sql);
    $cantidad_fotos=mysqli_num_rows($result);

	/*=============================================
	* SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LOS DATOS RELACIONADOS A LA INSPECCION
	* DEVOLVEMOS UN JSON CON LOS DATOS DE LA INSPECCION
	*==============================================*/
	$sql = "SELECT * FROM auditoria_inspecciones_puertas WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
	mysqli_set_charset($con, "utf8"); //formato de datos utf8

	if(!$result = mysqli_query($con, $sql)) die();

	$auditoria_inspecciones_puertas = array(); //creamos un array

	while($row = mysqli_fetch_array($result)){ 
	    $k_codusuario = $row['k_codusuario'];
	    $k_codinspeccion = $row['k_codinspeccion'];
	    $o_consecutivoinsp = $row['o_consecutivoinsp'];
	    $o_estado_envio = $row['o_estado_envio'];
	    $o_revision = $row['o_revision'];
	    $v_item_nocumple = $row['v_item_nocumple'];
	    $k_codcliente = $row['k_codcliente'];
	    $k_codinforme = $row['k_codinforme'];
	    $o_password_pdf = $row['o_password_pdf'];
	    
	    $auditoria_inspecciones_puertas[] = array('k_codusuario'=> $k_codusuario,
										 'k_codinspeccion'=> $k_codinspeccion,
										 'o_consecutivoinsp'=> $o_consecutivoinsp,
										 'o_estado_envio'=> $o_estado_envio,
										 'o_revision'=> $o_revision,
										 'v_item_nocumple'=> $v_item_nocumple,
										 'k_codcliente'=> $k_codcliente,
										 'k_codinforme'=> $k_codinforme,
										 'cantidad_inspecciones'=> $numero_inspecciones,
										 'fecha_inspeccion'=> $fecha_inspeccion,
										 'archivos_audio'=> $archivos_audio,
										 'cantidad_fotos'=> $cantidad_fotos,
										 'o_password_pdf'=> $o_password_pdf);
	}
	if (mysqli_query($con,$sql) == true){
      //echo "Consulta exitosa 5";
      //$bandera_sql += 1;
    }else{
      echo $con->error."\nerror: ". $sql . "<br>";
      $bandera_sql += 1;
    }
	    
	//desconectamos la base de datos
	$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

	//Creamos el JSON
	$json_string = json_encode($auditoria_inspecciones_puertas);
	echo $json_string;
?>