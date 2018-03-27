<?php
	ob_start(); //Linea para permitir enviar flujo de datos por url al redireccionar la pagina
	header("access-control-allow-origin: *"); //linea para permitir el acceso al servidor y hacerle peticiones desde localhost
	session_start();
	include ("conexion_BD.php");

	$usuario=$_POST['usuario'];
	$contrasena=$_POST['password'];
	
	$sql="SELECT * FROM usuarios WHERE n_usuario='".$usuario."' AND contrasena='".$contrasena."'";
	$result=mysqli_query($con, $sql) or die(mysqli_error($con));
	while ($row=mysqli_fetch_array($result)) {
		$arreglo[]=array('Nombre'=>$row['n_nombre'],
						 'Apellido'=>$row['n_apellido'],
						 'Correo'=>$row['o_correo']);
	}
	if (isset($arreglo)) {
		$_SESSION['Usuario']=$arreglo;
		header("Location: ./admin.php");
		// header("Location: ./admin_informes_inspeccion.php");
	} else {
		header("Location: ../index.php?error=datos no validos");
	}
	ob_end_flush(); //Linea para permitir enviar flujo de datos por url al redireccionar la pagina
?>