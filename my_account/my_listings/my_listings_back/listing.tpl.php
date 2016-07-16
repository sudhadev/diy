<?php
	/*---------------------------------------------------------------------------\
	'    This file is part of shoping Cart in module library of FUSIS            '
	'    (C) Copyright 2004 www.fusis.com                                        '
	' .......................................................................... '
	'                                                                            '
	'    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>          '
	'    FILE            :  my_account/my_listings/listing.tpl.php     	   '
	'    PURPOSE         :  list specifications page of the specification section'
	'    PRE CONDITION   :  commented                                            '
	'    COMMENTS        :                                                       '
	'---------------------------------------------------------------------------*/

$module = "myListing";
$function = "addList";

if($objCore->isAllowed($module, $function)) {

    //echo "==========>".$_REQUEST['tids'];
    $parent_ids = $_REQUEST['tids'];
    
    if($parent_ids == "")
    {
        $cArray = array_values($objCategory->getTopcList());
        $pid = $cArray[0]['id'];
        $subcatId = $objListing->get_dList_topMostCatId($pid);
        //$parent_ids = "1_45";
        $parent_ids = $pid."_".$subcatId;
    }
    
    $arrParentId = explode('_',$parent_ids);
    
    $level = 2;
    $status="Y";

    $subcategory=$objListing->get_dList_category($arrParentId,$status);
    $subcategory_list=$objListing->get_dList_subcategory($arrParentId,$level,$status);
    $credit = $objListing->calculate_credit($objCore->sessCusId);
//echo "**** ".$credit;
    if($credit > 0) {
        $credit = $credit." More";
    } else {
        $credit = $credit;
    }
    ?>

<!-- START BODY AREA-->
<style type="text/css">
    <!--
    .style2 {font-family: Arial, Helvetica, sans-serif}
    -->
</style>

<!-- START CONTENT AREA-->
<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar">
                <img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" />
            </div>
            <div id="main_form_bg_middlebar">
                <div id="banner_add_cads">Manage My Listings</div>
                <div id="text_area_add_cads">
                    <div class="common_text">
                        Browse through the given categories and select the specifications which you needs to be in your listings. Please provide the Manufacturer for each specification. When you click Add to My listings button, the selected Specifications will be added to your listing area and later you will be able to configure price details.
                    </div>
                </div>
                
                <div id="list_add_cads">
                    <div align="left">


                        <form id="" action="" method="post">
                        <!-- Load the content from database. -->
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                           
                            <tr>
                                <td class="list_blackbg_summery">
                                    <div id="list_summery1">You can add <span class="list_summery3" id="credit"><?php echo $credit; ?></span></div>
                                    <div id="list_summery2">You are about to use <span class="list_summery3">0 Listings</span></div>
                                   <!-- <div id="clear_selected_button"><a href="javascript:clear_items();"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/list_clear_button.jpg" width="130" height="17" border="0" /></a></div> -->

                                    <div  id="list_submit_button"><a href="javascript:add_edit();"><img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/list_submit_button.png" border="0" /></a></div>
                                </td>
                            </tr>

                            
                            <!-- Display the name of the category. -->
                            <tr>
                                <td class="list_heading">
                                    <input type="hidden" id="currentPath" name="currentPath" value="<?php echo $objCore->_SYS['CONF']['URL_REQUEST_SUBSCRIPTIONS'];?>"/>
                                    <?php echo $subcategory[0][3];?>
                                </td>
                            </tr>
                            <!-- /Display the name of the category. -->

                            <?php

                                if(count($subcategory_list) == "" && $parent_ids!="")
                                {
                                    $msg=array('ERR','NOT_EXIST_CAT');
                                    if($msg)
                                    {
                            ?>
                                        <tr><td>
                                            <div>
                                                <?php echo $objCore->msgBox("LISTING",$msg,'150%'); ?>
                                            </div>
                                        </td></tr>
                            <?php
                                    }
                                } else
                                {
                                
                            ?>
                                    <tr><td>
                                            <div id="displayMsg" style="display:none">Please wait....</div>
                                    </td></tr>

                            <?php

                               /* if(count($subcategory_list) == "" && $parent_ids!="")
                                {
                                    $msg=array('ERR','NOT_EXIST_CAT');
                                    if($msg)
                                    {
                                        echo $objCore->msgBox("LISTING",$msg,'150%');
                                    }
                                } else
                                {*/
                                    for($i=0;$i<count($subcategory_list);$i++)
                                    {
                            ?>

                                        <tr>
                                            <td class="list_yellowbg_heading">
                                                <div class="double_arrow"><a href="javascript:display_listings('<?php echo $parent_ids."_".$subcategory_list[$i][0];?>',<?php echo $i;?>);"><img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" border="0"></a></div>

                                                <div class="list_yellow_heading" id="third_level_category_<?php echo $i;?>"><?php echo $subcategory_list[$i][3];?></div>

                                            </td>
                                        </tr>

                                        <tr id="listing_add_list_tr_<?php echo $i;?>" style="display:none">

                                            <td><div id="listing_add_list_<?php echo $i;?>">&nbsp;</div></td>
                                        </tr>
                               <?php
                                        }
                                    }
                                ?>

                            <tr> <td height="10">
                                    &nbsp;
                                </td></tr>

                            <tr>
                                <td class="list_blackbg_summery">
                                    <div id="list_summery1">You can add <span class="list_summery3" id="credit"><?php echo $credit; ?></span></div>
                                    <div id="list_summery2">You are about to use <span class="list_summery3">0 Listings</span></div>
                                   <!-- <div id="clear_selected_button"><a href="javascript:clear_items();"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/list_clear_button.jpg" width="130" height="17" border="0" /></a></div> -->

                                    <div  id="list_submit_button"><a href="javascript:add_edit();"><img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/list_submit_button.png" border="0" /></a></div>
                                </td>
                            </tr>
                        </table>
                        </form>


                    </div>

                   
                    <!-- yellow part<div id="form_bg"> -->
                   <!-- <div id="form_outer">
                        <div id="form_middle">
                            <div class="form_middle_text"><br />
                                <br /></div>
                        </div>
                    </div> -->
                </div>
              
            </div>
            <div id="main_form_bg_bottombar"><img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
        </div>
    </div>
    
</div>

<?php } ?>
<!-- END CONTENT AREA-->