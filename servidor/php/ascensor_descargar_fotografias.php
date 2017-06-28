<?php
    ob_start();

    $codigo_inspector = $_POST['codigo_inspector'];
    $codigo_inspeccion = $_POST['codigo_inspeccion'];

    $archivo_final = 'inspeccion_'.$codigo_inspector.'_'.$codigo_inspeccion.'.zip';  // .zip *

    /*
    * creamos el enlace de descarga al archivo
    */

    //Utilizamos basename por seguridad, devuelve el 
    //nombre del archivo eliminando cualquier ruta. 
    $archivo = basename($archivo_final);

    $ruta = $archivo;

    if (is_file($ruta)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($archivo));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($archivo));
        ob_clean();
        flush();
        readfile($archivo);
        unlink($archivo_final); //Borra el archivo despues de ser descargado
        exit;
    } else
       exit();

    ob_end_flush();
?>