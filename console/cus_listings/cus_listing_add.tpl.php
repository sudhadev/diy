<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  console/users/user_add.tpl.php                      '
  '    PURPOSE         :  add users page of the user section                  '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

 //echo "-------------------->".$_REQUEST['cusId'];
  if($_REQUEST['cusId']){ 
        $cusId=$_REQUEST['cusId'];
        //$cusId='407cgTDRtC49ObaSNiFkjuhrCY6bwW539HLGBPXUrjt247zyCEJMzq1305301352';

        $arrCusData=$objCustomer->getCustomerData($cusId); //print_r($arrCusData);
        if(!count($arrCusData)) { echo "Please select a valid Customer "; exit;}
  }
  


  
  //$objCategory->dev=true;
 
  if($_POST['catId'])
  { //$objSpecification->dev=true;
    $catId=$_POST['catId'];
  	$arrSpec=$objSpecification->dList("WHERE category_id_2='".$catId."'");//print_r($arrSpec);
  	$specDrop=$objSpecification->createDrop("specId",$arrSpec,"spec",'text_area',$_POST['specId']);
  	
  	// check for manufacturer
  	if($_POST['specId'])
  	{ 
  		$specId=$_POST['specId']; 
  		$arrMan=$objManufacturer->getListForASpecifcation($specId,true);
  		
  		
  		$manDrop=$objComponent->drop('manId','',$arrMan);
  		
  		$arrParentCpath=$objCategory->getParentCpath($catId); //print_r($arrParentCpath);
  		$parentId= $arrParentCpath[0]['id']."_".$arrParentCpath[1]['id']."_".$arrParentCpath[2]['id']."_".$specId;
  		
  		// spec list
      foreach ($arrSpec as $key=>$arrInfo){
        $arrSpecInfo[$arrInfo[0]]=array(
          'Name'=>$arrInfo[4]
          );
      }

      //print_r($arrSpecInfo);
  	}
  	
  }
  
?>

<!-- Display the error messages  -->

<?php 
	if($msg)
	{
		echo $objCore->msgBox("LISTING",$msg,'98.99%');
	}             	
?>
<script type="text/javascript">
	function doChanges(reset){
		//if(reset="y"){document.getElemebtById("").value="";}
		frm.submit();
	}

  function changeDelivery()
  { 
  
    if(document.getElementById("delivery").value==1)
    {
        document.getElementById("delRate").style.display="block";

    }else{
        document.getElementById("delRate").style.display="none";
    }
    
  }

</script>
<div id="toolbar-box">
<div class="t"></div>
			<div class="m">
<!-- filter---------------- -->
			<fieldset style="border:1px solid #CCCCCC" id="page-middle-middle-content">
<legend>Search</legend>
<form id="frm" action="" method="post">
    <?php echo $catList=$objCategory->getSubcList('1','add_drop_list_subcats','catId','text_area',$catId,'onChange="frm.submit();"');?>
    <?php echo $specDrop; ?>
    <input type="hidden" name="f" value="<?php echo $_REQUEST['f'];?>" />
     <input type="hidden" name="cusId" value="<?php echo $_REQUEST['cusId'];?>" />
    </form>
  </fieldset>
  
  <?php if($_POST['specId']){?>
<!-------------- Function form----------->

	  <fieldset  id="page-middle-middle-content">
	  <legend>Add Listing For :  <?php echo $arrCusData[0][2]?></legend>
	   <form  action="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload_bulk.php" method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
	  	  <table class="admintable" width="800">
	  <tbody>

        <tr>
        <td class="key" align="right" width="150">Category </td>
        <td width="327"><strong><?php echo $arrParentCpath[1]['category']." > ".$arrParentCpath[2]['category']?></strong></td>
        </tr>
                <tr>
        <td class="key" align="right">Specification</td>
        <td><strong><?php echo $arrSpecInfo[$_POST['specId']]['Name']?></strong></td>
        </tr>
        <tr>
	      <td class="key" align="right" width="243">Images </td>
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
                                <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','listings');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
                            </div>
                <!--
                  Use this form to display file browse part.
                -->
                           
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
                                <input type="hidden" name="imgFolder" value="listings" id="imgFolder"/>
                               	<input type="file" name="filename_1" /><br/>
                               	<input type="file" name="filename_2" /><br/>
                               	<input type="file" name="filename_3" /><br/>
                               	<input type="file" name="filename_4" />&nbsp;&nbsp;&nbsp;&nbsp;
                               	<input type="hidden" name="lUser"  value="<?php echo $cusId;?>"/>
                                <input type="button" value="Upload Images" name="Upload" onclick="getFieldNames('keyName','sleeker','zooming'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload_bulk.php','uploadingImg','divProcess'); this.value=''; return true;" />
                               
                            
                            </td></tr></tbody></table></form>
                            </tr></tbody></table>
	 	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data"> 
	 	
	  <table class="admintable" width="800">
	  <tbody>


                <tr>
	      <td class="key" align="right">Manufacturer</td>
	      <td><?php echo $manDrop;?></td>
        </tr>
                <tr>
	      <td class="key" align="right">Listing Title</td>
	      <td><input name="title" class="text_area" id="title" size="30" type="text" value="<?php echo $_POST['title'];?>"/></td>
        </tr>
                <tr>
        <td class="key" align="right">Product Description</td>
        <td><textarea name="description" class="text_area" id="description" cols="60" rows="5"><?php echo $_POST['description'];?></textarea>
        </td>
        </tr>
                <tr>
        <td class="key" align="right">Product Specification</td>
        <td><textarea name="list_spec" class="text_area" id="list_spec" cols="60" rows="5"><?php echo $_POST['list_spec'];?></textarea>
        </td>
        </tr>
                <tr>
        <td class="key" align="right">Product URL</td>
        <td><input name="list_url" class="text_area" id="key_words" size="60" type="text" value="<?php echo $_POST['list_url'];?>"/></td>
        </tr>

                <tr>
	      <td class="key" align="right">key words</td>
	      <td><input name="key_words" class="text_area" id="key_words" size="60" type="text" value="<?php echo $_POST['key_words'];?>"/></td>
        </tr>

        <tr>
	      <td class="key" align="right">Unit Cost</td>
	      <td><input name="unit_cost" class="text_area" id="unit_cost" size="30" type="text" value="<?php echo $_POST['unit_cost'];?>"/></td>
        </tr>
                <tr>
	      <td class="key" align="right">Bulk Discount</td>
	      <td><input name="bulk_discount" class="text_area" id="bulk_discount" size="30" type="text" value="<?php echo $_POST['bulk_discount'];?>"/></td>
        </tr>
                <tr>
	      <td class="key" align="right">Bulk Price</td>
	      <td><input name="bulk_price" class="text_area" id="bulk_price" size="30" type="text" value="<?php echo $_POST['bulk_price'];?>"/></td>
        </tr>
               <tr>
        <td class="key" align="right">Delivery</td>
        <td>
        <select name="delivery"  class="text_area" id="delivery" onChange="changeDelivery();">
            <option value="1" <?php if($_POST['delivery']==1){echo "selected";}?> >Yes</option>
            <option value="0" <?php if($_POST['delivery']==0){echo "selected";}?> >No</option>
        </select>
        <div id="delRate" style="display:<?php if($_POST['delivery']==1){echo "block;";}else{echo "none;";}?>">Delivery Rate <input name="delivery_rate" class="text_area" id="delivery_rate" size="30" type="text" value="<?php echo $_POST['delivery_rate'];?>"/></div>
        </td>
        </tr> 
                <tr>
	      <td class="key" align="right"></td>
	      <td></td>
        </tr>
                <tr>
        <td class="key" align="right">Listing Active</td>
        <td>
        <select name="list_active" class="text_area" id="list_active" >
            <option value="Y" <?php if($_POST['list_active']=="Y"){echo "selected";}?> >Yes</option>
            <option value="N" <?php if($_POST['list_active']=="N"){echo "selected";}?> >No</option>
        </select>
        </td>
        </tr>            	    	    
		<tr>
	      <td class="key" align="right" width="131">&nbsp;</td>
	      <td width="327">
	        <input type="submit" name="Submit" value="Add" />
	        <input type="hidden" name="action"  value="add"/>
	        <input type="hidden" name="parentId"  value="<?php echo $parentId;?>"/>
	        <input type="hidden" name="cusId"  value="<?php echo $cusId;?>"/>
	        <input type="hidden" name="imgNames" value="" id="imgNames"/>	          
	      </td>
	    </tr>
	  </tbody></table>	</form>
	  </fieldset>


<!--------------END Function form----------->
<?php }else{ ?>
<div id="page_body" style="width:100%">
 <div id="page_body_deflt" style="margin:10px;">
	 <!-- START CONTENT AREA -->  
	  Please Select a Category, then a specification to proceed
	 <!-- END CONTENT AREA -->   
 </div>
</div>
<?php }?>
<div class="clr"></div>
</div>
<div class="b">
	<div class="b">
		<div class="b"></div>
	</div>
</div>


	

