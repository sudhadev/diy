<?php
/*
 * --------------------------------------------------------------------------\
 * ' This file is part module library of FUSIS '
 * ' (C) Copyright 2002-2009 www.fusis.com '
 * ' ..........................................................................'
 * ' '
 * ' AUTHOR : Priya Saliya Wijesinghe <saliyasoft@yahoo.com> '
 * ' FILE : index.php '
 * ' PURPOSE : provide the frame for any section of the system '
 * ' PRE CONDITION : commented '
 * ' COMMENTS : '
 * '--------------------------------------------------------------------------
 */
ini_set ( "max_execution_time", "3000" );
require_once ("../classes/core/core.class.php");
$objCore = new Core ();

$page = 'index.php';
// Display the logged user.
$objCore->auth ( 1, false );

require_once ($objCore->_SYS ['PATH'] ['CLASS_WISH_LIST']);

if (! is_object ( $objWishList )) {
	$objWishList = new WishList ( $objCore->gConf );
}
// print_r($_REQUEST);
$strSearch = $_REQUEST ['categories'] . "|DLM|"; // 0
$strSearch .= $_REQUEST ['keyword'] . "|DLM|"; // 1
$strSearch .= $_REQUEST ['address'] . "|DLM|"; // 2
$strSearch .= $_REQUEST ['radius'] . "|DLM|"; // 3
/* $strSearch.=$_REQUEST['order_by']."|DLM|"; */
/* start adding default search as nearest by- Ashan 2015-07-15 */
$orderby = $_REQUEST ['order_by'];
$cat=$_REQUEST['categories'];
if ($orderby == 0 && $cat==2) {
	$_REQUEST ['order_by'] = 1;
	$strSearch .= $_REQUEST ['order_by'] . "|DLM|";
} else {
	$strSearch .= $_REQUEST ['order_by'] . "|DLM|";
} /* end adding default search as nearest by- Ashan 2015-07-15 */
$strSearch .= $_REQUEST ['categoryId'] . "|DLM|"; // 5
$strSearch .= $_REQUEST ['specificationId'] . "|DLM|"; // 6
$strSearch .= $_REQUEST ['manufacturerId'] . "|DLM|"; // 7
$strSearch .= $_REQUEST ['latitude'] . "|DLM|"; // 8
$strSearch .= $_REQUEST ['longitude'] . "|DLM|"; // 9
$strSearch .= $_REQUEST ['pg']; // 10
$objCore->sysUpdate ( 'Search', $strSearch );
$objCore->sysUpdate ( 'Geo', $_REQUEST ['latitude'] . "|DLM|" . $_REQUEST ['longitude'] );
$objCore->sysCheck (); // get the updated values back to the same page;
$action = $_REQUEST ['action'];
switch ($action) {
	case "add" :
		{
			if ($_REQUEST ['subscription'] == "M") {
				$listing_id = $_REQUEST ['listing_id'];
				$quantity = $_REQUEST ['quantity'];
			} else {
				$quantity = "no_qty";
				$listing_id = "no_val";
			}
			$checkVal = $_REQUEST ['checkVal'];
			
			if ($checkVal != "") {
				$val = $objWishList->checkedValues ( $listing_id, $quantity, $checkVal, $_REQUEST ['subscription'] );
				$msg = $val [0];
				if ($msg [0] == "SUC") {
					$returnVal = $objCore->sysUpdate ( 'WishList', $val [1] );
					
					if (! $returnVal) {
						$msg = array (
								'ERR',
								'NOT_ADDED' 
						);
					} else {
						header ( "Location:" . $objCore->_SYS ['CONF'] ['URL_LOGIN_FRONT'] . "/?guest=Y" );
					}
				}
			} else {
				$msg = array (
						'ERR',
						'SELECT' 
				);
			}
		}
		break;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
<script type="text/javascript" language="javascript"
	src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/jquery.min.js"></script>
<script type="text/javascript" language="javascript"
	src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/animatedcollapse.js"></script>
<script type="text/javascript" language="javascript"
	src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/search.js"></script>
<script type="text/javascript"
	src="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.js"></script>
<script type="text/javascript"
	src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'];?>/wish_lists.js"></script>
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
<style>
#tag_bg_middle {
	height: auto;
	min-height: 100px;
}

#main_form_bg_middlebar {
	min-height: 0px;
}
</style>
</head>
<body <?php echo $jsBodyOnLoad;?>>
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
					<!-- START CONTENT AREA-->
        <?php
								switch ($_REQUEST ['f']) {
									default :
										{
											// default inclution
											include ("result.tpl.php");
										}
								}
								?>
        <!-- END CONTENT AREA-->
				</div>
				<!-- END BODY AREA-->
				<!-- START FOOTER AREA-->
      <?php require_once($objCore->_SYS['PATH']['FOOTER_FRONT']);?>
      <!-- END FOOTER AREA-->
			</div>
		</div>
	</div>
</body>
</html>
