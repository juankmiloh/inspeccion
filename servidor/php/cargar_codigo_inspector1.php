<?php
	include ("conexion_BD.php");
	$sql="SELECT max(k_codusuario)+1 FROM usuarios";
	$result=mysqli_query($con,$sql);  
	while ($row = mysqli_fetch_row($result)) {
	    $resultado=$row[0];
	}
	$array = array("codigo" => $resultado);
	if(isset($_GET['callback'])){ // Si es una petición cross-domain  
	  echo $_GET['callback'].'('.json_encode($array).')';
	}
	else // Si es una normal, respondemos de forma normal  
	  echo json_encode($array);
?>