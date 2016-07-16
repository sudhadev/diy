<?php	
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
$objCustomer = new Customer();
require_once($objCore->_SYS['PATH']['CLASS_ORDER']);
$objOrder = new Order($objCore->gConf); 
$customerStatus = $objCustomer->getStatus($objCore->sessCusId);
$arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];
require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);


if(!is_object($objClassifiedAd))
{
    $objClassifiedAd = new ClassifiedAd($objCore->gConf);
}

// Payment class inclution - Added by saliya
require_once($objCore->_SYS['PATH']['CLASS_PAYMENT']);
if(!is_object($objPayment)) $objPayment = new Payment($objCore->gConf);
$limitExeededForReqPackage=false;


// If this is the first login, add classifid ads to the subscription
if($_REQUEST['classified']=='C') $objCustomer->setSubcriptons($objCore->sessCusId, '', '');


//start generating the array keys for global config variables
switch ($_REQUEST['selections'])
{
    case 'M':
        {
            require_once($objCore->_SYS['PATH']['CLASS_GLOBAL_CONFIG']);
            if(!is_object($objGlobalConfig)) $objGlobalConfig= new GlobalConfig;
            $pkgNPlan=explode("||",$_REQUEST['packages']);
            $fareData=$objGlobalConfig->pickAFare($pkgNPlan[0], $pkgNPlan[1]);
            $val = $fareData[2];
            
            require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
            if(!$objListing) $objListing = new Listing;
            $listingAdded=$objListing->getListingCountsByCustomer($objCore->sessCusId);
            $currentSubs="SUBSCRIPTION_".strtoupper($objCore->_SYS['CONF']['SUBCRIPTIONS']['M'][$pkgNPlan[0]]);
            $reqPkgName=$objCore->_SYS['CONF']['SUBCRIPTIONS']['M'][$pkgNPlan[0]];
            $allowedListingsReqPackage= $objCore->gConf["SUBSCRIPTION_".strtoupper($objCore->_SYS['CONF']['SUBCRIPTIONS']['M'][$pkgNPlan[0]])];
            if((int)$allowedListingsReqPackage<(int)$listingAdded) $limitExeededForReqPackage=true;


        }break;
    case 'S':
        {
            $str = explode(" ", $arrSubscriptions['S'][$_REQUEST['packages']]);
            $val = "SUBSCRIPTION_".strtoupper($str[0].$str[1])."_PRICE";
        }break;
} //end switch





if ($customerStatus[0][0] == 'W') //if customer is waiting for approval
{
    //$objCustomer->setSubcriptons($objCore->sessCusId, $_REQUEST['selections'], $_REQUEST['packages']);
    //header("Location:".$objCore->_SYS['CONF']['URL_SYSTEM']."/my_account/payments/?selections=C&classifiedPayment=".$msg[1]);
    echo "<meta http-equiv='refresh' Content='0; URL=".$objCore->_SYS['CONF']['URL_MY_ACCOUNT']."/first_login/index.php?f=pending'>";
    exit;
} //if not waiting for approval
else
{ 
    if (empty($_REQUEST['selections']))
    {
        $val = "SUBSCRIPTION_".$arrSubscriptions['C'][$_REQUEST['packages']]."_PRICE";
        $objCustomer->setSubcriptons($objCore->sessCusId, '', '');
        echo "<meta http-equiv='refresh' Content='0; URL=".$objCore->_SYS['CONF']['URL_MY_ACCOUNT']."'>";
        exit;
    }
    elseif (!$_REQUEST['classifiedPayment']) //if payment is not from the classified ads
    {
        $reqPackage=$_REQUEST['packages'];$packageData=explode("||",$reqPackage);
        // if ($customerStatus[0][2] == null)
        $objCustomer->setSubcriptons($objCore->sessCusId, $_REQUEST['selections'], $packageData[0]);
        if ($_REQUEST['listing']) $_REQUEST['packages'] = $_REQUEST['packages']."||".$_REQUEST['listing'];
            /**
             * If the subscription is Supplies the calculation should be different
             * Added By Saliya
             */
        if ($_REQUEST['selections']=='M')
        {
                    /* Current customer information need for the calculations
                     */
            $orderPeriod='Month';
            $payData=$objPayment->calculateBuildingSupplierFare($objCore->sessCusId, $customerStatus, $reqPackage,$orderPeriod);


            if($payData['Ack']=='Ok')
            {
                // Success message retrieved
                switch($payData['Action'])
                {
                    case "FIRST-SUBCRIPTION":
                        case "EXPIRED|NEW-PROFILE":
                            case "NON-EXPIRED|NON-RECURRING|NEW-PROFILE":
                                {
                                    // TO be added when required
                                    $showPaymentForm=true;
                                }
                                break;

                            case "NON-EXPIRED|NON-RECURRING|EXTEND-TIME":
                                {
                                    // TO be added when required


                                }
                                break;

                            case "NON-EXPIRED|RECURRING|UPDATE-PROFILE":
                                {

                                    $payProfileId=$payData['profileId'];
                                    $extraMessage="Your existing payment schedule will be canceled
                                                and a new schedule will be created  during the process.
                                                Please visit My Account> Schedule Payment after the
                                                payment process and make sure your existing profile
                                                [<b>$payProfileId</b>] has been canceled. If the profile still Active,
                                                you can edit the profile and inactive it manually.";
                                    $showPaymentForm=true;
                                }
                                break;

                            default:
                                {
                                    // Issue in somewhere
                                    // display an error message
                                }
                            }

                        }
                        else
                        {
                            // Prepare error messge to display
                            // no need to show payment form
                            $showPaymentForm=false;
                        }

                        $orderFrequency=$payData['Frequent'];
                        $orderAmount=$payData['InitialPayment'];
                        $recurringPaymentAmount=$payData['FareData']['NEW_PAY_CYCLE'];


                        $_REQUEST['packages'].="||".$payData['NextPayDate']; // add the expairation time

                        $_REQUEST['packages']=$packageData[0].'||'.$packageData[1].'||'.$packageData[2];

                        // set order title
                        if(is_array($payData['FareData']))
                        {
                            if($payData['FareData']['ADJ_CHARGES']) $orderTitle='<onetime>Package Adjustment Charges<br/>New Package :</onetime>';
                            if($payData['FareData']['EXP_PERIOD']) $orderTitle='<onetime>Late Charges ['.$objCore->_SYS['CONF']['CURRENCY']." ".number_format($payData['FareData']['EXP_PERIOD'],2).'] + </onetime>';

                            $orderTitle.="".$arrSubscriptions['M']['OPTION']." - ".$arrSubscriptions['M'][$packageData[0]]." - ".$orderFrequency." ".$orderPeriod."(s)";

                        }
                        else
                        {
                            $orderTitle=$arrSubscriptions['M']['OPTION']." - ".$arrSubscriptions['M'][$packageData[0]]." - ".$orderFrequency." ".$orderPeriod."(s)";

                        }



                    }
                    else
                    {// requested services

                        $orderPeriod='Month';
                        $payData=$objPayment->calculateBuildingServicesFare($objCore->sessCusId, $customerStatus, $reqPackage,$orderPeriod);

                        if($payData['Ack']=='Ok')
                        {
                            // Success message retrieved
                            switch($payData['Action'])
                            {
                                case "FIRST-SUBCRIPTION":
                                    case "EXPIRED|NEW-PROFILE":
                                        case "NON-EXPIRED|NON-RECURRING|NEW-PROFILE":
                                            {
                                                // TO be added when required
                                                $showPaymentForm=true;
                                            }
                                            break;

                                        case "NON-EXPIRED|NON-RECURRING|EXTEND-TIME":
                                            {
                                                // TO be added when required


                                            }
                                            break;

                                        case "NON-EXPIRED|RECURRING|UPDATE-PROFILE":
                                            {

                                                $payProfileId=$payData['profileId'];
                                                $extraMessage="Your existing payment schedule will be canceled
                                                and a new schedule will be created  during the process.
                                                Please visit My Account> Schedule Payment after the
                                                payment process and make sure your existing profile
                                                [<b>$payProfileId</b>] has been canceled. If the profile still Active,
                                                you can edit the profile and inactive it manually.";
                                                $showPaymentForm=true;
                                            }
                                            break;

                                        default:
                                            {
                                                // Issue in somewhere
                                                // display an error message
                                            }
                                        }

                                    }
                                    else
                                    {
                                        // Prepare error messge to display
                                        // no need to show payment form
                                        $showPaymentForm=false;
                                    }


                                    $orderFrequency=$payData['Frequent'];
                                    $orderAmount=$payData['InitialPayment'];
                                    $recurringPaymentAmount=$payData['FareData']['NEW_PAY_CYCLE'];




                                    // set order title
                                    if(is_array($payData['FareData']))
                                    {
                                        if($payData['FareData']['ADJ_CHARGES']) $orderTitle='<onetime>Package Adjustment Charges<br/></onetime>';

                                        $orderTitle.="<onetime><strong>New Package :</strong></onetime>".$arrSubscriptions['S']['OPTION']." - ".$orderFrequency." ".$orderPeriod."(s)";

                                    }
                                    else
                                    {
                                        $orderTitle=$arrSubscriptions['S']['OPTION']." - ".$orderFrequency." ".$orderPeriod."(s)";

                                    }

                                    $_REQUEST['packages'].="||".$payData['NextPayDate']; // add the expairation time

                                    // order details for payment

                                    //$orderFrequency=$_REQUEST['packages'];
                                    //  $orderTitle=$arrSubscriptions['S']['OPTION']." - ".$orderFrequency." ".$orderPeriod."(s)";

                                }



                                $nextPaymentDate=$objPayment->calcNextBillingDateTime($orderPeriod, $orderFrequency);
                                $_REQUEST['packages'].="||".$nextPaymentDate;
        /*
                 *  / End of the code added for different package selection scenario
                 * / added by Saliya
                 */



                                $invoice_number = $objOrder->setOrder($objCore->sessCusId, $_REQUEST['selections'], $_REQUEST['packages'], $orderAmount, $objCore->_SYS['CONF']['GATE_WAY'],$orderTitle);
                                $orderDetails = $objOrder->getOrderDetails($objCore->sessCusId, $_REQUEST['pg'], $invoice_number);
                                $arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];
                            }
                            else //if payment is from the classified ads
                            {
            /*
             * Get the classified Ad details
             */
                                $cAdClient=$_REQUEST['auth'];
                                $cAdImage=$_REQUEST['imgKey'];
                                $cAdAddedTime=$_REQUEST['num'];
                                $result=$objClassifiedAd->dList("WHERE supplier_id='".$cAdClient."' AND image='".$cAdImage."' AND added_date='".$cAdAddedTime."' ");

                                // order details for payment
                                $orderTitle=$arrSubscriptions['C']['OPTION']." - ".$result[0][5];
                                $orderPeriod='Month';
                                $orderFrequency=1;
                                // get the payment
                                $orderAmount=$objClassifiedAd->getClassifiedFares($result[0][8]);
                                //----------------

                                $invoice_number = $objOrder->setOrder($objCore->sessCusId, $_REQUEST['selections'], $_REQUEST['packages'], $orderAmount, $objCore->_SYS['CONF']['GATE_WAY'],$orderTitle);
                                $orderDetails = $objOrder->getOrderDetails($objCore->sessCusId, $_REQUEST['pg'], $invoice_number);
                                $arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];
            /*
             * add invoice number to the classified_ads table before done the payment.
            */
                                // change varibales of last 2 param by saliya (removed $_REQUEST with assigned
                                $objClassifiedAd->addInvoiceNo($objCore->sessCusId,$invoice_number,$cAdImage,$cAdAddedTime);

                            }
                        }

    /**
     * Call back URL for the payment gateways
     *
     */
                        $callBackURL=$objCore->_SYS['CONF']['URL_MY_ACCOUNT']."/payments/?f=tks";



                        ?>

<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar">
                <div id="outer">
                    <div id="outer_middle">
                        <div id="loging_banner">ORDER CONFIRMATION</div>
           
                        <div id="text_area" class="common_text"> Dear Customer, <br />
                        <?php if($orderDetails[0][24]>0 && !$limitExeededForReqPackage) { ?>
                            <br /> You are about to pay <strong> <?php echo $objCore->_SYS['CONF']['CURRENCY']." ".$orderDetails[0][24]; ?><?php //if ($_REQUEST['classifiedPayment']) { echo $_REQUEST['classifiedPayment'];} else {echo $objCore->gConf[$val];}?> </strong>for the selected subscription option by you.<br />
                            <?php if($extraMessage) echo "<br/><i>".$extraMessage."</i><br/>";?>
                            <br />
                            <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="6" height="36" class="charges_grid_left" id="grid_left_end"></td>
                                    <td height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" style="background-repeat:repeat-x" class="chagrs_grid_heading">Description / Details</td>
                                    <td width="75" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                    <td width="1" height="36" class="grid_break"></td>
                                    <td width="75" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x">Total</td>
                                    <td width="6" height="36" class="charges_grid_right" id="grid_right_end"></td>
                                </tr>
                                <tr>
                                    <td width="6"></td>
                                    <td class="chagrs_grid_text"><?php  echo $orderTitle;//$str = explode("||",$orderDetails[0][25]); echo $arrSubscriptions[$str[0]]['OPTION']." - ".$arrSubscriptions[$str[0]][$str[1]]; ?>
                                        <?php if($packageUpgrade){ echo "<br/><strong>[ Upgrade the Package from ".$arrSubscriptions['M'][$currPackage]." to ".$arrSubscriptions['M'][$packageData[0]]." ]</strong>";}?>
                                        <?php //if($result[0][5]) echo "<br/><i>".$result[0][5].'</i>';?>
                                    </td>

                                    <td width="75" class="chagrs_grid_text"></td>
                                    <td></td>
                                    <td width="75" class="chagrs_grid_text" style="text-align:right"> <?php echo $objCore->_SYS['CONF']['CURRENCY']." ".$orderDetails[0][17]; ?></td>
                                    <td width="6"></td>
                                </tr>

                                <tr >
                                    <td height="10"></td>
                                    <td height="10"></td>
                                    <td height="10"></td>
                                    <td height="10"></td>
                                    <td height="10"></td>
                                    <td height="10"></td>
                                </tr>
                                <tr >
                                    <td width="6"></td>
                                    <td class="chagrs_grid_text ash_strip"></td>

                                    <td width="75" class="chagrs_grid_text ash_strip">Sub Total</td>
                                    <td></td>
                                    <td width="75" class="chagrs_grid_text ash_strip" style="text-align:right"><?php echo $objCore->_SYS['CONF']['CURRENCY'];?> <?php echo $orderDetails[0][17]; ?></td>
                                    <td width="6"></td>
                                </tr>
                                <?php if ($objCore->gConf['ORDER_VAT_CALCULATE'] == 'Y') {?>
                                <tr>
                                    <td width="6"></td>
                                    <td class="chagrs_grid_text"></td>
                                    <td width="75" class="chagrs_grid_text">VAT [+]</td>
                                    <td></td>
                                    <td width="75" class="chagrs_grid_text" style="text-align:right"><?php echo $objCore->_SYS['CONF']['CURRENCY'];?> <?php echo $orderDetails[0][19]; ?></td>
                                    <td width="6"></td>
                                </tr>
                                <?php }?>
                                <tr>
                                    <td height="10"></td>
                                    <td height="10"></td>
                                    <td height="10"></td>
                                    <td height="10"></td>
                                    <td height="10"></td>
                                    <td height="10"></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td class="chagrs_grid_text ash_strip"></td>
                                    <td class="chagrs_grid_text ash_strip"><strong>Total</strong></td>
                                    <td></td>
                                    <td class="chagrs_grid_text ash_strip" style="text-align:right"> <strong><?php echo $objCore->_SYS['CONF']['CURRENCY'];?> <?php echo $orderDetails[0][24]; ?></strong></td>
                                    <td></td>
                                </tr>

                            </table>
                            <?php }else{

                            // set 2 weeks prior date from the expiaraion
                               $displayDate=$payData['CurrentExpire']-(3600*24*14);
                               
                               if($limitExeededForReqPackage)
                               {
                                   echo "<br />We are unable to degrade your package. Number of listings allowed in ".$reqPkgName." package
                                        exceeds number of current listing subscribed by you.

                                        Please contact DIY Team via <a href=\"mailto:".$objCore->gConf['MAIL_SALES']."
                                        \">".$objCore->gConf['MAIL_SALES']."</a> if you need any further information.";
                               }else
                               {
                                   echo "<br />We are unable to process your subscription now. Please try again after 
                                        <strong>".date($objCore->gConf['DATE_FORMAT'],$displayDate)."</strong> 
                                        or contact DIY Team via <a href=\"mailto:".$objCore->gConf['MAIL_SALES']."
                                        \">".$objCore->gConf['MAIL_SALES']."</a>";
                               }
                              // $objCore->gConfig();
                            ?>
                                
                            <?php } ?>



                                                    <?php
                                                    // start order amount checking
                                                    if($orderDetails[0][24]>0 && !$limitExeededForReqPackage)
                                                    {



                                                        if ($_REQUEST['selections'] && $_REQUEST['packages'])
                                                        {
                                                            $invoice_amount = "GBP ".$payArray[$_REQUEST['selections']][$_REQUEST['packages']];
                                                        }
                                                        else
                                                        {
                                                            $invoice_amount = "GBP ".$payArray[$subsType[0]][$PkgType[0]];
                                                        }



                                                        ?>


                            <div id="list_add_cads" style="margin-left:-3px;">
                                <div align="left">

                                    <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                        <tbody><tr>
                                                <td class="list_blackbg_summery">
                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                        <tbody><tr>

                                                                <td width="47%">
                                                                    <table width="100%" align="left" border="0" cellpadding="0" cellspacing="0">
                                                                        <tbody><tr>
                                                                                <td width="13" height="30"></td>
                                                                                <td class="pgBar" width="206" height="30">Payment Schedule Selection</td>
                                                                                <td class="pbYellow" width="420" height="30"><a class="pbYellow"></td>
                                                                                <td width="13"></td>
                                                                            </tr>

                                                                    </tbody></table>
                                                                </td>
                                                            </tr>
                                                    </tbody></table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="16"></td>
                                            </tr>

                                            <tr>
                                                <td><div class="add_classified_formmain">
                                                        <div class="add_classified_formtop"></div>
                                                        <div class="add_classified_formmiddle">
                                                            <div id="payment_method_cont">



                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="commonInfoBox" style="float:none;margin:-10px 0 5px -15px;width:600px;">
                                                                    <tr>
                                                                        <td colspan="2" class="payment_box_text">

                                                                                                        <?php echo $pageContents['infoAutoPayment'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td class="payment_box_text"><?php echo $pageContents['infoManualPayment'];?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td colspan="2" class="common_text">&nbsp;   </td>
                                                                    </tr>
                                                                </table>

                                                                <br/>



                                                                <div id="payAutoManContainer">
                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">


                                                                        <tr>
                                                                            <td colspan="2" class="label_txt">
                                                                            Select Payment Method   </td>

                                                                        </tr>
                                                                        <tr><td colspan="2">&nbsp;</td></tr>
                                                                        <tr>
                                                                            <td width="50%"><label class="label_txt">

                                                                                    <input type="radio" name="pay_meth"  value="auto_pay" checked="checked" onclick="handleProcessMsg('block','automatic_payment');handleProcessMsg('none','manual_payment');"/>
                                                                                Automatic Payment</label><br />
                                                                            <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/payment/paypal.jpg" alt="Pay Pal" class="payment_image"/></td>
                                                                            <td><label class="label_txt">

                                                                                <input type="radio" name="pay_meth"  value="manu_pay" onclick="handleProcessMsg('none','automatic_payment');handleProcessMsg('block','manual_payment');"/> Manual Payment</label><br />

                                                                                <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/payment/paypal.jpg" alt="Pay Pal" class="payment_image "/>
                                                                                <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/payment/card_save.jpg" alt="Card Save" width="62" height="20" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr><td colspan="2">&nbsp;</td></tr>

                                                                    </table>

                                                                    <div id="manual_payment" style="display:none; margin-left:300px;">

                                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                            <tr><td height="30" colspan="2" valign="top"><label class="label_txt">Select Payment Gateway</label></td></tr>
                                                                            <tr>
                                                                                <td width="50%" height="30" valign="top" class="man_pay_opt">
                                                                                    <div><label class="label_txt">
                                                                                        <input type="radio" name="gateway" id="card_save" value="CardSave" onclick="handleProcessMsg('block','payCS');handleProcessMsg('none','payPP');" checked="checked" />CardSave</label><br />
                                                                                        <?php
                                                                                        include $URL_PG=$objCore->_SYS['CONF']['DIR_MODULES']."/payments/CS.pay.php";
                                                                                        ?>
                                                                                    </div>
                                                                                </td>
                                                                                <td height="30" valign="top"  class="man_pay_opt">
                                                                                    <div><label class="label_txt">
                                                                                        <input type="radio" name="gateway" id="pay_pal" value="PayPal"  onclick="handleProcessMsg('none','payCS');handleProcessMsg('block','payPP');" />PayPal</label><br />

                                                                                                                    <?php
                                                                                                                    // display direct payment section
                                                                                                                    include $URL_PG=$objCore->_SYS['CONF']['DIR_MODULES']."/payments/PP-API.pay.php";
                                                                                                                    ?>
                                                                                </div></td>
                                                                            </tr>

                                                                        </table>
                                                                    </div>
                                                                    <div id="automatic_payment" style="margin-left:-10px;display:block;">

                                                                                                    <?php
                                                                                                    $use='Direct';// display direct payment section
                                                                                                    $customerData=$objCustomer->getCustomerData($objCore->sessCusId);
                                                                                                    $customerInfo = $customerData[0];
                                                                                                    include $URL_PG=$objCore->_SYS['CONF']['DIR_MODULES']."/payments/PP-API.pay.php";
                                                                                                    ?>

                                                                    </div>
                                                                </div>
                                                                <div id="msgBoxContainer" style="display:none;">
                                                                    <div id="preLoaderContainer" >
                                                                        <table>
                                                                            <tbody><tr>
                                                                                    <td>
                                                                                        <img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/preloader.gif" title="Processing Image" alt="Processing Image"/>
                                                                                    </td>
                                                                                    <td style="padding-left: 10px; font-size: 14px;">
                                                                                        Processing ...
                                                                                    </td>
                                                                            </tr></tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div id="msgContainer"></div>

                                                                </div>

                                                                <table width="100%" border="0" cellspacing="0" cellpadding="0" style="float:left;"t>
                                                                    <tr><td>
                                                                            &nbsp;
                                                                            <hr />
                                                                    </td></tr>


                                                                    <tr>
                                                                        <td height="50" align="center" valign="bottom">
                                                                            <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/payment/visa_electron.jpg" alt="Visa Electron" width="46" height="30" class="payment_image" />
                                                                            <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/payment/visa.jpg" alt="Visa" width="46" height="30" class="payment_image"/>
                                                                            <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/payment/verifi_visa.jpg" alt="Verify Visa" width="46" height="30" class="payment_image"/>
                                                                            <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/payment/master_card.jpg" alt="Master Card" width="46" height="30" class="payment_image"/>
                                                                            <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/payment/maestro.jpg" alt="Maestro" width="46" height="30" class="payment_image" />
                                                                            <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/payment/mater_secure_code.jpg" alt="Master Card Secure" width="46" height="30" class="payment_image" />
                                                                            <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/payment/jcb_logo.jpg" alt="JCB" width="28" height="30" />
                                                                            <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/payment//american_express.jpg" alt="American Express" width="46" height="30" />
                                                                            <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/payment/solo_logo.jpg" alt="Solo" width="24" height="29" class="payment_image"/>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </div>

                                                        </div>
                                                        <div class="add_classified_formbottom"/></div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="10"></td>

                                            </tr>
                                    </tbody></table>
                                </div>
                                <?} // end order amount checking ?>
                            </div>

                        <?php ?>

                        </div>


                    </div>
                </div>
                <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
            </div>
        </div>
    </div>
</div>
<script language="javascript">
    function startProcessing()
    {
        handleProcessMsg('none','payAutoManContainer');
        handleProcessMsg('block','msgBoxContainer');
        handleProcessMsg('block','preLoaderContainer');
        document.getElementById('msgContainer').innerHTML='';

    }
    function endProcessing()
    {

        handleProcessMsg('block','msgBoxContainer');
        handleProcessMsg('none','preLoaderContainer');
    }

    function closeMessage()
    {
        handleProcessMsg('block','payAutoManContainer');
        handleProcessMsg('none','msgBoxContainer');
        handleProcessMsg('none','preLoaderContainer');
        document.getElementById('msgContainer').innerHTML='';
    }

    handleProcessMsg('block','payCS');
    handleProcessMsg('none','payPP');
</script>
