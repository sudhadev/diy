<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>                '
  '    FILE            :  /console/listing/index.php                          '
  '    PURPOSE         :                                                      '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
  	require_once("../../classes/core/core.class.php");$objCore=new Core;
	
	// Display the logged user.
	$objCore->auth(0,true);
	
	// Get the message key to show the message
	//$objCore->msgKey='USER';
  
	// Create an object to the User class.
  	require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
    require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);

    	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
	$objComponent = new Component();
    
	if(!is_object($objCategory))
	{
		$objCategory= new Category;
	}
    if(!is_object($objCustomer))
	{
		$objCustomer= new Customer;
	}
	$cusData = $objCustomer->getCustomerData($_REQUEST['id']);
    $var = ($_REQUEST['id'])?$_REQUEST['id']:$_REQUEST['time'];
    $listingCount = $objCustomer->getListingCount($var);
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head><script type="text/javascript" language="javascript" > section='';</script>
		<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_CONSOLE']);?>
	<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/listing.js">
	</script>
 	</head>
	<body onload="checkAdd();">
		<div align="left">
			<div id="main_outer">
				<div id="mainDiv">
					<!-- START PAGE HEADER -->
					<div id="top-bar">
						<?php require_once($objCore->_SYS['PATH']['HEAD_CONSOLE']);?>					
					</div>
					<!-- END PAGE HEADER -->
					
					<!-- START MENU -->
					<div id="page-menu">
					<?php require_once($objCore->_SYS['PATH']['MENU_CONSOLE']);?>			
					</div>
					<!-- END MENU -->

 
					<!-- START PAGE MIDDLE -->
					<div id="page-middle">
						<div id="page-middle-middle">
							<div id="page-middle-content">
                            <? if(!empty($_REQUEST['time'])){ ?>
<fieldset  style="border:1px solid #CCCCCC"id="page-middle-middle-content">
<legend>New Listing By Date</legend>
<form id="frm" action="">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" id="tblSearch">
      <tbody>
        <tr align="center">
          <td height="23"> </td>
          <td><table cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td>
                  </td>
                  <td width="20"> </td>
                     <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td width="60" align="center">Filter&nbsp;By</td>
                          <td><?php
				echo $objComponent->drop('time', $_REQUEST['time'], array(
				"all"=>"-------",
                "month"=>"Current Month",
                "week"=>"Current Week",
                "date"=>"Current Date",
			), '', 'onchange="form.submit();"');
							?></td>
                        </tr>
                      </tbody>
                    </table></td>
                </tr>
              </tbody>
            </table></td>
          <td width="15"> </td>
        </tr>
      </tbody>
    </table>
  </form>
  </fieldset> <? } ?>
                            <fieldset class="summeryBox" id="page-middle-middle-content" style="border: 1px dashed rgb(204, 204, 204);">
  <table>
  <tbody><tr>
                            <td valign="top" align="center" colspan="6">
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
								  <tbody><tr>
									<td>
										<table width="100%" cellspacing="0" cellpadding="0" border="0">
											<tbody>
                                            
								<? if(!$_REQUEST['time']){ ?>    <tr>
											<td width="150"><strong>Customer Name: </strong></td>
											<td><?php echo $cusData[0][0]." ".$cusData[0][1]; ?></td>
									      </tr> <? } ?>
                                          <tr>
                                            <td width="150"><strong>Total Listings: </strong></td>
											<td>Supplies (<?php if ($listingCount[0]['COUNT(*)']) { echo $listingCount[0]['COUNT(*)']; } else {echo "0"; } ?>)</td>
                                            <td>&nbsp; , &nbsp;</td>
                                            <td>Services (<?php if ($listingCount[1]['COUNT(*)']) { echo $listingCount[1]['COUNT(*)']; } else {echo "0"; } ?>)</td>
                                            <td>&nbsp; , &nbsp;</td>
                                            <td>Classified-Ads (<?php if ($listingCount[2]['COUNT(*)']) { echo $listingCount[2]['COUNT(*)']; } else {echo "0"; } ?>)</td>
                                          </tr>
									  </tbody></table></td>
								  </tr>
								</tbody></table></td>
                          </tr></tbody></table></fieldset>
                          
								<div id="category_list">
								<?php require_once($objCore->_SYS['PATH']['LEFT_CONSOLE']);?>
								</div>
								 <!-- START CONTENT AREA -->  
							<?php
								 switch($_REQUEST['f'])
								 {
                            default:
									{
					include ("listing.tpl.php");
									}
								 }                      
							?>
								 <!-- END CONTENT AREA -->      
								
							</div>
						</div>
					</div>
					<!-- END PAGE MIDDLE -->
					
					<!-- START PAGE FOOTER -->
					<div id="footer">
						<?php 
							require_once($objCore->_SYS['PATH']['FOOT_CONSOLE']);
						?>
					</div>
					<!-- END PAGE FOOTER -->
				</div>
			</div>
		</div>
	</body>
</html>
