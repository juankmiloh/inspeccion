<?php
	header("access-control-allow-origin: *");
	include ("conexion_BD.php");

	$caso=$_POST['Caso'];
	$codigo=$_POST['Id'];
	$usuario=$_POST['Usuario'];
	$cedula=$_POST['Cedula'];
	$nombre=$_POST['Nombre'];
	$apellido=$_POST['Apellido'];
	$correo=$_POST['Correo'];
	$rol=$_POST['Rol'];
	$contrasena=$_POST['Cedula']; // En este caso la contrasena sera la misma identificacion

	$sql="INSERT INTO usuarios(k_codusuario, n_usuario, o_cedula, n_nombre, n_apellido, o_correo, o_rol, contrasena) VALUES(
				".$codigo.",
				'".$usuario."',
				'".$cedula."',
				'".$nombre."',
				'".$apellido."',
				'".$correo."',
				'".$rol."',
				'".$contrasena."'
				)";
	if (mysqli_query($con,$sql)==TRUE){
		echo "Inspector creado con éxito!";
	} else {
		echo "error: ". $sql . "<br>" . $con->error;
	}
?>