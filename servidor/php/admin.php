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
    <title>PANEL DE ADMINISTRACIÓN</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon_1.ico" type="image/vnd.microsoft.icon">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="../estilos_css/estilo_admin.css"/>
    <script type="text/javascript" src="../javascript/script_admin.js"/></script>
    <script type="text/javascript">
		$(document).ready(function(){ 
            //alert("sirve js");
        });
	</script>
</head>
<body>
    <!-- DIV's de imagen de carga oculto -->
    <div class="fbback" style="z-index: 57;"></div>
    
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
                        <div class="col-md-12" style="text-align: center;" id="div_audio">
                            
                        </div>
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

    <div class="container">
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
                    <h4><span><b>INFORMES DE INSPECCIÓN</b></span></h4>
                </center>
                <br>
                <div class="div_division sombra"></div>
                <br>             
            </div>
            <div class="col-xs-12 col-md-3"></div>
            <div class="col-xs-12 col-md-6">
                <label for="select_tipo_inspeccion">TIPO DE INSPECCIÓN</label>
                <select class="form-control" id="select_tipo_inspeccion" name="select_tipo_inspeccion" onchange="enviarTipoInspeccion(this)">
                    <option value="n/a">Seleccione un tipo de inspección</option>
                    <option value="1">Ascensores</option>
                    <option value="2">Puertas Eléctricas</option>
                    <option value="3">Escaleras - Andenes</option>
                </select>
                <br>
            </div>
            <div class="col-xs-12 col-md-3"></div>

            <div class="col-xs-12 col-md-6" id="div_select_inspector">
                <label for="select_inspector">INSPECTOR</label>
                <select class="form-control" id="select_inspector" name="select_inspector" onchange="cargarInspecciones(this)">
                    <option value="n/a">Seleccione un inspector</option>
                </select>
            </div>
            <div class="col-xs-12 col-md-6">
                <br class="salto_xs">
                <label for="select_inspecciones">INSPECCIÓN</label>
                <select class="form-control" id="select_inspecciones" name="select_inspecciones" onchange="cargarDatos(this)">
                    <option value="n/a">Seleccione una inspección</option>
                </select>
            </div>
        </div>

        <div id="div_ascensores">
            <br>
            <div class="div_division sombra"></div>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tabla_ascensores">
                    <thead>
                        <tr>
                            <td colspan="9" bgcolor="#70b6e0">
                                <center><b>RESUMEN DE INSPECCIÓN | ASCENSORES</b></center>
                            </td>
                        </tr>
                        <tr>
                            <td class="active centrar_texto">
                                <b>INSPECTOR</b>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>CONSECUTIVO</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>REVISIÓN</b></center></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>NO CUMPLE</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>FECHA</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>AUDIO DE INFORME</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>DETALLE</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>FOTOGRAFÍAS</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>PASS PDF</b></center>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>

        <div id="div_puertas">
            <br>
            <div class="div_division sombra"></div>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tabla_puertas">
                    <thead>
                        <tr>
                            <td colspan="9" bgcolor="#70b6e0">
                                <center><b>RESUMEN DE INSPECCIÓN | PUERTAS</b></center>
                            </td>
                        </tr>
                        <tr>
                            <td class="active centrar_texto">
                                <b>INSPECTOR</b>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>CONSECUTIVO</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>REVISIÓN</b></center></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>NO CUMPLE</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>FECHA</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>AUDIO DE INFORME</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>DETALLE</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>FOTOGRAFÍAS</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>PASS PDF</b></center>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>

        <div id="div_escaleras">
            <br>
            <div class="div_division sombra"></div>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="tabla_escaleras">
                    <thead>
                        <tr>
                            <td colspan="9" bgcolor="#70b6e0">
                                <center><b>RESUMEN DE INSPECCIÓN | ESCALERAS</b></center>
                            </td>
                        </tr>
                        <tr>
                            <td class="active centrar_texto">
                                <b>INSPECTOR</b>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>CONSECUTIVO</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>REVISIÓN</b></center></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>NO CUMPLE</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>FECHA</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>AUDIO DE INFORME</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>DETALLE</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>FOTOGRAFÍAS</b></center>
                            </td>
                            <td class="active centrar_texto">
                                <center><b>PASS PDF</b></center>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
        
        <br>
        <div class="div_division sombra" id="div_focalizar"></div>
        <footer>
            <div class="row">
                <div class="col-xs-12 col-md-12" style="text-align: center;">
                    <br>
                    <span style="color: #428bca;"><b>Montajes & Procesos M.P SAS</b></span>
                    <br>
                    <span id="fecha_footer" style="color: #428bca; font-size: 0.9em;"></span>
                </div>
            </div>
        </footer>
        <br><br><br><br><br>
    </div>
</body>
</html>