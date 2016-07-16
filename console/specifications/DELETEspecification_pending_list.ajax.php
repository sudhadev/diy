<?php
  /*---------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS            '
  '    (C) Copyright 2004 www.fusis.com                                        '
  ' .......................................................................... '
  '                                                                            '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>          '
  '    FILE            :  console/specification/specification_list.ajax.php     '
  '    PURPOSE         :  list specifications page of the specification section'
  '    PRE CONDITION   :  commented                                            '
  '    COMMENTS        :                                                       '
  '---------------------------------------------------------------------------*/
  
	require_once("../../classes/core/core.class.php");$objCore=new Core;
	
	/**
	* Display the logged user.
	*/
	$objCore->auth(0,true);
  
	/** 
	* Create an object to the Specification class.
	*/
  	require_once($objCore->_SYS['PATH']['CLASS_SPECIFICATION']);
	require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
	
	if(!is_object($objSpecification))
	{
		$objSpecification= new Specification;
	}
	
	if(!is_object($objCategory))
	{
			$objCategory = new Category();
	}
	
	$module = "specification";
	$function = "listpecification";
	
  	if($objCore->isAllowed($module, $function))
	{
		$arrParentId = explode('_',$_REQUEST['ids']);
		//$list=$objSpecification->get_dList($arrParentId,'Y','specification');
                $list=$objSpecification->get_dList_pending($arrParentId,'Y','specification');
		if(count($arrParentId) <= 2)
		{
			if(count($arrParentId) == 1)
			{
				$parent = $objSpecification->get_dList_parent($arrParentId[0]);
			} else
			{
				$parent = $objSpecification->get_dList_parent($arrParentId[1]);
			}	
			if($parent == "")
			{
				$msg=array('ERR','NOT_EXIST_CAT');
				$i=1;
			} else
			{
				$msg=array('ERR','SELECT');
				$i=0;
			}
			if($msg)
			{
				echo $objCore->msgBox("SPECIFICATION",$msg,'75.99%')."||".$i;
			}	
		} else
		{
			$subcategory_list = $objSpecification->get_dList_subcategory($arrParentId[2]);
			$category_list = $objSpecification->get_dList_subcategory($arrParentId[1]);
			$cArray = array_values($objCategory->getTopcList()); 
			if($arrParentId[0] == 3)
			{
				$msg=array('ERR','CANNOT_ADD');
				$i=3; 
				if($msg)
				{
					echo $objCore->msgBox("SPECIFICATION",$msg,'75.99%')."||".$i;
				}		
			} else
			{
				if($list=="")
				{
					$msg=array('ERR','NOT_EXIST_SPEC');
					$i=2;
					if($msg)
					{
						echo $objCore->msgBox("SPECIFICATION",$msg,'75.99%')."||".$i;
					}
				} else
				{
?>

	<div id="specification_list">
  <fieldset  id="page-middle-middle-content">
	  <legend>Specification List (<?php echo $category_list[0][3];?> > <?php echo $subcategory_list[0][3];?>)</legend>	


      <table  cellspacing="1" class="adminlist" width="100%">
        <thead>
          <tr>
            <th width="5%" height="22"> # </th>
            <th width="16%" nowrap="nowrap" class="title" align="left"><a  href="#">Specification</a></th>
            <th width="31%" nowrap="nowrap" class="title" align="left"><a href="#">Description</a></th>
            <th width="14%" nowrap="nowrap" class="adminlistRight" align="right"><a  href="#">Average Price (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>) </a></th>
            <th width="4%" class="title">&nbsp;</th>
            <th width="4%" class="title">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          <!-- Retriew data from database and display the data corresponding fields -->
          <?php 
         $printedArray=array();
		for($n=0;$n<count($list);$n++)
		{
			$rowNo=$n+1;
            
            if(!in_array($list[$n][4],$printedArray))
            {
            
	?>
          <tr class="row0">
            <td align="center"><?php echo $rowNo; ?> </td>
            <td align="left"><?php echo $list[$n][4];?></td>
            <td align="left"><?php echo $list[$n][5];?></td>
            <td align="right"><?php echo $list[$n][6];?></td>
			
            <td align="center"><a href="javascript:edit_spec_tpl('<?php echo $list[$n][1]."_".$list[$n][2]."_".$list[$n][3]."_".$list[$n][0];?>','<?php echo $list[$n][8];?>')"> <img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/edit.png" title="Edit" alt="Edit"/> </a> </td>
            <td align="center"><a href="javascript:del('<?php echo $list[$n][1]."_".$list[$n][2]."_".$list[$n][3]."_".$list[$n][0];?>','<?php echo true;?>','<?php echo "spec";?>');"> <img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/delete.png" title="Delete" alt="Delete"/> </a> </td>
          </tr>
          <?php 
                $printedArray[]=$list[$n][4];
            } // end if block            
          } // End loop
            ?>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="14"><del class="container">
              <div class="pagination"> </div>
            </del> </td>
          </tr>
        </tfoot>
      </table>
  </fieldset>
</div>
	  <?php
	  	  }
	  	}
	  }
	 }
	?>