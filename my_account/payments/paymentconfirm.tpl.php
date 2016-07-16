<?php

require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
require_once($objCore->_SYS['PATH']['CLASS_ORDER']);
require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
if(!is_object($objClassifiedAd))
{
    $objClassifiedAd = new ClassifiedAd($objCore->gConf);
}
$objCustomer = new Customer($objCore->gConf);
$objOrder = new Order();
//print_r($_POST);echo $objCore->_SYS['CONF']['PAYMENT'][$objCore->_SYS['CONF']['GATE_WAY']]['MERCHANT'];
if($objCore->_SYS['ENV']!='LIVE')  $objCore->_SYS['CONF']['GATE_WAY'].="-DEMO";
if($objCore->_SYS['CONF']['PAYMENT'][$objCore->_SYS['CONF']['GATE_WAY']]['MERCHANT']==$_POST['MerchantID']){$_POST['gate']="cardsave";}
 

// Add necessory codes for gateway
switch($_POST['gate'])
{
    case "paypal":
        {

            if($_REQUEST['act']=='express-return')
            {
                require_once($objCore->_SYS['CONF']['DIR_MODULES']."/payments/PP-API.logic.php");
                // set diy specific messages
                if(is_array($expCheckoutResponse))
                {
                    if($expCheckoutResponse['Ack']=='Sucess'||$expCheckoutResponse['Ack']=='Success')
                    {
                        $paymentStatus='success';
                        $inv_Number=$expCheckoutResponse['InvoiceID'];
                    }
                    else
                    {

                        switch($expCheckoutResponse['MessageStack']['ErrorCode'])
                        {
                            case '10415':
                                {
                                    $paymentStatus='already-paid';
                                }
                                break;
                            default:
                                {
                                    $paymentStatus='exception-unknown';
                                }
                            } // end switch



                        } // end if - scheck for ack
                    }
                    else
                    {
                        $paymentStatus='exception-unknown';
                    }
                } // end express return
                else
                { // start direct payment
                    $ajax=true; 
                    if(is_array($response))
                    {  
                        
                        if($response['Ack']=='Sucess'||$response['Ack']=='Success')
                        {
                            $paymentStatus='success';
                            $inv_Number=$response['InvoiceID'];
                            $message='Dear '.$response['Payer']['FirstName'].' '.$response['Payer']['LastName'].',<br /><br /><br />
                                      Thank you for your payment. You will now be directed to your user area.<br /><br />
                            <div align="center"> <a href="{%URL%}"><img src="'.$objCore->_SYS['CONF']['URL_IMAGES_FRONT'].'/next-button.jpg" border=""  class="cursorHand" onClick="closeMessage();"></a></div>

                            ';
                            $megToBeFinalized=true;
                            $recProfile=$response['MessageStack']['ProfileID'];
                            $packageExt=$_POST['Frequency'];
                          
                        }
                        else
                        {

                            switch($expCheckoutResponse['MessageStack']['ErrorCode'])
                            {
                                case '10508':
                                    {
                                        $message='This transaction cannot be processed. Please enter a valid credit card expiration date.
                                            <br/>
                                           <div align="center"> <input type="button" value="  Ok  " onClick="closeMessage();" /> </div>';
                                  
                                    }
                                    break;

                                default:
                                    {
                                        $message='Dear '.$response['Payer']['FirstName'].' '.$response['Payer']['LastName'].', <br /><br />
                                                    There seems to be an issue with this payment request.<br />
                                                    This may be due to an error in the card details you have submitted
                                                    or another issue with the card. <br /><br />

                                                    Click “Next” to try again or “Cancel” to go back to your user area.<br />
                                                    Thank you <br /><br />
                                                    <div align="left">
                                                        <a href="'.$objCore->_SYS['CONF']['URL_MY_ACCOUNT'].'"><img src="'.$objCore->_SYS['CONF']['URL_IMAGES_FRONT'].'/cancel.jpg" border="" ></a>
                                                        <img src="'.$objCore->_SYS['CONF']['URL_IMAGES_FRONT'].'/next-button.jpg" border=""  class="cursorHand" onClick="closeMessage();">
                                                    </div>';
                                    }
                            } // end switch
                        }
                       
                    }

                }// end if




            }
            break;
case 'cardsave':
    {

        require_once($objCore->_SYS['CONF']['DIR_MODULES']."/payments/CS.logic.php");

    }
    break;
    default:
        die("Invalid Gateway");

    }

  
        /**
         * url for the next button of this pageas. as default, it redirect to the supplier area section.(by lakshyami)
         */
    $url = $objCore->_SYS['CONF']['URL_SYSTEM']."/my_account/";
  //echo $inv_Number."<==================".__LINE__;
    if ($inv_Number && $paymentStatus=='success')
    {
        $objOrder->updateOrderInfo($inv_Number);
        $orderInfo = $objOrder->getOrderInfo($inv_Number,true);

//print_r($orderInfo);
        
        $str = explode("||", $orderInfo[0]['contents']);
        if ($orderInfo[0]['subscriptions_lock'] == 'N')
        {                   
            // set expiration
            if($str[0]=='M')
            {
                $timeExpire=$str[4];
            }
            else
            {
                $timeExpire=$str[3];
            }
            $objCustomer->updateSubcriptons($objCore->sessCusId, $str[0], $str[1], $timeExpire,$packageExt,$recProfile);
            $objOrder->updateLock($inv_Number);
            $objCustomer->setStatus($objCore->sessCusId, 'Y', '', 'cus');
        }

                /*
                 * use this to classified ads section to change the status after payments.
                 */
        if($str[0] == "C")
        { 
            $msg = $objClassifiedAd->changeStatus($objCore->sessCusId,$inv_Number,$recProfile);
            $url = $objCore->_SYS['CONF']['URL_SYSTEM']."/my_account/classified_ads/index.php?f=manage&msg1=".$msg[0]."&msg2=".$msg[1]."";
            
        }
        elseif ($str[2] == "L")
        {
            $tmpValue = $objCore->sysVars['Content'];
            $arryVal = explode('-dlm-',$tmpValue);
            $val = explode('||',$arryVal[0]);
            $ids = explode('_',$val[5]);
            $tids = $ids[0]."_".$ids[1];
            $url = $objCore->_SYS['CONF']['URL_SYSTEM']."/my_account/my_listings/index.php?pay=Y&tids=".$tids."";
        }
 

       
        // if message to be finalized, this is the time to do it
           if($megToBeFinalized) $message=str_replace("{%URL%}",$url,$message);
        //send the email
            require_once($objCore->_SYS['PATH']['CLASS_EMAIL']);
            if(!$objEmail) $objEmail = new Email();//$objEmail->dev=true;
            $objEmail->send('order', $orderInfo[0]['email'], $objCore->sessCusId,'H',$inv_Number);
               


    }  // end order updation block

if(!$ajax)
{

?>
<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar" style="min-height:379px;">
                <div id="outer">
                    <div id="outer_middle">
                        <div id="loging_banner">
                            <?php if($paymentStatus=="success"){?>PAYMENT CONFIRMATION
                                <?php }else{ ?>ERROR OCCURRED
                                <?php }?> </div>
                        <div id="text_area" class="common_text">

    <?php
    switch($paymentStatus)
    {
        case "success":
            {
                echo ' <br />
                    Dear '.$orderInfo[0]['f_name'].' '.$orderInfo[0]['l_name'].',<br/><br />
                    Thank you for your payment.<br /><br />
                    You will now be directed to your user area.<br /><br />
                    ';
            }
            break;
        case "card-declined":
        case "duplicated":
        case "already-paid":
        case "exception-gateway":
        case "exception-unknown":
            default:
            {
                echo ' <br />
                        Dear '.$objCore->sessData[0]." ".$objCore->sessData[1].', <br /><br />
                        There seems to be an issue with this payment request.<br />
                        This may be due to an error in the card details you have submitted
                        or another issue with the card. <br /><br />

                        Click “Next” to try again or “Cancel” to go back to your user area.<br />
                        Thank you



                                                               ';

            }
            break;
//        case "duplicated":
//            {
//                echo ' <br />
//                                                              Duplicate Order has been found. Please re-order or contact the Administrator.<br />
//                                                               <br />  <br />
//                                                              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc. Curabitur vehicula nunc in nunc. Ut accumsan, metus fermentum varius rutrum, magna magna luctus purus, quis aliquam sapien purus a augue. Phasellus vestibulum blandit neque. Integer venenatis ultrices felis. Nullam sit amet massa. Fusce iaculis. Sed leo dolor, ornare quis, vulputate sed, ullamcorper eu, magna. <br />
//                                                                 ';
//
//            }
//            break;
//        case "already-paid":
//            {
//                echo ' <br />
//                                                              A successful transaction has already been completed for this Order.<br />
//                                                               <br />  <br />
//                                                              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc. Curabitur vehicula nunc in nunc. Ut accumsan, metus fermentum varius rutrum, magna magna luctus purus, quis aliquam sapien purus a augue. Phasellus vestibulum blandit neque. Integer venenatis ultrices felis. Nullam sit amet massa. Fusce iaculis. Sed leo dolor, ornare quis, vulputate sed, ullamcorper eu, magna. <br />
//                                                                 ';
//
//            }
//            break;
//
//        case "exception-gateway":
//        case "exception-unknown":
//            default:
//                {
//                    echo ' <br />Error occurred during the payment process. ';
//                    if($_POST['Message']) echo "due to ".$_POST['Message'];
//
//                    echo '                                   <br />  <br />
//                                                              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc. Curabitur vehicula nunc in nunc. Ut accumsan, metus fermentum varius rutrum, magna magna luctus purus, quis aliquam sapien purus a augue. Phasellus vestibulum blandit neque. Integer venenatis ultrices felis. Nullam sit amet massa. Fusce iaculis. Sed leo dolor, ornare quis, vulputate sed, ullamcorper eu, magna. <br />
//
//                                                         ';
//
//                }
//                break;

        }

        ?>
                        </div>
                    </div>
                    <div id="signup_butten" align="left"><a href="<?php echo $url;?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/next-button.jpg" border="" /></a></div>
                </div>
            </div>
            <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
        </div>
    </div>
</div>
<?php
}
else
{
?>
     <div id="text_area" class="common_text" style="width:520px;">
        <? echo $message;?>
     </div>

<?php
}
?>