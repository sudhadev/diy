<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
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
	* Create an object to the Page class.
	*/
	include($objCore->_SYS['PATH']['CLASS_CMS']);
	if(!is_object($objCms))
	{
		$objCms= new Cms;
	}
	
	/**
	* Check the request with the hidden field.
	*/
	$action = $_REQUEST['action'];
	
	switch($action)
	{
		case "edit":
		{
			/** 
			* Call to sampleposteddata.php file to take the html source code.
			*/
			include ("sampleposteddata.php");
			
			/**
			* Call to the edit function in the User class.	
			*/	
			$msg=$objCms->edit($newContent, $_REQUEST['pid']);
			
			/** 
			* If message is successfull message, call to the default php file.
			*/
			if($msg[0]=='SUC'){
				$_REQUEST['f']='edit';
			}
			
		} break;
		
		default:
		{
		
		}
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_CONSOLE']);?>
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
									  	<!--  Check the request and call to the corresponding php file. -->		
										<?php
											 switch($_REQUEST['f'])
											 {
											
												default:
												{
													include ("page_edit.tpl.php");
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
