<?php
	header("access-control-allow-origin: *");

	include ("conexion_BD.php");

  $notificacion_puertas = array(); //creamos un array

	/*=============================================
	* SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LAS INSPECCIONES CON NUMERO DE ITEMS LEVES MAYORES A 9
  * O NUMERO DE ITEMS GRAVES O MUY GRAVES MAYORES DE CERO
  * OBTENIENDO POR CADA INSPECCION LA CANTIDAD DE DIAS TRANSCURRIDOS DESDE SU CARGA AL SISTEMA
  * SI LA CANTIDAD DE DIAS ESTA ENTRE 15 Y 30 SE AÑADE AL ARREGLO
	*==============================================*/
  $sql="SELECT *,DATEDIFF(now(),f_carga_servidor) AS cantidad_dias FROM auditoria_inspecciones_puertas WHERE v_item_leve>9 OR v_item_grave>0 OR v_item_muygrave>0 AND f_carga_servidor<>'0000-00-00 00:00:00' ORDER BY cantidad_dias";
  $result=mysqli_query($con, $sql);
  $cantidad_inspecciones_graves=0;
  $notificacion_puertas_graves = array(); //creamos un array
  while($row = mysqli_fetch_array($result)){
  	$cantidad_dias = $row['cantidad_dias'];
  	if ($cantidad_dias >= 15 && $cantidad_dias <= 30) {
      $cantidad_inspecciones_graves += 1;
  	}
  }

  $notificacion_puertas[] = array('id'=> 'puertas_cantidad_inspecciones_graves',
                                  'descripcion'=> 'Plazo 30 días - SEGUNDA REVISIÓN',
                                  'text'=> 'Número de inspecciones con plazo 30 días para corregir defectos graves, faltando menos de 15 días para la segunda revisión.',
                                  'cantidad'=> $cantidad_inspecciones_graves);

  /*=============================================
  * SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LAS INSPECCIONES CON CANTIDAD DE ITEMS LEVES MENORES A 9
  * O NUMERO DE ITEMS GRAVES O MUY GRAVES IGUALES A CERO
  * OBTENIENDO POR CADA INSPECCION LA CANTIDAD DE DIAS TRANSCURRIDOS DESDE SU CARGA AL SISTEMA
  * SI LA CANTIDAD DE DIAS ESTA ENTRE 165 Y 180 SE AÑADE AL ARREGLO
  *==============================================*/
  $sql="SELECT *,DATEDIFF(now(),f_carga_servidor) AS cantidad_dias FROM auditoria_inspecciones_puertas WHERE v_item_leve>0 AND v_item_leve<10 AND v_item_grave=0 AND v_item_muygrave=0 AND f_carga_servidor<>'0000-00-00 00:00:00' ORDER BY cantidad_dias";
  $result=mysqli_query($con, $sql);
  $cantidad_inspecciones_leves=0;
  while($row = mysqli_fetch_array($result)){
    $cantidad_dias = $row['cantidad_dias'];
    if ($cantidad_dias >= 165 && $cantidad_dias <= 180) {
      $cantidad_inspecciones_leves += 1;
    }
  }

  $notificacion_puertas[] = array('id'=> 'puertas_cantidad_inspecciones_leves',
                                  'descripcion'=> 'Plazo 180 días - SEGUNDA REVISIÓN',
                                  'text'=> 'Número de inspecciones con plazo 180 días para corregir hasta 9 defectos leves, faltando menos de 15 días para la segunda revisión.',
                                  'cantidad'=> $cantidad_inspecciones_leves);

  /*=============================================
  * SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LAS INSPECCIONES CON NUMERO DE ITEMS LEVES MAYORES A 9
  * O NUMERO DE ITEMS GRAVES O MUY GRAVES MAYORES DE CERO
  * OBTENIENDO POR CADA INSPECCION LA CANTIDAD DE DIAS TRANSCURRIDOS DESDE SU CARGA AL SISTEMA
  * SI LA CANTIDAD DE DIAS ES MAYOR A 30 SE AÑADE AL ARREGLO INDICANDO QUE EL TIEMPO DE PLAZO YA ESTA VENCIDO
  *==============================================*/
  $sql="SELECT *,DATEDIFF(now(),f_carga_servidor) AS cantidad_dias FROM auditoria_inspecciones_puertas WHERE v_item_leve>9 OR v_item_grave>0 OR v_item_muygrave>0 AND f_carga_servidor<>'0000-00-00 00:00:00' ORDER BY cantidad_dias";
  $result=mysqli_query($con, $sql);
  $cantidad_inspecciones_graves_vencidas=0;
  while($row = mysqli_fetch_array($result)){
    $cantidad_dias = $row['cantidad_dias'];
    if ($cantidad_dias > 30) {
      $cantidad_inspecciones_graves_vencidas += 1;
    }
  }

  /*=============================================
  * SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LAS INSPECCIONES CON CANTIDAD DE ITEMS LEVES MENORES A 9
  * O NUMERO DE ITEMS GRAVES O MUY GRAVES IGUALES A CERO
  * OBTENIENDO POR CADA INSPECCION LA CANTIDAD DE DIAS TRANSCURRIDOS DESDE SU CARGA AL SISTEMA
  * SI LA CANTIDAD DE DIAS ES MAYOR A 180 SE AÑADE AL ARREGLO LO QUE INDICA QUE EL TIEMPO DE PLAZO ESTA VENCIDO
  *==============================================*/
  $sql="SELECT *,DATEDIFF(now(),f_carga_servidor) AS cantidad_dias FROM auditoria_inspecciones_puertas WHERE v_item_leve>0 AND v_item_leve<10 AND v_item_grave=0 AND v_item_muygrave=0 AND f_carga_servidor<>'0000-00-00 00:00:00' ORDER BY cantidad_dias";
  $result=mysqli_query($con, $sql);
  $cantidad_inspecciones_leves_vencidas = 0;
  while($row = mysqli_fetch_array($result)){
    $cantidad_dias = $row['cantidad_dias'];
    if ($cantidad_dias > 180) {
      $cantidad_inspecciones_leves_vencidas += 1;
    }
  }

  $cantidad_inspecciones_vencidas = ($cantidad_inspecciones_graves_vencidas + $cantidad_inspecciones_leves_vencidas);

  $notificacion_puertas[] = array('id'=> 'puertas_cantidad_inspecciones_vencidas',
                                  'descripcion'=> 'Plazo vencido - SEGUNDA REVISIÓN',
                                  'text'=> 'Número de inspecciones con plazo cumplido para corregir defectos, en espera de segunda revisión.',
                                  'cantidad'=> $cantidad_inspecciones_vencidas);

  /*=============================================
  * SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LAS INSPECCIONES CON CANTIDAD DE ITEMS NO CUMPLE IGUAL A CERO
  * Y CON 30 DIAS O MENOS PARA CUMPLIR EL AÑO DE CERTIFICACION
  *==============================================*/
  $sql="SELECT *,DATEDIFF(now(),f_carga_servidor) AS cantidad_dias FROM auditoria_inspecciones_puertas WHERE v_item_nocumple=0 AND f_carga_servidor<>'0000-00-00 00:00:00' ORDER BY cantidad_dias";
  $result=mysqli_query($con, $sql);
  $cantidad_certificados_x_vencer = 0;
  while($row = mysqli_fetch_array($result)){
    $cantidad_dias = $row['cantidad_dias'];
    if ($cantidad_dias >= 335 && $cantidad_dias <= 365) {
      $cantidad_certificados_x_vencer += 1;
    }
  }

  $notificacion_puertas[] = array('id'=> 'puertas_cantidad_certificados_x_vencer',
                                  'descripcion'=> 'X vencer - INSPECCIONES CERTIFICADAS',
                                  'text'=> 'Número de inspecciones certificadas faltando 30 días o menos para cumplir el año de certificación.',
                                  'cantidad'=> $cantidad_certificados_x_vencer);

  /*=============================================
  * SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LAS INSPECCIONES CON CANTIDAD DE ITEMS NO CUMPLE IGUAL A CERO
  * Y CON EL AÑO DE CERTIFICACION CUMPLIDO
  *==============================================*/
  $sql="SELECT *,DATEDIFF(now(),f_carga_servidor) AS cantidad_dias FROM auditoria_inspecciones_puertas WHERE v_item_nocumple=0 AND f_carga_servidor<>'0000-00-00 00:00:00' ORDER BY cantidad_dias";
  $result=mysqli_query($con, $sql);
  $cantidad_certificados_vencidos = 0;
  while($row = mysqli_fetch_array($result)){
    $cantidad_dias = $row['cantidad_dias'];
    if ($cantidad_dias > 365) {
      $cantidad_certificados_vencidos += 1;
    }
  }

  $notificacion_puertas[] = array('id'=> 'puertas_cantidad_certificados_vencidos',
                                  'descripcion'=> 'Vencidas - INSPECCIONES CERTIFICADAS',
                                  'text'=> 'Número de inspecciones con año de certificación cumplido.',
                                  'cantidad'=> $cantidad_certificados_vencidos);
	    
	//desconectamos la base de datos
	$close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

	//Creamos el JSON
	$json_string = json_encode($notificacion_puertas);
	echo $json_string;
?>