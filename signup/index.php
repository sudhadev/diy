<?php
session_start();
/* --------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>                '
  '    FILE            :  index.php                                  	      '
  '    PURPOSE         :                             			'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '-------------------------------------------------------------------------- */

require_once("../classes/core/core.class.php");
$objCore = new Core;
require_once($objCore->_SYS['PATH']['CLASS_REGISTRATION']);
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
$objCore->auth(1, false);

$objCustomer = new Customer();

if (isset($_REQUEST['key'])) {

    $customerDetails = $objCustomer->getCustomerByEmail($_REQUEST['email']);
    $customer_type = $objCustomer->getStatus($customerDetails[0][0]);

    if ($customer_type[0][0] == "Y" && $customerDetails[0][8] == "E") {
     
//Check if the customer is already existing
        if ($objCore->sessCusId) { //if the customer logged in
            if ($objCore->sessCusId != $customerDetails[0][0])   //If the customer is logged in with a different correct account
                header('Location:' . $objCore->_SYS['CONF']['URL_FRONT'] . 'signup/?guest=AL');
            else {
                header('Location:' . $objCore->_SYS['CONF']['URL_MY_ACCOUNT'] . '/first_login/?f=select_subscription&promo_code=' . $_REQUEST['code'] . '&promo_key=' . $_REQUEST['key'] . '&cusType=' . $_REQUEST['cusType']);
            }
        } else {
            header('Location:' . $objCore->_SYS['CONF']['URL_LOGIN_FRONT'] . '?email=' . $_REQUEST['email'] . '&promo_code=' . $_REQUEST['code'] . '&promo_key=' . $_REQUEST['key'] . '&cusType=' . $_REQUEST['cusType']);
        }
    } 
    //if($_REQUEST['ex']=="yes"){
}
//}
// }
//        if ($_REQUEST['action'] == "verify")
//	{     
//            $objCustomer = new Customer();
//            $msg = $objCustomer->verify($_POST['cus_Id'],$_POST['ver_code']);
//
// 	}
if ($_REQUEST['f'] == "verify") {
    echo 'sdffsdf';
        exit();
    if (!isset($_REQUEST['ver_code'])) {
        
        $msg = $objCustomer->verify($_REQUEST['uid'], 'first');
        echo $msg;
        exit();
    } else {
        $msg = $objCustomer->verify($_REQUEST['uid'], $_REQUEST['ver_code']);
        if ($msg[0] == "SUC") {
            //header('Location:'.$objCore->_SYS['CONF']['URL_LOGIN_MODULE'].'/process.php?uid='.$_REQUEST['email'].'&pass='.$_REQUEST['ps'].'&from=reg');
            header('Location:' . $objCore->_SYS['CONF']['URL_LOGIN_FRONT'] . '?err=530&verify=suc'); /* commented by ashan */
            //URL_MY_ACCOUNT
            //header('Location:'.$objCore->_SYS['CONF']['URL_LOGIN_FRONT']);
            header('Location:' . $objCore->_SYS['CONF']['URL_MY_ACCOUNT']); /* added by ashan */
        } else {
            
        }
    }
} else if ($_REQUEST['f'] == "reset") {

    $msg = $objCustomer->resetVerificationCode($_POST['cus_Id']);
}

if ($_REQUEST['action'] == "register") {
    //print_r($_REQUEST);
    $objRegistration = new Registration($objCore->gConf, '', $_POST['fName'], '', $_POST['email'], '', $_POST['password'], '', $_POST['company'], '', '', '', '', '', '', '', '', $_POST['cusType'], $_POST['confirmedLatitude'], $_POST['confirmedLongitude'], $subscription, $package);

    if ($_REQUEST['promo_key'] != "" && $_REQUEST['promo_code'] != "") {

        $msg = $objRegistration->register($_POST['cusType'], 'P', $_REQUEST['promo_key'], $_REQUEST['promo_code']);
    } else {
        $msg = $objRegistration->register($_POST['cusType']);
    }
    //print_r($msg);
}
$objCore->auth(1, false);
include("signup.content.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']); ?>
        <?php
        require_once($objCore->_SYS['PATH']['CLASS_GEO']); //Making a referance to Geo Class 
        $formName = "reg"; // Registration Form Name 
        $submitButtonName = "register"; // Submit Button Name 
        $mapsUrl = $objCore->_SYS['GEO']['URL']; // Google Maps URL  
        $apiKey = $objCore->_SYS['GEO']['KEY']; // Google Maps API Key for the Server 

        $objGeo = new Geo(); // Creating an Object from Geo Class 
        $map = $objGeo->getCoordinates($formName, '', '', $apiKey, $mapsUrl); // Calling the method getCoordinates()
        ?>



        <script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/signup.js"></script>
        <script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/jquery.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.signup_txtfields_company').keyup(function () {
                    var max = $(this).attr('maxlength');
                    var valLen = $(this).val().length;
                    //$('#signup_txtfields_text_block').text( valLen+'/'+max);
                    if (valLen == max && max != 0) {
                        $('#signup_txtfields_text_block').html('<strong style="color: red">' + valLen + '/' + max + '</strong>');
                    } else {
                        $('#signup_txtfields_text_block').html('<strong>' + valLen + '/' + max + '</strong>');
                    }
                });
            });

        </script>
    </head>
    <body <?php echo $jsBodyOnLoad; ?> >
        <div id="bg" style="left: 0px; top: 0px; display: none; position: absolute;"></div>
        <div id="info"></div> 
        <script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'] ?>/info.js"></script>
        <div style="z-index: 0;">
            <div align="center">
                <div id="main_outer">
                    <div id="mainDiv">
                        <div id="top_bar">
                            <!-- START TOP HEADER-->
                            <?php require_once($objCore->_SYS['PATH']['HEAD_FRONT']); ?>
                            <!-- END TOP HEADER-->
                        </div>
                        <!-- START BODY AREA-->
                        <div id="middle_bar">
                            <div id="middle_left_bar">
                                <!-- START LEFT AREA-->
                                <?php require_once($objCore->_SYS['PATH']['LEFT_FRONT']); ?>
                                <!-- END LEFT AREA-->
                            </div>
                            <div id="middle_right_bar">
                                <!-- START CONTENT AREA-->

                                <?php
                                switch ($_REQUEST['f']) {
                                    case 'verify':
                                        include("verification_user.tpl.php");
                                        break;
                                    case 'reset':
                                        include("verification_user.tpl.php");
                                        break;
                                    default: {
                                            // default inclution
                                            include("registration.tpl.php");
                                        }
                                }
                                ?>
                                <!-- END CONTENT AREA-->
                            </div>
                            <!-- END BODY AREA-->
                        </div>
                        <!-- START FOOTER AREA-->
                        <?php require_once($objCore->_SYS['PATH']['FOOTER_FRONT']); ?>
                        <!-- END FOOTER AREA-->
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>