<?php
  header("access-control-allow-origin: *");
  include ("conexion_BD.php");
  error_reporting(0); // Desactivar toda notificación de error - ya que por el foreach pone problema

  $objeto_json_AVA = $_POST['json_AVA'];
  $objeto_json_AVC = $_POST['json_AVC'];
  $objeto_json_AVE = $_POST['json_AVE'];
  $objeto_json_AVOF = $_POST['json_AVOF'];
  $objeto_json_AVF = $_POST['json_AVF'];
  $objeto_json_AVFG = $_POST['json_AVFG'];
  $objeto_json_AVI = $_POST['json_AVI'];
  $objeto_json_AVM = $_POST['json_AVM'];
  $objeto_json_AVP = $_POST['json_AVP'];
  $objeto_json_AVPRE = $_POST['json_AVPRE'];
  $objeto_json_AVPP = $_POST['json_AVPP'];

  $bandera_sql = 0;

  /*=============================================
  * Se guardan los respectivos valores en la tabla ascensor_valores_audios
  *==============================================*/
  //print_r($objeto_json_AVA);
  $array = json_decode($objeto_json_AVA);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $nombre_audio = $obj->nombre_audio;
    $nombre_directorio = $obj->nombre_directorio;
    $o_estado_envio = $obj->o_estado_envio;
    $sql="INSERT INTO ascensor_valores_audios(
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
      //echo $con->error."\nerror: ". $sql . "<br>";
      $bandera_sql += 1;
    }
  }

  /*=============================================
  * Se guardan los respectivos valores en la tabla ascensor_valores_fotografias
  *==============================================*/
  //print_r($objeto_json_AVFG);
  $array = json_decode($objeto_json_AVFG);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $nombre_fotografia = $obj->nombre_fotografia;
    $nombre_directorio = $obj->nombre_directorio;
    $o_estado_envio = $obj->o_estado_envio;
    $sql="INSERT INTO ascensor_valores_fotografias(
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
  * Se guardan los respectivos valores en la tabla ascensor_valores_preliminar
  *==============================================*/
  //print_r($objeto_json_AVPRE);
  $array = json_decode($objeto_json_AVPRE);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $calificacion = $obj->calificacion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM ascensor_valores_preliminar WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    
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
      $sql="UPDATE ascensor_valores_preliminar SET v_calificacion='".$calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem_preli=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO ascensor_valores_preliminar(
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
  * Se guardan los respectivos valores en la tabla ascensor_valores_proteccion
  *==============================================*/
  //print_r($objeto_json_AVPP);
  $array = json_decode($objeto_json_AVPP);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $seleccion_inspector = $obj->seleccion_inspector;
    $seleccion_empresa = $obj->seleccion_empresa;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM ascensor_valores_proteccion WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    //echo "\nnumero filas proteccion-> ".$rowcount;
    if($rowcount >= 7){
      //EXISTEN REGISTROS
      $sql="UPDATE ascensor_valores_proteccion SET v_sele_inspector='".$seleccion_inspector."',v_sele_empresa='".$seleccion_empresa."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO ascensor_valores_proteccion(
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
  * Se guardan los respectivos valores en la tabla ascensor_valores_elementos
  *==============================================*/
  //print_r($objeto_json_AVE);
  $array = json_decode($objeto_json_AVE);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $descripcion = $obj->descripcion;
    $seleccion = $obj->seleccion;
    $sql="SELECT * FROM ascensor_valores_elementos WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    //echo "\nnumero filas elementos-> ".$rowcount;
    if($rowcount >= 6){
      //EXISTEN REGISTROS
      $sql="UPDATE ascensor_valores_elementos SET o_descripcion='".$descripcion."',v_seleccion='".$seleccion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO ascensor_valores_elementos(
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
  * Se guardan los respectivos valores en la tabla ascensor_valores_iniciales
  *==============================================*/
  //print_r($objeto_json_AVI);
  //echo $array[0]->cod_inspeccion;
  $array = json_decode($objeto_json_AVI);
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cliente = $obj->cliente;
    $nombre_equipo = $obj->nombre_equipo;
    $empresa_mto = $obj->empresa_mto;
    $accionamiento = $obj->accionamiento;
    $capac_person = $obj->capac_person;
    $capac_peso = $obj->capac_peso;
    $num_paradas = $obj->num_paradas;
    $fecha = $obj->fecha;
    $codigo = $obj->codigo;
    $consecutivo = $obj->consecutivo;
    $ultimo_mto = $obj->ultimo_mto;
    $inicio_servicio = $obj->inicio_servicio;
    $ultima_inspeccion = $obj->ultima_inspeccion;
    $hora = $obj->hora;
    $tipo_informe = $obj->tipo_informe;
    $sql="SELECT * FROM ascensor_valores_iniciales WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 1){
      //EXISTEN REGISTROS
      $sql="UPDATE ascensor_valores_iniciales SET n_cliente='".$cliente."',n_equipo='".$nombre_equipo."',n_empresamto='".$empresa_mto."',o_tipoaccion='".$accionamiento."',v_capacperson=".$capac_person.",v_capacpeso=".$capac_peso.",v_paradas=".$num_paradas.",f_fecha='".$fecha."',v_codigo='".$codigo."',o_consecutivoinsp='".$consecutivo."',ultimo_mto='".$ultimo_mto."',inicio_servicio='".$inicio_servicio."',ultima_inspeccion='".$ultima_inspeccion."',h_hora='".$hora."',o_tipo_informe='".$tipo_informe."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO ascensor_valores_iniciales(
              k_codusuario,
              k_codinspeccion, 
              n_cliente,
              n_equipo,
              n_empresamto,
              o_tipoaccion,
              v_capacperson,
              v_capacpeso,
              v_paradas,
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
             '".$accionamiento."',
             ".$capac_person.",
             ".$capac_peso.",
             ".$num_paradas.",
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
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }
  } 

  /*=============================================
  * Se guardan los respectivos valores en la tabla ascensor_valores_cabina
  *==============================================*/
  //print_r($objeto_json_AVC);
  $array = json_decode($objeto_json_AVC);
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
    $sql="SELECT * FROM ascensor_valores_cabina WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 35){
      //EXISTEN REGISTROS
      $sql="UPDATE ascensor_valores_cabina SET n_calificacion='".$nombre_calificacion."',v_calificacion='".$valor_calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem_cabina=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO ascensor_valores_cabina(
                  k_codusuario,
                  k_codinspeccion,
                  k_coditem_cabina,
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
  * Se guardan los respectivos valores en la tabla ascensor_valores_maquinas
  *==============================================*/
  //print_r($objeto_json_AVM);
  $array = json_decode($objeto_json_AVM);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $nombre_calificacion = $obj->nombre_calificacion;
    $valor_calificacion = $obj->valor_calificacion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM ascensor_valores_maquinas WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 47){
      //EXISTEN REGISTROS
      $sql="UPDATE ascensor_valores_maquinas SET n_calificacion='".$nombre_calificacion."',v_calificacion='".$valor_calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO ascensor_valores_maquinas(
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
  * Se guardan los respectivos valores en la tabla ascensor_valores_pozo
  *==============================================*/
  //print_r($objeto_json_AVP);
  $array = json_decode($objeto_json_AVP);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $nombre_calificacion = $obj->nombre_calificacion;
    $valor_calificacion = $obj->valor_calificacion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM ascensor_valores_pozo WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 65){
      //EXISTEN REGISTROS
      $sql="UPDATE ascensor_valores_pozo SET n_calificacion='".$nombre_calificacion."',v_calificacion='".$valor_calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO ascensor_valores_pozo(
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
  * Se guardan los respectivos valores en la tabla ascensor_valores_foso
  *==============================================*/
  //print_r($objeto_json_AVF);
  $array = json_decode($objeto_json_AVF);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $cod_item = $obj->cod_item;
    $nombre_calificacion = $obj->nombre_calificacion;
    $valor_calificacion = $obj->valor_calificacion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM ascensor_valores_foso WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 29){
      //EXISTEN REGISTROS
      $sql="UPDATE ascensor_valores_foso SET n_calificacion='".$nombre_calificacion."',v_calificacion='".$valor_calificacion."',o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion." AND k_coditem=".$cod_item."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO ascensor_valores_foso(
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
  * Se guardan los respectivos valores en la tabla ascensor_valores_finales
  *==============================================*/
  //print_r($objeto_json_AVOF);
  $array = json_decode($objeto_json_AVOF);
  //echo $array[0]->cod_inspeccion;
  foreach($array as $obj){
    $cod_usuario = $obj->cod_usuario;
    $cod_inspeccion = $obj->cod_inspeccion;
    $observacion = $obj->observacion;
    $sql="SELECT * FROM ascensor_valores_finales WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
    $result=mysqli_query($con, $sql);
    $rowcount=mysqli_num_rows($result);
    if($rowcount >= 1){
      //EXISTEN REGISTROS
      $sql="UPDATE ascensor_valores_finales SET o_observacion='".$observacion."' WHERE k_codusuario=".$cod_usuario." AND k_codinspeccion=".$cod_inspeccion."";
      if (mysqli_query($con,$sql) == true){
        //echo "Registros guardados correctamente.";
        //$bandera_sql += 1;
      }else{
        //echo $con->error."\nerror: ". $sql . "<br>";
        $bandera_sql += 1;
      }
    }else{
      //NO EXISTEN REGISTROS
      $sql="INSERT INTO ascensor_valores_finales(
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