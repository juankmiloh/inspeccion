<?php
    header("access-control-allow-origin: *");
    //print_r($_SERVER);
    $nombre_archivo = $_GET["archivo"];
    //print_r($nombre_archivo);

    $valor = explode("-", $nombre_archivo); //divide el texto en un arreglo
    $codigo_inspector = $valor[0];
    $codigo_inspeccion = (int)$valor[1];

    $valor_1 = explode("INF", $codigo_inspector); //divide el texto en un arreglo
    $codigo_inspector_1 = $valor_1[1];

    $file_to_save = "../informes/inspector_".$codigo_inspector_1."/audios/".$nombre_archivo;
    mkdir(dirname($file_to_save), 0777, true); //esta linea es para crear el directorio si no existe

    file_put_contents($file_to_save, file_get_contents('php://input'));
?>

<?php
	// header("access-control-allow-origin: *");
 //    header("Content-Type: text/html; charset=iso-8859-1");
	// //print_r($_FILES);
	// $nombre_archivo = $_FILES["file"]["name"];

	// $valor = explode("-", $nombre_archivo); //divide el texto en un arreglo
 //    $codigo_inspector = $valor[0];
 //    $codigo_inspeccion = (int)$valor[1];

 //    $valor_1 = explode("INF", $codigo_inspector); //divide el texto en un arreglo
 //    $codigo_inspector_1 = $valor_1[1];

 //    $file_to_save = "../informes/inspector_".$codigo_inspector_1."/audios/".$nombre_archivo;
 //   	mkdir(dirname($file_to_save), 0777, true); //esta linea es para crear el directorio si no existe

	// move_uploaded_file($_FILES["file"]["tmp_name"], "/Applications/MAMP/htdocs/inspeccion/servidor/informes/inspector_".$codigo_inspector_1."/audios/".$nombre_archivo);
?>

<?php
    // header("access-control-allow-origin: *");
    // header("Content-Type: text/html; charset=iso-8859-1");
    // //print_r($_FILES);
    // $nombre_archivo = $_FILES["file"]["name"];

    // $valor = explode("-", $nombre_archivo); //divide el texto en un arreglo
    // $codigo_inspector = $valor[0];
    // $codigo_inspeccion = (int)$valor[1];

    // $valor_1 = explode("INF", $codigo_inspector); //divide el texto en un arreglo
    // $codigo_inspector_1 = $valor_1[1];

    // $file_to_save = "../informes/inspector_".$codigo_inspector_1."/audios/".$nombre_archivo;
    // mkdir(dirname($file_to_save), 0777, true); //esta linea es para crear el directorio si no existe

    // move_uploaded_file($_FILES["file"]["tmp_name"], "/home/montajesyproceso/public_html/inspeccion/servidor/informes/inspector_".$codigo_inspector_1."/audios/".$nombre_archivo);
    
?>