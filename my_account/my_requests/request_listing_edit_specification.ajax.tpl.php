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
    $arrParentId = explode('||',$_REQUEST['ids']);
    $manufacturer = $_REQUEST['manu'];
    $list=$objSpecification->get_dList_edit($arrParentId);
    $cData = $objCategory->getCategory($arrParentId[2]);
    
?>

<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar">
                <div id="banner_add_cads">Edit Requested Specification </div>
                <div id="text_area_add_cads">
                    <div class="common_text">
                    Below is your Requested Specification.<br/>
At present, the administrator hasn’t acted on this request, and so it can still be edited. Only the specification and keywords are editable.
If you want to delete this entry, return to “Requested Specifications” where you can delete it from your list.
Go to “New Requests” to enter a new specification
                    </div>
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
                                        <div id="specificaion_bar">
                                                <div class="list_yellowbg_heading">
                                                <div class="double_arrow"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" border="0" height="14"/></div>

                                                <div class="list_yellow_heading">Edit Requested Specification</div></div>
                                                <div speed="400" id="spec" groupname="new_listings">



<!-- START CONTENT AREA-->

<form action="" method="post" enctype="multipart/form-data" name="personal_details" id="personal_details">
    <div class="add_classified_formmain" style="padding:40px 0px 10px 0px;">
        <div class="add_classified_formtop"></div>
        <div class="add_newlistings_formmiddle2">
            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Category :</div>
                <div class="text_fieldBlock_right">
                    <label class="textfield_right_font">
                        <?php
                            $PCpath = $objCategory->getParentCpath($cData['parent']);
                            for($n=0;$n<count($PCpath);$n++)
                            {
                                $parent[] = $PCpath[$n]['category'];
                            }
                            echo implode(" <b>></b> ", $parent);
                        ?>
                    </label>
                    
                </div>
            </div>

             <?php
                if($manufacturer)
                {
            ?>
            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Manufacturer :</div>
                <div class="text_fieldBlock_right">
                    <label class="textfield_right_font">
                        <?php echo $manufacturer; ?>
                    </label>

                </div>
            </div>
            <?php
                }
            ?>

            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Specification Name :<span class="required_fields">*</span></div>
                <div class="text_fieldBlock_right">
                    <input name="specification" id="specification" value="<?php echo $list[0][4]; ?>" type="text" class="textfield_right_font"/>
                </div>
            </div>
           
            <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">Key Words:<span class="required_fields">*</span></div>
                <div class="text_fieldBlock_right">
                    <textarea name="keywords" id="keywords" cols="23" rows="3" class="textfield_right_font"><?php echo $list[0][10]; ?></textarea>
                </div>
            </div>

              <div class="text_feild_mainblock">
                <div class="text_fieldBlock_left">
                    <input name="keyName" id="keyName" value="<?php echo $list[0][12]; ?>" type="hidden"/>
                    <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_requests/?f=spec&category=1"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/cancel.jpg" border="" ></a>
                    <label id="submitSpecification"><img onclick="javascript:editSpec('<?php echo $list[0][1]."_".$list[0][2]."_".$list[0][3]."_".$list[0][0];?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="0" /></label>
                </div>
              </div>

        </div>
        <div class="add_classified_formbottom"></div>
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
