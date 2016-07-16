<?php

	include("../classes/core/core.class.php");
	$objCore = new Core;
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	
	$objCustomer = new Customer();
	
	if ($_SERVER["REQUEST_METHOD"] <> "POST") 
 		die("Access Denied");
 	
 	$msg = $objCustomer->resetPassword($_REQUEST['uid']);
 	print_r($msg); 
 	  
?>