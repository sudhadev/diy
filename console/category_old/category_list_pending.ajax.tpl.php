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
        require_once($objCore->_SYS['PATH']['CLASS_MANUFACTURER']);

        $topCategory=$_REQUEST['ids']; 
        $selList=$_REQUEST['selec'];
        
	if(!is_object($objCategory))
	{
            $objCategory = new Category();
	}

        if(!is_object($objManufacturer))
	{
            $objManufacturer = new Manufacturer();
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
	//$list = array_values($objCategory->getSubcList($pcat,$type='sub_arr_status','','','','',$_REQUEST['selec'],$_REQUEST['orderBy']));
   
    $list=$objCategory->get_dList_pending('1', $_REQUEST['selec'], $_REQUEST['orderBy']);  $objCategory->dev=false;
//        if($_REQUEST['orderBy'] == "requested_by")
//        {
//            for($k=0;$k<count($list);$k++)
//            {
//                $reqBy = $objManufacturer->getUserName($list[$k][7]);
//                $list[$k][]= $reqBy;
//            }
//            $list = $objCategory->sortArry($list,$_REQUEST['orderBy']);
//        }
//print_r($list);echo "<br/>";echo $_REQUEST['selec'];echo "<br/>";echo$topCategory;
        if($list == null)
	{
		$msg=array('ERR','NOT_EXIST_PENDING');
		$i=1;
		if($msg)
		{
			echo '<div id="page_body_deflt">Pending list is empty </div>'."||".$i;
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
     
	<th width="200" class="title"> <a href="#">Category</a></th>
	<th width="200" class="title">  <a href="#">Parent Categories</a></th>
	<th width="" class="title"> <a href="#">Description</a> </th>
        <?php if($_REQUEST['selec'] != "Y"){ ?><th width="150" class="title"> <a href="#">Requested By</a> </th><?php }?>
	<?php if($_REQUEST['selec'] == "Y"){ ?><th width="5%" class="title">&nbsp;</th><?php }?>
	<th width="5%" class="title">&nbsp;</th>
	
    </tr>
  </thead>
  <tbody>
    <!-- Retriew data from database and display the data corresponding fields -->
    <?php 
		$showCount=0;
		for($n=0;$n<count($list);$n++)
		{
		
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

        // Parent Categories
        /*this is not the exactly correct way to do this requirenment
         * but as Jason needed this and the there was a time constratins
         * this is the most possible way.
         * this code may be need future enhancemnts -saliya
         * 
         */
            $categUpperLevel = $objCategory->getCategory($list[$n][1]) ;
            if($categUpperLevel['level']!=0)
            {
                $categTopLevel = $objCategory->getCategory($categUpperLevel['parent']) ;
                $displayCat= $categTopLevel['category']." > ".$categUpperLevel['category'];
                $mostTopCat=$categTopLevel['id'];
            }
            else
            {
                 $displayCat= $categUpperLevel['category'];
                 $mostTopCat=$categUpperLevel['id'];
            }

            // logic is broken here with intention that there may be lots of logics
            // which can apply with this 
            if($topCategory && ($topCategory!=$mostTopCat))
            {
                $displayRow=false;
            }
            else
            {
                $displayRow=true;$showCount++;
            }
//$displayRow=true;


            // Control the display the data
            if($displayRow){
                $rowNo++;
     
		?>
                <tr class="row0">
                  <td align="center"><?php echo $rowNo; ?></td>
                  <td align="left">
                  <?php
//                  if($imgShow == "show")
//                  {
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
//                } else
//                {
//                    echo $list[$n][3];
//                }
                ?>

                  </td>
                <td align="left">
                <?php
                // Display parent categories
                    echo $displayCat;


                ?>
                </td>

                <td align="left"><?php echo $list[$n][4];?></td>
                    <?php if($_REQUEST['selec'] != "Y"){ ?>
                    <td align="left">
                        <?php


            //                $reqBy = $objManufacturer->getUserName($list[$n][7]);
            //                echo $reqBy;
                            echo $list[$n][7];
                        ?>
                    </td>
                    <?php }?>
                <?php if($_REQUEST['selec'] == "Y"){ ?>
                        <td align="center"><a href="javascript:add('<?php echo $add;?>');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/<?php echo $addimg;?>" title="<?php echo $addToolTipText;?>" alt="<?php echo $addToolTipText;?>" /></a></td>
                <?php }?>
                     <td align="center">
                      <?php
                        // set extra value to pass
                        $extValues= $topCategory."-sep-".$selList; 

                      ?>
                        <a href="javascript:edit('<?php echo $list[$n][0]; ?>','<?php echo $extValues;?>')">
                            <img height="13" width="12" alt="Moderate" title="Moderate" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/moderate.png"/>
                        </a>
                    </td>
                </tr>
        <?php } // display row end?>
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
	

