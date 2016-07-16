<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  index.php                                           '
  '    PURPOSE         :  provide the frame for any section of the system     '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
  require_once("../classes/core/core.class.php");$objCore=new Core;
    	require_once($objCore->_SYS['PATH']['CLASS_REGISTRATION']);
		//print_r($_REQUEST); 
	if ($_REQUEST['action'] == "register")
	{	
		if(!is_object($objRegistration))
	 	{  		
	  		$objRegistration= new Registration($_POST['title'], $_POST['fName'], $_POST['lName'], $_POST['email'], $_POST['emailConfirm'], $_POST['password'], $_POST['confirmPassword'], $_POST['company'], $_POST['address'], $_POST['street'], $_POST['city'], $_POST['postcode'], $_POST['country'], $_POST['phone'], $_POST['fax'], $_POST['mobile'], $_POST['cusType'], $_POST['confirmedLatitude'], $_POST['confirmedLongitude'], $subscription, $package);
	  		$msg = $objRegistration->register($_POST['cusType']);
	  		if ($msg[0]=='SUC'){
	  			$_REQUEST['f'] = "select_subscription";
	  		}
	 	}
 	}
  
  $objCore->auth(1,true); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/animatedcollapse.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/signup.js"></script>
<script type="text/javascript">
	animatedcollapse.addDiv('profile', 'fade=0,speed=400,group=account') 
	animatedcollapse.addDiv('subscriptions', 'fade=0,speed=400,group=account')
	animatedcollapse.addDiv('listings', 'fade=0,speed=400,group=account')
	animatedcollapse.addDiv('orders', 'fade=0,speed=400,group=account')
    animatedcollapse.addDiv('services', 'fade=0,speed=400,group=account')
	animatedcollapse.addDiv('classified_ads', 'fade=0,speed=400,group=account')
	//fires each time a DIV is expanded/contracted
	animatedcollapse.ontoggle=function($, divobj, state)
	{ 
		//$: Access to jQuery
		//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
		//state: "block" or "none", depending on state
	}

	animatedcollapse.init()
</script> 
</head>
<body <?php echo $jsBodyOnLoad;?> >
<div align="center">
  <div id="main_outer">
   <!-- <div id="logo"></div> -->
    <div id="mainDiv">
      <div id="top_bar">
        <!-- START TOP HEADER-->
        <?php require_once($objCore->_SYS['PATH']['HEAD_FRONT']);?>
        <!-- END TOP HEADER-->
      </div>
      <!-- START BODY AREA-->
      <div id="middle_bar">
        <div id="middle_left_bar">
          <!-- START LEFT AREA-->
          <?php require_once($objCore->_SYS['PATH']['LEFT_FRONT']);?>
          <div id="space"></div>
<div><?php include($objCore->_SYS['PATH']['SEARCH_COM']);?></div>
<div id="space"></div>
          <!-- END LEFT AREA-->
        </div>
        <div id="middle_right_bar">
          <!-- START CONTENT AREA-->
          <?php 
	switch($_REQUEST['f'])
	{
		case "select_subscription":
		{ 
			include("subscriptions.tpl.php");
		}break;
            case "email_subscriptions":
		{ 
			include("email_subscriptions/email_subscriptions.tpl.php");
		}break;
		default:
		{
			include("supplier.tpl.php");   
		}
	}
?>
          <!-- END CONTENT AREA-->
        </div>
        <!-- END BODY AREA-->
      </div>
      <!-- START FOOTER AREA-->
      <?php require_once($objCore->_SYS['PATH']['FOOTER_FRONT']);?>
      <!-- END FOOTER AREA-->
    </div>
  </div>
</div>
</body>
</html>
