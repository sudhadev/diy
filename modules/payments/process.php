<?php ini_set('display_errors','1');
  /*--------------------------------------------------------------------------\
  '    This file is part of the module library of FUSIS                       '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  process.php                                      '
  '    PURPOSE         :  Process File                                  '
  '    PRE CONDITION   :                                      '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

  // Common module executor - mostly use in Ajax requests
     
  require_once("../../classes/core/core.class.php");$objCore=new Core;
  $objCore->auth(1,true);

  // Add necessory codes for gateway
     switch($_REQUEST['gate'])
     {
        case "paypal":
            {

               require_once("PP-API.logic.php");
               // following section for direct payments
                if($_REQUEST['act']=='direct'){
                    include($objCore->_SYS['CONF']['DIR_MY_ACCOUNT'].'/payments/'."paymentconfirm.tpl.php");
                }
            }
            break;
        default:
            die("Invalid Gateway");

     }


?>
