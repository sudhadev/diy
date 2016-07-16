<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of fusis login module                                '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  process.inc.php                                     '
  '    PURPOSE         :  processing page for the login                       '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :  $uid,$pw                                            '
  '--------------------------------------------------------------------------*/
require_once ('../../classes/core/core.class.php');$objCore=new Core;
   require_once($objCore->_SYS['PATH']['SESS']);
  /* Configuration inclution .........................................../*/
     //include("bin/login.config.php");
  /*.................................................................../*/
    $objSession = new Session;
    $objSession->config=$objCore->_SYS['LCONF'];

    if(!isset($_REQUEST['cusr']))$_REQUEST['cusr']=1;//print_r($objCore->_SYS['LCONF']['LOGIN'][$_REQUEST['cusr']]['ERROR_URL']);

    if($_REQUEST['logout']=='y')
    {
        $objSession->logout($_REQUEST['cusr'],$_REQUEST['key'],$objCore->_SYS['LCONF']['LOGIN'][$_REQUEST['cusr']]['ERROR_URL'],$_REQUEST['bloc']);
    }
    else
    {
       $objSession->login($_REQUEST['uid'],$_REQUEST['pass'],$_REQUEST['cusr'],$_REQUEST['key'],$_LCONF['LOGIN'][$_REQUEST['cusr']]['ERROR_URL'],$_REQUEST['lfrom'][1]);
    }



?>