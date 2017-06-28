<?php
    session_start();
    include ("conexion_BD.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>INSPECCIÓN ASCENSORES</title>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="shortcut icon" href="../images/favicon_1.ico" type="image/vnd.microsoft.icon">
    <script src="../js/jquery.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <link href="../css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="../estilos_css/estilos_lista_inspeccion_ascensores.css">    
    <script type="text/javascript" src="../js/fileinput.min.js"></script>
    <script type="text/javascript" src="../javascript/js_lista_inspeccion_ascensores.js"></script>
  </head>
<body>
    <div class="container contenedor_cabecera">
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
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <center><label id="label_cabecera">INFORME DE INSPECCIÓN ASCENSORES ELECTROMECÁNICOS E HIDRÁULICOS</label></center>
                </div>
            </div>
        </header>
        <br>
        <!-- Contenedor de los datos respectivos de la empresa -->
        <?php
            //Se realiza la consulta y se guarda en una variable que llamamos result
            $sql = "SELECT * FROM ascensor_valores_iniciales
                    WHERE k_codusuario=".$_GET['id_inspector']."
                    AND k_codinspeccion=".$_GET['cod_inspeccion'];
            $result = mysqli_query($con, $sql);
            while ($row=mysqli_fetch_array($result)) {
        ?>  
        <div class="row datos_cabecera">
            <div class="col-xs-12 col-md-4">
                <label>CLIENTE</label>
                <input type="text" class="form-control" id="text_cliente" name="text_cliente" readonly value="<?php echo $row['n_cliente']; ?>">
            </div>
            <div class="col-xs-12 col-md-4">
                <label>NOMBRE DE EQUIPO</label>
                <input type="text" class="form-control" id="text_equipo" name="text_equipo" readonly value="<?php echo $row['n_equipo']; ?>">
            </div>
            <div class="col-xs-12 col-md-4">
                <label>EMPRESA MANTENIMIENTO</label>
                <input type="text" class="form-control" id="text_empresaMantenimiento" name="text_empresaMantenimiento" readonly value="<?php echo $row['n_empresamto']; ?>">
            </div>
            <div class="col-xs-12 col-md-4">
                <label>TIPO DE ACCIONAMIENTO</label>
                <input type="text" class="form-control" id="text_tipoAccionamiento" name="text_tipoAccionamiento" readonly value="<?php echo $row['o_tipoaccion']; ?>">
            </div>
            <div class="col-xs-12 col-md-4">
                <label>CAPACIDAD DE PERSONAS</label>
                <input type="number" class="form-control" id="text_capacidadPersonas" name="text_capacidadPersonas" readonly value="<?php echo $row['v_capacperson']; ?>">
            </div>
            <div class="col-xs-12 col-md-4">
                <label>CAPACIDAD (kg)</label>
                <input type="number" class="form-control" id="text_capacidadPeso" name="text_capacidadPeso" readonly value="<?php echo $row['v_capacpeso']; ?>">
            </div>

            <div class="col-xs-12 col-md-4">
                <label>NÚMERO DE PARADAS</label>
                <input type="number" class="form-control" id="text_numeroParadas" name="text_numeroParadas" readonly value="<?php echo $row['v_paradas']; ?>">
            </div>
            <div class="col-xs-12 col-md-4">
                <label>FECHA</label>
                <input type="text" class="form-control" id="text_fecha" name="text_fecha" readonly value="<?php echo $row['f_fecha']; ?>">  
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <label>CÓDIGO</label>
                        <input type="text" value="IN-R-02" class="form-control" id="text_codigo" name="text_codigo" readonly value="<?php echo $row['v_codigo']; ?>">
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <label>CONSECUTIVO</label>
                        <input type="text" class="form-control" id="text_consecutivo" name="text_consecutivo" readonly value="<?php echo $row['o_consecutivoinsp']; ?>">
                    </div>
                </div>  
            </div>
        </div>
        <?php } ?>

        <hr>
        <!-- Contenedor de los datos de la evaluación preliminar -->
        <div class="row contenedor_titulo titulo_items sombra">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <center><label>EVALUACIÓN PRELIMINAR DE INSPECCIÓN</label></center>
            </div>
        </div>
        <br>
        <div class="divisionItems sombra"></div>
        <br>

        <?php
            //Se realiza la consulta y se guarda en una variable que llamamos result
            $sql = "SELECT it.k_coditem_preli, it.o_descripcion, va.v_calificacion, va.o_observacion FROM ascensor_items_preliminar it, ascensor_valores_preliminar va WHERE va.k_codusuario=".$_GET['id_inspector']." AND va.k_codinspeccion=".$_GET['cod_inspeccion']." AND va.k_coditem_preli=it.k_coditem_preli";
            $result = mysqli_query($con, $sql);
            while ($row=mysqli_fetch_array($result)) {
        ?> 
        <div class="row">
            <div class="col-xs-12 col-md-5">
                <hr>
                <center><label>ÍTEM</label></center>
                <p class="text-justify item1_preliminar" id="text_item1_eval_preliminar" name="text_item1_eval_preliminar">
                    <b>[<?php echo $row['k_coditem_preli']; ?>] </b><?php echo $row['o_descripcion']; ?></p>
            </div>
            <div class="col-xs-12 col-md-2">
                <hr>
                <center><label>CAL</label></center>
                <p class="text-justify"><b><br><center>"<?php echo $row['v_calificacion']; ?>"</center></b></p>
            </div>                
            <div class="col-xs-12 col-md-5">
                <hr>
                <center><label>OBSERVACIÓN</label></center>
                <center><textarea class="form-control" rows="3" id="text_obser_item1_eval_prel" name="text_obser_item1_eval_prel" placeholder="Ingrese aquí la observación..."><?php echo $row['o_observacion']; ?></textarea></center>
            </div>
        </div>
        <hr>
        <div class="divisionItems sombra"></div>
        <br>
        <?php } ?>

        <!-- Contenedor de los datos de la lista de verificacion -->
        <div class="row sombra">
            <div class="col-xs-12 col-sm-12 col-md-12 contenedor_titulo titulo_items">
                <center><label>LISTA DE VERIFICACIÓN 5926-1</label></center>
            </div>
        </div>

        <!-- ////////////////////////////////////// CABINA /////////////////////////////////////////// -->
        
        <hr>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 contenedor_titulo_lv sombra">
                <center><label>CABINA</label></center>
            </div>
        </div>

        <!-- ////////////////////////////////////// CABINA /////////////////////////////////////////// -->

        <!-- /////////////////////////////////////// 1 //////////////////////////////////////////// -->

        <hr>        
        <div class="divisionItems sombra"></div>

        <!-- /////////////////////////////////////// 1 //////////////////////////////////////////// -->
        
        <?php
            //Se realiza la consulta y se guarda en una variable que llamamos result
            $sql = "SELECT va.k_codusuario, va.k_codinspeccion, it.k_coditem_cabina, it.v_item, it.o_descripcion, it.v_clasificacion, va.o_observacion FROM ascensor_items_cabina it, ascensor_valores_cabina va WHERE va.k_codusuario=".$_GET['id_inspector']." AND va.k_codinspeccion=".$_GET['cod_inspeccion']." AND va.v_calificacion=\"No Cumple\" AND va.k_coditem_cabina=it.k_coditem_cabina";
            $result = mysqli_query($con, $sql);
            $sql = "SELECT * FROM ascensor_valores_iniciales
                    WHERE k_codusuario=".$_GET['id_inspector']."
                    AND k_codinspeccion=".$_GET['cod_inspeccion'];
            while ($row=mysqli_fetch_array($result)) {
        ?> 
        <div class="row">            
            <div class="col-xs-1 col-md-1">
                <hr>
                <center><label></label></center>
                <center><p id="p_lv_no_item_1" name="p_lv_no_item_1"><b><?php echo $row['k_coditem_cabina']; ?>]</b></p></center>
            </div>
            <div class="col-xs-2 col-md-1">
                <hr>
                <center><label>ÍTEM</label></center>
                <center><p id="p_lv_valor_item_1" name="p_lv_valor_item_1"><b><?php echo $row['v_item']; ?></b></p></center>
            </div>
            <div class="col-xs-7 col-md-4">
                <hr>
                <center><label>DEFECTO</label></center>
                <p class="text-justify" id="p_lv_valor_defecto_1" name="p_lv_valor_defecto_1"><?php echo $row['o_descripcion']; ?></p>
            </div>
            <div class="col-xs-2 col-md-1">
                <hr>
                <center><label>CAL</label></center>
                <p class="text-justify"><b><br><center>"<?php echo $row['v_clasificacion']; ?>"</center></b></p>
            </div>
            <div class="col-xs-12 col-md-5">
                <hr>
                <center><label>OBSERVACIÓN</label></center>
                <textarea class="form-control" rows="3" id="text_lv_valor_observacion_1" name="text_lv_valor_observacion_1" placeholder="Ingrese aquí la observación..."><?php echo $row['o_observacion']; ?></textarea>
            </div> 
            <div class="col-xs-12 col-md-12">
                <hr>
                <center><label>REGISTRO FOTOGRÁFICO</label></center>
                <center>
                    <a href="./detalles.php?id_inspector=inspector&cod_inspeccion=inspeccion&cod_item=item">
                        <button type="button" id='' class="btn btn-info sombra">
                            <span class="glyphicon glyphicon-eye-open"></span>
                            Ver fotografías
                        </button>
                    </a>
                </center>
            </div> 
        </div>
        <hr>
        <div class="divisionItems sombra"></div>
        <?php } ?>
        <hr>
        <div class="row">
            <div class="col-xs-12 col-md-3"></div>          
            <div class="col-xs-12 col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <td colspan="3" class="success">
                            <center><b>RESUMEN DE ITEMS</b></center>
                        </td>
                    </tr>
                    <tr>
                        <td class="active">
                            <center><b>LEVES</b></center>
                        </td>
                        <td class="active">
                            <center><b>GRAVES</b></center>
                        </td>
                        <td class="active">
                            <center><b>MUY GRAVES</b></center>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php
                                //Se realiza la consulta y se guarda en una variable que llamamos result
                                $sql = "SELECT COUNT(*) cantidad_items FROM ascensor_items_cabina it, ascensor_valores_cabina va WHERE va.k_codusuario=".$_GET['id_inspector']." AND va.k_codinspeccion=".$_GET['cod_inspeccion']." AND va.v_calificacion=\"No Cumple\" AND va.k_coditem_cabina=it.k_coditem_cabina AND it.v_clasificacion=\"Leve\"";
                                $result = mysqli_query($con, $sql);
                                $sql = "SELECT * FROM ascensor_valores_iniciales
                                        WHERE k_codusuario=".$_GET['id_inspector']."
                                        AND k_codinspeccion=".$_GET['cod_inspeccion'];
                                while ($row=mysqli_fetch_array($result)) {
                            ?>
                            <center><?php echo $row['cantidad_items']; ?></center>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                                //Se realiza la consulta y se guarda en una variable que llamamos result
                                $sql = "SELECT COUNT(*) cantidad_items FROM ascensor_items_cabina it, ascensor_valores_cabina va WHERE va.k_codusuario=".$_GET['id_inspector']." AND va.k_codinspeccion=".$_GET['cod_inspeccion']." AND va.v_calificacion=\"No Cumple\" AND va.k_coditem_cabina=it.k_coditem_cabina AND it.v_clasificacion=\"Grave\"";
                                $result = mysqli_query($con, $sql);
                                $sql = "SELECT * FROM ascensor_valores_iniciales
                                        WHERE k_codusuario=".$_GET['id_inspector']."
                                        AND k_codinspeccion=".$_GET['cod_inspeccion'];
                                while ($row=mysqli_fetch_array($result)) {
                            ?>
                            <center><?php echo $row['cantidad_items']; ?></center>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                                //Se realiza la consulta y se guarda en una variable que llamamos result
                                $sql = "SELECT COUNT(*) cantidad_items FROM ascensor_items_cabina it, ascensor_valores_cabina va WHERE va.k_codusuario=".$_GET['id_inspector']." AND va.k_codinspeccion=".$_GET['cod_inspeccion']." AND va.v_calificacion=\"No Cumple\" AND va.k_coditem_cabina=it.k_coditem_cabina AND it.v_clasificacion=\"Muy Grave\"";
                                $result = mysqli_query($con, $sql);
                                $sql = "SELECT * FROM ascensor_valores_iniciales
                                        WHERE k_codusuario=".$_GET['id_inspector']."
                                        AND k_codinspeccion=".$_GET['cod_inspeccion'];
                                while ($row=mysqli_fetch_array($result)) {
                            ?>
                            <center><?php echo $row['cantidad_items']; ?></center>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-xs-12 col-md-3"></div> 
        </div>
        
        <hr>
        <!-- Contenedor del boton que permite guardar el archivo de inspección -->
        <center>
            <!-- A button to call out JavaScript Function -->
            <a href="./admin.php">
                <button type="submit" class="btn btn-success btn-lg sombra" id="boton">
                    <span class="glyphicon glyphicon-backward"></span>
                    Regresar
                </button>
            </a>
        </center>
        <hr>
    </div>
</body>
</html>