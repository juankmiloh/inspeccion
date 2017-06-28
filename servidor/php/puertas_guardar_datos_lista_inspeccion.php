<?php
  header("access-control-allow-origin: *");
  include ("conexion_BD.php");
  error_reporting(0); // Desactivar toda notificación de error

  $objeto_json_PVA = $_POST['json_PVA'];
  $objeto_json_PVM = $_POST['json_PVM'];
  $objeto_json_PVEL = $_POST['json_PVEL'];
  $objeto_json_PVMO = $_POST['json_PVMO'];
  $objeto_json_PVO = $_POST['json_PVO'];
  $objeto_json_PVMA = $_POST['json_PVMA'];
  $objeto_json_PVE = $_POST['json_PVE'];
  $objeto_json_PVOF = $_POST['json_PVOF'];
  $objeto_json_PVFG = $_POST['json_PVFG'];
  $objeto_json_PVI = $_POST['json_PVI'];
  $objeto_json_PVPRE = $_POST['json_PVPRE'];
  $objeto_json_PVPP = $_POST['json_PVPP'];

  $bandera_sql = 0;

  /*=============================================
  * Se guardan los respectivos valores en la tabla puertas_valores_audios
  *==============================================*/
  //print_r($objeto_json_PVA);
  $array = json_decode($objeto_json_PVA);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $nombre_audio = $obj->nombre_audio;
    $nombre_directorio = $obj->nombre_directorio;
    $o_estado_envio = $obj->o_estado_envio;
    $sql="INSERT INTO puertas_valores_audios(
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
  * Se guardan los respectivos valores en la tabla puertas_valores_fotografias
  *==============================================*/
  //print_r($objeto_json_PVFG);
  $array = json_decode($objeto_json_PVFG);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $nombre_fotografia = $obj->nombre_fotografia;
    $nombre_directorio = $obj->nombre_directorio;
    $o_estado_envio = $obj->o_estado_envio;
    $sql="INSERT INTO puertas_valores_fotografias(
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
      echo $con->error."\nerror: ". $sql . "<br>";
      $bandera_sql += 1;
    }
  }

  /*=============================================
  * Se guardan los respectivos valores en la tabla puertas_valores_preliminar
  *==============================================*/
  //print_r($objeto_json_PVPRE);
  $array = json_decode($objeto_json_PVPRE);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $calificacion = $obj->calificacion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM puertas_valores_preliminar WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    
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
      $sql="UPDATE puertas_valores_preliminar SET v_calificacion='".$calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem_preli=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO puertas_valores_preliminar(
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
        echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }
  }

  /*=============================================
  * Se guardan los respectivos valores en la tabla puertas_valores_proteccion
  *==============================================*/
  //print_r($objeto_json_PVPP);
  $array = json_decode($objeto_json_PVPP);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $seleccion_inspector = $obj->seleccion_inspector;
    $seleccion_empresa = $obj->seleccion_empresa;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM puertas_valores_proteccion WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    //echo "\nnumero filas proteccion-> ".$rowcount;
    if($rowcount >= 7){
      //EXISTEN REGISTROS
      $sql="UPDATE puertas_valores_proteccion SET v_sele_inspector='".$seleccion_inspector."',v_sele_empresa='".$seleccion_empresa."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO puertas_valores_proteccion(
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
  * Se guardan los respectivos valores en la tabla puertas_valores_elementos
  *==============================================*/
  //print_r($objeto_json_PVE);
  $array = json_decode($objeto_json_PVE);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $descripcion = $obj->descripcion;
    $seleccion = $obj->seleccion;
    $sql="SELECT * FROM puertas_valores_elementos WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    //echo "\nnumero filas elementos-> ".$rowcount;
    if($rowcount >= 6){
      //EXISTEN REGISTROS
      $sql="UPDATE puertas_valores_elementos SET o_descripcion='".$descripcion."',v_seleccion='".$seleccion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO puertas_valores_elementos(
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
  * Se guardan los respectivos valores en la tabla puertas_valores_iniciales
  *==============================================*/
  //print_r($objeto_json_PVI);
  //echo $array[0]->cod_inspeccion;
  $array = json_decode($objeto_json_PVI);
  foreach($array as $obj){
    $k_codusuario = $obj->k_codusuario;
    $k_codinspeccion = $obj->k_codinspeccion;
    $n_cliente = $obj->n_cliente;
    $n_equipo = $obj->n_equipo;
    $n_empresamto = $obj->n_empresamto;
    $o_desc_puerta = $obj->o_desc_puerta;
    $o_tipo_puerta = $obj->o_tipo_puerta;
    $o_motorizacion = $obj->o_motorizacion;
    $o_acceso = $obj->o_acceso;
    $o_accionamiento = $obj->o_accionamiento;
    $o_operador = $obj->o_operador;
    $o_hoja = $obj->o_hoja;
    $o_transmision = $obj->o_transmision;
    $o_identificacion = $obj->o_identificacion;
    $f_fecha = $obj->f_fecha;
    $v_ancho = $obj->v_ancho;
    $v_alto = $obj->v_alto;
    $v_codigo = $obj->v_codigo;
    $o_consecutivoinsp = $obj->o_consecutivoinsp;
    $ultimo_mto = $obj->ultimo_mto;
    $inicio_servicio = $obj->inicio_servicio;
    $ultima_inspeccion = $obj->ultima_inspeccion;
    $h_hora = $obj->h_hora;
    $tipo_informe = $obj->o_tipo_informe;
    $sql="SELECT * FROM puertas_valores_iniciales WHERE k_codusuario=".$k_codusuario." AND k_codinspeccion=".$k_codinspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 1){
      //EXISTEN REGISTROS
      $sql="UPDATE puertas_valores_iniciales SET n_cliente='".$n_cliente."',
                                                 n_equipo = '".$n_equipo."',
                                                 n_empresamto = '".$n_empresamto."',
                                                 o_desc_puerta = '".$o_desc_puerta."',
                                                 o_tipo_puerta = '".$o_tipo_puerta."',
                                                 o_motorizacion = '".$o_motorizacion."',
                                                 o_acceso = '".$o_acceso."',
                                                 o_accionamiento = '".$o_accionamiento."',
                                                 o_operador = '".$o_operador."',
                                                 o_hoja = '".$o_hoja."',
                                                 o_transmision = '".$o_transmision."',
                                                 o_identificacion = '".$o_identificacion."',
                                                 f_fecha = '".$f_fecha."',
                                                 v_ancho = ".$v_ancho.",
                                                 v_alto = ".$v_alto.",
                                                 v_codigo = '".$v_codigo."',
                                                 o_consecutivoinsp = '".$o_consecutivoinsp."',
                                                 ultimo_mto = '".$ultimo_mto."',
                                                 inicio_servicio = '".$inicio_servicio."',
                                                 ultima_inspeccion = '".$ultima_inspeccion."',
                                                 h_hora = '".$h_hora."',
                                                 o_tipo_informe = '".$tipo_informe."' 
                                              WHERE k_codusuario = ".$k_codusuario." 
                                              AND k_codinspeccion = ".$k_codinspeccion."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO puertas_valores_iniciales(
              k_codusuario,
              k_codinspeccion,
              n_cliente,
              n_equipo,
              n_empresamto,
              o_desc_puerta,
              o_tipo_puerta,
              o_motorizacion,
              o_acceso,
              o_accionamiento,
              o_operador,
              o_hoja,
              o_transmision,
              o_identificacion,
              f_fecha,
              v_ancho,
              v_alto,
              v_codigo,
              o_consecutivoinsp,
              ultimo_mto,
              inicio_servicio,
              ultima_inspeccion,
              h_hora,
              o_tipo_informe)
      VALUES(".$k_codusuario.",
            ".$k_codinspeccion.",
            '".$n_cliente."',
            '".$n_equipo."',
            '".$n_empresamto."',
            '".$o_desc_puerta."',
            '".$o_tipo_puerta."',
            '".$o_motorizacion."',
            '".$o_acceso."',
            '".$o_accionamiento."',
            '".$o_operador."',
            '".$o_hoja."',
            '".$o_transmision."',
            '".$o_identificacion."',
            '".$f_fecha."',
            ".$v_ancho.",
            ".$v_alto.",
            '".$v_codigo."',
            '".$o_consecutivoinsp."',
            '".$ultimo_mto."',
            '".$inicio_servicio."',
            '".$ultima_inspeccion."',
            '".$h_hora."',
            '".$tipo_informe."')";
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
  * Se guardan los respectivos valores en la tabla puertas_valores_mecanicos
  *==============================================*/
  //print_r($objeto_json_PVM);
  $array = json_decode($objeto_json_PVM);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $nombre_calificacion = $obj->nombre_calificacion;
    $valor_calificacion = $obj->valor_calificacion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM puertas_valores_mecanicos WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 37){
      //EXISTEN REGISTROS
      $sql="UPDATE puertas_valores_mecanicos SET n_calificacion='".$nombre_calificacion."',v_calificacion='".$valor_calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO puertas_valores_mecanicos(
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
  * Se guardan los respectivos valores en la tabla puertas_valores_electrica
  *==============================================*/
  //print_r($objeto_json_PVEL);
  $array = json_decode($objeto_json_PVEL);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $nombre_calificacion = $obj->nombre_calificacion;
    $valor_calificacion = $obj->valor_calificacion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM puertas_valores_electrica WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 5){
      //EXISTEN REGISTROS
      //print_r($objeto_json_PVEL);
      $sql="UPDATE puertas_valores_electrica SET n_calificacion='".$nombre_calificacion."',v_calificacion='".$valor_calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO puertas_valores_electrica(
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
  * Se guardan los respectivos valores en la tabla puertas_valores_motorizacion
  *==============================================*/
  //print_r($objeto_json_PVMO);
  $array = json_decode($objeto_json_PVMO);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $nombre_calificacion = $obj->nombre_calificacion;
    $valor_calificacion = $obj->valor_calificacion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM puertas_valores_motorizacion WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 12){
      //EXISTEN REGISTROS
      $sql="UPDATE puertas_valores_motorizacion SET n_calificacion='".$nombre_calificacion."',v_calificacion='".$valor_calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO puertas_valores_motorizacion(
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
  * Se guardan los respectivos valores en la tabla puertas_valores_otras
  *==============================================*/
  //print_r($objeto_json_PVO);
  $array = json_decode($objeto_json_PVO);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $nombre_calificacion = $obj->nombre_calificacion;
    $valor_calificacion = $obj->valor_calificacion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM puertas_valores_otras WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 21){
      //EXISTEN REGISTROS
      $sql="UPDATE puertas_valores_otras SET n_calificacion='".$nombre_calificacion."',v_calificacion='".$valor_calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO puertas_valores_otras(
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
  * Se guardan los respectivos valores en la tabla puertas_valores_maniobras
  *==============================================*/
  //print_r($objeto_json_PVMA);
  $array = json_decode($objeto_json_PVMA);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $nombre_calificacion = $obj->nombre_calificacion;
    $valor_calificacion = $obj->valor_calificacion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM puertas_valores_maniobras WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 11){
      //EXISTEN REGISTROS
      $sql="UPDATE puertas_valores_maniobras SET n_calificacion='".$nombre_calificacion."',v_calificacion='".$valor_calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO puertas_valores_maniobras(
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
  * Se guardan los respectivos valores en la tabla puertas_valores_finales
  *==============================================*/
  //print_r($objeto_json_PVOF);
  $array = json_decode($objeto_json_PVOF);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM puertas_valores_finales WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 1){
      //EXISTEN REGISTROS
      $sql="UPDATE puertas_valores_finales SET o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO puertas_valores_finales(
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
  //print_r($objeto_json_AVOF);
?>