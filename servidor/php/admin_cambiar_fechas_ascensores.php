<?php
	header("access-control-allow-origin: *");

	include ("conexion_BD.php");

  $notificacion_ascensores = array(); //creamos un array

  /*=============================================
  * 
  *==============================================*/
  $contador = 0;
  $sql="SELECT * FROM auditoria_inspecciones_ascensores WHERE f_carga_servidor='0000-00-00 00:00:00' AND k_codusuario<>3 ORDER BY k_codusuario";
  $result=mysqli_query($con, $sql);
  $numero_registros_mal=mysqli_num_rows($result);
  while($row = mysqli_fetch_array($result)){
    $k_codusuario = $row['k_codusuario'];
    $k_codinspeccion = $row['k_codinspeccion'];
    $f_carga_servidor = $row['f_carga_servidor'];
    echo "k_codusuario ".$k_codusuario." k_codinspeccion ".$k_codinspeccion."<br>";
    $sql1="SELECT * FROM ascensor_valores_iniciales WHERE k_codusuario=".$k_codusuario." AND k_codinspeccion=".$k_codinspeccion."";
    $result1=mysqli_query($con, $sql1);
    while($row1 = mysqli_fetch_array($result1)){
      $contador += 1;
      $k_codusuario = $row1['k_codusuario'];
      $k_codinspeccion = $row1['k_codinspeccion'];
      $f_fecha = $row1['f_fecha'];
      echo "k_codusuario ".$k_codusuario." k_codinspeccion ".$k_codinspeccion."<br>";
      $notificacion_ascensores[] = array('k_codusuario'=> $k_codusuario,
                                         'k_codinspeccion'=> $k_codinspeccion,
                                         'f_fecha'=> $f_fecha);
      $sql2="UPDATE auditoria_inspecciones_ascensores SET f_carga_servidor='".$f_fecha."' WHERE k_codusuario=".$k_codusuario." AND k_codinspeccion=".$k_codinspeccion."";
      if (mysqli_query($con,$sql2) == true){
        
        echo $contador.". Registro actualizado con éxito!<br>";
      }
    }
  }
  
  echo "<br>Número de registros sin fecha -> ".$numero_registros_mal."<br>";
  echo "Cantidad de registros afectados -> ".$contador;
  //Creamos el JSON
  $json_string = json_encode($notificacion_ascensores);
  // echo $json_string;
?>