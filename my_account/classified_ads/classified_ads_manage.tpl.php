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
/**
* use this to get the category and subcategory ids.
*/

$cat_selection = $_REQUEST['category_selection'];
if($cat_selection != "")
{
    $cat_ids = $objClassifiedAd->get_cat_id($cat_selection);
    $category_id_0 = $cat_ids[0];
    $category_id_1 = $cat_ids[1];
    $category_id_2 = $cat_ids[2];
    $where = " WHERE `supplier_id`='".$objCore->sessCusId."' AND `category_id_0`='".$category_id_0."' AND `category_id_1`='".$category_id_1."' AND `category_id_2`='".$category_id_2."'";
} else
{
    $where = " WHERE `supplier_id`='".$objCore->sessCusId."'";
}
            
    
    $paginationSize = $objCore->gConf['RECS_IN_LIST_FRONT'];
    $list = $objClassifiedAd->dList($where,$_REQUEST['pg'],$paginationSize,$cat_selection);
    $arrRowStyle[0] = "";
    $arrRowStyle[1] = "cadd_descriptionrow_gray";
    if($list == "")
    {
        $msg = array("ERR","NOT_EXIST_ADS");
    }

    require_once($objCore->_SYS['PATH']['CLASS_PAYMENT']);
	if(!is_object($objPayment))$objPayment = new Payment($objCore->gConf);
 ?>
 

<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar">

                <!----------------------------------------------------------------------------------------------------->

                <div id="banner">EDIT MY CLASSIFIED ADS</div>
                <div id="text_area">
                    <div class="common_text"><?php echo $pageContents['common_text_manage'];?></div>
                </div>

                <div id="list_add_cads">

                    <div align="left">
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="list_blackbg_summery">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="47%">
                                                <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  >
                                                    <tr>
                                                        <td width="13" height="30"></td>
                                                        <td height="30" width="60" class="pgBar">You have </td>
                                                        <td width="80" height="30" class="pbYellow">
                                                          <?php
                                                            $tot_ads_price = $objClassifiedAd->total_ads_price($objCore->sessCusId);
                                                            $totAds = (int)$tot_ads_price[0];
                                                            $totPrice = $tot_ads_price[1];
                                                            echo $totAds." Active Ads";
                                                            if($totPrice == "")
                                                            {
                                                                $totPrice = 0;
                                                            }
                                                          ?>  
                                                        </td>
                                                        <td width="158" class="pgBar">( <?php echo $objCore->_SYS['CONF']['CURRENCY']." ".number_format($totPrice,2);?>)</td>
                                                    </tr>
                                                </table></td>
                                            <td width="50%" height="30">
                                                <table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                         <?php echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objClassifiedAd->pgBar."</div></td>";?>
                                                       <td>&nbsp;</td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
    
                            <tr>
                               
                                <td height="10">
                                     <div>
                                            <?php
                                                if($msg)
                                                {
                                                    echo $objCore->msgBox("CLASSIFIED_ADS",$msg,'99%');
                                                } elseif($_REQUEST['msg1'] != "" && $_REQUEST['msg2'] != "")
                                                {
                                                    $msg = array($_REQUEST['msg1'],$_REQUEST['msg2']);
                                                    echo $objCore->msgBox("CLASSIFIED_ADS",$msg,'99%');
                                                }
                                            ?>
                              
                                    </div>
                                </td>
                                <td height="10"></td>
                              
                            </tr>
                            <tr>
                                <td>
                                    <div class="top_group_main">
                                        <div class="top_group_left"></div>
                                        <div class="top_group_middle">
                                            <div class="add_new_ads"><a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/my_account/classified_ads/index.php?f=add&cats_id=<?php echo $cat_selection;?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/place_new_add.jpg" width="103" height="30" alt="add_new_ad" /></a></div>
                                            <div class="category_selection_div">
                                                <form action="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/my_account/classified_ads/index.php?f=manage" method="POST">
                                                    <?php
                                                        echo $objCategory->getSubcList(3,'add_drop_list_cats','category_selection','mng_cladds_catdropdown',$_REQUEST['category_selection'],'onchange="javascript:this.form.submit();"');
                                                    ?>
                                                    <input type="hidden" name="action"  value="manage_category"/>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="top_group_right"></div>
                                    </div>					</td>
                            <tr>
                                <td height="12"></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                        if($list != "")
                                        {
                                    ?>
                                    <form id="classified_ads_list" name="classified_ads_list" action="" method="post">
                                    <table width="652" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td id="grid_left_end" width="6"></td>
                                            <td class="grid_middle chagrs_grid_heading" width="72">Image</td>
                                            <td class="grid_break" width="1"></td>
                                            <td class="grid_middle chagrs_grid_heading" width="347">Title</td>
                                            <td class="grid_break" width="1"></td>
                                            <td class="grid_middle chagrs_grid_heading" width="71" align="right">Price (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)</td>
                                            <td class="grid_break" width="1"></td>
                                            <td class="grid_middle chagrs_grid_heading" width="101">Status</td>
                                            <td class="grid_break" width="1"></td>
                                            <td class="grid_middle chagrs_grid_heading" width="45">Edit</td>
                                            <td id="grid_right_end" width="6"></td>
                                        </tr>
                                        <?php
                                            for($i=0;$i<count($list);$i++)
                                            {
                                                $recProfile="";

                                        ?>
                                        <tr class="<?php echo $arrRowStyle[$i%2];?>">
                                            <td width="6"></td>
                                            <td width="72" class="chagrs_grid_text">
                                                <div class="manage_classified_image"> 
                                                      <?php
                                                         $imgUrl = $objCategory->image($list[$i][9],$objCore->_SYS['CONF']['FTP_CLAS_ADS'],$objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS']);
                                                      ?>
                                                      <img src="<?php echo $imgUrl;?>" width="50"/>
                                                     
                                                       <br />
                                                </div>
                                                <div class="zoom_icon_div">
                                                       <a href="javascript:zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $list[$i][9]; ?>','clas_ads');"><img  border="0" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_FRONT'];?>/zoom.png" /></a>
                                                </div>
                                            </td>
                                            <td width="1"></td>
                                            <td width="347" class="chagrs_grid_text"><?php echo $list[$i][5];?></td>
                                            <td width="1"></td>
                                            <td width="71" class="chagrs_grid_text" align="right"><?php echo $list[$i][8];?></td>
                                            <td width="1"></td>
                                            <td width="101" class="chagrs_grid_text">
                                            <?php 
                                                if($list[$i][10] == "Y")
                                                {
                                                //  echo $status = $objCore->_SYS['CONF']['STATUS']['Y'];

                                                }else
                                                {
                                                //  echo $status = $objCore->_SYS['CONF']['STATUS']['N'];
                                                }
                                                $toBeExpired='';
                                                $toBeExpired=$list[$i][14];
                                                
                                                $toBeAlerted= mktime(0, 0, 0, date("m",$toBeExpired)  , date("d",$toBeExpired)-14, date("Y",$toBeExpired));

                                                $recProfile=$list[$i][15];
                                                // keep normal variable in null before start
                                                $flag[0]='';
                                                $flag[1]='';
                                                $extMsg='';
                                                

                                                  if($toBeExpired<time() ||$list[$i][10] != "Y")
                                                  {
                                                      $flag[0]='EXPIRED';
                                                      if($toBeExpired>time())
                                                      {
                                                            $extMsg=" [Not Paid]";
                                                      }
                                                      else
                                                      {
                                                            $extMsg=" [Expired on : ".date($objCore->gConf['DATE_FORMAT'], $toBeExpired)."]";
                                                      }
                                                     
                                                  }
                                                  elseif($toBeAlerted<time())
                                                  {
                                                      $flag[0]='ACTIVE'; // currently active

                                                      if($recProfile)
                                                      {
                                                          $getProfile=$objPayment->diyRecurringProfileGetFromGateway($recProfile);print_r($getProfile);
                                                          $cyclesRemaining=$getProfile['RecurringPaymentsSummary']['NumberCyclesRemaining'];
                                                           if($cyclesRemaining==-1||$cyclesRemaining>0)
                                                           {
                                                                $flag[1]='AUTO'; // auto payment on
                                                                $extMsg=" [Next Payment Date : ".date($objCore->gConf['DATE_FORMAT'], $toBeExpired)."]";
                                                           }
                                                           else
                                                           {
                                                                $flag[1]='TO-EXPIRE'; // auto payment of
                                                                $extMsg=" [Will be expired on : ".date($objCore->gConf['DATE_FORMAT'], $toBeExpired)."]";
                                                           }
                                                            
                                                      }
                                                      else
                                                      {
                                                            $flag[1]='TO-EXPIRE'; // auto payment on
                                                            $extMsg=" [Will be expired on : ".date($objCore->gConf['DATE_FORMAT'], $toBeExpired)."]";
                                                      }



                                                  }
                                                  else
                                                  {
                                                       $flag[0]='ACTIVE'; // Active
                                                       if($recProfile) $flag[1]='AUTO'; // auto payment on
                                                       //$extMsg=" [Next Payment Date : ".date($objCore->gConf['DATE_FORMAT'], $toBeExpired)."]";
                                                  }



                                               echo '<div style="float:left;padding-right:5px;">';
                                              // echo date($objCore->gConf['DATE_FORMAT'], $thisSub['Expire']);
                                               echo "</div>";
                                               echo "<div>";
                                               echo str_replace('{%EXT%}',$extMsg,$arrIcons[$flag[0]]);
                                               if($flag[1]) echo str_replace('{%EXT%}',$extMsg,$arrIcons[$flag[1]]);
                                               echo "</div>";
                                            ?>
                                            </td>
                                            <td width="1"></td>
                                            <td width="45" class="chagrs_grid_text"><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/classified_ads/index.php?f=edit&id=<?php echo $list[$i][0];?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/edit_active.gif" alt="edit" /></a></td>
                                            <td width="6"></td>
                                        </tr>
                                        <?php } ?>
                                    </table>
                                    </form>
                                    <?php } ?>
                                    </td>
                            </tr>
                            </tr>
                            <tr>
                                <td>       		</td>
                            </tr>
                        </table>
                        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="10">
                                </td>
                            </tr>
                            <tr>
                                <td class="list_blackbg_summery"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="47%"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  >
                                                    <tr>
                                                        <td width="13" height="30"></td>
                                                        <td height="30" width="60" class="pgBar">You have </td>
                                                        <td width="80" height="30" class="pbYellow">
                                                          <?php
                                                            $tot_ads_price = $objClassifiedAd->total_ads_price($objCore->sessCusId);
                                                            $totAds = (int)$tot_ads_price[0];
                                                            $totPrice = $tot_ads_price[1];
                                                            echo $totAds." Active Ads";
                                                            if($totPrice == "")
                                                            {
                                                                $totPrice = 0;
                                                            }
                                                          ?>  
                                                        </td>
                                                        <td width="158" class="pgBar">( <?php echo $objCore->_SYS['CONF']['CURRENCY']." ".number_format($totPrice,2);?>)</td>
                                                    </tr>
                                                </table></td>
                                            <td width="50%" height="30"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                                    <tr>
                                                     <td>&nbsp;</td>
                                                         <?php echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objClassifiedAd->pgBar."</div></td>";?>
                                                       <td>&nbsp;</td>
                                                    </tr>
                                                </table></td>
                                        </tr>
                                    </table></td>
                            </tr>
                            <tr>
                                <td height="10"></td>
                            </tr>
                            <tr></tr>
                        </table>
                    </div>


                    <!----------------------------------------------------------------------------------------------------->

                </div>
                <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
            </div>
        </div>
    </div>
    <?php
    }
?>
