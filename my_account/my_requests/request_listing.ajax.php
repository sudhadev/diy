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
/*require_once($objCore->_SYS['PATH']['CLASS_MANUFACTURER']);*/
require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
require_once($objCore->_SYS['PATH']['CLASS_SPECIFICATION']);
/*require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);*/

/*if(!is_object($objManufacturer))
{
    $objManufacturer= new Manufacturer;
}*/
if(!is_object($objSpecification))
{
    $objSpecification= new Specification;
}

if(!is_object($objClassifiedAd))
{
    $objClassifiedAd = new ClassifiedAd($objCore->gConf);
}

if(!is_object($objCategory))
{
    $objCategory = new Category($objCore->sessCusId);
}

/*if(!is_object($objComponent))
{
    $objComponent= new Component;
}*/

switch ($_REQUEST['val'])
{
    case "editCat":
    {
        $cname = addslashes(htmlspecialchars($_REQUEST['cn']));
        $cdescription = "";
        $cstatus = "P";
        $img=addslashes(htmlspecialchars($_REQUEST['img']));
        $msg = $objCategory->editCategoryItem($_POST['id'],$cname,$_POST['cat'],$cdescription,$_POST['pare'],$_POST['lvl'],$cstatus,$img);

        if($msg)
        {
            echo $objCore->msgBox("CATEGORY",$msg,'98%')."||".$msg[0];
        }

    } break;

    case "editSpec":
    {
        $arrParentId = explode('_',$_REQUEST['ids']);
        $specification=addslashes(htmlspecialchars($_REQUEST['spec']));
        $kWords=addslashes(htmlspecialchars($_REQUEST['kWords']));
        $keyName = $_REQUEST['keyName'];
        $msg=$objSpecification->edit($arrParentId,$specification,'','',$kWords,$keyName);

        if($msg)
        {
            echo $objCore->msgBox("SPECIFICATION",$msg,'98%')."||".$msg[0];
        }

    } break;

}



?>