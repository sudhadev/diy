<?php
	require_once("../../classes/core/core.class.php");$objCore=new Core;
	$objCore->auth(0,true);
	require_once($objCore->_SYS['PATH']['CLASS_ORDER']);
	$objOrder = new Order($objCore->gConf);
	$orderDetails = $objOrder->getOrderDetails($objCore->sessCusId, $_REQUEST['pg'], $_REQUEST['invoice_no']);
	$arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];
?>
<html>
<title>DIYPRICECHECK.COM - INVOICE</title>
<head>
<?php 	require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']); ?> 
</head>
<body onLoad="window.print();">
<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"></div>
      <div id="">
              <div id="banner">DIYPRICECHECK.COM - INVOICE</div>
		  <div class="list" style="margin-top:10px;">
          <div align="left">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr >
                              <td>
                <table width="652" border="0" align="left" cellpadding="0" cellspacing="0"  >
      <tr>
       
        <td width="80" class="chagrs_grid_heading" colspan="2" style="padding-left:0px;" >[ Invoice No:</td>
        <td width="1" ></td>
        <td width="80" class="chagrs_grid_heading" ><?php echo  $orderDetails[0][0]; ?></td>
        <td width="15"></td>
        <td width="30"  class="chagrs_grid_heading" >Date:</td>
        <td width="1"></td>
        <td width="80" class="chagrs_grid_heading" ><?php echo date("m-d-Y", $orderDetails[0][21]);?></td>
        <td width="15"></td>
        <td width="30"  class="chagrs_grid_heading" >Time:</td>
        <td width="1"></td>
        <td width="80"  class="chagrs_grid_heading" ><?php echo date("H:m:s", $orderDetails[0][21]);?> ]</td>
        <td width="180"></td>
        <td  ></td>
      </tr>
    </table>                </td>
              </tr>
                
              <tr>
                <td height="30">                </td>
              </tr>
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td align="left" valign="top" >
                <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="6" class="" id=""></td>
                                <td  class="chagrs_grid_heading">Description / Details</td>
                                 <td width="75" class="chagrs_grid_heading" ></td>
                                <td width="1" class=""></td>
                                <td width="75" class="chagrs_grid_heading" >Total</td>
                                <td width="6" class="" id=""></td>
                              </tr>
                                <tr><td colspan="5"><hr/></td></tr>
                              <tr>
                                <td width="6"></td>
                                <td class="chagrs_grid_text">
                                 <?php echo $orderDetails[0][26];?>
                                </td>

                                <td width="75" class="chagrs_grid_text"></td>
                                <td></td>
                                <td width="75" class="chagrs_grid_text" style="text-align:right;padding-right:5px;"><?php echo $objCore->_SYS['CONF']['CURRENCY'];?>  <?php echo $orderDetails[0][17]; ?></td>
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
                                <td width="6" height="36" class="charges_grid_left" id=""></td>
                                <td width="155" height="36"  class="chagrs_grid_heading" >Payment Details</td>
                                 <td width="232" height="36"  class="chagrs_grid_heading" ></td>
                                <td width="247" height="36"  class="chagrs_grid_heading" ></td>
                                <td width="6" height="36" class="charges_grid_right" id=""></td>
                              </tr>
                                <tr><td colspan="5"><hr/></td></tr>
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
              <?php }?>
              <tr>
                <td height="20" align="left" valign="top" ></td>
              </tr>
              <tr>
                <td align="left" valign="top" >
                <table width="652" border="0" align="center" cellpadding="0" cellspacing="0">

                              <tr>
                                <td width="6"  class="" id=""></td>
                                <td width="155" class="chagrs_grid_heading" >Personal Details</td>
                                 <td width="232"   class="chagrs_grid_heading" ></td>
                                <td width="247"  class="chagrs_grid_heading" ></td>
                                <td width="6"  class="" id=""></td>
                              </tr>
                              <tr><td colspan="5"><hr/></td></tr>
                              <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">First Name</td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][1]; ?></td>
                                <td width="6"></td>
                              </tr>  

                                <tr  class="">
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
                                <td width="6" class="charges_grid_left" id=""></td>
                                <td width="155" class="chagrs_grid_heading" >Company Details</td>
                                 <td width="232" class="chagrs_grid_heading" ></td>
                                <td width="247" class="chagrs_grid_heading" ></td>
                                <td width="6" class="charges_grid_right" id=""></td>
                              </tr>
                              <tr><td colspan="5"><hr/></td></tr>
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
                                <td width="6" class="charges_grid_left" id=""></td>
                                <td width="155" class="chagrs_grid_heading" ><strong>Address </strong></td>
                                 <td width="232" class="chagrs_grid_heading" ></td>
                                <td width="247" class="chagrs_grid_heading" ></td>
                                <td width="6" class="charges_grid_right" id=""></td>
                              </tr><tr><td colspan="5"><hr/></td></tr>
                              <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Address </td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][5]; ?></td>
                                <td width="6"></td>
                              </tr>
                              <tr class="">
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
                              <tr class="">
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
                                <td width="6" class="charges_grid_left" id=""></td>
                                <td width="155" class="chagrs_grid_heading" >Contact Details</td>
                                 <td width="232" class="chagrs_grid_heading" ></td>
                                <td width="247" class="chagrs_grid_heading" ></td>
                                <td width="6" class="charges_grid_right" id="" ></td>
                              </tr><tr><td colspan="5"><hr/></td></tr>
                              <tr>
                                <td width="6"></td>
                                <td width="155" class="chagrs_grid_text">Telephone</td>

                                <td width="232" class="chagrs_grid_text"><?php echo $orderDetails[0][11]; ?></td>
                                <td width="6"></td>
                              </tr>
                               <tr class="">
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
                </table>

          </div>
        </div>
      </div>
      <div id="main_form_bg_bottombar"></div>
    </div>
  </div>
</div>
</body>
</html>