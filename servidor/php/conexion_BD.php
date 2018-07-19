<?php
	/*
	* conexion con la base de datos del servidor local
	*/
    $con = mysqli_connect("localhost","root","root","inspeccion_mp");
    // Check connection
    mysqli_query($con, "SET NAMES 'UTF8'");
    if (mysqli_connect_error())
	{
		echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
 //    //echo 'Conectado satisfactoriamente';
?>

<?php
	/*
	* conexion con la base de datos del servidor local
	*/
 //    $con = mysqli_connect("sql100.byethost.com","b13_22410872","fiT2pass_","b13_22410872_inspeccion");
 //    // Check connection
 //    mysqli_query($con, "SET NAMES 'UTF8'");
 //    if (mysqli_connect_error())
	// {
	// 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	//}
 //    //echo 'Conectado satisfactoriamente';
?>

<?php
	/*
	* conexion con la base de datos de AMAZON WEB SERVICES [AWS]
	*/
	// ob_start();
	// exec('ssh ubuntu@agiliza.byethost13.com -L 3307:localhost:3306 -N -f');
 //    $con = mysqli_connect("agiliza.byethost13.com","root","juankmilo02","inspeccion_mp");

 //    // Check connection
 //    mysqli_query($con, "SET NAMES 'UTF8'");
 //    if (mysqli_connect_error()){
	// 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	// }else{
	// 	echo 'Conectado satisfactoriamente';
	// }
 //    ob_end_flush();
?>

<?php
	/*
	* conexion con la base de datos del servidor de montajes
	*/
 //    $con = mysqli_connect("agiliza.byethost13.com","montajes_admin","R;aadR*v!oO#","montajes_inspeccion_mp");
 //    // Check connection
 //    mysqli_query($con, "SET NAMES 'UTF8'");
 //    if (mysqli_connect_error())
	// {
	// 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	// }
    //echo 'Conectado satisfactoriamente';
?>

<?php
	/*
	* conexion con la base de datos del servidor co.nf
	*/
 //    $con = mysqli_connect("fdb3.biz.nf","2158013_montajes","juankmilo02","2158013_montajes");
 //    // Check connection
 //    mysqli_query($con, "SET NAMES 'UTF8'");
 //    if (mysqli_connect_error())
	// {
	// 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	// }
    //echo 'Conectado satisfactoriamente';
?>