<?
  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  console/prods/index.php                             '
  '    PURPOSE         :  index page of the products section                  '
  '    PRE CONDITION   :  commnted                                            '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

/* Configuration inclution ................................................../*
*/  require_once ('../../config/@shop_____base.class.php');$base=new base;/*
/* Authonication inclution ................................................../*
*/ if($_REQUEST['ln']){$U_LN=$_REQUEST['ln'];}else{$U_LN=$base->_SW['LANG_CONSOLE'];}/*
*/ $auth="";$use=1;include($base->_LINK['AUTH']);                                /*
/*............................................................./*/


  if(!$U_ID){
        header("Location: ".$base->_SW['URL_SHOP']."/my_account/?bloc=chkt");
  }

require_once('../lang/'.$U_LN.'.ln.php');
require_once $base->_LINK['CLASS_SQL'];//add by piyumi

include($base->_LINK['CLASS_PRODS']);
include($base->_LINK['CLASS_CATEG']);
include($base->_LINK['CLASS_CART']);
include($base->_LINK['CLASS_COUNTRY']);
include($base->_LINK['CLASS_DATE_TIME']);
include($base->_LINK['CLASS_DATE_TIME_PHP4']);
include($base->_LINK['CLASS_CUST']);
include($base->_LINK['CLASS_ORDERS']);
include($base->_LINK['CLASS_EMAIL']);

   $orders=new orders;
   $email=new email;
   
   //$prods=new products;
   //$categ=new category;
   $cart=new cart;
   $cart->clear($U_CID);
   //$cart->cl_check(); // check client and create if doesnt exist;

   $country=new country;
   $date=new date_N_time_PHP4;
   $customer=new customers;

   if($_REQUEST['action']){include("checkout.process.php");}
?>
<html>
<head>
<title><?echo $base->_SW['TITLE_CLIENT'];?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<link href="../themes/<? echo $base->_SW['THEME_SHOP'];?>/styles/common.css" rel="stylesheet" type="text/css">
<link href="../themes/<? echo $base->_SW['THEME_SHOP'];?>/styles/custom.css" rel="stylesheet" type="text/css">

<script language="javascript" src="<?=$base->_SW['URL_SYSTEM'];?>/modules/ibraries/functions.js"></script>
<table  border="0" cellspacing="0" cellpadding="0"  width="<?=$base->_SW['PAGE_SIZE'];?>" align="<?=$base->_SW['PAGE_ALIGN'];?>">  <tr>
    <td  align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td valign="top"><? include($base->_LINK['HEAD_CLIENT']); ?></td>
        </tr>
        <tr>
          <td height="54" valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td valign="top"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="shop_body_boder">
                    <tr>
                      <td><? include($base->_LINK['COM+1007']); ?></td>
                    </tr>
                    <tr>
                      <td valign="top"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                          
                          <tr>
                            <td width="204" align="right" valign="top">
                            <? include($base->_LINK['L_MENU_CLIENT']); ?>							</td>
                            <td width="364" valign="top" align="center" ><?
                                               switch($_REQUEST['f']){
                                                case "tks":
                                                        include ("thanks.tpl.php");  
											    break;
                                                default:
                                                        include ("error.tpl.php");
                       }
          ?></td>
                            <td width="187" align="left" valign="top"><? include($base->_LINK['R_MENU_CLIENT']); ?></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td height="8"></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td height="26" class="shop_futter_bord"><? include($base->_LINK['FOOT_CLIENT']); ?></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>