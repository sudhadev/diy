<?php

require_once("../classes/core/core.class.php");
$objCore=new Core;
require_once($objCore->_SYS['PATH']['CLASS_EMAIL']);

$objEmail = new Email();
$objEmail->send('register_supplier', $_REQUEST['email'], $_REQUEST['cid']);

?>

