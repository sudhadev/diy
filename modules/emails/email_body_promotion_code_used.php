<?php
	require_once("../../classes/core/core.class.php");
 	$objCore=new Core;
	$objCore->auth(1,false);
    
    $code= $_REQUEST['code'];
    $id= $_REQUEST['id'];

    require_once($objCore->_SYS['PATH']['CLASS_PROMOTION']);
    if(!is_object($objPromotion)) $objPromotion= new Promotion($objCore->gConf);
    $promoInfo=$objPromotion->getByPromoteCode($code,'Y');
    
    require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
 	if(!is_object($objCustomer)) $objCustomer = new Customer();
    $customerData=$objCustomer->getCustomerData($id);
    $customerInfo = $customerData[0];

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/email.css" rel="stylesheet" type="text/css" /> 
<div align="center">
<div id="main_outer">
<div id="mainDiv">
<div id="main_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/emails/email_header.jpg" width="700" height="60" /></div>
<div id="body_area">
<div id="text_area" ><p class="main_text"><span style='font-size:13px;font-family:"Arial","sans-serif"; color:#000000'><strong>Dear Administrator, </strong></span></p>

<p class="main_text">
<!--As a valued supplier within the DIY and construction sector, we would like to invite you to a 30 day unconditional trial with diypricecheck.com.--> 
Following promotion code has been used by the customer to register with DIY Price Check.
<br/><br/>
</p>


<div class="sub_headings">Promotion Code Used</div>
<table width="660" border="0" cellspacing="0" cellpadding="0" class="table_text">
    <tr>
    <td width="150">Supplier Name</td>
    <td width="10"></td>
    <td width="399"><?php echo $customerInfo[0]." ".$customerInfo[1] ; ?></td>
    </tr>
    <tr>
    <td width="150">Supplier Email Address</td>
    <td width="10"></td>
    <td width="399"><?php echo $customerInfo[11]; ?></td>
    </tr>
  <tr>
    <td width="150">Promotional Code</td>
    <td width="10"></td>
    <td width="399"><?php echo $promoInfo['PromotionCode'];?></td>
    </tr>
  <tr>
    <td width="150">Package Applicable</td>
    <td width="10"></td>
    <td width="399"><?php echo $objCore->_SYS['CONF']['SUBCRIPTIONS']['M']['OPTION']. " - " .$objCore->_SYS['CONF']['SUBCRIPTIONS']['M'][$promoInfo['Package']]; ?>
    [ <strong><?php echo $promoInfo['GracePeriod'];?> Days</strong>]</td>
    </tr>
    <tr>
    <td width="150">Activated Time</td>
    <td width="10"></td>
    <td width="399"><?php echo date($objCore->gConf['DATE_FORMAT'],$promoInfo['UsedTime']);?></td>
   
   </tr>
   <tr>
    <td width="150">Code Expires On</td>
    <td width="10"></td>
    <td width="399"><?php echo date($objCore->gConf['DATE_FORMAT'],$promoInfo['CodeExpire']); ?></td>
   
   </tr>
     <tr>
    <td width="150">Promotional period expires on</td>
    <td width="10"></td>
    <td width="399"><?php echo date($objCore->gConf['DATE_FORMAT'],$promoInfo['TimeExpire']); ?></td>
   
   </tr>
</table> 

<?php //include("email_footer.php");?>
</div>
</div>
</div>
</div>
</div>