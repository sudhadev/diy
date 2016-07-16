<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of the module library of FUSIS                       '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  config.inc.php                                      '
  '    PURPOSE         :  Configuration File                                  '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/



	# Special Variables ------------- >
		$PREFIX_TBL='@diy_____';
		$PREFIX_DIR='';
		$PREFIX_FILE='';
		$CONFIG='config';
		$CONSOLE='console';
		$FRONT='';

	#-------------------------------- >

if($_SERVER["HTTPS"]){$dynHttp="https";}else{$dynHttp="http";}
if($ENV=='LIVE'){$secureHttp="https";}else{$secureHttp="http";}

$_CONF=array(

/* Host Configuration
*/
'HOST'=>$HOST,

/* Cookies host - If restriction cookies only for this domain
*/

'COOKIE_CONSOLE_URL'=>'',
'COOKIE_CONSOLE_KEY'=>'DCK_s9',
'COOKIE_FRONT_URL'=>'',
'COOKIE_FRONT_KEY'=>'diypc',
'COOKIE_GUEST_KEY'=>'dpcGKey',

/* URL(s) Configuration
*/
'URL_SYSTEM'=>'http://'.$HOST.$HOST_SW_FOLDER,

'URL_FRONT'=>'http://'.$HOST.$HOST_SW_FOLDER.'/'.$FRONT,
'URL_CONSOLE'=>'http://'.$HOST.$HOST_SW_FOLDER.'/'.$CONSOLE,

'URL_LOGIN_CONSOLE'=>'http://'.$HOST.$HOST_SW_FOLDER.'/'.$CONSOLE.'/login',
'URL_LOGIN_FRONT'=>$secureHttp.'://'.$HOST.$HOST_SW_FOLDER.'/login',
'URL_LOGIN_MODULE'=>$secureHttp.'://'.$HOST.$HOST_SW_FOLDER.''.'/modules'.'/login',
'URL_PAYMENT_MODULE'=>$secureHttp.'://'.$HOST.$HOST_SW_FOLDER.''.'/modules'.'/payments',
'URL_FCKEDITOR_MODULE'=>'http://'.$HOST.$HOST_SW_FOLDER.''.'/modules'.'/fckeditor',
'URL_IMG_UPLOAD_MODULE'=>'http://'.$HOST.$HOST_SW_FOLDER.''.'/modules'.'/image_upload',
'URL_AUTOSUGGEST_MODULE'=>'http://'.$HOST.$HOST_SW_FOLDER.''.'/modules'.'/autosuggest',

'URL_IMAGES_FRONT'=>$dynHttp.'://'.$HOST.$HOST_SW_FOLDER.'/images',
'URL_ICONS_FRONT'=>$dynHttp.'://'.$HOST.$HOST_SW_FOLDER.'/images/icons',
'URL_IMAGES_CONSOLE'=>'http://'.$HOST.$HOST_SW_FOLDER.'/'.$CONSOLE.'/images',
'URL_ICONS_CONSOLE'=>'http://'.$HOST.$HOST_SW_FOLDER.'/'.$CONSOLE.'/images/icons',


'URL_CSS_FRONT'=>$dynHttp.'://'.$HOST.$HOST_SW_FOLDER.'/css',
'URL_CSS_CONSOLE'=>'http://'.$HOST.$HOST_SW_FOLDER.'/'.$CONSOLE.'/css',

'URL_JS_FRONT'=>$dynHttp.'://'.$HOST.$HOST_SW_FOLDER.'/js',
'URL_JS_CONSOLE'=>'http://'.$HOST.$HOST_SW_FOLDER.'/'.$CONSOLE.'/js',

'URL_MY_ACCOUNT'=>'http://'.$HOST.$HOST_SW_FOLDER.'/my_account',
'URL_WISH_LIST'=>'http://'.$HOST.$HOST_SW_FOLDER.'/my_account/wish_list',
'URL_NEW_LISTINGS'=>'http://'.$HOST.$HOST_SW_FOLDER.'/my_account/new_listings',
'URL_REQUEST_LISTINGS'=>'http://'.$HOST.$HOST_SW_FOLDER.'/my_account/my_requests',
'URL_REQUEST_SUBSCRIPTIONS'=>'http://'.$HOST.$HOST_SW_FOLDER.'/my_account/my_subscriptions',



'URL_IMAGES_FCK'=>$HOST_SW_FOLDER.'/data/custom',
'URL_IMAGES_ITEMS'=>'http://'.$HOST.$HOST_SW_FOLDER.'/data/images/items',
'URL_IMAGES_CATS'=>'http://'.$HOST.$HOST_SW_FOLDER.'/data/images/categories',
'URL_IMAGES_SPECS'=>'http://'.$HOST.$HOST_SW_FOLDER.'/data/images/specifications',
'URL_IMAGES_CLAS_ADS'=>'http://'.$HOST.$HOST_SW_FOLDER.'/data/images/classified_ads',
'URL_IMAGES_SERVICES'=>'http://'.$HOST.$HOST_SW_FOLDER.'/data/images/services',
'URL_IMAGES_QUOTATIONS'=>'http://'.$HOST.$HOST_SW_FOLDER.'/data/images/quotations',
'URL_IMAGES_LISTINGS'=>'http://'.$HOST.$HOST_SW_FOLDER.'/data/images/listings',
'URL_ALERT'=>'http://'.$HOST.$HOST_SW_FOLDER.'/alert/',
'URL_FILES'=>'',



/* FTP(s) Configuration
*/
'FTP_TEMP'=>$_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/data/tmp',
'FTP_ITMS'=>$_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/data/images/items',
'FTP_CATS'=>$_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/data/images/categories',
'FTP_SPECS'=>$_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/data/images/specifications',   
'FTP_CLAS_ADS'=>$_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/data/images/classified_ads',
'FTP_SERVICES'=>$_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/data/images/services',
'FTP_QUOTATIONS'=>$_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/data/images/quotations',
'FTP_LISTINGS'=>$_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/data/images/listings',
'FTP_BRNS'=>$_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/data/images/brands',
'FTP_SEARCH_FRONT'=>$_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/search',




/* Dir(s) OR Path(s) Configuration
*/
'DIR_CONF' => $_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/'.$CONFIG.'/base',
'DIR_BIN_CONSOLE' => $_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/'.$CONSOLE.'/'.$PREFIX_DIR.'bin',
'DIR_BIN_FRONT' => $_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/'.$FRONT.''.$PREFIX_DIR.'bin',
'DIR_INC_FRONT' => $_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/'.$FRONT.''.$PREFIX_DIR.'inc',
'DIR_EMAIL_FRONT' => $_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/'.$FRONT.'/emails',
'DIR_CLASSES' => $_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/'.$PREFIX_DIR.'classes',
'DIR_CSS_FRONT' => $_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/'.$PREFIX_DIR.'css',
'DIR_MODULES' => $_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/modules',
'DIR_MATERIAL_LIST'=>$_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/'.$FRONT.''.$PREFIX_DIR.'/bin/tpl/material_list.tpl.php',
'DIR_MY_ACCOUNT' => $_SERVER['DOCUMENT_ROOT'].$HOST_SW_FOLDER.'/my_account',


/* payment(s) Configuration
*/
'PAYMENT'=>array(
'FS'=>array('NAME'=>'Dummy Payment Gateway'),
'PP'=>array('NAME'=>'Pay Pal'),
'CS'=>array('NAME'=>'Card Save','PRE_SHARED_KEY'=>'r8xO96h8C+p8gt7D1R9yWc9yJh1BlZVZ++kO91YQKeMSjpNiqbr1dZp9mr1vdiTO','MERCHANT'=>'DiyPri-6121078','PASS'=>'XL23nw38Wie','URL'=>"",'TRANSACTION_TYPE'=>'SALE'),
'CS-DEMO'=>array('NAME'=>'Card Save','PRE_SHARED_KEY'=>'r8xO96h8C+p8gt7D1R9yWc9yJh1BlZVZ++kO91YQKeMSjpNiqbr1dZp9mr1vdiTO','MERCHANT'=>'DiyPri-6085384','PASS'=>'9264C0F4M1','URL'=>"",'TRANSACTION_TYPE'=>'SALE'),
'PX'=>array('NAME'=>'PROTX','USER'=>'','PASS'=>'','URL'=>"https://ukvps.protx.com/vspgateway/service/vspform-register.vsp",'URL_TEST'=>"https://ukvpstest.protx.com/vspgateway/service/vspform-register.vsp"),

),

'PAY_METHODS'=>array(
   'DRT'=>'Direct Payment',
   'RCR'=>'Recurring Payment',
   'EXP'=>'Express Checkout',
   ''=>'Standard',
),

'GATE_WAY'=>'CS', // PX => protx , FS => Fusis
'GATE_WAY_TEST_MODE'=>TRUE, //      TRUE/FALSE


/* cart(s) Currency
*/
'CURRENCY'=>'&pound;',
'CURRENCY_PAY_GATE'=>'GBP',

/* FILE Extention(s) Configuration
*/
'EXT'=>array(
'.jpg',
'.jpeg',
'.gif',
),

/* Maximum FILE size(s) Configuration ===> in KB
*/
'F_SIZE'=>array(
'IMAGE'=>12288,

),


/* Special variables put in to the array -  this will be help on inheritence by base class
*/
'HOST'=>$HOST,
'HOST_SW_FOLDER'=>$HOST_SW_FOLDER,
'PREFIX_TBL'=>$PREFIX_TBL,
'PREFIX_DIR'=>$PREFIX_DIR,
'PREFIX_FILE'=>$PREFIX_FILE,

'SUBCRIPTIONS'=>array(
	'M'=>array(
		'OPTION'=>'Building Supplies',
		'B'=>'Bronze',
		'S'=>'Silver',
		'G'=>'Gold',
	),
	'S'=>array(
		'OPTION'=>'Building Services',
		'1'=>'1 Month',
		'3'=>'3 Month',
		'6'=>'6 Month',
		'12'=>'1 Year'	
	),
	'C'=>array(
		'OPTION'=>'Classified Ads'
	), 	
),

'PROMO_EXPIRE'=>10,
    
'STATUS'=>array(
    'Y'=>'Active',
    'N'=>'Inactive',
    'P'=>'Pending',
    'R'=>'Rejected'
),

'CREDIT_CARD_TYPES'=>array(
     'Visa'         =>'Visa',
     'MasterCard'   =>'MasterCard',
     'Discover'     =>'Discover',
     'Amex'         =>'American Express',
     'Maestro'      =>'Maestro',
     'Solo'         =>'Solo',

),

'MAIL_DEVELOPER'=>'sudharshan.ars@gmail.com',
    
'MAIL_ADMIN'=>'sudharshan.ars@gmail.com',
); // end vars Array


?>