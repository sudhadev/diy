<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 - 2007 www.fusis.com                                '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Saliya Wijesinghe <saliyasoft@yahoo.com>            '
  '    FILE            :  console\index.php                                   '
  '    PURPOSE         :  Console Index Page                                  '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

    /*
       Add code for delete un wanted sesssion


    */
  	require_once("../classes/core/core.class.php");$objCore=new Core;

	$objCore->auth(0,true);
    
    switch($objCore->sessURole)
    {
        case 0: // super admin
        {
            $locatoin='revenue/';
        }
        break;
        
        case 1: // admin
        {
            $locatoin='listing/index.php?time=all';
        }
            
            
        
    }
    if($locatoin) header("Location: ".$locatoin);
 


?>
