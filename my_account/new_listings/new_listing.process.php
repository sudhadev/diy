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


/** 
 * Display the logged user.
 */
//$objCore->auth(1,true);
//if($objCore->auth(1,true))
//{

if(!is_object($objCategory))
{
    $objCategory = new Category($objCore->sessCusId);
}
if(!is_object($objClassifiedAd))
{
    $objClassifiedAd = new ClassifiedAd($objCore->gConf);
}
if(!is_object($objSpecification))
{
    $objSpecification= new Specification;
}

$requestTpl = $_REQUEST['req'];

$cate = "hide=1";
$spec = "hide=1";
$manufac = "hide=1";

switch($requestTpl)
{
    case "cate":
    {
        $cate = "hide=0";
    } break;

    case "spec":
    {
        $spec = "hide=0";
    } break;

    case "manufac":
    {
        $manufac = "hide=0";
    } break;
}

$ids = $_REQUEST['ids'];
$arryids = explode("_", $ids); //1_45
$level = count($arryids)-1;
$requestId = $arryids[0];

?>