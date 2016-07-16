<?php
	require_once("../../classes/core/core.class.php");
 	$objCore=new Core;
 	$objCore->auth(1,false);
 	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
 	if(!is_object($objCustomer)) $objCustomer = new Customer();
 	$customerData=$objCustomer->getCustomerData($_REQUEST['cid']);
 	$customerInfo = $customerData[0];
 	require_once($objCore->_SYS['PATH']['CLASS_COUNTRY']); 
	if(!is_object($objCountry))$objCountry=new Country();
 	 
?>
<?php 
$title=$_REQUEST['cid'];
$fname=$_REQUEST['fname'];
$lname=$_REQUEST['lname'];

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<div align="center">
<div id="main_outer">
<div id="mainDiv">
<div id="main_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/emails/email_header.jpg" width="700" height="60" /></div>
<div id="body_area">
<div id="text_area" >
<p class="main_text">
<!--    Thank you for Registering with <strong>DIY Price Check.</strong> -->
<?php
    /**
     * need to add following text if pending approval is on
     */

         echo "Hello ".$title." ".$fname." ".$lname."<br>You have been registered successfully with diypricecheck.com";
 
?>
 
<br/><br/>
<?php include("email_footer.php");?>
</div>
</div>
</div>
</div>
</div>