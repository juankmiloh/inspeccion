<?php
      header("access-control-allow-origin: *");
      header("Content-Type: text/html; charset=iso-8859-1");
      include ("conexion_BD.php");

      $codigo_inspector = $_POST['codigo_inspector'];

      $objeto_json_cliente = $_POST['json_cliente'];
      $objeto_json_informe = $_POST['json_informe'];
      $json_informe_audios = $_POST['json_IVA'];

      $bandera_sql = 0;

      /*=============================================
      * Se guardan los respectivos valores en la tabla cliente
      *==============================================*/     
      //print_r($objeto_json_cliente);
      $array = json_decode($objeto_json_cliente);
      //echo $array[0]->cod_inspeccion;
      foreach($array as $obj){
            $cod_cliente = $obj->cod_cliente;
            $consecutivo = $obj->consecutivo;
            $k_codusuario = $obj->k_codusuario;
            $nombre = $obj->nombre;
            $contacto = $obj->contacto;
            $nit = $obj->nit;
            $direccion = $obj->direccion;
            $telefono = $obj->telefono;
            $correo = $obj->correo;
            $n_encargado = $obj->n_encargado;
            $sql="INSERT INTO cliente(
                                k_codcliente,
                                v_consecutivocliente,
                                k_codusuario,
                                n_cliente, 
                                n_contacto,
                                v_nit,
                                o_direccion,
                                o_telefono,
                                o_correo,
                                n_encargado) 
                        VALUES(".$cod_cliente.",
                               '".$consecutivo."',
                               ".$k_codusuario.",   
                               '".$nombre."',
                               '".$contacto."',
                               '".$nit."',
                               '".$direccion."',
                               '".$telefono."',
                               '".$correo."',
                               '".$n_encargado."')";
            if (mysqli_query($con,$sql) == true){
                  //echo "Registros guardados correctamente.";
                  //$bandera_sql += 1;
            }else{
                  //echo $con->error."\nerror: ". $sql . "<br>";
                  $bandera_sql += 1;
            }
      }     
      
      /*=============================================
      * Se guardan los respectivos valores en la tabla informe
      *==============================================*/     
      //print_r($objeto_json_informe);
      $array = json_decode($objeto_json_informe);
      //echo $array[0]->cod_inspeccion;
      foreach($array as $obj){
            $cod_informe = $obj->cod_informe;
            $consecutivo = $obj->consecutivo;
            $cod_usuario = $obj->cod_usuario;
            $fecha = $obj->fecha;
            $sql="INSERT INTO informe(
                                k_codinforme,
                                v_consecutivoinforme,
                                k_codusuario, 
                                f_informe) 
                        VALUES(".$cod_informe.",
                               '".$consecutivo."',   
                               '".$cod_usuario."',
                               '".$fecha."')";
            if (mysqli_query($con,$sql) == true){
                  //echo "Registros guardados correctamente.";
                  //$bandera_sql += 1;
            }else{
                  //echo $con->error."\nerror: ". $sql . "<br>";
                  $bandera_sql += 1;
            }
      }

      /*=============================================
      * Se guardan los respectivos valores en la tabla informe_valores_audios
      *==============================================*/ 
      //print_r($json_informe_audios);
      $array = json_decode($json_informe_audios);
      //echo $array[0]->cod_inspeccion;
      foreach($array as $obj){
        $cod_usuario = $obj->cod_usuario;
        $cod_informe = $obj->cod_informe;
        $nombre_audio = $obj->nombre_audio;
        $nombre_directorio = $obj->nombre_directorio;
        $o_estado_envio = $obj->o_estado_envio;
        $sql="INSERT INTO informe_valores_audios(
                              k_codusuario,
                              k_codinforme,
                              n_audio,
                              n_directorio,
                              o_estado_envio)
                      VALUES(".$cod_usuario.",
                             '".$cod_informe."',
                             '".$nombre_audio."',
                             '".$nombre_directorio."',
                             '".$o_estado_envio."')";
        mysqli_set_charset($con, "utf8"); //formato de datos utf8
        if (mysqli_query($con,$sql) == true){
          //echo "Registros guardados correctamente.";
          //$bandera_sql += 1;
        }else{
          //echo $con->error."\nerror: ". $sql . "<br>";
          $bandera_sql += 1;
        }
      }

      echo $bandera_sql;
      //print_r($objeto_json_cliente);
?>