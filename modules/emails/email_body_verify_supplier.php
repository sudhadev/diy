<?php
	require_once("../../classes/core/core.class.php");
 	$objCore=new Core;
	$objCore->auth(1,false);
    
    $email= $_REQUEST['em'];
    $id= $_REQUEST['id'];
    $pass = $_REQUEST['type'];
    
    require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
    if(!is_object($objCustomer)) 
        $objCustomer= new Customer();
    $verificationInfo=$objCustomer->getVerifiationCode($id);
 
    $verificationLinks = $objCustomer->getVerificationLinks($id,$pass);
    
    
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../css/email.css" rel="stylesheet" type="text/css" /> 
<div align="center">
<div id="main_outer">
<div id="mainDiv">
<div id="main_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/emails/email_header.jpg" width="700" height="60" /></div>
<div id="body_area">
<div id="text_area" ><p class="main_text"><span style='font-size:13px;font-family:"Arial","sans-serif"; color:#000000'><strong>Dear Customer, </strong></span></p>

<p class="main_text">

This code can only be used once after registration, for activating your account.

</p>


<div class="sub_headings"></div><br/><br/>
<table width="500" border="0" cellspacing="0" cellpadding="0" class="table_text" style="margin-left: 240px;">
  <tr>
    <td width="200"><strong>Verification Code</strong></td>
    <td width="10"></td>
    <td width="290"><?php echo $verificationInfo[0][ver_key]; ?></td>
    </tr>
    <tr></tr>
    <tr>
    <td width="200"><strong>Valid for</strong></td>
    <td width="10"></td>
    <td width="290">24 hours</td>
    </tr>
     <tr></tr>
    <tr>
    <td width="200"><strong>Activate Account</strong></td>
    <td width="10"></td>
    <td width="290"><?php echo $verificationLinks['activate']; ?></td>
    </tr>
     <tr></tr>
    <tr>
    <td width="200"><strong>Reset Code</strong></td>
    <td width="10"></td>
    <td width="299"><?php echo $verificationLinks['reset']; ?></td>
    </tr>
</table> 
<br/>
<?php include("email_footer.php");?>
</div>
</div>
</div>
</div>
</div>