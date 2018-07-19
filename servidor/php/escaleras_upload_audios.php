<?php
    header('Access-Control-Allow-Origin: *');
    //print_r($_SERVER);
    $nombre_archivo = $_GET["archivo"];
    //print_r($nombre_archivo);
    
    $valor = explode("-", $nombre_archivo); //divide el texto en un arreglo
    $codigo_inspector = $valor[0];
    $codigo_inspeccion = (int)$valor[1]; //(int) para convertir el codigo de inspeccion a entero y poder eliminar los ceros iniciales

    $valor_1 = explode("ESC", $codigo_inspector); //divide el texto en un arreglo
    $codigo_inspector_1 = $valor_1[1];

    $file_to_save = "../escaleras/inspector_".$codigo_inspector_1."/audios/".$codigo_inspeccion."/".$nombre_archivo;
    mkdir(dirname($file_to_save), 0777, true); //esta linea es para crear el directorio si no existe

    // linea para mover la foto recibida desde el dispositivo a la carpeta del servidor
    file_put_contents($file_to_save, file_get_contents('php://input'));
?>

<?php
	// header("access-control-allow-origin: *");
	// //print_r($_FILES);
	// $nombre_archivo = $_FILES["file"]["name"];

	// $valor = explode("-", $nombre_archivo); //divide el texto en un arreglo
 //    $codigo_inspector = $valor[0];
 //    $codigo_inspeccion = (int)$valor[1];

 //    $valor_1 = explode("ESC", $codigo_inspector); //divide el texto en un arreglo
 //    $codigo_inspector_1 = $valor_1[1];

 //    $file_to_save = "../escaleras/inspector_".$codigo_inspector_1."/audios/".$codigo_inspeccion."/".$nombre_archivo;
 //   	mkdir(dirname($file_to_save), 0777, true); //esta linea es para crear el directorio si no existe

	// move_uploaded_file($_FILES["file"]["tmp_name"], "/Applications/MAMP/htdocs/inspeccion/servidor/escaleras/inspector_".$codigo_inspector_1."/audios/".$codigo_inspeccion."/".$nombre_archivo);
?>

<?php
    // header("access-control-allow-origin: *");
    // //print_r($_FILES);
    // $nombre_archivo = $_FILES["file"]["name"];

    // $valor = explode("-", $nombre_archivo); //divide el texto en un arreglo
    // $codigo_inspector = $valor[0];
    // $codigo_inspeccion = (int)$valor[1];

    // $valor_1 = explode("ESC", $codigo_inspector); //divide el texto en un arreglo
    // $codigo_inspector_1 = $valor_1[1];

    // $file_to_save = "../escaleras/inspector_".$codigo_inspector_1."/audios/".$codigo_inspeccion."/".$nombre_archivo;
    // mkdir(dirname($file_to_save), 0777, true); //esta linea es para crear el directorio si no existe

    // move_uploaded_file($_FILES["file"]["tmp_name"], "/home/montajesyproceso/public_html/inspeccion/servidor/escaleras/inspector_".$codigo_inspector_1."/audios/".$codigo_inspeccion."/".$nombre_archivo);
?>