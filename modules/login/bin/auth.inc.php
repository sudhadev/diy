<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of fusis login module                                '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  authonicate.inc.php                                 '
  '    PURPOSE         :  user authonication module                           '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

     include($objCore->_SYS['PATH']['LOGIN_CONF']);//echo $base->_LINK['LOGIN_CONF'];
     $objSession = new Session;
     $objSession->config=$objCore->_SYS['LCONF'];
	 if(!isset($use)){$use=1;}
     $auth=$objSession->read($use,$objCore->_SYS['LCONF']['LOGIN'][$use]['COOKIE_NAME'],$auth);
echo "====";print_r($AUTH_VARS);echo "====";
     $U_ID=$auth['user'];
     $U_EXPIRE=$AUTH_VARS[1];
     $U_ACCESS=$AUTH_VARS[2];

//echo $U_ID;
     // extra fields comes begining from index 3
     // Dont add those to this file you can use those after this file
     // eg: $AUTH_VARS[3]  ----> For user first name
      $U_FNAME=$AUTH_VARS[3];
      $U_LNAME=$AUTH_VARS[4];
      $U_CID=$AUTH_VARS[5];

     //echo "$U_FNAME==========$U_LNAME============$U_CID=================";
?>