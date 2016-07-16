<?
  /*--------------------------------------------------------------------------\
  '    This file is part of module library of FUSIS                           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  zoom_prods.inc.php                                          '
  '    PURPOSE         :                          '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

/* 	Configuration inclution ........................................................../*
*/ 	require_once("../../classes/core/core.class.php");$objCore=new Core;               /*
/*.................................................................................../*/

	require_once($objCore->_SYS['PATH']['CLASS_FTP']);
	require_once($objCore->_SYS['PATH']['CLASS_FTP_IMG']);     
  
	$objftp_img = new ftp_img;
	$objftp_img->img_x=50;
	$objftp_img->img_y=50;
   
	$com=$_REQUEST['com'];
        $imgData=explode("_spl_",$_REQUEST['img']);
  // Location
     switch ($com)
     {
        case "categ":
             $ftploc='FTP_CATS';
             $httploc='URL_IMAGES_CATS';
        break;
        case "specs":
             $ftploc='FTP_SPECS';
             $httploc='URL_IMAGES_SPECS';
        break;
        case "clas_ads":
             $ftploc='FTP_CLAS_ADS';
             $httploc='URL_IMAGES_CLAS_ADS';
        break;
        case "services":
             $ftploc='FTP_SERVICES';
             $httploc='URL_IMAGES_SERVICES';
        break;

        case "quotations":
             $ftploc='FTP_QUOTATIONS';
             $httploc='URL_IMAGES_QUOTATIONS';
        break;

        case "brand":
             $ftploc='FTP_BRNS';
             $httploc='URL_IMAGES_BRNDS';
        break;
        case "listing":
             $ftploc='FTP_LISTINGS';
             $httploc='URL_IMAGES_LISTINGS';
             $extraFolder="/".$imgData[1];
        break;
        default:
             $ftploc='FTP_PRDS';
             $httploc='URL_IMAGES_PRODS';
     }


	$fnameFTP = $objCore->_SYS['CONF'][$ftploc].$extraFolder."/large/".$imgData[0];
  
    if(is_file($fnameFTP))
	{
        $objftp_img->get_img_xy($fnameFTP);
		$showIMG = $objCore->_SYS['CONF'][$httploc].$extraFolder."/large/".$imgData[0];
    }else
	{
       $showIMG=$showIMG = $objCore->_SYS['CONF'][$httploc]."/large/no_image.jpg";   $objftp_img->img_x=200;   $objftp_img->img_y=200;
    }
    
    $objftp_img->img_x=800;
    $objftp_img->img_y=600;
?>
<html>
<head>
<title>Product Zoom</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="resizeTo(<?php echo $objftp_img->img_x?>,<?php echo $objftp_img->img_y+50?>);">
<div style="overflow:scroll;height:600px;"><img border="0" width="<?php echo $objftp_img->img_x;?>" src="<?php echo $showIMG;?>" ></div></body>
</html>