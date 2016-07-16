<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of DIY Project of FUSIS           '
  '    (C) Copyright 2009 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>         			'
  '    FILE            :  customer_more.tpl.php                      			'
  '    PURPOSE         :                   												'
  '    PRE CONDITION   :                                          				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

?>
<?php

	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
	$objComponent = new Component();	 
	require_once($objCore->_SYS['PATH']['CLASS_ORDER']);
	$arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];
  	$objOrder = new Order($objCore->gConf);
  	$orderDetails = $objOrder->getOrderDetails('', $_REQUEST['pg'], $_REQUEST['invoice_no'], $_REQUEST['time'], $_REQUEST['sub_type'], $_REQUEST['search'], $_REQUEST['search_by'], $_REQUEST['id'], $_REQUEST['sort_by']);
 
?>

<div id="toolbar-box">
<div class="t"></div>
<div class="m">
  <fieldset id="page-middle-middle-content">
  <legend>Invoice</legend>
      <div id="main_form_bg_middlebar">
		  <div class="list">
          <div align="center">
            <table class="invoice-border" width="652" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="list_blackbg_summery">
                <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="15" height="30" ></td>
        <td width="60"class="pbYellow">Invoice No:</td>
        <td width="1" ></td>
        <td width="80" class="pgBar" ><?php echo  $orderDetails[0][0]; ?></td>
        <td width="5"></td>
        <td width="30"  class="pbYellow" >Date:</td>
        <td width="1"></td>
        <td width="80" class="pgBar" ><?php echo date("m-d-Y", $orderDetails[0][21]);?></td>
        <td width="1"></td>
        <td width="30"  class="pbYellow" >Time:</td>
        <td width="1"></td>
        <td width="80"  class="pgBar" ><?php echo date("H:m:s", $orderDetails[0][21]);?></td>
        <td width="1"></td>
        <td width="80" ><div align="center"><a href="javascript: printInvoice('frmPrinter','invoice.php?invoice_no=<?php echo $orderDetails[0][0];?>');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/printer.png" width="24" height="24" border="0" /></a></div></td>
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
                                <td height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" style="background-repeat:repeat-x" class="chagrs_grid_heading">Description / Details</td>
                                 <td width="75" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x"></td>
                                <td width="1" height="36" class="grid_break"></td>
                                <td width="75" height="36" background="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/other_charges/middle_small_grid.jpg" class="chagrs_grid_heading" style="background-repeat:repeat-x;text-align:right;padding-right:5px;">Total</td>
                                <td width="6" height="36" class="charges_grid_right" id="grid_right_end"></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td class="chagrs_grid_text">
                                            <?php  echo $orderDetails[0][26];?></td>

                                <td width="75" class="chagrs_grid_text"></td>
                                <td></td>
                                <td width="75" class="chagrs_grid_text" style="text-align:right;padding-right:5px;">£ <?php echo $orderDetails[0][17]; ?></td>
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
                                <td width="75" class="chagrs_grid_text" style="text-align:right;padding-right:5px;">£ <?php echo $orderDetails[0][17]; ?></td>
                                <td width="6"></td>
                              </tr>
                              <tr>
                                <td width="6"></td>
                                <td class="chagrs_grid_text"></td>
                                <td width="75" class="chagrs_grid_text">VAT [+]</td>
                                <td></td>
                                <td width="75" class="chagrs_grid_text" style="text-align:right;padding-right:5px;">£ <?php echo $orderDetails[0][19]; ?></td>
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
                                <td class="chagrs_grid_text" style="text-align:right;padding-right:5px;"> <strong>£ <?php echo $orderDetails[0][24]; ?></strong></td>
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
                            </table>                </td>
              </tr>
              <tr>
                <td align="left" valign="top" ><!--<div class="page_braek page_break_fulll"></div>--></td>              </tr>
                        <tr>
                <td height="20" align="left" valign="top" ></td>
              </tr>
                <?php
                   /*
                    * payment details will display only for paid orders
                    */
                    if($orderDetails[0][20]=="Y")
                    {

                ?>
              <tr>
                <td align="left" valign="top" >

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
                 </td>
              </tr>
              <? }?>
              <tr>
                <td height="20" align="left" valign="top" ></td>
              </tr>
              <tr>
                <td align="left" valign="top" >
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
              </td>
              </tr>
              <tr>
                <td align="left" valign="top" >
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
                </td>
              </tr>
              <tr>
                <td align="left" valign="top" >
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
                </td>
              </tr>
              <tr>
                <td align="left" valign="top" >
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
                </table></td>
              </tr>
               </table>

          </div>
        </div>
      </div>
  </fieldset>
    </div>
  </div>
  <div class="clr"></div>
<div class="b">
  <div class="b">
    <div class="b"></div>
  </div>
</div>
<iframe id="frmPrinter" src="" width="0" height="0" border="0" style="width:0px;width:0px;" ></iframe>