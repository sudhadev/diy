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

    $urlTmp=$objCore->_SYS['CONF']['URL_LOGIN_MODULE']."/process_m.php?slky=".$accData['AccessCode']."&email=".$customerInfo[11]."&safe=on&lh=".md5(time());
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- <title>DIY Price Check e-mail</title>-->
<link href="../../css/email.css" rel="stylesheet" type="text/css" /> 
<div align="center">
<div id="main_outer">
<div id="mainDiv">
<div id="main_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/emails/email_header.jpg" width="700" height="60" /></div>
<div id="image_banner"><img alt="Expiaration Alert" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/emails/item_expire.jpg"/></div>
<div id="body_area">
<div id="text_area" ><p class="main_text"><span style='font-size:13px;font-family:"Arial","sans-serif"; color:#000000'><strong>Dear <?php echo $customerInfo[0]." ".$customerInfo[1]; ?> </strong></span></p>

<p class="main_text">
   <?php 
   
    switch ($accData['AlertNo'])
    {
        case 2:
            {
                echo "The item listed below have been Expired.";
            }
            break;
        case 3:
            {
                echo "The item listed below has been expired and at risk of removing all the related data in 15 days of expiration.";
            }
            break;
        case 4:
            {
                 echo "All the related data of item listed below has been deleted from the system.";
               
            }
            break;
        default:
            {
                echo "The item listed below is at risk of expiring";
            }

    }

   
   ?></p>



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

<?php
if($accData['AlertNo']<4)
{
?>
    <p class="grayInfoBox" style="padding-top:10px;padding-bottom:10px;" >

    Renew your subscription right now by going to <a href="<?php echo $urlTmp;?>" target="_blank"><?php echo $objCore->_SYS['CONF']['URL_LOGIN_MODULE'].'/?k'.substr($_REQUEST['acode'],0,80);?> ..........</a><br/>
<br/>
    <b>PLEASE NOTE:</b> This link can only be used once.<br/>
If you use this link, but don't renew, you can always log into the system <a href="<?php echo $objCore->_SYS['CONF']['URL_LOGIN_FRONT']?>"><?php echo $objCore->_SYS['CONF']['URL_LOGIN_FRONT']?></a>  and renew from there.<br/>

    </p>
    <?php
    if($accData['Subscript']!="C")
    {
    ?>
        <p class="main_text">
            <strong>Important Note: </strong>Expired Subscription Package will be held for a 15-day Redemption Period.
        After the Redemption Period has ended, the Subscription will be removed with all related data
        from our server and no longer subject to recovery. To avoid future loss, select the Automatic Payment option when you made the payment.


        </p>
    <?php
    }
    ?>
<?php
}
?> 
<?php include("email_footer.php");?>
</div>
</div>
</div>
</div>
</div>
<br/>