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
 	$msg = $objCustomer->updateAddress($_REQUEST['customerId'], $_REQUEST['company'], ucwords($_REQUEST['address']), ucwords($_REQUEST['street']), ucwords($_REQUEST['city']), strtoupper($_REQUEST['postcode']), $_REQUEST['country'], $_REQUEST['latitude'], $_REQUEST['longitude']); 
 	
 	if ($msg)
  	{
		echo $objCore->msgBox("CUSTOMER",$msg);
	}
?>