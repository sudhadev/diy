<?php
	require_once("../../classes/core/core.class.php");
 	$objCore=new Core;
	$objCore->auth(1,false);
    
    $email= $_REQUEST['em'];
    $id= $_REQUEST['id'];
    require_once($objCore->_SYS['PATH']['CLASS_PROMOTION']);
    if(!is_object($objPromotion)) $objPromotion= new Promotion();
    $promoInfo=$objPromotion->getByPromoteCode($id);
 
  //  print_r($promoInfo);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/email.css" rel="stylesheet" type="text/css" /> 
<div align="center">
<div id="main_outer">
<div id="mainDiv">
<div id="main_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'].$image_localization;?>/emails/email_header.jpg" width="700" height="60" /></div>
<div id="body_area">
<div id="text_area" ><p class="main_text">
<!--        <span style='font-size:13px;font-family:"Arial","sans-serif"; color:#000000'><strong>Dear Customer, </strong></span></p>-->

<p class="main_text">
<!--As a valued supplier within the DIY and construction sector, we would like to invite you to a 30 day unconditional trial with diypricecheck.com.--> 
As a valued supplier within the DIY and construction sector, we would like to invite you to a FREE, unconditional trial with <a href="http://www.diypricecheck.co.uk">www.diypricecheck.co.uk</a>.<br/><br/>
At Diy Price Check, you'll be able to build a list of products that you sell and place your prices and other info next to them as listings. <br/><br/>
You can compile as many listing as you like, but will only be able to activate 
<?php
$package = $objCore->_SYS['CONF']['SUBCRIPTIONS']['M'][$promoInfo['Package']];

switch ($package):
    case 'Gold':
        $products = $objCore->gConf['SUBSCRIPTION_GOLD'];
        break;
    case 'Silver':
        $products = $objCore->gConf['SUBSCRIPTION_SILVER'];
        break;
    case 'Bronze':
        $products = $objCore->gConf['SUBSCRIPTION_BRONZE'];
        break;
    default:
       // $products = $objCore->gConf['SUBSCRIPTION_BRONZE'];
        $products='Services';
        break;
endswitch;
echo $products;
?>
 with this code, which users can then search for. <br/><br/>
<br/><br/>
Hopefully, you'll get the hang of it.
<br/><br/>
If you get stuck, send your queries to <a href="mailto:support@diypricecheck.com">support@diypricecheck.com</a>, where we will be pleased to help.
<br/><br/>
<!--This code can only be used once after registration, for Building Supplies, 1 month Bronze package.-->
This code can only be used once after registration, for Building
<?php if($products=='Services'){?>
Services.
<?php }else{ ?>
Supplies,
<?php echo $objCore->_SYS['CONF']['SUBCRIPTIONS']['M'][$promoInfo['Package']]; ?> package. 
<?php } ?> 

</p>
<?php
$link_params = 'key='.urlencode($promoInfo['Key']).'&code='.urlencode($promoInfo['PromotionCode']).'&email='.urlencode($promoInfo['MailAddress']);
$link = $objCore->_SYS['CONF']['URL_FRONT'].'/signup/?'.$link_params;

?>

<div class="sub_headings">Promotion Code</div>
<table width="660" border="0" cellspacing="0" cellpadding="0" class="table_text">
  <tr>
    <td width="150">Code</td>
    <td width="10"></td>
    <td width="399"><?php echo $promoInfo['PromotionCode']; ?></td>
    </tr>
    <tr>
    <td width="150">Link to activate</td>
    <td width="10"></td>
    <td width="399"><a href="<?php echo $link; ?>">Activate</a></td>
    </tr>
  <tr>
    <td width="150">Package Applicable</td>
    <td width="10"></td>
    <td width="399">
        <?php if($products=='Services'){?>
        Services - <?php echo $promoInfo['Package']; ?> month
        <?php }else{ ?>
            <?php echo $objCore->_SYS['CONF']['SUBCRIPTIONS']['M']['OPTION']. " - " .$objCore->_SYS['CONF']['SUBCRIPTIONS']['M'][$promoInfo['Package']]; ?>
        
            [ <strong><?php echo $promoInfo['GracePeriod'];?> Days Free </strong>]
       <?php } ?>
        
    </td>
    </tr>
   <tr>
    <td width="150">Use Before</td>
    <td width="10"></td>
<!--    <td width="399"><?php echo date($objCore->gConf['DATE_FORMAT'],$promoInfo['TimeExpire']); ?></td>-->
    <td width="399"><?php echo date($objCore->gConf['DATE_FORMAT'],$promoInfo['CodeExpire']); ?></td>
   
   </tr>
     <tr>
    <td width="150">Promo period expires on</td>
    <td width="10"></td>
    <td width="399"><?php echo date($objCore->gConf['DATE_FORMAT'],$promoInfo['TimeExpire']); ?></td>
   
   </tr>
</table> 

<?php //include("email_footer.php");?>

<p class="main_text">Thank you for using Diy Price Check. <br/><br/>
    <div>
  <?php
      if($objCore->gConf['DIY_ADDRESS']) $diyDetails= ucwords($objCore->gConf['DIY_ADDRESS']).", ";
      if($objCore->gConf['DIY_STREET']) $diyDetails.= ucwords($objCore->gConf['DIY_STREET']).", ";
      if($objCore->gConf['DIY_CITY']) $diyDetails.= ucwords($objCore->gConf['DIY_CITY']).", ";
//      if($objCore->gConf['DIY_COUNTRY']) $diyDetails.= ucwords($objCore->gConf['DIY_COUNTRY'])."<br />";
      if($objCore->gConf['DIY_POSTAL']) $diyDetails.= strtoupper ($objCore->gConf['DIY_POSTAL']).".<br />";


      echo $diyDetails;

  ?><br />
  <strong>
      <?php
          if($objCore->gConf['DIY_TELEPHONE']) $diyConDetails= $objCore->gConf['DIY_TELEPHONE']."(Tel) <br />";
          if($objCore->gConf['DIY_FAX']) $diyConDetails.= $objCore->gConf['DIY_FAX']." (Fax) <br />";
          //if($objCore->gConf['DIY_EMAIL']) $diyConDetails.= "<a href='mailto:".$objCore->gConf['DIY_EMAIL']."'>".$objCore->gConf['DIY_EMAIL']."</a><br />";
        echo $diyConDetails;
      ?>
  </strong></div>

</div>
</div>
</div>
</div>
</div>