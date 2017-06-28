<?php
	header("access-control-allow-origin: *");
	//print_r($_FILES);
	$nombre_archivo = $_FILES["file"]["name"];

	$valor = explode("-", $nombre_archivo); //divide el texto en un arreglo
    $codigo_inspector = $valor[0];
    $codigo_inspeccion = (int)$valor[1];

    $valor_1 = explode("PUT", $codigo_inspector); //divide el texto en un arreglo
    $codigo_inspector_1 = $valor_1[1];

    $file_to_save = "../puertas/inspector_".$codigo_inspector_1."/fotografias/".$codigo_inspeccion."/".$nombre_archivo;
   	mkdir(dirname($file_to_save), 0777, true); //esta linea es para crear el directorio si no existe

	move_uploaded_file($_FILES["file"]["tmp_name"], "/Applications/MAMP/htdocs/inspeccion/servidor/puertas/inspector_".$codigo_inspector_1."/fotografias/".$codigo_inspeccion."/".$nombre_archivo);
?>

<?php
    // header("access-control-allow-origin: *");
    // //print_r($_FILES);
    // $nombre_archivo = $_FILES["file"]["name"];

    // $valor = explode("-", $nombre_archivo); //divide el texto en un arreglo
    // $codigo_inspector = $valor[0];
    // $codigo_inspeccion = (int)$valor[1];

    // $valor_1 = explode("PUT", $codigo_inspector); //divide el texto en un arreglo
    // $codigo_inspector_1 = $valor_1[1];

    // $file_to_save = "../puertas/inspector_".$codigo_inspector_1."/fotografias/".$codigo_inspeccion."/".$nombre_archivo;
    // mkdir(dirname($file_to_save), 0777, true); //esta linea es para crear el directorio si no existe

    // move_uploaded_file($_FILES["file"]["tmp_name"], "/home/montajesyproceso/public_html/inspeccion/servidor/puertas/inspector_".$codigo_inspector_1."/fotografias/".$codigo_inspeccion."/".$nombre_archivo);
?>