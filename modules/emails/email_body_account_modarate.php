<?php
	require_once("../../classes/core/core.class.php");
 	$objCore=new Core;
	$objCore->auth(1,false);

	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
 	$objCustomer = new Customer();
 	$customerData=$objCustomer->getCustomerData($_REQUEST['cid']);
 	$customerInfo = $customerData[0];
    
    $emailType=$_REQUEST['type'];

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <title>DIY Price Check e-mail</title>
<link href="../../css/email.css" rel="stylesheet" type="text/css" /> -->
<div align="center">
<div id="main_outer">
<div id="mainDiv">
<div id="main_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/email_header.jpg" width="700" height="60" /></div>
<div id="body_area">
<div id="text_area" ><p class="main_text"><span style='font-size:13px;font-family:"Arial","sans-serif"; color:#000000'><strong>Dear <?php echo $customerInfo[0]." ".$customerInfo[1]; ?> </strong></span></p>
<p class="main_text">
    <?php
    switch($emailType)
    {
        case "approved":
            {
                echo "Your Account has been approved by the Administrator. Please login to the system using the email address and the password that you given at the Registration.";
            }break;
        case "disapproved":
            {
                echo "Your Account has been Deactivated by the administrator due to following reason
                Please contact Diy Price Team in order to Reactevate the account.";
            }break;
        case "reactivated":
            {
                echo "Your Account has been Reactivated by the Administrator. Now you can access & work on the system";
            }break;
        case "deactivated":
            {
                echo "Your Account has been Deactivated by the administrator due to following reason
                    Please contact Diy Price Team in order to Reactevate the account.";
            }break;
    }



?>
</p>

<?php include("email_footer.php");?>
</div>
</div>
</div>
</div>
</div>