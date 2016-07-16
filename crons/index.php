<?php 

	/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Saliya Wijesinghe <saliya@ymail.com>       				'
  '    FILE            :  index.php                                  			'
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

require_once("../classes/core/core.class.php");$objCore=new Core; 
require_once($objCore->_SYS['PATH']['CLASS_EXPIRING_ITEMS']);

if(!is_object($objExpiringItems)) $objExpiringItems = new ExpiringItems();

//$objExpiringItems->addExpiringClassifieds();


$objExpiringItems->addExpiringSubscriptions();

//$objExpiringItems->devideExpireRenew();

    
?>
