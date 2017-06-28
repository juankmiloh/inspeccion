<?php
    header("access-control-allow-origin: *");

    include ("conexion_BD.php");

    $codigo_inspector = $_POST['inspector'];

    //generamos la consulta
    $sql = "SELECT * FROM auditoria_inspecciones_ascensores WHERE k_codusuario=".$codigo_inspector." ORDER BY o_consecutivoinsp desc";
    mysqli_set_charset($con, "utf8"); //formato de datos utf8

    if(!$result = mysqli_query($con, $sql)) die();


    echo '<option value="n/a">Seleccione una inspección</option>';
    while($row = mysqli_fetch_array($result)){ 
        $k_codinspeccion = $row['k_codinspeccion'];
        $o_consecutivoinsp = $row['o_consecutivoinsp'];
        echo '<option value='.$k_codinspeccion.'>'.$o_consecutivoinsp.'</option>';
    }

    //desconectamos la base de datos
    $close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
?>