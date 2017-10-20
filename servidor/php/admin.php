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
            <div class="dheader">MONTAJES & PROCESOS M.P SAS</div>
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
    <!-- <a href="./admin_inspecciones_certificadas.php">
      <button type="button" class="btn_flotante botonF2">
        <span class="texto_boton_flotante"><b>Inspecciones Certificadas</b></span>
        <span class="glyphicon glyphicon-check img_boton_flotante"></span>
      </button>
    </a>
    <a href="./admin_inspecciones_por_revision.php">
      <button type="button" class="btn_flotante botonF3">
        <span class="texto_boton_flotante"><b>Inspecciones por Revisión</b></span>
        <span class="glyphicon glyphicon-eye-open img_boton_flotante"></span>
      </button>
    </a>
    <a href="./admin_generar_reportes.php">
      <button type="submit" class="btn_flotante botonF4" id="btn_guardar">
        <span class="texto_boton_flotante"><b>Reporte de Inspeccciones</b></span>
        <span class="glyphicon glyphicon-list-alt img_boton_flotante"></span>
      </button>
    </a> -->
    <a href="./admin_informes_inspeccion.php">
      <button type="submit" class="btn_flotante botonF2" id="btn_guardar">
        <span class="texto_boton_flotante"><b>Informes de inspección</b></span>
        <span class="glyphicon glyphicon-file img_boton_flotante"></span>
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
          <h4><span><b>INFORME GENERAL DE INSPECCIONES</b></span></h4>
        </center>
        <br>
        <div class="div_division sombra"></div>
        <br>             
      </div>
    </div>

    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12" style="border: 0px solid red;">
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <div>
              <md-content class="md-padding" layout-xs="column" layout="row">
                <div flex-xs flex-gt-xs="50" layout="column">
                  <md-card md-theme="{{ showDarkTheme ? 'dark-orange' : 'default' }}" md-theme-watch>
                    <md-toolbar class="md-warn" style="background-color: #6A1B9A">
                      <div class="md-toolbar-tools sombra">
                        <span class="glyphicon glyphicon-compressed"></span>&nbsp
                        <h2 class="md-flex"><b>ASCENSORES</b></h2>
                      </div>
                    </md-toolbar>
                    <br>
                    <div class="row" ng-repeat="option in options_ascensores">
                      <div class="col-xs-12 col-md-12">
                        <md-divider></md-divider>
                        <md-subheader class="md-no-sticky">{{option.descripcion}}</md-subheader>
                        <md-list-item class="md-3-line" ng-click="navigateTo(option.descripcion, $event, option)" ng-class="{active: activeOption == option}">
                          <div class="md-list-item-text" layout="row">
                            <div id="cajon1">
                              <p class="desc_texto">{{option.text}}</p>
                            </div>
                            <div id="cajon2">
                              <div class="padre">
                                <div class="hijo">
                                  <a ng-if="option.cantidad==0" href="#">{{option.cantidad}}</a>
                                  <a ng-if="option.cantidad>0" href="#" style="color: #d9534f;">{{option.cantidad}}</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </md-list-item>
                      </div>
                    </div>
                  </md-card>
                </div>

                <div flex-xs flex-gt-xs="50" layout="column">
                  <md-card md-theme="{{ showDarkTheme ? 'dark-orange' : 'default' }}" md-theme-watch>
                    <md-toolbar class="md-warn" style="background-color: #2196F3;">
                      <div class="md-toolbar-tools sombra">
                        <span class="glyphicon glyphicon-flash"></span>&nbsp
                        <h2 class="md-flex"><b>PUERTAS ELÉCTRICAS</b></h2>
                      </div>
                    </md-toolbar>
                    <br>
                    <div class="row" ng-repeat="option in options_puertas">
                      <div class="col-xs-12 col-md-12">
                        <md-divider></md-divider>
                        <md-subheader class="md-no-sticky">{{option.descripcion}}</md-subheader>
                        <md-list-item class="md-3-line" ng-click="navigateTo(option.descripcion, $event, option)" ng-class="{active: activeOption == option}">
                          <div class="md-list-item-text" layout="row">
                            <div id="cajon1">
                              <p class="desc_texto">{{option.text}}</p>
                            </div>
                            <div id="cajon2">
                              <div class="padre">
                                <div class="hijo">
                                  <a ng-if="option.cantidad==0" href="#">{{option.cantidad}}</a>
                                  <a ng-if="option.cantidad>0" href="#" style="color: #d9534f;">{{option.cantidad}}</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </md-list-item>
                      </div>
                    </div>
                  </md-card>
                </div>

                <div flex-xs flex-gt-xs="50" layout="column">
                  <md-card md-theme="{{ showDarkTheme ? 'dark-orange' : 'default' }}" md-theme-watch>
                    <md-toolbar class="md-warn" style="background-color: #F44336;">
                      <div class="md-toolbar-tools sombra">
                        <span class="glyphicon glyphicon-signal"></span>&nbsp
                        <h2 class="md-flex"><b>ESCALERAS / ANDENES</b></h2>
                      </div>
                    </md-toolbar>
                    <br>
                    <div class="row" ng-repeat="option in options_escaleras">
                      <div class="col-xs-12 col-md-12">
                        <md-divider></md-divider>
                        <md-subheader class="md-no-sticky">{{option.descripcion}}</md-subheader>
                        <md-list-item class="md-3-line" ng-click="navigateTo(option.descripcion, $event, option)" ng-class="{active: activeOption == option}">
                          <div class="md-list-item-text" layout="row">
                            <div id="cajon1">
                              <p class="desc_texto">{{option.text}}</p>
                            </div>
                            <div id="cajon2">
                              <div class="padre">
                                <div class="hijo">
                                  <a ng-if="option.cantidad==0" href="#">{{option.cantidad}}</a>
                                  <a ng-if="option.cantidad>0" href="#" style="color: #d9534f;">{{option.cantidad}}</a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </md-list-item>
                      </div>
                    </div>
                  </md-card>
                </div>

              </md-content>
            </div>
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