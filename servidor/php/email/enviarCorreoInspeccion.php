<?php
/**
 * Envio de correo mediante un servidor SMTP
 */
header("access-control-allow-origin: *");
header("Content-Type: text/html; charset=iso-8859-1");
ob_start(); //Linea para permitir enviar flujo de datos por url al redireccionar la pagina 
include("phpmailer.php");
error_reporting(0); // Desactivar toda notificación de error 
$correo=$_POST['correo'];
$codigo_inspector_url=$_POST['codigo_inspector'];
$nombre_empresa=$_POST['nombre_empresa'];

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
    $correo=>$nombre_empresa,
    //"juankmiloardila@gmail.com"=>"Correo Administrador"
    //"rcardenas@montajesyprocesos.com"=>"Correo Administrador"
    "juankmiloh@hotmail.com"=>"Correo Administrador"
    //"correo_3_DondeSeEnviaElMensaje@servidor.info"=>"Nombre_3 persona que recibe el correo"
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
$contenidoHTML.='Sres. <b>'.$nombre_empresa.'</b>, <br><br>Adjunto a este correo se envian las inspecciones realizadas.';
$contenidoHTML.='<br><br>Cordialmente,';
$contenidoHTML.='<br><br><center><img src="../../images/mp_sas.jpg" alt="M.P SAS"></center><br><br>';
$contenidoHTML.='</body>';
$contenidoHTML.='</html>';

# Definimos el contenido en formato Texto del correo
$contenidoTexto='Visite nuestra página web: ';
$contenidoTexto.='http://agiliza.byethost13.com';

# Definimos el subject
$smtp->Subject="Inspecciones - ".$nombre_empresa;

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

/*=============================================
****************** ASCENSORES *****************
*==============================================*/

$directory="../../ascensores/inspector_".$codigo_inspector_url."/registros_pdf"; // directorio de donde se encuentran los archivos en el servidor
mkdir($directory, 0777, true); //esta linea es para crear el directorio si no existe
$dirint = dir($directory);
while (($archivo = $dirint->read()) !== false)
{
    if ($archivo != "." and $archivo != ".DS_Store" and $archivo != ".txt" and $archivo != "..") {
        //echo $archivo;
        $smtp->AddAttachment("../../ascensores/inspector_".$codigo_inspector_url."/registros_pdf/".$archivo, $archivo);
    }
}
//cerramos la conexion con el directorio de los archivos del servidor
$dirint->close();

/*=============================================
****************** PUERTAS *****************
*==============================================*/

$directory="../../puertas/inspector_".$codigo_inspector_url."/registros_pdf"; // directorio de donde se encuentran los archivos en el servidor
mkdir($directory, 0777, true); //esta linea es para crear el directorio si no existe
$dirint = dir($directory); 
while (($archivo = $dirint->read()) !== false)
{
    if ($archivo != "." and $archivo != ".DS_Store" and $archivo != ".txt" and $archivo != "..") {
        $smtp->AddAttachment("../../puertas/inspector_".$codigo_inspector_url."/registros_pdf/".$archivo, $archivo);
    }
}
//cerramos la conexion con el directorio de los archivos del servidor
$dirint->close();

/*=============================================
****************** ESCALERAS *****************
*==============================================*/

$directory="../../escaleras/inspector_".$codigo_inspector_url."/registros_pdf"; // directorio de donde se encuentran los archivos en el servidor
mkdir($directory, 0777, true); //esta linea es para crear el directorio si no existe
$dirint = dir($directory);
while (($archivo = $dirint->read()) !== false)
{
    if ($archivo != "." and $archivo != ".DS_Store" and $archivo != ".txt" and $archivo != "..") {
        //echo $archivo;
        $smtp->AddAttachment("../../escaleras/inspector_".$codigo_inspector_url."/registros_pdf/".$archivo, $archivo);
    }
}
//cerramos la conexion con el directorio de los archivos del servidor
$dirint->close();

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
    /*=============================================
    ****************** ASCENSORES *****************
    *==============================================*/

    $directory="../../ascensores/inspector_".$codigo_inspector_url."/registros_pdf"; // directorio de donde se encuentran los archivos en el servidor
    $dirint = dir($directory);
    while (($archivo = $dirint->read()) !== false)
    {
        if ($archivo != "." and $archivo != ".DS_Store" and $archivo != ".txt" and $archivo != "..") {
            //echo $archivo;
            unlink("../../ascensores/inspector_".$codigo_inspector_url."/registros_pdf/".$archivo);
            $bandera=0;
        }
    }
    //cerramos la conexion con el directorio de los archivos del servidor
    $dirint->close();

    /*=============================================
    ****************** PUERTAS *****************
    *==============================================*/
    
    $directory="../../puertas/inspector_".$codigo_inspector_url."/registros_pdf"; // directorio de donde se encuentran los archivos en el servidor
    $dirint = dir($directory);
    while (($archivo = $dirint->read()) !== false)
    {
        if ($archivo != "." and $archivo != ".DS_Store" and $archivo != ".txt" and $archivo != "..") {
            //echo $archivo;
            unlink("../../puertas/inspector_".$codigo_inspector_url."/registros_pdf/".$archivo);
            $bandera=0;
        }
    }
    //cerramos la conexion con el directorio de los archivos del servidor
    $dirint->close();

    /*=============================================
    ****************** ESCALERAS *****************
    *==============================================*/
    
    $directory="../../escaleras/inspector_".$codigo_inspector_url."/registros_pdf"; // directorio de donde se encuentran los archivos en el servidor
    $dirint = dir($directory);
    while (($archivo = $dirint->read()) !== false)
    {
        if ($archivo != "." and $archivo != ".DS_Store" and $archivo != ".txt" and $archivo != "..") {
            //echo $archivo;
            unlink("../../escaleras/inspector_".$codigo_inspector_url."/registros_pdf/".$archivo);
            $bandera=0;
        }
    }
    //cerramos la conexion con el directorio de los archivos del servidor
    $dirint->close();
}

echo $bandera;
ob_end_flush();
?>