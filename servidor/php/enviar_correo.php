<?php
	ob_start(); //Linea para permitir enviar flujo de datos por url al redireccionar la pagina
	header("access-control-allow-origin: *");
	header("Content-Type: text/html; charset=iso-8859-1");
	include ("conexion_BD.php");
	//require_once("./dompdf/dompdf_config.inc.php");
	include("./email/phpmailer.php");
?>


<?php
	enviarReporteCorreo();
	/*========================================================================
	* FUNCION QUE PERMITE EL ENVIO DE CORREO ELECTRONICO
	*========================================================================*/
	function enviarReporteCorreo(){
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
		$smtp->Username   = "juankmiloardila@gmail.com";
		$smtp->Password   = "anamaria26";
		$smtp->Port       = 465;
		$smtp->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only

		# datos de quien realiza el envio
		$smtp->From       = "correoQueEnviaElMensaje@miservidor.com"; // from mail
		//$smtp->FromName   = "Nombre persona que envia el correo"; // from mail name
		$smtp->FromName   = "Empresa"; // from mail session_name()

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
		$contenidoTexto.='http://agiliza.byethost13.com';

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
		//$smtp->AddAttachment("../reportes/reporte_".$fecha_actual.".pdf", "reporte_".$fecha_actual.".pdf");

		# Indicamos el contenido
		$smtp->AltBody=$contenidoTexto; //Text Body
		$smtp->MsgHTML($contenidoHTML); //Text body HTML

		foreach($mailTo as $mail=>$name)
		{
		    $smtp->ClearAllRecipients();
		    $smtp->AddAddress($mail,$name);

		    if(!$smtp->Send())
		    {
		        echo "<br>Error (".$mail."): ".$smtp->ErrorInfo;
		        $bandera=1;
		    }else{
		        $bandera=0;
		        echo "<br>Envio realizado a ".$name." (".$mail.")";
		    }
		}

		/*=============================================
		* Hacemos una validacion final para corroborar que se envio el correo a todos los destinatarios, 
		* poder enviar un mensaje de exito y poder borrar los archivos PDF de registros de inspecciones
		*==============================================*/
		if($bandera == 0){
		    echo "envio de correo exitoso!";
		}
	}
?>