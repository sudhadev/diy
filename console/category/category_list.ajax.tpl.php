<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Sadaruwan Hettiarachchi <sadaruwan@fusis.com>       '
  '    FILE            :  console/category/category_add.tpl.php               '
  '    PURPOSE         :  add users page of the user section                  '
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
			$objCategory = new Category();
	}
       
	$module = "category";
	$function = "addCategory";
	
  	if($objCore->isAllowed($module, $function))
	{
		if($msg)
		{
			echo $objCore->msgBox("CATEGORY",$msg,'75.99%');	
		}
?>
	

<?php
	//echo $objCategory->getTopcList('drop','topclist','text_area',$_REQUEST['topclist'],' onchange="javascript:this.form.submit();"') ;      
$topCategs = array_values($objCategory->getTopcList()); 
if(!empty($_REQUEST['pcat'])){$pcat = $_REQUEST['pcat']; }else{$pcat = (!empty($_REQUEST['topclist']))? $_REQUEST['topclist'] : $topCategs[0]['id']; } 
$tcat = (!empty($_REQUEST['topclist']))? $_REQUEST['topclist'] : $topCategs[0]['id'];
$PCpath = $objCategory->getParentCpath($pcat);
			for($n=0;$n<count($PCpath);$n++)
			{
			$cparent[] = $PCpath[$n]['category'];
			}
?>



<?php 
	$list = array_values($objCategory->getSubcList($pcat,$type='sub_arr'));
	
	if($list == null)
	{
		$msg=array('ERR','NOT_EXIST_CAT');
		$i=1;
               
		if($msg)
		{
			echo $objCore->msgBox("CATEGORY",$msg,'75.99%')."||".$i;
		}
                
	} else
	{
             

?>
<div id="toolbar-box">
<div class="t"></div>
<div class="m">

<fieldset id="page-middle-middle-content">
<legend>Category List <?php echo "(".implode(" <b>></b> ", $cparent).")"; ?></legend>
<table  cellspacing="1" class="adminlist" width="100%">
  <thead>
    <tr>
      <th width="2%" height=""> # </th>
     
	   <th width="35%" class="title"> <a href="#"></a> <a href="#">Category</a></th>
	<th width="48%" class="title"> <a href="#">Description</a> </th>
	<th width="5%" class="title">&nbsp;</th>
	<th width="5%" class="title">&nbsp;</th>
	<th width="5%" class="title">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <!-- Retriew data from database and display the data corresponding fields -->
    <?php 
		
		for($n=0;$n<count($list);$n++)
		{
		$rowNo=$n+1;
		$href = ($list[$n]['next1'])? $objCore->_SYS['CONF']['URL_CONSOLE']."/category/?plevel=0&pcat=".$list[$n][0]."&topclist=".$_REQUEST['topclist'] : '#';
		$jmsg =  ($list[$n]['next1'])? "": "onclick=\"alert('This Category Has No Sub Categories.')\"";
		/*if($topCategs[0]['levels']>$list[$n][2])
		{
			$addhref = "topclist=".$list[$n][0]."_".$list[$n][2]."&tcat=".$tcat."&plevel=".$list[$n][2];
			$objCore->_SYS['CONF']['URL_CONSOLE']."/category/?f=add&topclist=".$list[$n][0]."_".$list[$n][2]."&tcat=".$tcat."&plevel=".$list[$n][2];
		}else
		{
			"#"
		};*/
		$addimg = ($topCategs[0]['levels']>$list[$n][2])? "add.png" :"add-gray.png";
		$addToolTipText = ($topCategs[0]['levels']>$list[$n][2])? "Add" :"";
		$edithref = $objCore->_SYS['CONF']['URL_CONSOLE']."/category/?f=edit&id=".$list[$n][0];
		$delhref = $objCore->_SYS['CONF']['URL_CONSOLE']."/category/?action=delete&id=".$list[$n][0]."&level=".$list[$n][2];
		
		if($topCategs[0]['levels']>$list[$n][2])
		{
			$add = $list[$n][2]."_".$list[$n][0];
			$imgShow = "notshow";
		} else
		{
			$add = "no_id";
			$imgShow = "show";
		}
		
		?>
    <tr class="row0">
      <td align="center"><?php echo $rowNo; ?></td> 
	  <td align="left">
	  <?php
	  if($imgShow == "show")
	  {
	   	$imgUrl = $objCategory->image($list[$n][9],$objCore->_SYS['CONF']['FTP_CATS'],$objCore->_SYS['CONF']['URL_IMAGES_CATS']);
	  ?>
	  	<img src="<?php echo $imgUrl;?>" width="50"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $list[$n][3];?><br />
	<?php 
	  	if($list[$n][9] != "")
	  	{
	?>
		  <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $list[$n][9]; ?>','categ');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
	<?php 
	  	} else
	 	 {
	 ?> 
	 	 <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','no_image.jpg','categ');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
	<?php 
		}
	} else
	{
		echo $list[$n][3];
	}
	?>
	 
	  </td>
	<td align="left"><?php echo $list[$n][4];?></a></td>
	<td align="center"><a href="javascript:add('<?php echo $add;?>');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/<?php echo $addimg;?>" title="<?php echo $addToolTipText;?>" alt="<?php echo $addToolTipText;?>" /></a></td>
	<td align="center"><a href="javascript:edit('<?php echo $list[$n][0]; ?>')"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/edit.png"  title="Edit" alt="Edit"/></a></td>
	<td align="center"><a href="javascript:del('<?php echo $list[$n][0]."_".$list[$n][2];?>','<?php echo true;?>','<?php echo "cat";?>');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/delete.png" title="Delete" alt="Delete"/></a></td>
    </tr>
    <?php }?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="12"><del class="container">
        <div class="pagination">
          
        </div>
      </del> </td>
    </tr>
  </tfoot>
</table>
</fieldset>

<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>

<?php 
	}
}
?>
	

