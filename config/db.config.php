<?php

define("DB_USER","");
define("DB_PASSWORD","");
define("DB_HOST","");

/**
 * OO STYLE
*/
/* 
class MySqlConnection{

	private $dbHost="localhost";
	private $dbUser="root";
	private $dbPassword="x1y2z3t4e5";
	private $dbName="WILD";
	$mysqli = new mysqli($dbHost,$dbUser,$dbPassword,$dbName);

	if($mysqli->connect_errno){
		printf("Connected failed: %s\n",$mysqli->connect_errno);
		
	}
	
}
*/

/**
 * PROCEDURAL STYLE
 */
function connectDB()
{
	$mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB);
	if(!mysqli_connect_errno()) echo "Connected\n";
	else die("Could not connect to DB: ".mysqli_connect_error());

	return $mysqli;
}

function disconnectDB($mysqli)
{
	mysqli_close($mysqli);
}

function startTransaction($mysqli)
{
	if(!mysqli_query($con,"START TRANSACTION")){
		printf("ErrorCode: %s\n",mysqli_connect_error());
	}
}

function commit($mysqli)
{
	if(!mysqli_query($con,"COMMIT")){
		printf("ErrorCode: %s\n",mysqli_connect_error());
	}
}

function rollBack($mysqli)
{
	if(!mysqli_query($con,"COMMIT")){
		printf("ErrorCode: %s\n",mysqli_connect_error());
	}
}



/**
 * DA STUDIARE COME FARE
 * 
 */
function typeQuery($type)
{
	switch($type) 
	{
		case 'SELECT ':
			
			break;
		case 'DELETE ':

			break;
		case 'ALTER ':

			break;

		default:
			# SELECT
			break;
	}

}

?>
