<?php
	require_once("../../classes/core/core.class.php");
 	$objCore=new Core;
 	$objCore->auth(1,false);
    require_once($objCore->_SYS['PATH']['CLASS_ORDER']);
    $objOrder=new Order();
    $orderDetails = $objOrder->getOrderDetails($_REQUEST['cid'],1, $_REQUEST['invoice']);
    $orderInfo=$orderDetails[0];
    $arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];
    $str = explode("||",$orderInfo[25]);
	
	echo "Following Payment has been recieved. Please login to the admin console for more information<br/>";
	echo "<br/>Invoice Number: ".$orderInfo[0]."<br/>";
	echo "Customer Name: ".$orderInfo[1]." ".$orderInfo[2]."<br/>";
	echo "Customer Email: ".$orderInfo[14]."<br/><br>";
	echo "Description: ".$orderInfo[26]."<br/>";
	echo "Amount (".$objCore->_SYS['CONF']['CURRENCY']."): ".$orderInfo[24]."<br/>";
	echo "Processed Time: ".date($objCore->gConf['DATE_FORMAT'],$orderInfo[22])." ".date($objCore->gConf['TIME_FORMAT'],$orderInfo[22])."<br/>";


    /**
     * need to add following text if pending approval is on
     */
?>
