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
	require_once($objCore->_SYS['PATH']['CLASS_ORDER']);
	$arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];
  	$objOrder = new Order($objCore->gConf);
  	$orderDetails = $objOrder->getOrderDetails('', $_REQUEST['pg'], $_REQUEST['id'], $_REQUEST['time'], $_REQUEST['sub_type'], $_REQUEST['search'], $_REQUEST['search_by'], $_REQUEST['id'], $_REQUEST['sort_by']);

    // preapare back link for back button
    if(!$_REQUEST['blvals'])
        $backLinkValues='&f='.$_REQUEST['olt'].'&pg='.$_REQUEST['pg'];
    else
        $backLinkValues=$_REQUEST['blvals'];

        // prepare date drop down
           $today=time();

$months = array (1 => 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun','Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
$days = range (1, 31);


  	if($msg)
	{
		echo $objCore->msgBox("ORDER",$msg,'98%');
	}
?>

<div id="toolbar-box">
<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
</div>
			<div class="m">

<!-------------- Function form----------->
<table width="250" border="0">
  <tr valign="top">
    <td>

	  <fieldset id="page-middle-middle-content">
	  <legend>View <?php if($orderDetails[0][20]!="Y"){ ?>Incompleted<?php }?> Order - <?php echo $orderDetails[0][0]; ?></legend>
 <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="6" height="36" class="charges_grid_left" id="grid_left_end"></td>
                                <td height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" style="background-repeat:repeat-x" class="chagrs_grid_heading">Description / Details</td>
                                 <td width="75" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="1" height="36" class="grid_break"></td>
                                <td width="75" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x;text-align:right;padding-right:5px;">Total</td>
                                <td width="6" height="36" class="charges_grid_right" id="grid_right_end"></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td class="chagrs_grid_text">
                                    <?php echo $orderDetails[0][26];?>
                                            </td>

                                <td width="75" class="chagrs_grid_text"></td>
                                <td></td>
                                <td width="75" class="chagrs_grid_text" style="text-align:right;padding-right:5px;"><?php echo $objCore->_SYS['CONF']['CURRENCY'];?> <?php echo $orderDetails[0][17]; ?></td>
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
                                <td class="chagrs_grid_text"></td>

                                <td width="75" class="chagrs_grid_text">Sub Total</td>
                                <td></td>
                                <td width="75" class="chagrs_grid_text" style="text-align:right;padding-right:5px;"><?php echo $objCore->_SYS['CONF']['CURRENCY'];?> <?php echo $orderDetails[0][17]; ?></td>
                                <td width="6"></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td class="chagrs_grid_text"></td>
                                <td width="75" class="chagrs_grid_text">VAT [+]</td>
                                <td></td>
                                <td width="75" class="chagrs_grid_text" style="text-align:right;padding-right:5px;"><?php echo $objCore->_SYS['CONF']['CURRENCY'];?> <?php echo $orderDetails[0][19]; ?></td>
                                <td width="6"></td>
                              </tr>
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
                                <td class="chagrs_grid_text"></td>
                                <td class="chagrs_grid_text"><strong>Total</strong></td>
                                <td></td>
                                <td class="chagrs_grid_text" style="text-align:right;padding-right:5px;"> <strong><?php echo $objCore->_SYS['CONF']['CURRENCY'];?> <?php echo $orderDetails[0][24]; ?></strong></td>
                                <td></td>
                              </tr>
                                   <tr>
                                <td height="20"></td>
                                <td height="20"></td>
                                <td height="20"></td>
                                <td height="20"></td>
                                <td height="20"> </td>
                                <td height="20"></td>
                              </tr>
                            </table>
                <?php
                   /*
                    * payment details will display only for paid orders
                    */
                    if($orderDetails[0][20]=="Y")
                    {

                ?>
                <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">

                              <tr>
                                <td width="6" height="36" class="charges_grid_left" id="grid_left_end"></td>
                                <td width="155" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x">Payment Details</td>
                                 <td width="232" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="247" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="6" height="36" class="charges_grid_right" id="grid_right_end"></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Method</td>

<td width="232" class="chagrs_grid_text"><strong><?php echo $objCore->_SYS['CONF']['PAYMENT'][$orderDetails[0][23][0]]['NAME']; ?></strong> - <?php echo $objCore->_SYS['CONF']['PAY_METHODS'][$orderDetails[0][23][1]]?></td>
                                <td width="6"></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Time</td>

                                <td width="232" class="chagrs_grid_text"><?php echo date($objCore->gConf['DATE_FORMAT']." ".$objCore->gConf['TIME_FORMAT'],$orderDetails[0][22]); ?></td>
                                <td width="6"></td>
                              </tr>
                 </table>
                <?php }?>
                 <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                              <td width="6" height="36"  ></td>
                                <td width="155" height="36" class="chagrs_grid_heading"></td>
                                <td width="232" height="36" class="chagrs_grid_heading" ><strong>Billing Details </strong></td>
                              </tr>
                              <tr>
                                <td width="6" height="36" class="charges_grid_left" id="grid_left_end"></td>
                                <td width="155" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x">Personal Details</td>
                                 <td width="232" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="247" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="6" height="36" class="charges_grid_right" id="grid_right_end"></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">First Name</td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][1]; ?></td>
                                <td width="6"></td>
                              </tr>

                                <tr  class="ash_strip">
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Last Name</td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][2]; ?></td>
                                <td width="6"></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Email Address</td>
                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][14]; ?></td>
                                <td width="6"></td>
                              </tr>
                              <tr>
                                <td></td>
                                <td width="155" class="chagrs_grid_text"></td>
                                <td width="232" class="chagrs_grid_text"></td>
                                <td width="247" class="chagrs_grid_text"></td>
                                <td></td>
                              </tr>
                                            <tr>
                <td height="20" align="left" valign="top" ></td>
              </tr>
                            </table>

                <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">

                              <tr>
                                <td width="6" height="36" class="charges_grid_left" id="grid_left_end"></td>
                                <td width="155" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x">Company Details</td>
                                 <td width="232" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="247" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="6" height="36" class="charges_grid_right" id="grid_right_end"></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Company Name</td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][4]; ?></td>
                                <td width="6"></td>
                              </tr>


                                            <tr>
                <td height="20" align="left" valign="top" ></td>
              </tr>
                            </table>

                <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">

                              <tr>
                                <td width="6" height="36" class="charges_grid_left" id="grid_left_end"></td>
                                <td width="155" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"><strong>Address </strong></td>
                                 <td width="232" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="247" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="6" height="36" class="charges_grid_right" id="grid_right_end"></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Address </td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][5]; ?></td>
                                <td width="6"></td>
                              </tr>
                              <tr class="ash_strip">
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Street</td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][6]; ?></td>
                                <td width="6"></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">City</td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][7]; ?></td>
                                <td width="6"></td>
                              </tr>
                              <tr class="ash_strip">
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">State / Province</td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][8]; ?></td>
                                <td width="6"></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Country</td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][10]; ?></td>
                                <td width="6"></td>
                              </tr>


                                            <tr>
                <td height="20" align="left" valign="top" ></td>
              </tr>
                            </table>

                <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">

                              <tr>
                                <td width="6" height="36" class="charges_grid_left" id="grid_left_end"></td>
                                <td width="155" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x">Contact Details</td>
                                 <td width="232" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="247" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="6" height="36" class="charges_grid_right" id="grid_right_end" ></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Telephone</td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][11]; ?></td>
                                <td width="6"></td>
                              </tr>
                               <tr class="ash_strip">
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Fax</td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][12]; ?></td>
                                <td width="6"></td>
                              </tr>
                               <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Mobile</td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][13]; ?></td>
                                <td width="6"></td>
                              </tr>
                               <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text" style="padding-top:20px;"><a href="?<?php echo $backLinkValues;?>"><input name="back" value="Back" type="button"></a></td>

                                <td width="232" class="chagrs_grid_text" ></td>
                                <td width="6"></td>
                              </tr>


                                            <tr>
                <td height="20" align="left" valign="top" > 
</td>
              </tr>
                            </table>

                            </fieldset>


	</td>

	<td> </td>

    <td>
<?php
   /*
    * To update an order forcefully, it should be non paid order
    */
    if($orderDetails[0][20]!="Y")
    {

?>

	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" style="right:auto">
	  <fieldset id="page-middle-middle-content">
	  <legend>Force Update</legend>
<table width="470" class="admintable">
	    <tbody><tr>
	      <td align="right" class="key">Payment Method</td>
	      <td>
                    <select value="" type="text" id="payMethod" class="text_area" name="PayMethod">
                          <option value="CS-">Card Save - Standard</option>
                          <option value="PP-DRT">Pay Pal - Direct Payment</option>
                          <option value="PP-EXP">Pay Pal - Express Checkout</option>
                   
                    </select>
          </td>
        </tr>
	    <tr>
          <td align="right" class="key">Date</td>
	      <td>
                  <select value="" type="text" id="Date" class="text_area" name="Date">
                      <?php
                         for($i=0;$i<22;$i++)
                         {
                             $stamp= mktime(0, 0, 0, date("m")  , date("d")-$i, date("Y"));
                             echo "<option value=\"".$stamp."\">".date("d, M Y",$stamp) ."</option>";
                         }
                      ?>
                    </select>
              </td>
        </tr>
	    <tr>
          <td align="right" class="key">Remarks <br>(Max length=255)</td>
	      <td><textarea class="text_area" name="note" style="width:210px;height:100px;" onkeyup="return ismaxlength(this)" maxlength="255"></textarea></td>
        </tr>


		<tr>
	      <td width="131" align="right" class="key"> </td>
	      <td width="327"><label>
	        <input type="submit" value="Edit" name="Submit"/>
	        <input type="hidden" value="edit" name="action"/>
	        <input type="hidden" value="<?php echo $backLinkValues;?>" name="blvals"/>
	        <input type="hidden" value="<?php echo $orderDetails[0][0]; ?>" name="invoiceNo"/>
	      </label></td>
	    </tr>
	  </tbody></table>
	  </fieldset>
	</form>
    <?php
       }  // End if - display force update section
       else
       {  // start refund section

          if($orderDetails[0][29]) $refunded=true;
    ?>

	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" style="right:auto">
	  <fieldset id="page-middle-middle-content">
	  <legend>Refund<?php if($refunded) echo "ed record found ";?></legend>
<table width="470" class="admintable">
	    <tbody>
	    <tr>
          <td align="right" class="key">Refund<?php if($refunded) echo "ed ";?> Amount ( <?php echo $objCore->_SYS['CONF']['CURRENCY'];?> )</td>
	      <td>
            <?php
              if($refunded){
                     echo $orderDetails[0][29];
              }
              else
              {
            ?>

            <input type="text" value="<?php echo $_REQUEST['refundAmount']; ?>" name="refundAmount" id="refundAmount" maxlength="12"/>
            <?php
              }
            ?>
          </td>
        </tr>
	    <tr>
          <td align="right" class="key">Remarks <?php if(!$refunded){?><br>(Max length=255)<?}?></td>
	      <td>
            <?php
              if($refunded){
                     echo "<pre>".$orderDetails[0][31]."</pre>";
              }
              else
              {
            ?>          
                    <textarea class="text_area" name="note" style="width:210px;height:100px;" onkeyup="return ismaxlength(this)" maxlength="255"></textarea>
           <?php
              }
            ?>
          </td>
        </tr>

       <?php

        if(!$refunded)
        {
       ?>
		<tr>
	      <td width="131" align="right" class="key"> </td>
	      <td width="327"><label>
	        <input type="submit" value="Edit" name="Submit"/>
	        <input type="hidden" value="refund" name="action"/>
             <input type="hidden" value="<?php echo $backLinkValues;?>" name="blvals"/>
	        <input type="hidden" value="<?php echo $orderDetails[0][0]; ?>" name="invoiceNo"/>
	      </label></td>
	    </tr>
       <?php
         }
         else
         { // show following records if there is a refund
       ?>
		<tr>
	      <td width="131" align="right" class="key"> Time</td>
	      <td width="327"><label>
            <?php echo date($objCore->gConf['DATE_FORMAT']." ".$objCore->gConf['TIME_FORMAT'],$orderDetails[0][32]); ?>
	      </label></td>
	    </tr>
        <tr>
	      <td width="131" align="right" class="key"> Refunded By</td>
	      <td width="327"><label>
          <?php 
          require_once($objCore->_SYS['PATH']['CLASS_USER']);
          if(!$objUser) $objUser=new User();

          $user=$objUser->getUser($orderDetails[0][30]); 

          echo $user['Name'];?>
	      </label></td>
	    </tr>
       <?php
         }
         ?>
	  </tbody></table>
	  </fieldset>
	</form>

    <?php
       }  // End if - display refund section
    ?>
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

<script type="text/javascript">

/***********************************************
* Textarea Maxlength script- © Dynamic Drive (www.dynamicdrive.com)
* This notice must stay intact for legal use.
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/

function ismaxlength(obj){
var mlength=obj.getAttribute? parseInt(obj.getAttribute("maxlength")) : ""
if (obj.getAttribute && obj.value.length>mlength)
obj.value=obj.value.substring(0,mlength)
}

</script>


