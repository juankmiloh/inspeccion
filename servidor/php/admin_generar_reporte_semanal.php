<?php
	ob_start(); //Linea para permitir enviar flujo de datos por url al redireccionar la pagina
	header("access-control-allow-origin: *");
	header("Content-Type: text/html; charset=iso-8859-1");
	include ("conexion_BD.php");
	require_once("./dompdf/dompdf_config.inc.php");
	include("./email/phpmailer.php");
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>REPORTE SEMANAL INSPECCIONES</title>
	<style type="text/css">
		html{font-family:sans-serif;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%}
        body{margin:0;}
        table{border-spacing:0;border-collapse:collapse;font-size:11px;width: 100%;}td,th{padding:0}
        .div_titulo{border: 0px solid; text-align: center; background-color: #5cb85c; height: 30px; padding-top: 1%;}
        .color_celda{background-color: #5cb85c; color: white;}
        .center{text-align: center;}
        .borde{border: 1px solid #000000;}
		.border-left{border-left: 1px solid #000000;}
		.border-right{border-right: 1px solid #000000;}
		.border-top{border-top: 1px solid #000000;}
		.border-bottom{border-bottom: 1px solid #000000;}
	</style>
</head>
<body>
	<div style="text-align: center;">
		<div class="sombra"><img src="../images/banner.png" alt="M.P SAS" style="width: 60%; height: auto;"></div><br>
		<div style="border: 1px solid green; width: 100%;"></div><br>
	</div>
	<div class="border-left border-right border-top border-bottom">
		<div class="div_titulo border-bottom">
			<span style="color: white;"><b>REPORTE DE INSPECCIONES</b></span>
		</div>
	<?php
		$bandera_error=0; //PERMITE CONTROLAR LA ACTUALIZACION DE LA TABLA reporte
		/*=============================================
		* SE OBTIENE LA FECHA ACTUAL DESDE LA BASE DE DATOS
		*==============================================*/
	    $sql="SELECT NOW()fecha_actual";
	    $result=mysqli_query($con, $sql);
	    $row = mysqli_fetch_array($result);
	   	$fecha_actual = $row['fecha_actual'];
	?>
		<div>
			<table>
				<tr>
					<td>Fecha Actual:</td>
					<td><? echo $fecha_actual;?></td>
				</tr>
	<?php
	    /*=============================================
		* SE HACE UN SELECT A LA TABLA reporte PARA CAPTURAR LA FECHA EN QUE SE GENERO EL ULTIMO REPORTE
		*==============================================*/
		$sql="SELECT * FROM reporte ORDER BY consecutivo DESC LIMIT 1";
	    $result=mysqli_query($con, $sql);
	    $row = mysqli_fetch_array($result);
	    $f_ultimo_reporte = $row['f_reporte'];
	?>	
				<tr>
					<td>Fecha último reporte:</td>
					<td><? echo $f_ultimo_reporte;?></td>
				</tr>
	<?php
	    /*=============================================
		* SE HACE UN SELECT A LA TABLA USUARIOS PARA SABER CUANTOS INSPECTORES HAY
		* SE QUITA EL INSPECTOR DE PRUEBA JUAN CAMILO Y EL USUARIO ADMINISTRADOR
		*==============================================*/
		$sql="SELECT * FROM usuarios WHERE o_rol<>'Administrador' AND o_rol<>'Inspector_prueba'";
	    $result=mysqli_query($con, $sql);
	    $numero_usuarios=mysqli_num_rows($result);
	?>	
				<tr>
					<td>Número de inspectores:</td>
					<td><? echo $numero_usuarios;?></td>
				</tr>
			</table>
		</div>

		<!-- 
		* REPORTE ASCENSORES 
		-->

		<div class="div_titulo border-top border-bottom">
			<span style="color: white;"><b>NÚMERO TOTAL DE INSPECCIONES REALIZADAS A ASCENSORES</b></span>
		</div>
		<div>
			<br>
			<center>
			<table border="0" style="padding-left: 30%; padding-right: 25%;">
				<tr>
					<th class="color_celda border-top border-bottom border-left border-right">INSPECTOR</th>
					<th class="color_celda border-top border-bottom border-left border-right">CANTIDAD</th>
				</tr>
	<?php
		/*=============================================
		* SE HACE UN SELECT A LA TABLA AUDITORIA CON CADA USUARIO PARA SABER EL NUMERO DE INSPECCIONES REALIZADAS
		* POR INSPECTOR, SE HACE UN SELECT A LA TABLA USUARIOS PARA SABER EL NOMBRE DEL INSPECTOR
		*==============================================*/
		$sql="SELECT * FROM usuarios ORDER BY k_codusuario ASC";
		$result=mysqli_query($con, $sql);
		$numero_total_usuarios=mysqli_num_rows($result);
	    //echo $numero_total_usuarios;
	    /*=============================================
		* SE HACE UN SELECT A LA TABLA AUDITORIA CON CADA USUARIO PARA SABER EL NUMERO DE INSPECCIONES REALIZADAS
		* POR INSPECTOR, SE HACE UN SELECT A LA TABLA USUARIOS PARA SABER EL NOMBRE DEL INSPECTOR
		*==============================================*/
		$numero_total_inspecciones = 0;
		for ($i=0; $i < $numero_total_usuarios; $i++) {
			$sql="SELECT * FROM usuarios WHERE k_codusuario=".$i."";
		    $result=mysqli_query($con, $sql);
		    $row = mysqli_fetch_array($result);
		    $n_usuario = $row['n_usuario'];
			$n_nombre = $row['n_nombre'];
			$n_apellido = $row['n_apellido'];
		    $o_rol = $row['o_rol'];

			if ($o_rol == "Inspector") {
				$sql="SELECT * FROM auditoria_inspecciones_ascensores WHERE k_codusuario=".$i."";
				$result=mysqli_query($con, $sql);
				$numero_inspecciones = mysqli_num_rows($result);
				$numero_total_inspecciones += $numero_inspecciones;
	?>
				<tr>
					<td class="border-top border-bottom border-left border-right"><? echo $n_nombre." ".$n_apellido;?></td>
					<td class="border-top border-bottom border-right"style="text-align: center;"><? echo $numero_inspecciones;?></td>
				</tr>
	<?php
			}
		}
	?>
				<tr>
					<td class="color_celda border-bottom border-left border-right" style="text-align: right;"><b>TOTAL</td>
					<td class="border-bottom border-right" style="text-align: center;"><? echo $numero_total_inspecciones;?></td>
				</tr>
			</table>
			</center>
			<br>
		</div>
		<div class="div_titulo border-top border-bottom">
			<span style="color: white;"><b>REPORTE SEMANAL ASCENSORES</b></span>
		</div>
		<div>
			<br><center>
			<table style="width: 100%;">
				<tr>
					<th class="color_celda border-top border-bottom border-right">INSPECTOR</th>
					<th class="color_celda border-top border-bottom border-right">CONSECUTIVO</th>
					<th class="color_celda border-top border-bottom border-right">CLIENTE</th>
					<th class="color_celda border-top border-bottom border-right">FECHA INSPECCIÓN</th>
					<th class="color_celda border-top border-bottom">FECHA CARGA</th>
				</tr>
	<?php
	    /*=============================================
		* SE HACE UN SELECT A LA TABLA auditoria VERIFICANDO LAS INSPECCIONES CON FECHA 
		* DE CARGA AL SERVIDOR MAYORES A LA FECHA DEL ULTIMO REPORTE SEMANAL GENERADO
		*==============================================*/
		$numero_total_inspecciones = 0;
		for ($i=0; $i < $numero_total_usuarios; $i++) {
			$sql="SELECT * FROM usuarios WHERE k_codusuario=".$i."";
		    $result=mysqli_query($con, $sql);
		    $row = mysqli_fetch_array($result);
		    $n_usuario = $row['n_usuario'];
			$n_nombre = $row['n_nombre'];
			$n_apellido = $row['n_apellido'];
		    $o_rol = $row['o_rol'];

			if ($o_rol == "Inspector") {
				/*=============================================
				* SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LOS DATOS DE LA INSPECCION
				*==============================================*/
				$sql  = 'SELECT * FROM auditoria_inspecciones_ascensores WHERE k_codusuario='.$i.' AND f_carga_servidor > \''.$f_ultimo_reporte.'\'';
				if (mysqli_query($con,$sql) == true){
					$result=mysqli_query($con, $sql);
					$numero_inspecciones=mysqli_num_rows($result);
					$numero_total_inspecciones += $numero_inspecciones;
					while($row = mysqli_fetch_array($result)){
						$o_consecutivoinsp = $row['o_consecutivoinsp'];
						$k_codinspeccion = $row['k_codinspeccion'];
						$f_carga_servidor = $row['f_carga_servidor'];
						/*=============================================
						* SE HACE UN SELECT A LA TABLA DE VALORES INICIALES PARA OBTENER EL NOMBRE DEL CLIENTE
						*==============================================*/
						$sql_cliente="SELECT * FROM ascensor_valores_iniciales WHERE k_codusuario=".$i." AND k_codinspeccion=".$k_codinspeccion."";
						$result_cliente=mysqli_query($con, $sql_cliente);
					    $row_cliente = mysqli_fetch_array($result_cliente);
					   	$n_cliente = $row_cliente['n_cliente'];
					   	$f_fecha = $row_cliente['f_fecha'];
	?>
				<tr>
					<td class="center border-bottom border-right"><? echo $n_nombre." ".$n_apellido;?></td>
					<td class="center border-bottom border-right"><? echo $o_consecutivoinsp;?></td>
					<td class="center border-bottom border-right"><? echo $n_cliente;?></td>
					<td class="center border-bottom border-right"><? echo $f_fecha;?></td>
					<td class="center border-bottom"><? echo $f_carga_servidor;?></td>
				</tr>
	<?php
					}	    	
				}else{
					$bandera_error+=1;
					echo $con->error."\nerror: ". $sql . "<br>";
				}
			}
		}
	?>
			</table><br>
			<div class="border-top border-bottom">
				<span>*NÚMERO TOTAL DE INSPECCIONES REALIZADAS A ASCENSORES EN LA SEMANA => <? echo $numero_total_inspecciones;?></span>
			</div>
			</center><br>
		</div>

		<!-- 
		* REPORTE PUERTAS 
		-->

		<div class="div_titulo border-top border-bottom">
			<span style="color: white;"><b>NÚMERO TOTAL DE INSPECCIONES REALIZADAS A PUERTAS</b></span>
		</div>
		<div>
			<br>
			<center>
			<table border="0" style="padding-left: 30%; padding-right: 25%;">
				<tr>
					<th class="color_celda border-top border-bottom border-left border-right">INSPECTOR</th>
					<th class="color_celda border-top border-bottom border-left border-right">CANTIDAD</th>
				</tr>
	<?php
		/*=============================================
		* SE HACE UN SELECT A LA TABLA AUDITORIA CON CADA USUARIO PARA SABER EL NUMERO DE INSPECCIONES REALIZADAS
		* POR INSPECTOR, SE HACE UN SELECT A LA TABLA USUARIOS PARA SABER EL NOMBRE DEL INSPECTOR
		*==============================================*/
		$sql="SELECT * FROM usuarios ORDER BY k_codusuario ASC";
		$result=mysqli_query($con, $sql);
		$numero_total_usuarios=mysqli_num_rows($result);
	    //echo $numero_total_usuarios;
	    /*=============================================
		* SE HACE UN SELECT A LA TABLA AUDITORIA CON CADA USUARIO PARA SABER EL NUMERO DE INSPECCIONES REALIZADAS
		* POR INSPECTOR, SE HACE UN SELECT A LA TABLA USUARIOS PARA SABER EL NOMBRE DEL INSPECTOR
		*==============================================*/
		$numero_total_inspecciones = 0;
		for ($i=0; $i < $numero_total_usuarios; $i++) {
			$sql="SELECT * FROM usuarios WHERE k_codusuario=".$i."";
		    $result=mysqli_query($con, $sql);
		    $row = mysqli_fetch_array($result);
		    $n_usuario = $row['n_usuario'];
			$n_nombre = $row['n_nombre'];
			$n_apellido = $row['n_apellido'];
		    $o_rol = $row['o_rol'];

			if ($o_rol == "Inspector") {
				$sql="SELECT * FROM auditoria_inspecciones_puertas WHERE k_codusuario=".$i."";
				$result=mysqli_query($con, $sql);
				$numero_inspecciones = mysqli_num_rows($result);
				$numero_total_inspecciones += $numero_inspecciones;
	?>
				<tr>
					<td class="border-top border-bottom border-left border-right"><? echo $n_nombre." ".$n_apellido;?></td>
					<td class="border-top border-bottom border-right"style="text-align: center;"><? echo $numero_inspecciones;?></td>
				</tr>
	<?php
			}
		}
	?>
				<tr>
					<td class="color_celda border-bottom border-left border-right" style="text-align: right;"><b>TOTAL</td>
					<td class="border-bottom border-right" style="text-align: center;"><? echo $numero_total_inspecciones;?></td>
				</tr>
			</table>
			</center>
			<br>
		</div>
		<div class="div_titulo border-top border-bottom">
			<span style="color: white;"><b>REPORTE SEMANAL PUERTAS</b></span>
		</div>
		<div>
			<br><center>
			<table style="width: 100%;">
				<tr>
					<th class="color_celda border-top border-bottom border-right">INSPECTOR</th>
					<th class="color_celda border-top border-bottom border-right">CONSECUTIVO</th>
					<th class="color_celda border-top border-bottom border-right">CLIENTE</th>
					<th class="color_celda border-top border-bottom border-right">FECHA INSPECCIÓN</th>
					<th class="color_celda border-top border-bottom">FECHA CARGA</th>
				</tr>
	<?php
	    /*=============================================
		* SE HACE UN SELECT A LA TABLA auditoria VERIFICANDO LAS INSPECCIONES CON FECHA 
		* DE CARGA AL SERVIDOR MAYORES A LA FECHA DEL ULTIMO REPORTE SEMANAL GENERADO
		*==============================================*/
		$numero_total_inspecciones = 0;
		for ($i=0; $i < $numero_total_usuarios; $i++) {
			$sql="SELECT * FROM usuarios WHERE k_codusuario=".$i."";
		    $result=mysqli_query($con, $sql);
		    $row = mysqli_fetch_array($result);
		    $n_usuario = $row['n_usuario'];
			$n_nombre = $row['n_nombre'];
			$n_apellido = $row['n_apellido'];
		    $o_rol = $row['o_rol'];

			if ($o_rol == "Inspector") {
				/*=============================================
				* SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LOS DATOS DE LA INSPECCION
				*==============================================*/
				$sql  = 'SELECT * FROM auditoria_inspecciones_puertas WHERE k_codusuario='.$i.' AND f_carga_servidor > \''.$f_ultimo_reporte.'\'';
				if (mysqli_query($con,$sql) == true){
					$result=mysqli_query($con, $sql);
					$numero_inspecciones=mysqli_num_rows($result);
					$numero_total_inspecciones += $numero_inspecciones;
					while($row = mysqli_fetch_array($result)){
						$o_consecutivoinsp = $row['o_consecutivoinsp'];
						$k_codinspeccion = $row['k_codinspeccion'];
						$f_carga_servidor = $row['f_carga_servidor'];
						/*=============================================
						* SE HACE UN SELECT A LA TABLA DE VALORES INICIALES PARA OBTENER EL NOMBRE DEL CLIENTE
						*==============================================*/
						$sql_cliente="SELECT * FROM puertas_valores_iniciales WHERE k_codusuario=".$i." AND k_codinspeccion=".$k_codinspeccion."";
						$result_cliente=mysqli_query($con, $sql_cliente);
					    $row_cliente = mysqli_fetch_array($result_cliente);
					   	$n_cliente = $row_cliente['n_cliente'];
					   	$f_fecha = $row_cliente['f_fecha'];
	?>
				<tr>
					<td class="center border-bottom border-right"><? echo $n_nombre." ".$n_apellido;?></td>
					<td class="center border-bottom border-right"><? echo $o_consecutivoinsp;?></td>
					<td class="center border-bottom border-right"><? echo $n_cliente;?></td>
					<td class="center border-bottom border-right"><? echo $f_fecha;?></td>
					<td class="center border-bottom"><? echo $f_carga_servidor;?></td>
				</tr>
	<?php
					}	    	
				}else{
					$bandera_error+=1;
					echo $con->error."\nerror: ". $sql . "<br>";
				}
			}
		}
	?>
			</table><br>
			<div class="border-top border-bottom">
				<span>*NÚMERO TOTAL DE INSPECCIONES REALIZADAS A PUERTAS EN LA SEMANA => <? echo $numero_total_inspecciones;?></span>
			</div>
			</center><br>
		</div>
		
		<!-- 
		* REPORTE ESCALERAS 
		-->

		<div class="div_titulo border-top border-bottom">
			<span style="color: white;"><b>NÚMERO TOTAL DE INSPECCIONES REALIZADAS A ESCALERAS</b></span>
		</div>
		<div>
			<br>
			<center>
			<table border="0" style="padding-left: 30%; padding-right: 25%;">
				<tr>
					<th class="color_celda border-top border-bottom border-left border-right">INSPECTOR</th>
					<th class="color_celda border-top border-bottom border-left border-right">CANTIDAD</th>
				</tr>
	<?php
		/*=============================================
		* SE HACE UN SELECT A LA TABLA AUDITORIA CON CADA USUARIO PARA SABER EL NUMERO DE INSPECCIONES REALIZADAS
		* POR INSPECTOR, SE HACE UN SELECT A LA TABLA USUARIOS PARA SABER EL NOMBRE DEL INSPECTOR
		*==============================================*/
		$sql="SELECT * FROM usuarios ORDER BY k_codusuario ASC";
		$result=mysqli_query($con, $sql);
		$numero_total_usuarios=mysqli_num_rows($result);
	    //echo $numero_total_usuarios;
	    /*=============================================
		* SE HACE UN SELECT A LA TABLA AUDITORIA CON CADA USUARIO PARA SABER EL NUMERO DE INSPECCIONES REALIZADAS
		* POR INSPECTOR, SE HACE UN SELECT A LA TABLA USUARIOS PARA SABER EL NOMBRE DEL INSPECTOR
		*==============================================*/
		$numero_total_inspecciones = 0;
		for ($i=0; $i < $numero_total_usuarios; $i++) {
			$sql="SELECT * FROM usuarios WHERE k_codusuario=".$i."";
		    $result=mysqli_query($con, $sql);
		    $row = mysqli_fetch_array($result);
		    $n_usuario = $row['n_usuario'];
			$n_nombre = $row['n_nombre'];
			$n_apellido = $row['n_apellido'];
		    $o_rol = $row['o_rol'];

			if ($o_rol == "Inspector") {
				$sql="SELECT * FROM auditoria_inspecciones_escaleras WHERE k_codusuario=".$i."";
				$result=mysqli_query($con, $sql);
				$numero_inspecciones = mysqli_num_rows($result);
				$numero_total_inspecciones += $numero_inspecciones;
	?>
				<tr>
					<td class="border-top border-bottom border-left border-right"><? echo $n_nombre." ".$n_apellido;?></td>
					<td class="border-top border-bottom border-right"style="text-align: center;"><? echo $numero_inspecciones;?></td>
				</tr>
	<?php
			}
		}
	?>
				<tr>
					<td class="color_celda border-bottom border-left border-right" style="text-align: right;"><b>TOTAL</td>
					<td class="border-bottom border-right" style="text-align: center;"><? echo $numero_total_inspecciones;?></td>
				</tr>
			</table>
			</center>
			<br>
		</div>
		<div class="div_titulo border-top border-bottom">
			<span style="color: white;"><b>REPORTE SEMANAL ESCALERAS</b></span>
		</div>
		<div>
			<br><center>
			<table style="width: 100%;">
				<tr>
					<th class="color_celda border-top border-bottom border-right">INSPECTOR</th>
					<th class="color_celda border-top border-bottom border-right">CONSECUTIVO</th>
					<th class="color_celda border-top border-bottom border-right">CLIENTE</th>
					<th class="color_celda border-top border-bottom border-right">FECHA INSPECCIÓN</th>
					<th class="color_celda border-top border-bottom">FECHA CARGA</th>
				</tr>
	<?php
	    /*=============================================
		* SE HACE UN SELECT A LA TABLA auditoria VERIFICANDO LAS INSPECCIONES CON FECHA 
		* DE CARGA AL SERVIDOR MAYORES A LA FECHA DEL ULTIMO REPORTE SEMANAL GENERADO
		*==============================================*/
		$numero_total_inspecciones = 0;
		for ($i=0; $i < $numero_total_usuarios; $i++) {
			$sql="SELECT * FROM usuarios WHERE k_codusuario=".$i."";
		    $result=mysqli_query($con, $sql);
		    $row = mysqli_fetch_array($result);
		    $n_usuario = $row['n_usuario'];
			$n_nombre = $row['n_nombre'];
			$n_apellido = $row['n_apellido'];
		    $o_rol = $row['o_rol'];

			if ($o_rol == "Inspector") {
				/*=============================================
				* SE HACE UN SELECT A LA TABLA DE AUDITORIA PARA OBTENER LOS DATOS DE LA INSPECCION
				*==============================================*/
				$sql  = 'SELECT * FROM auditoria_inspecciones_escaleras WHERE k_codusuario='.$i.' AND f_carga_servidor > \''.$f_ultimo_reporte.'\'';
				if (mysqli_query($con,$sql) == true){
					$result=mysqli_query($con, $sql);
					$numero_inspecciones=mysqli_num_rows($result);
					$numero_total_inspecciones += $numero_inspecciones;
					while($row = mysqli_fetch_array($result)){
						$o_consecutivoinsp = $row['o_consecutivoinsp'];
						$k_codinspeccion = $row['k_codinspeccion'];
						$f_carga_servidor = $row['f_carga_servidor'];
						/*=============================================
						* SE HACE UN SELECT A LA TABLA DE VALORES INICIALES PARA OBTENER EL NOMBRE DEL CLIENTE
						*==============================================*/
						$sql_cliente="SELECT * FROM escaleras_valores_iniciales WHERE k_codusuario=".$i." AND k_codinspeccion=".$k_codinspeccion."";
						$result_cliente=mysqli_query($con, $sql_cliente);
					    $row_cliente = mysqli_fetch_array($result_cliente);
					   	$n_cliente = $row_cliente['n_cliente'];
					   	$f_fecha = $row_cliente['f_fecha'];
	?>
				<tr>
					<td class="center border-bottom border-right"><? echo $n_nombre." ".$n_apellido;?></td>
					<td class="center border-bottom border-right"><? echo $o_consecutivoinsp;?></td>
					<td class="center border-bottom border-right"><? echo $n_cliente;?></td>
					<td class="center border-bottom border-right"><? echo $f_fecha;?></td>
					<td class="center border-bottom"><? echo $f_carga_servidor;?></td>
				</tr>
	<?php
					}	    	
				}else{
					$bandera_error+=1;
					echo $con->error."\nerror: ". $sql . "<br>";
				}
			}
		}
	?>
			</table><br>
			<div class="border-top border-bottom">
				<span>*NÚMERO TOTAL DE INSPECCIONES REALIZADAS A ESCALERAS EN LA SEMANA => <? echo $numero_total_inspecciones;?></span>
			</div>
			</center><br>
		</div>
	</div>
</body>
</html>
<?php
	if ($bandera_error == 0) {
		// echo $bandera_error;
		/*========================================================================
		* VAMOS A EXPORTAR COMO PDF EL REPORTE ANTERIORMENTE GENERADO EN HTML
		* EL PDF SE CREA CAPTURANDO TODO EL HTML GENERADO ANTERIORMENTE
		*========================================================================*/
		crearPDF($fecha_actual);
		/*=============================================
		* SE HACE UN INSERT A LA TABLA reporte CON LA NUEVA FECHA EN QUE ENVIA EL REPORTE
		*==============================================*/
		$sql="INSERT INTO reporte(f_reporte,n_archivo_reporte) VALUES(now(),'reporte_".$fecha_actual.".pdf')";
		if (mysqli_query($con,$sql) == true){
			// echo "Se guardo con éxito el registro del reporte!";
		}
	}else{
		echo "Ocurrio un error en la carga de datos!";
	}

	/*========================================================================
	* FUNCION PARA CREAR EL PDF DEL REPORTE
	*========================================================================*/
	function crearPDF($fecha_actual){
		$dompdf = new DOMPDF();
		$dompdf -> set_paper("A4", "portrait");
		$dompdf -> load_html(ob_get_clean());
		$dompdf -> render();
		// $dompdf->stream(); //LINEA QUE PERMITE DESCARGAR EL PDF GENERADO
		$file_to_save = "../reportes/reporte_".$fecha_actual.".pdf";
		mkdir(dirname($file_to_save), 0777, true); //esta linea es para crear el directorio si no existe
		file_put_contents($file_to_save, $dompdf->output());
		/*========================================================================
		* VAMOS A ENVIAR EL REPORTE POR CORREO
		*========================================================================*/
		enviarReporteCorreo($fecha_actual);
	}

	/*========================================================================
	* FUNCION QUE PERMITE EL ENVIO DE CORREO ELECTRONICO
	*========================================================================*/
	function enviarReporteCorreo($fecha_actual){
		/*========================================================================
		* CODIGO PARA ENVIAR EL CORREO ELECTRONICO ADJUNTANDO EL ARCHIVO DE PUBLICACION
		*========================================================================*/
		$bandera="";
	    $smtp=new PHPMailer();

		# Indicamos que vamos a utilizar un servidor SMTP
		$smtp->IsSMTP();

		# Definimos el formato del correo con UTF-8
		$smtp->CharSet="UTF-8";

		# autenticación contra nuestro servidor smtp
		$smtp->SMTPAuth   = true;
		$smtp->SMTPSecure = "ssl";
		$smtp->Host       = "smtp.gmail.com";
		$smtp->Username   = "montajesyprocesoss@gmail.com";
		$smtp->Password   = "montajes";
		$smtp->Port       = 465;
		$smtp->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only

		# datos de quien realiza el envio
		$smtp->From       = "correoQueEnviaElMensaje@miservidor.com"; // from mail
		//$smtp->FromName   = "Nombre persona que envia el correo"; // from mail name
		$smtp->FromName   = "MONTAJES & PROCESOS M.P SAS"; // from mail session_name()

		# Indicamos las direcciones donde enviar el mensaje con el formato
		#   "correo"=>"nombre usuario"
		# Se pueden poner tantos correos como se deseen
		$mailTo=array(
		    // "mgonzalez@montajesyprocesos.com"=>"Correo Administrador",
		    // "rcardenas@montajesyprocesos.com"=>"Correo Administrador",
		    // "aux.contable@montajesyprocesos.com"=>"Correo Contadora",
		    "juankmiloh@hotmail.com"=>"Correo Administrador"
		);

		# establecemos un limite de caracteres de anchura
		$smtp->WordWrap   = 50; // set word wrap

		# NOTA: Los correos es conveniente enviarlos en formato HTML y Texto para que
		# cualquier programa de correo pueda leerlo.

		# Definimos el contenido HTML del correo
		$contenidoHTML='<html lang="es">';
		$contenidoHTML='<head><meta http-equiv="Content-Type" content="text/html; charset=big5">';
		$contenidoHTML.='';
		$contenidoHTML.='</head><body>';    
		$contenidoHTML.='Sr. <b>Administrador</b>, <br><br>Adjunto a este correo se envia el <b>reporte semanal</b> de las inspecciones realizadas a través de la aplicación móvil <b>Inspeccion_mp</b>.';
		$contenidoHTML.='<br><br>Cordialmente,';
		$contenidoHTML.='<br><br><center><img src="../images/mp_sas.jpg" alt="M.P SAS"></center><br><br>';
		$contenidoHTML.='</body>';
		$contenidoHTML.='</html>';

		# Definimos el contenido en formato Texto del correo
		$contenidoTexto='Visite nuestra página web: ';
		$contenidoTexto.='http://www.montajesyprocesos.com';

		# Definimos el subject
		$smtp->Subject="REPORTE SEMANAL DE INSPECCIONES";

		# Adjuntamos el archivo "leameLWP.txt" al correo.
		# Obtenemos la ruta absoluta de donde se ejecuta este script para encontrar el
		# archivo leameLWP.txt para adjuntar. Por ejemplo, si estamos ejecutando nuestro
		# script en: /home/xve/test/sendMail.php, nos interesa obtener unicamente:
		# /home/xve/test para posteriormente adjuntar el archivo leameLWP.txt, quedando
		# /home/xve/test/leameLWP.txt
		//$rutaAbsoluta=substr($_SERVER["SCRIPT_FILENAME"],0,strrpos($_SERVER["SCRIPT_FILENAME"],"/"));

		/*=============================================
		* PARTE DEL CODIGO DONDE SE ESPECIFICA LA RUTA DEL ARCHIVO PDF DEL REGISTRO DE INSPECCION QUE SE GENERA LUEGO DE ENVIAR LOS DATOS DE LA INSPECCION DESDE EL DISPOSITIVO AL SERVIDOR SE RECORRE LA CARPETA Y SE ADJUNTAN LOS PDF´s ENCONTARDOS AL ENVIO DEL CORREO ELECTRONICO
		*==============================================*/
		$smtp->AddAttachment("../reportes/reporte_".$fecha_actual.".pdf", "reporte_".$fecha_actual.".pdf");

		# Indicamos el contenido
		$smtp->AltBody=$contenidoTexto; //Text Body
		$smtp->MsgHTML($contenidoHTML); //Text body HTML

		foreach($mailTo as $mail=>$name)
		{
		    $smtp->ClearAllRecipients();
		    $smtp->AddAddress($mail,$name);

		    if(!$smtp->Send())
		    {
		        //echo "<br>Error (".$mail."): ".$smtp->ErrorInfo;
		        $bandera=1;
		    }else{
		        $bandera=0;
		        //echo "<br>Envio realizado a ".$name." (".$mail.")";
		    }
		}

		/*=============================================
		* Hacemos una validacion final para corroborar que se envio el correo a todos los destinatarios, 
		* poder enviar un mensaje de exito y poder borrar los archivos PDF de registros de inspecciones
		*==============================================*/
		if($bandera == 0){
		    // echo "envio de correo exitoso!";
		}
		ob_end_flush();
	}
?>