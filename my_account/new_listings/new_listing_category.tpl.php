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
if($objCore->isAllowed($module, $function)) {

    switch(count($arryids))
    {
        case "1":
        {
            $requestId = $arryids[0];
            //$type = "add_drop_list";
            $selecId = $arryids[0]."_".$level;
            
        } break;

        case "2":
        {
            $requestId = $arryids[0];
            $selecId = $arryids[1]."_".$level;
            //$type = "add_drop_list";
            
        } break;

        case "3":
        {
            $requestId = $arryids[0];
            $selecId = $arryids[1]."_".($level-1);
            //$type = "add_drop_list";

        } break;

    }

$type = "add_drop_list_front";

?>

<!-- START CONTENT AREA-->

<form action="" method="post" name="frmCategory" id="frmCategory">

        <?php   $paddingTop=0;if($requestId == "1")$paddingTop="41";    ?>
        <div class="add_classified_formmain" style="padding:<?php echo $paddingTop;?>px 0px 25px 0px;">
        <div class="add_classified_formtop "></div>


        
        <div class="add_newlistings_formmiddle" id="catDiv">
          <div id="specialInfo" class="commonInfoBox" style="width: 610px;margin-top:10px;margin-left:5px;display:none;">
            <div id="addSecCat" style="display:none">
                <?php echo $pageContents['infoAddSecCategory'];?>
            </div>
            <div id="addThirdCat" style="display:none">
                <?php if($requestId==1)
                      {
                            echo $pageContents['infoAddThirdCategory'];
                      }
                      else
                      {
                            echo $pageContents['infoAddThirdCategoryNonSupplies'];
                      }

                 ?>
              
                
            </div>
          </div>

            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Parent Category :<span class="required_fields">*</span></div>
                <div class="text_fieldBlock_right">

                        <?php
                            echo $objCategory->getSubcList($requestId,$type,'category_selection','textfield_right_font',$selecId,'onchange="javascript:doChanges(); selectCat();"');
                        ?>

                </div>
            </div>
            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Category Name :<span class="required_fields">*</span></div>
                <div class="text_fieldBlock_right">
                    <input name="category_name" id="category_name" value="<?php echo $_POST['category_name'];?>" type="text" class="textfield_right_font" onblur="doChanges();"/>
                </div>
            </div>
            <div class="text_feild_mainblock" id="divImage" style="display:none">
                <div class="text_fieldBlock_left">Category Image :<br/>
                (Optional, for admin referral)
                </div>
                <div class="text_fieldBlock_right">
                    
                    <div class="delete_image_div">
                        <!--<div class="dlt_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_image.jpg" alt="delete image" width="11" height="12" border="0"/></div>  &nbsp; Delete Image</div>-->
                    </div>

                        <div class="image_path">
                        <!--
                           Image is uploaded and display in this div.
                        -->
                        <div id="uploadingImg"></div>
                        <!--
                           Display zoom icon in here.
                        -->
                        <div id="zooming" style="display:none">
                            <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','categ');"><img alt="Zoom" border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                        </div>


                        <!--
                            Use this form to display file browse part.
                        -->
                        <form id="frmCategoryImage" name="frmCategoryImage" action="" style="vertical-align:top">
                            <input type="hidden" name="filename" value="filename" />
                            <input type="hidden" name="imgFolder" value="cats_request" id="imgFolder"/>

                            <input type="file" name="filename" onchange="doChanges();clearMsg('error_msg');getFieldNames('keyName','frmCategory','zooming'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg','divProcess'); changeHeight(); this.value='';return true;" />
                                                          <div class="common_text" style="font-size:10px;"> <br/> <?php  echo str_replace("{%MAX_SIZE%}",$objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'],$objCore->_SYS['MSGS']['COMMON']['IMAGE_PRE_UPLOAD']);?></div>
                        </form>
                        
                        <input type="hidden" name="keyName" value="" id="keyName"/>
                    </div>


               
            </div>
                
            </div>
             <div class="text_feild_mainblock" id="submitarea">
                <div class="text_fieldBlock_left"><label id="submitCategory"><img onclick="javascript:clickSave(); addCatData();" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="0" /></label>
                </div>
             </div>
           <div class="text_feild_mainblock" style="display:none;" id="linkarea">
                <div class="text_fieldBlock_left" style="width:20%;"><a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS']."?req=cate&ids=3";?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/add-another-button.png" border="0" /></a>
                </div>
               <div class="text_fieldBlock_left"><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/your-account-button.png" border="0" /></a>
                </div>
             </div>
      
    </div>  <div class="add_classified_formbottom"></div>
    </div>
</form>

<?php } ?>
<!-- END CONTENT AREA-->
