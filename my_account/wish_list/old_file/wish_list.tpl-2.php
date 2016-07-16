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

    $dbVal = $objCore->sysVars['WishList'];
    $arrRowStyle[0] = "";
    $arrRowStyle[1] = "cadd_descriptionrow_gray";

    // $createQuotationLink="<a href=\"\">Create Quotation</a>";

    $general_wishlist = array();  // for general wishlist - add by maduranga 
    $general_listValues = array();

    switch($_REQUEST['selectParent']) {
        case "1": {
                $suscription = "M";
                $wishListName = "Building Supplies";
                $file = "wish_list_supplies.tpl.php";

            }break
            ;
        case "2": {
                $suscription = "S";
                $wishListName = "Building Services";
                $file = "wish_list_services.tpl.php";

            }break
            ;
        case "3": {
                $suscription = "C";
                $wishListName = "Classified Ads";
                $file = "wish_list_classified_ads.tpl.php";

            }break
            ;
        default: {
                /*
                             * Added by saliya to select a section of the wishlist which contain at least one item
                             * when client not selected the specific sectoin at the initial access
                */

                //Initially it should be the supplies section
                $suscription = "M";
                $file = "wish_list_supplies.tpl.php";

                $general_wishlist[0]['selectParent'] = 1;
                $general_wishlist[0]['suscription'] = "M";
                $general_wishlist[0]['wishListName'] = "Building Supplies";
                $general_wishlist[0]['file'] = "wish_list_supplies.tpl.php";
                
                $general_wishlist[1]['selectParent'] = 2;
                $general_wishlist[1]['suscription'] = "S";
                $general_wishlist[1]['wishListName'] = "Building Services";
                $general_wishlist[1]['file'] = "wish_list_services.tpl.php";
                
                $general_wishlist[2]['selectParent'] = 3;
                $general_wishlist[2]['suscription'] = "C";
                $general_wishlist[2]['wishListName'] = "Classified Ads";
                $general_wishlist[2]['file'] = "wish_list_classified_ads.tpl.php";
                

                // logic should check if only if wish list has some items
                if(str_replace("-dlm-","",$dbVal)) {
                    $posM = strrpos($dbVal, "-dlm-M"); // check for supplies
                    $posS = strrpos($dbVal, "-dlm-S"); // check for services
                    $posC = strrpos($dbVal, "-dlm-C"); // check for classified ads
                    if ($posM === false) {
                        // Supplies not found...
                        if($posS === false) {   // Services Not found
                            if($posC === false) {
                                // Classified adds not found
                                // will not be executed as this wont be acess with empty whishlist
                                // just ignore this potion of the code
                            }
                            else {
                                $suscription = "C";
                                $file = "wish_list_classified_ads.tpl.php";
                            }

                        }
                        else {
                            $suscription = "S";
                            $file = "wish_list_services.tpl.php";
                        }
                    }

                }else {
                    // The wish list is empty
                    $flagWishListEmpty=true;
                }




            }break
            ;
    }


    if(isset ($_REQUEST['selectParent'])){ // change by maduranga - for general wish list

    $listValues = $objWishList->getValues($dbVal,$objCore->sessCusId,$_REQUEST['pg'],$suscription);
    } else {
        // general wish list
        for ($r=0; $r<3; $r++){
            $general_listValues[$r] = $objWishList->getValues($dbVal,$objCore->sessCusId,$_REQUEST['pg'],$general_wishlist[$r]['suscription']);
        }
    }
    /*
    echo '<pre>';
    print_r($general_listValues);
    echo '</pre>';*/
        
    // Added by Saliya
    $wishListName=$objCore->_SYS['CONF']['SUBCRIPTIONS'][$suscription]['OPTION'];
    if($listValues == "") {
        $msg = array("ERR", "NO_WISHLIST");
        $flagWishListEmpty=true;
    }


    ?>

<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar">

                <div id="banner_add_cads">Wish List</div>
                <div id="text_area_add_cads">
                    <div class="common_text">
    <?php
    echo $pageContents['common_text'];
    ?>
                    </div>
                </div>

    <?php if($objCore->sysVars['WQLink']) {?> <div class="commonInfoBox">
                                <?php

                                require_once($objCore->_SYS['PATH']['CLASS_QUOTATION']);
        if(!is_object($objQuotation)) $objQuotation = new Quotation('',$objCore->gConf,$objCore->sessCusId);
        $quoteData=$objQuotation->getQuotationDtails($objCore->sysVars['WQLink']);
        echo str_replace("{%QUOTE_ID%}",$quoteData[0]['quotationid'],$pageContents['info_quotation_link']);

                            ?></div>
                            <?php }
                        ?>

                <div id="list_add_cads"  <?php if($objCore->sysVars['WQLink']) {?>style="margin-top:0px"<?php }?>>
                    <div align="left">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="list_blackbg_summery">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="69%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0"  >
                                                    <tr>
    <?php
    // Create the Item count statistics for each wish list
    $splitter="";
    $counter=1;
    $arrWLItemCounts["M"]=$objWishList->itemCounts['M'];
    $arrWLItemCounts["S"]=$objWishList->itemCounts['S'];
    $arrWLItemCounts["C"]=$objWishList->itemCounts['C'];
                                                            foreach ($arrWLItemCounts as $wListId => $iCount) {

                                                                ?>
                                                        <td width="6" height="30"></td>
                                                        <td height="30" class="pgBar">
                                                            <a href="?selectParent=<?php echo $counter;?>" style="text-decoration:none;">
                                                                <?php if($splitter) echo $splitter." ";
                                                                echo $objCore->_SYS['CONF']['SUBCRIPTIONS'][$wListId]['OPTION']; ?>&nbsp;
                                                            </a>
                                                        </td>
                                                        <td width="5" height="30"></td>
                                                        <td height="30"  class="pbYellow" >
                                                                        <?php
        echo $iCount;
        ?> Item<?php if($iCount>1) {?>s<?;
        }?>

                                                        </td>
                                                                    <?php $splitter="|";
                                                                    $counter++;
    } // end loop?>

                                                    </tr>
                                                </table></td>
                                            <td width="51%" height="30">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                                    <tr>
                                                        <td>&nbsp;</td>
    <?php
    echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objSearch->pgBar."</div></td>";
    ?>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>    </td>
                                        </tr>
                                    </table>                </td>
                            </tr>

                            <tr>
                                <td height="10">
                                    <div id="messageBox" name="messageBox">
    <?php

    if($msg) {
                                                echo $objCore->msgBox("WISHLIST",$msg,'99%');

                                            } elseif($_REQUEST['msg1'] != "" && $_REQUEST['msg2'] != "") {
                                                $msg = array($_REQUEST['msg1'], $_REQUEST['msg2']);
                                                echo $objCore->msgBox("WISHLIST",$msg,'99%');
                                            }
                                            ?>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td><div class="top_group_left"></div>
                                    <div class="top_group_middle">
                                        <div class="top_group_middle">

                                            <div class="my_listings_addbtn"><?php if(!$flagWishListEmpty && $objCore->sessUType!="S") {?><a href="<?echo $PHP_SELF."?cQuote=y";?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/<?php  $objCore->sysVars['WQLink']=="" ? $img="Create": $img="Update";
        echo strtolower($img);?>_quotation.jpg" alt="<?php echo $img;?> Quotation" border="0" /></a><?php }?>
    <?php //if($flagWishListEmpty) {?><a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/?categories=<?php echo $_REQUEST['selectParent'];?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_n_add_item.jpg" alt="Search and add Items" border="0" /></a><?php //}?>
                                            </div>
                                            <div class="category_selection_div">
                                                <form action="" method="POST">
                                                    <?php

    echo $objCategory->getTopcList('drop','selectParent','category_selection',$_REQUEST['selectParent'], "onchange='javascript:this.form.submit();'") ;



                                                        ?>
                                                    <input type="hidden" name="action"  value="manage_category"/>
                                                </form>
                                            </div>
                                        </div></div><div class="top_group_right"></div>

                                </td>
                            </tr>
                            <tr>
                                <td height="10"></td>
                            </tr>


                            <tr>
                                <td>
                                    <!-- insert the wish list tpls -->
    <?php
                                            if(isset ($_REQUEST['selectParent'])){ // change by maduranga - for general wish list
    if($listValues != "") {
        include($file);
    }
                                            } else {// general wishlist - change by maduranga
                                                for ($r=0; $r<3; $r++){
                                                   /* echo '*************************<pre>';
                                                    print_r($general_listValues);
                                                    echo '</pre>************************';*/
                                                    if($general_listValues[$r] != ""){
                                                        $listValues = $general_listValues[$r];
                                                        include($general_wishlist[$r]['file']);
                                                    }
                                                }
                                            }
                                        ?>
                                </td>
                            </tr>
                            <tr>
                                <td height="10"></td>
                            </tr>
                            <tr>
                                <td>
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td class="list_blackbg_summery" >
                                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                    <tr>
                                                        <td width="69%"><table width="99%" border="0" align="left" cellpadding="0" cellspacing="0"  >
    <?php
    // Create the Item count statistics for each wish list
    $splitter="";
    $counter=1;
    foreach ($arrWLItemCounts as $wListId => $iCount) {

                                                                        ?>
                                                                <td width="6" height="30"></td>
                                                                <td height="30" class="pgBar">
                                                                    <a href="?selectParent=<?php echo $counter;?>" style="text-decoration:none;">
                                                                        <?php if($splitter) echo $splitter." ";
        echo $objCore->_SYS['CONF']['SUBCRIPTIONS'][$wListId]['OPTION']; ?>&nbsp;
                                                                    </a>
                                                                </td>
                                                                <td width="5" height="30"></td>
                                                                <td height="30"  class="pbYellow" >
        <?php
        echo $iCount;
        ?> Item<?php if($iCount>1) {?>s<?;
                                                                            }?>

                                                                </td>
        <?php $splitter="|";
        $counter++;
                                                                    } // end loop?>
                                                            </table></td>
                                                        <td width="51%" height="30">
                                                            <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                                                <tr>
                                                                    <!--
                                                                     <td>&nbsp;</td>
                                                                     <td width="15" class="pgBar selected"><div align="center">1</div></td>
                                                                     <td width="15" class="pgBar"><div align="center"><a href="#">2</a></div></td>
                                                                     <td width="15" class="pgBar"><div align="center"><a href="#">3</a></div></td>
                                                                     <td width="40" class="pgBar"><div align="center"><a href="#">Next</a></div></td>
                                                                     <td width="25" class="pgBar"><div align="left"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/next_arrow.jpg" width="11" height="11" /></div></td>
                                                                    -->
                                                                    <td>&nbsp;</td>
    <?php
                                                                        echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objSearch->pgBar."</div></td>";
                                                                        ?>
                                                                    <td>&nbsp;</td>
                                                                </tr>
                                                            </table>    </td>
                                                    </tr>
                                                </table>                </td>
                                        </tr>

                                        <tr>
                                            <td height="10"></td>
                                        </tr>
                                        <tr></tr>
                                    </table>
                                </td>
                            </tr>

                        </table>

                    </div>
                </div>







            </div>
            <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
        </div>
    </div>
</div>
    <?php
}
?>