<?php 
  /*--------------------------------------------------------------------------\
    '    This file is part of shoping Cart in module library of FUSIS           '
    '    (C) Copyright 2004 www.fusis.com                                       '
    ' ..........................................................................'
    '                                                                           '
    '    AUTHOR          :  sadaruwan hettiarachchi <sadaruwan@fusis.com>       '
    '    FILE            :  my_account/my_quotation/index.php                   '
    '    PURPOSE         :  main page                                           '
    '    PRE CONDITION   :  commented                                           '
    '    COMMENTS        :                                                      '
    '--------------------------------------------------------------------------*/
require_once("../../classes/core/core.class.php");$objCore=new Core;
$objCore->auth(1,true);
require_once($objCore->_SYS['PATH']['CLASS_QUOTATION']);$objQuotation = new Quotation('',$objCore->gConf,$objCore->sessCusId);
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	$list = $objQuotation->getQuotationItems($_GET['id']);
	$qdetails = $objQuotation->getQuotationDtails($_GET['id']);
    // to convert the page to printer friendly version
        if($_GET['print']=="y") $printerFriendly=true;
$subtotal= "";

// get customer data
// added by Saliya
    if(!is_object($objCustomer))
    {
        $objCustomer = new Customer($objCore->gConf);
    }
    $ownerData=$objCustomer->getCustomerData($objCore->sessCusId);
    $image=$objQuotation->image($qdetails[0]['himage'],"large");
   
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
</head>

<body <?php if($printerFriendly){?> onLoad="window.print();"<?php }?>>
<div id="clients_quot_main_wrapper">
	<table width="682" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
    <td class="clients_quot_main_top"/>
  </tr>
  <tr>
    <td class="clients_quot_main_mid">
       <?php if($image){?>
		<div align="center" class="top_main_logo"><img  border="0" alt="" src="<?php echo $image;//$objCore->_SYS['CONF']['URL_IMAGES_QUOTATIONS']."/large/".$qdetails[0]['himage'];?>"/> </div>
		<?php }else{ ?>
        <div class="top_info" style="float:left;padding-left:0px;">
			<dl class="common_text_ash_bold">            
	  		<?php if($ownerData[0][2]){?><span class="common_text_bold"><?php echo $ownerData[0][2];?></span><?php }?>
			<?php if($ownerData[0][3]){?><dt class="common_text"><?php echo $ownerData[0][3];?>,</dt><?php }?>
			<?php if($ownerData[0][4]){?><dt class="common_text"><?php echo $ownerData[0][4];?>,</dt><?php }?>
			<?php if($ownerData[0][5]){?><dt class="common_text"><?php echo $ownerData[0][5];?>,</dt><?php }?>
			<?php if($ownerData[0][6]){?><dt class="common_text"><?php echo $ownerData[0][6];?>,</dt><?php }?>
			<?php if($ownerData[0][7]){?><dt class="common_text"><?php echo $ownerData[0][7];?>.</dt><?php }?><br/>
			<?php if($ownerData[0][8]){?><dt class="common_text_ash_bold">Tel : <?php echo $ownerData[0][8];?></dt><?php }?>
			<?php if($ownerData[0][9]){?><dt class="common_text_ash_bold">Fax : <?php echo $ownerData[0][9];?></dt><?php }?>
			<?php if($ownerData[0][11]){?><dt class="common_text_ash_bold">E-mail : <?php echo $ownerData[0][11];?></dt><?php }?>
			</dl>
		</div>
        <?php }?>
	</td>
  </tr>
  <tr>
    <td class="clients_quot_main_mid"> </td>
  </tr>
  <?php if(!$printerFriendly){?>

  <tr>
    <td class="clients_quot_main_mid">
	<table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody>
      <tr>
        <td class="list_blackbg_summery">
                <table width="100%" cellspacing="0" cellpadding="0" border="0">
				  <tbody><tr>
					<td width="47%"><table width="100%" cellspacing="0" cellpadding="0" align="left" border="0">
					  <tbody><tr>
						<td width="12" height="30"/>
						<td width="110" height="30" class="pgBar">Quotation Number </td>
						<td width="194" height="30" class="pbYellow"><?=$qdetails[0]['quotationid'];?></td>
					  </tr>
					</tbody></table></td>
					<td width="50%" height="30">
					<table width="100%" cellspacing="0" cellpadding="0" border="0">
				  <tbody>
                  <?php if(!$printerFriendly){?>
                  <tr>
					<td> </td>
					<td width="20" class="pgBar"><div align="center"><a href="javascript: printInvoice('frmPrinter','print_quotation.php?id=<?php echo $_GET['id'];?>&print=y');"><img border="0" alt="Print" src="../../images/printer.png"/></a></div></td>
					<td width="60" class="pgBar"><div align="center"><a href="javascript: printInvoice('frmPrinter','print_quotation.php?id=<?php echo $_GET['id'];?>&print=y');">Print</a></div></td>
					<td width="5" class="pgBar"><div align="left"/></td>
				  </tr>
                  <?php }?>
				</tbody></table></td>
				  </tr>
				</tbody></table> </td>
					  </tr>
					</tbody></table>
                   
	</td>
  </tr>
  <?php }?>
  <tr>
    <td class="clients_quot_main_mid"> </td>
  </tr>
  <tr>
    <td class="clients_quot_main_mid">
	<div class="common_text" style="font-weight:bold;"><?=str_replace("\n","<br/>",$qdetails[0]['cdetails']);?></div>
	</td>
  </tr>
  <tr>
    <td class="clients_quot_main_mid"> </td>
  </tr>
  <tr>
    <td class="clients_quot_main_mid">
<!--		<div class="common_text"><?= str_replace("\n","<br/>",$qdetails[0]['othertxt']); ?> </div>-->
	</td>
  </tr>
   <?php if($printerFriendly){?>
  <tr>
    <td class="clients_quot_main_mid" style="text-align:right;"><span class="chagrs_grid_heading" style="font-size:14px;">[ Quotation Number :  &nbsp;&nbsp;&nbsp;	<?=$qdetails[0]['quotationid'];?> ]</span> </td>
  </tr>
  <tr>
  <?php }?>
    <td class="clients_quot_main_mid">
	<table width="652" cellspacing="0" cellpadding="0" border="0">
  <tbody>
  <?php if($printerFriendly){?><hr> <?php }?><tr>
    <td width="6" <?php if(!$printerFriendly){?>id="grid_left_end"<?php }?>/>
    <td class="<?php if(!$printerFriendly){?>grid_middle<?php }?> chagrs_grid_heading">#</td>
    <td width="1" <?php if(!$printerFriendly){?>class="grid_break"<?php }?>/>
    <td class="<?php if(!$printerFriendly){?>grid_middle <?php }?>chagrs_grid_heading">Description</td>
    <td width="1" <?php if(!$printerFriendly){?>class="grid_break"<?php }?>/>
    <td class="<?php if(!$printerFriendly){?>grid_middle<?php }?> chagrs_grid_heading">Unit Price /<br/>
Hourly Rate</td>
    <td width="1" <?php if(!$printerFriendly){?>class="grid_break"<?php }?>/>
    <td class="<?php if(!$printerFriendly){?>grid_middle<?php }?> chagrs_grid_heading">Qty / Hours</td>
    <td width="1" <?php if(!$printerFriendly){?>class="grid_break"<?php }?>/>
	<td class="<?php if(!$printerFriendly){?>grid_middle<?php }?> chagrs_grid_heading">Amount</td>
    <td width="6" <?php if(!$printerFriendly){?>id="grid_right_end"<?php }?>/>
  </tr><tr><td colspan="11"><?php if($printerFriendly){?><hr> <?php }?></td></tr>
 <? for ($n=0; count($list)>$n; $n++ ){
     if($list[$n][0]['totle']){
                                            	switch ($list[$n][0]['type']){
												case"M":{
													?>
                                          <tr style="vertical-align: top;">
                                            <td width="6"></td>
                                            <td class="chagrs_grid_text"><?=$n+1;//$list[$n][0]['id'];?></td>
                                           <td width="1"></td>
                                            <td class="chagrs_grid_text">

                                            <div class="requested_category_details_main common_text">
											<div class="requested_category_details_sub"><?=$list[$n][0][16];?>&nbsp;<?=$list[$n][0][10];?><br/>
											  </div>
																						
											</div>
											</td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text numeric_texts"><? if(empty($list[$n][0]['cp'])){echo number_format($list[$n][0][6], 2, '.', '');}else{echo number_format($list[$n][0]['cp'], 2, '.', '');}?></td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text numeric_texts"><?=$list[$n][0]['qty'];?></td>
                                            <td width="1"></td>
											<td class="chagrs_grid_text numeric_texts"><?=number_format($list[$n][0]['totle'], 2, '.', '');?></td>
                                     
                                          </tr>
                                          <? } break; case"S":{?>
                                            		 <tr style="vertical-align: top;">
                                            <td width="6"></td>
                                            <td class="chagrs_grid_text"><?=$n+1;//$list[$n][0]['id'];?></td>
                                           <td width="1"></td>
                                            <td class="chagrs_grid_text">

                                            <div class="requested_category_details_main common_text">
											<div class="requested_category_details_sub"><?=$list[$n][0][16];?><br/>
											 </div>
											</div>
											</td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text numeric_texts"><? if(empty($list[$n][0]['cp'])){echo number_format($list[$n][0][10], 2, '.', '');}else{echo number_format($list[$n][0]['cp'], 2, '.', '');}?></td>
                                            
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text numeric_texts">
											<?=$list[$n][0]['qty'];?>
											</td>
                                            <td width="1"></td>
											<td class="chagrs_grid_text numeric_texts"><?=number_format($list[$n][0]['totle'], 2, '.', '');?></td>
                                     
                                          </tr>
											<? } break; case"C":{?>
                                            		 <tr style="vertical-align: top;">
                                            <td width="6"></td>
                                            <td class="chagrs_grid_text"><?=$n+1;//$list[$n][0]['id'];?></td>
                                           <td width="1"></td>
                                            <td class="chagrs_grid_text">

                                            <div class="requested_category_details_main common_text">
											<div class="requested_category_details_sub"><?=$list[$n][0][8];?><br/>
											  </div>
																						</div>
											</td>
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text numeric_texts"><? if(empty($list[$n][0]['cp'])){echo number_format($list[$n][0][10], 2, '.', '');}else{echo number_format($list[$n][0]['cp'], 2, '.', '');}?></td>
                                 
                                            <td width="1"></td>
                                            <td class="chagrs_grid_text numeric_texts"><?=$list[$n][0]['qty'];?>
											</td>
                                            <td width="1"></td>
											<td class="chagrs_grid_text numeric_texts"><?=number_format($list[$n][0]['totle'], 2, '.', '');?></td>
                             
                                          </tr>
											<? } 
                                            } // end switch
                                            } // end if?>
                                          <?
										  $subtotal = $subtotal + $list[$n][0]['totle']; } // end loop ?>

</tbody></table>
	</td>
  </tr>
  <tr>
    <td class="clients_quot_main_mid"> </td>
  </tr>
  <tr>
    <td class="clients_quot_main_mid">
	</td>
  </tr>
  <tr>
    <td class="clients_quot_main_mid">
	<table width="652" cellspacing="0" cellpadding="0" border="0">
 		<tbody>
        <?php if($printerFriendly){?><tr><td colspan="4"><hr> </td></tr> <?php }?>
        <tr style="vertical-align: top; height:20px;padding-top: 0px;padding-bottom: 0px;">
		<td width="6"/>
		<td width="566" class="chagrs_grid_text <?php if(!$printerFriendly){?>clients_quot_tbl<?php }?>" style="font-weight:bold;">Total</td>
		<td width="74" class="client_quot_grid_text <?php if(!$printerFriendly){?>clients_quot_tbl<?php }?>" style="font-weight:bold;"><?=number_format($subtotal, 2, '.', '');?></td>
		<td width="6"/>
	  </tr>     <?php if($printerFriendly){?><tr><td colspan="4"><hr> </td></tr> <?php }?>
      <?/* WILL BE ABLE TO USE IN FUTURE
	  <tr style="vertical-align: top;">
		<td width="6"/>
		<td class="chagrs_grid_text clients_quot_tbl">Delivery</td>
		<td class="client_quot_grid_text clients_quot_tbl">00.00</td>
		<td width="6"/>
	  </tr>
	  <tr style="vertical-align: top;">
		<td width="6"/>
		<td class="chagrs_grid_text clients_quot_tbl">(VAT)</td>
		<td class="client_quot_grid_text clients_quot_tbl">00.00</td>
		<td width="6"/>
	  </tr>
	  <tr style="vertical-align: top;">
		<td width="6"/>
		<td class="chagrs_grid_text clients_quot_tbl">Total</td>
		<td class="client_quot_grid_text clients_quot_tbl">0000.00</td>
		<td width="6"/>
	  </tr>*/?>
</tbody></table>
	</td>
  </tr>
  <tr>
    <td class="clients_quot_main_mid"> </td>
  </tr>
  <tr>
    <td class="clients_quot_main_mid">
		
	</td>
  </tr>
  <tr>
    <td class="clients_quot_main_mid">
		<table width="652" cellspacing="0" cellpadding="0" border="0">
 		<tbody>
        <tr style="vertical-align: top;">
		<td width="6"/>
		<td width="562" class="chagrs_grid_text <?php if(!$printerFriendly){?>clients_quot_tbl<?php }?>">Terms of Payment</td>
		<td width="78" class="chagrs_grid_text <?php if(!$printerFriendly){?>clients_quot_tbl<?php }?>"><?php echo $qdetails[0]['pay_method'];?></td>
		<td width="6"/>
        </tr>
      <?php if($qdetails[0]['vto']){?>
	  <tr style="vertical-align: top;">
		<td width="6"/>
		<td class="chagrs_grid_text clients_quot_tbl">Valid until</td>
		<td class="chagrs_grid_text  clients_quot_tbl"><?php  echo date('d/m/Y',$qdetails[0]['vto']);?></td>
		<td width="6"/>
	  </tr>
	 <?php }?>
</tbody></table>
	</td>
  </tr>
  <tr>
    <td class="clients_quot_main_mid" style="height:60px;">&nbsp; </td>
  </tr>
  <tr>
    <td class="clients_quot_main_mid"><br/><span class="common_text">----------------------------------</span><br/>
      <span class="common_text">On behalf of the contractor</span></td>
  </tr>
  <tr>
    <td class="clients_quot_main_bottom"/>
  </tr>
</tbody></table>

</div>
<?php if(!$printerFriendly){?><iframe id="frmPrinter" src="" width="0" height="0" border="0"  ></iframe><?php }?>
</body></html>