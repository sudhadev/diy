<?php
/* ---------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS            '
  '    (C) Copyright 2004 www.fusis.com                                        '
  ' .......................................................................... '
  '                                                                            '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>          '
  '    FILE            :  my_account/my_listings/listing.tpl.php     	   '
  '    PURPOSE         :  list specifications page of the specification section'
  '    PRE CONDITION   :  commented                                            '
  '    COMMENTS        :                                                       '
  '--------------------------------------------------------------------------- */

$module = "myListing";
$function = "addList";

if ($objCore->isAllowed($module, $function)) {

    $parent_ids = $_REQUEST['tids'];
    $level = 2;
    $status = "Y";

    if ($objCore->curSection() == "my_listings_edit") {
        if ($parent_ids == "") {
            $secondLevelCatList = $objCategory->getCategoryByCustomerListing($objCore->sessCusId, 1, 1);
            $parent_ids = "1_" . $secondLevelCatList[0][0];
            $arrParentId = explode('_', $parent_ids);
        }
        $arrParentId = explode('_', $parent_ids);
        $secondLevelCatList = $objCategory->getCategoryByCustomerListing($objCore->sessCusId, 1, 1);
        $subcategory_list = $objCategory->getCategoryByCustomerListing($objCore->sessCusId, $level, $arrParentId[1]);
    } else {
        if ($parent_ids == "") {
            $cArray = array_values($objCategory->getTopcList());
            $pid = $cArray[0]['id'];
            $subcatId = $objListing->get_dList_topMostCatId($pid);
            //$parent_ids = "1_45";
            $parent_ids = $pid . "_" . $subcatId;
        }

        $arrParentId = explode('_', $parent_ids);

        $subcategory_list = $objListing->get_dList_subcategory($arrParentId, $level, $status);
    }

    /*
     * Get 2nd Level category Name for display
     */
    $displayCategory = $objCategory->getCategory($arrParentId[1]);

    // changed by saliya 24th Nov 2010
    $listingData = $objListing->calculate_credit($objCore->sessCusId); //echo "------------------------------------------";
    
    $credit = $listingData['listCanAdd']; //$objListing->calculate_credit($objCore->sessCusId);
//echo "**** ".$credit;
    if ($credit > 0) {
        $credit = $credit . " More";
    } else {
        $credit = 0;
    }
?>

    <!-- START BODY AREA-->
    <style type="text/css">
        <!--
        .style2 {font-family: Arial, Helvetica, sans-serif}
        -->
    </style>

    <!-- START CONTENT AREA-->
    <input type="hidden" id="lastClicked" value="" >
    <div id="right_bar_middle">
        <div id="main_form_bg">
            <div id="main_form_bg_middle">
                <div id="main_form_bg_topbar">
                    <img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/main_form_bg_top.jpg" />
                </div>
                <div id="main_form_bg_middlebar">
                    <div id="banner_add_cads">
                    <?php echo $objCore->curSection() == "my_listings" ? "Add Listings" : "Edit My Listings"; ?>
                </div>
                <div id="text_area_add_cads">
                    <div class="common_text">
                        <?php echo $objCore->curSection() == "my_listings" ? $pageContents['listing_add'] : $pageContents['my_listing_edit']; ?>
                    </div>


                    <div style="width: 630px; margin-top: 10px; margin-left: 5px; display: block;"  id="infoBox">
                    </div>


                </div>

                <div id="list_add_cads">
                    <div align="left">


                        <form id="" action="" method="post">
                            <!-- Load the content from database. -->
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">

                                <tr>
                                    <td class="list_blackbg_summery">
                                        <div id="list_summery1">You can add <span class="list_summery3 credit" id="credit"><?php echo $credit; ?> </span></div>
                                        <div id="list_summery2"> <?php //You are about to use <span class="list_summery3">0 Listings</span>;     ?></div>
                                       <!-- <div id="clear_selected_button"><a href="javascript:clear_items();"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/list_clear_button.jpg" width="130" height="17" border="0" /></a></div> -->

                                        <div  id="list_submit_button"><a href="javascript:add_edit();"><img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/list_submit_button.png" border="0" /></a></div>
                                    </td>
                                </tr>


                                <!-- Display the name of the category. -->
                                <tr>
                                    <td class="list_heading">
                                        <input type="hidden" id="currentPath" name="currentPath" value="<?php echo $objCore->_SYS['CONF']['URL_REQUEST_SUBSCRIPTIONS']; ?>"/>

                                        <?php echo $displayCategory['category']; ?>
                                    </td>
                                </tr>
                                <!-- /Display the name of the category. -->

                                <?php
                                        if (count($subcategory_list) == "" && $parent_ids != "") {
                                            $msg = array('ERR', 'NOT_EXIST_CAT');
                                            if ($msg) {
                                ?>
                                                <tr><td>
                                                        <div>
                                                        <?php echo $objCore->msgBox("LISTING", $msg, '150%'); ?>
                                                        </div>
                                                </td></tr>
                                    <tr><td>
                                            <table>
                                                <tbody>
                                                    <tr><td height="5px;"></td></tr>
                                                    <tr><td>
                                                            <div class="top_group_main">
                                                                <div class="top_group_left"></div>


                                                                <div class="top_group_middle">
                                                                    <div class="my_listings_addbtn">
                                                                        <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS'] . "?req=cate&ids=1_" . $arrParentId[1]; ?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/request_new_category.jpg" alt="Request a new Category" /></a>
                                                                    </div>
                                                                </div>
                                                                <div class="top_group_right"></div>
                                                            </div>
                                                        </td></tr>

                                                </tbody>
                                            </table>
                                        </td></tr>


                                <?php
                                            }
                                        } else {
                                ?>
                                            <tr><td>


                                        <?php if ($listingData['listAvailable'] < 20) {                                    
                                        ?><div id="displayMsg" style="display:block">
                                                <?php  echo $objListing->infoBox('limitExeed',$pageContents['infoSubsAlert'],$listingData);       ?>
                                                </div> <input type="hidden" id="traceInfoBox" value="y"/>
                                                <div id="msgWrapper"></div>

<?php } else {
?><div id="displayMsg" style="display:none"><div id="msgWrapper"></div>
                                                    Please wait....</div><input type="hidden" id="traceInfoBox" value=""/>
<?php } ?>



<?php
                                            /* if(count($subcategory_list) == "" && $parent_ids!="")   </td></tr>
                                              {
                                              $msg=array('ERR','NOT_EXIST_CAT');
                                              if($msg)
                                              {
                                              echo $objCore->msgBox("LISTING",$msg,'150%');
                                              }
                                              } else
                                              { */
                                            for ($i = 0; $i < count($subcategory_list); $i++) {
?>

                                        <tr>
                                            <td class="list_yellowbg_heading">
                                                <div class="double_arrow"><a href="javascript:display_listings('<?php echo $parent_ids . "_" . $subcategory_list[$i][0]; ?>',<?php echo $i; ?>);"><img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/double-arrows.jpg" width="14" height="14" border="0"></a></div>

                                                <div class="list_yellow_heading" id="third_level_category_<?php echo $i; ?>"><?php echo $subcategory_list[$i][3]; ?></div>

                                            </td>
                                        </tr>

                                        <tr id="listing_add_list_tr_<?php echo $i; ?>" style="display:none">

                                            <td><div id="listing_add_list_<?php echo $i; ?>">&nbsp;</div></td>
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
                                        <div id="list_summery1">You can add <span class="list_summery3 credit" id="credit1"><?php echo $credit; ?></span></div>
                                        <div id="list_summery2"> <?php //You are about to use <span class="list_summery3">0 Listings</span>;     ?></div>
                                       <!-- <div id="clear_selected_button"><a href="javascript:clear_items();"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/list_clear_button.jpg" width="130" height="17" border="0" /></a></div> -->

                                        <div  id="list_submit_button"><a href="javascript:add_edit();"><img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/list_submit_button.png" border="0" /></a></div>
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
                    <div id="main_form_bg_bottombar"><img alt="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/main_form_bg_bottom.jpg" /></div>
                </div>
            </div>

        </div>

<?php } ?>
<!-- END CONTENT AREA-->