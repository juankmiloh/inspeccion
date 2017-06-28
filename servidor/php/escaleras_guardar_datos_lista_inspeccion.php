<?php
  header("access-control-allow-origin: *");
  include ("conexion_BD.php");
  error_reporting(0); // Desactivar toda notificación de error

  $objeto_json_EVA = $_POST['json_EVA'];
  $objeto_json_EVD = $_POST['json_EVD'];
  $objeto_json_EVE = $_POST['json_EVE'];
  $objeto_json_EVOF = $_POST['json_EVOF'];
  $objeto_json_EVFG = $_POST['json_EVFG'];
  $objeto_json_EVI = $_POST['json_EVI'];
  $objeto_json_EVPRE = $_POST['json_EVPRE'];
  $objeto_json_EVPP = $_POST['json_EVPP'];

  $bandera_sql = 0;

  /*=============================================
  * Se guardan los respectivos valores en la tabla escaleras_valores_audios
  *==============================================*/
  //print_r($objeto_json_EVA);
  $array = json_decode($objeto_json_EVA);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $nombre_audio = $obj->nombre_audio;
    $nombre_directorio = $obj->nombre_directorio;
    $o_estado_envio = $obj->o_estado_envio;
    $sql="INSERT INTO escaleras_valores_audios(
                        k_codusuario,
                        k_codinspeccion,
                        n_audio,
                        n_directorio,
                        o_estado_envio) 
                VALUES(".$cod_usuario.",
                       ".$cod_inspeccion.",
                       '".$nombre_audio."',
                       '".$nombre_directorio."',
                       '".$o_estado_envio."')";
    if (mysqli_query($con,$sql) == true){
      //echo "Registros guardados correctamente.";
      //$bandera_sql += 1;
    }else{
      echo $con->error."\nerror: ". $sql . "<br>";
      $bandera_sql += 1;
    }
  }

  /*=============================================
  * Se guardan los respectivos valores en la tabla escaleras_valores_fotografias
  *==============================================*/
  //print_r($objeto_json_EVFG);
  $array = json_decode($objeto_json_EVFG);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $nombre_fotografia = $obj->nombre_fotografia;
    $nombre_directorio = $obj->nombre_directorio;
    $o_estado_envio = $obj->o_estado_envio;
    $sql="INSERT INTO escaleras_valores_fotografias(
                        k_codusuario,
                        k_codinspeccion,
                        k_coditem,
                        n_fotografia,
                        n_directorio,
                        o_estado_envio)
                VALUES(".$cod_usuario.",
                       ".$cod_inspeccion.",                                       
                       ".$cod_item.",
                       '".$nombre_fotografia."',
                       '".$nombre_directorio."',
                       '".$o_estado_envio."')";
    if (mysqli_query($con,$sql) == true){
      //echo "Registros guardados correctamente.";
      //$bandera_sql += 1;
    }else{
      //echo $con->error."\nerror: ". $sql . "<br>";
      $bandera_sql += 1;
    }
  }

  /*=============================================
  * Se guardan los respectivos valores en la tabla escaleras_valores_preliminar
  *==============================================*/
  //print_r($objeto_json_EVPRE);
  $array = json_decode($objeto_json_EVPRE);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $calificacion = $obj->calificacion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM escaleras_valores_preliminar WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    
    if (mysqli_query($con,$sql) == true){
      //echo "Registros guardados correctamente.";
      $result=mysqli_query($con, $sql);
      $rowcount=mysqli_num_rows($result);
      //$bandera_sql += 1;
    }else{
      //echo $con->error."\nerror: ". $sql . "<br>";
      $bandera_sql += 1;
    }
    
    //echo "\nnumero filas preliminar-> ".$rowcount;
    if($rowcount >= 3){
      //EXISTEN REGISTROS
      $sql="UPDATE escaleras_valores_preliminar SET v_calificacion='".$calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem_preli=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO escaleras_valores_preliminar(
                    k_codusuario,
                    k_codinspeccion, 
                    k_coditem_preli,
                    v_calificacion,
                    o_observacion) 
            VALUES(".$cod_usuario.",
                   ".$cod_inspeccion.",                                       
                   ".$cod_item.",
                   '".$calificacion."',
                   '".$observacion."')";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }
  }

  /*=============================================
  * Se guardan los respectivos valores en la tabla escaleras_valores_proteccion
  *==============================================*/
  //print_r($objeto_json_EVPP);
  $array = json_decode($objeto_json_EVPP);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $seleccion_inspector = $obj->seleccion_inspector;
    $seleccion_empresa = $obj->seleccion_empresa;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM escaleras_valores_proteccion WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    //echo "\nnumero filas proteccion-> ".$rowcount;
    if($rowcount >= 7){
      //EXISTEN REGISTROS
      $sql="UPDATE escaleras_valores_proteccion SET v_sele_inspector='".$seleccion_inspector."',v_sele_empresa='".$seleccion_empresa."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO escaleras_valores_proteccion(
                    k_codusuario,
                    k_codinspeccion, 
                    k_coditem,
                    v_sele_inspector,
                    v_sele_empresa,
                    o_observacion) 
            VALUES(".$cod_usuario.",
                   ".$cod_inspeccion.",                                       
                   ".$cod_item.",
                   '".$seleccion_inspector."',
                   '".$seleccion_empresa."',
                   '".$observacion."')";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }
  }

  /*=============================================
  * Se guardan los respectivos valores en la tabla escaleras_valores_elementos
  *==============================================*/
  //print_r($objeto_json_EVE);
  $array = json_decode($objeto_json_EVE);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $descripcion = $obj->descripcion;
    $seleccion = $obj->seleccion;
    $sql="SELECT * FROM escaleras_valores_elementos WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    //echo "\nnumero filas elementos-> ".$rowcount;
    if($rowcount >= 6){
      //EXISTEN REGISTROS
      $sql="UPDATE escaleras_valores_elementos SET o_descripcion='".$descripcion."',v_seleccion='".$seleccion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO escaleras_valores_elementos(
                          k_codusuario,
                          k_codinspeccion,
                          k_coditem,
                          o_descripcion,
                          v_seleccion) 
                  VALUES(".$cod_usuario.",
                         ".$cod_inspeccion.",                                       
                         ".$cod_item.",
                         '".$descripcion."',
                         '".$seleccion."')";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }
  }

  /*=============================================
  * Se guardan los respectivos valores en la tabla escaleras_valores_iniciales
  *==============================================*/
  //print_r($objeto_json_EVI);
  //echo $array[0]->cod_inspeccion;
  $array = json_decode($objeto_json_EVI);
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cliente = $obj->cliente;
    $nombre_equipo = $obj->nombre_equipo;
    $empresa_mto = $obj->empresa_mto;
    $velocidad = $obj->velocidad;
    $tipo_equipo = $obj->tipo_equipo;
    $inclinacion = $obj->inclinacion;
    $ancho_paso = $obj->ancho_paso;
    $fecha = $obj->fecha;
    $codigo = $obj->codigo;
    $consecutivo = $obj->consecutivo;
    $ultimo_mto = $obj->ultimo_mto;
    $inicio_servicio = $obj->inicio_servicio;
    $ultima_inspeccion = $obj->ultima_inspeccion;
    $hora = $obj->hora;
    $tipo_informe = $obj->tipo_informe;
    $sql="SELECT * FROM escaleras_valores_iniciales WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 1){
      //EXISTEN REGISTROS
      $sql="UPDATE escaleras_valores_iniciales SET n_cliente='".$cliente."',
                                                  n_equipo='".$nombre_equipo."',
                                                  n_empresamto='".$empresa_mto."',
                                                  v_velocidad=".$velocidad.",
                                                  o_tipo_equipo='".$tipo_equipo."',
                                                  v_inclinacion=".$inclinacion.",
                                                  v_ancho_paso=".$ancho_paso.",
                                                  f_fecha='".$fecha."',
                                                  v_codigo='".$codigo."',
                                                  o_consecutivoinsp='".$consecutivo."',
                                                  ultimo_mto='".$ultimo_mto."',
                                                  inicio_servicio='".$inicio_servicio."',
                                                  ultima_inspeccion='".$ultima_inspeccion."',
                                                  h_hora='".$hora."',
                                                  o_tipo_informe='".$tipo_informe."' 
                                                  WHERE k_codusuario=".$cod_usuario." 
                                                  AND k_codinspeccion=".$cod_inspeccion."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO escaleras_valores_iniciales(
              k_codusuario,
              k_codinspeccion, 
              n_cliente,
              n_equipo,
              n_empresamto,
              v_velocidad,
              o_tipo_equipo,
              v_inclinacion,
              v_ancho_paso,
              f_fecha,
              v_codigo,
              o_consecutivoinsp,
              ultimo_mto,
              inicio_servicio,
              ultima_inspeccion,
              h_hora,
              o_tipo_informe)
      VALUES(".$cod_usuario.",
             ".$cod_inspeccion.",                                       
             '".$cliente."',
             '".$nombre_equipo."',
             '".$empresa_mto."',
             ".$velocidad.",
             '".$tipo_equipo."',
             ".$inclinacion.",
             ".$ancho_paso.",
             '".$fecha."',
             '".$codigo."',
             '".$consecutivo."',
             '".$ultimo_mto."',
             '".$inicio_servicio."',
             '".$ultima_inspeccion."',
             '".$hora."',
             '".$tipo_informe."')";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }
  } 

  /*=============================================
  * Se guardan los respectivos valores en la tabla escaleras_valores_defectos
  *==============================================*/
  //print_r($objeto_json_EVD);
  $array = json_decode($objeto_json_EVD);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $marcador_it_leve="";
    $marcador_it_grave="";
    $marcador_it_muy_grave="";

    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $nombre_calificacion = $obj->nombre_calificacion;
    $valor_calificacion = $obj->valor_calificacion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM escaleras_valores_defectos WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 93){
      //EXISTEN REGISTROS
      $sql="UPDATE escaleras_valores_defectos SET n_calificacion='".$nombre_calificacion."',v_calificacion='".$valor_calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO escaleras_valores_defectos(
                  k_codusuario,
                  k_codinspeccion,
                  k_coditem,
                  n_calificacion,
                  v_calificacion,
                  o_observacion) 
          VALUES(".$cod_usuario.",
                 ".$cod_inspeccion.",                                       
                 ".$cod_item.",
                 '".$nombre_calificacion."',
                 '".$valor_calificacion."',
                 '".$observacion."')";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }
  }

  /*=============================================
  * Se guardan los respectivos valores en la tabla escaleras_valores_finales
  *==============================================*/
  //print_r($objeto_json_EVOF);
  $array = json_decode($objeto_json_EVOF);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM escaleras_valores_finales WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 1){
      //EXISTEN REGISTROS
      $sql="UPDATE escaleras_valores_finales SET o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO escaleras_valores_finales(
                    k_codusuario,
                    k_codinspeccion,
                    o_observacion) 
            VALUES(".$cod_usuario.",
                   ".$cod_inspeccion.",
                   '".$observacion."')";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }
  }

  echo $bandera_sql;
  //print_r($objeto_json_EVOF);
?>