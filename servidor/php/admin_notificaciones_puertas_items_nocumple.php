<?php
  session_start();
  ob_start(); //Linea para permitir enviar flujo de datos por url al redireccionar la pagina 
  header("access-control-allow-origin: *");
  include ("conexion_BD.php");
  if(isset($_SESSION['Usuario'])){
      
  }else{
    header("Location: ../index.php?Error=Acceso denegado");
  }
  ob_end_flush();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="format-detection" content="telephone=no">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width">
    <link rel="shortcut icon" href="../images/favicon_1.ico" type="image/vnd.microsoft.icon">
    <script src="../bower_components/jquery/dist/jquery.js"></script>
    <script src="../bower_components/bootstrap/dist/js/bootstrap.js"></script>
    <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="../estilos_css/estilo_admin_v4.css"/>
    <link rel="stylesheet" href="../bower_components/sweetalert2/dist/sweetalert2.css" />
    <link rel="stylesheet" href="../bower_components/angular-material/angular-material.css" />
    <script type="text/javascript" src="../javascript/script_admin_v6.js"/></script>
    <script src="../bower_components/sweetalert2/dist/sweetalert2.js"></script>
    <title>PANEL DE ADMINISTRACIÓN</title>
  </head>
<body ng-app="cardDemo" ng-controller="AppCtrl" ng-cloak>
  <!-- DIV's de imagen de carga oculto -->
  <div class="fbback" style="z-index: 57;"></div>
  <div class="fbback_1"></div> <!-- div que oculta los controles cuando se oprime el btnF1 -->
  
  <div class="container" id="fbdrag1">
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="fb" style="z-index: 57;">
            <!--<span class="close" onclick="dragClose('fbdrag1')"></span>-->
            <div class="dheader">Empresa</div>
            <div class="dcontent">
              <div style="text-align:center;padding-top:20px">
                <center>
                  <img src="../images/loading.gif" alt="Loading...">
                  <br><br>
                  <label id="texto_carga" style="color: black;"></label>
                </center>
              </div>
              <br>
            </div>
        </div>
      </div>
    </div>
  </div> 

  <!--<div class="bs-example bs-example-padded-bottom"> <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#gridSystemModal"> Launch demo modal </button> </div>-->
  <!-- DIV's del modal que carga el audio -->
  <div class="modal fade" tabindex="-1" id="gridSystemModal" role="dialog" aria-labelledby="gridSystemModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn_small_cerrar_modal">
            <span aria-hidden="true">&times;</span>
          </button>
          <h4 class="modal-title" id="gridSystemModalLabel">CONFORMIDAD DEL CLIENTE</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12" style="text-align: center;">
              <h6>Registro audio de informe</h6>
            </div>
            <div class="col-md-12" style="text-align: center;" id="div_audio"></div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-8" style="text-align: center;">
              <h6 id="nombre_audio"></h6>
            </div>
            <div class="col-md-4" style="text-align: right;">
              <button type="button" id="btn_cerrar_modal" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  <!--
  * CONTENEDOR DEL BOTON FLOTANTE
  -->
  <div class="contenedor_btns_flotantes">
    <button type="button" class="botonF1">
      <span>+</span>
    </button>
    <a href="./admin.php">
      <button type="submit" class="btn_flotante botonF2" id="btn_guardar">
        <span class="texto_boton_flotante"><b>Regresar</b></span>
        <span class="glyphicon glyphicon-arrow-left img_boton_flotante"></span>
      </button>
    </a>
  </div>

  <div class="container-fluid">
    <header>
      <!-- Contenedor de la imagen banner y el título de la cabecera -->
      <div class="row sombra_banner" id="top_home">
        <div class="col-xs-12 col-sm-12 col-md-12">
          <center>
            <img src="../images/banner.png" class="img-responsive banner" alt="M.P SAS">
          </center>
        </div>
      </div>
      <br>
      <div class="row sombra" id="header">
        <div class="col-xs-6 col-md-6" style="width: 60%;">
          <label style="color: white; padding-top: 0.5em; padding-left: 0.5em;">ADMINISTRADOR</label>
        </div>
        <div class="col-xs-6 col-md-6" style="text-align: right; width: 40%;">
          <a href="./cerrar_sesion_administrador.php">
            <button type="button" class="btn btn-primary btn-sm sombra" id="boton">
              <span class="glyphicon glyphicon-lock"></span>
              Cerrar Sesión
            </button>
          </a>
        </div>
      </div>
    </header>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <br>
        <div class="div_division sombra"></div>
        <br>
        <center>
          <h4><span><b>INFORME - INSPECCIONES PUERTAS - SEGUNDA REVISIÓN - PLAZO 180 DÍAS</b></span></h4>
        </center>
        <br>
        <div class="div_division sombra"></div>
        <br>             
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12" style="border: 0px solid red;">
        <div id="div_notificacion_puertas">
          <div class="table-responsive">
            <table class="table table-hover table-bordered" id="tabla_puertas">
              <thead>
                <tr>
                  <th colspan="10" bgcolor="#70b6e0">
                    <center><b>RESUMEN DE INSPECCIÓN | PUERTAS</b></center>
                  </th>
                </tr>
                <tr>
                  <th class="active centrar_texto">
                    <b>INSPECTOR</b>
                  </th>
                  <th class="active centrar_texto">
                    <center><b>CONSECUTIVO</b></center>
                  </th>
                  <th class="active centrar_texto" style="width:10%">
                    <center><b>CLIENTE</b></center>
                  </th>
                  <th class="active centrar_texto">
                    <center><b>NO CUMPLE</b></center>
                  </th>
                  <th class="active centrar_texto">
                    <center><b>FECHA CARGA</b></center>
                  </th>
                  <th class="active centrar_texto">
                    <center><b>DÍAS FALTANTES</b></center>
                  </th>
                  <th class="active centrar_texto">
                    <center><b>FECHA VENCIMIENTO</b></center>
                  </th>
                  <th class="active centrar_texto">
                    <center><b>PASS PDF</b></center>
                  </th>
                  <th class="active centrar_texto">
                    <center><b>DETALLE</b></center>
                  </th>
                </tr>
              </thead>
              <tbody>
                <?php
                  /*=============================================
                  * SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LAS INSPECCIONES CON CANTIDAD DE ITEMS NOCUMPLE MAYORES A 0
                  * OBTENIENDO POR CADA INSPECCION LA CANTIDAD DE DIAS TRANSCURRIDOS DESDE SU CARGA AL SISTEMA
                  * SI LA CANTIDAD DE DIAS ESTA ENTRE 150 Y 180 DIAS SE MUESTRA EN LA TABLA
                  *==============================================*/
                  $sql="SELECT *,DATE_FORMAT(f_carga_servidor,'%d-%m-%Y') AS f_carga,DATE_FORMAT(ADDDATE(f_carga_servidor, INTERVAL 180 DAY),'%d-%m-%Y') AS f_vencimiento,DATEDIFF(now(),f_carga_servidor) AS cantidad_dias FROM auditoria_inspecciones_puertas WHERE v_item_nocumple>0 AND f_carga_servidor<>'0000-00-00 00:00:00' ORDER BY cantidad_dias DESC";
                  $result=mysqli_query($con, $sql);
                  // $numero_inspecciones=mysqli_num_rows($result);
                  $notificacion_inspecciones_puertas = array(); //creamos un array
                  while($row = mysqli_fetch_array($result)){
                    $k_codusuario = $row['k_codusuario'];
                    $k_codinspeccion = $row['k_codinspeccion'];
                    $o_consecutivoinsp = $row['o_consecutivoinsp'];
                    $v_item_nocumple = $row['v_item_nocumple'];
                    $f_carga_servidor = $row['f_carga'];
                    $f_vencimiento = $row['f_vencimiento'];
                    $o_password_pdf = $row['o_password_pdf'];
                    
                    $v_item_leve = $row['v_item_leve'];
                    $v_item_grave = $row['v_item_grave'];
                    $v_item_muygrave = $row['v_item_muygrave'];
                    
                    $cantidad_dias = $row['cantidad_dias'];

                    $dias_faltantes = 180 - $cantidad_dias;

                    /*=============================================
                    * SE HACE UN SELECT A LA TABLA DE VALORES INICIALES PARA OBTENER EL NOMBRE DEL CLIENTE
                    *==============================================*/
                    $sql1="SELECT * FROM puertas_valores_iniciales WHERE k_codusuario=".$k_codusuario." AND k_codinspeccion=".$k_codinspeccion."";
                    $result1=mysqli_query($con, $sql1);
                    while($row1 = mysqli_fetch_array($result1)){
                      $n_cliente = $row1['n_cliente'];
                    }

                    if ($cantidad_dias >= 150 && $cantidad_dias <= 180) {
                ?>
                      <tr>
                        <td class="centrar_texto" style="padding: 25px;">
                          <?php echo $k_codusuario; ?>
                        </td>
                        <td class="centrar_texto" style="padding: 25px;">
                          <?php echo $o_consecutivoinsp; ?>
                        </td>
                        <td class="centrar_texto" style="padding: 25px;">
                          <?php echo $n_cliente; ?>
                        </td>
                        <td class="centrar_texto" style="padding: 25px;">
                          <?php echo $v_item_nocumple; ?>
                        </td>
                        <td class="centrar_texto" style="padding: 25px;">
                          <?php echo $f_carga_servidor; ?>
                        </td>
                        <td class="centrar_texto" style="padding: 25px;">
                          <?php echo $dias_faltantes ?>
                        </td>
                        <td class="centrar_texto" style="padding: 25px;">
                          <?php echo $f_vencimiento; ?>
                        </td>
                        <td class="centrar_texto" style="padding: 25px;">
                          <?php echo $o_password_pdf; ?>
                        </td>
                        <td class="centrar_texto" style="padding: 15px;">
                          <?php
                            echo '
                            <a href="../php/puertas_modificar_lista_inspeccion.php?id_inspector='.$k_codusuario.'&cod_inspeccion='.$k_codinspeccion.'" target="_blank">
                              <img src="../images/lupa.png" style="width: 3em;">
                            </a>';
                          ?>
                        </td>
                      </tr>
                <?php
                    }
                  }
                  //desconectamos la base de datos
                  $close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    
    <br>
    <div class="div_division sombra" id="div_focalizar"></div>
    <footer>
      <div class="row">
      <br>
        <div class="col-xs-12 col-md-12" style="text-align: center;">
          <br>
          <span style="color: #428bca;"><b>Montajes & Procesos M.P SAS</b></span>
          <br>
          <span id="fecha_footer" style="color: #428bca; font-size: 0.9em;"></span>
        </div>
      </div>
    </footer>
    <div class="row" style="width: 100%; position: fixed; bottom: 0px; border: 1px solid; background-color: #060d14; z-index: 57">
      <div class="col-xs-12 col-md-12" style="text-align: center;">
        <span style="color: #ecf3f9;">Aplicación desarrollada por</span>
        <a href="mailto:juankmiloh@hotmail.com" style="color: #b3d0e9;">
          juankmiloh
        </a>
      </div>
    </div>
    <br><br><br>
  </div>
  <script src="../bower_components/angular/angular.js"></script>
  <script src="../bower_components/angular-animate/angular-animate.js"></script>
  <script src="../bower_components/angular-cookies/angular-cookies.js"></script>
  <script src="../bower_components/angular-resource/angular-resource.js"></script>
  <script src="../bower_components/angular-route/angular-route.js"></script>
  <script src="../bower_components/angular-sanitize/angular-sanitize.js"></script>
  <script src="../bower_components/angular-touch/angular-touch.js"></script>
  <script src="../bower_components/angular-aria/angular-aria.js"></script>
  <script src="../bower_components/angular-material/angular-material.js"></script>
  <script type="text/javascript" src="../javascript/controller_admin_v2.js"/></script>
</body>
</html>