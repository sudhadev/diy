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
     *                    Following alerts are only for materials and will execute by separate cron
     *                   3 -> First Alert (Data deletion Warning - after 7 days of expiry )
     *                   4 -> Data Deletion Confirmation
     *                                                       '
  '--------------------------------------------------------------------------*/

require_once("../classes/core/core.class.php");$objCore=new Core;
require_once($objCore->_SYS['PATH']['CLASS_PROMOTION']);
require_once($objCore->_SYS['PATH']['CLASS_EMAIL']);

if(!is_object($objPromotion)) $objPromotion = new Promotion();
if(!is_object($objEmail)) $objEmail = new Email();

$time_gap = 1317368088+(3600*24);

$result = $objPromotion->sendAlert($time_gap);

if(count($result)>0){
    for($n=0;$n<count($result);$n++){
        $objEmail->send('promo_expire', $result[$n][email],'','H', $result[$n][code]);
        $codes = array($result[$n][code]);
        $objEmail->send('promo_expire_admin', $objCore->_SYS['CONF']['MAIL_ADMIN'],'','H', $result[$n][code]);
    }
    
}

//print_r($result);
   
?>
DONE =================================================
