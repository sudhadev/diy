<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                               '
  '    (C) Copyright 2002-2009 www.fusis.com                                    '
  ' ..........................................................................  '
  '                                                                             '
  '    AUTHOR          :  Heshan J Peiris<j.heshan@gmail.com>                   '
  '    FILE            :  index.php                                             '
  '    PURPOSE         :       							'
  '    PRE CONDITION   :                                             		'
  '    COMMENTS        :                                                        '
  '--------------------------------------------------------------------------*/
  
  	require_once("../../classes/core/core.class.php");$objCore=new Core;
	
	$objCore->auth(0,true);

  	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	if(!is_object($objCustomer))
	{
		$objCustomer= new Customer;
	}
	
	// Check the request with the hidden field.
	$action = $_REQUEST['action'];
	
	switch($action)
	{
            
                case "add":
		{
                        $title = $_POST['ctitle'];
                        $email=$_POST['cemail'];
                        $fname = $_POST['cfname'];
                        $pass = $_POST['cpass'];
                        $cusType="S";
                        $subscription = $_POST['subscription'];
                        $package_type_extend=1;
                        
                        
                        if($subscription=="M")
                            $package="B";
                        else
                            $package="1";
                        
			$objCustomer->setVariables($title, " ","", $email, $email, $pass, $pass, $fname, "", "", "", "", "", "", "", "", $cusType, "", "", $subscription, $package,$package_type_extend);
			
			$msg = $objCustomer->addAdmin($cusType);
                        if($msg[0]=='SUC')
			{
				$_REQUEST['f']='add';
			}
		} break;
		case "delete":
		{
			$msg = $objCustomer->deleteCustomer($_REQUEST['id']);
			if($msg[0]=='SUC')
			{
				$_REQUEST['f']='';
			}
		} break;
		case "approve":
		{
			$msg = $objCustomer->setStatus($_REQUEST['id'], $_REQUEST['status'], '', 'cus');
			if($msg[0]=='SUC')
			{
				$_REQUEST['f']='';
			}
		} break;
		case "addprom":
		{
            require_once($objCore->_SYS['PATH']['CLASS_PROMOTION']);
            if(!is_object($objPromotion))   


                $objPromotion=new Promotion($objCore->gConf);
            $msg = $objPromotion->onRegistration($_POST['package'], $_POST['email'], $_POST['grace_period'], $_POST['ex_period']);
			if($msg[0]=='SUC')
			{
		// send email
                $code=$objPromotion->getCode();
                
                require_once($objCore->_SYS['PATH']['CLASS_EMAIL']);
                if(!is_object($objEmail)) $objEmail=new Email();
                
                $objEmail->send('promo', $_POST['email'], $code, 'H', $_POST['email']);

			}
		} break;
	}
  
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/jquery.min.js"></script>
		<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_CONSOLE']);?>
		
	<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/users.js">
	</script>
        
        <script type="text/javascript">
            $(document).ready(function(){
                $('#cfname').keyup(function(){ 
                    var max=$(this).attr('maxlength');
                    var valLen=$(this).val().length;
                    //$('#cfname_text_block').text( valLen+'/'+max);
                    if(valLen==max){
                        $('#cfname_text_block').html('<strong style="color: red">'+valLen+'/'+max+'</strong>');
                    }else{
                        $('#cfname_text_block').html('<strong>'+valLen+'/'+max+'</strong>');
                    }
                });
            });

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
												
												case "add":
												{
													include("customer_add.tpl.php");
												}break;
                                                                                             case "more":
												{
													include("customer_more.tpl.php");
												}break;
												case "prcd":
												{
													include("promote_code_add.tpl.php");
												}break;
												case "prcd_list":
												{
													include("promocode_list.tpl.php");
												}break;	
												default:
												{
													include ("customer_list.tpl.php");
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