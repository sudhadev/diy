<?php

  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>     	  '
  '    FILE            :  category.ajax.php          		  			      '
  '    PURPOSE         :  provide category for any section of the system      '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

	require_once("../../classes/core/core.class.php");$objCore=new Core;
	
	/**
	* Display the logged user.
	*/
	$objCore->auth(0,true);
  
	/** 
	* Create an object to the Specification class.
	*/
	require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
	
	if(!is_object($objCategory))
	{
		$objCategory = new Category($objCore->sessUId);
	}
	
	switch ($_REQUEST['val'])
	{
		case "edit":
		{ 
			$cname=addslashes(htmlspecialchars($_REQUEST['cn']));
			$cdescription=addslashes(htmlspecialchars($_REQUEST['cd']));
			$cstatus=addslashes(htmlspecialchars($_REQUEST['cs']));
			$img=addslashes(htmlspecialchars($_REQUEST['img']));
			$msg = $objCategory->editCategoryItem($_POST['id'],$cname,$_POST['cat'],$cdescription,$_POST['pare'],$_POST['lvl'],$cstatus,$img);
			
		} break;
		
		case "delete":
		{
			$arrParentId = explode('_',$_REQUEST['ids']);
			
			$msg = $objCategory->deleteCategoryItem($arrParentId[0],$arrParentId[1]);
			
		} break;
		
		case "add":
		{
			$arrParentId = explode('_',$_REQUEST['ids']);
			$cname=addslashes(htmlspecialchars($_REQUEST['cn']));
			$cdescription=addslashes(htmlspecialchars($_REQUEST['cd']));
			$cstatus=addslashes(htmlspecialchars($_REQUEST['cs']));
			$img=addslashes(htmlspecialchars($_REQUEST['img']));
			
			if(count($arrParentId) < 2)
			{
				$i = 0;
				$topclist = $arrParentId[0]."_".$i;
			} else
			{
                // Was logical error of following code
                // and modified by Saliya Wijesinghe on 24-02-2010
                // previous code -> $topclist = $arrParentId[1]."_".$arrParentId[0];
                $topclist = $arrParentId[1]."_".(count($arrParentId)-1);;
				
			}
			
			$msg = $objCategory->addCategoryItem($cname,$topclist,$cdescription,$cstatus,$img);
            $msgEmbed='||'.$topclist.'||'.$cname.'||'.$_REQUEST['ulid'].'||'.$arrParentId[0];
			
		} break;
	}
	
	if($msg)
	{
        if($_REQUEST['extValues']) { $widthMessage='99%';}else{$widthMessage='75%';}
        if($msg[1]=='DONE')
            $msg[1]='ADDED';
		echo $objCore->msgBox("CATEGORY",$msg,$widthMessage)."||".$msg[0];
        if($msg[0]=="SUC") echo $msgEmbed;
	}
?>