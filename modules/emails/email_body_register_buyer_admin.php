<?php
	require_once("../../classes/core/core.class.php");
 	$objCore=new Core;
 	$objCore->auth(1,false);
 	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
 	if(!is_object($objCustomer)) $objCustomer = new Customer();
 	$customerData=$objCustomer->getCustomerData($_REQUEST['cid']);
 	$customerInfo = $customerData[0];
 	require_once($objCore->_SYS['PATH']['CLASS_COUNTRY']); 
	if(!is_object($objCountry)) $objCountry=new Country();
	
	echo "New buyer has registered with <b>DIY PRICE CHECK</b>. Please check following details.<br/>";
	echo "<br/>First Name: ".$customerInfo[0]."<br/>";
	echo "Last Name: ".$customerInfo[1]."<br/>";
	echo "Email: ".$customerInfo[11]."<br/>";
	if($customerInfo[3]){
        //echo "Company: ".$customerInfo[2]."<br/>";
	echo "Address: ".$customerInfo[3]."<br/>";
	echo "Street: ".$customerInfo[4]."<br/>"; 
	echo "City: ".$customerInfo[5]."<br/>"; 
	echo "Postal: ".$customerInfo[6]."<br/>";
	echo "Country: ".$objCountry->arrCountry[$customerInfo[7]]."<br/>";
	//echo "Telephone: ".$customerInfo[8]."<br/>";
	//echo "Fax: ".$customerInfo[9]."<br/>"; 
	//echo "Mobile: ".$customerInfo[10]."<br/><br/>";

        }

    /**
     * need to add following text if pending approval is on
     */
//     if($objCore->gConf['REGISTRATION_PENDING_APPROVAL']=='ON')
//     {
//        // echo "<strong>* Note :</strong> System is waiting for your Approval for this Account. Please log in to the system and do appropriate.";
//     }
?>
