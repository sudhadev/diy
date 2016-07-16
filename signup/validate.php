<?php
	
	include("../classes/core/core.class.php");
	$objCore = new Core;
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	
	$objCustomer = new Customer();
	
	
	if ($_SERVER["REQUEST_METHOD"] <> "POST") 
 		die("Access Denied"); 
	
		if (isset($_REQUEST['fName']))
		{
			$msg  = $objCustomer->checkfName($_REQUEST['fName']);
		} 
		elseif (isset($_REQUEST['lName']))
		{
			$msg  = $objCustomer->checklName($_REQUEST['lName']);
		}
		elseif (isset($_REQUEST['email']) && isset($_REQUEST['emailConfirm']))
		{
			$msg = $objCustomer->checkEmail($_REQUEST['email'], $_REQUEST['emailConfirm']);
		}
		elseif (isset($_REQUEST['email']))
		{	
			$msg = $objCustomer->checkCustomerExists($_REQUEST['email']);		
		}
		elseif (isset($_REQUEST['password']) && isset($_REQUEST['passwordConfirm']))
		{
			$msg = $objCustomer->checkPassword($_REQUEST['password'], $_REQUEST['passwordConfirm']);
		}
		elseif (isset($_REQUEST['company']))
		{
			$msg = $objCustomer->checkCompany($_REQUEST['company']); 
		}
		elseif (isset($_REQUEST['address']))
		{
			$msg = $objCustomer->checkAddress($_REQUEST['address']);
		}
		elseif (isset($_REQUEST['street']))
		{
			$msg = $objCustomer->checkStreet($_REQUEST['street']);
		}
		elseif (isset($_REQUEST['city']))
		{
			$msg = $objCustomer->checkCity($_REQUEST['city']);
		}
		elseif (isset($_REQUEST['country']))
		{
			$msg = $objCustomer->checkCountry($_REQUEST['country']);
		}
		elseif (isset($_REQUEST['phone']))
		{
			$msg = $objCustomer->checkPhone($_REQUEST['phone']);
		}
		
		if($msg)
		{
			print_r($msg);
			echo $objCore->_SYS['MSGS']['CUSTOMER'][$msg[1]][1];
		}
  

?>
