<?php
	require_once("../../classes/core/core.class.php");
 	$objCore=new Core;
	$objCore->auth(1,false);
    
    $code= $_REQUEST['code'];
    $id= $_REQUEST['id'];

    require_once($objCore->_SYS['PATH']['CLASS_PROMOTION']);
    if(!is_object($objPromotion)) $objPromotion= new Promotion();
    $promoInfo=$objPromotion->getByPromoteCode($code);
 

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/email.css" rel="stylesheet" type="text/css" /> 
<div align="center">
<div id="main_outer">
<div id="mainDiv">
<div id="main_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/emails/email_header.jpg" width="700" height="60" /></div>
<div id="body_area">
<div id="text_area" ><p class="main_text"><span style='font-size:13px;font-family:"Arial","sans-serif"; color:#000000'><strong>Dear Customer, </strong></span></p>

    <p class="main_text" style="color:red;">
      This is an alert from the DIY Pricecheck reminding you the promotion code which has been sent to you on <span style="color: black;"><strong><?php echo date($objCore->gConf['DATE_FORMAT'],$promoInfo['TimeGenerated']); ?></strong></span>.
        </p>
        
        <p class="main_text" style="color:red;">
      Please use this code before <span style="color: black;"><strong><?php echo date($objCore->gConf['DATE_FORMAT']." ".$objCore->gConf['TIME_FORMAT'],$promoInfo['CodeExpire']); ?></strong></span> to activate your Grace Period.
        </p>
<p class="main_text">
<!--As a valued supplier within the DIY and construction sector, we would like to invite you to a 30 day unconditional trial with diypricecheck.com.--> 
As a valued supplier within the DIY and construction sector, we would like to invite you to a FREE, unconditional trial with www.diypricecheck.com.<br/><br/>
On diypricecheck.com, you'll be able to build a list of products that you sell and place your prices and other info next to them as listings. <br/><br/>
You can compile as many listing as you like, but will only be able to activate 50 with this code, which users can then search for. <br/><br/>
<br/><br/>
Hopefully, you'll get the hang of it.
<br/><br/>
If you get stuck, send your queries to <a href="mailto:support@diypricecheck.com">support@diypricecheck.com</a>, where we will be pleased to help.
<br/><br/>
<!--This code can only be used once after registration, for Building Supplies, 1 month Bronze package.-->
This code can only be used once after registration, for Building Supplies, <?php echo $objCore->_SYS['CONF']['SUBCRIPTIONS']['M'][$promoInfo['Package']]; ?> package. 

</p>


<div class="sub_headings">Promotion Code</div>
<table width="660" border="0" cellspacing="0" cellpadding="0" class="table_text">
  <tr>
    <td width="150">Code</td>
    <td width="10"></td>
    <td width="399"><?php echo $promoInfo['PromotionCode']; ?></td>
    </tr>
  <tr>
    <td width="150">Package Applicable</td>
    <td width="10"></td>
    <td width="399"><?php echo $objCore->_SYS['CONF']['SUBCRIPTIONS']['M']['OPTION']. " - " .$objCore->_SYS['CONF']['SUBCRIPTIONS']['M'][$promoInfo['Package']]; ?>
    [ <strong><?php echo $promoInfo['GracePeriod'];?> Days Free </strong>]</td>
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

<?php include("email_footer.php");?>
</div>
</div>
</div>
</div>
</div>