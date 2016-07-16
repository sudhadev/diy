<?php
	require_once("../../classes/core/core.class.php");
 	$objCore=new Core;
 	$objCore->auth(1,false);
    require_once($objCore->_SYS['PATH']['CLASS_ORDER']);
    $objOrder=new Order();
    $orderDetails = $objOrder->getOrderDetails($_REQUEST['cid'],1, $_REQUEST['invoice']);
    $orderInfo=$orderDetails[0];
    $arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];

?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 
<div align="center">
<div id="main_outer">
<div id="mainDiv">
<div id="main_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/emails/email_header.jpg" width="700" height="60" /></div>
<div id="body_area">
<div id="text_area" ><p class="main_text"><span style='font-size:13px;font-family:"Arial","sans-serif"; color:#000000'><strong>Dear <?php echo $orderInfo[1]." ".$orderInfo[2]; ?>, </strong></span></p>
<p class="main_text">
Thank you for your Payment! This email contains important information regarding your recent purchase  please save it for reference.
</p>

<div class="sub_headings">Order Details </div>
<table width="660" border="0" cellspacing="0" cellpadding="0" class="table_text">
  <tr>
    <td width="150">Invoice Number</td>
    <td width="15"></td>
    <td width="399"><?php echo $orderInfo[0]; ?></td>
    </tr>
  <tr>
    <td width="150">Description</td>
    <td width="15"></td>
    <td><?php echo $orderInfo[26];  // $str = explode("||",$orderInfo[25]); echo $arrSubscriptions[$str[0]]['OPTION']." - ".$arrSubscriptions[$str[0]][$str[1]]; ?></td>
    </tr>
  <tr>
    <td width="150">Amount (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)</td>
    <td width="15"></td>
    <td><?php echo $orderInfo[24]; ?></td>
    </tr>
</table>



<?php include("email_footer.php");?>
</div>
</div>
</div>
</div>
</div>