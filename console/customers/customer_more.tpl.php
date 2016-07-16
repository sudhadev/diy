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
 	$customerData=$objCustomer->getCustomerData($_REQUEST['id']);
	$subcriptionData = $objCustomer->getStatus($_REQUEST['id']);
 	$customerInfo = $customerData[0];
 	require_once($objCore->_SYS['PATH']['CLASS_COUNTRY']); 
	$objCountry=new Country();    
	$arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];     	

?>
<?php if ($subcriptionData[0][0] == 'W') {?>
<fieldset style="border:1px dashed #CCCCCC" id="page-middle-middle-content" class="summeryBox">
  <form id="frmApprove" action="">
  <table>
  <tr>
                            <td valign="top" align="center" colspan="6">
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
								  <tbody><tr>
									<td>
										<table width="100%" cellspacing="0" cellpadding="0" border="0">
											<tbody><tr>											</tr> 
										    <tr>
											<td width="100%">Customer is in Pending for Approval</td>
											<td width="150"><?php
									echo $objComponent->drop('status', $_REQUEST['status'], array(
				"A"=>"Approve",
				"R"=>"Reject",
			), '', '');
							?></td>										
											<td><input type="submit" value="Submit" name="submit"/></td>
									      </tr>
									  </tbody></table></td>
								  </tr>
								</tbody></table></td>
                          </tr></table>
                          <input type="hidden" id="action" name="action" value="approve">
                          <input type="hidden" id="id" name="id" value="<?php echo $_REQUEST['id']; ?>">
                          </form></fieldset><?php }?>
<div id="toolbar-box">
<div class="t"></div>
<div class="m">
  <fieldset id="page-middle-middle-content">
  <legend>Customer Information</legend>
  <table class="admintable" width="470">
    <tr>
      <td class="key" align="right">First Name</td>
      <td><?php echo $customerInfo[0]; ?></td>
    </tr>
    <tr>
      <td class="key" align="right">Last Name</td>
      <td><?php echo $customerInfo[1]; ?></td>
    </tr>
    <tr>
      <td class="key" align="right">E-Mail</td>
      <td><?php echo $customerInfo[11]; ?></td>
    </tr>
    <tr>
      <td class="key" align="right">Company</td>
      <td><?php echo $customerInfo[2]; ?></td>
    </tr>
    <tr>
      <td class="key" align="right">Address</td>
      <td><?php echo $customerInfo[3]; ?></td>
    </tr>
    <tr>
      <td class="key" align="right">Street</td>
      <td><?php echo $customerInfo[4]; ?></td>
    </tr>
    <tr>
      <td class="key" align="right">City</td>
      <td><?php echo $customerInfo[5]; ?></td>
    </tr>
    <tr>
      <td class="key" align="right">Postal</td>
      <td><?php echo $customerInfo[6]; ?></td>
    </tr>
    <tr>
      <td class="key" align="right">Country</td>
      <td><?php echo $objCountry->arrCountry[$customerInfo[7]]; ?></td>
    </tr>
    <tr>
      <td class="key" align="right">Telephone</td>
      <td><?php echo $customerInfo[8]; ?></td>
    </tr>
    <tr>
      <td class="key" align="right">Fax</td>
      <td><?php echo $customerInfo[9]; ?></td>
    </tr>
    <tr>
      <td class="key" align="right">Mobile</td>
      <td><?php echo $customerInfo[10]; ?></td>
    </tr>
    <tr>	
      <td class="key" align="right">Subscription(s)</td>
      <td><?php for ($i=0; $i<count($subcriptionData); $i++) { if ($subcriptionData[$i][2] == 'C') echo $arrSubscriptions[$subcriptionData[$i][2]]['OPTION']."<br/>"; else echo $arrSubscriptions[$subcriptionData[$i][2]]['OPTION']." - ".$arrSubscriptions[$subcriptionData[$i][2]][$subcriptionData[$i][3]]."<br/>"; }?></td>
    </tr>
    </tr>
    <form action="" method="post" enctype="multipart/form-data">
    
    <tbody>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <label>
          <input type="submit" name="back" value="Back"/>
          <input type="hidden" name="f"  value=""/>
          </label></td>
      </tr>
    </tbody>
  </table>
  </fieldset>
  <div class="clr"></div>
</div>
<div class="b">
  <div class="b">
    <div class="b"></div>
  </div>
</div>
