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

  require_once($objCore->_SYS['PATH']['CLASS_COUNTRY']);
  if(!is_object($objCountry)) $objCountry=new Country();

  require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
  if(!is_object($objCustomer)) $objCustomer= new Customer;
  $customerData=$objCustomer->getCustomerData($objCore->sessCusId);
  $customerInfo = $customerData[0];


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
                         $totalCycles=$pgProfile['CurrentRecurringPaymentsPeriod']['TotalBillingCycles']+1;
                         
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
<table width="" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td></td>
        <td class="chagrs_grid_text">Credit Card Number</td>

        <td class="chagrs_grid_text"><input type="text" autocomplete="off"  id="CardNumber" maxlength="20" name="CardNumber" tabindex="0" class="myprof_editdetails_txtfield"/>
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

        <td class="chagrs_grid_text"><input type="button" value="Submit" onclick="doEditCC();"/> </td>
        <td ></td>
      </tr>
</table>