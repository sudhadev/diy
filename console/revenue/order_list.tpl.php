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
	require_once($objCore->_SYS['PATH']['CLASS_ORDER']);
  	$objOrder = new Order($objCore->gConf);

    /*
     * Change the list of the orders acording to the request
     */
    switch($_REQUEST['f'])
    {
        case "odrf":
            {
                $listId="refund";
            }
            break;
        default:
            {

            }
    }  
    
    if(!$paid) $paid='Y';
  	if ($_REQUEST['time'] || $_REQUEST['sub_type'] || $_REQUEST['sort_by'] || $_REQUEST['search'])
  	{
  		$orderDetails = $objOrder->getOrderDetails('', $_REQUEST['pg'], $_REQUEST['invoice_no'], $_REQUEST['time'], $_REQUEST['sub_type'], $_REQUEST['search'], $_REQUEST['search_by'], $_REQUEST['id'], $_REQUEST['sort_by'],$paid,$listId);
  	}
  	else 
  	{
  		$orderDetails = $objOrder->getOrderDetails('', $_REQUEST['pg'], $_REQUEST['invoice_no'], '', '', '', '', $_REQUEST['id'], 'time_order',$paid,$listId);
  	}
  	if ($orderDetails[0] == null ) $msg = array('ERR', 'NO_MATCHES');
  	$totalCount = $objOrder->getTotalCount();
  	if($msg)
	{
		echo $objCore->msgBox("ORDER",$msg,'96%');
	}	

?>
<fieldset  style="border:1px solid #CCCCCC"id="page-middle-middle-content">
<legend>Search</legend>
<form id="frm" action="">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" id="tblSearch">
      <tbody>
        <tr align="center">
          <td height="23"> </td>
          <td><table cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td width="10"> </td>
                          <td><input type="text" value="<?php echo $_REQUEST['search']; ?>" size="30" id="search" class="" name="search"/></td>
                          <td><input type="hidden" value="<?php echo $_REQUEST['id']; ?>" size="30" id="id" class="" name="id"/></td>
                          <td width="80" align="center">By</td>
									<td><?php
									echo $objComponent->drop('search_by', $_REQUEST['search_by'], array(
				"invoice_no"=>"Invoice",
				"email"=>"E-Mail",
			), '', '');
							?></td>
                          <td> </td>
                          <td width="60" align="center"><input type="submit" value="Search" class="btn_common" name="button2"/>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="20"> </td>
                  <td width="20" class="vertical-line"></td>
                  <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td width="60" align="center">Filter&nbsp;By</td>
                          <td><?php
									echo $objComponent->drop('time', $_REQUEST['time'], array(
				""=>"Duration",
				"date"=>"Current Date",
				"month"=>"Current Month",
				"year"=>"Current Year",
			), '', 'onchange="form.submit();"');
							?></td>
                          <td> </td>
                          <td> </td>
                          <td> </td>
                          <td><?php
									echo $objComponent->drop('sub_type', $_REQUEST['sub_type'], array(
				""=>"Subscription",
				"M"=>"Supplies",
				"S"=>"Services",
				"C"=>"Classified Ads",
			), '', 'onchange="form.submit();"');
							?></td>
                          <td> </td>
                          <td> </td>
                          <td> </td>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="20"> </td>
                  <td width="20" class="vertical-line"></td>
                  <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td width="60" align="center">Sort&nbsp;By</td>
									<td><?php
									echo $objComponent->drop('sort_by', $_REQUEST['sort_by'], array(
				"time_order"=>"Date",
				"l_name"=>"Name",
			), '' , 'onchange="form.submit();"');
							?></td>
                          <td> </td>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="10"> </td>
                </tr>
              </tbody>
            </table></td>
          <td width="15"> </td>
        </tr>
      </tbody>
    </table>
  
  </form>
  </fieldset>
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
										    <td>:£ <?php echo $orderDetails[1]; ?>	</td>
									      </tr>
									  </tbody></table></td>
								  </tr>
								</tbody></table></td>
                          </tr></table></fieldset><?php }?>
  <div align="right"><?php echo $objOrder->pgBar; ?></div>
<fieldset  id="page-middle-middle-content">
 <legend><?php if($_REQUEST['f']=='odrf') { echo "Refunded Transaction List";}else{ echo "Order List";}?></legend>
<table  cellspacing="1" class="adminlist" width="100%">
  <thead>
    <tr>
      <th width="" height=""> # </th>
      <th width="" class="title"> <a href="#">Invoice #</a> </th>
      <th width="" nowrap="nowrap"> <a  href="#">Amount (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)</a> </th>
      <th width="" nowrap="nowrap"><a  href="#">Customer Name</a></th>
      <th width="" nowrap="nowrap" class="title"><a  href="#">Email</a></th>
      <th width="" align="center"><a  href="#">Time</a></th>
      <th width="" class="title"><a href="#"></a></th>
      <th width="" class="title"><a  href="#"></a></th>
    </tr>
  </thead>
  <tbody>
    <!-- Retriew data from database and display the data corresponding fields -->
    <?php 
		for($n=0;$n<count($orderDetails[0]);$n++)
		{
			$rowNo=$n+1;

            // prepare edit/view icon alternative text
                if($orderDetails[0][$n][8])
                    $altText="View";
                else
                    $altText="View / Edit";
	?>
    <tr class="row0">
      <td align="left"><?php echo $rowNo; ?> </td>
      <td align="left"><a href="index.php?f=more&amp;invoice_no=<?php echo $orderDetails[0][$n][0];?>" style="text-decoration:none"><?php echo $orderDetails[0][$n][1];?></a></td>
      <td align="right"><span class="editlinktip hasTip"></span> <?php if($orderDetails[0][$n][8]) {echo "<font color=\"#FF0000\" >[-".$orderDetails[0][$n][8]."] </font>";} echo$orderDetails[0][$n][2];?></td>
      <td align="left"><?php echo $orderDetails[0][$n][3]." ".$orderDetails[0][$n][4];?></td>
      <td align="left"><?php echo $orderDetails[0][$n][5]; ?></td>
      <td nowrap="nowrap" align="left"><?php echo date($objCore->gConf['DATE_FORMAT']." ".$objCore->gConf['TIME_FORMAT'],$orderDetails[0][$n][1]);?></td>
	  	<td align="center">
			<a href="index.php?f=edit&amp;id=<?php echo $orderDetails[0][$n][0];?>&olt=<?php echo $_REQUEST['f'];?>&pg=<?php echo $_REQUEST['pg'];?>" alt="<?php echo $altText;?>" title="<?php echo $altText;?>">
			<img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/<?php echo $orderDetails[0][$n][8]!=""?  "eye":"edit";?>.png"/></a></td>      <td align="center">
      	<a href="javascript:del('<?php echo $orderDetails[0][$n][0];?>');" alt="Delete" title="Delete"><img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/delete.png"/></a>
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
