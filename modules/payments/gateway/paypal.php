<?php
ini_set('display_errors','1');
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
     
require_once("../../../classes/core/core.class.php");$objCore=new Core;
$objCore->auth(1,false);

// Read the post from PayPal and add 'cmd'
$req = 'cmd=_notify-validate';
if(function_exists('get_magic_quotes_gpc'))
{ $get_magic_quotes_exits = true;}
foreach ($_POST as $key => $value)
// Handle escape characters, which depends on setting of magic quotes
{ if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1)
    {  $value = urlencode(stripslashes($value));
    } else {
        $value = urlencode($value);
    }
    $req .= "&$key=$value";
}
// Post back to PayPal to validate
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('sandbox.paypal.com', 80, $errno, $errstr, 30);

// Process validation from PayPal
if (!$fp) { // HTTP ERROR
} else {

    foreach ($_POST as $key => $value){
        $emailtext .= $key . " = " .$value ."\n\n";
        $newKey=str_replace(" ","",ucwords(str_replace("_"," ",$key)));
        $vals[$newKey]=$value;
        $log.=$vals[$newKey]."=".$value."<br/>";
        
    }
    mail("saliyasoft@gmail.com", "LIVE TEST", $emailtext . "\n\n" . $req);


//    require_once($objCore->_SYS['PATH']['CLASS_SQL']);
//    $sql=new sql;
//    $sql->query("INSERT INTO `"."@diy_____logs` (log,time) VALUES ('".$log."','".time()."')" );

    $_REQUEST['act']='listen';
    require_once("../PP-API.logic.php");
}



  


?>
