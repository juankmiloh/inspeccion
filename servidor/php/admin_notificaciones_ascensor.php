<?php
	header("access-control-allow-origin: *");

	include ("conexion_BD.php");

  $notificacion_ascensores = array(); //creamos un array

  /*=============================================
  * SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LAS INSPECCIONES CON CANTIDAD DE ITEMS NOCUMPLE MAYORES A 0
  * OBTENIENDO POR CADA INSPECCION LA CANTIDAD DE DIAS TRANSCURRIDOS DESDE SU CARGA AL SISTEMA
  * SI LA CANTIDAD DE DIAS ESTA ENTRE 165 Y 180 SE AÑADE AL ARREGLO
  *==============================================*/
  $sql="SELECT *,DATEDIFF(now(),f_carga_servidor) AS cantidad_dias FROM auditoria_inspecciones_ascensores WHERE v_item_nocumple>0 AND f_carga_servidor<>'0000-00-00 00:00:00' ORDER BY cantidad_dias";
  $result=mysqli_query($con, $sql);
  $ascensor_cantidad_items_nocumple=0;
  while($row = mysqli_fetch_array($result)){
    $cantidad_dias = $row['cantidad_dias'];
    if ($cantidad_dias >= 150 && $cantidad_dias <= 180) {
      $ascensor_cantidad_items_nocumple += 1;
    }
  }

  $notificacion_ascensores[] = array('id'=> 'ascensor_cantidad_items_nocumple',
                                     'descripcion'=> 'Plazo 180 días - SEGUNDA REVISIÓN',
                                     'text'=> 'Número de inspecciones con plazo 180 días para corregir inconformidades, faltando 30 días o menos para la segunda revisión.',
                                     'cantidad'=> $ascensor_cantidad_items_nocumple);

  /*=============================================
  * SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LAS INSPECCIONES CON CANTIDAD DE ITEMS NOCUMPLE MAYORES A 0
  * OBTENIENDO POR CADA INSPECCION LA CANTIDAD DE DIAS TRANSCURRIDOS DESDE SU CARGA AL SISTEMA
  * SI LA CANTIDAD DE DIAS ES MAYOR A 180 (6 MESES) SE AÑADE AL ARREGLO LO QUE INDICA QUE EL TIEMPO DE PLAZO ESTA VENCIDO
  *==============================================*/
  $sql="SELECT *,DATEDIFF(now(),f_carga_servidor) AS cantidad_dias FROM auditoria_inspecciones_ascensores WHERE v_item_nocumple>0 AND f_carga_servidor<>'0000-00-00 00:00:00' ORDER BY cantidad_dias";
  $result=mysqli_query($con, $sql);
  $ascensor_cantidad_items_nocumple_vencidos = 0;
  while($row = mysqli_fetch_array($result)){
    $cantidad_dias = $row['cantidad_dias'];
    if ($cantidad_dias > 180) {
      $ascensor_cantidad_items_nocumple_vencidos += 1;
    }
  }

  $notificacion_ascensores[] = array('id'=> 'ascensor_cantidad_items_nocumple_vencidos',
                                     'descripcion'=> 'Plazo vencido - SEGUNDA REVISIÓN',
                                     'text'=> 'Número de inspecciones con plazo cumplido para corregir defectos, en espera de segunda revisión.',
                                     'cantidad'=> $ascensor_cantidad_items_nocumple_vencidos);

  /*=============================================
  * SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LAS INSPECCIONES CON CANTIDAD DE ITEMS NO CUMPLE IGUAL A CERO
  * Y CON 30 DIAS O MENOS PARA CUMPLIR EL AÑO DE CERTIFICACION
  *==============================================*/
  $sql="SELECT *,DATEDIFF(now(),f_carga_servidor) AS cantidad_dias FROM auditoria_inspecciones_ascensores WHERE v_item_nocumple=0 AND f_carga_servidor<>'0000-00-00 00:00:00' ORDER BY cantidad_dias";
  $result=mysqli_query($con, $sql);
  $cantidad_certificados_x_vencer = 0;
  while($row = mysqli_fetch_array($result)){
    $cantidad_dias = $row['cantidad_dias'];
    if ($cantidad_dias >= 335 && $cantidad_dias <= 365) {
      $cantidad_certificados_x_vencer += 1;
    }
  }

  $notificacion_ascensores[] = array('id'=> 'ascensor_cantidad_certificados_x_vencer',
                                     'descripcion'=> 'X vencer - INSPECCIONES CERTIFICADAS',
                                     'text'=> 'Número de inspecciones certificadas faltando 30 días o menos para cumplir el año de certificación.',
                                     'cantidad'=> $cantidad_certificados_x_vencer);

  /*=============================================
  * SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LAS INSPECCIONES CON CANTIDAD DE ITEMS NO CUMPLE IGUAL A CERO
  * Y CON EL AÑO DE CERTIFICACION CUMPLIDO
  *==============================================*/
  $sql="SELECT *,DATEDIFF(now(),f_carga_servidor) AS cantidad_dias FROM auditoria_inspecciones_ascensores WHERE v_item_nocumple=0 AND f_carga_servidor<>'0000-00-00 00:00:00' ORDER BY cantidad_dias";
  $result=mysqli_query($con, $sql);
  $cantidad_certificados_vencidos = 0;
  while($row = mysqli_fetch_array($result)){
    $cantidad_dias = $row['cantidad_dias'];
    if ($cantidad_dias > 365) {
      $cantidad_certificados_vencidos += 1;
    }
  }

  $notificacion_ascensores[] = array('id'=> 'ascensor_cantidad_certificados_vencidos',
                                     'descripcion'=> 'Vencidas - INSPECCIONES CERTIFICADAS',
                                     'text'=> 'Número de inspecciones con año de certificación cumplido.',
                                     'cantidad'=> $cantidad_certificados_vencidos);
	    
	//desconectamos la base de datos
	$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

	//Creamos el JSON
	$json_string = json_encode($notificacion_ascensores);
	echo $json_string;
?>