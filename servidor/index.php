<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<title>INDEX / SERVIDOR</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="shortcut icon" href="images/favicon_1.ico" type="image/vnd.microsoft.icon">
	<script src="js/jquery.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="./estilos_css/estilos_index.css"/>
	<script type="text/javascript" src="./javascript/script_index_servidor.js"/></script>
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
                                <img src="./images/loading.gif" alt="Loading...">
                                <br><br>
                                <label style="color: black;">Empaquetando app...Espere</label>
                            </center>
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div> 
    <br>

	<div class="container">
        <header>
            <!-- Contenedor de la imagen banner y el título de la cabecera -->
            <div class="row sombra_banner" id="top_home">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <center>
                        <img src="./images/banner.png" class="img-responsive banner" alt="M.P SAS">
                    </center>
                </div>
            </div>
            <br>
            <div class="row sombra" id="header">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <center><label id="label_cabecera">MÓDULO PRINCIPAL</label></center>
                </div>
            </div>
        </header>

        <hr>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <center>
                    <h4><b>SELECCIONE UNA OPCIÓN</b></h4>
                </center>                        
            </div>
        </div>
        <hr>
        <center>
            <div class="row">
            	<div class="col-xs-12 col-sm-12 col-md-12">
            		<button type="submit" class="btn btn-success btn-lg boton" id="btn_iniciar">
            			<span class="glyphicon glyphicon-user"></span>
	                    INICIAR SESIÓN | Admin
	                </button> 
                </div>
            	<div class="col-xs-12 col-sm-12 col-md-12 contenedor_login" id="div_login">
            		<form id="form" method="post" action="./php/login_administrador.php">
						<h1 class="titulo_login">ADMINISTRADOR</h1>
						<div class="inset">
							<p>
								<label for="usuario">NOMBRE USUARIO</label>
								<input type="text" name="usuario" id="usuario" class="form-control" placeholder="Usuario" required>
							</p>
							<p>
								<label for="password">CONTRASEÑA</label>
								<input type="password" name="password" id="password" class="form-control" placeholder="Contraseña" required>
							</p>
						</div>
						<p class="p-container">
							<button type="submit" name="" id="btn_login" value="Login" class="btn btn-info btn-sm boton_login">
			                    <strong>INICIAR SESIÓN</strong>
			                </button> 
						</p>
					</form>
                </div>
                <!-- Si existe la variable error se genera un mensaje de alerta --> 
                <?php 
					if(isset($_GET['error'])){
						echo '<script language="JavaScript"> alert("Datos de usuario no válidos!"); </script>';
					}
				?>
                <div class="col-xs-12 col-sm-12 col-md-12" id="div_btn_descargas">
                    <hr>
                    <!--<a href="http://www.montajesyprocesos.com/inspeccion/servidor/aplicacion/Inspeccion_MP-debug.apk">-->
                    <button type="submit" class="btn btn-success btn-lg boton" id="btn_descargas">
                        <span class="glyphicon glyphicon-cloud-download"></span>
                        DESCARGAS
                    </button> 
                </div> 
                <div class="col-xs-12 col-sm-12 col-md-12" id="div_btn_inspeccion_apk">
                    <!--<a href="http://www.montajesyprocesos.com/inspeccion/servidor/aplicacion/Inspeccion_MP-debug.apk">-->
                    <button type="submit" class="btn btn-success btn-lg boton" id="btn_descargar_inspeccion">
                        <span class="glyphicon glyphicon-phone"></span>
                        INSPECCIÓN MP (.apk)
                    </button> 
                </div> 
                <div class="col-xs-12 col-sm-12 col-md-12" id="div_btn_grabadora_apk">
                    <hr>
                    <!--<a href="http://www.montajesyprocesos.com/inspeccion/servidor/aplicacion/Inspeccion_MP-debug.apk">-->
                    <button type="submit" class="btn btn-success btn-lg boton" id="btn_descargar_grabadora">
                        <span class="glyphicon glyphicon-phone"></span>
                        GRABADORA SONIDOS (.apk)
                    </button> 
                </div>  
                <div class="col-xs-12 col-sm-12 col-md-12" id="div_btn_regresar">
                    <hr>
                    <!--<a href="http://www.montajesyprocesos.com/inspeccion/servidor/aplicacion/Inspeccion_MP-debug.apk">-->
                    <button type="submit" class="btn btn-success btn-lg boton" id="btn_regresar">
                        <span class="glyphicon glyphicon-backward"></span>
                        REGRESAR
                    </button> 
                </div> 
            </div>
            <br>             
        </center>   
        <hr>
        <footer>
            <div class="row">
                <div class="col-xs-12 col-md-12" style="text-align: center;">
                    <span style="color: #428bca;"><b>Montajes & Procesos M.P SAS</b></span>
                    <br>
                    <span id="fecha_footer" style="color: #428bca; font-size: 0.9em;"></span>
                    <br><br><br>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>