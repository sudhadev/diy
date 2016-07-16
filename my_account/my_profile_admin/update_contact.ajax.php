<?php
echo ' ';
	include("../../classes/core/core.class.php");
	$objCore = new Core();
	$objCore->auth(1,true);
	
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	
	$objCustomer = new Customer();
	if ($_SERVER["REQUEST_METHOD"] <> "POST")
	{
 		die("Access Denied");
 	}	
 	
 	$msg = $objCustomer->updateContact($_REQUEST['customerId'],$_REQUEST['phone'], $_REQUEST['fax'], $_REQUEST['mobile']);
 	
 	if ($msg)
  	{
		echo $objCore->msgBox("CUSTOMER",$msg);
	}
?>
