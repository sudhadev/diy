<?php

  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  /bin/ajax/contact_us.ajax.php                       '
  '    PURPOSE         :  provide contact_us for any section of the system    '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

require_once("../../classes/core/core.class.php");$objCore=new Core;
require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
require_once($objCore->_SYS['PATH']['CLASS_MANUFACTURER']);
require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
require_once($objCore->_SYS['PATH']['CLASS_SPECIFICATION']);
require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);

/** 
 * Display the logged user.
 */
$objCore->auth(1,true);
//if($objCore->auth(1,true))
//{



if(!is_object($objCategory))
{
    $objCategory = new Category($objCore->sessCusId);
}

if(!is_object($objComponent))
{
    $objComponent= new Component;
}






?>