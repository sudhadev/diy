<?php
/* ---------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS            '
  '    (C) Copyright 2004 www.fusis.com                                        '
  ' .......................................................................... '
  '                                                                            '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>          '
  '    FILE            :  my_account/my_listings/listing_add.ajax.tpl.php     	   '
  '    PURPOSE         :  list specifications page of the specification section'
  '    PRE CONDITION   :  commented                                            '
  '    COMMENTS        :                                                       '
  '--------------------------------------------------------------------------- */


require_once("../../classes/core/core.class.php");
$objCore = new Core;
$objCore->auth(1, true);

require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
if (!is_object($objListing)) {
    $objListing = new Listing;
}
if (!is_object($objCategory)) {
    $objCategory = new Category;
}

require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
if (!is_object($objComponent)) {
    $objComponent = new Component();
}





$module = "myListing";
$function = "addList";

if ($objCore->isAllowed($module, $function)) {
    $arrParentId = explode('_', $_POST['ids']);

    $status = "Y";
    $logId = $objCore->sessCusId;
    if ($objCore->curSection() == "my_listings_edit")
        $filter = true;
    $specification_list = $objListing->get_dList_specification($arrParentId, $status, $objCore->sessCusId, $filter);

    /*
     * Get average prices
     */$avgArray = $objListing->getAvgByThirdlevelCategory($arrParentId[2]);

    // Content inclusion
    include("my_listing.content.php");

    if ($specification_list == "") {
        //echo "<br/> We should add a link/button for \"Request Specificatoin\" from this area<br/><br/><br/>";
        $msg = array('ERR', 'NOT_EXIST_SPEC');
        $i = 1;
        if ($msg) {
            $listingData = $objListing->calculate_credit($objCore->sessCusId); // take the count of listings that can be add
            //print_r($listingData);
            if ($listingData['listCanAdd'] < 20) {
                $infoBox = $objListing->infoBox('limitExeed', $pageContents['infoSubsAlert'], $listingData) . '<input type="hidden" id="traceInfoBox" value="y"/>'

                ;
            } else {
                echo '  <style>.msgBox {width:94%;}</style>   ';
                $infoBox = '<input type="hidden" id="traceInfoBox" value=""/>';
            }
            echo $objCore->msgBox("LISTING", $msg, '99%') . $infoBox . "||" . $i . "||";
        }
        ?>



        <table>
            <tbody>
                <tr><td height="5px;"></td></tr>
                <tr><td>
                        <div class="top_group_main">
                            <div class="top_group_left"></div>
                            <div class="top_group_middle">
                                <div class="my_listings_addbtn">
                                    <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS'] . "?req=spec&ids=" . $_POST['ids']; ?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/request_new_spec.jpg" alt="Request a new Specification" /></a>
                                </div>

                                <div class="my_listings_addbtn">
                                    <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS'] . "?req=manufac&ids=" . $_POST['ids']; ?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/add_new_manuf.jpg" alt="Add a new Manufacturer" /></a>
                                </div>

                            </div>


                            <div class="top_group_right"></div>
                        </div>
                    </td></tr>
                <tr><td height="5px;"></td></tr>
            </tbody>
        </table>
        <?php
    } else {
        $arrRowStyle[0] = "";
        $arrRowStyle[1] = "cadd_descriptionrow_gray";
        /*
         * Create the option list for bulk discount drop down
         * - Added by Saliya Wijesinghe 17th September 2009
         */
        $bdOptionList = '';
        $blMax = $objCore->gConf['BULK_MAX'];
        $blDiff = $objCore->gConf['BULK_DIFFERENCE'];
        for ($bl = 0; $bl < $blMax; $bl+=$blDiff) {
            $bdOptionList.='<option value="' . $bl . '" >' . $bl . '</option>' . "\n";
        }
        ?>

        <!-- Load the content from database. -->

        <input name="specCount"  id="specCount" type="hidden" value="<?php echo count($specification_list); ?>" />
        <table width="665" cellspacing="0" cellpadding="0" border="0" align="center">
            <tbody>
                <tr> <td height="10"></td></tr>
                <tr>
                    <td id="grid_left_end" class="grid_end" width="6" height="36"/>
                    <td class="grid_middle chagrs_grid_heading" width="230" height="36">Products</td><td class="grid_break" width="1" height="36"/>
                    <td class="grid_middle chagrs_grid_heading" width="60" height="36">Average<br />Price (<?php echo $objCore->_SYS['CONF']['CURRENCY']; ?>)</td><td class="grid_break" width="1" height="36"/>
                    <td class="grid_middle chagrs_grid_heading" width="60" height="36">Unit<br />Cost (<?php echo $objCore->_SYS['CONF']['CURRENCY']; ?>) </td><td class="grid_break" width="1" height="36"/>
                    <td class="grid_middle chagrs_grid_heading" width="70" height="36">Bulk<br />Discount</td><td class="grid_break" width="1" height="36"/>
                    <td class="grid_middle chagrs_grid_heading" width="60" height="36">Bulk<br />Price (<?php echo $objCore->_SYS['CONF']['CURRENCY']; ?>) </td><td class="grid_break" width="1" height="36"/>
                    <td class="grid_middle chagrs_grid_heading" width="60" height="36">Delivery<br /> (<?php echo $objCore->_SYS['CONF']['CURRENCY']; ?>) </td><td class="grid_break" width="1" height="36"/>
                    <td class="grid_middle chagrs_grid_heading" width="60" height="36">Listing<br />Active</td><!--<td class="grid_break" width="1" height="36"/>
                    <td class="grid_middle chagrs_grid_heading" width="50" height="36">Clear Item</td>-->

                    <td id="grid_right_end" class="grid_end" width="6" height="36"/>
                </tr>
                <?php
                $lstCount = 0; // to store number of listings

                $specListKeys = array_keys($specification_list);
                $tr_count = 0;

                for ($n = 0; $n < count($specListKeys); $n++) {
                    ?>

                    <?php
                    $manufactListKeys = array_keys($specification_list[$specListKeys[$n]]);
                    for ($lsIt = 0; $lsIt < count($manufactListKeys); $lsIt++) {
                       if($specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][7]!='M'){
                        $ids = $arrParentId[0] . "_" . $arrParentId[1] . "_" . $arrParentId[2] . "_" . $specListKeys[$n] . "_" . $manufactListKeys[$lsIt] . "_" . $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][11];
                        ?>


                        <tr><td>
                                <input type="hidden" value="<?php echo $ids; ?>" id="ids[<?php echo $lstCount; ?>]" name="ids[<?php echo $lstCount; ?>]">
                                <input type="hidden" value="<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="eleId[<?php echo $lstCount; ?>]" name="eleId[<?php echo $lstCount; ?>]">

                                <input type="hidden" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][12]; ?>" name="list_img_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="list_img_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />
                                <input type="hidden" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][22]; ?>" name="list_img2_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="list_img2_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />
                                <input type="hidden" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][23]; ?>" name="list_img3_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="list_img3_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />
                                <input type="hidden" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][24]; ?>" name="list_img4_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="list_img4_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />
                                <input type="hidden" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][13]; ?>" name="list_des_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="list_des_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />
                                <input type="hidden" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][14]; ?>" name="list_sup_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="list_sup_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />
                                <input type="hidden" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][21]; ?>" name="list_spec_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="list_spec_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />
                                <input type="hidden" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][20]; ?>" name="list_head_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="list_head_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />
                                <input type="hidden" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][17]; ?>" name="list_del_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="list_del_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />
                                <input type="hidden" value="<?php if (($specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][18]) > 0) echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][18];
                else echo "Free"; ?>" name="list_rate_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="list_rate_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />
                                <input type="hidden" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][18]; ?>" name="actual_list_rate_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="actual_list_rate_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />

                                <input type="hidden" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][19]; ?>" name="list_url_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="list_url_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />

                                <input type="hidden" id="list_title_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" name="list_title_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][1]; ?>"/>



                                       <div  id="div_img_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" ></div>


                            </td></tr>
                        <?php if ($lsIt == 0) { ?>
                            <tr class="<?php echo $arrRowStyle[$n % 2]; ?>">
                                <td width="6"/>
                                <td class="chagrs_grid_text" colspan="15" style="font-size:11px;font-weight:bolder; padding: 8px 0px 0px 0px;">
                                    <?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][0]; ?></td>
                                <td width="6"></td>
                            </tr>
                        <?php } // end if ?>
                        <tr class="<?php echo $arrRowStyle[$n % 2]; ?> tr-class" id="tr-<?php echo $tr_count; ?>">
                            <td width="6" height="41"></td>
                            <td class="chagrs_grid_text list_style_spc2" style="padding-left:15px;">                        
                                <?php
                                if ($specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][12] == "") {

                                    $imgUrl = $objListing->image($specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][15], $objCore->_SYS['CONF']['FTP_SPECS'], $objCore->_SYS['CONF']['URL_IMAGES_SPECS'], '');
                                } else {
                                    $imgUrl = $objListing->image($specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][12], $objCore->_SYS['CONF']['FTP_LISTINGS'], $objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'], $objCore->sessCusId);
                                }
                                ?>
                                <a href="javascript: addExtraDetails('<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>','<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][11]; ?>','tr-<?php echo $tr_count; ?>');"	><img src="<?php echo $imgUrl; ?>" id="thumb_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>"  width="30" border="1" alt="Click here to change the image"/></a>

                                <a style="color: #000;font-size: 12px;font-weight: normal;" href="javascript: addExtraDetails('<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>','<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][11]; ?>','tr-<?php echo $tr_count; ?>');">  <?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][1]; ?> </a>
                                <br /> <a class="" href="JavaScript:newPopup('<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT']; ?>/my_listings/other-charges.php?pg=1&cid=<?php echo $arrParentId[2]; ?>&sid=<?php echo $specListKeys[$n]; ?>&mid=<?php echo $manufactListKeys[$lsIt]; ?>&t=<?php echo time(); ?>');">What are others charging?</a>

                            </td>
                            <td></td>
                            <td class="chagrs_grid_text list_style numeric_texts"><?php /* Avarage Price   */ echo number_format($avgArray[$specListKeys[$n]][$manufactListKeys[$lsIt]], 2); //$specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][2]; ?></td>
                            <td></td>
                            <td class="chagrs_grid_text"><input type="text" value="<?php /* Unit Cost */ echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][3]; ?>" name="unit_cost_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" class="numeric_txtfield" id="unit_cost_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" size="4" 
                                                                onclick="change_div_color('tr-<?php echo $tr_count; ?>');" onchange="checkValue('<?php echo $ids; ?>', '<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>', null);"/></td>
                            <td></td>
                            <td class="chagrs_grid_text">
                                <select name="select_bulk_discount_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="select_bulk_discount_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" class="mng_mylistings_short" 
                                        onchange="checkValue('<?php echo $ids; ?>', '<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>', 'tr-<?php echo $tr_count; ?>');">
                <?php
                $optSelectedValue = $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][4];
                echo str_replace('value="' . $optSelectedValue . '"', 'value="' . $optSelectedValue . '" selected ', $bdOptionList)
                ?>
                                </select>              </td>
                            <td></td>
                            <td class="chagrs_grid_text"><input type="text" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][5]; ?>" name="bulk_price_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="bulk_price_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>"  class="numeric_txtfield" size="4" 
                                                                onclick="change_div_color('tr-<?php echo $tr_count; ?>');"  onchange="checkValue('<?php echo $ids; ?>', '<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>', null);"/></td>
                            <td></td>
                <?php
                $delivery_rate_value = $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][6];
                /*        echo $delivery_rate_value;
                  if($delivery_rate_value=='0'){
                  $print_value = "Ring";
                  }
                  else if($delivery_rate_value==""){
                  $print_value = "";
                  }else{
                  $print_value = $delivery_rate_value;
                  } */ //echo $delivery_rate_value;
                if ($delivery_rate_value == 'Free' || $delivery_rate_value == '0.00' || $delivery_rate_value == '') { /* Add by maduranga */
                    $print_value = "Free";
                } else if ($delivery_rate_value == 'Ring') {
                    $print_value = "Ring";
                } else {
                    $print_value = $delivery_rate_value;
                }
                ?>

                            <td class="chagrs_grid_text">
                                <input type="hidden" value="<?php echo $delivery_rate_value; ?>" name="delivery_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="delivery_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" class="numeric_txtfield" size="4" 
                                       onclick="change_div_color('tr-<?php echo $tr_count; ?>');"  onchange="checkValue('<?php echo $ids; ?>', '<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>', null);"/>

                                <div id="delivery_show_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>_div" class="numeric_txtfield" ><?php if ($print_value) {
                    echo $print_value;
                } else {
                    echo "&nbsp;";
                } ?></div>

                                <input type="hidden" value="<?php echo $print_value; ?>" name="delivery_show_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="delivery_show_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" class="numeric_txtfield" size="4" 
                                       onclick="change_div_color('tr-<?php echo $tr_count; ?>');" onchange="checkValue('<?php echo $ids; ?>', '<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>', null);"/></td>
                            <td></td>
                            <td class="chagrs_grid_text">
                                    <?php $lstStatus = $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][7]; ?>
                                <select id="listing_active_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" class="mng_mylistings_short" name="listing_active_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" 
                                        onchange="changeColor('<?php echo $ids; ?>', '<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>', 'tr-<?php echo $tr_count; ?>');"
                                        style="<?php if ($lstStatus == "Y") { ?> border-color:#009966; <?php } else { ?> border-color:#FF0000; <?php } ?>;">
                                    <option value="Y"<?php
                            if ($lstStatus == "Y") {
                                echo " selected ";
                            }
                            ?> >Yes </option>
                                    <option value="N"<?php
                            if ($lstStatus == "N" || $lstStatus == "") {
                                echo " selected ";
                            }
                                    ?> >No </option>
                                </select>

                                <input type="hidden" value="<?php echo $lstStatus == "" ? '*' : $lstStatus; ?>" name="curstatus_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" id="curstatus_<?php echo $specListKeys[$n] . "_" . $manufactListKeys[$lsIt]; ?>" />
                            </td>
                            <?php if($specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][11]>0){ ?>
                            <?php $actual_link = $_SERVER['HTTP_REFERER'];   
                            $mybool=strlen($actual_link);  
                            $ar1=explode('?', $actual_link, 2);
                            $mytable=explode('&', $ar1[1], 2);
                            $table= $mytable[0];      
                            $myurl;                      
                            ?>
                            <?php if(!empty($table)){$myurl=$ar1[0].'?'.$table.'&';}else{$myurl=$ar1[0].'?';}
                            $myurl.="f=del_from_edit&delId=".$specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][11];
                            ?>
                            
                            <td align="center">
                                <a href="<?php echo $myurl;?>" alt="Delete" title="Delete">
                                    <img height="13" width="12" src="http://diypricecheck.co.uk/console/images/icons/delete.png">
                                </a>
                            </td>
                            <?php } ?>
                            <td></td>
                <!--   <td class="chagrs_grid_text"><input type="checkbox" id="checkbox" name="checkbox"/></td><td /> -->
                <?php $tr_count++; ?>

                            <td width="6"></td>
                        </tr>


                <?php $lstCount++; // Increase the count of listings
            }
            ?>

                    <?php } } ?>

                <tr> <td height="10"></td></tr>
                <tr><td><input type="hidden" value="<?php echo $lstCount; ?>" id="rowCount" name="rowCount"></td></tr>
            </tbody>
        </table>

        <table>
            <tbody>
                <tr><td>
                        <div class="top_group_main">
                            <div class="top_group_left"></div>
                            <!-- <div class="top_group_middle">
                                 <div class="add_new_ads">
                                     <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS'] . "?req=spec&ids=" . $_POST['ids']; ?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/request_new_spec.jpg" alt="Request a new Specification" /></a>
                   </div>

                                 <div class="category_selection_div">
                                     <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS'] . "?req=manufac&ids=" . $_POST['ids']; ?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/add_new_manuf.jpg" alt="Add a new Manufacturer" /></a>
                                 </div>
                             </div>-->

                            <div class="top_group_middle">
                                <div class="my_listings_addbtn">
                                    <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS'] . "?req=spec&ids=" . $_POST['ids']; ?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/request_new_spec.jpg" alt="Request a new Specification" /></a>
                                </div>

                                <div class="my_listings_addbtn">
                                    <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS'] . "?req=manufac&ids=" . $_POST['ids']; ?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/add_new_manuf.jpg" alt="Add a new Manufacturer" /></a>
                                </div>

                            </div>

                            <div class="top_group_right"></div>
                        </div>
                    </td></tr>
                <tr><td height="5px;"></td></tr>
            </tbody>
        </table>
        <div id="divInputFader">&nbsp;</div>
        <div id="divInputBox">
            <div id="lHeader" class="contact_fieldBlock_left" style="float: left; vertical-align: top; margin-top: -38px; margin-right: 3px; width: 420px; margin-left: -8px;"> Manage Extra Details for <span id="divListName"></span></div>
            <div style="float: right; vertical-align: top; margin-top: -38px; margin-right: 3px;"><a href="javascript: cancelExtraDetails();" id="" style="display: inline;"><img alt="Close" title="Close" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/delete_active.gif" border="0"/></a></div>
            <hr style="color: #eee;background-color: #eee;height: 2px; border-style: solid; margin-left: -10px; margin-top:-18px;"/>
            <div id="divContainer"></div>
            <div id="divLoader" style="display:block;text-align:center;padding-left:130px;">
                <table>
                    <tr>
                        <td>
                            <img alt="Close" title="Close" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT']; ?>/preloader.gif" border="0" />
                        </td>
                        <td style="padding-left:10px;font-size:14px;">
                            Processing ...
                        </td>
                    </tr></table>

            </div>
        </div>
        <?php
    }
}
?>




