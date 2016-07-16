<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>      	  '
  '    FILE            :  index.php                                           '
  '    PURPOSE         :  provide the frame for any section of the system     '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
  	require_once("../../classes/core/core.class.php");$objCore=new Core;
	
	/**
	* Display the logged user.
	*/
	$objCore->auth(0,true);
	
	/**
	* Create an object to the User class.
	*/
  	require_once($objCore->_SYS['PATH']['CLASS_MANUFACTURER']);
	if(!is_object($objManufacturer))
	{
		$objManufacturer= new Manufacturer;
	}
	
	/**
	* Check the request with the hidden field.
	*/
	$action = $_REQUEST['action'];
	
	switch($action)
	{
		case "add":
		{
			/**
			* Call to the add function in the User class.
			*/
			$msg=$objManufacturer->add($_POST['mname'],$objCore->sessUId);
			
			/**
			* If message is successfull message, call to the default php file.
			*/
			if($msg[0]=='SUC'){
				$_REQUEST['f']='';
			}
			
		} break;
		
		case "edit":
		{
			/** 
			* Call to the edit function in the User class.
			*/
                        $msg=$objManufacturer->edit($_POST['mname'],$objCore->sessUId,$_REQUEST['id']);
                        
			/**
			* If message is successfull message, call to the default php file.
			*/
			if($msg[0]=='SUC'){
				$_REQUEST['f']='';
			}
			
		} break;
		
		case "merge":
		{
			/** 
			* Call to the edit function in the User class.
			*/
                        $msg=$objManufacturer->merge($_POST['mergeData'],$objCore->sessUId,$_REQUEST['id'],$_REQUEST['manufac']);
                        
			/**
			* If message is successfull message, call to the default php file.
			*/
			if($msg[0]=='SUC'){
				$_REQUEST['f']='';
			}
			
		} break;
		
		case "delete":
		{
			/**
			* Call to the edit function in the User class.
			*/
			$msg=$objManufacturer->delete($_REQUEST['id']);
			
			/**
			* If message is successfull message, call to the default php file.
			*/
			if($msg[0]=='SUC'){
				$_REQUEST['f']='';
			}
			
		} break;
		
		default:
		{
		
		}
	}
  
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_CONSOLE']);?>
		
	<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/manufacturers.js">
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
													include ("manufacturer_add.tpl.php");
												} break;
												
												case "edit":
												{
													include ("manufacturer_edit.tpl.php");
												} break;
											
												default:
												{
													include ("manufacturer_list.tpl.php");
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
