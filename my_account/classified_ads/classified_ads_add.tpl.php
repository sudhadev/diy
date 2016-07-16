<?php
 /*--------------------------------------------------------------------------\
    '    This file is part of shoping Cart in module library of FUSIS           '
    '    (C) Copyright 2004 www.fusis.com                                       '
    ' ..........................................................................'
    '                                                                           '
    '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
    '    FILE            :  console/category/category_add.ajax.tpl.php          '
    '    PURPOSE         :  add users page of the user section                  '
    '    PRE CONDITION   :  commented                                           '
    '    COMMENTS        :                                                      '
    '--------------------------------------------------------------------------*/

    $module = "Classified Ads";
    $function = "add classified ads";
    if($objCore->isAllowed($module, $function))
    {
        //$available_amount = $objClassifiedAd->count_db_val($objCore->sessCusId ,"Y");
        $clAdsValues=$objClassifiedAd->total_ads_price($objCore->sessCusId);
        $totAds = (int)$clAdsValues[0];
        $available_amount = $clAdsValues[1];
    
?>

<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar">
<!----------------------------------------------------------------------------------------------------->
                <div id="banner_add_cads">Add Classified Ads</div>
                
                <div id="text_area_add_cads">
                    <div class="common_text"><?php echo $pageContents['common_text_add']?> </div>
                </div>

                <div id="list_add_cads">
                    <div align="left">
                        
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="list_blackbg_summery">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="47%">
                                                <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  >
                                                    <tr>
                                                        <td width="13" height="30"></td>
                                                        <td height="30" width="206" class="pgBar">Your total amount of active Ads is</td>
                                                        <td width="420" height="30" class="pbYellow">(<a class="pbYellow"><?php echo $objCore->_SYS['CONF']['CURRENCY']."  ".number_format(intval($available_amount),2);?> </a>)</td>
                                                        <td width="13"></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td height="16"></td>
                            </tr>
                            <tr>
                                <td><div class="add_classified_formmain">
                                        <div class="add_classified_formtop"></div>
                                        <div class="add_classified_formmiddle">
                                            <form id="Add_Classifieds" name="Add_Classifieds" method="post" action="<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>/my_account/classified_ads/index.php" enctype="multipart/form-data">
                                                    <!--
                                                      Display loading image.
                                                    -->
                                                    <div id="message_holder">
                                                            <div id="error_msg" style="margin-left: -8px; width: 630px;">
                                                                <?php 
                                                                    if($msg)
                                                                    {
                                                                        echo $objCore->msgBox("CLASSIFIED_ADS",$msg,'99%');
                                                                    } elseif($_REQUEST['msg1'] != "" && $_REQUEST['msg2'] != "")
                                                                    {
                                                                        $msg = array($_REQUEST['msg1'],$_REQUEST['msg2']);
                                                                        echo $objCore->msgBox("CLASSIFIED_ADS",$msg,'99%');
                                                                    }
                                                                ?>
                                                            </div>
                                                            <table width="80%" border="0" align="center">
                                                                    <tr>
                                                                        <td class="" style="padding-top:10px;"><div id="divProcess">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uploading Image...</div></td>
                                                                    </tr>
                                                                    
                                                            </table>
                                                    </div>

                                                <div class="contact_fieldBlock_left">Sellers Name: <span class="required_fields">*</span></div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <input name="sellers_name" id="sellers_name" class="add_cladds_txtfield" value="<?php echo $_POST['sellers_name'];?>" type="text">
                                                    </label>
                                                </div>
                                                <div class="contact_fieldBlock_left">Category: <span class="required_fields">*</span></div>
                                                <div class="fieldBlock_right_add_cadds">
                                                    <label>
                                                        <?php
                                                         if($_REQUEST['cats_id'] != "")
                                                         {
                                                            $selected = $_REQUEST['cats_id'];
                                                            
                                                         } else
                                                         {
                                                            $selected = $_REQUEST['category'];
                                                         }
                                                         echo $objCategory->getSubcList(3,'add_drop_list_subcats','category','mng_cladds_catdropdown',$selected,'');
                                                        ?>
                                                        
                                                   </label>
                                                    <div class="fieldBlock_right_add_cadds_btn">
                                                        <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS']."?req=cate&ids=3";?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/request_new_cate_classfied.jpg" alt="Request a new Category" /></a>
                                                    </div>
                                                </div>
                                                <div class="contact_fieldBlock_left">Description Heading: <span class="required_fields">*</span></div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <input name="title" id="title" class="add_cladds_txtfield" value="<?php echo $_POST['title'];?>" type="text">
                                                    </label>
                                                </div>
                                                 <div class="contact_fieldBlock_left">Ad Description: <span class="required_fields">*</span></div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <!--<textarea name="notes" cols="" rows="" style="width:262px; height:60px" id="notes"><?php echo $_POST['notes'];?></textarea>-->
                                                        <textarea name="notes" class="add_cladds_txtfield" id="notes"><?php echo $_POST['notes'];?></textarea>
                                              
                                                </div>
                                                <div class="contact_fieldBlock_left">Key Words: <span class="required_fields">*</span></div>
                                                <div class="contact_fieldBlock_right">
                                                    <textarea name="keywords" class="add_cladds_txtfield" id="keywords"><?php echo $_POST['keywords'];?></textarea>
                                                </div>
                                                <div class="contact_fieldBlock_left">Price: <span class="required_fields">*</span></div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <input name="price" class="add_cladds_txtfield" id="price" value="<?php echo $_POST['price'];?>" type="text">
                                                    </label>
                                                </div>
                                                
                                                <div class="contact_fieldBlock_left">Supplier Code: </div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <input name="supplier_code" class="add_cladds_txtfield" id="supplier_code" value="<?php echo $_POST['supplier_code'];?>" type="text">
                                                    </label>
                                                </div>
                                                
                                                <div class="contact_fieldBlock_left">Product URL: </div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <input name="product_url" class="add_cladds_txtfield" id="product_url" value="<?php echo $_POST['product_url'];?>" type="text">
                                                    </label>
                                                </div>
                                                
<!--                                                <div class="contact_fieldBlock_left">Image:</div>-->
                                                    <!--
                                                      Use this hidden field to keep the image key.
                                                    -->
                                                    <input type="hidden" name="keyName" value="" id="keyName"/>
                                                    
                                                    <input type="hidden" name="keyName1" value="" id="keyName1"/>
                                                    
                                                     <input type="hidden" name="keyName2" value="" id="keyName2"/>
                                                    
                                                    <input type="hidden" name="keyName3" value="" id="keyName3"/>
                                                    
                                                    <input type="hidden" name="action"  value="add"/>

                                           </form>
					<div class="contact_fieldBlock_left">
                                            <table width="600px">
                                             <tbody>
                                                 <tr>
                                                     
                                                     <?php for($i=0;$i<4;$i++){
                                                         
                                                         if($i==0){
                                                            $n = ''; 
                                                         }
                                                         else{
                                                             $n = $i; 
                                                         }
                                                         
                                                         ?>
                                                         
                                                     <td width="80px">
                                                <div class="image_path<?php echo $n; ?>" style="width: 80px;margin-left: 10px;padding: 5px;">
                                                    <!--
                                                       Image is uploaded and display in this div.
                                                    -->
                                                    <div id="uploadingImg<?php echo $n; ?>" style="min-height: 65px;">
                                                        
                                                        <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS'].'/thumbs/no_image.jpg'; ?>" width="60px"/>
                                                        
                                                       
                                                    </div>
                                                    <!--
                                                       Display zoom icon in here.
                                                    -->
                                                    <div id="zooming<?php echo $n; ?>" style="display:none">
                                                            <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','clas_ads');"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                    </div>
                                                </div>


                                               <!--
                                                  Use this form to display file browse part.
                                                -->
                                                <form id="Add_Classifieds_Image<?php echo $n; ?>" name="Add_Classifieds_Image<?php echo $n; ?>" action="" style="vertical-align:top">
                                                 <input type="hidden" name="maxSize" value="9999999999" />
                                                 <input type="hidden" name="maxW" value="200" />
                                                 <input type="hidden" name="fullPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>" />
                                                 <input type="hidden" name="relPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>" />
                                                 <input type="hidden" name="colorR" value="255" />
                                                 <input type="hidden" name="colorG" value="255" />
                                                 <input type="hidden" name="colorB" value="255" />
                                                 <input type="hidden" name="maxH" value="300" />
                                                 <input type="hidden" name="filename" value="filename" />
                                                 <input type="hidden" name="imgFolder" value="clas_ads" id="imgFolder"/>
                                                   <?php
                                                        $where = " WHERE `customer_id`='".$objCore->sessCusId."'";
                                                        $cus_list = $objCustomer->dList($where);
                                                        $cus_tbl_id = $cus_list[0][6];
                                                       
                                                   ?>
                                                 <input type="hidden" name="logUser" value="<?php echo $cus_tbl_id;?>" id="logUser"/>
                                                 
                      <div style="position: relative;overflow: hidden; width: 85px; float: left;margin-left: 10px">                           
                                                 <input type="file" style="position: relative;
	text-align: right;
	-moz-opacity:0 ;
	filter:alpha(opacity:0);
	opacity: 0;
	z-index: 2;width: 80px;" class="add_cladds_txtfield" name="filename" onchange="clearMsg('error_msg');getFieldNames('keyName<?php echo $n; ?>','Add_Classifieds','zooming<?php echo $n; ?>'); ajaxUpload('Add_Classifieds_Image<?php echo $n; ?>','<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg<?php echo $n; ?>','divProcess');  this.value='';return true;" />
         
     <div class="fakefile" style="position: absolute;
	top: 0px;
	left: 0px;
	z-index: 1;text-decoration: underline; cursor: pointer;">
<!--		<input />-->
		Upload Image
     </div>      
                                                 </div>
                                                 
<!--                                                  <div class="common_text" style="font-size:10px;"> <br/> <?php  echo str_replace("{%MAX_SIZE%}",$objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'],$objCore->_SYS['MSGS']['COMMON']['IMAGE_PRE_UPLOAD']);?></div>-->
                                                 </form>

                                             
                                            </td>
                                                     
                                                     
                                                         <?php
                                                     }
?>
                                                     
                                                     
                                                     
                                            
                                                 
<!--                                            <td width="80px">
                                                <div class="image_path1" style="width: 80px;margin-left: 10px;padding: 5px;">
                                                    
                                                       Image is uploaded and display in this div.
                                                    
                                                    <div id="uploadingImg1" style="min-height: 65px;">
                                                        
                                                        <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS'].'/thumbs/no_image.jpg'; ?>" width="60px"/>
                                                        
                                                    </div>
                                                    
                                                       Display zoom icon in here.
                                                    
                                                    <div id="zooming1" style="display:none">
                                                            <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','clas_ads');"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                    </div>
                                                </div>


                                               
                                                  Use this form to display file browse part.
                                                
                                                <form id="Add_Classifieds_Image1" name="Add_Classifieds_Image1" action="" style="vertical-align:top">
                                                 <input type="hidden" name="maxSize" value="9999999999" />
                                                 <input type="hidden" name="maxW" value="200" />
                                                 <input type="hidden" name="fullPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>" />
                                                 <input type="hidden" name="relPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>" />
                                                 <input type="hidden" name="colorR" value="255" />
                                                 <input type="hidden" name="colorG" value="255" />
                                                 <input type="hidden" name="colorB" value="255" />
                                                 <input type="hidden" name="maxH" value="300" />
                                                 <input type="hidden" name="filename" value="filename" />
                                                 <input type="hidden" name="imgFolder" value="clas_ads" id="imgFolder"/>
                                                   <?php
                                                        $where = " WHERE `customer_id`='".$objCore->sessCusId."'";
                                                        $cus_list = $objCustomer->dList($where);
                                                        $cus_tbl_id = $cus_list[0][6];
                                                       
                                                   ?>
                                                 <input type="hidden" name="logUser" value="<?php echo $cus_tbl_id;?>" id="logUser"/>
                                                 
                      <div style="position: relative;overflow: hidden; width: 85px; float: left;margin-left: 10px">                           
                                                 <input type="file" style="position: relative;
	text-align: right;
	-moz-opacity:0 ;
	filter:alpha(opacity:0);
	opacity: 0;
	z-index: 2;width: 80px;" class="add_cladds_txtfield" name="filename" onchange="clearMsg('error_msg');getFieldNames('keyName1','Add_Classifieds','zooming1'); ajaxUpload('Add_Classifieds_Image1','<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg1','divProcess');  this.value='';return true;" />
         
    <div class="fakefile" style="position: absolute;
	top: 0px;
	left: 0px;
	z-index: 1;text-decoration: underline; cursor: pointer;">
		<input />
		Upload Image
     </div>        
                                                 </div>
                                                 
                                                  <div class="common_text" style="font-size:10px;"> <br/> <?php  echo str_replace("{%MAX_SIZE%}",$objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'],$objCore->_SYS['MSGS']['COMMON']['IMAGE_PRE_UPLOAD']);?></div>
                                                 </form>

                                             
                                            </td>     
                                                 
                                                 
                             <td width="80px">
                                                <div class="image_path2" style="width: 80px;margin-left: 10px;padding: 5px;">
                                                    
                                                       Image is uploaded and display in this div.
                                                    
                                                    <div id="uploadingImg2" style="min-height: 65px;">
                                                        
                                                        <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS'].'/thumbs/no_image.jpg'; ?>" width="60px"/>
                                                        
                                                    </div>
                                                    
                                                       Display zoom icon in here.
                                                    
                                                    <div id="zooming2" style="display:none">
                                                            <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','clas_ads');"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                    </div>
                                                </div>


                                               
                                                  Use this form to display file browse part.
                                                
                                                <form id="Add_Classifieds_Image2" name="Add_Classifieds_Image2" action="" style="vertical-align:top">
                                                 <input type="hidden" name="maxSize" value="9999999999" />
                                                 <input type="hidden" name="maxW" value="200" />
                                                 <input type="hidden" name="fullPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>" />
                                                 <input type="hidden" name="relPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>" />
                                                 <input type="hidden" name="colorR" value="255" />
                                                 <input type="hidden" name="colorG" value="255" />
                                                 <input type="hidden" name="colorB" value="255" />
                                                 <input type="hidden" name="maxH" value="300" />
                                                 <input type="hidden" name="filename" value="filename" />
                                                 <input type="hidden" name="imgFolder" value="clas_ads" id="imgFolder"/>
                                                   <?php
                                                        $where = " WHERE `customer_id`='".$objCore->sessCusId."'";
                                                        $cus_list = $objCustomer->dList($where);
                                                        $cus_tbl_id = $cus_list[0][6];
                                                       
                                                   ?>
                                                 <input type="hidden" name="logUser" value="<?php echo $cus_tbl_id;?>" id="logUser"/>
                                                 
                      <div style="position: relative;overflow: hidden; width: 85px; float: left;margin-left: 10px">                           
                                                 <input type="file" style="position: relative;
	text-align: right;
	-moz-opacity:0 ;
	filter:alpha(opacity:0);
	opacity: 0;
	z-index: 2;width: 80px;" class="add_cladds_txtfield" name="filename" onchange="clearMsg('error_msg');getFieldNames('keyName2','Add_Classifieds','zooming2'); ajaxUpload('Add_Classifieds_Image2','<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg2','divProcess');  this.value='';return true;" />
         
     <div class="fakefile" style="position: absolute;
	top: 0px;
	left: 0px;
	z-index: 1;text-decoration: underline; cursor: pointer;">
		<input />
		Upload Image
     </div>      
                                                 </div>
                                                 
                                                  <div class="common_text" style="font-size:10px;"> <br/> <?php  echo str_replace("{%MAX_SIZE%}",$objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'],$objCore->_SYS['MSGS']['COMMON']['IMAGE_PRE_UPLOAD']);?></div>
                                                 </form>

                                             
                                            </td>                    
                                                 
                                                 
                                  <td width="80px">
                                                <div class="image_path3" style="width: 80px;margin-left: 10px;padding: 5px;">
                                                    
                                                       Image is uploaded and display in this div.
                                                    
                                                    <div id="uploadingImg3" style="min-height: 65px;">
                                                        
                                                        <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS'].'/thumbs/no_image.jpg'; ?>" width="60px"/>
                                                        
                                                    </div>
                                                    
                                                       Display zoom icon in here.
                                                    
                                                    <div id="zooming3" style="display:none">
                                                            <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','clas_ads');"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                    </div>
                                                </div>


                                               
                                                  Use this form to display file browse part.
                                                
                                                <form id="Add_Classifieds_Image3" name="Add_Classifieds_Image3" action="" style="vertical-align:top">
                                                 <input type="hidden" name="maxSize" value="9999999999" />
                                                 <input type="hidden" name="maxW" value="200" />
                                                 <input type="hidden" name="fullPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>" />
                                                 <input type="hidden" name="relPath" value="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>" />
                                                 <input type="hidden" name="colorR" value="255" />
                                                 <input type="hidden" name="colorG" value="255" />
                                                 <input type="hidden" name="colorB" value="255" />
                                                 <input type="hidden" name="maxH" value="300" />
                                                 <input type="hidden" name="filename" value="filename" />
                                                 <input type="hidden" name="imgFolder" value="clas_ads" id="imgFolder"/>
                                                   <?php
                                                        $where = " WHERE `customer_id`='".$objCore->sessCusId."'";
                                                        $cus_list = $objCustomer->dList($where);
                                                        $cus_tbl_id = $cus_list[0][6];
                                                       
                                                   ?>
                                                 <input type="hidden" name="logUser" value="<?php echo $cus_tbl_id;?>" id="logUser"/>
                                                 
                      <div style="position: relative;overflow: hidden; width: 85px; float: left;margin-left: 10px">                           
                                                 <input type="file" style="position: relative;
	text-align: right;
	-moz-opacity:0 ;
	filter:alpha(opacity:0);
	opacity: 0;
	z-index: 2;width: 80px;" class="add_cladds_txtfield" name="filename" onchange="clearMsg('error_msg');getFieldNames('keyName3','Add_Classifieds','zooming3'); ajaxUpload('Add_Classifieds_Image3','<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg3','divProcess');  this.value='';return true;" />
         
     <div class="fakefile" style="position: absolute;
	top: 0px;
	left: 0px;
	z-index: 1;text-decoration: underline; cursor: pointer;">
		<input />
		Upload Image
     </div>       
                                                 </div>
                                                 
                                                  <div class="common_text" style="font-size:10px;"> <br/> <?php  echo str_replace("{%MAX_SIZE%}",$objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'],$objCore->_SYS['MSGS']['COMMON']['IMAGE_PRE_UPLOAD']);?></div>
                                                 </form>

                                             
                                            </td>               -->
                      
                                                 </tr>
                                                 </tbody>
                                                 </table>
                                                   </div> 
                                                   
                                             <div class="contact_fieldBlock_left ">
                                                    <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/cancel.jpg" border="" ></a>
                                                    <label id="submit_contact_details">
                                                    
                                                    <a href="javascript:Add_Classifieds.submit();"><img alt="Submit" border="0" onclick="Add_Classifieds.submit();" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg"/></a>
                                                    </label>
                                                </div>
                                        </div>

                                        <div class="add_classified_formbottom"></div>

                                    </div></td>
                            </tr>
                            <tr>
                                <td height="10"></td>
                            </tr> 
                        </table>
                    </div>
                </div>
<!----------------------------------------------------------------------------------------------------->
            </div>
            <div id="main_form_bg_bottombar"><img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
        </div>
    </div>
</div>
<?php
} 
?>