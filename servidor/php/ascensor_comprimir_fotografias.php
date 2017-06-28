<?php
    ob_start();
    $codigo_inspector = $_POST['codigo_inspector'];
    $codigo_inspeccion = $_POST['codigo_inspeccion'];

    //se borra el archivo .zip por si existe, ya que si se borran fotos se genere de nuevo el archivo .zip
    unlink("./inspeccion_ascensores_".$codigo_inspector."_".$codigo_inspeccion.".zip");

    $carpeta = dirname("../ascensores/inspector_".$codigo_inspector."/fotografias/".$codigo_inspeccion."/*"); /*Línea de código para el localhost de producción*/
    $archivo_final = 'inspeccion_ascensores_'.$codigo_inspector.'_'.$codigo_inspeccion.'.zip';  // .zip *

    comprimir($carpeta, $archivo_final, false, false);
    //header("Location: ./inspeccion_".$codigo_inspector."_".$codigo_inspeccion.".zip");
    //header("Location: ./ascensor_descargar_fotografias.php?codigo_inspector=4&codigo_inspeccion=5");

    function comprimir($ruta, $zip_salida, $handle, $recursivo){
        if(!is_dir($ruta) and !is_file($ruta))
            return false; /* La ruta no existe */

        /* Declara el handle del objeto */
        if(!$handle){
            $handle = new ZipArchive;
            if ($handle->open($zip_salida, ZipArchive::CREATE) === false){
                return false; /* Imposible crear el archivo ZIP */
            }
        }

        /* Procesa directorio */
        if(is_dir($ruta)){
            $ruta = dirname($ruta.'/arch.ext'); /* Aseguramos que sea un directorio sin carácteres corruptos */
            $handle->addEmptyDir($ruta); /* Agrega el directorio comprimido */
            foreach(glob($ruta.'/*') as $url){ /* Procesa cada directorio o archivo dentro de el */
                comprimir($url, $zip_salida, $handle, true); /* Comprime el subdirectorio o archivo */
            }
            /* Procesa archivo */
        }else
            $handle->addFile($ruta);

        /* Finaliza el ZIP si no se está ejecutando una acción recursiva en progreso */
        if(!$recursivo)
            $handle->close();
        
        return true; /* Retorno satisfactorio */
    }

    ob_end_flush();
?>