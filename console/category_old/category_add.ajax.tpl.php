<?php

    /*--------------------------------------------------------------------------\
    '    This file is part of shoping Cart in module library of FUSIS           '
    '    (C) Copyright 2004 www.fusis.com                                       '
    ' ..........................................................................'
    '                                                                           '
    '    AUTHOR          :  Sadaruwan Hettiarachchi <sadaruwan@fusis.com>       '
    '    FILE            :  console/category/category_add.ajax.tpl.php          '
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

if(!is_object($objCategory))
{
    $objCategory = new Category();
}

$module = "category";
$function = "addCategory";

if($objCore->isAllowed($module, $function))
{
    $arrParentId = explode('_',$_REQUEST['ids']);
    if(count($arrParentId) >=3) {
        $msg=array('ERR','CANNOT_ADD');
        if($msg)
        {
            echo $objCore->msgBox("CATEGORY",$msg,'75.99%')."||".$msg[0];
        }
    } else
    {
        $category_list = $objCategory->getCategory(end($arrParentId));
        if($msg)
        {
            echo $objCore->msgBox("CATEGORY",$msg,'75.99%');
        }

        ?>

<div id="toolbar-box">
    <div class="t"></div>
    <div class="m">

        <!-------------- Function form----------->

        <form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
            <fieldset id="page-middle-middle-content">
                <legend>Add New Sub-Category  </legend>
                <table class="admintable" width="470">
                    <tr>
                        <td class="key" align="right">Category Name<span class="required_fields">*</span></td>
                        <td><input name="cname" class="text_area" id="cname" size="36" type="text" value="<?php echo $_POST['cname'];?>"/></td>
                    </tr>
                    <tr>
                        <td class="key" align="right">Parent Category<span class="required_fields">*</span></td>
                        <td><?php echo $category_list["category"];?>	</td>
                    </tr>
        <?php
        if(count($arrParentId) == 2) {
            ?>
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
                                <a href="javascript:doZoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','categ');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
                            </div>
                <!--
                  Use this form to display file browse part.
                -->
                            <form action="scripts/ajaxupload.php" method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
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

<!--<input name="image" class="text_area" type="file" id="image" size="22"/> -->
                        </td>
                    </tr>
        <?php
        }
        ?>

                    <tr>
                        <td class="key" align="right">Category Description</td>
                        <td><textarea id="cdescription" class="text_area" rows="3" cols="25" name="cdescription" ><?php echo $_POST['cdescription'];?></textarea></td>
                    </tr>
                    <tr>
                        <td class="key" align="right">Category Status<span class="required_fields">*</span></td>
                        <td><select class="cstatus" name="cstatus" id="cstatus" >
                                <option value="1">Show</option>
                                <option value="0">Hide</option>
                            </select></td>
                    </tr>


                    <tr>
                        <td class="key" align="right" width="131">&nbsp;</td>
                        <td width="327"><label>
        <!--
          Use this hidden field to keep the image key.
        -->
                                <input type="hidden" name="keyName" value="" id="keyName"/>
                                <input type="hidden" name="ulid" id="ulid" value="<?php echo $_REQUEST['ulid'];?>" />
                                <input type="button" name="Submit" value="Add" onclick="addData('<?php echo $_REQUEST['ids']; ?>');" />
                            </label></td>
                    </tr>
                </table>
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

<?php } }?>
