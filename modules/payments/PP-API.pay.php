<?php
/* ---------------------------------------------------------------------------
 * PLIGGIN - PAY PAL API
 *
 *
 * Written By Saliya Wijesinghe - Fusis IT
 * [saliya@ymail.com / 0773-505072]
 -----------------------------------------------------------------------------*/
require_once($objCore->_SYS['PATH']['CLASS_PAYMENT']);
if(!is_object($objPayment))$objPayment = new Payment($objCore->gConf);
/*COUTION!  **************************
 *
 *  Its necesory to have values for following variable to use this code
 *  without issue.
 *
 * Sequence of order
 * ip,clientId,email,invoiceId,amount
 */
if(!isset($postString)) $postString="ip=".$_SERVER['REMOTE_ADDR']."&cid=".$objCore->sessCusId."&email=".$orderDetails[0][14]."&invoice=".$orderDetails[0][0]."&amount=".$orderDetails[0][24];
if(!isset($hashString)) $hashString=md5($postString);
?>

<?php
/*==============================================================================
 * codes for both direct and express checkout are included
 * in this file
 * ------------------>
 */
if($use=='Direct')
{
?>
<script language="javascript">
    <!--
    //Assume that the request object creation code is already included
    //   written by Saliya Wijesinghe
    function doDirect()
    {
        startProcessing();
        var CardType            =document.getElementById('CardType').value;
        var CardNumber          =document.getElementById('CardNumber').value;
        var ExpiryDateMonth     =document.getElementById('ExpiryDateMonth').value;
        var ExpiryDateYear      =document.getElementById('ExpiryDateYear').value;
        var IssueNumber         =''//document.getElementById('IssueNumber').value;
        var CV2                 =document.getElementById('CV2').value;
        var Cycles              =document.getElementById('Cycles').value;

        var fName               =document.getElementById('fName').value;
        var lName               =document.getElementById('lName').value;

        var address             =document.getElementById('address').value;
        var street              =document.getElementById('street').value;
        var city                =document.getElementById('city').value;
        var postcode            =document.getElementById('postcode').value;
        var country             =document.getElementById('country').value;

        var string ="gate=paypal&act=direct&ajax=y&hash=<?php echo $hashString;?>&<?php echo $postString?>&recPay=<?php echo $recurringPaymentAmount;?>"  +  "&CardType="+ CardType  + "&CardNumber=" + CardNumber + "&ExpiryDateMonth=" + ExpiryDateMonth + "&ExpiryDateYear=" + ExpiryDateYear + "&IssueNumber=" + IssueNumber + "&CV2=" + CV2 + "&Period=<?php echo $orderPeriod;?>" + "&Frequency=<?php echo $orderFrequency;?>" + "&Cycles=" + Cycles + "&pfId=<?php echo $payProfileId;?>" + "&Title=<?php echo $orderTitle;?>"  ;
        string = string + "&fName=" + fName + "&lName=" + lName + "&address=" + address + "&street=" + street + "&city=" + city + "&postcode=" + postcode + "&country=" + country ;

        reqPayment = createAjaxRequest();
        reqPayment.open("POST", "<?php echo $objCore->_SYS['CONF']['URL_PAYMENT_MODULE']."/process.php";?>", true);
        reqPayment.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded; charset=UTF-8');
        reqPayment.onreadystatechange = doneDirect;
        reqPayment.send(string);
    }

    function doneDirect()
    {
        if (reqPayment.readyState == 4)
        {

            document.getElementById('msgContainer').innerHTML=reqPayment.responseText;
            endProcessing();
        }


    }


    -->
</script>
<table width="" border="0" align="left" cellpadding="0" cellspacing="0">
      <tr>
        <td></td>
        <td class="chagrs_grid_text">Number of Recurrent Payments:</td>

        <td class="chagrs_grid_text">
               <select name="Cycles" id="Cycles" class="mng_cladds_catdropdown">
                    <option value="">Until I Cancel</option>
                    <?php
                    for($i=1;$i<61;$i++)
                    {
                        echo '<option value="'.$i.'">'.$i.'</option>'."\n";
                    }


                    ?>

                </select>
        </td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td class="chagrs_grid_text">Credit Card Type </td>
        <td class="chagrs_grid_text">
            <select class="myprof_editdetails_txtfield" style="width: 100px;" id="CardType" name="CardType" tabindex="0">
                   <?php
                        foreach($objCore->_SYS['CONF']['CREDIT_CARD_TYPES'] as $key=>$value)
                        {
                                echo '<option value="'.$key.'">'.$value.'</option>'."\n";
                        }
                   ?>

            </select>
        </td>
        <td></td>
      </tr>

      <tr>
        <td></td>
        <td class="chagrs_grid_text">Credit Card Number</td>

        <td class="chagrs_grid_text"><input type="text" autocomplete="off"  id="CardNumber" maxlength="20" name="CardNumber" tabindex="0" class="myprof_editdetails_txtfield"/>
        </td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td class="chagrs_grid_text">CV2</td>

        <td class="chagrs_grid_text"><input type="text" autocomplete="off"  id="CV2" maxlength="20" name="CV2" tabindex="0" class="myprof_editdetails_txtfield"/>
        </td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td class="chagrs_grid_text">Expiry Date</td>

        <td class="chagrs_grid_text">
              <select class="myprof_editdetails_txtfield" style="width: 45px;" id="ExpiryDateMonth" name="ExpiryDateMonth" tabindex="0">
                            <option value="1">01</option>
                            <option value="2">02</option>
                            <option value="3">03</option>
                            <option value="4">04</option>
                            <option value="5">05</option>
                            <option value="6">06</option>
                            <option value="7">07</option>
                            <option value="8">08</option>
                            <option value="9">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                         /
                        <select  class="myprof_editdetails_txtfield" style="width: 55px;" id="ExpiryDateYear" name="ExpiryDateYear" tabindex="0">
                            <?php
                                // Loop for 10 years from the current year
                                   $currentYear=date("Y");
                                   for($y=$currentYear;$y<$currentYear+10;$y++)
                                   {
                                       echo "<option value=\"".($y)."\">".$y."</option><br/>";
                                   }
                            ?>
                        </select>

        </td>
        <td ></td>
      </tr>
      <tr>
        <td ></td>
        <td class="chagrs_grid_text" style="vertical-align:top;">Card Owner</td>

        <td class="chagrs_grid_text">
        First Name:
        <input name="fName" type="text" id="fName" class="myprof_editdetails_txtfield" value="<?php echo $customerInfo[0]; ?>" style="width:115px;"/><br/>
        <div style="margin-top:8px;">Last Name: <input name="lName" type="text" id="lName" class="myprof_editdetails_txtfield" value="<?php echo $customerInfo[1]; ?>" style="width:115px;"/></div>

        </td>
        <td ></td>
      </tr>
      <tr>
        <td ></td>
        <td class="chagrs_grid_text">Address</td>

        <td class="chagrs_grid_text"><input name="address" type="text" id="address" class="myprof_editdetails_txtfield" value="<?php echo $customerInfo[3]; ?>"/> </td>
        <td ></td>
      </tr>
      <tr>
        <td ></td>
        <td class="chagrs_grid_text">Street</td>

        <td class="chagrs_grid_text"><input name="street" type="text" id="street" class="myprof_editdetails_txtfield" value="<?php echo $customerInfo[4]; ?>"/> </td>
        <td ></td>
      </tr>
      <tr>
        <td ></td>
        <td class="chagrs_grid_text">City</td>

        <td class="chagrs_grid_text"><input name="city" type="text"  id="city" class="myprof_editdetails_txtfield" value="<?php echo $customerInfo[5]; ?>"/> </td>
        <td ></td>
      </tr>
      <tr>
        <td ></td>
        <td class="chagrs_grid_text">Post Code</td>

        <td class="chagrs_grid_text"><input type="text" name="postcode" id="postcode" class="myprof_editdetails_txtfield" value="<?php echo $customerInfo[6]; ?>"/> </td>
        <td ></td>
      </tr>
      <tr>
        <td ></td>
        <td class="chagrs_grid_text">Country</td>

        <td class="chagrs_grid_text">
                            <?php $objCountry->style='myprof_editdetails_txtfield'; // css style for country drop down
									$objCountry->name='country'; // name of the drop down
									$objCountry->ln='en';
									$objCountry->event='';

									echo $objCountry->drop($customerInfo[7], $objCountry->ln, $objCountry->event);
							?>
        </td>
        <td ></td>
      </tr>
      <tr>
        <td ></td>
        <td class="chagrs_grid_text"></td>

        <td class="chagrs_grid_text"> <input type="button" onclick="doDirect();" class="btn_Common" value="" name="pay_now"> </td>
        <td ></td>
      </tr>
</table>
<?php /*
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr><td>
            <div class="text_fieldBlock_left">Number of Recurrent Payments:</div>
            <div class="text_fieldBlock_right">
                <select name="Cycles" id="Cycles" class="mng_cladds_catdropdown">
                    <option value="">Until I Cancel</option>
                    <?php
                    for($i=1;$i<61;$i++)
                    {
                        echo '<option value="'.$i.'">'.$i.'</option>'."\n";
                    }


                    ?>

                </select>
            </div>
            <div class="text_fieldBlock_left">Card Type:</div>

            <div class="text_fieldBlock_right">
                <select name="CardType" id="CardType" class="myprof_editdetails_mrtxtfield"><option value="">--</option>
                    <option value="Visa" selected="selected">Visa</option>
                    <option value="Master">Master</option>
            </select>                                                            </div>
            <div class="text_fieldBlock_left">Name On Card:</div>
            <div class="text_fieldBlock_right">

                <label>
                    <input name="CardName" id="CardName" class="myprof_editdetails_txtfield" value="" type="text">
                </label>
            </div>
            <div class="text_fieldBlock_left">Card Number:</div>
            <div class="text_fieldBlock_right">
                <label>
                    <input name="CardNumber" id="CardNumber" class="myprof_editdetails_txtfield" value="" type="text">

                </label>
            </div>
            <div class="text_fieldBlock_left">Expiry Date:</div>
            <div class="text_fieldBlock_right">
                <label>
                    <select tabindex="0" name="ExpiryDateMonth" id="ExpiryDateMonth" style="width: 45px;">
                        <option value="1">01</option>
                        <option value="2">02</option>

                        <option value="3">03</option>
                        <option value="4">04</option>
                        <option value="5">05</option>
                        <option value="6">06</option>
                        <option value="7">07</option>
                        <option value="8">08</option>

                        <option value="9">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </label>
                / <select tabindex="0" name="ExpiryDateYear" id="ExpiryDateYear" style="width: 55px;">
                    <?php
                    // Loop for 10 years from the current year
                    $currentYear=date("Y");
                    for($y=$currentYear;$y<$currentYear+10;$y++)
                    {
                        echo "<option value=\"".($y)."\">".$y."</option><br/>";
                    }
                    ?>
               </select></div>

            <div class="text_fieldBlock_left">Issue Number:</div>
            <div class="text_fieldBlock_right">

                <label>
                    <input name="issue_number" id="issue_number" class="myprof_editdetails_txtfield" value="" type="text">
                </label>
            </div>
            <div class="text_fieldBlock_left">Security Code (CV2):</div><div class="text_fieldBlock_right">
                <label>
                    <input name="CV2" id="CV2" class="myprof_editdetails_txtfield" value="" type="text">
                </label>

            </div>
            <div class="text_fieldBlock_left"></div><div class="text_fieldBlock_right">
                <input type="button" onclick="doDirect();" class="btn_Common" value="PAY" name="pay_now">
            </div>
            <input type="hidden" id="orderTitle" name="orderTitle" value="<?php echo $orderTitle;?>" />
    </td></tr>

</table>
*/?>
<?php

} // end direct part
else{ // express checkout start

?>
<script language="javascript">
    <!--
    //Assume that the request object creation code is already included
    //   written by Saliya Wijesinghe
    function setExpress()
    {
        startProcessing();
        var string ="gate=paypal&act=express&ajax=y&hash=<?php echo $hashString;?>&<?php echo $postString?>";

        expPayment = createAjaxRequest();
        expPayment.open("POST", "<?php echo $objCore->_SYS['CONF']['URL_PAYMENT_MODULE']."/process.php";?>", true);
        expPayment.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded; charset=UTF-8');
        expPayment.onreadystatechange = doneExpress;
        expPayment.send(string);
    }

    function doneExpress()
    {
        if (expPayment.readyState == 4)
        {
            
            var response=expPayment.responseText;
            splRes=response.split("|spl|");
            if(splRes[0]=='OK')
            {
                document.getElementById('msgContainer').innerHTML='<div align=\"center\">Initial Authentication process was success.<br/> You will be redirected to the Paypal payment gateway shortly.</div>';
                document.location.href=splRes[1];
            }
            else{
                document.getElementById('msgContainer').innerHTML='Error occurred during the payment process. Please try again (Or please contact the Administrator).<br/><div align=\"center\"> <input type=\"button\" value=\"  Ok  \" onClick=\"closeMessage();\" /> </div>';
            }

        }
    }
    -->
</script>

<input type="button" class="btn_Common" value="" name="pay_now"  id="payPP" style="display:block;" onclick="setExpress();" />
<?php
} //end if

?>



