<?php

	include("../../classes/core/core.class.php");
	$objCore = new Core;
    $objCore->auth(1,true);
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	
	$objCustomer = new Customer();
	if ($_SERVER["REQUEST_METHOD"] <> "POST")
	{
 		die("Access Denied");
 	}	
 	
 	$msg = $objCustomer->updatePersonal($_REQUEST['customerId'], $_REQUEST['title'], $_REQUEST['fName'], $_REQUEST['lName'], $_REQUEST['email'], $_REQUEST['emailConfirm']);
 	
 	if ($msg)
  	{
		echo $objCore->msgBox("CUSTOMER",$msg);

    }
    // end if($msg)

    if($msg[0]=='SUC')
    {
        echo "||".$msg[0]."||".addslashes($_REQUEST['fName']." ". $_REQUEST['lName']);
        // update the current session
   
        if(!is_object($objSql))
        {
            $objSql= new Sql;
            $objSql->query("UPDATE `".$objCore->_SYS['CONF']['PREFIX_TBL']."cus_session` SET f_name='".$_REQUEST['fName']."',l_name='".$_REQUEST['lName']."' WHERE customer_id='".$objCore->sessCusId."'");
        }
    }
?>