<?php
      ob_start(); //Linea para permitir enviar flujo de datos por url al redireccionar la pagina
      header("access-control-allow-origin: *");
      include ("conexion_BD.php");
      require_once("./dompdf/dompdf_config.inc.php");

      $codigo_inspector = $_POST['codigo_inspector'];
      $codigo_inspector_dispositivo = $_POST['codigo_inspector_dispositivo'];
      $codigo_inspeccion = $_POST['codigo_inspeccion'];
      $fecha_emision = $_POST['fecha_emision'];
      $mensaje_servidor = $_POST['servidor'];

      $contador_it_leve=0;
      $contador_it_grave=0;
      $contador_it_muy_grave=0;

      $bandera_sql = 0;
      
      /*=============================================
      * Consulta SQL a la tabla puertas_valores_iniciales
      *==============================================*/
      $sql = "SELECT * FROM puertas_valores_iniciales WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
      $result = mysqli_query($con, $sql);
      while ($row=mysqli_fetch_array($result)) {
            $nombre_cliente = $row['n_cliente'];
            $fecha_inspeccion = $row['f_fecha'];
            $consecutivo_inspeccion = $row['o_consecutivoinsp'];
            $nombre_equipo = $row['n_equipo']; //identificacion de equipo
            $tipo_informe = $row['o_tipo_informe'];
            $empresa_mto = $row['n_empresamto'];
            $desc_puerta = $row['o_desc_puerta'];
            $ultimo_mto = $row['ultimo_mto'];
            $inicio_servicio = $row['inicio_servicio'];
            $ultima_inspeccion = $row['ultima_inspeccion'];            
            $tipo_puerta = $row['o_tipo_puerta'];
            $motorizacion = $row['o_motorizacion'];
            $acceso = $row['o_acceso'];
            $accionamiento = $row['o_accionamiento'];
            $operador = $row['o_operador'];
            $hoja = $row['o_hoja'];
            $transmision = $row['o_transmision'];
            $identificacion = $row['o_identificacion']; //en caso de existir varias
            $ancho = $row['v_ancho'];
            $alto = $row['v_alto'];            
      }
      if (mysqli_query($con,$sql) == true){
            //echo "Consulta exitosa!";
            //$bandera_sql += 1;
      }else{
            //echo $con->error."\nerror: ". $sql . "<br>";
            $bandera_sql += 1;
      }
      
      /*=============================================
      * Consulta SQL a la tabla cliente - auditoria_inspecciones_puertas para obtener los datos del cliente relacionado a la inspeccion
      *==============================================*/
      $sql = "SELECT c.n_cliente nombre,c.n_contacto contacto,c.v_nit nit,c.o_direccion direccion,c.o_telefono telefono,c.n_encargado encargado from cliente c,auditoria_inspecciones_puertas a WHERE a.k_codcliente=c.k_codcliente AND a.k_codusuario=".$codigo_inspector." AND a.k_codinspeccion=".$codigo_inspeccion."";
      $result = mysqli_query($con, $sql);
      while ($row=mysqli_fetch_array($result)) {
            $contacto_cliente = $row['contacto'];
            $nit_cliente = $row['nit'];
            $direccion_cliente = $row['direccion'];
            $telefono_cliente = $row['telefono'];
            $encargado_emp_mto = $row['encargado'];
      }
      if (mysqli_query($con,$sql) == true){
            //echo "Consulta exitosa!";
            //$bandera_sql += 1;
      }else{
            //echo $con->error."\nerror: ". $sql . "<br>";
            $bandera_sql += 1;
      }   

      /*=============================================
      * Consulta SQL a la tabla puertas_valores_finales para obtener la observacion final
      *==============================================*/
      $sql="SELECT puertas_valores_finales.o_observacion observacion FROM puertas_valores_finales WHERE puertas_valores_finales.k_codusuario=".$codigo_inspector." AND puertas_valores_finales.k_codinspeccion=".$codigo_inspeccion."";
      $result = mysqli_query($con, $sql);
      while ($row=mysqli_fetch_array($result)) {
            $observacion_final = $row['observacion'];
      }
      if (mysqli_query($con,$sql) == true){
            //echo "Consulta exitosa!";
            //$bandera_sql += 1;
      }else{
            //echo $con->error."\nerror: ". $sql . "<br>";
            $bandera_sql += 1;
      }

      /*========================================================================
      * Vamos a crear el PDF de la inspeccion para previamente enviarlo por correo
      *========================================================================*/
?>
<html lang="es">
      <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
            <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
            <style>
                  html{font-family:sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}
                  body{margin:0;}
                  table{border-spacing:0;border-collapse:collapse;font-size:11px;width: 100%;}td,th{padding:0}
                  .centrar_texto{text-align: center;}
                  .text-justify{text-align:justify}
                  .borde{border: 1px solid #000000; color: black;}
                  .border-left{border-left: 1px solid #000000; color: black;}
                  .border-right{border-right: 1px solid #000000; color: black;}
                  .border-top{border-top: 1px solid #000000; color: black;}
                  .border-bottom{border-bottom: 1px solid #000000; color: black;}
                  .imagen_X{background: url(../images/x.png) no-repeat center center;} /* ESTILO DE IMAGEN QUE SE MUESTRA EN LOS ITEM NOCUMPLE */
            </style>
      </head>

      <body>
            <table border="0">
                  <tr>
                        <td style="text-align: left; width: 50px; height: 100px;">
                              <img src="../images/banner.png" alt="M.P SAS" width="270px" style="height: 70px;">
                        </td>
                        <td class="centrar_texto" style="width: 220px;">
                              <?php
                                    if ($mensaje_servidor != "si") {
                                          echo "<b>INFORME DE INSPECCIÓN PUERTAS ELÉCTRICAS AUTOMÁTICAS EN SITIO</b><br>";
                                    }else{
                                          echo "<b>INFORME FINAL DE INSPECCIÓN PUERTAS ELÉCTRICAS AUTOMÁTICAS</b><br>";
                                    }
                              ?>
                              Registro del sistema Integrado de Gestión
                        </td>
                        <td class="centrar_texto">
                              <br>
                        </td>
                        <td>
                              <table>
                                    <tr>
                                          <td>
                                                CÓDIGO
                                          </td>
                                          <td class="centrar_texto">
                                                <?php
                                                      if ($mensaje_servidor != "si") {
                                                            echo "IN-R-14"; //EN SITIO
                                                      }else{
                                                            echo "IN-R-13"; //FINAL
                                                      }
                                                ?>
                                          </td>
                                    </tr>
                                    <tr>
                                          <td>
                                                VERSIÓN
                                          </td>
                                          <td class="centrar_texto">
                                                <?php
                                                      if ($mensaje_servidor != "si") {
                                                            echo "01"; //EN SITIO
                                                      }else{
                                                            echo "02"; //FINAL
                                                      }
                                                ?>
                                          </td>
                                    </tr>
                                    <tr>
                                          <td>
                                                FECHA
                                          </td>
                                          <td class="centrar_texto">
                                                <?php
                                                      if ($mensaje_servidor != "si") {
                                                            echo "15/01/2015"; //EN SITIO
                                                      }else{
                                                            echo "30/07/2015"; //FINAL
                                                      }
                                                ?>
                                          </td>
                                    </tr>
                              </table>
                        </td>
                  </tr>
            </table>
            <br>
            <div class="border-top border-bottom border-left border-right">
                  <table border="0"> 
                        <tr>
                              <td class="border-top" style="height: 0.3%;"></td>
                        </tr>
                  </table>

                  <table>
                        <tr>
                              <td colspan="6" bgcolor="#97ad93" class="centrar_texto border-top border-bottom border-left border-right">
                                    <b>ACTA DE INSPECCIÓN PUERTAS</b>
                              </td>
                        </tr>
                        <tr>
                              <td class="border-top border-left" style="width: 17%;">
                                    Fecha de Inspección:
                              </td>
                              <td class="centrar_texto border-top border-left border-right" style="width: 17%;">
                                    <?php echo $fecha_inspeccion ?>
                              </td>
                              <td class="border-top" style="width: 16%;">
                                    Consecutivo:
                              </td>
                              <td class="centrar_texto border-top border-left border-right" style="width: 17%;">
                                    <?php echo $consecutivo_inspeccion ?>
                              </td>
                              <td class="border-top" style="width: 16%;">
                                    Fecha de emisión:
                              </td>
                              <td class="centrar_texto border-top border-left border-right" style="width: 17%;">
                                    <?php echo $fecha_emision ?>
                              </td>
                        </tr>
                  </table>
                  <table border="0">
                        <tr>
                              <td class="border-top border-left" style="width: 25%;">
                                    Emitido por:
                              </td>
                              <td class="centrar_texto border-top border-left border-right" style="width: 25%;">
                                    <?php
                                          if ($mensaje_servidor != "si") {
                                                $sql="SELECT * FROM usuarios WHERE k_codusuario=".$codigo_inspector_dispositivo."";
                                                $result = mysqli_query($con, $sql);
                                                while ($row=mysqli_fetch_array($result)) {
                                                      $nombre_inspector = strtoupper($row['n_nombre'])." ".strtoupper($row['n_apellido']);
                                                }
                                                echo $nombre_inspector;
                                          }else{
                                                echo "ING. ROBINSON CARDENAS";
                                          }
                                    ?>
                              </td>
                              <td class="border-top" style="width: 25%;">
                                    Identificación del equipo
                              </td>
                              <td class="centrar_texto border-top border-left border-right" style="width: 25%;">
                                    <?php echo $nombre_equipo ?>
                              </td>
                        </tr>
                  </table>
                  <table>
                        <tr>
                              <td class="border-top border-left" style="width: 25%;">
                                    Informe Inicial (X)
                              </td>
                              <td class="centrar_texto border-top border-left border-right" style="width: 8%;">
                                    <?php
                                          if ($tipo_informe == "Inicial") {
                                                echo "X";
                                          }
                                    ?>
                              </td>
                              <td class="border-top" style="width: 25%;">
                                    Informe Revisión (X)
                              </td>
                              <td class="centrar_texto border-top border-left border-right" style="width: 8%;">
                                    <?php
                                          if ($tipo_informe == "Revisión") {
                                                echo "X";
                                          }
                                    ?>
                              </td>
                              <td class="border-top" style="width: 25%;">
                                    Informe que modifica
                              </td>
                              <td class="centrar_texto border-top border-left border-right" style="width: 9%;">
                                    <?php
                                          if ($tipo_informe == "Modifica") {
                                                echo "X";
                                          }
                                    ?>
                              </td>
                        </tr>
                  </table>
                  <table>
                        <tr>
                              <td colspan="6" bgcolor="#97ad93" class="centrar_texto border-top border-bottom border-left border-right">
                                    <b>DATOS DEL CLIENTE</b>
                              </td>
                        </tr>

                        <tr>
                              <td class="border-left" colspan="2">
                                    Nombre del cliente o Razón Social
                              </td>
                              <td colspan="4" class="centrar_texto border-left border-right">
                                    <?php echo $nombre_cliente ?>
                              </td>
                        </tr>

                        <tr>
                              <td colspan="1" class="border-top border-left">
                                    Dirección
                              </td>
                              <td colspan="2" class="centrar_texto border-top border-left border-right">
                                    <?php echo $direccion_cliente ?>
                              </td>
                              <td colspan="1" class="border-top">
                                    Teléfono
                              </td>
                              <td colspan="2" class="centrar_texto border-top border-left border-right">
                                    <?php echo $telefono_cliente ?>
                              </td>
                        </tr>

                        <tr>
                              <td colspan="1" class="border-top border-left" style="width: 25%;">
                                    Contacto Representante Legal
                              </td>
                              <td colspan="2" class="centrar_texto border-top border-left border-right" style="width: 25%;">
                                    <?php echo $contacto_cliente ?>
                              </td>
                              <td colspan="1" class="border-top" style="width: 25%;">
                                    Nit o Documento de Identidad
                              </td>
                              <td colspan="2" class="centrar_texto border-top border-left border-right" style="width: 25%;">
                                    <?php echo $nit_cliente ?>
                              </td>
                        </tr>
                  </table>
                  <table>
                        <tr>
                              <td colspan="4" bgcolor="#97ad93" class="centrar_texto border-top border-bottom border-left border-right">
                                    <b>DATOS DE LA EMPRESA DE MANTENIMIENTO</b>
                              </td>
                        </tr>
                        <tr>
                              <td class="border-left" style="width: 25%;">
                                    Nombre o razón social
                              </td>
                              <td class="centrar_texto border-left border-right" style="width: 25%;">
                                    <?php echo $empresa_mto ?>
                              </td>
                              <td style="width: 25%;">
                                    Fecha de Último Mantenimiento
                              </td>
                              <td class="centrar_texto border-left border-right" style="width: 25%;">
                                    <?php echo $ultimo_mto ?>
                              </td>
                        </tr>
                  </table>
                  <table>
                        <tr>
                              <td colspan="4" bgcolor="#97ad93" class="centrar_texto border-top border-bottom border-left border-right">
                                    <b>DATOS DE LA INSTALACION</b>
                              </td>
                        </tr>
                        <tr>
                              <td class="border-left" style="width: 25%;">
                                    Fecha puesta en servicio
                              </td>
                              <td class="centrar_texto border-left border-right" style="width: 25%;">
                                    <?php echo $inicio_servicio ?>
                              </td>
                              <td style="width: 25%;">
                                    Fecha Última inspección
                              </td>
                              <td class="centrar_texto border-left border-right" style="width: 25%;">
                                    <?php echo $ultima_inspeccion ?>
                              </td>
                        </tr>
                  </table>
                  <table>
                        <tr>
                              <td colspan="2" bgcolor="#97ad93" class="centrar_texto border-top border-bottom border-left border-right">
                                    <b>CARACTERISTICAS TÉCNICAS</b>
                              </td>
                        </tr>

                        <tr>
                              <td class="border-left" style="width: 25%;">
                                    Descripción de la puerta
                              </td>
                              <td class="centrar_texto border-left border-right">
                                    <strong><?php echo $desc_puerta ?></strong>
                              </td>
                        </tr>
                  </table>
                  <table>
                        <tr>
                              <td style="width: 45%;">
                                    <table>
                                          <tr>
                                                <td colspan="4" class="border-top border-left border-bottom" style="padding-left: 40px;">
                                                      Tipo de puerta:
                                                </td>
                                          </tr>
                                          <tr>
                                                <td class="border-left" style="padding-left: 15px;">
                                                      Basculante
                                                </td>
                                                <td>
                                                      <?php
                                                            if ($tipo_puerta == "Basculante") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                                <td>
                                                      Plegable
                                                </td>
                                                <td>
                                                      <?php
                                                            if ($tipo_puerta == "Plegable") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td class="border-left" style="padding-left: 15px;">
                                                      Batiente
                                                </td>
                                                <td>
                                                      <?php
                                                            if ($tipo_puerta == "Batiente") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                                <td>
                                                      Seccional
                                                </td>
                                                <td>
                                                      <?php
                                                            if ($tipo_puerta == "Seccional") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td class="border-left" style="padding-left: 15px;">
                                                      Corredera
                                                </td>
                                                <td>
                                                      <?php
                                                            if ($tipo_puerta == "Corredera") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                                <td>
                                                      Peatonal
                                                </td>
                                                <td>
                                                      <?php
                                                            if ($tipo_puerta == "Peatonal") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td class="border-left" style="padding-left: 15px;"> 
                                                      Enrollable
                                                </td>
                                                <td>
                                                      <?php
                                                            if ($tipo_puerta == "Enrollable") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                                <td>
                                                      Otra
                                                </td>
                                                <td>
                                                      <?php
                                                            if ($tipo_puerta == "Otra") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                    </table>
                              </td>
                              <td style="width: 25%;">
                                    <table>
                                          <tr>
                                                <td colspan="2" class="centrar_texto border-top border-left border-right border-bottom">
                                                      Motorización:
                                                </td>
                                          </tr>
                                          <tr>
                                                <td class="border-left" style="padding-left: 15px;">
                                                      Electromecánica
                                                </td>
                                                <td class="border-right">
                                                     <?php
                                                            if ($motorizacion == "Electromecánica") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td class="border-left" style="padding-left: 15px;">
                                                      Hidráulica
                                                </td>
                                                <td class="border-right">
                                                     <?php
                                                            if ($motorizacion == "Hidráulica") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td class="border-left" style="padding-left: 15px;">
                                                      Neumática
                                                </td>
                                                <td class="border-right">
                                                     <?php
                                                            if ($motorizacion == "Neumática") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td class="border-left" style="padding-left: 15px;">
                                                      Otra
                                                </td>
                                                <td class="border-right">
                                                     <?php
                                                            if ($motorizacion == "Otra") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                    </table>
                              </td>
                              <td style="width: 30%;">
                                    <table>
                                          <tr>
                                                <td colspan="2" class="border-top border-right border-bottom">
                                                      Control de acceso:
                                                </td>
                                          </tr>
                                          <tr>
                                                <td style="padding-left: 15px;">
                                                      Estación de mando
                                                </td>
                                                <td class="border-right">
                                                      <?php
                                                            if ($acceso == "Estación de mando") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td style="padding-left: 15px;">
                                                      Sensores de proximidad
                                                </td>
                                                <td class="border-right">
                                                      <?php
                                                            if ($acceso == "Sensores de proximidad") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td style="padding-left: 15px;">
                                                      Otro
                                                </td>
                                                <td class="border-right">
                                                      <?php
                                                            if ($acceso == "Otro") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                          <tr>
                                                <td>
                                                      <br>
                                                </td>
                                                <td class="border-right">
                                                      <br>
                                                </td>
                                          </tr>
                                    </table>
                              </td>
                        </tr>
                  </table>
                  <table>
                        <tr>
                              <td class="border-top border-left">
                                    Tipo de accionamiento:
                              </td>
                              <td class="border-top border-right">
                                    <?php echo $accionamiento ?>
                              </td>
                              <td class="border-top">
                                    Marca de Operador:
                              </td>
                              <td class="border-top">
                                    <?php echo $operador ?>
                              </td>    
                              <td class="border-top border-left">
                                    Hoja Ciega:
                              </td>
                              <td class="border-top">
                                    <?php
                                          if ($hoja == "Hoja Ciega") {
                                                echo "X";
                                          }
                                    ?>
                              </td>
                              <td class="border-top">
                                    Hoja Barrotes:
                              </td>
                              <td class="border-top border-right">
                                    <?php
                                          if ($hoja == "Hoja Barrotes") {
                                                echo "X";
                                          }
                                    ?>
                              </td>       
                        </tr>
                  </table>
                  <table>
                        <tr>
                              <td style="width: 30%;" class="border-top">
                                    <table>
                                          <tr>
                                                <td colspan="4" class="border-left border-right">
                                                      Paso Libre:
                                                </td>
                                          </tr>
                                    </table>
                                    <table>
                                          <tr>
                                                <td class="border-left">
                                                      Ancho:
                                                </td>
                                                <td>
                                                      <?php echo $ancho ?>CM
                                                </td>
                                                <td>
                                                      Alto:
                                                </td>
                                                <td class="border-right">
                                                      <?php echo $alto ?>M
                                                </td>
                                          </tr>
                                    </table>
                              </td>
                              <td style="width: 30%;" class="border-top">
                                    <table>
                                          <tr>
                                                <td class="border-left" style="width: 80%;">
                                                      Sin transmisión por cadena:
                                                </td>
                                                <td class="centrar_texto" style="width: 20%;">
                                                     <?php
                                                            if ($transmision == "Sin transmisión por cadena") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                    </table>
                                    <table>
                                          <tr>
                                                <td class="border-left" style="width: 25%;">
                                                      Un lado:
                                                </td>
                                                <td style="width: 20%;">
                                                     <?php
                                                            if ($transmision == "Un lado") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                                <td style="width: 30%;">
                                                      Dos lados:
                                                </td>
                                                <td class="border-right" style="width: 25%;">
                                                      <?php
                                                            if ($transmision == "Dos lados") {
                                                                  echo "X";
                                                            }
                                                      ?>
                                                </td>
                                          </tr>
                                    </table>
                              </td>
                              <td style="width: 40%;" class="border-top">
                                    <table>
                                          <tr>
                                                <td class="border-left border-right">
                                                      Identificación de la puerta eléctrica: (en caso de existir
                                                </td>
                                          </tr>
                                          <tr>
                                                <td class="border-right">
                                                      varias) <?php echo $identificacion ?>
                                                </td>
                                          </tr>
                                    </table>
                              </td>
                        </tr>
                  </table>

                  <table>
                        <tr>
                              <td colspan="3" bgcolor="#97ad93" class="centrar_texto border-top border-bottom border-left border-right">
                                    <b>LISTA DE VERIFICACIÓN</b>
                              </td>
                        </tr>

                        <tr>
                              <td class="centrar_texto border-top border-left border-right" style="width: 33%;">
                                    <b>Descripción del defecto</b>  
                              </td>
                              <td style="width: 33%;">
                                   <table>
                                          <tr>
                                                <td colspan="3" class="centrar_texto">
                                                      <b>CON DEFECTO</b>    
                                                </td>
                                          </tr>
                                          <tr>
                                                <td class="centrar_texto border-top" style="width: 11%;">
                                                      <b>Leve</b>
                                                </td>
                                                <td class="centrar_texto border-left border-top" style="width: 11%;">
                                                      <b>Grave</b>
                                                </td>
                                                <td class="centrar_texto border-top border-left" style="width: 11%;">
                                                      <b>Muy Grave</b>
                                                </td>
                                          </tr>
                                   </table> 
                              </td>
                              <td class="centrar_texto border-top border-left border-right" style="width: 34%;">
                                    <b>Observaciones</b>
                              </td>
                        </tr>
                  </table>                  
<?php
      /*=============================================
      * Consulta SQL a la tabla puertas_valores_mecanicos
      *==============================================*/
      for ($i=1; $i <= 37; $i++) {
            $sql="SELECT item.k_coditem_puertas numero_item,item.o_descripcion descripcion,valor.n_calificacion clasificacion,valor.v_calificacion calificacion,valor.o_observacion observacion FROM puertas_items_mecanicos item,puertas_valores_mecanicos valor WHERE valor.k_codusuario=".$codigo_inspector." AND valor.k_codinspeccion=".$codigo_inspeccion." AND valor.k_coditem=".$i." AND item.k_coditem_puertas=valor.k_coditem";
            $result = mysqli_query($con, $sql);
            while ($row=mysqli_fetch_array($result)) {
                  $numero_item = $row['numero_item'];
                  $descripcion = $row['descripcion'];
                  $clasificacion = $row['clasificacion'];
                  $calificacion = $row['calificacion'];
                  $observacion = $row['observacion'];
            }
            if (mysqli_query($con,$sql) == true){
                  //echo "Consulta exitosa!.";
                  if ($calificacion == "No Cumple") {
                        if ($clasificacion == "L") {
                              $contador_it_leve+=1;
                              $marcador_it_leve="X";
                              $marcador_it_grave="";
                              $marcador_it_muy_grave="";
                        } elseif ($clasificacion == "G") {
                              $contador_it_grave+=1;
                              $marcador_it_leve="";
                              $marcador_it_grave="X";
                              $marcador_it_muy_grave="";
                        } elseif ($clasificacion == "MG") {
                              $contador_it_muy_grave+=1;
                              $marcador_it_leve="";
                              $marcador_it_grave="";
                              $marcador_it_muy_grave="X";
                        }
?>
                        <table>
                              <tr>
                                    <td class="border-top border-bottom border-left" style="text-align: center; width: 4%;">
                                          <b><?php echo $numero_item; ?></b>
                                    </td>
                                    <td valign="top" class="text-justify border-top border-left border-right border-bottom" style="margin: 14px; padding: 15px; width: 29%;">
                                          <?php echo $descripcion ?>      
                                    </td>  
                                    <td class="centrar_texto border-top border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_leve; ?></b>
                                    </td>
                                    <td class="centrar_texto border-left border-top border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_grave; ?></b>
                                    </td>
                                    <td class="centrar_texto border-top border-left border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_muy_grave; ?></b>
                                    </td>
                                    <td valign="top" class="text-justify border-top border-left border-bottom border-right" style="width: 34%; margin: 14px; padding: 15px;">
                                          <?php
                                                if ($observacion == "") {
                                                      echo $observacion;
                                                }else{
                                                      echo $observacion."<br><br>";
                                                }                                                
                                                /* Consulta para mostrar las fotos relacionadas a la inspeccion */
                                                $sql="SELECT n_fotografia FROM puertas_valores_fotografias WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion." AND k_coditem=".$i."";
                                                $result = mysqli_query($con, $sql);
                                                $numero_fotos=mysqli_num_rows($result);
                                                if ($numero_fotos > 0) {
                                                      echo "<b>Ver imagen:</b><br>";
                                                      while ($row=mysqli_fetch_array($result)) {
                                                            $n_fotografia = $row['n_fotografia'];
                                                            echo $n_fotografia."<br>";
                                                            // echo '<a href="http://192.168.0.26:8888/inspeccion/servidor/puertas/inspector_'.$codigo_inspector.'/fotografias/'.$n_fotografia.'">
                                                            //             '.$n_fotografia.'
                                                            //       </a>';
                                                      }
                                                }
                                          ?>
                                    </td>
                              </tr>
                        </table>
<?php
                  }
            }else{
                  //echo $con->error."\nerror: ". $sql . "<br>";
                  $bandera_sql += 1;
            }
      }                                
?>

<?php
      /*=============================================
      * Consulta SQL a la tabla puertas_valores_electrica
      *==============================================*/
      for ($i=38; $i <= 42; $i++) {
            $sql="SELECT item.k_coditem_electrica numero_item,item.o_descripcion descripcion,valor.n_calificacion clasificacion,valor.v_calificacion calificacion,valor.o_observacion observacion FROM puertas_items_electrica item,puertas_valores_electrica valor WHERE valor.k_codusuario=".$codigo_inspector." AND valor.k_codinspeccion=".$codigo_inspeccion." AND valor.k_coditem=".$i." AND item.k_coditem_electrica=valor.k_coditem";
            $result = mysqli_query($con, $sql);
            while ($row=mysqli_fetch_array($result)) {
                  $numero_item = $row['numero_item'];
                  $descripcion = $row['descripcion'];
                  $clasificacion = $row['clasificacion'];
                  $calificacion = $row['calificacion'];
                  $observacion = $row['observacion'];
            }
            if (mysqli_query($con,$sql) == true){
                  //echo "Consulta exitosa!.";
                  if ($calificacion == "No Cumple") {
                        if ($clasificacion == "L") {
                              $contador_it_leve+=1;
                              $marcador_it_leve="X";
                              $marcador_it_grave="";
                              $marcador_it_muy_grave="";
                        } elseif ($clasificacion == "G") {
                              $contador_it_grave+=1;
                              $marcador_it_leve="";
                              $marcador_it_grave="X";
                              $marcador_it_muy_grave="";
                        } elseif ($clasificacion == "MG") {
                              $contador_it_muy_grave+=1;
                              $marcador_it_leve="";
                              $marcador_it_grave="";
                              $marcador_it_muy_grave="X";
                        }
?>
                        <table>
                              <tr>
                                    <td class="border-top border-bottom border-left" style="text-align: center; width: 4%;">
                                          <b><?php echo $numero_item; ?></b>
                                    </td>
                                    <td valign="top" class="text-justify border-top border-left border-right border-bottom" style="margin: 14px; padding: 15px; width: 29%;">
                                          <?php echo $descripcion ?>      
                                    </td>  
                                    <td class="centrar_texto border-top border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_leve; ?></b>
                                    </td>
                                    <td class="centrar_texto border-left border-top border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_grave; ?></b>
                                    </td>
                                    <td class="centrar_texto border-top border-left border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_muy_grave; ?></b>
                                    </td>
                                    <td valign="top" class="text-justify border-top border-left border-bottom border-right" style="width: 34%; margin: 14px; padding: 15px;">
                                          <?php
                                                if ($observacion == "") {
                                                      echo $observacion;
                                                }else{
                                                      echo $observacion."<br><br>";
                                                }                                                
                                                /* Consulta para mostrar las fotos relacionadas a la inspeccion */
                                                $sql="SELECT n_fotografia FROM puertas_valores_fotografias WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion." AND k_coditem=".$i."";
                                                $result = mysqli_query($con, $sql);
                                                $numero_fotos=mysqli_num_rows($result);
                                                if ($numero_fotos > 0) {
                                                      echo "<b>Ver imagen:</b><br>";
                                                      while ($row=mysqli_fetch_array($result)) {
                                                            $n_fotografia = $row['n_fotografia'];
                                                            echo $n_fotografia."<br>";
                                                            // echo '<a href="http://192.168.0.26:8888/inspeccion/servidor/puertas/inspector_'.$codigo_inspector.'/fotografias/'.$n_fotografia.'">
                                                            //             '.$n_fotografia.'
                                                            //       </a>';
                                                      }
                                                }
                                          ?>
                                    </td>
                              </tr>
                        </table>
<?php
                  }
            }else{
                  //echo $con->error."\nerror: ". $sql . "<br>";
                  $bandera_sql += 1;
            }
      }                                
?>

<?php
      /*=============================================
      * Consulta SQL a la tabla puertas_valores_pozo
      *==============================================*/
      for ($i=43; $i <= 54; $i++) {
            $sql="SELECT item.k_coditem_motorizacion numero_item,item.o_descripcion descripcion,valor.n_calificacion clasificacion,valor.v_calificacion calificacion,valor.o_observacion observacion FROM puertas_items_motorizacion item,puertas_valores_motorizacion valor WHERE valor.k_codusuario=".$codigo_inspector." AND valor.k_codinspeccion=".$codigo_inspeccion." AND valor.k_coditem=".$i." AND item.k_coditem_motorizacion=valor.k_coditem";
            $result = mysqli_query($con, $sql);
            while ($row=mysqli_fetch_array($result)) {
                  $numero_item = $row['numero_item'];
                  $descripcion = $row['descripcion'];
                  $clasificacion = $row['clasificacion'];
                  $calificacion = $row['calificacion'];
                  $observacion = $row['observacion'];
            }
            if (mysqli_query($con,$sql) == true){
                  //echo "Consulta exitosa!.";
                  if ($calificacion == "No Cumple") {
                        if ($clasificacion == "L") {
                              $contador_it_leve+=1;
                              $marcador_it_leve="X";
                              $marcador_it_grave="";
                              $marcador_it_muy_grave="";
                        } elseif ($clasificacion == "G") {
                              $contador_it_grave+=1;
                              $marcador_it_leve="";
                              $marcador_it_grave="X";
                              $marcador_it_muy_grave="";
                        } elseif ($clasificacion == "MG") {
                              $contador_it_muy_grave+=1;
                              $marcador_it_leve="";
                              $marcador_it_grave="";
                              $marcador_it_muy_grave="X";
                        }
?>
                        <table>
                              <tr>
                                    <td class="border-top border-bottom border-left" style="text-align: center; width: 4%;">
                                          <b><?php echo $numero_item; ?></b>
                                    </td>
                                    <td valign="top" class="text-justify border-top border-left border-right border-bottom" style="margin: 14px; padding: 15px; width: 29%;">
                                          <?php echo $descripcion ?>      
                                    </td>  
                                    <td class="centrar_texto border-top border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_leve; ?></b>
                                    </td>
                                    <td class="centrar_texto border-left border-top border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_grave; ?></b>
                                    </td>
                                    <td class="centrar_texto border-top border-left border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_muy_grave; ?></b>
                                    </td>
                                    <td valign="top" class="text-justify border-top border-left border-bottom border-right" style="width: 34%; margin: 14px; padding: 15px;">
                                          <?php
                                                if ($observacion == "") {
                                                      echo $observacion;
                                                }else{
                                                      echo $observacion."<br><br>";
                                                }                                                
                                                /* Consulta para mostrar las fotos relacionadas a la inspeccion */
                                                $sql="SELECT n_fotografia FROM puertas_valores_fotografias WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion." AND k_coditem=".$i."";
                                                $result = mysqli_query($con, $sql);
                                                $numero_fotos=mysqli_num_rows($result);
                                                if ($numero_fotos > 0) {
                                                      echo "<b>Ver imagen:</b><br>";
                                                      while ($row=mysqli_fetch_array($result)) {
                                                            $n_fotografia = $row['n_fotografia'];
                                                            echo $n_fotografia."<br>";
                                                            // echo '<a href="http://192.168.0.26:8888/inspeccion/servidor/puertas/inspector_'.$codigo_inspector.'/fotografias/'.$n_fotografia.'">
                                                            //             '.$n_fotografia.'
                                                            //       </a>';
                                                      }
                                                }
                                          ?>
                                    </td>
                              </tr>
                        </table>
<?php
                  }
            }else{
                  //echo $con->error."\nerror: ". $sql . "<br>";
                  $bandera_sql += 1;
            }
      }                                
?>

<?php
      /*=============================================
      * Consulta SQL a la tabla puertas_valores_otras
      *==============================================*/
      for ($i=55; $i <= 75; $i++) {
            $sql="SELECT item.k_coditem_otras numero_item,item.o_descripcion descripcion,valor.n_calificacion clasificacion,valor.v_calificacion calificacion,valor.o_observacion observacion FROM puertas_items_otras item,puertas_valores_otras valor WHERE valor.k_codusuario=".$codigo_inspector." AND valor.k_codinspeccion=".$codigo_inspeccion." AND valor.k_coditem=".$i." AND item.k_coditem_otras=valor.k_coditem";
            $result = mysqli_query($con, $sql);
            while ($row=mysqli_fetch_array($result)) {
                  $numero_item = $row['numero_item'];
                  $descripcion = $row['descripcion'];
                  $clasificacion = $row['clasificacion'];
                  $calificacion = $row['calificacion'];
                  $observacion = $row['observacion'];
            }
            if (mysqli_query($con,$sql) == true){
                  //echo "Consulta exitosa!.";
                  if ($calificacion == "No Cumple") {
                        if ($clasificacion == "L") {
                              $contador_it_leve+=1;
                              $marcador_it_leve="X";
                              $marcador_it_grave="";
                              $marcador_it_muy_grave="";
                        } elseif ($clasificacion == "G") {
                              $contador_it_grave+=1;
                              $marcador_it_leve="";
                              $marcador_it_grave="X";
                              $marcador_it_muy_grave="";
                        } elseif ($clasificacion == "MG") {
                              $contador_it_muy_grave+=1;
                              $marcador_it_leve="";
                              $marcador_it_grave="";
                              $marcador_it_muy_grave="X";
                        }
?>
                        <table>
                              <tr>
                                    <td class="border-top border-bottom border-left" style="text-align: center; width: 4%;">
                                          <b><?php echo $numero_item; ?></b>
                                    </td>
                                    <td valign="top" class="text-justify border-top border-left border-right border-bottom" style="margin: 14px; padding: 15px; width: 29%;">
                                          <?php echo $descripcion ?>      
                                    </td>  
                                    <td class="centrar_texto border-top border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_leve; ?></b>
                                    </td>
                                    <td class="centrar_texto border-left border-top border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_grave; ?></b>
                                    </td>
                                    <td class="centrar_texto border-top border-left border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_muy_grave; ?></b>
                                    </td>
                                    <td valign="top" class="text-justify border-top border-left border-bottom border-right" style="width: 34%; margin: 14px; padding: 15px;">
                                          <?php
                                                if ($observacion == "") {
                                                      echo $observacion;
                                                }else{
                                                      echo $observacion."<br><br>";
                                                }                                                
                                                /* Consulta para mostrar las fotos relacionadas a la inspeccion */
                                                $sql="SELECT n_fotografia FROM puertas_valores_fotografias WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion." AND k_coditem=".$i."";
                                                $result = mysqli_query($con, $sql);
                                                $numero_fotos=mysqli_num_rows($result);
                                                if ($numero_fotos > 0) {
                                                      echo "<b>Ver imagen:</b><br>";
                                                      while ($row=mysqli_fetch_array($result)) {
                                                            $n_fotografia = $row['n_fotografia'];
                                                            echo "*".$n_fotografia."<br>";
                                                            // echo '<a href="http://192.168.0.26:8888/inspeccion/servidor/puertas/inspector_'.$codigo_inspector.'/fotografias/'.$n_fotografia.'">
                                                            //             '.$n_fotografia.'
                                                            //       </a>';
                                                      }
                                                }
                                          ?>
                                    </td>
                              </tr>
                        </table>
<?php
                  }
            }else{
                  //echo $con->error."\nerror: ". $sql . "<br>";
                  $bandera_sql += 1;
            }
      }                                
?>

<?php
      /*=============================================
      * Consulta SQL a la tabla puertas_valores_maniobras
      *==============================================*/
      for ($i=76; $i <= 86; $i++) {
            $sql="SELECT item.k_coditem_maniobras numero_item,item.o_descripcion descripcion,valor.n_calificacion clasificacion,valor.v_calificacion calificacion,valor.o_observacion observacion FROM puertas_items_maniobras item,puertas_valores_maniobras valor WHERE valor.k_codusuario=".$codigo_inspector." AND valor.k_codinspeccion=".$codigo_inspeccion." AND valor.k_coditem=".$i." AND item.k_coditem_maniobras=valor.k_coditem";
            $result = mysqli_query($con, $sql);
            while ($row=mysqli_fetch_array($result)) {
                  $numero_item = $row['numero_item'];
                  $descripcion = $row['descripcion'];
                  $clasificacion = $row['clasificacion'];
                  $calificacion = $row['calificacion'];
                  $observacion = $row['observacion'];
            }
            if (mysqli_query($con,$sql) == true){
                  //echo "Consulta exitosa!.";
                  if ($calificacion == "No Cumple") {
                        if ($clasificacion == "L") {
                              $contador_it_leve+=1;
                              $marcador_it_leve="X";
                              $marcador_it_grave="";
                              $marcador_it_muy_grave="";
                        } elseif ($clasificacion == "G") {
                              $contador_it_grave+=1;
                              $marcador_it_leve="";
                              $marcador_it_grave="X";
                              $marcador_it_muy_grave="";
                        } elseif ($clasificacion == "MG") {
                              $contador_it_muy_grave+=1;
                              $marcador_it_leve="";
                              $marcador_it_grave="";
                              $marcador_it_muy_grave="X";
                        }
?>
                        <table>
                              <tr>
                                    <td class="border-top border-bottom border-left" style="text-align: center; width: 4%;">
                                          <b><?php echo $numero_item; ?></b>
                                    </td>
                                    <td valign="top" class="text-justify border-top border-left border-right border-bottom" style="margin: 14px; padding: 15px; width: 29%;">
                                          <?php echo $descripcion ?>      
                                    </td>  
                                    <td class="centrar_texto border-top border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_leve; ?></b>
                                    </td>
                                    <td class="centrar_texto border-left border-top border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_grave; ?></b>
                                    </td>
                                    <td class="centrar_texto border-top border-left border-bottom" style="width: 11%;">
                                          <b><?php echo $marcador_it_muy_grave; ?></b>
                                    </td>
                                    <td valign="top" class="text-justify border-top border-left border-bottom border-right" style="width: 34%; margin: 14px; padding: 15px;">
                                          <?php
                                                if ($observacion == "") {
                                                      echo $observacion;
                                                }else{
                                                      echo $observacion."<br><br>";
                                                }                                                
                                                /* Consulta para mostrar las fotos relacionadas a la inspeccion */
                                                $sql="SELECT n_fotografia FROM puertas_valores_fotografias WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion." AND k_coditem=".$i."";
                                                $result = mysqli_query($con, $sql);
                                                $numero_fotos=mysqli_num_rows($result);
                                                if ($numero_fotos > 0) {
                                                      echo "<b>-> Ver imagen:</b><br>";
                                                      while ($row=mysqli_fetch_array($result)) {
                                                            $n_fotografia = $row['n_fotografia'];
                                                            echo $n_fotografia."<br>";
                                                            // echo '<a href="http://192.168.0.26:8888/inspeccion/servidor/puertas/inspector_'.$codigo_inspector.'/fotografias/'.$n_fotografia.'">
                                                            //             '.$n_fotografia.'
                                                            //       </a>';
                                                      }
                                                }
                                          ?>
                                    </td>
                              </tr>
                        </table>
<?php
                  }
            }else{
                  //echo $con->error."\nerror: ". $sql . "<br>";
                  $bandera_sql += 1;
            }
      }                                
?>
                  <table>
                        <tr>
                              <td class="border-right border-bottom border-left" style="width: 33%;">    
                              </td>  
                              <td class="centrar_texto border-bottom" style="width: 11%;">
                                    <b><?php echo $contador_it_leve; ?></b>
                              </td>
                              <td class="centrar_texto border-left border-bottom" style="width: 11%;">
                                    <b><?php echo $contador_it_grave; ?></b>
                              </td>
                              <td class="centrar_texto border-left border-bottom" style="width: 11%;">
                                    <b><?php echo $contador_it_muy_grave; ?></b>
                              </td>
                              <td class="border-left border-bottom border-right" style="width: 34%;">
                              </td>
                        </tr>
                  </table>

                  <table border="0">
                        <tr>
                              <td class="border-top border-bottom border-left border-right" colspan="2" bgcolor="#97ad93">
                                    <br>
                              </td>
                        </tr>
                        <tr>
                              <td class="border-top border-bottom border-left border-right" colspan="2">
                                    <b>OBSERVACIONES: </b>Se deben corregir los defectos en el tiempo estipulado por la norma NTC 5926-3:
                              </td>
                        </tr>
                        <tr>
                              <td class="border-top border-bottom border-left border-right" colspan="2" class="text-justify">
                                    Para defectos leves se debe corregir en un plazo no máximo a 180 días, graves un plazo no máximo de 30 días. En caso tal que el número de defectos leves supere 4 o más se considera esta situación como un defecto grave. <?php echo "<br><br>"; ?>
                              </td>                                            
                        </tr>
                        <tr>
                              <td class="border-top border-bottom border-left border-right" colspan="2" class="text-justify">
                                    <b>RESULTADO DE LA INSPECCIÓN: Se encontró <?php echo $contador_it_leve; ?> hallazgos leve, <?php echo $contador_it_grave; ?> grave y <?php echo $contador_it_muy_grave; ?> muy grave. </b> <?php echo "<br><br>"; ?>
                              </td>
                        </tr>
                        <tr>
                              <td class="border-top border-bottom border-left border-right" colspan="2" class="text-justify">
                                    Estos hallazgos deben estar completamente subsanados para la próxima inspección. Los defectos encontrados quedan bajo responsabilidad del administrador y/o propietario del equipo.<b> NOTA: <?php echo $observacion_final ?>.</b> <?php echo "<br><br>"; ?> 
                              </td>
                        </tr>
                        <tr>
                              <td class="border-top border-bottom border-left border-right" colspan="2">
                                    <b>CONFORMIDAD DEL CLIENTE:</b>
                              </td>
                        </tr>
                        <tr>
                              <td class="border-top border-bottom border-left border-right" colspan="2" class="text-justify">
                                    <br><br>
                              </td>
                        </tr>
                        <tr>
                              <td class="border-top border-right border-bottom border-left" style="padding: 6px;" bgcolor="#97ad93">
                                    <b>PROPIETARIO O ADMINISTRADOR DEL EQUIPO</b>
                              </td>
                              <td class="border-top border-bottom border-right" bgcolor="#97ad93" style="text-align: center;" style="padding: 6px;">
                                    <b>INSPECTOR DE MP</b>
                              </td>
                        </tr>
                        <tr>
                              <td class="border-top border-bottom border-right border-left" style="padding: 6px;">
                                    FIRMA
                              </td>
                              <td class="border-top border-bottom border-right" style="padding: 6px;">
                                    FIRMA
                              </td>
                        </tr>
                        <tr>
                              <td class="border-top border-bottom border-right border-left">
                                    NOMBRE <?php echo strtoupper($contacto_cliente) ?>
                              </td>
                              <td class="border-top border-bottom border-right">
                                    <?php
                                          if ($mensaje_servidor != "si") {
                                                $sql="SELECT * FROM usuarios WHERE k_codusuario=".$codigo_inspector_dispositivo."";
                                                $result = mysqli_query($con, $sql);
                                                while ($row=mysqli_fetch_array($result)) {
                                                      $nombre_inspector = strtoupper($row['n_nombre'])." ".strtoupper($row['n_apellido']);
                                                }
                                                echo "NOMBRE ".$nombre_inspector;
                                          }else{
                                                $sql="SELECT * FROM usuarios WHERE k_codusuario=".$codigo_inspector."";
                                                $result = mysqli_query($con, $sql);
                                                while ($row=mysqli_fetch_array($result)) {
                                                      $nombre_inspector = strtoupper($row['n_nombre'])." ".strtoupper($row['n_apellido']);
                                                }
                                                echo "NOMBRE ".$nombre_inspector;
                                          }
                                    ?>
                              </td>
                        </tr>
                        <tr>
                              <td class="border-top border-bottom border-right border-left" bgcolor="#97ad93" style="padding: 6px;">
                                    <b>EMPRESA DE MANTENIMIENTO</b>
                              </td>
                              <td class="border-top border-bottom border-right" bgcolor="#97ad93" style="text-align: center;" style="padding: 6px;">
                                    <b>EMISOR DE INFORME POR MP</b>
                              </td>
                        </tr>
                        <tr>
                              <td class="border-top border-bottom border-right border-left" style="padding: 6px;">
                                    FIRMA
                              </td>
                              <td class="border-top border-bottom border-right" style="padding: 6px;">
                                    FIRMA
                              </td>
                        </tr>
                        <tr>
                              <td class="border-top border-right border-left">
                                    NOMBRE <?php echo strtoupper($encargado_emp_mto) ?>
                              </td>
                              <td class="border-top border-right">
                                    NOMBRE ROBINSON CARDENAS
                              </td>
                        </tr>
                  </table>
            </div>
      </body>
</html>
<?php
      /*========================================================================
      * Vamos a exportar el PDF de la inspeccion para previamente enviarlo por correo
      * El PDF se crea capturando todo el html generado
      *========================================================================*/
      $dompdf = new DOMPDF();
      $dompdf -> set_paper("A4", "portrait");
      $dompdf -> load_html(ob_get_clean());
      $dompdf -> render();

      /*========================================================================
      * Se hace una consulta a la tabla de auditoria para saber si el campo de la contraseña esta vacio y asi poder generar una contraseña
      *========================================================================*/
      $sql = "SELECT * FROM auditoria_inspecciones_puertas WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
      $result = mysqli_query($con, $sql);
      while ($row=mysqli_fetch_array($result)) {
            $o_password_pdf = $row['o_password_pdf'];
      }

      /*========================================================================
      * Si el campo de contraseña esta vacia se genera una contraseña y se actualiza el campo en la tabla de auditoria con la nueva 
      * contraseña; Si el campo de contraseña no esta vacio se deja la misma contraseña
      *========================================================================*/
      if ($o_password_pdf == "") {
            $contrasena_pdf = generaPass();
            $sql="UPDATE auditoria_inspecciones_puertas SET o_password_pdf = '".$contrasena_pdf."' WHERE k_codusuario=".$codigo_inspector." AND k_codinspeccion=".$codigo_inspeccion."";
            if (mysqli_query($con,$sql)==TRUE){
                  //echo "Transaccion exitosa!";
            } else {
                  //echo "error: ". $sql . "<br>" . $con->error;
            }
      }else{
            $contrasena_pdf = $o_password_pdf;
      }

      /*========================================================================
      * Se utiliza la funcion de encripcion en donde se le pasa por parametro la contraseña creada, la contraseña por defecto que abrira el * archivo y se le dan permisos al archivo de poderse imprimir y permitir copiar el texto del PDF
      *========================================================================*/
      //$dompdf -> get_canvas()->get_cpdf()->setEncryption("", "robinson90", array('print','copy'));
      $dompdf -> get_canvas()->get_cpdf()->setEncryption($contrasena_pdf, "robinson90", array('print','copy'));
      $dompdf -> get_canvas()->get_cpdf()->encrypted=true;

      if ($mensaje_servidor != "si") {
            unlink("../puertas/inspector_".$codigo_inspector_dispositivo."/registros_pdf/".$consecutivo_inspeccion.".pdf");
            $file_to_save = "../puertas/inspector_".$codigo_inspector_dispositivo."/registros_pdf/".$consecutivo_inspeccion.".pdf";
      }else{
            $files = glob("../puertas/servidor/inspector_".$codigo_inspector."/registros_pdf/*"); // obtiene todos los archivos
            foreach($files as $file){
              if(is_file($file)) // si se trata de un archivo
              unlink($file); // lo elimina
            }
            $file_to_save = "../puertas/servidor/inspector_".$codigo_inspector."/registros_pdf/".$consecutivo_inspeccion.".pdf";
      }

      mkdir(dirname($file_to_save), 0777, true); //esta linea es para crear el directorio si no existe
      file_put_contents($file_to_save, $dompdf->output());
      
      echo $bandera_sql;
      ob_end_flush();
      //print_r($json_auditoria_puertas);
      //echo $fecha_emision;

      /*========================================================================
      * Funcion para generar contraseñas
      *========================================================================*/
      function generaPass(){
          //Se define una cadena de caractares. Te recomiendo que uses esta.
          $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
          //Obtenemos la longitud de la cadena de caracteres
          $longitudCadena=strlen($cadena);
           
          //Se define la variable que va a contener la contraseña
          $pass = "";
          //Se define la longitud de la contraseña, en mi caso 10, pero puedes poner la longitud que quieras
          $longitudPass=10;
           
          //Creamos la contraseña
          for($i=1 ; $i<=$longitudPass ; $i++){
              //Definimos numero aleatorio entre 0 y la longitud de la cadena de caracteres-1
              $pos=rand(0,$longitudCadena-1);
           
              //Vamos formando la contraseña en cada iteraccion del bucle, añadiendo a la cadena $pass la letra correspondiente a la posicion $pos en la cadena de caracteres definida.
              $pass .= substr($cadena,$pos,1);
          }
          return $pass;
      }
?>