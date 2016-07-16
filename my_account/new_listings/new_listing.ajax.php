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

if(!is_object($objManufacturer))
{
    $objManufacturer= new Manufacturer;
}
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

if(!is_object($objComponent))
{
    $objComponent= new Component;
}

switch ($_REQUEST['val'])
{
    case "addCat":
    {
        $topclist = $_REQUEST['cat'];
        $cname = addslashes(htmlspecialchars($_REQUEST['subcat']));
        $image = addslashes(htmlspecialchars($_REQUEST['img']));
        

        $msg = $objCategory->addCategoryItem($cname,$topclist,'',"P",$image);

        /*
         * Get id of added category
         */
               $parentandlevel = explode("_",$topclist);
               $addedCategory=$objCategory->getCategoryByName($parentandlevel[0], ($parentandlevel[1]+1), $cname);



        if($msg)
        {
            echo $objCore->msgBox("CATEGORY",$msg,'98%')."||".$msg[0]."||".$addedCategory[0][0];
        }

    } break;

    case "addSpec":
    {
        $subcategory = addslashes(htmlspecialchars($_REQUEST['subcat']));
        $specification = addslashes(htmlspecialchars($_REQUEST['spec']));
        $manufacturer = addslashes(htmlspecialchars($_REQUEST['manu']));
        $keywords=$_REQUEST['kWords'];
        $image = $_REQUEST['img'];
        $supplier_code = $_REQUEST['supplier_code'];
        
        $file = $objCore->_SYS['CONF']['FTP_SEARCH_FRONT']."/index.txt";
        
        $arrParentId = $objClassifiedAd->get_cat_id($subcategory);
        $ids = $arrParentId[0]."_".$arrParentId[1]."_".$arrParentId[2];
        
        $list = $objCategory->arryMerge($arrParentId[1],"");

        $specId = "";
        
        if($list == "")
        {
            $msg = array("ERR", "NOT_EXIST_CAT");
            
        }elseif($arrParentId[2] == "")
        {
            $msg = array("ERR", "SELECT");

        } else
        {
            if($manufacturer != "")
            {
                $value = $objManufacturer->testManufac($manufacturer,$objCore->sessCusId);
                $manu_add = $value[0];
                $manu_id = $value[1];
                
            } else
            {
                $manu_add = "blank";
                $manu_id = 0;
            }
            
            if($manu_add != "not_added")
            {
               $msg = $objSpecification->add($arrParentId,$specification,'','',$keywords,$image,$objCore->sessCusId,$file,$manu_id);
               $specId = $objSpecification->getSpecId($specification,$subcategory);

               if($manu_add != "blank" && $msg[0]=="SUC")
               {
                   $msg = $objManufacturer->addSpecManu($specId,$manu_id);
               }

            }elseif($manu_add == "not_added")
            {
                $msg=array('ERR','NOT_ADDED');
            }
        }

        if($msg)
        {
            echo $objCore->msgBox("SPECIFICATION",$msg,'98%')."||".$msg[0]."||".$ids."||".$specId;
        }

    } break;

    case "showSpec":
    {
        $catId = explode("_",$_REQUEST['cat']);
       
        $list = $objCategory->arryMerge($catId[0],"");

        $subcategory = $_REQUEST['subcat'];

        $where = "`parent`='".$catId[0]."' AND `category`='".$subcategory."'";
        $list_id = $objCategory->dList($where);
        $id = $list_id[0][0];
        $arrParentId = $objClassifiedAd->get_cat_id($id);
        //*/$arrParentId = $objClassifiedAd->get_cat_id($catId[0]);
        $ids = $arrParentId[0]."_".$arrParentId[1]."_".$arrParentId[2];
        //$ids = $arrParentId[0]."_".$arrParentId[1];
        
        if($list == "")
        {
            $msg = array('ERR','NOT_EXIST_CAT');
            if($msg)
            {
                echo $objCore->msgBox("SPECIFICATION",$msg,'98%')."||".$msg[0]."||".$ids;
                //echo  print_r($msg)."||".$msg[0]."||".$ids;
            }
            
        } else
        {
             echo "0"."||"."SUC"."||".$ids;
        }
    } break;

    case "refreshDropDown":
    {
        $type = $_REQUEST['type'];
        $newAddedValue = $_REQUEST['addedVal'];
        $specId = $_REQUEST['specId'];

        switch($type)
        {
            case 'cate':
            {
                $category = $newAddedValue;
                $where = "`category`='".$category."'";
                $list = $objCategory->dList($where);
                $id = $list[0][0];
                $arrParentId = $objClassifiedAd->get_cat_id($id);
                $ids = $arrParentId[0]."_".$arrParentId[1];
                echo "0"."||"."SUC"."||".$ids;
                
            } break;

            case 'manufac':
            {
                $categoryId = $newAddedValue;
                
                $list = $objSpecification->specDropDown($categoryId, $objCore->sessCusId);
                $drop_down_list = $objSpecification->createDrop('spec_selection',$list,'spec','textfield_right_font',$specId);
                
                //$catDetails = $objCategory->getCategory($categoryId);
                $where = "`id`='".$categoryId."'";
                $catDetails = $objCategory->dList($where);
                
                if($catDetails[0][2] != "2")
                {
                    $msg = array('ERR','SELECT');
                    echo $objCore->msgBox("SPECIFICATION",$msg,'98%')."||"."ERR"."||".$drop_down_list;
                
                }elseif($list == "")
                {
                    $msg = array('ERR','NOT_EXIST_SPEC');
                    echo $objCore->msgBox("SPECIFICATION",$msg,'98%')."||"."ERR"."||".$drop_down_list;

                } else
                {
                     echo $drop_down_list."||"."SUC";
                }
                  
            } break;
        }
        
    } break;

    case "addManufac":
    {
        $subcategory = addslashes(htmlspecialchars($_REQUEST['subcat']));
        $specification = addslashes(htmlspecialchars($_REQUEST['spec']));
        $manufacturer = addslashes(htmlspecialchars($_REQUEST['manu']));

        $where = "`id`='".$subcategory."'";
        $catDetails = $objCategory->dList($where);

        if($catDetails[0][2] != "2")
        {
            $msg = array('ERR','SELECT');
            echo $objCore->msgBox("SPECIFICATION",$msg,'98%')."||"."ERR";

        } elseif($specification == "")
        {
            $msg = array('ERR','SELECT');
            echo $objCore->msgBox("MANUFACTURER",$msg,'98%')."||"."ERR";

        } elseif($manufacturer == "")
        {
            $msg = array('ERR','BLANK');
            echo $objCore->msgBox("MANUFACTURER",$msg,'98%')."||"."ERR";

        }else
        {
            $value = $objManufacturer->testManufac($manufacturer,$objCore->sessCusId);

            $manu_add = $value[0];
            $manu_id = $value[1];

            if($manu_add == "not_added")
            {
                $msg=array('ERR','NOT_ADDED');
                echo $objCore->msgBox("SPECIFICATION",$msg,'98%')."||"."ERR";

            }else
            {
                $msg = $objManufacturer->addSpecManu($specification,$manu_id);
                echo $objCore->msgBox("MANUFACTURER",$msg,'98%')."||".$msg[0];
            }
        }
    } break;
}



?>