<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara        '
  '    FILE            :  console/specification/specification_edit.ajax.php   '
  '    PURPOSE         :  edit specification page of the specification section'
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
	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
    require_once($objCore->_SYS['PATH']['CLASS_MANUFACTURER']);

	if(!is_object($objSpecification))
	{
		$objSpecification= new Specification;
	}
	
	if(!is_object($objCategory))
	{
		$objCategory = new Category();
	}
        
    if(!is_object($objComponent))
	{
		$objComponent = new Component();
	}

    if(!is_object($objListing))
	{
		require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
        $objListing = new Listing();
	}


	if(!is_object($objManufacturer))
	{
        require_once($objCore->_SYS['PATH']['CLASS_MANUFACTURER']);
		$objManufacturer= new Manufacturer;
        // get all the manufacturers
        $manList=$objManufacturer->dList(" WHERE status='Y'");

	}
        
	$module = "specification";
	$function = "editSpecification";
	
  	if($objCore->isAllowed($module, $function))
	{
		/**
		* check the listings available for specific specification. 
		*/
		$arrParentId = explode('_',$_REQUEST['ids']);
		$manufacturer = $_REQUEST['manu'];
		$listingAvailable=$objSpecification->checkListings($arrParentId);
                /**
                * Call to dList funtion and take correspond values that match with ID into a $list array
                */
                $list=$objSpecification->get_dList_edit($arrParentId);
                
                $cData = $objCategory->getCategory($arrParentId[2]) ;

             //   $subcategory_list = $objSpecification->get_dList_subcategory($arrParentId[2]);
             //   $category_list = $objSpecification->get_dList_subcategory($arrParentId[1]);

                $categSecond = $objCategory->getCategory($arrParentId[1]) ;
                $categThird = $objCategory->getCategory($arrParentId[2]) ;


    /*
     * Now we need all the listings available for each manufacture for the selected category
     */    
            $listCounts=$objListing->getListingCountsBySpecManufact($arrParentId[3]);
            if(is_array($listCounts)) $listCountsKeys=array_keys($listCounts);// listing available manufacture ids are in this array
            if(!is_array($listCountsKeys)) $listCountsKeys=array();
    /*
     * prepare the list box for selected manufacturers
     */
        // Get the manufacturer list for selected specification
        $manListForSpec=$objManufacturer->getListForASpecifcation($arrParentId[3]);
        for($ms=0;$ms<count($manListForSpec);$ms++)
        {
            $manListForSpecKeys[]=$manListForSpec[$ms][0];// all assigned  manufacture keys
            $manListForSpecValues[]=$manListForSpec[$ms][1]; // all assigned manufacture values
            $manListKeyValue[$manListForSpec[$ms][0]]=$manListForSpec[$ms][1]; // we need key, value pare for use in the wish list
          
            if(!in_array($manListForSpec[$ms][0],$listCountsKeys))
            {
                $manListEditableKeys[]=$manListForSpec[$ms][0];
            }
            else
            {
               
                $manListNonEditableKeys[]=$manListForSpec[$ms][0];
            }

        }


///print_r($_REQUEST);
?>

<div id="toolbar-box">
<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
</div>
			<div class="m">

<!-------------- Function form----------->

	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset id="page-middle-middle-content">
	  <legend>Edit Specification (<?php if($categSecond['category']) {echo $categSecond['category'];}else{echo "<font color=\"#F00\"><i>Not Available</i></font>";}?> > <?php if($categThird['category']) {echo $categThird['category'];}else{echo "<font color=\"#F00\"><i>Not Available</i></font>";}?>)</legend>
	  <table class="admintable" width="600">
              <?php
              /*
              if($listingAvailable)
		{
			/**
			* Display the error messages
			*
			$msg=array('ERR','EXIST_LISTINGS_SPEC');
			$i=1;
                ?>


        <tr>
	      <td class="key" align="right">Specification</td>
              <td><label id="specification"><?php echo $list[0][4]; ?></label></td>
        </tr>
	<tr>
          <td class="key" align="right">Description</td>
	      <td><label id="description"><?php
                  if($list[0][9] == "")
                  {
                      echo "-";
                  } else
                  {
                      echo $list[0][9];
                  }
              ?></label></td>
        </tr>
	    <tr>
          <td class="key" align="right">Average Price</td>
	      <td><label id="average_price"><?php
                  if($list[0][6] == "")
                  {
                      echo "-";
                  } else
                  {
                      echo $list[0][6];
                  }
              ?></label></td>
        </tr>
    
        <tr>
          <td class="key" align="right">Manufacturer</td>
          <td><label id="manufacturer"><?php
                  if($manufacturer == "")
                  {
                      echo "-";
                  } else
                  {
                      echo $manufacturer;
                  }   
                  ?></label>
          </td>
        </tr>
       

        <tr>
          <td class="key" align="right">Keywords </td>
          <td>
            <textarea name="keywords" class="text_area" id="keywords" style="width:180"><?php echo $list[0][10];?></textarea>
            <br />
          * Please fill keywords to relevant Specification</td>
          </tr>
<tbody>
		<tr>
	      <td class="key" align="right" width="131">&nbsp;</td>
	      <td width="327"><label>

	        <input type="button" name="Submit" value="Edit" onclick="editSpecData('<?php echo $list[0][1]."_".$list[0][2]."_".$list[0][3]."_".$list[0][0];?>','notAll');"/>

	      </label></td>
	    </tr>
	  </tbody></table>
	  </fieldset>
	</form>

<!--------------END Function form----------->

<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>


              <?php
                    if($msg)
                    {
                        echo "||".$i."||".$objCore->msgBox("SPECIFICATION",$msg,'75.99%');
                    }

		} else
		{*/
              ?>




	    <tr>
	      <td class="key" align="right">Product<span class="required_fields">*</span></td>
	      <td><?php if($listingAvailable){ echo $list[0][4];?><input name="specification" class="text_area" id="specification" size="90" type="hidden" value="<?php echo str_replace('-amp;','&',$list[0][4]); ?>"/> <?php }else{?><input name="specification" class="text_area" id="specification" size="90" type="text" value="<?php echo str_replace('-amp;','&',$list[0][4]); ?>"/><?php }?></td>
        </tr>
        
        <tr>
	 	 <td class="key" align="right">Image</td>
		 <td>
                    <div id="divProcess">
                        Uploading Image...
                    </div>
                    <div id="uploadingImg">
                          <?php
                                $imgUrl = $objCategory->image($list[0][12],$objCore->_SYS['CONF']['FTP_SPECS'],$objCore->_SYS['CONF']['URL_IMAGES_SPECS']);
                          ?>
                          <img src="<?php echo $imgUrl;?>" width="60"/>&nbsp;
                          <br />
                        <?php
                           // if($cData['image'] != "") {
                        ?>
                        <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $list[0][12]; ?>','specs');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
                             <!-- Dlete Image -->
                            <?php 
                              $pos = strrpos($imageQuote, "no_image.jpg");
                              if ($pos === false) { // note: three equal signs
                             ?>  
                             <a href="javascript:delImage('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/delete.ajax.php','specs','<?php echo $list[0][12]; ?>','<?php echo $objCore->sessUId;?>','0');" title="Delete Image" style="text-decoration:none"><img alt="delete" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/delete_img_str.png" border="0"  /> </a>
                              <?php  }// end of $pos
                            ?>
                            <!-- / Delete Image -->
                        <?php
                          //  }else
                            //{
                        ?>
<!--                        <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','no_image.jpg','categ');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>-->
                        <?php
                            //}
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
                        <input type="hidden" name="imgFolder" value="specs" id="imgFolder"/>
                        <input type="file" name="filename" onchange="getFieldNames('keyName','adminForm','zooming'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg','divProcess'); this.value=''; return true;" />
                    </form>
		</td>
	  </tr>
          <tr>
          <td class="key" align="right">Specification</td>
         <td><textarea name="specification_desc" class="text_area" id="specification_desc" style="width:300px; height:50px"><?php echo str_replace('-amp;','&',$list[0][13]);?></textarea></td>
	   </tr>
	    <tr>
          <td class="key" align="right">Description</td>
	      <td><textarea name="description" class="text_area" id="description" style="width:300px; height:50px"><?php echo str_replace('-amp;','&',$list[0][9]); ?></textarea></td>
        </tr>


        <tr>
          <td class="key" align="right">Manufacturer <span class="required_fields">*</span></td>
          <td>
                    <div style="padding-bottom:20px;vertical-align:bottom;" width="200">
                        * Please note that Suppliers may be added Listings for these Manufacturers under the selected specification. As Removing such combinations will be directly effect the system.Therefore system will not allowed to change such Manufacturers and will be listed under 'Un-editable" list.
                    </div>
               <table>
                <tr>
                    <td><strong>All Manufacturers</strong><br/><br/>
                        <select name="available" style="width:180px;height:250px;" size="15" id="available" onFocus="populate(event)" onKeyDown="setSelection(event)" onKeyPress="javascript:return false">
                          <?php 
                            for($s=0;$s<count($manList);$s++){
                                
                                if(!in_array($manList[$s][0],$manListForSpecKeys))
                                {
                                ?>
                                <option value="<? echo $manList[$s][0];?>"><? echo $manList[$s][1];?></option>
                          <?    }// end if
                            } // end loop
                            ?>
                        </select>
                    </td>
                    <td style="padding-top:60px;vertical-align:top;">
                        <input type="button" name="Button" value="  &gt;&gt; " onClick="moveOver()"><br/><br/>
                        <input type="button" name="Submit2" value="  &lt;&lt; " onClick="moveBack()">
                    </td>
                    <td>
                        <strong>Selected Manufacturers</strong>
                        <br/><br/>* Editable
                            <select name="choiceBox" style="width:180px;height:110px;"   size="15" id="choiceBox" onFocus="populate(event)" onKeyDown="setSelection(event)" onKeyPress="javascript:return false" >
                              <?php
                                for($s=0;$s<count($manListEditableKeys);$s++){?>
                                    <option value="<? echo $manListEditableKeys[$s];?>"><? echo $manListKeyValue[$manListEditableKeys[$s]];?></option>
                              <? }?>
                            </select>
                        <br/>
                        *Non-Editable
                            <select name="unmovable" style="width:180px;height:110px;background-color:#eee;"   size="15" id="unmovable"  >
                              <?php
                                for($s=0;$s<count($manListNonEditableKeys);$s++){?>
                                    <option value="<? echo $manListNonEditableKeys[$s];?>"><? echo $manListKeyValue[$manListNonEditableKeys[$s]];?></option>
                              <? }?>
                            </select> 

                    </td>

                    </tr>
              </table>

              
              <input type="hidden" id="oldManufac" name="oldManufac" value="<?php echo $manufacturer;?>"/>
                <input type="hidden" id="pg" name="pg" value="<?php echo $_REQUEST['pg'];?>"/>

          </td>
        </tr>

        <tr>
          <td class="key" align="right">Keywords </td>
          <td>
            <textarea name="keywords" class="text_area" id="keywords" style="width:280px;height:100px;"><?php echo str_replace('-amp;','&',$list[0][10]);?></textarea>
            
            <input type="hidden" name="for_keywords" id="for_keywords" value="<?php echo $list[0][10];?>" />
                   
            
            <br />
          * Please fill keywords to relevant Specification</td>
          </tr>
          <?php
            if($_REQUEST['status'] == "plist")
            {
          ?>
             <tr>
              <td class="key" align="right">Status </td>
              <td>
                 <?php
                 //echo "----".$list[0][5];
                        echo $objComponent->drop('spec_status', $list[0][5], array(
                            "P"=>"Pending",
                            "Y"=>"Active",
                            "D"=>"Deleted",
                            "R"=>"Rejected",
                        ), '', '');
                 ?>
              </td>
             </tr>
          <?php
            }
          ?>
	    <tbody>
		<tr>
	      <td class="key" align="right" width="131">&nbsp;</td>
	      <td width="327"><label>
		 <input type="hidden" name="keyName" value="<?php echo $list[0][12];?>" id="keyName"/>
	        <input type="button" name="btnEdit" value="Edit" onClick="editSpecData('<?php echo $list[0][1]."_".$list[0][2]."_".$list[0][3]."_".$list[0][0];?>','all');"/>
	       <?php
                if($_REQUEST['status'] == "plist")
                {
/*	        <input type="button" name="btnback" value="Back" onClick="getId_Spec_pending('1','P','specification','<?php echo $_REQUEST['pg']?>');"/> */
               ?>
                <!--<input type="button" name="Submit" value="Back" onclick="editSpecData('<?php echo $list[0][1]."_".$list[0][2]."_".$list[0][3]."_".$list[0][0];?>','all');"/> -->
               <?php
                }
               ?>
                
	      </label>

              </td>
	    </tr>
	  </tbody></table>
	  </fieldset>
	</form>
 
<!--------------END Function form----------->

<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
<?php 
	//}
}
?>
	

