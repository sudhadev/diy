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
/* Authonication inclution ........................................................../*
*/$auth="";$use=0;include($base->_LINK['AUTH']);                                           /*
/* Language      ..................................................................../*
*/ if($_REQUEST['ln']){$U_LN=$_REQUEST['ln'];}else{$U_LN=$base->_SW['LANG_CONSOLE'];}/*
/*.................................................................................../*/

//require_once('../ln/'.$U_LN.'.ln.php');





  // Location
     switch ($_REQUEST['module'])
     {
        case "con_prd_lst":// console product list
			require_once($base->_LINK['CLASS_SQL']);echo ">>>>>>>>>>>>>>>>>>>>>>>>>>>";
			require_once($base->_LINK['CLASS_PRODS']);
			 $prods=new products;
			$UI='mod';$pg_bar='y';include $base->_LINK['COM+0006_1'];
        break;
        default:
             
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