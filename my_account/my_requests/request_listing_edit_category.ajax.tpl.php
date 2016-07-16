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
    $id_level = explode("||", $_REQUEST['id_lvl']);

    $id = $id_level[0];
    $level = $id_level[1];

    $cData = $objCategory->getCategory($id) ;

?>

<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar">
                <div id="banner_add_cads">EDIT LISTINGS </div>
                <div id="text_area_add_cads">
                    <div class="common_text">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. </div>
                </div>


                <div id="list_add_cads">
                    <div align="left">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="list_blackbg_summery">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="13" height="30"></td>
                                            <td class="pgBar">You can add - <span class="pbYellow">15 more</span></td>
                                            <td width="13" height="30"></td>
                                        </tr>
                                    </table>					</td>
                            </tr>
                            <tr>
                                <td height="16"></td>
                            </tr>
                            <tr>
                                <td height="16">

                                    <!--
                                      Display loading image.
                                    -->
                                    <div id="message_holder">
                                        <div id="error_msg" style="width:605px; margin-left:0px">
                                            <?php
                                                if($msg)
                                                {
                                                    echo $objCore->msgBox("CATEGORY",$msg,'100%');
                                                }

                                            ?>
                                        </div>
                                        <table width="100%" border="0" align="center">
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
                                    <div id="add_new_listings">
                                        <input type="hidden" name="displayDiv" id="displayDiv" value="<?php echo $_REQUEST['req']; ?>">
                                        <div id="category_bar">
                                            <div class="list_yellowbg_heading">
                                            <div class="double_arrow"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" border="0" height="14"/></div>

                                            <div class="list_yellow_heading">Edit Requested Category</div></div>
                                            <div speed="400" id="cate" groupname="new_listings">




<!-- START CONTENT AREA-->




<form action="" method="post" name="frmCategory" id="frmCategory">
    <div class="add_classified_formmain" style="padding:41px 0px 10px 0px;">
        <div class="add_classified_formtop "></div>
        <div class="add_newlistings_formmiddle1" id="catDiv">
            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Parent Category :</div>
                <div class="text_fieldBlock_right">
                <label class="textfield_right_font">

                        <?php
                            $PCpath = $objCategory->getParentCpath($cData['parent']);
                            //echo $PCpath[0]['id']."<br />";
                            //print_r($PCpath);
                            for($n=0;$n<count($PCpath);$n++)
                            {
                            $parent[] = $PCpath[$n]['category'];
                            }
                            echo implode(" <b>></b> ", $parent);
                        ?>
                </label>
                </div>
            </div>
            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Category Name :<span class="required_fields">*</span></div>
                <div class="text_fieldBlock_right">
                    <input name="category_name" id="category_name" value="<?php echo $cData['category'];?>" type="text" class="textfield_right_font"/>
                </div>
            </div>
             <?php
                if($cData['level']== 2)
                {
             ?>
            <div class="text_feild_mainblock" id="divImage">
               	
                <div class="text_fieldBlock_left">Category Image :</div>
                <div class="text_fieldBlock_right">
                    
                    <div class="delete_image_div">
                        <!--<div class="dlt_image"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_image.jpg" alt="delete image" width="11" height="12" border="0"/></div>  &nbsp; Delete Image</div>-->
                    </div>

                       <div class="image_path">
                        <!--
                           Image is uploaded and display in this div.
                        -->
                        <div id="uploadingImg">
                            
                           <?php
                                $imgUrl = $objCategory->image($cData['image'],$objCore->_SYS['CONF']['FTP_CATS'],$objCore->_SYS['CONF']['URL_IMAGES_CATS']);
                           ?>
                          <img src="<?php echo $imgUrl;?>" width="60"/>&nbsp;
                          <br />
                        <?php
                            if($cData['image'] != "") {
                        ?>
                          <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $cData['image']; ?>','categ');"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
                        <?php
                            }else
                            {
                        ?>
                        <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','no_image.jpg','categ');"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/zoom.png" /></a>
                        <?php
                            }
                        ?>
                      <br />
                        </div>
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
                            <input type="hidden" name="imgFolder" value="cats" id="imgFolder"/>

                            <input type="file" name="filename" onchange="clearMsg('error_msg');getFieldNames('keyName','frmCategory','zooming'); ajaxUpload(this.form,'<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php','uploadingImg','divProcess');  return true;" />
                        </form>
                        
                        <input type="hidden" name="keyName" value="" id="keyName"/>
                    </div>


               
            </div>
                
            </div>

             <?php
                }
             ?>
            

             <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left"><label id="submitCategory"><img onclick="javascript:editCat('<?php echo $cData['category'];?>','<?php echo $cData['id']; ?>','<?php echo $cData['parent']; ?>','<?php echo $cData['level'] ;?>','<?php echo $PCpath[0]['id'] ;?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="0" /></label>
                </div>
             </div>
           
      
    </div>  <div class="add_classified_formbottom"></div>
    </div>
</form>

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
