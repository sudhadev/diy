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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<div align="center">
<div id="main_outer">
<div id="mainDiv">
<div id="main_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/emails/email_header.jpg" width="700" height="60" /></div>
<div id="body_area">
<div id="text_area" ><p class="main_text"><span style='font-size:13px;font-family:"Arial","sans-serif"; color:#000000'><strong>Dear <?php echo $customerInfo[0]." ".$customerInfo[1]; ?> </strong></span></p>
<p class="main_text">
<!--    Thank you for Registering with <strong>DIY Price Check.</strong> -->
<?php
    /**
     * need to add following text if pending approval is on
     */
     if($objCore->gConf['REGISTRATION_PENDING_APPROVAL']=='ON')
     {
         echo "Your details has been submitted to the Administrator for the approval. You may be contacted by one of our representative during the approval process.
";
     }
     else
     {
         echo "Thank you for registering with diypricecheck.com. Your account details, shown below, can be changed anytime you're logged in.";
     }
?>
 </p>
<p></p>
<div class="sub_headings"><strong>Personal Details</strong> </div>
<table width="660" border="0" cellspacing="0" cellpadding="0" class="table_text">
  <tr>
    <td width="150">First Name</td>
    <td width="15"></td>
    <td width="399"><?php echo $customerInfo[0]; ?></td>
    </tr>
  <tr>
    <td width="150">Last Name</td>
    <td width="15"></td>
    <td><?php echo $customerInfo[1]; ?></td>
    </tr>
  <tr>
    <td width="150">Email</td>
    <td width="15"></td>
    <td><?php echo $customerInfo[11]; ?></td>
    </tr>
</table>
<p></p><br/>
<div class="sub_headings"><strong>Address </strong></div>
<table width="660" border="0" cellspacing="0" cellpadding="0" class="table_text">
  <tr>
    <td width="150">Company</td>
    <td width="15"></td>
    <td width="399"><?php echo $customerInfo[2]; ?></td>
    </tr>
  <tr>
    <td width="150">Address</td>
    <td width="15"></td>
    <td><?php echo $customerInfo[3]; ?></td>
    </tr>
  <tr>
    <td width="150">Street</td>
    <td width="15"></td>
    <td><?php echo $customerInfo[4]; ?></td>
    </tr>
  <tr>
    <td width="150">City</td>
    <td width="15"></td>
    <td><?php echo $customerInfo[5]; ?></td>
    </tr>
  <tr>
    <td width="150">Postal</td>
    <td width="15"></td>
    <td><?php echo $customerInfo[6]; ?></td>
    </tr>
  <tr>
    <td width="150">Country</td>
    <td width="15"></td>
    <td><?php echo $objCountry->arrCountry[$customerInfo[7]]; ?></td>
    </tr>
</table>
<p></p>
<br/>
<div class="sub_headings"><strong>Contact Details</strong></div>
<table width="660" border="0" cellspacing="0" cellpadding="0" class="table_text">
  <tr>
    <td width="150">Telephone</td>
    <td width="15"></td>
    <td width="399"><?php echo $customerInfo[8]; ?></td>
    </tr>
  <tr>
    <td width="150">Fax</td>
    <td width="15"></td>
    <td ><?php echo $customerInfo[9]; ?></td>
    </tr>
  <tr>
    <td width="150">Mobile</td>
    <td width="15"></td>
    <td><?php echo $customerInfo[10]; ?></td>
    </tr>
  <tr>
</table>
<br/><br/>
<?php include("email_footer.php");?>
</div>
</div>
</div>
</div>
</div>