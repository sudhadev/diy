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
require_once($objCore->_SYS['PATH']['CLASS_WISH_LIST']);

/** 
 * Display the logged user.
 */
$objCore->auth(1,true);

if(!is_object($objWishList))
{
    $objWishList= new WishList($objCore->gConf);
}

        $subscription= $_REQUEST['subscri'];
        if($subscription == "M")
        {
            $listing_id= explode(',',$_REQUEST['listingId']);
            $quantity = explode(',',$_REQUEST['qty']);
            
        } else
        {
            $quantity = "no_qty";
            $listing_id = "no_val";
        }
        
	$checkValArry = explode(',',$_REQUEST['check']);
        for($i=0;$i<count($checkValArry);$i++)
        {
            if($checkValArry[$i] != "")
            {
                $check_val = explode('||',$checkValArry[$i]);
                $checkVal[$check_val[1]] = $check_val[0];
            }
        }

        if($checkVal != "")
        {
            $val = $objWishList->checkedValues($listing_id, $quantity, $checkVal,$subscription);

            $msg = $val[0];
            if($msg[0] == "SUC")
            {
                $dbVal =  $objWishList->updateTmpValue($objCore->sysVars['WishList'], $val[1]);
                $returnVal = $objCore->sysUpdate('WishList', $dbVal);

                if(!$returnVal)
                {
                    $msg=array('ERR','NOT_ADDED');
                } else
                {
                    $msg=array('SUC','DONE');
                    $wishListCount = $objWishList->itemCount($dbVal);
                }
            }
        } else
        {
            $msg=array('ERR','SELECT');
        }         

    if($msg)
    {
        echo $objCore->msgBox("WISHLIST",$msg,'98%')."||".$msg[0]."||".$wishListCount;
    }

?>