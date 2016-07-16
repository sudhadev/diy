<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara    	  '
  '    FILE            :  index.php                                           '
  '    PURPOSE         :  provide the frame for specification section         '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
  	require_once("../../classes/core/core.class.php");$objCore=new Core;
	
	/**
	* Display the logged user.
	*/
	$objCore->auth(0,true);
  
	/** 
	* Create an object to the Specification class.
	*/
  	require_once($objCore->_SYS['PATH']['CLASS_SPECIFICATION']);
	require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);

	if(!is_object($objSpecification))
	{
		$objSpecification= new Specification;
	}
	
	if(!is_object($objCategory))
	{
		$objCategory = new Category();
	}

        if(!is_object($objComponent))
	{
		$objComponent = new Component();
	}
          
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head><script type="text/javascript" language="javascript" > section='';</script>
		<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_CONSOLE']);?>
        
<script src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/specification.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']?>/ajaxupload.js">
	</script>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_AUTOSUGGEST_MODULE'];?>/bsn.AutoSuggest_c_2.0.js"></script>
			
	</head>

        <body <?php if ($_REQUEST['f'] == "plist"){?> onload="resetPlist();" <?php }?> >
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
						<div id="page-middle-middle" >
							<div id="page-middle-content"  >
							<?php
                            if($_REQUEST['f']!="plist") {
                            ?>
							<div id="category_list">
                            
								<?php require_once($objCore->_SYS['PATH']['LEFT_CONSOLE']);?>
							</div>
                            <?php }?>

							<?php 
								switch($_REQUEST['f'])
								 {
                                     case "plist":
                                         include('specification_pending.tpl.php');
                                         break;
                                     default:
                                        {
                                            include ("specification.tpl.php");
                                        }
								 }           
							?>

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
<script language="javascript">//selectCategoryLevel('1_69_95');
//add_spec_tpl('1_131_135');</script>
					<!-- END PAGE FOOTER -->
				</div>
			</div>
		</div>
	</body>
</html>
