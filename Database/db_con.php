<?php
$servername = "localhost";
$username	= "root";
$password	= "";
$db 		= "obts";

$conn =	mysqli_connect($servername, $username, $password, $db);
ob_start();

if(session_status() === PHP_SESSION_NONE)
{
	session_start();
}

//Check connection
if(mysqli_connect_error())
{
	die("Database connection failed: ".mysqli_connect_error());
}
/*else
{
	echo "Connection Successful";
}*/

?>