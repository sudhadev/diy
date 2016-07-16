<?php

?>
<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar">
                <div id="banner">Manage my Services</div>
                <div id="text_area">
                    <div class="common_text"><?php echo $pageContents['common_text']?></div>
                </div>
                <div class="list">
                    <div align="left">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="list_blackbg_summery">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="13" height="30"></td>
                                            <td class="pbYellow">Manage Profile - Services</td>
                                            <td width="13" height="30"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <!--
                                      Display loading image.
                                    -->
                                    <div id="message_holder">
                                        <div id="error_msg" style="width:605px; margin-left:0px">
                                            <?php
                                            if($msg) {
                                                echo $objCore->msgBox("SERVICES",$msg,'100%');
                                            }
                                            else if ($exists && $_POST['action']) {
                                                    echo $objCore->msgBox("SERVICES",$exists,'100%');
                                                }
                                            ?>
                                        </div>
                                        <table width="98%" border="0" align="center">
                                            <tr>
                                                <td class="" style="padding-top:10px;"><div id="divProcess" style="width:570px; margin-left:0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uploading Image...</div></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                            </tr>
                                        </table>
                                    </div>

                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <form action="" method="POST" enctype="multipart/form-data" name="frmServices" id="frmServices">
                                    <div class="add_classified_formmain">
                                        <div class="option_form_catagori_head">GENERAL INFORMATION</div>
                                        <div id="personal" style="">
                                            
                                                <div class="option_form_catagories">
                                                    <div class="text_fieldBlock_left">Business Name:<span class="required_fields">*</span></div>
                                                    <div class="text_fieldBlock_right">
                                                        <input name="business_name" id="business_name" class="mng_myinfo_txtfield" value="<?php if ($serviceData) {echo $serviceData[0][9];}else {echo $_REQUEST['business_name'];} ?>" type="text">
                                                    </div>
                                                    <div class="text_fieldBlock_left">Category:</div>
                                                    <div class="text_fieldBlock_right">
                                                    <div style="float:left;">
                                                            <?php
                                                            if ($serviceData) {
                                                                if ($serviceData[0][1] && !$serviceData[0][2]) {
                                                                    $val = $serviceData[0][1];
                                                                }
                                                                else if ($serviceData[0][2]) {
                                                                        $val = $serviceData[0][2];
                                                                    }
                                                                    else {
                                                                        $val = $_REQUEST['description'];
                                                                    }
                                                            }
                                                            echo $objCategory->getSubcList(2,'add_drop_list_subcats','category','mng_myinfo_txtfield',$val,'');
                                                            ?></div>
                                                        <div class="fieldBlock_right_add_cadds_btn">
                                                            <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS']."?req=cate&ids=2";?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/request_new_cate_classfied.jpg" alt="Request a new Category" /></a>
                                                        </div>
                                                   
                                                    </div>
                                                    <div class="text_fieldBlock_left">Service Description:<span class="required_fields">*</span></div>
                                                    <div class="text_fieldBlock_right">
                                                        <textarea name="description" class="mng_myinfo_txtfield"><?php if ($serviceData) {echo $serviceData[0][5];}else {echo $_REQUEST['description'];} ?></textarea>
                                                    </div>
                                                    <!--
                                                    <div class="text_fieldBlock_left">Affliations:<span class="required_fields">*</span></div>
                                                    <div class="text_fieldBlock_right">
                                                        <label>
                                                            <input name="affiliations" id="affiliations" class="mng_myinfo_txtfield" value="<?php if ($serviceData) {echo $serviceData[0][10];}else {echo $_REQUEST['affiliations'];} ?>" type="text">
                                                        </label>
                                                    </div>
                                                    -->
                                                    <div class="text_fieldBlock_left">Key Words:<span class="required_fields">*</span></div>
                                                    <div class="text_fieldBlock_right">
                                                        <textarea name="keywords" class="mng_myinfo_txtfield"><?php if ($serviceData) {echo $serviceData[0][4];}else {echo $_REQUEST['keywords'];} ?></textarea>
                                                    </div>
                                                    <div class="text_fieldBlock_left">Website:</div>
                                                    <div class="text_fieldBlock_right">
                                                        <input name="website" id="website" class="mng_myinfo_txtfield" value="<?php if ($serviceData) {echo $serviceData[0][18];}else {echo $_REQUEST['website'];} ?>" type="text">
                                                  
                                                    </div>
                                                    <div class="text_fieldBlock_left">Call out charge:</div>
                                                    <div class="text_fieldBlock_right">
                                                       
                                                    <select name="callOutCharge" id="callOutCharge" class="mng_mylistings_short" style="width:140px;">
                                                        <?php
                                                                $bdOptionListRate = '<option value="0" >No</option>' . "\n";
                                                                $i = 5;
                                                                while($i<55){
                                                                    $bdOptionListRate .= '<option value="'.$i.'" >£'.$i.'</option>' . "\n";
                                                                    $i = $i+5;
                                                                    }
                    
                                                                    echo str_replace('value="' . $serviceData[0][7] . '"', 'value="' . $serviceData[0][7] . '" selected ', $bdOptionListRate)
                                                        ?>
                                                    </select>
                                                    
                                                    </div>
                                                    
                                                    <div class="text_fieldBlock_left">Hourly rate:</div>
                                                    <div class="text_fieldBlock_right">
                                                    <input name="hourlyRate" id="hourlyRate" class="mng_myinfo_txtfield" value="<?php echo $serviceData[0][6]; ?>" type="text">

                                                    </div>
                                                    <div class="text_fieldBlock_left">Image:<span class="required_fields"></span></div>
                                                    <div class="text_fieldBlock_right">
                                                        <!--
                                                            add image to the services. (by Lakshyami)
                                                        -->
                                                        <div class="image_path">
                                                            <!--
                                                            add image to the services. (by Lakshyami)
                                                               Image is uploaded and display in this div.
                                                            -->
<!--                                                            <div id="uploadingImg">
                                                          
                                                                <?php
                                                                if($serviceData[0][8] != "") {
                                                                    $imgUrl = $objCategory->image($serviceData[0][8],$objCore->_SYS['CONF']['FTP_SERVICES'],$objCore->_SYS['CONF']['URL_IMAGES_SERVICES']);
                                                                ?>
                                                                <img alt="" src="<?php echo $imgUrl."?t=".time();?>" width="65"/>&nbsp;
                                                                <br />
                                                              
                                                             
                                                                <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $serviceData[0][8]; ?>','services');"><img  alt="Zoom" border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                                Dlete Image 
                                                                <?php 
                                                                  $pos = strrpos($imgUrl, "no_image.jpg");
                                                                  if ($pos === false) { // note: three equal signs
                                                                 ?>  
                                                                 <a href="javascript:delImage('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/delete.ajax.php','services','<?php echo $serviceData[0][8]; ?>','<?php echo $objCore->sessCusId;?>');" title="Delete Image" style="text-decoration:none"><img alt="delete" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/delete_img_str.png" border="0"  /> </a>
                                                                  <?php  }// end of $pos
                                                                ?>
                                                                 / Delete Image 

                                                                <?php
                                                                }
                                                                ?>
                                                            </div>-->
                                                            
                                                            <!--
                                                               Display zoom icon in here.
                                                            -->
                                                            <div id="zooming" style="display:none">
                                                                <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','services');"><img alt="Zoom" border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                            </div>


                                                            <!--
                                                                Use this form to display file browse part.
                                                    -->   <div>
                                                        
                                                        <input type="hidden" id="action" name="action" value="<?php if ($exists) {echo 'update'; }else {echo 'add';}?>"/>
                                           
                                                        <input type="hidden" name="keyName" value="<?php if ($serviceData) {echo $serviceData[0][8];}?>" id="keyName"/>
                                                        <input type="hidden" name="keyName1" value="<?php if ($serviceData) {echo $serviceData[0][14];}?>" id="keyName1"/>
                                                        <input type="hidden" name="keyName2" value="<?php if ($serviceData) {echo $serviceData[0][15];}?>" id="keyName2"/>
                                                        <input type="hidden" name="keyName3" value="<?php if ($serviceData) {echo $serviceData[0][16];}?>" id="keyName3"/>
                                                        
                                                      <!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
                                    
                                                           
                                                         </div>
                                                        </div>
                                                    </div>
                                                    <?php ?>
                                                    
                                                </div>

                                        </div>
                                    </div>
                                        </form>
                                    
                                        <?php
                                        
                                        $images_array  = array(0=>$serviceData[0][8],1=>$serviceData[0][14],2=>$serviceData[0][15],3=>$serviceData[0][16]);
                                        ?>
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
                                                        <?php if($images_array[$i]!=''){ ?>
                                                        <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_SERVICES'].'/thumbs/'.$images_array[$i]; ?>" width="60px"/>
                                                        
                                                        <?php }
                                                        else{
                                                            ?>
                                                         <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_SERVICES'].'/thumbs/no_image.jpg'; ?>" width="60px"/>
                                                      
                                                        <?php
                                                        }
                                                        
                                                        ?>
                                                       
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
                                                 <input type="hidden" name="imgFolder" value="services" id="imgFolder"/>
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
	z-index: 2;width: 80px;" class="add_cladds_txtfield" name="filename" onchange="clearMsg('error_msg');getFieldNames('keyName<?php echo $n; ?>','frmServices','zooming<?php echo $n; ?>'); ajaxUpload('Add_Classifieds_Image<?php echo $n; ?>','<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg<?php echo $n; ?>','divProcess');  this.value='';return true;" />
         
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

                                                 </tr>
                                                 
                                                 </tbody>
                                                 </table>
                                        
                                        
                                        
                                                   </div> 
                                   
                                      
                                                      <div class="contact_fieldBlock_left">               <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/back-black.jpg" border="" ></a>
<label id="submit_contact_details"><img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="0" onClick="resetSubmit('frmServices','<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/my_account/services/');"></label></div>

<!--                                         <form id="Add_Classifieds_Image" name="Add_Classifieds_Image" action="" style="vertical-align:top;">
                                                                <input type="hidden" name="filename" value="filename" />
                                                                <input type="hidden" name="imgFolder" value="services" id="imgFolder"/>
                                                                    <input type="hidden" name="keyName" value="<?php if ($serviceData) {echo $serviceData[0][8];}?>" id="keyName"/>
                                                                <input type="file" name="filename" class="mng_myinfo_txtfield" onchange="clearMsg('error_msg');getFieldNames('keyName','frmServices','zooming'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg','divProcess');  return true;" />
                                                                <br/> <?php  echo str_replace("{%MAX_SIZE%}",$objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'],$objCore->_SYS['MSGS']['COMMON']['IMAGE_PRE_UPLOAD']);?>
                                                            </form>       -->
                                </td>
                            </tr>

                            <tr>
                                <td height="10"></td>
                            </tr>
                            
                             
                        </table>
                    </div>
                </div>

                <div id="main_form_bg_bottombar"><img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
            </div>
        </div>
    </div>
</div>




<!--                                    <div class="add_classified_formmain">-->
<!--                                        <div class="option_form_catagori_head">COMPANY DETAILS</div>-->
<!--                                        <div id="personal" style="">-->
<!--                                            <div class="option_form_catagories">-->
<!--                                                <div class="text_fieldBlock_left">Name of person to contact:<span class="required_fields">*</span></div>
                                                <div class="text_fieldBlock_right">
                                                    <input name="contactPerson" id="contactPerson" class="mng_myinfo_txtfield" value="<?php if ($serviceData) {echo $serviceData[0][11];}else {echo $_REQUEST['contactPerson'];} ?>" type="text">
                                                </div>-->
<!--                                                <div class="text_fieldBlock_left">Hourly Rate:</div>
                                                <div class="text_fieldBlock_right"><input type="checkbox" name="hrate" value="Y" onClick="javascript: if (this.checked) {document.getElementById('hrate').style.display = 'block'} else {document.getElementById('hrate').style.display = 'none'}" <?php if ($serviceData[0][6] != 0) echo "checked";?> >
                                                <div id="hrate" class="hrate" <?php if ($serviceData[0][6] == 0) {?> style="display:none" <?php } else {?> style="display:block" <?php }?>><input name="hourlyRate" id="hourlyRate" class="mng_myinfo_txtfield" value="<?php if ($serviceData) {echo $serviceData[0][6];}else {echo $_REQUEST['hourlyRate'];} ?>" type="text"></div>
                                                </div>-->
                                                
<!--                                                <div class="text_fieldBlock_left">Call Out Charge:</div>
                                                <div class="text_fieldBlock_right">
                                                    <input name="callOutCharge" id="callOutCharge" class="mng_myinfo_txtfield" value="<?php if ($serviceData) {echo $serviceData[0][7];}else {echo $_REQUEST['callOutCharge'];} ?>" type="text">
                                                </div>-->
                                                <?php
                                                    /*
                                                     * Create Array for Accreditation
                                                     */ //$arrAccreditation=array();
                                                        if($serviceData[0][12])
                                                        {
                                                            $arrAccreditation=explode("||",$serviceData[0][12]);
                                                        }
                                                        $arrAccreditation[]="||";
                                                        //if(!is_array($arrAccreditation))
                                                        //print_r($arrAccreditation);

                                                ?>
<!--                                                <div class="text_fieldBlock_left">Accreditation:</div>
                                                <div class="text_fieldBlock_right" style="padding-top:5px">
                                                    <div class="accreditations_main">
                                                        <div class="accreditations">Gas Safe Registered</div>
                                                        <div class="accreditations_checkbox">
                                                            <input type="checkbox" name="accreditation[]" value="Gas Safe Registered"  <?php if(in_array("Gas Safe Registered",$arrAccreditation)) echo "checked";?> />
                                                        </div>
                                                    </div>
                                                    <div class="accreditations_main">
                                                        <div class="accreditations">NICEIC</div>
                                                        <div class="accreditations_checkbox">
                                                            <input type="checkbox" name="accreditation[]" value="NICEIC"  <?php if(in_array("NICEIC",$arrAccreditation)) echo "checked";?> />
                                                        </div>
                                                    </div>
                                                    <div class="accreditations_main">
                                                        <div class="accreditations">FMB</div>
                                                        <div class="accreditations_checkbox">
                                                            <input type="checkbox" name="accreditation[]" value="FMB"   <?php if(in_array("FMB",$arrAccreditation)) echo "checked";?> />
                                                        </div>
                                                    </div>
                                                    <div class="accreditations_main">
                                                        <div class="accreditations">Guild of Master Craftsmen</div>
                                                        <div class="accreditations_checkbox">
                                                            <input type="checkbox" name="accreditation[]" value="Guild of Master Craftsmen"   <?php if(in_array("Guild of Master Craftsmen",$arrAccreditation)) echo "checked";?> />
                                                        </div>
                                                    </div>
                                                    <div class="accreditations_main">
                                                        <div class="accreditations">Painting Decoration Association </div>
                                                        <div class="accreditations_checkbox">
                                                            <input type="checkbox" name="accreditation[]" value="Painting Decoration Association"   <?php if(in_array("Painting Decoration Association",$arrAccreditation)) echo "checked";?> />
                                                        </div>
                                                    </div>
                                                    <div class="accreditations_main">
                                                        <div class="accreditations">Nat. Fed. of Roofing Contractors </div>
                                                        <div class="accreditations_checkbox">
                                                            <input type="checkbox" name="accreditation[]" value="Nat. Fed. of Roofing Contractors"   <?php if(in_array("Nat. Fed. of Roofing Contractors",$arrAccreditation)) echo "checked";?> />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text_fieldBlock_left">Website:</div>
                                                <div class="text_fieldBlock_right"><input name="website" id="website" class="mng_myinfo_txtfield" value="<?php if ($serviceData) {echo $serviceData[0][13];}else {echo $_REQUEST['website'];} ?>" type="text"></div>-->
