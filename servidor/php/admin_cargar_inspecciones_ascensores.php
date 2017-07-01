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
        $k_codcliente = $row['k_codcliente'];
        /*=============================================
        * SE HACE UN SELECT A LA TABLA VALORES INICIALES PARA OBTENER EL NOMBRE DEL CLIENTE Y EL NOMBRE DEL EQUIPO
        *==============================================*/
        $sql_cliente="SELECT * FROM ascensor_valores_iniciales WHERE k_codinspeccion=".$k_codinspeccion." AND k_codusuario=".$codigo_inspector."";
        $result_cliente=mysqli_query($con, $sql_cliente);
        while($row_cliente = mysqli_fetch_array($result_cliente)){
            $n_cliente = $row_cliente['n_cliente'];
            $n_equipo = $row_cliente['n_equipo'];
        }

        echo '<option value='.$k_codinspeccion.'>'.$o_consecutivoinsp.' - '.$n_cliente.' - '.$n_equipo.'</option>';
    }

    //desconectamos la base de datos
    $close = mysqli_close($con) or die("Ha sucedido un error inexperado en la desconexion de la base de datos");
?>