<?php 
session_start();

	if ($_SERVER["REQUEST_METHOD"] <> "POST") 
 		die("Access Denied");

	if ( ($_REQUEST["security_code"] == $_SESSION["security_code"]) && (!empty($_REQUEST["security_code"]) && !empty($_SESSION["security_code"])) ) 
	{
  		echo "Done";
	} 
	else 
	{
  		echo "Error";
	}
?>
