<?php
/*
 * Written by Saliya Wijesinghe
 * 2010 04 04
 *-----------------------------------------------------------------------------------*/

$diyProfile=$objPayment->diyRecurringProfileGet($_REQUEST['pfid']);
// we should double check that this supplier is trying to access
// one of his profiles
   if($diyProfile[0][3]==$objCore->sessCusId)
   {
        // Now we can get most accurate infomation from paypal
          // get the profile from Paypal
             $pgProfile=$objPayment->diyRecurringProfileGetFromGateway($_REQUEST['pfid']);

          // Prepare necessory details
             $getNPDate=$objPayment->pharseDateTime($pgProfile['RecurringPaymentsSummary']['NextBillingDate']);
             $nextPaymentDate=$getNPDate['Stamp'];

             $getFPDate=$objPayment->pharseDateTime($pgProfile['FinalPaymentDueDate']);
             $finalPaymentDate=$getFPDate['Stamp'];
             $billingFrequency=$pgProfile['CurrentRecurringPaymentsPeriod']['BillingFrequency'];
             $billingPeriod=$pgProfile['CurrentRecurringPaymentsPeriod']['BillingPeriod'];
             $regularAmount=$objPayment->pharseAmount($pgProfile['RegularAmountPaid']); // sum of settled payments
             $amount=$objPayment->pharseAmount($pgProfile['CurrentRecurringPaymentsPeriod']['Amount'] +$pgProfile['CurrentRecurringPaymentsPeriod']['TaxAmount']);
             
             print_r($ppProfile);
   }
$arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];
?>

<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">
              <div id="banner">Scheduled Payment Details</div>
		  <div class="list">
          <div align="left">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="list_blackbg_summery">

                <table width="652" border="0" align="left" cellpadding="0" cellspacing="0"  >
      <tr>
        <td width="15" height="30" ></td>
        <td width="60"class="pbYellow">Title:</td>
        <td width="1" ></td>
        <td class="pgBar" ><?php echo $pgProfile['Description'];?></td>
      </tr>
    </table>                </td>
              </tr>
              <tr>
                <td>                </td>
              </tr>
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td align="left" valign="top" >

                <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">

                              <tr>
                                <td width="6" height="36" class="charges_grid_left" id="grid_left_end"></td>
                                <td width="155" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x">General Details</td>
                                 <td width="" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="2" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="6" height="36" class="charges_grid_right" id="grid_right_end"></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td  class="chagrs_grid_text">Profile Id </td>

                                <td class="chagrs_grid_text"><?php echo $pgProfile['ProfileID'];?></td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td  class="chagrs_grid_text">Profile Status</td>

                                <td class="chagrs_grid_text"><?php echo $pgProfile['ProfileStatus'];?></td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td class="chagrs_grid_text">Subscriber Name</td>

                                <td class="chagrs_grid_text"><?php echo $pgProfile['RecurringPaymentsProfileDetails']['SubscriberName'];?></td>
                                <td ></td>
                              </tr>
                 </table>
                 <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">

                              <tr>
                                <td width="6" height="36" class="charges_grid_left" id="grid_left_end"></td>
                                <td width="155" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x">Payment Details</td>
                                 <td width="" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="2" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="6" height="36" class="charges_grid_right" id="grid_right_end"></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td class="chagrs_grid_text">Amount (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)</td>

<td class="chagrs_grid_text"><?php echo $amount;?></td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td class="chagrs_grid_text">Billing Period</td>

                                <td class="chagrs_grid_text"><?php echo $pgProfile['CurrentRecurringPaymentsPeriod']['BillingFrequency']." ".$pgProfile['CurrentRecurringPaymentsPeriod']['BillingPeriod']." Subscription";?></td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td class="chagrs_grid_text" style="vertical-align:top;">Total Billing Cycles</td>

                                <td  class="chagrs_grid_text" style="vertical-align:top;">
                                <a id="editLinkETBC" href="javascript: showExtendCycle();"  style="display: inline;text-decoration:none;"> <span id="divTotalCycles">
                                <?php if($pgProfile['CurrentRecurringPaymentsPeriod']['TotalBillingCycles']==-1)
                                                echo "Until I Cancel";
                                           else
                                                echo $pgProfile['CurrentRecurringPaymentsPeriod']['TotalBillingCycles']+1;
                                        
                                        ?></span> [ <span style="text-decoration:underline;color:#000099;">Edit</span> ]</a>
                                <div id="expandTotalBillCycle" class="PaymentContainer" style="display: none;text-align:right;width:425px;">
                                <a href="javascript: hideExtendCycle();" id="closeExpandTotalBillCycle" style="display: inline;"><img alt="Close" title="Close" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_active.gif" border="0"/></a>

                                    <div id="etbcForm">

                                    </div>
                                    <div id="etbcMsg" style="display:block;text-align:left;padding-left:0px;"></div>
                                    <div id="etbcLorder" style="display:none;text-align:center;padding-left:130px;">
                                    <table>
                                    <tr>
                                    <td>
                                    <img alt="Close" title="Close" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/preloader.gif" border="0" />
                                    </td>
                                    <td style="padding-left:10px;font-size:14px;">
                                     Processing ...
                                    </td>
                                    </tr></table>

                                    </div>
                                </div>



                                </td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td  class="chagrs_grid_text">Number Cycles Completed</td>

                                <td  class="chagrs_grid_text"><div id="divCyclesCompleted"> <?php echo $pgProfile['RecurringPaymentsSummary']['NumberCyclesCompleted']+1;?></div></td>
                                <td ></td>
                              </tr>
                              <tr <?php if($pgProfile['CurrentRecurringPaymentsPeriod']['TotalBillingCycles']==-1){ echo ' style="display:none;" '; } ?>>
                                <td ></td>
                                <td class="chagrs_grid_text">Number Cycles Remaining</td>

                                <td class="chagrs_grid_text"><div id="divCyclesRemaining"> <?php echo $pgProfile['RecurringPaymentsSummary']['NumberCyclesRemaining'];?></div></td>
                                <td ></td>
                              </tr>

                              <tr>
                                <td ></td>
                                <td class="chagrs_grid_text">Next Billing Date</td>

                                <td class="chagrs_grid_text"> <?php echo date($objCore->gConf['DATE_FORMAT'],$nextPaymentDate); ?></td>
                                <td ></td>
                              </tr>

                              <tr <?php if($pgProfile['CurrentRecurringPaymentsPeriod']['TotalBillingCycles']==-1){ echo ' style="display:none;" '; } ?>>
                                <td ></td>
                                <td class="chagrs_grid_text">Final Payment Due Date</td>
                                <td class="chagrs_grid_text"><div id="divFinalPayment"> <?php echo date($objCore->gConf['DATE_FORMAT'],$finalPaymentDate); ?></div></td>
                                <td ></td>
                              </tr>

                 </table>

                <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">

                              <tr>
                                <td width="6" height="36" class="charges_grid_left" id="grid_left_end"></td>
                                <td width="155" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x">Credit Card Details</td>
                                 <td width="" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="2" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="6" height="36" class="charges_grid_right" id="grid_right_end"></td>
                              </tr>

                              <tr>
                                <td></td>
                                <td class="chagrs_grid_text">Credit Card Number</td>

                                <td class="chagrs_grid_text">
                                <a id="editLinkECC" href="javascript: showEditCC();"  style="display: inline;text-decoration:none;"> <span id="divCCNumber">xxxx-xxxx-xxxx-<?php echo $pgProfile['CreditCard']['CreditCardNumber'];?></span> [ <span style="text-decoration:underline;color:#000099;">Edit</span> ]</a>
                                <div id="expandEditCreditCard" class="PaymentContainer" style="display: none;text-align:right;width:425px;">
                                <a href="javascript: hideEditCC();" id="closeExpandedEditCreditCard" style="display: inline;"><img alt="Close" title="Close" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_active.gif" border="0"/></a>

                                    <div id="eccForm">

                                    </div>
                                    <div id="eccMsg" style="display:block;text-align:left;padding-left:0px;"></div>
                                    <div id="eccLorder" style="display:none;text-align:center;padding-left:130px;">
                                    <table>
                                    <tr>
                                    <td>
                                    <img alt="Close" title="Close" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/preloader.gif" border="0" />
                                    </td>
                                    <td style="padding-left:10px;font-size:14px;">
                                     Processing ...
                                    </td>
                                    </tr></table>

                                    </div>
                                </div>


                                </td>
                                <td></td>
                              </tr>
                              <tr>
                                <td></td>
                                <td class="chagrs_grid_text">Credit Card Type </td>

                                <td class="chagrs_grid_text"><?php echo $pgProfile['CreditCard']['CreditCardType'];?></td>
                                <td></td>
                              </tr>
                              <tr>
                                <td></td>
                                <td class="chagrs_grid_text">Expiry Date</td>

                                <td class="chagrs_grid_text"><?php echo $pgProfile['CreditCard']['ExpMonth']."/".$pgProfile['CreditCard']['ExpYear'];?></td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td class="chagrs_grid_text">Card Owner</td>

                                <td class="chagrs_grid_text"><?php echo $pgProfile['CreditCard']['CardOwner']['PayerName']['FirstName']." ".$pgProfile['CreditCard']['CardOwner']['PayerName']['LastName'];?> </td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td class="chagrs_grid_text" style="vertical-align:top">Address</td>

                                <td class="chagrs_grid_text">
                                <?php
                                      foreach($pgProfile['CreditCard']['CardOwner']['Address'] as $key=>$value)
                                      {
                                          switch($key)
                                          {
                                              case "Country":
                                              case "AddressOwner":
                                              case "AddressStatus":
                                                {
                                                    // We dont process these values
                                                }
                                                break;
                                              default:
                                              {
                                                   echo $value."<br/>";
                                              }

                                          } // End switch
                                      } // end foreach loop
                                      ?>

                                 </td>
                                <td ></td>
                              </tr>

                              </table>

                  </td>
              </tr>
              <tr>
                <td align="left" valign="top" ><!--<div class="page_braek page_break_fulll"></div>--></td>              </tr>
              <tr>
                <td height="20" align="left" valign="top" ></td>
              </tr>
              <tr>
                <td align="left" valign="top" >
        
              </td>
              </tr>
              <tr>
                <td align="left" valign="top" >
     
                </td>
              </tr>
              <tr>
                <td align="left" valign="top" >
 
                </td>
              </tr>
              <tr>
                <td align="left" valign="top" >
       
                </td>
              </tr>
              <tr>
                <td align="left" valign="top" ><!--<div class="page_braek page_break_fulll"></div>--></td>
              </tr>
              <tr>
                <td height="20" align="left" valign="top" ></td>
              </tr>
  <tr>
                <td class="search_partison"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td height="10"></td>
                    <td height="10"></td>
                    <td width="20" height="10"></td>
                  </tr>
                  <tr>
                    <td width="10"></td>
                    <td align="left" valign="middle"><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_orders/?pg=<?php echo $_REQUEST['pg']; ?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/back-black.jpg"border="0" /></a></td>
                    <td width="20"></td>
                  </tr>
                </table></td>
              </tr>
               </table>

          </div>
        </div>
      </div>
      <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
    </div>
  </div>
</div>
<?php
/*COUTION!  **************************
 *
 *  Its necesory to have values for following variable to use this code
 *  without issue.
 *
 * Sequence of order
 * ip,clientId,profileid
 */
   $postString="ip=".$_SERVER['REMOTE_ADDR']."&cid=".$objCore->sessCusId."&pfid=".$_REQUEST['pfid'];
   $hashString=md5($postString);

?>
<script language="javascript">
 <!--
 //Assume that the request object creation code is already included
 //   written by Saliya Wijesinghe
 	function doExtendCycles()
	{
        handleProcessMsg('block','etbcLorder');
        handleProcessMsg('none','etbcMsg');
        handleProcessMsg('none','closeExpandTotalBillCycle');       
        var Cycles              =document.getElementById('Cycles').value;
        document.getElementById('etbcForm').innerHTML='';

        var string ="gate=paypal&act=ebcyc&ajax=y&hash=<?php echo $hashString;?>&<?php echo $postString?>&Cycles=" + Cycles + "&pfid=<?php echo $_REQUEST['pfid'];?>"   ;
        document.getElementById('etbcMsg').innerHTML="<?php echo $objCore->_SYS['CONF']['URL_PAYMENT_MODULE']."/process.php";?>"+string;
        reqPayment = createAjaxRequest();
		reqPayment.open("POST", "<?php echo $objCore->_SYS['CONF']['URL_PAYMENT_MODULE']."/process.php";?>", true);
		reqPayment.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
    	reqPayment.onreadystatechange = doneExtendCycles;
    	reqPayment.send(string);
	}


    function doneExtendCycles()
    {
        if (reqPayment.readyState == 4)
		{
           
            handleProcessMsg('none','etbcLorder');
            handleProcessMsg('block','etbcMsg');
            handleProcessMsg('block','closeExpandTotalBillCycle');
            
            var expRes=reqPayment.responseText.split("||");
            if(expRes[0]=='SUC')
            {
                var expSMsg=expRes[1].split("-spl-");
                document.getElementById('etbcMsg').innerHTML=expSMsg[0];
                document.getElementById('divCyclesCompleted').innerHTML=expSMsg[1];
                document.getElementById('divCyclesRemaining').innerHTML=expSMsg[2];
                document.getElementById('divTotalCycles').innerHTML=expSMsg[3];
                document.getElementById('divFinalPayment').innerHTML=expSMsg[4];
                  
            }
            else
            {
                document.getElementById('etbcMsg').innerHTML=expRes[1];
            }
                    
            //document.getElementById('etbcMsg').innerHTML=reqPayment.responseText;
            
            
            getCycleDrop();
        }

    }

 	function doEditCC()
	{
        handleProcessMsg('block','eccLorder');
        handleProcessMsg('none','eccMsg');
        handleProcessMsg('none','closeExpandedEditCreditCard');


        var CardType            =document.getElementById('CardType').value;
        var CardNumber          =document.getElementById('CardNumber').value;
        var ExpiryDateMonth     =document.getElementById('ExpiryDateMonth').value;
        var ExpiryDateYear      =document.getElementById('ExpiryDateYear').value;
        //var CV2                 =document.getElementById('CV2').value;
var CV2 ='';
        var fName               =document.getElementById('fName').value;
        var lName               =document.getElementById('lName').value;
      
        var address             =document.getElementById('address').value;
        var street              =document.getElementById('street').value;
        var city                =document.getElementById('city').value;
        var postcode            =document.getElementById('postcode').value;
        var country             =document.getElementById('country').value;



        document.getElementById('eccForm').innerHTML='';

        var string ="gate=paypal&act=eccard&ajax=y&hash=<?php echo $hashString;?>&<?php echo $postString?>&pfid=<?php echo $_REQUEST['pfid'];?>"   ;
        string = string + "&CardType=" + CardType + "&CardNumber=" + CardNumber + "&ExpiryDateMonth=" + ExpiryDateMonth + "&ExpiryDateYear=" + ExpiryDateYear + "&CV2=" + CV2 ;
        string = string + "&fName=" + fName + "&lName=" + lName + "&address=" + address + "&street=" + street + "&city=" + city + "&postcode=" + postcode + "&country=" + country ;
        document.getElementById('eccMsg').innerHTML="<?php echo $objCore->_SYS['CONF']['URL_PAYMENT_MODULE']."/process.php";?>"+string;
        reqECC = createAjaxRequest();
		reqECC.open("POST", "<?php echo $objCore->_SYS['CONF']['URL_PAYMENT_MODULE']."/process.php";?>", true);
		reqECC.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
    	reqECC.onreadystatechange = doneEditCC;
    	reqECC.send(string);
	}

    function doneEditCC()
    {
        if (reqECC.readyState == 4)
		{

            handleProcessMsg('none','eccLorder');
            handleProcessMsg('block','eccMsg');
            handleProcessMsg('block','closeExpandedEditCreditCard');
            document.getElementById('eccMsg').innerHTML=reqECC.responseText;
            
            var expRes=reqECC.responseText.split("||");
            if(expRes[0]=='SUC')
            {
                var expSMsg=expRes[1].split("-spl-");
                document.getElementById('eccMsg').innerHTML=expSMsg[0];
//                document.getElementById('divCyclesCompleted').innerHTML=expSMsg[1];
//                document.getElementById('divCyclesRemaining').innerHTML=expSMsg[2];
//                document.getElementById('divTotalCycles').innerHTML=expSMsg[3];
//                document.getElementById('divFinalPayment').innerHTML=expSMsg[4];

            }
            else
            {
                document.getElementById('eccMsg').innerHTML=expRes[1];
            }

            //document.getElementById('etbcMsg').innerHTML=reqPayment.responseText;


            getEditCCForm();
        }

    }



    function getCycleDrop()
	{
        handleProcessMsg('block','etbcLorder');
        handleProcessMsg('none','etbcMsg');
        handleProcessMsg('none','closeExpandTotalBillCycle');
        var string ="tc=paypal&ajax=y&hash=<?php echo $hashString;?>&pfid=<?php echo $_REQUEST['pfid'];?>"   ;
        reqCdrop = createAjaxRequest();
		reqCdrop.open("POST", "etbc_form.ajax.php", true);
		reqCdrop.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
    	reqCdrop.onreadystatechange = gotCycleDrop;
    	reqCdrop.send(string);
	}

    function gotCycleDrop()
    {
        if (reqCdrop.readyState == 4)
		{
            handleProcessMsg('none','etbcLorder');
            handleProcessMsg('block','etbcMsg');
            handleProcessMsg('block','closeExpandTotalBillCycle');
            document.getElementById('etbcForm').innerHTML=reqCdrop.responseText;
        }

    }


 	function getEditCCForm()
	{
        handleProcessMsg('block','eccLorder');
        handleProcessMsg('none','eccMsg');
        handleProcessMsg('none','closeExpandedEditCreditCard');
        
        var string ="tc=paypal&ajax=y&hash=<?php echo $hashString;?>&pfid=<?php echo $_REQUEST['pfid'];?>"   ;
        reqCdrop = createAjaxRequest();
		reqCdrop.open("POST", "cc_edit_form.ajax.php", true);
		reqCdrop.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
    	reqCdrop.onreadystatechange = gotEditCCForm;
    	reqCdrop.send(string);
	}

    function gotEditCCForm()
    {
        if (reqCdrop.readyState == 4)
		{
            handleProcessMsg('none','eccLorder');
            handleProcessMsg('block','eccMsg');
            handleProcessMsg('block','closeExpandedEditCreditCard');
            document.getElementById('eccForm').innerHTML=reqCdrop.responseText;
        }

    }


    function showExtendCycle()
    {
        handleProcessMsg('none','editLinkETBC');
        handleProcessMsg('block','expandTotalBillCycle');
        handleProcessMsg('block','closeExpandTotalBillCycle');
        handleProcessMsg('block','etbcMsg');
        getCycleDrop();

    }

    function hideExtendCycle()
    {
        document.getElementById('etbcForm').innerHTML='';
        document.getElementById('etbcMsg').innerHTML='';
        handleProcessMsg('block','editLinkETBC');
        handleProcessMsg('none','expandTotalBillCycle');
        handleProcessMsg('none','etbcMsg');
    }

    function showEditCC()
    {
        handleProcessMsg('none','editLinkECC');
        handleProcessMsg('block','expandEditCreditCard');
        handleProcessMsg('block','closeExpandedEditCreditCard');
        handleProcessMsg('block','eccMsg');
        getEditCCForm();

    }

    function hideEditCC()
    {
        document.getElementById('eccForm').innerHTML='';
        document.getElementById('eccMsg').innerHTML='';
        handleProcessMsg('block','editLinkECC');
        handleProcessMsg('none','expandEditCreditCard');
        handleProcessMsg('none','eccMsg');
    }

-->
</script>