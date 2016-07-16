<?
  /*--------------------------------------------------------------------------\
  '    This file is part of ePost[Newsletter] in module library of FUSIS      '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  cv.inc.php                                          '
  '    PURPOSE         :  Component for cv upload                             '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

/* Configuration inclution ........................................................../*
*/ require_once ('../../config/@shop_____base.class.php');$base=new base;            /*
/*.................................................................................../*/

  include($base->_LINK['CLASS_FTP']);
  include($base->_LINK['CLASS_FTP_IMG']);

  $ftp= new ftp_img;
  $ftp->img_x=50;
  $ftp->img_y=50;
$com=$_REQUEST['com'];
  // Location
     switch ($com)
     {
        case "categ":
             $ftploc='FTP_CATS';
             $httploc='URL_IMAGES_CATS';
        break;
        case "brand":
             $ftploc='FTP_BRNS';
             $httploc='URL_IMAGES_BRNDS';
        break;
        default:
             $ftploc='FTP_PRDS';
             $httploc='URL_IMAGES_PRODS';
     }

   $fnameFTP=$base->_SW[$ftploc]."/large/".$_REQUEST['img'];
    if(is_file($fnameFTP)){
       $ftp->get_img_xy($fnameFTP);
           $showIMG=$base->_SW[$httploc]."/large/".$_REQUEST['img'];;
    }else{
       $showIMG=$showIMG=$base->_SW[$httploc]."/large/no_image.jpg";  $ftp->img_x=200;  $ftp->img_y=200;
    }
?>
<html>
<head>
<title>Product Zoom</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="resizeTo(<?=$ftp->img_x?>,<?=$ftp->img_y+50?>);">
<img src="<?=$showIMG;?>" ></body>
</html>