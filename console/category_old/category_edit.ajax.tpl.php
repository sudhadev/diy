<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Sadaruwan Hettiarachchi <sadaruwan@fusis.com>         '
  '    FILE            :  console/category/category_add.tpl.php                      '
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
	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
        
	if(!is_object($objCategory))
	{
            $objCategory = new Category();
	}
         if(!is_object($objComponent))
	{
		$objComponent = new Component();
	}

	
	$module = "category";
	$function = "editCategory";
	
  	if($objCore->isAllowed($module, $function))
	{
		if($msg)
		{
			echo $objCore->msgBox("CATEGORY",$msg,'96%');
		} 
		
		if(!empty($_REQUEST['ids']))
		{    
			$cData = $objCategory->getCategory($_REQUEST['ids']) ;

		}


        // check parent category status
           $categUpperLevel = $objCategory->getCategory($cData['parent']) ;


?>

<div id="toolbar-box">
<div class="t"></div>
<div class="m">
<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset id="page-middle-middle-content">
	  <legend>Edit Category  </legend>
	  <table class="admintable" width="100%">
      <?php   if($categUpperLevel['status']!="Y"){
          ?>
	   <tr><td colspan="2" style="color:red;"><strong>* Parent Category   ( <?php echo $categUpperLevel['category'];?> ) of this Category is not in the Active mode.</strong><br/> If you need to keep this category in Active mode, please make sure to keep the Parent category also in the Active mode.
       <input type="button" value=" Click Here to go to the Parent Category " onclick="edit('<?php echo $cData['parent'];?>','<?php echo $_REQUEST['extValues']?>')"/></td></tr>
	    <tr>
        <?php }?>
          <td class="key" align="right">Category Name<span class="required_fields" width="150">*</span></td>
	  <td width="80%"><input name="cname" class="text_area" id="cname" size="30" type="text" value="<?php echo $cData['category'];?>"/></td>
        </tr>
	
		<tr>
          <td class="key" align="right">Parent Category<span class="required_fields">*</span></td>    
	      <td><? $PCpath = $objCategory->getParentCpath($cData['parent']); 
			for($n=0;$n<count($PCpath);$n++)
			{
			$parent[] = $PCpath[$n]['category'];
			}
		echo implode(" <b>></b> ", $parent);
		?></td>
        </tr>
		
		<?php 
			if($cData['level']== 2)
			{
		?>	
		
	  <tr>
	 	 <td class="key" align="right">Image</td>
		 <td>
                    <div id="divProcess">
                        Uploading Image...
                    </div>
                    <div id="uploadingImg">
                          <?php
                                $imgUrl = $objCategory->image($cData['image'],$objCore->_SYS['CONF']['FTP_CATS'],$objCore->_SYS['CONF']['URL_IMAGES_CATS']);
                          ?>
                          <img src="<?php echo $imgUrl;?>" width="60"/>&nbsp;
                          <br />
                        <?php
                            if($cData['image'] != "") {
                        ?>
                        <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $cData['image']; ?>','categ');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
                             <!-- Dlete Image -->
                            <?php 
                              $pos = strrpos($imageQuote, "no_image.jpg");
                              if ($pos === false) { // note: three equal signs
                             ?>  
                             <a href="javascript:delImage('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/delete.ajax.php','categ','<?php echo $cData['image'];?>','<?php echo $objCore->sessUId;?>','0');" title="Delete Image" style="text-decoration:none"><img alt="delete" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/delete_img_str.png" border="0"  /> </a>
                              <?php  }// end of $pos
                            ?>
                            <!-- / Delete Image -->
                        <?php
                            }else
                            {
                        ?>
                        <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','no_image.jpg','categ');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
                        <?php
                            }
                        ?>
                      <br />
                  </div> 

                     <div id="zooming" style="display:none">
			<a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
                    </div>  
                    <form action="" method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
                        <input type="hidden" name="maxSize" value="9999999999" />
                        <input type="hidden" name="maxW" value="200" />
                        <input type="hidden" name="fullPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>" />
                        <input type="hidden" name="relPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>" />
                        <input type="hidden" name="colorR" value="255" />
                        <input type="hidden" name="colorG" value="255" />
                        <input type="hidden" name="colorB" value="255" />
                        <input type="hidden" name="maxH" value="300" />
                        <input type="hidden" name="filename" value="filename" />
                        <input type="hidden" name="imgFolder" value="cats" id="imgFolder"/>
                        <input type="file" name="filename" onchange="getFieldNames('keyName','adminForm','zooming'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg','divProcess'); this.value=''; return true;" />
                    </form>
		</td>
	  </tr>
	  
	  <?php	
            }
          ?>
	  
	  
	<tr>
              <td class="key" align="right">Category Description</td>
	      <td><textarea id="cdescription" class="text_area" rows="3" cols="40" name="cdescription" ><?php echo $cData['description'];?></textarea></td>
        </tr>
	<tr>
              <td class="key" align="right">Category Status<span class="required_fields">*</span></td>
	      <td>
                  <?php
                    if($_REQUEST['status'] == "plist" && $_REQUEST['selec'] != "Y")
                    {
                        echo $objComponent->drop('cstatus', $cData['status'], array(
                            "P"=>"Pending",
                            "Y"=>"Active",
                            "D"=>"Deleted",
                            "R"=>"Rejected",
                        ), '', '');

                    } else
                    {
                   ?>
                  <select class="cstatus" name="cstatus" id="cstatus">
			<option  value="Y" <?php echo ( $cData['status']=="Y")? selected : '' ; ?>>Show</option>
			<option value="P" <?php echo ( $cData['status']=="P")? selected : '' ; ?> >Hide</option>
		  </select>
                  <?php
                    }
                  ?>
             </td>
        </tr>

		<tr> 
	      <td class="key" align="right" width="131">&nbsp;</td>
	      <td width="327"><label>
		  <input type="hidden" name="keyName" value="<?php echo $cData['image'];?>" id="keyName"/>
		  <input type="hidden" name="extValues" value="<?php echo $_REQUEST['extValues']?>" id="extValues"/>
          <?php
             $splExtVals=explode("-sep-",$_REQUEST['extValues']);
            //chelanga new code change
             $temp_ids = $cData['level'].'_'.$cData['parent'];
             //end
          ?>

                 <!-- Changed by chelanga!! -->
	     <!-- <input type="button" name="Back" value=" Cancel " onclick="getId_Cat_pending('<?php echo $splExtVals[0];  ?>','<?php echo $splExtVals[1];?>','');"/> -->
         <?php 
		 $encode_category = urlencode($cData['category']);
		 ?>
                  <input type="button" name="Back" value=" Cancel " onclick="getId('<?php echo $temp_ids;  ?>');"/>
	      <input type="button" name="Submit" value="Edit" onclick="editData('<?php echo $encode_category;?>','<?php echo $cData['id']; ?>','<?php echo $cData['parent']; ?>','<?php echo $cData['level'] ;?>');"/>

	      </label></td>
	    </tr>
	 
	  </table>
	  </fieldset>


<!--------------END Function form----------->

<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
<?php } ?>

	

