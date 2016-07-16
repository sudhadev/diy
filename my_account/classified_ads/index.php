<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  index.php                                           '
  '    PURPOSE         :  provide the frame for any section of the system     '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
    require_once("../../classes/core/core.class.php");$objCore=new Core;
    $objCore->auth(1,true);
    require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
    require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
    require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);

    if(!is_object($objClassifiedAd))
    {
        $objClassifiedAd = new ClassifiedAd($objCore->gConf);
    }
    if(!is_object($objCategory))
    {
        $objCategory = new Category();
    }
    if(!is_object($objCustomer))
    {
        $objCustomer = new Customer();
    }

    $subsType = $objCore->sessUSubsTypes;
    $PkgType = $objCore->sessUPkgType;

    /**
    * Check the request with the hidden field.
    */
    $action = $_REQUEST['action'];
    $id_for_page = '';
    switch($action)
    {
        case "add":
        {
            /**
            * use this to get the category and subcategory ids.
            */
            $ids = $objClassifiedAd->get_cat_id($_POST['category']);
            
            /**
            * Call to the add function in the ClassifiedAd class.
            */
            $msg=$objClassifiedAd->add($objCore->sessCusId,$_POST['title'],$ids,$_POST['notes'],$_POST['keywords'],$_POST['price'],$_POST['keyName'],$_POST['keyName1'],$_POST['keyName2'],$_POST['keyName3'],$_POST['sellers_name'],$_POST['supplier_code'],$_POST['product_url']);

            /**
            * If message is successfull message, call to the default php file.
            */
            if($objCore->_SYS['ENV']=='LIVE'){
                $sysURL=str_replace("http://", "https://", $objCore->_SYS['CONF']['URL_SYSTEM']);
            }else{
                $sysURL=$objCore->_SYS['CONF']['URL_SYSTEM'];
            }
                
            if($msg[0]=='PAY')
            {
                   //echo "<meta http-equiv='refresh' Content='0; URL=".$objCore->_SYS['CONF']['URL_SYSTEM']."/my_account/payments/?selections=C&classifiedPayment=".$msg[1]."&imgKey=".$msg[2];
                  header("Location:".$sysURL."/my_account/payments/?selections=C&auth=".$objCore->sessCusId."&classifiedPayment=".$msg[1]."&imgKey=".$msg[2]."&num=".$msg[3]."&aat=".$msg[3]);
           
            } elseif($msg[0]=='SUC')
            {
                header("Location:". $objCore->_SYS['CONF']['URL_SYSTEM']."/my_account/classified_ads/index.php?f=manage&msg1=".$msg[0]."&msg2=".$msg[1]);
            } else
            {
                $_REQUEST['f']='add';
            }
        } break;

        case "edit":
        {
            /**
            * use this to get the category and subcategory ids.
            */
            $ids = $objClassifiedAd->get_cat_id($_POST['category']);
           
            /**
            * Call to the edit function in the ClassifiedAd class.
            */
            $msg=$objClassifiedAd->edit($objCore->sessCusId,$_POST['idValue'],$_POST['title'],$ids,$_POST['notes'],$_POST['keywords'],$_POST['keyName'],$_POST['keyName1'],$_POST['keyName2'],$_POST['keyName3'],$_POST['sellers_name'],$_POST['supplier_code'],$_POST['product_url']);

            /**
            * If message is successfull message, call to the default php file.
            */
            if($msg[0]=='SUC')
            {
                $_REQUEST['f']='manage';

            } elseif($msg[0]=='PAY')
            {
               header("Location:".$objCore->_SYS['CONF']['URL_SYSTEM']."/my_account/payments/?selections=C&auth=".$objCore->sessCusId."&classifiedPayment=".$msg[1]."&imgKey=".$msg[2]."&num=".$msg[3]);
               //echo "<meta http-equiv='refresh' Content='0; URL=".$objCore->_SYS['CONF']['URL_SYSTEM']."/my_account/payments/?selections=C&classifiedPayment=".$msg[1]."&imgKey=".$msg[2]."'>";
            }
            elseif($msg[0]=='ERR')
            {
                 $id_for_page = $_POST['idValue'];
                 //$_REQUEST['f']='edit';
                 header("Location:".$objCore->_SYS['CONF']['URL_SYSTEM']."/my_account/classified_ads/index.php?f=edit&id=".$id_for_page."&msg1=".$msg[0]."&msg2=".$msg[1]);
            }
        } break;
    }

    /*
     * Include content page
     */
        include("content_classified.php");


        $arrIcons['ACTIVE']='<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_FRONT'].'/icons/ok.png" alt="Active {%EXT%}" title="Active {%EXT%}" />';
        $arrIcons['EXPIRED']='<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_FRONT'].'/icons/issue.png" alt="Expired {%EXT%}" title="Expired {%EXT%}" />';
        $arrIcons['TO-EXPIRE']='<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_FRONT'].'/icons/thumb_down.png" alt="Auto Renew:  Off {%EXT%}" title="Auto Renew:  Off {%EXT%}" />';
        $arrIcons['AUTO']='<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_FRONT'].'/icons/thumb_up.png" alt="Auto Renew:  On {%EXT%}" title="Auto Renew:  On {%EXT%}" />';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.js"></script>
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
   <div id="debug" name="debug"></div>
<div id="middle_right_bar">
<!-- START CONTENT AREA-->
<?php 
	switch($_REQUEST['f'])
	{
		case "add":
		{			
			include("classified_ads_add.tpl.php");
		}break; 
		case "edit":
		{
			include("classified_ads_edit.tpl.php");
		}break;
                case "manage":
		{
			include("classified_ads_manage.tpl.php");
		}break;
                default:
                {
                    include("classified_ads_add.tpl.php");
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
