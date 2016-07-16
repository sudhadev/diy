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
    

?>

<!-- START CONTENT AREA-->

<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar">
                <div id="banner_add_cads">
                    <?php
                   
                        if($requestId != "1")
                        {
                            echo "ADD NEW CATEGORIES";
                        } else
                        {
                            echo "NEW REQUESTS";
                        }
                    ?>
                </div>
                <div id="text_area_add_cads">
                    <div class="common_text"><?php echo $pageContents['common_text'];?> </div>
                </div>


                <div id="list_add_cads">
                    <div align="left">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="list_blackbg_summery">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="13" height="30"></td>
                                            <td class="pgBar">You have requested <span class="pbYellow">
                    <?php echo $objCategory->getRequestedCategorCount($objCore->sessCusId); ?> 
                    <?php if($objCategory->getRequestedCategorCount($objCore->sessCusId)==1) 
                            echo 'category' ; 
                    echo 'categories'; ?> </span> and  <span class="pbYellow"> 
                    <?php 
                    echo $objSpecification->getRequestedSpecificationCount($objCore->sessCusId);?> 
                                            <?php 
                                           if($objSpecification->getRequestedSpecificationCount($objCore->sessCusId)==1)
                                                    echo 'Product'; 
                                            else 
                                                echo 'Products'; ?></span></td>
                                            <td width="13" height="30"></td>
                                        </tr>
                                    </table>					</td>
                            </tr>
                            <tr>
                                <td height="5"></td>
                            </tr>
                            <tr>
                                <td height="5">

                                    <!--
                                      Display loading image.
                                    -->
                                    <div id="message_holder">
                                        <div id="error_msg" style="width: 670px; margin-left: -18px;">
                                            <?php
                                                if($msg)
                                                {
                                                    echo $objCore->msgBox("SPECIFICATION",$msg,'100%');
                                                } 
                                            
                                            ?>
                                        </div>
                                        <div id="divProcess" style="width: 617px; margin-left: -8px; display: none;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uploading Image...</div>

                                    </div>

                                </td>
                            </tr>

                            
                            <tr>
                                <td>
                                    <div id="add_new_listings">
                                        <input type="hidden" name="displayDiv" id="displayDiv" value="<?php echo $_REQUEST['req']; ?>"> 
                                        <div id="category_bar">
                                           <?php
                                                if($requestId == "1")
                                                {   
                                           ?>
                                            <div class="list_yellowbg_heading">
                                                    <div class="double_arrow"><a href="javascript: saveChanges('cate'); selectCat();"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" border="0" height="14"/></a></div>

                                                    <div class="list_yellow_heading">Add a new Category</div>

                                                </div>
                                            <?php
                                                }
                                            ?>
                                            <div speed="400" id="cate" groupname="new_listings">
                                                <?php include_once("new_listing_category.tpl.php");?>
                                                <input type="hidden" name="topCatId" id="topCatId" value="<?php echo $requestId; ?>">
                                            </div>
                                        </div>

                                        <div id="specAndManu">
                                            <div id="specificaion_bar">
                                                <div class="list_yellowbg_heading">
                                                <div class="double_arrow"><a href="javascript:  saveChanges('spec'); "><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" border="0" height="14"/></a></div>

                                                <div class="list_yellow_heading">
<!--                                                    Request a new Specification-->
                                                    Add a new Product <!-- Changed by Sudharshan - CR by Jason -->
                                                </div></div>
                                                <div speed="400" id="spec" groupname="new_listings" style="display:block">
                                                    <?php include_once("new_listing_specification.tpl.php");?>
                                                    <input type="hidden" name="topCatId" id="topCatId" value="<?php echo $requestId; ?>">
                                                </div>
                                            </div>
                                        
                                            <div id="manufacturer_bar">
                                                <div class="list_yellowbg_heading">
                                                <div class="double_arrow"><a href="javascript:  saveChanges('manufac');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" border="0" height="14"/></a></div>

                                                <div class="list_yellow_heading">Add a new Manufacturer</div></div>
                                                <div speed="400" id="manufac" groupname="new_listings">
                                                    <?php include_once("new_listing_manufacturer.tpl.php");?>
                                                    <input type="hidden" name="topCatId" id="topCatId" value="<?php echo $requestId; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td height="10"></td>
                            </tr>

                        </table>

                    </div>
                </div>

                <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
            </div>
        </div>
    </div>
</div>

<?php } ?>
<!-- END CONTENT AREA-->
