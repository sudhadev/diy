<?php 
  /*--------------------------------------------------------------------------\
    '    This file is part of shoping Cart in module library of FUSIS           '
    '    (C) Copyright 2004 www.fusis.com                                       '
    ' ..........................................................................'
    '                                                                           '
    '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
    '    FILE            :  console/category/category_add.ajax.tpl.php          '
    '    PURPOSE         :  add users page of the user section                  '
    '    PRE CONDITION   :  commented                                           '
    '    COMMENTS        :                                                      '
    '--------------------------------------------------------------------------*/
  
    require_once("../../classes/core/core.class.php");$objCore=new Core;
    require_once($objCore->_SYS['PATH']['CLASS_WISH_LIST']);
    require_once($objCore->_SYS['PATH']['CLASS_SEARCH']);

    $objCore->auth(1,true);
    if(!is_object($objWishList))
    {
        $objWishList = new WishList($objCore->gConf);
    }
    if(!is_object($objSearch))
    {
        $objSearch = new Search($objCore->gConf);
    }


    // Create quotation
       if($_REQUEST['cQuote']=='y'){
           require_once($objCore->_SYS['PATH']['CLASS_QUOTATION']);
            if(!is_object($objQuotation))
            {
                 $objQuotation = new Quotation('',$objCore->gConf,$objCore->sessCusId);
            }
          
            $objQuotation->addQuotationFromWishList($objCore->sysVars['WishList'],$objCore->sysVars['WQLink']);
            header("Location:".$objCore->_SYS['CONF']['URL_FRONT'].'/my_account/my_quotations/');
            
       }

   // echo $objCore->sysVars['WishList']."****".$objWishList->itemCount($objCore->sysVars['WishList']);
    $action = $_REQUEST['action'];
    switch($action)
    {
        case "add":
        {
            $subcription = "M";
            $listing_id = $_REQUEST['listing_id'];
            $quantity = $_REQUEST['quantity'];

            $checkVal = $listing_id;

            if($checkVal != "")
            {
                $val = $objWishList->checkedValues($listing_id, $quantity, $checkVal,$subcription);
                $msg = $val[0];
                
                if($msg[0] == "SUC")
                {
                    
                    $dbVal =  $objWishList->updateTmpValue($objCore->sysVars['WishList'], $val[1]);
                    $returnVal = $objCore->sysUpdate('WishList', $dbVal);

                    if(!$returnVal)
                    {
                        $msg=array('ERR','NOT_ADDED');
                    } else
                    {
                         $msg=array('SUC','UPDATED');
                         header("Location:".$objCore->_SYS['CONF']['URL_WISH_LIST']."/?selectParent=1&msg1=".$msg[0]."&msg2=".$msg[1]);
                    }
                }
            } else
            {
                $msg=array('ERR','SELECT');
            }
        } break;

        case "delete":
        {
                $dbVal =  $objWishList->delete($_REQUEST['id'],$objCore->sysVars['WishList']);
                $returnVal = $objCore->sysUpdate('WishList', $dbVal);

                if(!$returnVal)
                {
                    $msg=array('ERR','NOT_DELETE');
                    //echo $objCore->msgBox("WISHLIST",$msg,'99%');
                } else
                {
                    $subscriptionAndId = $_REQUEST['id'];
                    $subscription = $subscriptionAndId[0];
                    if($subscription == "M")
                    {
                        $parentCat = "1";
                    } elseif($subscription == "S")
                    {
                        $parentCat = "2";
                    }elseif($subscription == "C")
                    {
                        $parentCat = "3";
                    }
                    $msg=array('SUC','DELETE');
                    header("Location:".$objCore->_SYS['CONF']['URL_WISH_LIST']."/?selectParent=".$parentCat."&msg1=".$msg[0]."&msg2=".$msg[1]);
                }
        }break;
    }

    // Add the content page - modified by salya
    include("wish_list.content.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'];?>/wish_lists.js"></script>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'];?>/search.js"></script>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.js"></script>
</head>
<body <?php echo $jsBodyOnLoad;?> >
<div align="center">
<div id="main_outer">
<!--<div id="logo"></div>-->
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
		default:
		{
			include("wish_list.tpl.php");
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
