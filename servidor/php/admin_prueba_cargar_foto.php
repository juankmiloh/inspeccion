<?php
  header("access-control-allow-origin: *");

  include ("conexion_BD.php");

  $nombre = "foto";

  //generamos la consulta
  $sql = "SELECT * FROM ascensor_valores_fotografias WHERE consecutivo='1'";
  mysqli_set_charset($con, "utf8"); //formato de datos utf8

  if(!$result = mysqli_query($con, $sql)) die();

  $ascensor_valores_elementos = array(); //creamos un array

  while($row = mysqli_fetch_array($result)){ 
    $consecutivo = $row['consecutivo'];
    $n_directorio = $row['n_directorio'];

    $data = base64_decode($n_directorio);
    // echo $data;
    $im = imagecreatefromstring($data);  //convertir text a imagen
    if ($im !== false) {
      imagejpeg($im, "../ascensores/".$nombre.".jpg",100); //guardar a server 
      imagedestroy($im); //liberar memoria  
      //echo $data;
    }else {
      echo 'Un error ocurrio al convertir la imagen.';
    }
    
    $ascensor_valores_elementos[] = array('consecutivo'=> $consecutivo);
  }
      
  //desconectamos la base de datos
  $close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");

  //Creamos el JSON
  $json_string = json_encode($ascensor_valores_elementos);
  echo $json_string;
?>
<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
  <img src="data:image/jpeg;base64,<?php echo $n_directorio ?>">
</body>
</html>