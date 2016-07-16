<?php

	/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Saliya Wijesinghe <saliya@ymail.com>    				'
  '    FILE            :  index.php                                  			'
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        : Following are the expiration ids to be passed at each point
     *                   0 -> First Alert (before 1 Week)
     *                   1 -> First Alert (before 2 Days)
     *                   2 -> First Alert (Expired)
     *                    Following alerts are only for materials
     *                   3 -> First Alert (Data deletion Warning - after 7 days of expiry )
     *                   4 -> Data Deletion Confirmation
     *                                                       '
  '--------------------------------------------------------------------------*/

require_once("../classes/core/core.class.php");$objCore=new Core;
require_once($objCore->_SYS['PATH']['CLASS_EXPIRING_ITEMS']);
require_once($objCore->_SYS['PATH']['CLASS_EMAIL']);

if(!is_object($objExpiringItems)) $objExpiringItems = new ExpiringItems();
if(!is_object($objEmail)) $objEmail = new Email();


//$objEmail->dev=true;$objExpiringItems->dev=true;

    if(!$_REQUEST['id']||is_nan($_REQUEST['id']|| $_REQUEST['id']>1))  $_REQUEST['id']=0;
    // get items from Queue
    $result=$objExpiringItems->getByAlertNo((int)$_REQUEST['id'],'R');
    $newAlertNo=(int)$_REQUEST['id']+1;
    // sending emails
     for($e=0;$e<count($result);$e++)
     {
         if($result[$e][14]) $objEmail->send('renew', $result[$e][14],$result[$e][8],'H', $result[$e][13]);
         $objExpiringItems->updateAfterEmailSent($result[$e][8], $newAlertNo);
         echo "Email sent : ".($e+1)."<br/>";
     }


?>
DONE =================================================