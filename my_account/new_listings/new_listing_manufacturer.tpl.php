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
   //----------- Added by saliya ---
   // remove if category drop down should be restricted acording to the newly added specifications
        $requestId = $arryids[0];
        $selecId = $arryids[0];
   // <------------------------------------------
$type = "add_drop_list_subcats_spec_exist";

$list_parent = $objCategory->getParentCpath($requestId);

/*if($_REQUEST['specId'] != "")
{
    
}*/
                
//echo $list[0]['category']."--------------------------<br />";
//  echo $list[1]['category']."--------------------------<br />";
// print_r($list);

?>

<!-- START CONTENT AREA-->

<form action="" method="post" enctype="multipart/form-data" name="personal_details" id="personal_details">

    <div class="add_classified_formmain" style="padding:103px 0px 10px 0px;">
        <div class="add_classified_formtop"></div>
        <div class="add_newlistings_formmiddle">
            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Category : <span class="required_fields">*</span></div>
                <div class="text_fieldBlock_right">
                     <label class="">
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
                        echo $objCategory->getSubcList($requestId ,$type,'cat_spec_select','textfield_right_font',$selecId,"onchange=javascript:refreshDropDown('manufac','','');");
                    ?>
                </div>
            </div>
            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Product : <span class="required_fields">*</span></div>
                <div class="text_fieldBlock_right" id="spec_drop_down">
                    
                    
                </div>
            </div>
            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Manufacturer : <span class="required_fields">*</span></div>
                <div class="text_fieldBlock_right">
                    <input name="manu_name" id="manu_name" value="" type="text" class="textfield_right_font" onkeypress="doChanges(); doSearch('manu_name','<?php echo $objCore->_SYS['CONF']['URL_AUTOSUGGEST_MODULE'];?>/manufacturer_search.php');"/>
                </div>
            </div>

         
            <div class="text_fieldBlock_left"><label id="submit_manufacturer"><img onclick="javascript:clickSave(); addManufacData();" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="0" /></label>
            </div>
        </div>
        <div class="add_classified_formbottom"></div>
    </div>
</form>

<?php } ?>
<!-- END CONTENT AREA-->
