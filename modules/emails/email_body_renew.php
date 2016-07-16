<?php
	require_once("../../classes/core/core.class.php");
 	$objCore=new Core;
	$objCore->auth(1,false);

    require_once($objCore->_SYS['PATH']['CLASS_EXPIRING_ITEMS']);
    if(!is_object($objExpiringItems)) $objExpiringItems = new ExpiringItems();

	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
    if(!is_object($objCustomer)) $objCustomer = new Customer();


    $accData=$objExpiringItems->getByAccessCode($_REQUEST['acode']);


    if($accData['Ack']=='Ok')
    {
        // now we can get the user details from the database
        $cusData=$objCustomer->getCustomerData($accData['CusId']);


    }
  // echo "<pre>";print_r($accData);echo "</pre>";


 	$customerInfo = $cusData[0];
 //   echo "<pre>";print_r($customerInfo);echo "</pre>";

//    $urlTmp=$objCore->_SYS['CONF']['URL_LOGIN_MODULE']."/process_m.php?slky=".$accData['AccessCode']."&email=".$customerInfo[11]."&safe=on&lh=".md5(time());
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <title>DIY Price Check e-mail</title>-->
<link href="../../css/email.css" rel="stylesheet" type="text/css" /> 
<div align="center">
<div id="main_outer">
<div id="mainDiv">
<div id="main_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/emails/email_header.jpg" width="700" height="60" /></div>
<div id="image_banner"><img alt="Expiaration Alert" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/emails/renewal.jpg"/></div>
<div id="body_area">
<div id="text_area" ><p class="main_text"><span style='font-size:13px;font-family:"Arial","sans-serif"; color:#000000'><strong>Dear <?php echo $customerInfo[0]." ".$customerInfo[1]; ?> </strong></span></p>

<p class="main_text">Following item is set to automatically renew on the expiration date mentioned:</p>



<div class="sub_headings">Item details</div>
<table width="660" border="0" cellspacing="0" cellpadding="0" class="table_text">
  <tr>
    <td width="150">Item</td>
    <td width="15"></td>
    <td width="399"><?php echo $accData['Descript']; ?></td>
    </tr>
  <tr>
    <td width="150">Expiry date </td>
    <td width="15"></td>
    <td width="399"><?php echo date($objCore->gConf['DATE_FORMAT'], $accData['ExpireOn']); ?></td>
    </tr>
</table>


    <p class="grayInfoBox" >
    <strong>IMPORTANT:</strong>If the credit card we have on file for you has expired or been closed, we will not be able to automatically renew your Item.
    To review and update your credit card information, log in to your account and and then go to "Scheduled Payment" section.
    Click on the the specific schecule. You can update your Credit Card details from that window.
       </p>
       


<?php include("email_footer.php");?>
</div>
</div>
</div>
</div>
</div>
<br/>