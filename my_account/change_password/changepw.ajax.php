<?php

	if ($_SERVER["REQUEST_METHOD"] <> "POST") 
 		die("Access Denied");
 	
 	require_once("../../classes/core/core.class.php");
 	$objCore=new Core;
 	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	$objCustomer = new Customer();
	
	$msg = $objCustomer->changePassword($_REQUEST['customerId'], $_REQUEST['password'], $_REQUEST['newPassword'], $_REQUEST['confirmNewPassword']);
 	
 	if ($msg)
  	{
		echo $objCore->msgBox("CUSTOMER",$msg);
               } ?>