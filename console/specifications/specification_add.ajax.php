<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  console/specifications/specification_add.ajax.php   '
  '    PURPOSE         :  add specification page of the specification section '
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
  	require_once($objCore->_SYS['PATH']['CLASS_SPECIFICATION']);
	require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
	
	if(!is_object($objSpecification))
	{
		$objSpecification= new Specification;
	}

	if(!is_object($objManufacturer))
	{
        require_once($objCore->_SYS['PATH']['CLASS_MANUFACTURER']);
		$objManufacturer= new Manufacturer;
        $manList=$objManufacturer->dList(" WHERE status='Y'");
        
	}

	if(!is_object($objCategory))
	{
		$objCategory = new Category();
	}
	
	$module = "specification";
	$function = "addSpecification";
	
  	if($objCore->isAllowed($module, $function))
	{
		$arrParentId = explode('_',$_REQUEST['ids']);
				
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



         
?>

<div id="toolbar-box">
<div class="t"></div>
<div class="m">

<!-------------- Function form----------->

	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset id="page-middle-middle-content">
	  <legend>Add New Specification  </legend>
	  <table class="admintable" width="470">
	    <tr>
	      <td class="key" align="right">Subcategory</td>
	      <td><?php echo $subcategory_list[0][3];?></td>
        </tr>
	    <tr>
          <td class="key" align="right">Product<span class="required_fields">*</span></td>
          <td><input name="specification" class="text_area" id="specification" size="90" type="text" maxlength="500<?php //echo $objSpecification->getMaxLength();?>" value="<?php echo str_replace('-amp;','&',$_POST['specification']);;?>"/></td>
	    </tr>
            
            
                    <tr>
          <td class="key" align="right">Specification</td>
         <td><textarea name="specification_desc" class="text_area" id="specification_desc" style="width:300px; height:50px"><?php echo str_replace('-amp;','&',$_POST['specification_desc']);?></textarea></td>
	   </tr>
		<tr>
		  <td class="key" align="right">Description</td>
		  <td><textarea name="description" class="text_area" id="description" style="width:300px; height:50px"><?php echo str_replace('-amp;','&',$_POST['description']);?></textarea></td>
	    </tr>
            
		<tr>
		  <td class="key" align="right">Keywords <span class="required_fields">*</span></td>
		  <td>
		    <textarea name="keywords" class="text_area" id="keywords" style="width:180"><?php echo str_replace('-amp;','&',$category_list[0][3]."\n".$subcategory_list[0][3]);?></textarea>
		     <br />
		  * Please fill keywords to relevant Specification</td>
		  </tr>
		<tr>
		  <td class="key" align="right">Manufacturer <span class="required_fields">*</span></td>
		  <td>
              <table>
                <tr>
                    <td><strong>All Manufacturers</strong>
                        <select name="available" style="width:180px;height:250px;" size="15" id="available" onFocus="populate(event)" onKeyDown="setSelection(event)" onKeyPress="javascript:return false">
                          <?php
                            for($s=0;$s<count($manList);$s++){?>
                                <option value="<? echo $manList[$s][0];?>"><? echo $manList[$s][1];?></option>
                          <? }?>
                        </select>
                    </td>
                    <td style="vertical-align:middle;">
                        <input type="button" name="Button" value="  &gt;&gt; " onClick="moveOver()"><br/><br/>
                        <input type="button" name="Submit2" value="  &lt;&lt; " onClick="moveBack()">
                    </td>
                    <td>    <strong>Selected Manufacturers</strong>
                            <select name="choiceBox" style="width:180px;height:250px;"   size="15" id="choiceBox" onFocus="populate(event)" onKeyDown="setSelection(event)" onKeyPress="javascript:return false" >
                            </select>
                    </td>
                </tr>
              </table>



                    

	    </tr>
		<tr>
	      <td class="key" align="right" width="131">&nbsp;</td>
	      <td width="327"><label>
<!--               <input type="hidden" name="keyName" value="" id="keyName"/>-->
	        <input type="button" name="Submit" value="Add" onclick="addSpecData();"/>
	      </label></td>
	    </tr>
	  
	</form>
<tr id="imgUpload">
                        <td class="key" align="right">Image</td>
                        <td>
                <!--
                  Display loading image.
                -->
                            <div id="divProcess">
				Uploading Image...
                            </div>
                 <!--
                   Image is uploaded and display in this div.
                -->
                            <div id="uploadingImg"></div>
                <!--
                   Display zoom icon in here.
                -->
                            <div id="zooming" style="display:none">
                                <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','spec');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
                            </div>
                <!--
                  Use this form to display file browse part.
                -->
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
                                 <input type="hidden" name="keyName" value="" id="keyName"/>
                                <input type="hidden" name="imgFolder" value="specs" id="imgFolder"/>
                                <input type="file" name="filename" onchange="getFieldNames('keyName','sleeker','zooming'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg','divProcess'); this.value=''; return true;" />
                            </form>
</tbody></table>
	  </fieldset>
<!--<input name="image" class="text_area" type="file" id="image" size="22"/> -->
                        </td>
                    </tr>
<!--------------END Function form----------->

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
 }  
?>