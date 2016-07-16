<?php
  /*---------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS            '
  '    (C) Copyright 2004 www.fusis.com                                        '
  ' .......................................................................... '
  '                                                                            '
  '    AUTHOR          :  Lakshyami Nanayakkara     '
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
	require_once($objCore->_SYS['PATH']['CLASS_MANUFACTURER']);
        
	if(!is_object($objSpecification))
	{
		$objSpecification= new Specification($objCore->gConf);
	}
	
	if(!is_object($objCategory))
	{
		$objCategory = new Category();
        $catList=$objCategory->getTopcList();
	}
        if(!is_object($objManufacturer))
	{
		$objManufacturer = new Manufacturer();
	}
	
	$module = "specification";
	$function = "listpecification";
	
  	if($objCore->isAllowed($module, $function))
	{
         
		$arrParentId = explode('_',$_REQUEST['ids']);
        $objSpecification->ajaxPgBarFunction="javascript: getPendingSpecifations('".$arrParentId[0]."' , '".$_REQUEST['orderBy']."','{%PG%}');";
		$list=$objSpecification->get_dList_pending($arrParentId,$_REQUEST['selec'],$_REQUEST['orderBy'],$_REQUEST['pg']);
     

//		if(count($arrParentId) <= 2)
//		{
//			if(count($arrParentId) == 1)
//			{
//				$parent = $objSpecification->get_dList_parent($arrParentId[0]);
//			} else
//			{
//				$parent = $objSpecification->get_dList_parent($arrParentId[1]);
//			}
//			if($parent == "")
//			{
//				$msg=array('ERR','NOT_EXIST_CAT');// Add new Category
//				$i=1;
//			} else
//			{
//				//$msg=array('ERR','SELECT'); // Please Select a Category
//				//$i=0;
//			}
//			if($msg)
//			{
//				echo $objCore->msgBox("SPECIFICATION",$msg,'75.99%')."||".$i;
//			}
//		} else
//		{
//			$subcategory_list = $objSpecification->get_dList_subcategory($arrParentId[2]);
//			$category_list = $objSpecification->get_dList_subcategory($arrParentId[1]);
//			//$cArray = array_values($objCategory->getTopcList());
//			if($arrParentId[0] != 1)
//			{
//				$msg=array('ERR','CANNOT_ADD'); // can not add specifications for building services and classified ads.
//				$i=3;
//				if($msg)
//				{
//					echo $objCore->msgBox("SPECIFICATION",$msg,'75.99%')."||".$i;
//				}
//			} else
//			{
//				if($list=="")
//				{
//					$msg=array('ERR','NOT_EXIST_SPEC'); // no specifications for the selected category.
//					$i=2;
//					if($msg)
//					{
//						echo $objCore->msgBox("SPECIFICATION",$msg,'75.99%')."||".$i;
//					}
//				} else
//				{


  
?>
<div style="text-align:right;margin-right:15px;"><?php echo $objSpecification->pgBar; ?></div>

	<div id="specification_list">
  <fieldset  id="page-middle-middle-content">
	  <legend>Specification List - Pending for Approval ( <?php echo $catList[$arrParentId[0]]['category'];?> )</legend>


      <table  cellspacing="1" class="adminlist" width="100%">
  <thead>
    <tr>
      <th width="30" height="22"> # </th>
      <th width="150" nowrap="nowrap" class="title" align="left"><a  href="#">Specification</a></th>
      <th width="" nowrap="nowrap" class="title" align="left"><a  href="#">Description</a></th>
      <th width="230" nowrap="nowrap" class="title" align="left"><a  href="#">Parent Categories</a></th>
     <?php if($_REQUEST['selec'] != "Y"){ ?>

      <th width="150" nowrap="nowrap" class="title" align="left"><a  href="#">Requested By</a></th>
      <th width="130" nowrap="nowrap" class="adminlistRight" align="right"><a  href="#">Requested Time</a></th>
      <?php }?>
      <th width="5%" class="title">&nbsp;</th>
	
       
    </tr>
  </thead>
  <tbody>
    <!-- Retriew data from database and display the data corresponding fields -->
    <?php 
		for($n=0;$n<count($list);$n++)
		{
			$rowNo=$n+1;
            $categSecond = $objCategory->getCategory($list[$n][2]) ;
            $categThird = $objCategory->getCategory($list[$n][3]) ;
            
	?>
    <tr class="row0">
      <td align="center"><?php echo $rowNo; ?> </td>
      <td align="left"><?php echo $list[$n][4];?></td>
	  <td align="left"><?php echo $list[$n][5];?></td>

          <td align="left"><?php echo $categSecond['category']." <strong>></strong> ".$categThird['category'];?></td>
          <?php if($_REQUEST['selec'] != "Y"){ ?>
          <td align="left"><?php echo $list[$n][7];?></td>
          <td align="right"><?php echo date($objCore->gConf['DATE_FORMAT']." ".$objCore->gConf['TIME_FORMAT'],$list[$n][9]);?></td>
           <?php }?>
         <!--  -->

	  <td align="center">
			<a href="javascript:edit_spec_tpl('<?php echo $list[$n][1]."_".$list[$n][2]."_".$list[$n][3]."_".$list[$n][0];?>','<?php echo $list[$n][8];?>',<?php echo $_REQUEST['pg'];?>)">
                            <img height="13" width="12" alt="Moderate" title="Moderate" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/moderate.png"/>
                        </a>
		</td>
	
    </tr>
    <?php }?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="14"><del class="container">
        <div class="pagination">        </div>
      </del> </td>
    </tr>
  </tfoot>
</table>
	  </fieldset>
</div>
	  <?php
//	  	  }
//	  	}
//	  }
	 }
	?>