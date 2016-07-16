<?php ini_set('display_errors',1);
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
  	if(!is_object($objCategory))
  	{
  		$objCategory= new Category;
  	}
  	
  	require_once($objCore->_SYS['PATH']['CLASS_SPECIFICATION']);
  	if(!is_object($objSpecification))
  	{
  		$objSpecification= new Specification;
  	}  	
  	
    require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
    if(!is_object($objCustomer))
    {
    	$objCustomer= new Customer;
    }    
    
    require_once($objCore->_SYS['PATH']['CLASS_MANUFACTURER']);
    if(!is_object($objManufacturer))
    {
    	$objManufacturer= new Manufacturer;
    }

    require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
    if(!is_object($objListing))
    {
    	$objListing= new Listing;
    }
    
    
    require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
	$objComponent = new Component();
    
	

	$cusData = $objCustomer->getCustomerData($_REQUEST['id']);
  //  $var = ($_REQUEST['id'])?$_REQUEST['id']:$_REQUEST['time'];
   // $listingCount = $objCustomer->getListingCount($var);
   
	
	// adding or editing listings
	
	switch($_REQUEST['action'])
	{
		case "add":
			{
				if($_POST['title']){
					$arrParentId=explode("_",$_POST['parentId']);$arrParentId[]=$_POST['manId'];//print_r($arrParentId);
					$arrImages=explode("|i|",$_POST['imgNames']);//print_r($arrImages);
						
					//$objListing->dev=true;
					//add_edit($arrParentId,$logId,$unitCost,$bulkDiscount,
					//$bulkPrice,$delivery,$listingActive,$img,$desc,$supplier_code,
					//$list_spec,$del,$del_rate,$header,
					//$url,$img2,$img3,$img4
					$msg = $objListing->add_edit($arrParentId,$_POST['cusId'],$_POST['unit_cost'],$_POST['bulk_discount'],
							$_POST['bulk_price'],'',$_POST['list_active'],$arrImages[0],$_POST['description'],'',
							$_POST['list_spec'],$_POST['delivery'],$_POST['delivery_rate'],$_POST['title'],
							$_POST['list_url'],$arrImages[1],$arrImages[2],$arrImages[3]);
				}
			}break;
			
	}
	
	
	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head><script type="text/javascript" language="javascript" > section='';</script>
		<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_CONSOLE']);?>
	<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/listing.js">
	</script>
	
	<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE']?>/ajaxupload.js">
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

                          
								<div id="category_list">
								<?php //require_once($objCore->_SYS['PATH']['LEFT_CONSOLE']);?>
								</div>
								 <!-- START CONTENT AREA -->  
							<?php
								 switch($_REQUEST['f'])
								 {
								 	
								 	case "add":
								 		include("cus_listing_add.tpl.php");
								 		break;
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
