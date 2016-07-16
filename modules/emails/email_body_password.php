<?php
	require_once("../../classes/core/core.class.php");
 	$objCore=new Core;
	$objCore->auth(1,false);
	$request = explode("|x|", $_REQUEST['id']);
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
 	$objCustomer = new Customer();
 	$customerData=$objCustomer->getCustomerData($request[1]);
 	$customerInfo = $customerData[0]; 
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <title>DIY Price Check e-mail</title>
<link href="../../css/email.css" rel="stylesheet" type="text/css" /> -->
<div align="center">
<div id="main_outer">
<div id="mainDiv">
<div id="main_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/emails/email_header.jpg" width="700" height="60" /></div>
<div id="body_area">
<div id="text_area" ><p class="main_text"><span style='font-size:13px;font-family:"Arial","sans-serif"; color:#000000'><strong>Dear <?php echo $customerInfo[0]." ".$customerInfo[1]; ?> </strong></span></p>
<?php 
	if ($request[2] == 'reset')
	{ 
?> 
<p class="main_text">Your <strong>DIY Price Check</strong> password has been reset and you can login using following Username and Password. Once you logged in you can change the password. Please note that your password is case sensitive.</p>
<?php 
	}
	else if ($request[2] == 'change')
	{
?>
<p class="main_text">Your <strong>DIY Price Check</strong> password has been changed and you can login using following Username and Password.</p> 
<?php 
	}
?> 

<div class="sub_headings">Login Information</div>
<table width="660" border="0" cellspacing="0" cellpadding="0" class="table_text">
  <tr>
    <td width="150">Username</td>
    <td width="15"><?php echo $customerInfo[11]; ?></td>
    <td width="399"></td>
    </tr>
  <tr>
    <td width="150">Password</td>
    <td width="15"><?php echo $request[0]; ?></td>
    <td width="399"></td>
    </tr>
</table> 

<?php include("email_footer.php");?>
</div>
</div>
</div>
</div>
</div>