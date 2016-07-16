<?php 

	/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>      				'
  '    FILE            :  index.php                                  			'
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

require_once("../classes/core/core.class.php");$objCore=new Core; 
$objCore->auth(1,false);
require_once($objCore->_SYS['PATH']['CLASS_WISH_LIST']);

/*
 * added by saliya
 * if the user clicks on the same main category system should display the serch box (means home page)
 */

    if($_REQUEST['tcid'] && ($_REQUEST['tcid']==$_REQUEST['ctcid'])) header("Location:".$objCore->_SYS['CONF']['URL_SYSTEM']);
/* 
 * added by chelanga
 * adding listing class to take the count on listing for each level 3 catogory
 * 
 */
require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
if(!is_object($objListing)) {
	$objListing = new Listing();
}

// end

if(!is_object($objWishList))
{
    $objWishList = new WishList($objCore->gConf);
}
		$strBrowse=$_REQUEST['f']."|DLM|";  //0
		$strBrowse.=$_REQUEST['tcid']."|DLM|"; //1
		$strBrowse.=$_REQUEST['categoryId']."|DLM|";//2
		$strBrowse.=$_REQUEST['specificationId']."|DLM|";//3
		$strBrowse.=$_REQUEST['manufacturerId']."|DLM|";//4
		$strBrowse.=$_REQUEST['order_by']."|DLM|";//5
		$strBrowse.=$_REQUEST['pg']."|DLM|";//6
		$strBrowse.=$_REQUEST['categories']."|DLM|";//7
                $strBrowse.=$_REQUEST['pcid'];//8
	
		$geoData = $objCore->sysVars['Geo'];
		if (!is_null($geoData))
		{
			$strGeo = explode("|DLM|", $geoData); 
			$_REQUEST['latitude'] = $strGeo[0];
			$_REQUEST['longitude'] = $strGeo[1];
		}

    $action = $_REQUEST['action'];
    switch($action)
    {
        case "add":
        {
            if($_REQUEST['subscription'] == "M")
            {
                $listing_id = $_REQUEST['listing_id'];
                $quantity = $_REQUEST['quantity'];
            } else
            {
                $quantity = "no_qty";
                $listing_id = "no_val";
            }
            $checkVal = $_REQUEST['checkVal'];
            
            if($checkVal != "")
            {
                $val = $objWishList->checkedValues($listing_id, $quantity, $checkVal,$_REQUEST['subscription']);
                echo "--------->".$val[1];
                $msg = $val[0];
                if($msg[0] == "SUC")
                {
                    /*if($objCore->sessCusId != "")
                    {
                        $dbVal =  $objWishList->updateTmpValue($objCore->sysVars['WishList'], $val[1]);
                        $returnVal = $objCore->sysUpdate('WishList', $dbVal);
                        $guest = "N";
                    } else
                    {
                        $returnVal = $objCore->sysUpdate('WishList', $val[1]);
                        $guest = "Y";
                    }*/

                    $returnVal = $objCore->sysUpdate('WishList', $val[1]);
                    
                    if(!$returnVal)
                    {
                        $msg=array('ERR','NOT_ADDED');
                    } else
                    {
                        header("Location:".$objCore->_SYS['CONF']['URL_LOGIN_FRONT']."/?guest=Y"); 
                    }
                }
            } else
            {
                $msg=array('ERR','SELECT');
            }         
        } break;
    }

    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php
    $title = "Building Supplies | Building Services | Classified Ads";
    switch($_REQUEST['f'])
						{
							case "slist":
							{ 
							  $title = "Categories | Building Supplies | Building Services | Classified Ads";
							}break;
							
							case "spec":
							{ 
								$title = "Specifications | Building Supplies | Building Services | Classified Ads";
							}break;
							case "manufac":
							{ 
								$title = "Manufacturers | Building Supplies | Building Services | Classified Ads";
							}break;
					 		 case "result":
							{ 
								$title = "Listings | Building Supplies | Building Services | Classified Ads";
							}break;
                                                        case "more":
							{ 
                                                            if($_REQUEST['catid']==1){
                                                                $title = "More Details | Listings | Building Supplies | Building Services | Classified Ads";
                                                            }
                                                            else if($_REQUEST['catid']==2){
                                                                $title = "More Details | Services | Building Supplies | Building Services | Classified Ads";
                                                            }
                                                            else{
                                                                $title = "More Details | Classified Ads | Building Supplies | Building Services | Classified Ads";
                                                            }
                                                            
								
							}break;
							default:
							{
								// default inclution
								$title = "Categories | Listings | Building Supplies | Building Services | Classified Ads";
							}
						}
    
    ?>
    <title><?php echo $title; ?></title>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/signup.js"></script>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'];?>/wish_lists.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/search.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/animatedcollapse.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/wish_lists.js"></script>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.js"></script>
<script type="text/javascript">
	animatedcollapse.addDiv('read', 'fade=0,speed=400, group=read_more, persist=1,hide=1')
	animatedcollapse.addDiv('read_init', 'fade=0,speed=400, group=read_more, persist=1,hide=1')
	//fires each time a DIV is expanded/contracted
	animatedcollapse.ontoggle=function($, divobj, state)
	{
		//$: Access to jQuery
		//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
		//state: "block" or "none", depending on state
	}

	animatedcollapse.init()
</script>

</head>
<body <?php echo $jsBodyOnLoad ;?>>
 <div id="bg" style="left: 0px; top: 0px; display: none; position: absolute;"></div>
  <div align="center">
    <div id="main_outer">
      <div id="mainDiv">
        <div id="top_bar">
          <!-- START TOP HEADER-->
          <?php require_once($objCore->_SYS['PATH']['HEAD_FRONT']);?>
          <!-- END TOP HEADER-->
        </div>
        <!-- START BODY AREA-->
        <div id="middle_bar">
          <div id="middle_left_bar">
            <!-- START LEFT AREA-->
            <?php require_once($objCore->_SYS['PATH']['LEFT_FRONT']);?>
            <!-- END LEFT AREA-->
          </div>
          <div id="middle_right_bar">
            <!-- START CONTENT AREA-->
            <?php 
						switch($_REQUEST['f'])
						{
							case "slist":
							{ 
								include("sub_category.tpl.php"); 
							}break;
							
							case "spec":
							{ 
								include("specification.tpl.php"); 
							}break;
							case "manufac":
							{ 
								include("manufacturers.tpl.php"); 
							}break;
					 		 case "result":
							{ 
								include("result.tpl.php");
							}break;
                                                        case "more":
							{ 
                                                            if($_REQUEST['catid']==1){
                                                                include("moredetails.tpl.php"); 
                                                            }
                                                            else if($_REQUEST['catid']==2){
                                                                include("moredetails_services.tpl.php"); 
                                                            }
                                                            else{
                                                                include("moredetails_classifieds.tpl.php"); 
                                                            }
                                                            
								
							}break;
							default:
							{
								// default inclution
								include("category.tpl.php");  
							}
						}
					?>
            <!-- END CONTENT AREA-->
            
            
          </div>
          <!-- END BODY AREA-->
         
        </div>
        
      </div><!-- START FOOTER AREA-->
            <?php
            require_once($objCore->_SYS['PATH']['FOOTER_FRONT']);?>
            <!-- END FOOTER AREA-->
    </div>
  </div>
  
</body>
</html>