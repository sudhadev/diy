<?php

	include("../../classes/core/core.class.php");
	$objCore = new Core;
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	
	$objCustomer = new Customer();
	if ($_SERVER["REQUEST_METHOD"] <> "POST")
	{
 		die("Access Denied");
 	}	
 	$msg = $objCustomer->updateBusiness($_REQUEST['customerId'], $_REQUEST['mon'], $_REQUEST['sat'], $_REQUEST['sun'],$_REQUEST['website'],$_REQUEST['show_website']); 
 	
 	if ($msg)
  	{
		echo $objCore->msgBox("CUSTOMER",$msg);
	}
?>