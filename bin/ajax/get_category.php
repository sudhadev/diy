<?php

  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  sadaruwan hettiarachchi <sadaruwan@fusis.com>   	  '
  '    FILE            :  /bin/ajax/contact_us_check_fields.ajax.php          '
  '    PURPOSE         :  provide contact_us for any section of the system    '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

	require_once("../../classes/core/core.class.php");$objCore=new Core;
	
	//Display the logged user.
  	$objCore->auth(1,false);

if(isset($_GET['parentId'])){
	
	
	include($objCore->_SYS['PATH']['CLASS_CATEGORY']);
	if(!is_object($objCategory))
        {
            $objCategory = new Category();
        }
		//$objCategory->dev=true;
		$id_arr = explode("_",$_GET['parentId']);

        if($_GET['spId']){
            $extSpId=explode("|spl|",$_GET['spId']);// Dont change the variable name
            $cArr=$objCategory->getCategoryByCustomerListing($extSpId[0], $_GET['treeLevels']-1);
        }
        else
        {
            $cArr = $objCategory->getSubcList($id_arr[(count($id_arr)-1)],'sub_arr');
        }
        
	
		for ($s=0;$s<count($cArr);$s++)
		{ 
			if($cArr[$s][0]) {?>
			<li><a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/my_account/my_listings<?php echo $extSpId[1];?>/?tids=<?php echo $_GET['parentId']."_".$cArr[$s][0];?>" cPath="<?php echo $_GET['parentId']."_".$cArr[$s][0];?>"><?php echo $cArr[$s][3];?></a>
			<? if($cArr[$s]['nextl'] && ($_GET['treeLevels'] > (count($id_arr)+1)) ) {?>
			<ul>
			<li parentId="<?php echo $_GET['parentId']."_".$cArr[$s][0];?>"><a href="#" >Loading...</a></li>
			</ul>
			<? } ?>
			</li>
	<?		}
		}

	
}

?>
