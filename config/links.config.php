<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of the module library of FUSIS                       '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  links.arr.php                                  '
  '    PURPOSE         :  containing all the file names                       '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/


$_PATHS=array(

/* Config
*/
'CONF_SETUP'=>$_CONF['DIR_CONF'].'/'.$PREFIX_FILE.'setup.config.php',
/*'CONF_AREA_MAILS'=>$_CONF['DIR_CONF'].'/'.$PREFIX_FILE.'area_mails.arr.php',
'CONF_CONT_MNG'=>$_CONF['DIR_CONF'].'/'.$PREFIX_FILE.'content_mng.arr.php',
'CONF_USR_LIST'=>$_CONF['DIR_CONF'].'/'.$PREFIX_FILE.'user_type.arr.php',  */

/* Auth + Login links
*/
'AUTH'                  =>$_CONF['DIR_MODULES'].'/login//bin/auth.inc.php',
'SESS'                  =>$_CONF['DIR_MODULES'].'/login/bin/session.class.php',
'LOGIN_CONF'            =>$_CONF['DIR_MODULES'].'/login/bin/login.config.php',
'LOGIN_PROCESS'         =>$_CONF['DIR_MODULES'].'/login/bin/login.process.php',

/* Classes
*/
'CLASS_SQL'             =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_DIR.'core/sql.class.php',
'CLASS_ENCODE'          =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_DIR.'core/encode.class.php',
'CLASS_FTP'             =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_DIR.'core/ftp.class.php',
'CLASS_FTP_IMG'         =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_DIR.'core/ftp_img.class.php',
'CLASS_COUNTRY'         =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_DIR.'core/country.class.php',
'CLASS_DATE_TIME'       =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_DIR.'core/date_n_time.class.php',
'CLASS_DATE_TIME_PHP4'  =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_DIR.'core/date_n_time_PHP4.class.php',
'CLASS_HFILE'           =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_DIR.'core/hFile.class.php',

'CLASS_USER'            =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'user.class.php',
'CLASS_CMS'             =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'cms.class.php',
'CLASS_CUSTOMER'        =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'customer.class.php',
'CLASS_REGISTRATION'    =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'registration.class.php',
'CLASS_GEO'             =>$_CONF['DIR_MODULES'].'/geo/'.$PREFIX_FILE.'geo.class.php',
'CLASS_SPECIFICATION'   =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'specification.class.php',
'CLASS_CATEGORY'        =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'category.class.php',
'CLASS_LISTING'         =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'listing.class.php',
'CLASS_ORDER'           =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'order.class.php',
'CLASS_EMAIL'           =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'emails.class.php',
'CLASS_COMPONENT'       =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'component.class.php',
'CLASS_SPELL_CORRECTOR' =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'spell_corrector.class.php',
'CLASS_SEARCH'          =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'search.class.php',
'CLASS_GLOBAL_CONFIG'   =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'global_config.class.php',
'CLASS_CLASSIFIED_ADS'  =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'classified_ad.class.php',
'CLASS_BLOG'		    =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'blog.class.php',
'CLASS_MANUFACTURER'    =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'manufacturer.class.php',		
'CLASS_SERVICE'         =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'service.class.php',
'CLASS_WISH_LIST'       =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'wish_list.class.php',
'CLASS_QUOTATION'       =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'quotations.class.php',
'CLASS_PAYMENT'         =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'payment.class.php',
'CLASS_EXPIRING_ITEMS'  =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'expiring_items.class.php',
'CLASS_PROMOTION'       =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'promotion.class.php',
'CLASS_CURL'            =>$_CONF['DIR_CLASSES'].'/'.$PREFIX_FILE.'Curl.class.php',
'CLASS_SMTP'            =>$_CONF['DIR_CLASSES'].'/core/'.$PREFIX_FILE.'smtp.class.php',


'CLASS_PAYPAL_WRAPPER'  =>$_CONF['DIR_MODULES'].'/payments/PP-API/PPWrapper.class.php',


/* Misc
*/
'HEAD_CONSOLE'          =>$_CONF['DIR_BIN_CONSOLE'].'/header.inc.php',
'HEAD_HTML_CONSOLE'     =>$_CONF['DIR_BIN_CONSOLE'].'/html_inc_head.inc.php',
'LEFT_CONSOLE'          =>$_CONF['DIR_BIN_CONSOLE'].'/left.inc.php',
'FOOT_CONSOLE'          =>$_CONF['DIR_BIN_CONSOLE'].'/footer.inc.php',
'MENU_CONSOLE'          =>$_CONF['DIR_BIN_CONSOLE'].'/menu.inc.php',
'MSG_CONSOLE'           =>$_CONF['DIR_BIN_CONSOLE'].'/message.inc.php',

'HEAD_FRONT'            =>$_CONF['DIR_BIN_FRONT'].'/head.inc.php',
'HEAD_HTML_FRONT'       =>$_CONF['DIR_BIN_FRONT'].'/html_inc_head.inc.php',
'LEFT_FRONT'            =>$_CONF['DIR_BIN_FRONT'].'/left.inc.php',
'RIGHT_FRONT'           =>$_CONF['DIR_BIN_FRONT'].'/right.inc.php',
'FOOTER_FRONT'          =>$_CONF['DIR_BIN_FRONT'].'/footer.inc.php',
'MSG_FRONT'             =>$_CONF['DIR_BIN_FRONT'].'/message.inc.php',
'SEARCH_COM'            =>$_CONF['DIR_BIN_FRONT'].'/search_com.inc.php',
'MATERIAL_LIST'         =>$_CONF['DIR_BIN_FRONT'].'/tpl/material_list.tpl.php',
'CLASSIFIED_LIST'       =>$_CONF['DIR_BIN_FRONT'].'/tpl/classified_ad_list.tpl.php',
'SERVICE_LIST'          =>$_CONF['DIR_BIN_FRONT'].'/tpl/service_list.tpl.php',
'COM_GROUP_BY'          =>$_CONF['DIR_BIN_FRONT'].'/group_by.com.php',

//'MAIL_ON_ORDER_FRONT'=>$_CONF['DIR_EMAIL_CLIENT'].'/on_an_order.inc.php',
//'MAIL_ON_ORDER_ADMIN'=>$_CONF['DIR_EMAIL_CLIENT'].'/on_an_order_to_admin.inc.php',


);

?>
