<?php

	include("../../classes/core/core.class.php");
	$objCore = new Core;
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	
	$objCustomer = new Customer();
	if ($_SERVER["REQUEST_METHOD"] <> "POST")
	{
 		die("Access Denied");
 	}	
 	$msg = $objCustomer->updateEmailSubscriptions($_REQUEST['cus_Id'], $_REQUEST['order'], $_REQUEST['password'], $_REQUEST['expiration'], $_REQUEST['renew'], $_REQUEST['promo']); 
 	
 	if ($msg)
  	{
		echo $objCore->msgBox("CUSTOMER",$msg);
	}
?>
