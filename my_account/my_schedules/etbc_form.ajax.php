<?php
/*
 * Written by Saliya Wijesinghe
 * 2010-04-26
 * echo "====>".__FILE__.__LINE__."<br/>";
 *-----------------------------------------------------------------------------------*/
  require_once("../../classes/core/core.class.php");$objCore=new Core;
  $objCore->auth(1,false);
  require_once($objCore->_SYS['PATH']['CLASS_PAYMENT']);
  require_once($objCore->_SYS['PATH']['CLASS_PAYPAL_WRAPPER']);
  if(!is_object($objPayment)) $objPayment = new Payment($objCore->gConf);
  if(!is_object($objPPWrapper))$objPPWrapper=new PPWrapper();
  
$postString="ip=".$_SERVER['REMOTE_ADDR']."&cid=".$objCore->sessCusId."&pfid=".$_REQUEST['pfid'];
$hashString=md5($postString);

   if($hashString==$_POST['hash'])
   {
        $diyProfile=$objPayment->diyRecurringProfileGet($_REQUEST['pfid']);
        // we should double check that this supplier is trying to access
        // one of his profiles
           if($diyProfile[0][3]==$objCore->sessCusId)
           {
                // Now we can get most accurate infomation from paypal
                  // get the profile from Paypal
                     $pgProfile=$objPayment->diyRecurringProfileGetFromGateway($_REQUEST['pfid']);
                     if($pgProfile['Ack']=="Success")
                     {
                         if($pgProfile['CurrentRecurringPaymentsPeriod']['TotalBillingCycles']==-1)
                         {
                             $totalCycles=$pgProfile['RecurringPaymentsSummary']['NumberCyclesCompleted']+1;
                             $tcTitle='Until I Cancel';
                         }
                         else
                         {
                             $totalCycles=$pgProfile['CurrentRecurringPaymentsPeriod']['TotalBillingCycles']+1;
                             $tcTitle=$totalCycles;
                         }
                         
                        
                     }
                     else
                     {
                         // ERROR :: Profile is invalid
                         switch($pgProfile['ErrorCode'])
                         {

                             default:
                                 echo "".$objCore->msgBox('PAYMENT', 'ERROR', $width);
                         }
                            exit;
                     }
           }
           else
           {
               // ERROR :: Not the authorised person
                  exit;
           }
   }
   else
   {
         // ERROR :: Not the authorised person (hash check is failed)
            exit;
   }



?>
<table style="text-align:left;">
    <tbody>
        <tr>
            <td colspan="2">
            Please make sure that you have selected correct figure before submit. Once you increased value, you will not be able to reduced it again.
            </td>
        </tr>
        <tr style="padding-top:10px;">
            <td>Update number of Cycles from <strong><?php echo $tcTitle;?></strong> to </td>
            <td>
                <select id="Cycles" name="Cycles">
                  <?php

                    for($i=$totalCycles+1;$i<$totalCycles+24;$i++)
                    {
                        echo '<option value="'.($i-1).'">'.$i.'</option>';
                    }
                  ?>
                </select>
                <input type="button" value="Submit" onclick="doExtendCycles();"/>
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align:right;padding-right:15px;">
            </td>
        </tr>
   </tbody>
</table>
