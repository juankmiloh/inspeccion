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
    <title>REGISTROS FOTOGRÁFICOS</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon_1.ico" type="image/vnd.microsoft.icon">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../estilos_css/estilos_lista_inspeccionv3.css">
    <script type="text/javascript" src="../javascript/script_escaleras_fotografias.js"/></script>
    <script type="text/javascript">
		$(document).ready(function(){ 
            //alert("sirve js");
        });
	</script>
</head>
<body>
    <a name="arriba"></a> <!--ESTO SE PONE PARA CUANDO SE GUARDE, SE DEVUELVA A LA PARTE DE ARRIBA DE LA PAGINA-->
    <!-- DIV's de imagen de carga oculto -->
    <div class="fbback" style="z-index: 57;"></div>
    
    <div class="container" id="fbdrag1">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="fb" style="z-index: 57;">
                    <!--<span class="close" onclick="dragClose('fbdrag1')"></span>-->
                    <div class="dheader">Montajes & Procesos M.P SAS</div>
                    <div class="dcontent">
                        <div style="text-align:center;padding-top:20px">
                            <center>
                                <img src="../images/loading.gif" alt="Loading...">
                                <br><br>
                                <label style="color: black;" id="texto_carga"></label>
                            </center>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- DIV's del modal que carga la foto -->
    <div class="modal fade" tabindex="-1" id="gridSystemModal" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="btn_small_cerrar_modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="gridSystemModalLabel">DETALLE FOTOGRÁFICO</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-12" style="text-align: center;" id="div_imagen">
                            <div class="divisionItems sombra"></div><br>
                            <img id="imagen_modal" class="img-thumbnail sombra" data-toggle="modal" data-target="#gridSystemModal" style="max-width: 100%; height: auto;">
                            <br><br>
                            <div class="divisionItems sombra"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-8" style="text-align: center;">
                            <h6 id="nombre_foto"></h6>
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
                                <a href="javascript:descargar_fotos()">
                                    |&nbsp
                                    <span class="glyphicon glyphicon-download-alt"></span>
                                    &nbspDESCARGAR FOTOGRAFÍAS
                                    &nbsp|
                                </a>
                            </li>
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
                                            Cerrar Pestaña
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
                <center><label>REGISTROS FOTOGRÁFICOS</label></center>
            </div>
        </div>

        <br>
        <div class="divisionItems sombra"></div>
        <br>
        <div class="row">

<?php
    /*=============================================
    * CONSULTA QUE PERMITE OBTENER EL CONSECUTIVO DE LA INSPECCION, PARA PODER GENERAR EL PDF
    * SE GUARDA EN UN CAMPO OCULTO EL VALOR DEL CONSECUTIVO
    *==============================================*/
    $sql = "SELECT * FROM escaleras_valores_iniciales WHERE k_codusuario = ".$_GET['id_inspector']." AND 
                                                     k_codinspeccion=".$_GET['cod_inspeccion']."";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($result)) {
?>
        <input type="hidden" id="consecutivo_inspeccion" value="<?php echo $row['o_consecutivoinsp']; ?>">
        <input type="hidden" id="text_cliente" value="<?php echo $row['n_cliente']; ?>">
<?
    }   
    /*=============================================
    * CONSULTA QUE PERMITE OBTENER LOS VALORES (NOMBRE DE LA FOTO) RELACIONADA AL ITEM 
    *==============================================*/
    $sql = "SELECT * FROM escaleras_valores_fotografias WHERE k_codusuario = ".$_GET['id_inspector']." AND 
                                                             k_codinspeccion=".$_GET['cod_inspeccion'];
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($result)) {
?>  
            <div class="col-xs-4 col-md-4" style="text-align: center;">
                <img id="<?php echo $row['n_fotografia']; ?>" onclick="mostrarDetalleFoto(this.id)" class="img-thumbnail sombra" data-toggle="modal" data-target="#gridSystemModal" style="cursor: pointer; max-width: 100%; height: auto;" src="../escaleras/inspector_<?php echo $_GET['id_inspector']; ?>/fotografias/<?php echo $_GET['cod_inspeccion']; ?>/<?php echo $row['n_fotografia']; ?>"><br><br>
                <button type="button" class="btn btn-success btn-sm sombra" id="<?php echo $row['n_fotografia']; ?>" onclick="eliminarFotografia(this)">
                    <span class="glyphicon glyphicon-trash"></span>
                    ELIMINAR
                </button>
                <br><br><br>
                <div class="divisionItems sombra"></div>
                <br><br>
            </div>
<?
    }
?>      
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12" style="text-align: center;">
                <hr>
                <a href="javascript:window.close()">
                    <button type="submit" class="btn btn-success btn-lg sombra" id="boton">
                        <span class="glyphicon glyphicon-remove"></span>
                        CERRAR PESTAÑA
                    </button>
                </a>
                <hr>
            </div>
        </div>
    </div>
</body>
</html>