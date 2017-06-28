<?php
	/*
	* conexion con la base de datos del servidor co.nf
	*/
    $con = mysqli_connect("localhost","root","root","inspeccion_mp");
    // Check connection
    mysqli_query($con, "SET NAMES 'UTF8'");
    if (mysqli_connect_error())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
    //echo 'Conectado satisfactoriamente';
?>

<?php
	/*
	* conexion con la base de datos del servidor co.nf
	*/
 //    $con = mysqli_connect("localhost","montajes_admin","montajes","montajes_inspeccion_mp");
 //    // Check connection
 //    mysqli_query($con, "SET NAMES 'UTF8'");
 //    if (mysqli_connect_error())
	// {
	// 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	// }
    //echo 'Conectado satisfactoriamente';
?>