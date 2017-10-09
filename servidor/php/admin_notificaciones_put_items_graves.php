<?php
	header("access-control-allow-origin: *");

	include ("conexion_BD.php");

	/*=============================================
	* SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LAS INSPECCIONES CON NUMERO DE ITEMS LEVES MAYORES A 9
  * O NUMERO DE ITEMS GRAVES O MUY GRAVES MAYORES DE CERO
  * OBTENIENDO POR CADA INSPECCION LA CANTIDAD DE DIAS TRANSCURRIDOS DESDE SU CARGA AL SISTEMA
  * SI LA CANTIDAD DE DIAS ESTA ENTRE 15 Y 30 SE AÑADE AL ARREGLO
	*==============================================*/
  $sql="SELECT *,DATEDIFF(now(),f_carga_servidor) AS cantidad_dias FROM auditoria_inspecciones_puertas WHERE v_item_leve>9 OR v_item_grave>0 OR v_item_muygrave>0 AND f_carga_servidor<>'0000-00-00 00:00:00' ORDER BY cantidad_dias";
  $result=mysqli_query($con, $sql);
  // $numero_inspecciones=mysqli_num_rows($result);
  $notificacion_inspecciones_puertas = array(); //creamos un array
  while($row = mysqli_fetch_array($result)){
  	$k_codusuario = $row['k_codusuario'];
  	$k_codinspeccion = $row['k_codinspeccion'];
    $v_item_leve = $row['v_item_leve'];
  	$v_item_grave = $row['v_item_grave'];
  	$v_item_muygrave = $row['v_item_muygrave'];
  	$f_carga_servidor = $row['f_carga_servidor'];
  	$cantidad_dias = $row['cantidad_dias'];
  	if ($cantidad_dias >= 15 && $cantidad_dias <= 30) {
  		$notificacion_inspecciones_puertas[] = array('k_codusuario'=> $k_codusuario,
                            													'k_codinspeccion'=> $k_codinspeccion,
                                                      'v_item_leve'=> $v_item_leve,
                            													'v_item_grave'=> $v_item_grave,
                            													'v_item_muygrave'=> $v_item_muygrave,
                            													'f_carga_servidor'=> $f_carga_servidor,
                            													'cantidad_dias'=> $cantidad_dias);
  	}
  }
	    
	//desconectamos la base de datos
	$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

	//Creamos el JSON
	$json_string = json_encode($notificacion_inspecciones_puertas);
	echo $json_string;
?>