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

require_once("../../classes/core/core.class.php");
$objCore=new Core;
$objCore->auth(1,true);
$arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];

require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
if(!is_object($objCustomer)) $objCustomer=new Customer($objCore->gConf);
// prevent unauthorised force access to promote section
if($_REQUEST['f']=='promote') $_REQUEST['f']='';

if($_POST['prCode'] && $_REQUEST['selections']=="M") {
    require_once($objCore->_SYS['PATH']['CLASS_PROMOTION']);
    if(!is_object($objPromotion)) $objPromotion=new Promotion($objCore->gConf);




    $response= $objPromotion->getByPromoteCode($_POST['prCode']); //echo __FILE__." ".__LINE__." RESPONSE ==> "; print_r($response); echo "<br/>";
    if($response['Ack']=="Ok") {
        // promotion code is ok we can create the requested package now


        $reqPackage=$_REQUEST['packages'];
        $packageData=explode("||",$reqPackage);//echo __FILE__." ".__LINE__." PACKAGE DATA ==> "; print_r($packageData); echo "<br/>";

        if($response['Package']==$packageData[0]) {
            $timeStamp=time();
            $packageExpire=mktime(date("H",$timeStamp), date("i",$timeStamp), date("s",$timeStamp), date("m",$timeStamp), date("d",$timeStamp)+$response['GracePeriod'],   date("Y",$timeStamp));

            // create the package
            $objCustomer->setSubcriptons($objCore->sessCusId, $_REQUEST['selections'], $packageData[0], $packageExpire);
            // update the package
            $objCustomer->updateSubcriptons($objCore->sessCusId, $_REQUEST['selections'], $packageData[0], $packageExpire,$packageData[1]);

            // update the promotion
            $objPromotion->useCode($_POST['prCode'], $objCore->sessCusId);

            $_REQUEST['f']='promote';
        }
        else {
            // error package
            $errMsg="Error: Selected Package not valid for entered Promotional Code.<br/>";
        }

    }
    else {
        // error code
        $errMsg="Error: Promotional Code Invalid.<br/>";
    }
}
else if($_POST['prCode'] && $_REQUEST['selections']=="S") {
	require_once($objCore->_SYS['PATH']['CLASS_PROMOTION']);
	if(!is_object($objPromotion)) $objPromotion=new Promotion($objCore->gConf);




	$response= $objPromotion->getByPromoteCode($_POST['prCode']); //echo __FILE__." ".__LINE__." RESPONSE ==> "; print_r($response); echo "<br/>";
	if($response['Ack']=="Ok") {
		// promotion code is ok we can create the requested package now


		$reqPackage=$_REQUEST['packages'];
		$packageData=explode("||",$reqPackage);//echo __FILE__." ".__LINE__." PACKAGE DATA ==> "; print_r($packageData); echo "<br/>";

		if($response['Package']==$packageData[0]) {
			$timeStamp=time();
			$packageExpire=mktime(date("H",$timeStamp), date("i",$timeStamp), date("s",$timeStamp), date("m",$timeStamp), date("d",$timeStamp)+$response['GracePeriod'],   date("Y",$timeStamp));

			// create the package
			$objCustomer->setSubcriptons($objCore->sessCusId, $_REQUEST['selections'], $packageData[0], $packageExpire);
			// update the package
			$objCustomer->updateSubcriptons($objCore->sessCusId, $_REQUEST['selections'], $packageData[0], $packageExpire,$packageData[1]);

			// update the promotion
			$objPromotion->useCode($_POST['prCode'], $objCore->sessCusId);

			$_REQUEST['f']='promote';
		}
		else {
			// error package
			$errMsg="Error: Selected Package not valid for entered Promotional Code.<br/>";
		}

	}
	else {
		// error code
		$errMsg="Error: Promotional Code Invalid.<br/>";
	}
}
elseif(($_REQUEST['selections']&&$_REQUEST['packages'])|| $_REQUEST['classified']) {

    if($objCore->_SYS['ENV']=='LIVE') {
        $myAccountURL=str_replace("http://", "https://", $objCore->_SYS['CONF']['URL_MY_ACCOUNT']);
    }else {
        $myAccountURL=$objCore->_SYS['CONF']['URL_MY_ACCOUNT'];
    }
    $qString="selections=".$_REQUEST['selections']."&packages=".$_REQUEST['packages']."&selMOption=".$_REQUEST['selMOption']."&classified=".$_REQUEST['classified'];
    $url= $myAccountURL."/payments/index.php?".$qString;
    header("Location: $url");

    // error
}
else {
    $objCustomer->removeSubscriptions($objCore->sessCusId, 'M');
    $objCustomer->removeSubscriptions($objCore->sessCusId, 'S');
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/jquery.min.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/subscriptions.js"></script>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
        <link href="<?php echo $objCore->_SYS['CONF']['URL_CSS_FRONT']?>/subscription.css" rel="stylesheet" type="text/css" />
    </head>
    <body <?php echo $jsBodyOnLoad;?> >
        <div align="center">
            <div id="main_outer">
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
                            <!-- END LEFT AREA-->
                        </div>
                        <div id="middle_right_bar">
                            <!-- START CONTENT AREA-->
                            <?php
switch($_REQUEST['f']) {
//		case 'confirm':
//		{
//			include("confirm.tpl.php");
//		}break;
                                default: {
                                        include("subscription.tpl.php");
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
