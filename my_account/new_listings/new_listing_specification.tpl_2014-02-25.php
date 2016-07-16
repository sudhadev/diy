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
                $selecId = $arryids[0];
                $type = "add_drop_list_subcats";

            } break;

            case "2":
            {
                $request_Id = $arryids[1];
                $requestId = $objCategory->arryMerge($request_Id,$arryids[0]);
                $selecId = $arryids[1];
                $type = "add_drop_list_subcats";
              
            } break;

            case "3":
            {
                $requestId = $arryids[1];
                $selecId = $arryids[2];
                $type = "add_drop_list_subcats";

            } break;
        }

        $list_parent = $objCategory->getParentCpath($requestId);

        //echo $list[0]['category']."--------------------------<br />";
       //  echo $list[1]['category']."--------------------------<br />";
       
       
        
?>

<!-- START CONTENT AREA-->

<form action="" method="post" enctype="multipart/form-data" name="frmSpecification" id="frmSpecification">
    <div class="add_classified_formmain" style="padding:73px 0px 10px 0px;">
        <div class="add_classified_formtop"></div>

        <div class="add_newlistings_formmiddle">
          <div id="specialInfo" class="commonInfoBox" style="width: 610px;margin-top:10px;margin-left:5px;display:block;">
                <?php echo $pageContents['infoAddSpecificaton'];?>
          </div>
            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Category : <span class="required_fields">*</span></div>
                <div class="text_fieldBlock_right">
                    <label class="text" style="font-weight:bold;font-size:11px;">
                        <?php
                        if($list_parent[1]['category'] != "")
                        {
                            echo $list_parent[0]['category']." > ".$list_parent[1]['category']." ><br /><br />";
                        } else
                        {
                            echo $list_parent[0]['category']." ><br /><br />";
                        }
                            
                         ?>
                    </label>
                    <?php
                        echo $objCategory->getSubcList($requestId ,$type,'cat_spec_selection','textfield_right_font',$selecId,'onchange="javascript:doChanges();"');
                    ?>
                </div>
            </div>
            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Product Name :<span class="required_fields">*</span></div><!--Changed by Sudharshan - CR by Jason -->
                <div class="text_fieldBlock_right">
                    <input name="specification" id="specification" value="" type="text"  maxlength="<?php echo $objSpecification->getMaxLength();?>"  class="textfield_right_font" onblur="doChanges();"/>
                </div>
            </div>
            
            <div class="text_feild_mainblock" id="divImage">
                <div class="text_fieldBlock_left">Product Image :</div><!--Changed by Sudharshan - CR by Jason -->
            <div class="image_path" style="padding-left: 10px;">
                        <!--
                           Image is uploaded and display in this div.
                        -->
                        <div id="specdivProcess"></div>
                        <div id="specuploadingImg"></div>
                        <!--
                           Display zoom icon in here.
                        -->
                        <div id="zooming" style="display:none">
                            <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','categ');"><img alt="Zoom" border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                        </div>


                        <!--
                            Use this form to display file browse part.
                        -->
                        <form id="frmSpecImage" name="frmSpecImage" action="" style="vertical-align:top">
                            <input type="hidden" name="filename" value="filename" />
                            <input type="hidden" name="imgFolder" value="specs_request" id="imgFolder"/>

                            <input type="file" name="filename" onchange="doChanges();clearMsg('error_msg');getFieldNames('keyName','frmSpecification','zooming'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','specuploadingImg','divProcess');  changeHeight();this.value='';return true;" />
                                                          <div class="common_text" style="font-size:10px;"> <br/> <?php  echo str_replace("{%MAX_SIZE%}",$objCore->_SYS['CONF']['F_SIZE_PRINT']['IMAGE'],$objCore->_SYS['MSGS']['COMMON']['IMAGE_PRE_UPLOAD']);?></div>
                        </form>
                        
                        <input type="hidden" name="keyName" value="" id="keyName"/>
                    </div>
                </div>
            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Manufacturer :</div>
                <div class="text_fieldBlock_right">
                    <input name="manufacturer" id="manufacturer" value="" type="text" class="textfield_right_font" 
                    onkeypress="doChanges(); doSearch('manufacturer','<?php echo $objCore->_SYS['CONF']['URL_AUTOSUGGEST_MODULE'];?>/manufacturer_search.php');"/>
                </div>
            </div>
            
            <input type="hidden" name="keywords" id="keywords" value=" "/>
<!--            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Keywords:<span class="required_fields">*</span></div>
                <div class="text_fieldBlock_right">
                    <textarea name="keywords" id="keywords" cols="23" rows="3" class="textfield_right_font" onblur="doChanges();"></textarea>
                </div>
            </div>-->
            
<!--            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Supplier Code:</div>
                <div class="text_fieldBlock_right">
                    <input name="supplier_code" id="supplier_code" value="" type="text" class="textfield_right_font" onblur="doChanges();"/>
            </div>
            </div>-->
              <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">
                    <label id="submitSpecification"><img onclick="javascript:clickSave(); addSpecData();" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="0" /></label>
                </div>
              </div>
            
        </div>
        <div class="add_classified_formbottom"></div>
    </div>
</form>



<?php } ?>
<!-- END CONTENT AREA-->
