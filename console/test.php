<?php
require_once("../classes/core/core.class.php");$objCore=new Core; 
//$use=0;require_once($objCore->_SYS['PATH']['AUTH']);
 $objCore->auth(0,true);echo $objCore->sessUId;
require_once($objCore->_SYS['PATH']['CLASS_SQL']);
echo "------------>".$U_ID;


$objSql= new Sql;
$objSql->dev=true;

$result=$objSql->query("SELECT * FROM `@diy_____admin_users`");
//print_r($result);


?>
