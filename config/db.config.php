<?php

define("DB_USER","");
define("DB_PASSWORD","");
define("DB_HOST","");

function connectDB(){
	$mysqli = new mysqli('','','','');
	if(!mysqli_connect_errno()) echo "Connected\n";
	else die("Could not connect to DB: ".$mysqli->connect_error);
	return $mysqli:
}

function disconnectDB($mysqli){
	mysqli_close($mysqli);
}


?>
