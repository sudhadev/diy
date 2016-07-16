<?php 
  /*--------------------------------------------------------------------------\
    '    This file is part of shoping Cart in module library of FUSIS           '
    '    (C) Copyright 2004 www.fusis.com                                       '
    ' ..........................................................................'
    '                                                                           '
    '    AUTHOR          :  sadaruwan hettiarachchi <sadaruwan@fusis.com>       '
    '    FILE            :  my_account/my_quotation/index.php                   '
    '    PURPOSE         :  main page                                           '
    '    PRE CONDITION   :  commented                                           '
    '    COMMENTS        :                                                      '
    '--------------------------------------------------------------------------*/
require_once("../../classes/core/core.class.php");$objCore=new Core;
$objCore->auth(1,true);
require_once($objCore->_SYS['PATH']['CLASS_QUOTATION']);$objQuotation = new Quotation('',$objCore->gConf,$objCore->sessCusId);
switch($_REQUEST['f'])
	{
        case"recreate":
        {
            $msg=$objQuotation->loadQuotationToWishlist($_GET['qid']);
		$location = "Location: ".$objCore->_SYS['CONF']['URL_FRONT'].'/my_account/wish_list/';
       // header($location);
        }break;

                case"del":
        {
		$objQuotation->deleteQuotation($_GET['qid']);
        if($objCore->sysVars['WQLink']==$_GET['qid']){
            $objCore->sysUpdate('WQLink', '');
        }
		}break;

	}

    // Add the content page - modified by salya
    include("quotation.content.php");
    // pay methods
      // print_r($payArray);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
<link href="<?php echo $objCore->_SYS['CONF']['URL_CSS_FRONT']?>/calendar.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'];?>/quotation.js"></script>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'];?>/calendar.js"></script>
</head>
<body <?php echo $jsBodyOnLoad;?> >
<div align="center">
<div id="main_outer">
<div id="logo"></div>
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
        case"item":
        {
            include("item_list.tpl.php");
        }break;

        default:
		{
			include("quotation_list.tpl.php");
		}
	}
?>
<!-- END CONTENT AREA-->
</div>
<!-- END BODY AREA-->
</div>
<!-- START FOOTER AREA-->
<?php require_once($objCore->_SYS['PATH']['FOOTER_FRONT']);?>
<!-- END FOOTER AREA-->

</div>
</div>
</div>
</body>
</html>
