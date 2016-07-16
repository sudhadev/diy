<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  console/users/user_edit.tpl.php                     '
  '    PURPOSE         :  edit users page of the user section                 '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
	$objComponent = new Component();
	require_once($objCore->_SYS['PATH']['CLASS_PAYMENT']);
  	$objPayment = new Payment($objCore->gConf);

    // Get profile information from the paypal
       $pgProfile=$objPayment->diyRecurringProfileGetFromGateway($_REQUEST['prid']);

    // Get payment details from the database
       $paymentDetails=$objPayment->diyRecurringPaymentGetByProfile($_REQUEST['prid']);
   

    // We should prepare the listings for sheduled payments
       $getNPDate=$objPayment->pharseDateTime($pgProfile['RecurringPaymentsSummary']['NextBillingDate']);
       $nextPaymentDate=$getNPDate['Stamp'];

       $getFPDate=$objPayment->pharseDateTime($pgProfile['FinalPaymentDueDate']);
       $finalPaymentDate=$getFPDate['Stamp'];

       $nextIndex=count($paymentDetails);
       $billingFrequency=$pgProfile['CurrentRecurringPaymentsPeriod']['BillingFrequency'];
       $billingPeriod=$pgProfile['CurrentRecurringPaymentsPeriod']['BillingPeriod'];
       $regularAmount=$objPayment->pharseAmount($pgProfile['RegularAmountPaid']); // sum of paid amounts
       $amount=$objPayment->pharseAmount($pgProfile['CurrentRecurringPaymentsPeriod']['Amount'] +$pgProfile['CurrentRecurringPaymentsPeriod']['TaxAmount']);
       
       for($l=$nextIndex;$l<$pgProfile['CurrentRecurringPaymentsPeriod']['TotalBillingCycles']+1;$l++)
       {

            // set the status
               if($nextPaymentDate<time())
               {
                   $status="<font color=\"#ff0000\">Not Updated</font>";
               }
               else
               {
                   $status="Sheduled";

               }
            $paymentDetails[$l]=array(
                0=>'', // transaction id - null
                1=>$_REQUEST['prid'], // profile id
                2=>'', // order id - null
                3=>'', // cycle id - no need
                4=>$amount, // amount
                5=>$status, // status
                6=>'<i>- Not Available Yet-</i>',
                7=>$nextPaymentDate, // time
                8=>'', // flag - null

            );
           // we should prepare the next payment date
           $nextPaymentDate=$objPayment->calcNextBillingDateTime($billingPeriod, $billingFrequency, $nextPaymentDate);

       }


    // preapare back link for back button
    if(!$_REQUEST['blvals'])
        $backLinkValues='&f='.$_REQUEST['olt'].'&pg='.$_REQUEST['pg'];
    else
        $backLinkValues=$_REQUEST['blvals'];



  	if($msg)
	{
		echo $objCore->msgBox("ORDER",$msg,'98%');
	}


/* Display Profile details*/
 if($pgProfile['Ack']=='Success')
 {
?>
<style>
    .chagrs_grid_text {
        padding-bottom:4px;
        padding-top:5px;
}
</style>
<div id="toolbar-box">
<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
</div>
			<div class="m">

<!-------------- Function form----------->
<table width="100%" border="0">
  <tr valign="top">
    <td width="550">

	  <fieldset id="page-middle-middle-content">
	  <legend>View Profile - <?php echo $pgProfile['ProfileID'] ?> </legend>

                <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">

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
                                <td class="chagrs_grid_text">Description</td>

                                <td class="chagrs_grid_text"><?php echo $pgProfile['Description'];?></td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td class="chagrs_grid_text">Subscriber Name</td>

                                <td class="chagrs_grid_text"><?php echo $pgProfile['RecurringPaymentsProfileDetails']['SubscriberName'];?></td>
                                <td ></td>
                              </tr>
                 </table>
                 <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">

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
                                <td class="chagrs_grid_text">TotalBilling Cycles</td>

                                <td  class="chagrs_grid_text"><?php echo $pgProfile['CurrentRecurringPaymentsPeriod']['TotalBillingCycles']+1;?></td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td  class="chagrs_grid_text">NumberCyclesCompleted</td>

                                <td  class="chagrs_grid_text"><?php echo $pgProfile['RecurringPaymentsSummary']['NumberCyclesCompleted']+1;?></td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td class="chagrs_grid_text">NumberCyclesRemaining</td>

                                <td class="chagrs_grid_text"><?php echo $pgProfile['RecurringPaymentsSummary']['NumberCyclesRemaining']+1;?></td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td class="chagrs_grid_text">Next Billing Date</td>

                                <td class="chagrs_grid_text"> <?php echo date($objCore->gConf['DATE_FORMAT'],$nextPaymentDate); ?></td>
                                <td ></td>
                              </tr>
                              <tr>
                                <td ></td>
                                <td class="chagrs_grid_text">Final Payment Due Date</td>
                                <td class="chagrs_grid_text"><?php echo date($objCore->gConf['DATE_FORMAT'],$finalPaymentDate); ?></td>
                                <td ></td>
                              </tr>
                 </table>

                <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">

                              <tr>
                                <td width="6" height="36" class="charges_grid_left" id="grid_left_end"></td>
                                <td width="155" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x">General Details</td>
                                 <td width="" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="2" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="6" height="36" class="charges_grid_right" id="grid_right_end"></td>
                              </tr>
                              <tr>
                                <td></td>
                                <td class="chagrs_grid_text">Credit Card Type </td>

                                <td class="chagrs_grid_text"><?php echo $pgProfile['CreditCard']['CreditCardType'];?></td>
                                <td></td>
                              </tr>
                              <tr>
                                <td></td>
                                <td class="chagrs_grid_text">Credit Card Number</td>

                                <td class="chagrs_grid_text">xxxx-xxxx-xxxx-<?php echo $pgProfile['CreditCard']['CreditCardNumber'];?></td>
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

                                <td class="chagrs_grid_text"><?php echo $pgProfile['CreditCard']['CardOwner']['PayerName']['FirstName']." ".$pgProfile['CreditCard']['CardOwner']['PayerName']['LastName'];?> [ <?php echo $pgProfile['CreditCard']['CardOwner']['Payer'];?> ]</td>
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
                                <tr>
                                <td></td>
                                <td class="chagrs_grid_text" style="padding-top:20px;"><a href="?<?php echo $backLinkValues;?>"><input name="back" value="Back" type="button"></a></td>

                                <td class="chagrs_grid_text" ></td>
                                <td></td>
                              </tr>

                              </table>
                           </fieldset>


	</td>

	<td> </td>

    <td>


	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" style="right:auto">
	  <fieldset id="page-middle-middle-content">
	  <legend>Related Transactions</legend>


        <table  cellspacing="1" class="adminlist" width="100%">
          <thead>
            <tr>
              <th width="" height=""> # </th>
              <th width="" nowrap="nowrap"><a  href="#">Transaction Id</a></th>
              <th width="" nowrap="nowrap" > <a  href="#">Amount (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?> )</a> </th>
              <th width="" nowrap="nowrap" class="title"><a  href="#">Status</a></th>
              <th width="" nowrap="nowrap" class="title"><a  href="#">Sheduled Date </a></th>
            </tr>
          </thead>
          <tbody>
            <!-- Retriew data from database and display the data corresponding fields -->
            <?php
                for($n=0;$n<count($paymentDetails);$n++)
                {
                    $rowNo=$n+1;

        //            // prepare edit/view icon alternative text
        //                if($paymentDetails[0][$n][8])
        //                    $altText="View";
        //                else
        //                    $altText="View / Edit";
            ?>
            <tr class="row0">
              <td align="left"><?php echo $rowNo; ?> </td>
              <td align="left"><?php echo $paymentDetails[$n][6];?></td>
              <td align="left"><?php echo number_format($paymentDetails[$n][4],2);?></td>
              <td align="left"><?php echo $paymentDetails[$n][5];?></td>
              <td align="left"><?php echo date($objCore->gConf['DATE_FORMAT'],$paymentDetails[$n][7]);?></td>
        </tr>
            <?php }?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="12"><del class="container">
                </del> </td>
            </tr>
          </tfoot>
        </table>

	  </fieldset>
	</form>

	</td>
  </tr>
</table>






<!--------------END Function form----------->

<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>

<?php

 } // End if - check for the profile data from the gateway

 ?>
