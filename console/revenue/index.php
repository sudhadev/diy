<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris<j.heshan@gmail.com>       	  			'
  '    FILE            :  index.php                                           '
  '    PURPOSE         :       																'
  '    PRE CONDITION   :                                             			'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
  	require_once("../../classes/core/core.class.php");$objCore=new Core;
	
	$objCore->auth(0,true);

   require_once($objCore->_SYS['PATH']['CLASS_ORDER']);
	if(!is_object($objOrder))
	{
		$objOrder= new Order();
	}
   
	// Check the request with the hidden field.
	$action = $_REQUEST['action'];
	
	switch($action)
	{
		case "delete":
		{
			$msg = $objOrder->deleteOrder($_REQUEST['id']);
			if($msg[0]=='SUC')
			{
				$_REQUEST['f']='';
			}
		} break;

        case "edit":
            {

                $year  =date("Y",$_REQUEST['Date']);
                $month =date("n",$_REQUEST['Date']);
                $date  =date("j",$_REQUEST['Date']);
                $hour  =0;
                $minute=0;

                $msg=$objOrder->forceUpdate($_REQUEST['invoiceNo'],$_REQUEST['payMethod'],$year,$month,$date,$hour,$minute,$_REQUEST['note'],$objCore->sessUId);
                print_r($msg);
                if($msg[0]=='SUC')
                {
                    $_REQUEST['f']='fadd';$_REQUEST['invoiceNo']='';;$_REQUEST['id']='';
                }
            }
            break;
        case "refund":
            {

                $msg=$objOrder->refund($_REQUEST['invoiceNo'], $_REQUEST['refundAmount'], $_REQUEST['note'],$objCore->sessUId);
                if($msg[0]=='SUC')
                {
                    $_REQUEST['f']='';$_REQUEST['invoiceNo']='';$_REQUEST['id']='';
                }
            }
            break;
	}
  
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_CONSOLE']);?>
		
	<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/users.js">
	</script>
	<script type="text/javascript" language="javascript">
	function print_pg(url)
	{
		args="width="+730+",height="+400+",resizable=yes,scrollbars=yes,status=0";
		window.open(url,"Print",args);
	}
</script>
	</head>

	<body>
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
								<div>
									 <!-- START CONTENT AREA -->  
									  	<?php
											 switch($_REQUEST['f'])
											 {
												
												case "more":
												{
													include("order_more.tpl.php");
												}break;
												case "edit":
												{
													include("order_edit.tpl.php");
												}break;

												case "faddrc":
												{
													include("order_recurring_edit.tpl.php");
												}break;

												case "fadd":
												{
													include("order_force_insert.tpl.php");
												}break;
												
                                                case "sdul":
                                                {
                                                    include("shedule_list.tpl.php");
                                                }
                                                break;
                                                case "rcprf":
                                                {
                                                    include("recurring_profile.tpl.php");
                                                }
                                                break;
												default:
												{
													include ("order_list.tpl.php");
												}
											 }                      
										?>
									 <!-- END CONTENT AREA -->      
								</div>
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