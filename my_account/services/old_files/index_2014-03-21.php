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
    require_once($objCore->_SYS['PATH']['CLASS_SERVICE']);
    require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
    require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
    require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
    if(!is_object($objCategory))
    {
        $objCategory = new Category();
    }
    if(!is_object($objCustomer))
    {
        $objCustomer = new Customer();
    }
    if (!is_object($objService))
    {
        $objService = new Service;
    }
    if (!is_object($objClassifiedAd))
    {
        $objClassifiedAd = new ClassifiedAd;
    }
    include("content_services.php");
   
    //$objService->dev = true;
    
    $exists = $objService->checkExists($objCore->sessCusId, '');
    //print_r($exists);
    
//    $submittedAccreditation=$_POST['accreditation'];
//    if ($submittedAccreditation)
//    {
//        $arrayAccreditation = array_values($submittedAccreditation);
//        $accreditation="||";
//        for($i=0;$i<count($submittedAccreditation);$i++)
//        {
//            $accreditation.=$submittedAccreditation[$i]."||";
//        }
//
//      
////        foreach ($arrayAccreditation as $value)
////        {
////            $accreditation.=$value."||";
////        }
//    }
    $accreditation="||";
   
    if (!$exists)
    { 
        
        switch ($_POST['action'])
        {
            case 'add':
                {
                
//                 echo $objCore->sessCusId.$_REQUEST['business_name'].$arrayIds.$_REQUEST['description'].
//                     $affiliations.$_REQUEST['keywords'].$_REQUEST['keyName'].$contact.$_REQUEST['hourlyRate'].
//        $_REQUEST['callOutCharge'].$accreditation.$website;
                      //exit;
                     $arrayIds = $objClassifiedAd->get_cat_id($_POST['category']);
                     //if(!$_REQUEST['hrate']) $_REQUEST['hourlyRate']=0;
                     
                     $contact = "none";
                     $website = "http://www.example.com";
                     $affiliations = "test";
                      //$objService->dev = true;

                     $msg = $objService->addToTbl($objCore->sessCusId, $_REQUEST['business_name'], $arrayIds, $_REQUEST['description'],
                     $affiliations, $_REQUEST['keywords'], $_REQUEST['keyName'], $contact, $_REQUEST['hourlyRate'],
        $_REQUEST['callOutCharge'], $accreditation, $website,$_REQUEST['keyName1'],$_REQUEST['keyName2'],$_REQUEST['keyName3']);
                     $serviceData = $objService->getServiceData($objCore->sessCusId);
                }
        }
    }
    else
    {
         if ($_POST['action'] == 'update')
         {
            $arrayIds = $objClassifiedAd->get_cat_id($_REQUEST['category']);
                     $contact = "noone";
                     $website = "http://www.example.com";
            //if(!$_REQUEST['hrate']) $_REQUEST['hourlyRate']=0;
                   //  $objService->dev = true;

            $msg = $objService->updateTbl($objCore->sessCusId, $_REQUEST['business_name'], $arrayIds, $_REQUEST['description'],
            $_REQUEST['affiliations'], $_REQUEST['keywords'], $_REQUEST['keyName'], $contact, $_REQUEST['hourlyRate'],
        $_REQUEST['callOutCharge'], $accreditation, $website,$_REQUEST['keyName1'],$_REQUEST['keyName2'],$_REQUEST['keyName3']);
         }
         $serviceData = $objService->getServiceData($objCore->sessCusId);
    }
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/services.js"></script>
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
     <div id="debug" name="debug">
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
			include("services.tpl.php");
		}break; 
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
</div>
</body>
</html>
