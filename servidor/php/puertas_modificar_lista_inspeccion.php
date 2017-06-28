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
    <title>INSPECCIÓN PUERTAS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="shortcut icon" href="../images/favicon_1.ico" type="image/vnd.microsoft.icon">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../estilos_css/estilos_lista_inspeccion.css"/>
    <link href="../css/lightgallery.css" rel="stylesheet">
    <link href="../css/lightgallery-theme.css" rel="stylesheet"> 

    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/Concurrent.Thread.js"></script>
    <script type="text/javascript" src="../javascript/script_puertas_modificar_cargar_items.js"/></script>
    <script type="text/javascript" src="../javascript/script_puertas_modificar_cargar_valores.js"/></script>
    <script type="text/javascript" src="../javascript/script_puertas_modificar_guardarinspeccion.js"/></script>
    <script type="text/javascript" src="../javascript/script_puertas_enviar_registro_inspeccion.js"/></script>
</head>
<body>
    <a name="arriba"></a> <!--ESTO SE PONE PARA CUANDO SE GUARDE, SE DEVUELVA A LA PARTE DE ARRIBA DE LA PAGINA-->
    <!-- DIV's de imagen de carga oculto -->
    <div class="fbback" style="z-index: 57;"></div>
    
    <div class="container" id="fbdrag1">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="fb" style="z-index: 57;">
                    <div class="dheader">Montajes & Procesos M.P SAS</div>
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

    <div class="container contenedor_cabecera">
        <header>
            <nav class="navbar navbar-default navbar-fixed-top navbar-inverse sombra">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-1">
                            <span class="sr-only">Menu</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="../php/admin.php" class="navbar-brand">ADMINISTRADOR</a>
                    </div>

                    <div class="collapse navbar-collapse" id="navbar-1">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="javascript:crearPDF()">
                                    |&nbsp
                                    <span class="glyphicon glyphicon-file"></span>
                                    &nbspCREAR PDF DE INSPECCIÓN
                                    &nbsp|
                                </a>
                            </li>
                            <li>
                                <a href="javascript:crear_pdf_correo()">
                                    |&nbsp
                                    <span class="glyphicon glyphicon-envelope"></span>
                                    &nbspENVIAR INSPECCIÓN POR CORREO
                                    &nbsp|
                                </a>
                            </li>
                        </ul>

                        <form action="" class="navbar-form navbar-left" role="search">
                            <div class="form-group">
                            </div>
                        </form>

                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Opciones<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="javascript:window.close()">
                                            <span class="glyphicon glyphicon-remove"></span>
                                            Cerrar Inspección
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="../php/cerrar_sesion_administrador.php?error=error">
                                            <span class="glyphicon glyphicon-lock"></span>
                                            Salir
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <br><br><br>

        <!-- Contenedor de la imagen banner y el título de la cabecera -->
        <div class="row sombra_banner" id="top_home">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <center>
                    <img src="../images/banner.png" class="img-responsive banner" alt="M.P SAS">
                </center>
            </div>
        </div>
        <br>
        <div class="row sombra">
            <div class="col-xs-12 col-sm-12 col-md-12 contenedor_titulo" id="label_cabecera">
                <center><label>LISTA DE INSPECCIÓN PUERTAS ELÉCTRICAS AUTOMÁTICAS</label></center>
            </div>
        </div>

        <br>

        <form id="formulario" method="post" action="javascript:guardarInspeccion()">
            <!-- Contenedor de los datos respectivos de la empresa -->
            <div class="row datos_cabecera">
                <div class="col-xs-12 col-md-4">
                    <label for="text_cliente">CLIENTE</label>
                    <input type="text" class="form-control" id="text_cliente" name="text_cliente" placeholder="Cliente" required>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_equipo">IDENTIFICACIÓN DEL EQUIPO</label>
                    <input type="text" class="form-control" id="text_equipo" name="text_equipo" placeholder="Identificación Equipo" required>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_empresaMantenimiento">EMPRESA MANTENIMIENTO</label>
                    <input type="text" class="form-control" id="text_empresaMantenimiento" name="text_empresaMantenimiento" placeholder="Empresa" required>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_desc_puerta">DESCRIPCIÓN DE LA PUERTA</label>
                    <input type="text" class="form-control" id="text_desc_puerta" name="text_desc_puerta" placeholder="Descripción" required>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_tipoPuerta">TIPO DE PUERTA</label>
                    <select class="form-control" id="text_tipoPuerta" name="text_tipoPuerta" required>
                        <option value="">Seleccione un tipo de puerta</option>
                        <option value="Basculante">Basculante</option>
                        <option value="Batiente">Batiente</option>
                        <option value="Corredera">Corredera</option>
                        <option value="Enrollable">Enrollable</option>
                        <option value="Plegable">Plegable</option>
                        <option value="Seccional">Seccional</option>
                        <option value="Peatonal">Peatonal</option>
                        <option value="Otra">Otra</option>
                    </select>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_motorizacion">MOTORIZACIÓN</label>
                    <select class="form-control" id="text_motorizacion" name="text_motorizacion" required>
                        <option value="">Seleccione un tipo de motorización</option>
                        <option value="Electromecánica">Electromecánica</option>
                        <option value="Hidráulica">Hidráulica</option>
                        <option value="Neumática">Neumática</option>
                        <option value="Otra">Otra</option>
                    </select>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_acceso">CONTROL DE ACCESO</label>
                    <select class="form-control" id="text_acceso" name="text_acceso" required>
                        <option value="">Seleccione un tipo de acceso</option>
                        <option value="Estación de mando">Estación de mando</option>
                        <option value="Sensores de proximidad">Sensores de proximidad</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_accionamiento">TIPO DE ACCIONAMIENTO</label>
                    <input type="text" class="form-control" id="text_accionamiento" name="text_accionamiento" placeholder="Tipo de accionamiento" required>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_operador">MARCA DE OPERADOR</label>
                    <input type="text" class="form-control" id="text_operador" name="text_operador" placeholder="Marca de operador" required>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_hoja">TIPO DE HOJA</label>
                    <select class="form-control" id="text_hoja" name="text_hoja" required>
                        <option value="">Seleccione un tipo de hoja</option>
                        <option value="Hoja Ciega">Hoja Ciega</option>
                        <option value="Hoja Barrotes">Hoja Barrotes</option>
                    </select>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_transmision">TRANSMISIÓN</label>
                    <select class="form-control" id="text_transmision" name="text_transmision" required>
                        <option value="">Seleccione un tipo de transmisión</option>
                        <option value="Sin transmisión por cadena">Sin transmisión por cadena</option>
                        <option value="Un lado">Un lado</option>
                        <option value="Dos lados">Dos lados</option>
                    </select>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_identificacion">IDENTIFICACIÓN DE LA PUERTA ELÉCTRICA</label>
                    <input type="text" class="form-control" id="text_identificacion" name="text_identificacion" placeholder="En caso de existir varias" required>
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_fecha">FECHA DE INSPECCIÓN</label>
                    <input type="date" class="form-control" id="text_fecha" name="text_fecha" placeholder="Fecha de Inspección">
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_ultimo_mto">FECHA ÚLTIMO MANTENIMIENTO</label>
                    <input type="date" class="form-control" id="text_ultimo_mto" name="text_ultimo_mto" placeholder="Seleccione una fecha">
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_inicio_servicio">FECHA PUESTA EN SERVICIO</label>
                    <input type="date" class="form-control" id="text_inicio_servicio" name="text_inicio_servicio">
                </div>
                <div class="col-xs-12 col-md-4">
                    <label for="text_ultima_inspec">FECHA ÚLTIMA INSPECCIÓN</label>
                    <input type="date" class="form-control" id="text_ultima_inspec" name="text_ultima_inspec">
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <label>PASO LIBRE</label>
                        </div>
                        <div class="col-xs-6 col-md-6">
                            <input type="number" class="form-control" id="text_ancho" name="text_ancho" placeholder="Ancho (cm)" required step="0.01">
                        </div>
                        <div class="col-xs-6 col-md-6">
                            <input type="number" class="form-control" id="text_alto" name="text_alto" placeholder="Alto (m)" required step="0.01">
                        </div>
                    </div>  
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <label for="text_codigo">CÓDIGO</label>
                            <input type="text" value="IN-R-14" class="form-control" id="text_codigo" name="text_codigo" readonly>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <label for="text_consecutivo">CONSECUTIVO</label>
                            <input type="text" class="form-control" id="text_consecutivo" name="text_consecutivo" readonly>
                        </div>
                    </div>  
                </div>
            </div>
            <hr>
            
            <center>
                <div class="row" id="div_items">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <!-- ///////////////// CONTENEDOR DE LOS ITEMS DE LA EVALUACIÓN PRELIMINAR DE INSPECCIÓN ///////////////////// -->
                        <a name="campo_focus_2"></a>

                        <div class="bs-example"> 
                            <p> 
                                <button aria-controls="collapse_evaluacion_preliminar" aria-expanded="false" class="btn btn-success collapsed sombra div_1" data-target="#collapse_evaluacion_preliminar" data-toggle="collapse" type="button" id="boton_titulo"> 
                                    <b>EVALUACIÓN PRELIMINAR DE INSPECCIÓN</b>
                                </button> 
                            </p> 
                            <div class="collapse" id="collapse_evaluacion_preliminar" aria-expanded="false" style="height: 0px;"> 
                                <div class=""> 
                                    <div id="items_evaluacion_preliminar"> <!-- DIV DONDE SE CARGAN LOS ITEMS -->
                                        <br>
                                        <div class="divisionItems sombra"></div>
                                        <br>
                                    </div>
                                </div> 
                            </div> 
                        </div>

                        <hr>

                        <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                        
                        <!-- ////////////////////// CONTENEDOR DE LOS ITEMS DE ELEMENTOS DE PROTECCIÓN PERSONAL /////////////////////// -->

                        <a name="campo_focus_3"></a>

                        <div class="bs-example"> 
                            <p> 
                                <button aria-controls="collapse_elementos_proteccion_personal" aria-expanded="false" class="btn btn-success collapsed sombra div_2" data-target="#collapse_elementos_proteccion_personal" data-toggle="collapse" type="button" id="boton_titulo"> 
                                    <b>ELEMENTOS DE PROTECCIÓN PERSONAL</b>
                                </button> 
                            </p> 
                            <div class="collapse" id="collapse_elementos_proteccion_personal" aria-expanded="false" style="height: 0px;"> 
                                <div class=""> 
                                    <div id="items_elementos_proteccion_personal"> <!-- DIV DONDE SE CARGAN LOS ITEMS -->
                                        <br>
                                        <div class="divisionItems sombra"></div>
                                        <br>
                                    </div>
                                </div> 
                            </div> 
                        </div>

                        <hr>

                        <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                        <!-- ////////////////////////// CONTENEDOR DE LOS ITEMS DE ELEMENTOS DEl INSPECTOR /////////////////////////// -->

                        <a name="campo_focus_4"></a>



                        <div class="bs-example"> 
                            <p> 
                                <button aria-controls="collapse_elementos_del_inspector" aria-expanded="false" class="btn btn-success collapsed sombra div_3" data-target="#collapse_elementos_del_inspector" data-toggle="collapse" type="button" id="boton_titulo"> 
                                    <b>ELEMENTOS DEL INSPECTOR</b>
                                </button> 
                            </p> 
                            <div class="collapse" id="collapse_elementos_del_inspector" aria-expanded="false" style="height: 0px;"> 
                                <div class="">
                                    <div id="items_elementos">
                                        <br>
                                        <div class="divisionItems sombra"></div>
                                        <br>

                                        <div id="items_elementos" class="container-fluid">
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-right:1px solid; border-left:1px solid;border-bottom:1px solid;">
                                                    <div class="row" style="height: 3.4em; background-color: #5bc0de;">
                                                        <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;">
                                                            <label>&nbsp</label>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid #5bc0de; background-color: #5bc0de; text-align: center;">
                                                            <label>ÍTEM</label>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div id="items_elementos_del_inspector" style="height: 2.2em;"></div> <!-- DIV DONDE SE CARGAN LOS ITEMS -->
                                                    </div>
                                                </div>

                                                <div class="col-xs-6 col-sm-6 col-md-6" style="border-top:1px solid; border-right:1px solid; border-bottom:1px solid;">
                                                    <center>
                                                        <div class="row" style="height: 3.4em;">
                                                            <div class="col-xs-12 col-sm-12 col-md-12" style="background-color: #5bc0de;">
                                                                <label>INSPECTOR</label>
                                                            </div>
                                                            <div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; background-color: #9cd9eb;">
                                                                <label>C</label>
                                                            </div>
                                                            <div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #9cd9eb;">
                                                                <label>NC</label>
                                                            </div>
                                                            <div class="col-xs-4 col-sm-4 col-md-4" style="border-top:1px solid; border-left:1px solid; background-color: #9cd9eb;">
                                                                <label>N/A</label>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div id="items_elementos_del_inspector_1"></div> <!-- DIV DONDE SE CARGAN LOS ITEMS -->
                                                        </div>
                                                    </center>
                                                </div>
                                            </div>
                                        </div>

                                        <br>
                                        <div class="divisionItems sombra"></div>
                                        <br>
                                    </div>
                                </div> 
                            </div> 
                        </div>
                        
                        <hr>

                        <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                        <!-- /////////////////////// CONTENEDOR DE LOS ITEMS DE LISTA DE DEFECTOS ////////////////////////// -->
                        
                        <div class="row sombra btn1 btn-success" id="div_4">
                            <div class="col-xs-12 col-sm-12 col-md-12 contenedor_titulo titulo_items" style="background-color: #499349;">
                                <center><label>LISTA DE DEFECTOS</label></center>
                            </div>
                        </div>

                        <hr>

                        <div id="items_lista_verificacion">
                            <!-- /////////////////////////////// CONTENEDOR DE LOS ITEMS ELEMENTOS MECANICOS ///////////////////////////////////// -->
                            <a name="campo_focus_5"></a>

                            <div class="bs-example">
                                <p> 
                                    <button aria-controls="collapse_mecanicos" aria-expanded="false" class="btn btn-primary collapsed sombra div_5" data-target="#collapse_mecanicos" data-toggle="collapse" type="button" id="boton_titulo"> 
                                        <b>ELEMENTOS MECÁNICOS</b>
                                    </button> 
                                </p> 
                                <div class="collapse" id="collapse_mecanicos" aria-expanded="false" style="height: 0px;"> 
                                    <div class=""> 
                                        <div id="items_mecanicos"> <!-- DIV DONDE SE CARGAN LOS ITEMS -->
                                            <br>
                                            <div class="divisionItems sombra"></div>
                                            <br>
                                        </div>
                                    </div> 
                                </div> 
                            </div>

                            <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                            
                            <hr>

                            <!-- ///////////////////////// CONTENEDOR DE LOS ITEMS DE INSTALACION ELECTRICA ///////////////////////// -->
                            <a name="campo_focus_6"></a>

                            <div class="bs-example">
                                <p> 
                                    <button aria-controls="collapse_electrica" aria-expanded="false" class="btn btn-primary collapsed sombra div_6" data-target="#collapse_electrica" data-toggle="collapse" type="button" id="boton_titulo"> 
                                        <b>INSTALACIÓN ELÉCTRICA</b>
                                    </button> 
                                </p> 
                                <div class="collapse" id="collapse_electrica" aria-expanded="false" style="height: 0px;"> 
                                    <div class=""> 
                                        <div id="items_electrica"> <!-- DIV DONDE SE CARGAN LOS ITEMS -->
                                            <br>
                                            <div class="divisionItems sombra"></div>
                                            <br>
                                        </div>
                                    </div> 
                                </div> 
                            </div>

                            <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                            <hr>

                            <!-- ///////////////////////// CONTENEDOR DE LOS ITEMS DE MOTORIZACION ///////////////////////// -->
                            <a name="campo_focus_7"></a>

                            <div class="bs-example">
                                <p> 
                                    <button aria-controls="collapse_motorizacion" aria-expanded="false" class="btn btn-primary collapsed sombra div_7" data-target="#collapse_motorizacion" data-toggle="collapse" type="button" id="boton_titulo"> 
                                        <b>MOTORIZACIÓN</b>
                                    </button> 
                                </p> 
                                <div class="collapse" id="collapse_motorizacion" aria-expanded="false" style="height: 0px;"> 
                                    <div class=""> 
                                        <div id="items_motorizacion"> <!-- DIV DONDE SE CARGAN LOS ITEMS -->
                                            <br>
                                            <div class="divisionItems sombra"></div>
                                            <br>
                                        </div>
                                    </div> 
                                </div> 
                            </div>

                            <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                            <hr>

                            <!-- ///////////////////////// CONTENEDOR DE LOS ITEMS DE OTRAS COMPROBACIONES ///////////////////////// -->
                            <a name="campo_focus_8"></a>

                            <div class="bs-example">
                                <p> 
                                    <button aria-controls="collapse_otras" aria-expanded="false" class="btn btn-primary collapsed sombra div_8" data-target="#collapse_otras" data-toggle="collapse" type="button" id="boton_titulo"> 
                                        <b>OTRAS COMPROBACIONES</b>
                                    </button> 
                                </p> 
                                <div class="collapse" id="collapse_otras" aria-expanded="false" style="height: 0px;"> 
                                    <div class=""> 
                                        <div id="items_otras"> <!-- DIV DONDE SE CARGAN LOS ITEMS -->
                                            <br>
                                            <div class="divisionItems sombra"></div>
                                            <br>
                                        </div>
                                    </div> 
                                </div> 
                            </div>

                            <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                            <hr>

                            <!-- ///////////////////////// CONTENEDOR DE LOS ITEMS DE MANIOBRAS DE SEGURIDAD ///////////////////////// -->

                            <div class="bs-example">
                                <p> 
                                    <button aria-controls="collapse_maniobras" aria-expanded="false" class="btn btn-primary collapsed sombra div_9" data-target="#collapse_maniobras" data-toggle="collapse" type="button" id="boton_titulo"> 
                                        <b>MANIOBRAS DE SEGURIDAD</b>
                                    </button> 
                                </p> 
                                <div class="collapse" id="collapse_maniobras" aria-expanded="false" style="height: 0px;"> 
                                    <div class=""> 
                                        <div id="items_maniobras"> <!-- DIV DONDE SE CARGAN LOS ITEMS -->
                                            <br>
                                            <div class="divisionItems sombra"></div>
                                            <br>
                                        </div>
                                    </div> 
                                </div> 
                            </div>

                            <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                            <hr>
                            
                        </div>

                        <!-- ///////////////////////// CONTENEDOR OBSERVACIÓN FINAL ///////////////////////// -->

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 contenedor_titulo_lv sombra" style="color: white;">
                                <center><label>OBSERVACIÓN FINAL (OPCIONAL)</label></center>
                            </div>
                        </div>

                        <br>        
                        <div class="divisionItems sombra"></div>
                        <br>

                        <div class="container-fluid">

                            <div class="row" style="border-left:1px solid; border-right:1px solid;">
                                <div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">
                                    <label for="text_observacion_final">OBSERVACIÓN</label>
                                </div>
                            </div>

                            <div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid;">
                                <div class="col-xs-12 col-md-12">
                                    <br>
                                    <textarea class="form-control" rows="3" id="text_observacion_final" name="text_observacion_final" placeholder="Ingrese aquí la nota..."></textarea>
                                    <br>
                                </div>
                            </div>

                            <div class="row" style="border-left:1px solid; border-right:1px solid;">
                                <div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">
                                    <label for="botonIniciar0">REGISTRO FOTOGRÁFICO</label>
                                </div>
                            </div>

                            <div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid; border-bottom:1px solid; text-align: center;">
                                <div class="col-xs-12 col-md-12">
                                    <br>
                                    <a href="" id="link_botonIniciar0" target="_blank">
                                        <button type="button" id="botonIniciar0" class="btn btn-success sombra">
                                            <span class="glyphicon glyphicon-camera"></span>
                                             Ver Fotografías
                                        </button>
                                    </a>
                                    <br><br>                    
                                </div>
                            </div>
                        </div>
                        
                        <br>
                        <div class="divisionItems sombra"></div>
                        <br>

                        <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                        <hr>

                        <!-- ///////////////////////// CONTENEDOR AUDIO ///////////////////////// -->

                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 contenedor_titulo_lv sombra" style="color: white;">
                                <center><label>ANEXOS</label></center>
                            </div>
                        </div>

                        <br>        
                        <div class="divisionItems sombra"></div>
                        <br>

                        <div class="container-fluid">

                            <div class="row" style="border-left:1px solid; border-right:1px solid;">
                                <div class="col-xs-12 col-sm-12 col-md-12" style="border-top:1px solid; text-align: center; background-color: #5bc0de;">
                                    <label for="botonGrabar">REGISTRO DE VOZ</label>
                                </div>
                            </div>

                            <div class="row" style="border-top:1px solid; border-left:1px solid; border-right:1px solid; border-bottom:1px solid; text-align: center;">
                                <div class="col-xs-12 col-md-12">
                                    <br>
                                    <center>
                                        <select class="form-control" id="select_audio_inspeccion" style="width: 20em;" onchange="escucharAudio(this)">
                                            <option value="n/a">Seleccione un audio</option>
                                        </select>
                                    </center>
                                    <br><br>                    
                                </div>
                            </div>
                        </div>
                        
                        <br>
                        <div class="divisionItems sombra"></div>
                        <br>

                        <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->

                        <hr>

                        <!-- ///////////////////// CONTENEDOR DEL BOTON QUE PERMITE GUARDAR LA INSPECCION ///////////////////////////// -->

                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6" style="text-align: right;">
                                <a href="javascript:window.close()">
                                    <button type="button" class="btn btn-success btn-lg boton sombra" id="boton" style="width: 100%;">
                                        <span class="glyphicon glyphicon-remove"></span>
                                        CERRAR
                                    </button>
                                </a>
                            </div>
                            <div class="col-xs-6 col-sm-6 col-md-6" style="text-align: left;">
                                <button type="submit" id="btn_guardar" class="btn btn-success btn-lg boton sombra" style="width: 100%;" onclick="mostrarDivs();">
                                    GUARDAR
                                    <span class="glyphicon glyphicon-floppy-disk"></span>
                                </button>
                            </div>  
                        </div>

                        <hr>

                        <!-- ////////////////////////////////////////////////////////////////////////////////////////////////////////// -->
                    
                    </div>                    
                </div>
            </center>
        </form>
    </div>
    <script src="../js/picturefill.min.js"></script>
    <script src="../js/lightgallery.js"></script>
    <script src="../js/lg-pager.js"></script>
    <script src="../js/lg-autoplay.js"></script>
    <script src="../js/lg-fullscreen.js"></script>
    <script src="../js/lg-zoom.js"></script>
    <script src="../js/lg-hash.js"></script>
    <script src="../js/lg-share.js"></script>
    <!-- lightgallery plugins -->
    <script src="../js/lg-thumbnail.min.js"></script>
    <script src="../js/lg-fullscreen.min.js"></script>
    <script>
        //lightGallery(document.getElementById('lightgallery'));
    </script>
</body>
</html>