<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Sadaruwan Hettiarachchi <sandaruwan@fusis.com>       '
  '    FILE            :  index.php                                           '
  '    PURPOSE         :  provide the frame for any section of the system     '
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
        require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);

	if(!is_object($objCategory))
	{
		$objCategory= new Category($objCore->sessUId);
	}

        if(!is_object($objComponent))
	{
		$objComponent = new Component();
	}
        
/*	// Check the request with the hidden field.
	switch($_REQUEST['action'])
	{
		case "add":
		{
			$msg = $objCategory->addCategoryItem($_POST['cname'],$_POST['topclist'],$_POST['cdescription'],$_POST['cstatus']);
		}break; 
		
		case "edit":
		{
			$msg = $objCategory->editCategoryItem($_POST['id'],$_POST['cname'],$_POST['name'],$_POST['cdescription'],$_POST['parent'],$_POST['level'],$_POST['cstatus']);
		}break; 
		
		case "delete":
		{
			$msg = $objCategory->deleteCategoryItem($_REQUEST['id'],$_REQUEST['level']);
		}break;
 
		default:
		{
		//skip;
		}
	}  */
	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    <script type="text/javascript" language="javascript" > section='cat';</script>
		<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_CONSOLE']);?>
	<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/category.js">
	</script>
	</script>
	<!--<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/category_folder-tree-static_console.js">
	</script>
	<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/category_ajax_console_.js">
	</script>-->
	<link href="<?php echo $objCore->_SYS['CONF']['URL_CSS_CONSOLE'];?>/edit_category.css" rel="stylesheet" type="text/css" />
 	</head>
	<body onload="checkAdd();<?php if ($_REQUEST['f'] == "plist"){?>getPendingCategories('1','P','','1');" <?php }?>; ">
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
                            	<?php
                                    if($_REQUEST['f']!="plist") {
                                ?>
								<div id="category_list">
								<?php require_once($objCore->_SYS['PATH']['LEFT_CONSOLE']);?>
								</div>
                                <?php
                                    }
                                ?>
								 <!-- START CONTENT AREA -->  
									<?php
										 switch($_REQUEST['f'])
										 {
											default:
											{
												include ("category.tpl.php");
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
