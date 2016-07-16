<?php 
session_start();

	include("../classes/core/core.class.php");
	$objCore = new Core;

	if ($_SERVER["REQUEST_METHOD"] <> "POST") 
 		die("Access Denied");

	if (!(($_REQUEST["security_code"] == $_SESSION["security_code"]) && (!empty($_REQUEST["security_code"]) && !empty($_SESSION["security_code"]))))  
	{
  		$msg = array('ERR', 'CAPTCHA_NOT_MATCH');
  		echo $objCore->msgBox("CUSTOMER",$msg);
	} 

?>
