<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>          		'
  '    FILE            :  customer_list.tpl.php                     				'
  '    PURPOSE         :                   												'
  '    PRE CONDITION   :                                             			'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
?>
<?php
	
	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
	$objComponent = new Component();	 
	require_once($objCore->_SYS['PATH']['CLASS_PAYMENT']);
  	$objPayment = new Payment($objCore->gConf);

    $paymentDetails=$objPayment->diyRecurringProfileListFutureShedules();

  	if (count($paymentDetails)==0) $msg = array('ERR', 'NO_MATCHES');
  	
  	if($msg)
	{
		echo $objCore->msgBox("ORDER",$msg,'96%');
	}	

?>

  <?php if ($totalCount>0) {?>
  <fieldset style="border:1px dashed #CCCCCC" id="page-middle-middle-content" class="summeryBox">
  <table>
  <tr>
                            <td valign="top" align="center" colspan="6">
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
								  <tbody><tr>
									<td>
										<table width="100%" cellspacing="0" cellpadding="0" border="0">
											<tbody><tr>											</tr> 
										    <tr>
											<td width="150"><strong>Total Orders </strong></td>
											<td>:<?php echo $totalCount; ?></td>
											<td>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</td>
											<td width="150"><b>Total Purchases </b></td>
										    <td>:£ <?php echo $paymentDetails[1]; ?>	</td>
									      </tr>
									  </tbody></table></td>
								  </tr>
								</tbody></table></td>
                          </tr></table></fieldset><?php }?>

                      
  <div align="right"><?php echo $objOrder->pgBar; ?></div>
<fieldset  id="page-middle-middle-content">
 <legend>Scheduled Payments</legend>

<table  cellspacing="1" class="adminlist" width="100%">
  <thead>
    <tr>
      <th width="" height=""> # </th>
      <th width="" nowrap="nowrap"><a  href="#">Profile Id</a></th>
      <th width="" nowrap="nowrap" > <a  href="#">Status</a> </th>
      <th width="" nowrap="nowrap" class="title"><a  href="#">Customer Name</a></th>
      <th width="" nowrap="nowrap" class="title"><a  href="#">Customer email</a></th>
      <th width="" nowrap="nowrap" class="title"><a  href="#">Initial Order</a></th>
      <th width="" class="title"> <a href="#">Next Payment</a> </th>
      <th width="" nowrap="nowrap" style="text-align:right;"> <a  href="#">Amount (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?> )</a> </th>


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
      <td align="left"><a href="index.php?f=rcprf&prid=<?php echo $paymentDetails[$n][4];?>&olt=<?php echo $_REQUEST['f'];?>&pg=<?php echo $_REQUEST['pg'];?>" style="text-decoration:none"><?php echo $paymentDetails[$n][4];?></a></td>
      <td align="left"><?php echo $paymentDetails[$n][5];?></td>      
       <td align="left"><?php echo $paymentDetails[$n][14];?></td>
      <td align="left"><?php echo $paymentDetails[$n][15];?></td>
      <td align="left"><a href="index.php?f=edit&id=<?php echo $paymentDetails[$n][12];?>&olt=<?php echo $_REQUEST['f'];?>&pg=<?php echo $_REQUEST['pg'];?>" style="text-decoration:none"><?php echo $paymentDetails[$n][12];?></a></td>
     
      <td align="left"><?php echo date($objCore->gConf['DATE_FORMAT'],$paymentDetails[$n][9]);?></td>
      <td align="right"><?php echo (number_format($paymentDetails[$n][6]+$paymentDetails[$n][7],2));?></td>

     
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
