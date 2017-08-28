<?php
    header("access-control-allow-origin: *");

    include ("conexion_BD.php");

    //generamos la consulta
    $sql = "SELECT * FROM usuarios WHERE o_rol<>'Administrador' AND o_rol<>'Inspector_prueba' ORDER BY n_nombre asc";
    mysqli_set_charset($con, "utf8"); //formato de datos utf8

    if(!$result = mysqli_query($con, $sql)) die();


    echo '<option value="n/a">Seleccione un inspector</option>';
    while($row = mysqli_fetch_array($result)){ 
        $k_codusuario = $row['k_codusuario'];
        $n_nombre = $row['n_nombre'];
        echo '<option value='.$k_codusuario.'>'.$n_nombre.'</option>';
    }

    //desconectamos la base de datos
    $close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
?>