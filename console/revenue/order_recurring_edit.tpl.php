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
	$arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];
  	$objPayment = new Payment($objCore->gConf);
  	//$orderDetails = $objOrder->getOrderDetails('', $_REQUEST['pg'], $_REQUEST['id'], $_REQUEST['time'], $_REQUEST['sub_type'], $_REQUEST['search'], $_REQUEST['search_by'], $_REQUEST['id'], $_REQUEST['sort_by']);

       // get the transaction details
          if($_REQUEST['tid'])
          {
                $transactionData=$objPayment->diyGetTransaction($_REQUEST['tid']); 
          }


?>
<pre><?php print_r($transactionData);?></pre>
<fieldset  style="border:1px solid #CCCCCC"id="page-middle-middle-content">
<legend>Search - Uncompleted Recurring Payments</legend>
<form id="frm" action="">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" id="tblSearch">
      <tbody>
      <tr valign="top" style="background-color: rgb(255, 255, 234);">
	<td height="50" align="left" colspan="4">
You can create a recurring payment using this section. Please use this only for the orders which has not been updated as paid orders even after a supplier made his payment. Please make sure to get relevant order detail from the supplier and check it with the Pay Pay pal console for the correctness of the request and then do the change in the diy system.  	      </tr>
        <tr align="left">
          <td height="23"> </td>
          <td>Transaction Id &nbsp;&nbsp;
              <input type="text" value="<?php echo $_REQUEST['tid']; ?>" size="30" id="tid" class="" name="tid"/>&nbsp;&nbsp;
              <input type="submit" value="Search" class="btn_common" name="button2"/>
          </td>
          <td></td>
          <td width="60" align="center">

        </tr>
      </tbody>
    </table>
    <input type="hidden" id="f" name="f" value="faddrc" />
  </form>
  </fieldset>

<?php
  if($transactionData)
  {

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
	  <legend>View Order - <?php echo $orderDetails[0][0]; ?></legend>
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
                                <td class="chagrs_grid_text"><?php  $str = explode("||",$orderDetails[0][25]); echo $arrSubscriptions[$str[0]]['OPTION']." - ".$arrSubscriptions[$str[0]][$str[1]]; ?>
                                                                <i><?php if($str[0]!='C') echo "<br/>";
                                            echo $orderDetails[0][26];?></i></td>

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
                <td height="20" align="left" valign="top" ></td>
              </tr>
                            </table>

                            </fieldset>


	</td>

	<td> </td>

    <td>


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
	        <input type="hidden" value="<?php echo $orderDetails[0][0]; ?>" name="invoiceNo"/>
	      </label></td>
	    </tr>
	  </tbody></table>
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

<?php
} // End check transaction data
?>


