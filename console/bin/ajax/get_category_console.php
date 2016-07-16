<?php

  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  sadaruwan hettiarachchi <sadaruwan@fusis.com>       '
  '    FILE            :  console/bin/ajax/get_category_console.php           '
  '    PURPOSE         :  provide contact_us for any section of the system    '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

	require_once("../../../classes/core/core.class.php");$objCore=new Core;
    $objCore->auth(0,true); // only logged in admin users can be access this module

    /**
     * Re written by Saliya Wijesinghe on 2009-12-21
     *
     */ 
        $customerId=trim($_REQUEST['id']);
        // we need the category object to handle the complete process
	 	require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
		if(!is_object($objCategory)) $objCategory = new Category();

     // Get passed category information
        $idArr = explode("_",$_GET['parentId']); 
        $level = count($idArr);
        if($_REQUEST['section']=='cat' && $level>1) exit;
         if($customerId && $customerId!='undefined')
         {
             // category listing should be populated acording to the customer
                    $cArr=$objCategory->getCategoryByCustomerListing($customerId, $level, $idArr[count($idArr)-1],$idArr[0]);
                    $nextLevel=$level+1;

         }
         else
         {
             // should be displayed all the categories
             $cArr = $objCategory->getSubcList($idArr[(count($idArr)-1)],'sub_arr');
         }

                
		for ($s=0;$s<count($cArr);$s++)
		{
            //echo $cArr[$s][0].", ".$listingIds[$s][1];
            if($nextLevel) $cArr[$s]['nextl']=$nextLevel;
			if($cArr[$s][0]) {?>
                <li><a href="#" cPath="<?php echo $_GET['parentId']."_".$cArr[$s][0];?>"><?php echo $cArr[$s][3];?></a>
                <?php if($cArr[$s]['nextl'] && ($_GET['treeLevels'] > (count($idArr)+1))) {?>
                <ul>
                <li parentId="<?php echo $_GET['parentId']."_".$cArr[$s][0];?>"><a href="#" cPath="<?php echo $_GET['parentId']."_".$cArr[$s][0];?>" >Loading...</a></li>
                </ul>
                <?php } ?>
                </li>
	  <?php
            }
		}


?>