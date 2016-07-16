<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  log.php                                             '
  '    PURPOSE         :  control the front end user sections on login        '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
  require_once("../classes/core/core.class.php");$objCore=new Core;
  $objCore->auth(1,true);
  require_once($objCore->_SYS['PATH']['CLASS_WISH_LIST']);

  if(!is_object($objWishList))
  {
    $objWishList = new WishList();
  }

	switch($objCore->sessUType)
	{
		case "S":
		{
			if($_REQUEST['lfrom'])
			{
				$url=$_REQUEST['lfrom'];
			}
			else
			{
				//redirect supplier to the my_account
                $url=$objCore->_SYS['CONF']['URL_SYSTEM']."/my_account/";
                $clientUpdate = $objCore->sysUpdate('ClientId', $objCore->sessCusId);
                $result = $objCore->getSysRows($objCore->sessCusId);
                $dbValue = $objWishList->updateTmpValue($result[0]['content_wlist'], $result[1]['content_wlist']);
                $objCore->updateClient($clientUpdate, $objCore->sessCusId, $result, $dbValue);
               
			}
		
		}break;
		
		case "B":
		{
			//redirect buyer to the wishlist
            $url=$objCore->_SYS['CONF']['URL_SYSTEM']."/";
            $clientUpdate = $objCore->sysUpdate('ClientId', $objCore->sessCusId);
            $result = $objCore->getSysRows($objCore->sessCusId);
            $dbValue = $objWishList->updateTmpValue($result[0]['content_wlist'], $result[1]['content_wlist']);
            $objCore->updateClient($clientUpdate, $objCore->sessCusId, $result, $dbValue);
		}break;
		
		default:
		{
			$url=$objCore->_SYS['CONF']['URL_LOGIN_FRONT'];
		}	
	
	} 

 	header("Location: $url");
  
?>
