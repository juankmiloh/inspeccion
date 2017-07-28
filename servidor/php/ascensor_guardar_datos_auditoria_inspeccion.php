<?php
  header("access-control-allow-origin: *");
  include ("conexion_BD.php");

  $json_auditoria_ascensores = $_POST['json_auditoria_ascensores'];

  $bandera_sql = 0;

  /*=============================================
  * Se guardan los respectivos valores en la tabla cliente
  *==============================================*/     
  //print_r($json_auditoria_ascensores);
  $array = json_decode($json_auditoria_ascensores);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $consecutivoinsp = $obj->consecutivoinsp;
    $estado_envio = $obj->estado_envio;
    $revision = $obj->revision;
    $cantidad_item_nocumple = $obj->cantidad_item_nocumple;
    $codcliente = $obj->codcliente;
    $codinforme = $obj->codinforme;
    $k_codusuario_modifica = $obj->k_codusuario_modifica;
    $o_actualizar_inspeccion = $obj->o_actualizar_inspeccion;

    $sql="SELECT * FROM auditoria_inspecciones_ascensores v WHERE v.k_codusuario=".$cod_usuario." AND v.k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    
    if($rowcount >= 1){
      //EXISTEN REGISTROS
      $sql="UPDATE auditoria_inspecciones_ascensores SET o_consecutivoinsp='".$consecutivoinsp."',o_estado_envio='".$estado_envio."',o_revision='".$revision."',v_item_nocumple=".$cantidad_item_nocumple.",k_codcliente='".$codcliente."',k_codinforme='".$codinforme."',k_codusuario_modifica=".$k_codusuario_modifica.",o_actualizar_inspeccion='".$o_actualizar_inspeccion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO auditoria_inspecciones_ascensores(
                            k_codusuario,
                            k_codinspeccion, 
                            o_consecutivoinsp,
                            o_estado_envio,
                            o_revision,
                            v_item_nocumple,
                            k_codcliente,
                            k_codinforme,
                            k_codusuario_modifica,
                            o_actualizar_inspeccion,
                            f_carga_servidor) 
                    VALUES(".$cod_usuario.",
                           ".$cod_inspeccion.",   
                           '".$consecutivoinsp."',
                           '".$estado_envio."',
                           '".$revision."',
                           '".$cantidad_item_nocumple."',
                           '".$codcliente."',
                           '".$codinforme."',
                           ".$k_codusuario_modifica.",
                           '".$o_actualizar_inspeccion."',
                           now())";
      if (mysqli_query($con,$sql) == true){
        //echo "Consulta exitosa!";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }      
  }            

  echo $bandera_sql;
  //print_r($objeto_json_AVOF);
?>