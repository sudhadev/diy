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
        $available_amount = $objClassifiedAd->count_db_val($objCore->sessCusId, "Y");
        /*if($available_amount == "have_to_pay")
        {
            $available_amount = "have to pay";
        } else
        {
            $available_amount = $available_amount;
        }*/
        
       $id = $_REQUEST['id'];
       $list = $objClassifiedAd->get_dList($id,$objCore->sessCusId);
       
       /*
        * Get order information
        */
            if($list[0][12])
            {
                require_once($objCore->_SYS['PATH']['CLASS_ORDER']);
                if(!is_object($objOrder))
                {
                    $objOrder=new Order;
                }
                $orderDetails=$objOrder->getOrderInfoByCus($objCore->sessCusId,$list[0][12]);
             
             
            }


        
    
?>

<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">

          <!----------------------------------------------------------------------------------------------------->
                <div id="banner_add_cads">EDIT MY CLASSIFIED ADS</div>
                <div id="text_area_add_cads">
                    <div class="common_text"><?php echo $pageContents['common_text_edit'];?> </div>
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
                                                        <td height="30" width="206" class="pgBar">Your total amount of available Ads is</td>
                                                        <td width="420" height="30" class="pbYellow">(<a class="pbYellow"><?php echo $objCore->_SYS['CONF']['CURRENCY']."  ".$available_amount;?> </a>)</td>
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
                                <td>
                                    <div class="add_classified_formmain">
                                        <div class="add_classified_formtop"></div>
                                        <div class="add_classified_formmiddle">
                                            <form id="Add_Classifieds" name="Add_Classifieds" method="post" action="<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>/my_account/classified_ads/" enctype="multipart/form-data">
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
                                                            <table width="98%" border="0" align="center">
                                                                    <tr>
                                                                        <td class="" style="padding-top:10px;"><div id="divProcess">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uploading Image...</div></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td></td>
                                                                    </tr>
                                                            </table>
                                                    </div>
                                                    
                                                    <?php 
                                                   // print_r($list[0]);
                                                   // if(($list[0][10]!="Y" && $orderDetails[0]['paid']!='Y') || ($list[0][10]!="N" && $list[0][16]>0)) {?>
<!--                                                      <div id="specialInfo" class="commonInfoBox" style="width: 610px;margin-top:10px;margin-left:5px;display:block;">
                                                            <?php //echo $pageContents['infoEditAdNotPaidAd'];?>
                                                      </div>-->
                                                  <?php// }?>
                                                <div class="contact_fieldBlock_left">Sellers Name: <span class="required_fields">*</span></div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <input name="sellers_name" id="sellers_name" class="add_cladds_txtfield"  value="<?php echo $list[0][17]; ?>" type="text">
                                                    </label>
                                                </div>
                                                <div class="contact_fieldBlock_left">Category: <span class="required_fields">*</span></div>
                                                <div class="Category contact_fieldBlock_right">
                                                    <label>
                                                        <?php
                                                        if($list[0][4] != "")
                                                        {
                                                            $cat_list = $objCategory->getCategory($list[0][4]);
                                                        } else
                                                        {
                                                            $cat_list = $objCategory->getCategory($list[0][3]);
                                                        }
                                                        //$selected = $cat_list['id']."_".$cat_list['level'];
                                                        $selected = $cat_list['id'];
                                                         echo $objCategory->getSubcList(3,'add_drop_list_subcats','category','mng_cladds_catdropdown',$selected,'');
                                                        ?>
                                                   </label>

                                                </div>
                                                
                                                <div class="contact_fieldBlock_left">Description Heading: <span class="required_fields">*</span></div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <input name="title" id="title" class="add_cladds_txtfield"  value="<?php echo $list[0][5]; ?>" type="text">
                                                    </label>
                                                </div>
                                                
                                                <div class="contact_fieldBlock_left">Notes: <span class="required_fields">*</span></div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <textarea name="notes" class="add_cladds_txtfield" id="notes"><?php echo $list[0][7]; ?></textarea>
                                                    </label>

                                                </div>
                                                <div class="contact_fieldBlock_left">Key Words: <span class="required_fields">*</span></div>
                                                <div class="contact_fieldBlock_right">
                                                    <textarea name="keywords" class="add_cladds_txtfield" id="keywords"><?php echo $list[0][6]; ?></textarea>
                                                </div>
                                                <div class="contact_fieldBlock_left">Price (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>): <span class="required_fields">*</span></div>
                                                <div class="">
                                                    <label class="contact_fieldBlock_right common_text">
                                                        <?php echo $list[0][8]; 
                                                        print_r($orderDetails);
                                                        ?>
                                                    </label>
                                                </div>
                                                
                                               <div class="contact_fieldBlock_left">Supplier Code: <span class="required_fields">*</span></div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <input name="supplier_code" id="supplier_code" class="add_cladds_txtfield"  value="<?php echo $list[0][18]; ?>" type="text">
                                                    </label>
                                                </div>
                                               
                                               <div class="contact_fieldBlock_left">Product URL: <span class="required_fields">*</span></div>
                                                <div class="contact_fieldBlock_right">
                                                    <label>
                                                        <input name="product_url" id="product_url" class="add_cladds_txtfield"  value="<?php echo $list[0][19]; ?>" type="text">
                                                    </label>
                                                </div>
                                               
                                                <div class="contact_fieldBlock_left">Image:</div>
                                                    <!--
                                                      Use this hidden field to keep the image key.
                                                    -->
                                                    <input type="hidden" name="keyName" value="<?php echo $list[0][9];?>" id="keyName"/>
                                                    <input type="hidden" name="keyName1" value="<?php echo $list[0][20];?>" id="keyName1"/>
                                                    <input type="hidden" name="keyName2" value="<?php echo $list[0][21];?>" id="keyName2"/>
                                                    <input type="hidden" name="keyName3" value="<?php echo $list[0][22];?>" id="keyName3"/>
                                                    <input type="hidden" name="idValue" value="<?php echo $id;?>" id="idValue"/>
                                                    <input type="hidden" name="action"  value="edit"/>
                                                    <input type="hidden" name="aat"  id="aat" value="<?php echo $list[0][11];?>" />
                                             
                                            </form>

                                            
                                            <div class="contact_fieldBlock_left">
                                            <table width="600px">
                                             <tbody>
                                                 <tr>
                                                     <td width="80px">
                                                <div class="image_path" style="width: 80px;margin-left: 10px;padding: 5px;">
                                                    <?php
                                                                $imgUrl = $objCategory->image($list[0][9],$objCore->_SYS['CONF']['FTP_CLAS_ADS'],$objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS']);
                                                          ?>
                                                    
                                                    <!--
                                                       Image is uploaded and display in this div.
                                                    -->
                                                    <div id="uploadingImg" style="height: 60px;"><img src="<?php echo $imgUrl;?>" width="60"/>&nbsp;</div>
                                                    <!--
                                                       Display zoom icon in here.
                                                    -->
                                                    <div id="zooming" style="display:none">
                                                            <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','clas_ads');"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                    </div>
                                                </div>


                                               <!--
                                                  Use this form to display file browse part.
                                                -->
                                                <form id="Add_Classifieds_Image" name="Add_Classifieds_Image" action="" style="vertical-align:top">
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
                                                 
                      <div style="position: relative;overflow: hidden; width: 80px; float: left;margin-left: 10px">                           
                                                 <input type="file" style="position: relative;
	text-align: right;
	-moz-opacity:0 ;
	filter:alpha(opacity:0);
	opacity: 0;
	z-index: 2;width: 80px;" class="add_cladds_txtfield" name="filename" onchange="clearMsg('error_msg');getFieldNames('keyName','Add_Classifieds','zooming'); ajaxUpload(Add_Classifieds_Image,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg','divProcess');  this.value='';return true;" />
         
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
                                            
                                                 
                                            <td width="80px">
                                                <div class="image_path1" style="height: 60px;width: 80px;margin-left: 10px;padding: 5px;">
                                                    <!--
                                                       Image is uploaded and display in this div.
                                                    -->
                                                     <?php
                                                                $imgUrl1 = $objCategory->image($list[0][20],$objCore->_SYS['CONF']['FTP_CLAS_ADS'],$objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS']);
                                                          ?>
                                                    
                                                    <div id="uploadingImg1"><img src="<?php echo $imgUrl1;?>" width="60"/>&nbsp;</div>
                                                    <!--
                                                       Display zoom icon in here.
                                                    -->
                                                    <div id="zooming1" style="display:none">
                                                            <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','clas_ads');"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                    </div>
                                                </div>


                                               <!--
                                                  Use this form to display file browse part.
                                                -->
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
                                                 
                      <div style="position: relative;overflow: hidden; width: 80px; float: left;margin-left: 10px">                           
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
<!--		<input />-->
		Upload Image
     </div>       
                                                 </div>
                                                 
<!--                                                  <div class="common_text" style="font-size:10px;"> <br/> <?php  echo str_replace("{%MAX_SIZE%}",$objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'],$objCore->_SYS['MSGS']['COMMON']['IMAGE_PRE_UPLOAD']);?></div>-->
                                                 </form>

                                             
                                            </td>     
                                                 
                                                 
                             <td width="80px">
                                                <div class="image_path2" style="height: 60px;width: 80px;margin-left: 10px;padding: 5px;">
                                                    <!--
                                                       Image is uploaded and display in this div.
                                                    -->
                                                    <?php
                                                                $imgUrl2 = $objCategory->image($list[0][21],$objCore->_SYS['CONF']['FTP_CLAS_ADS'],$objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS']);
                                                          ?>
                                                    
                                                    <div id="uploadingImg2"><img src="<?php echo $imgUrl2;?>" width="60"/>&nbsp;</div>
                                                    <!--
                                                       Display zoom icon in here.
                                                    -->
                                                    <div id="zooming2" style="display:none">
                                                            <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','clas_ads');"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                    </div>
                                                </div>


                                               <!--
                                                  Use this form to display file browse part.
                                                -->
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
                                                 
                      <div style="position: relative;overflow: hidden; width: 80px; float: left;margin-left: 10px">                           
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
<!--		<input />-->
		Upload Image
     </div>       
                                                 </div>
                                                 
<!--                                                  <div class="common_text" style="font-size:10px;"> <br/> <?php  echo str_replace("{%MAX_SIZE%}",$objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'],$objCore->_SYS['MSGS']['COMMON']['IMAGE_PRE_UPLOAD']);?></div>-->
                                                 </form>

                                             
                                            </td>                    
                                                 
                                                 
                                  <td width="80px">
                                                <div class="image_path3" style="height: 60px;width: 80px;margin-left: 10px;padding: 5px;">
                                                    <?php
                                                                $imgUrl3 = $objCategory->image($list[0][22],$objCore->_SYS['CONF']['FTP_CLAS_ADS'],$objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS']);
                                                          ?>
                                                    
                                                    <!--
                                                       Image is uploaded and display in this div.
                                                    -->
                                                    <div id="uploadingImg3"><img src="<?php echo $imgUrl3;?>" width="60"/>&nbsp;</div>
                                                    <!--
                                                       Display zoom icon in here.
                                                    -->
                                                    <div id="zooming3" style="display:none">
                                                            <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','clas_ads');"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                    </div>
                                                </div>


                                               <!--
                                                  Use this form to display file browse part.
                                                -->
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
                                                 
                      <div style="position: relative;overflow: hidden; width: 80px; float: left;margin-left: 10px">                           
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
<!--		<input />-->
		Upload Image
     </div>       
                                                 </div>
                                                 
<!--                                                  <div class="common_text" style="font-size:10px;"> <br/> <?php  echo str_replace("{%MAX_SIZE%}",$objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'],$objCore->_SYS['MSGS']['COMMON']['IMAGE_PRE_UPLOAD']);?></div>-->
                                                 </form>

                                             
                                            </td>               
                      
                                                 </tr>
                                                 </tbody>
                                                 </table>
                                                
                                                </div>
                                            
<!--                                             <div class="contact_fieldBlock_right">

                                                <div class="image_path">
                                                    
                                                       Image is uploaded and display in this div.
                                                    
                                                    <div id="uploadingImg">
                                                          <?php
                                                                $imgUrl = $objCategory->image($list[0][9],$objCore->_SYS['CONF']['FTP_CLAS_ADS'],$objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS']);
                                                          ?>
                                                          <img src="<?php echo $imgUrl;?>" width="60"/>&nbsp;
                                                          <br />
                                                           <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $list[0][9]; ?>','clas_ads');"><img  border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                                Dlete Image 
                                                                <?php 
                                                                  $pos = strrpos($imgUrl, "no_image.jpg");
                                                                  if ($pos === false) { // note: three equal signs
                                                                 ?>  
                                                                 <a href="javascript:delImage('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/delete.ajax.php','clas_ads','<?php echo $list[0][9]; ?>','<?php echo $objCore->sessCusId;?>');" title="Delete Image" style="text-decoration:none"><img alt="delete" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/delete_img_str.png" border="0"  /> </a>
                                                                  <?php  }// end of $pos
                                                                ?>
                                                                 / Delete Image 
                                                </div>
                                                    
                                                       Display zoom icon in here.
                                                    
                                                    <div id="zooming" style="display:none">
                                                        <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','clas_ads');"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
                                                    </div>
                                                </div>
                                                    
                                                      Use this form to display file browse part.
                                                    
                                                    <form id="Add_Classifieds_Image" name="Add_Classifieds_Image" action="">
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
                                                        <input type="file" name="filename" class="add_cladds_txtfield" onchange="clearMsg('error_msg');getFieldNames('keyName','Add_Classifieds','zooming'); ajaxUpload(Add_Classifieds_Image,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg','divProcess');  this.value='';return true;" />
                                                          <div class="common_text" style="font-size:10px;"> <br/> <?php  echo str_replace("{%MAX_SIZE%}",$objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'],$objCore->_SYS['MSGS']['COMMON']['IMAGE_PRE_UPLOAD']);?></div>
                                                                                      </form>
                                          
                                        </div>-->
                                        <div class="contact_fieldBlock_left ">

                                                    <label id="submit_contact_details">
                                                    <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'].'/classified_ads/index.php?f=manage';?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/cancel.jpg" border="" ></a>
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
      <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
    </div>
  </div>
</div>
<?php
    }
?>
