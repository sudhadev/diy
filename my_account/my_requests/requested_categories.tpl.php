<?php
require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
$objComponent = new Component();
$objCategory->pgBarStrPrevious='<span id="pgBarImgPre">Previous </span>';
$objCategory->pgBarStrNext='<span id="pgBarImgNext">Next </span>';
$catData = $objCategory->getRequestedCategories($objCore->sessCusId, $_REQUEST['category'], $_REQUEST['pg']);
 if ($catData[0] == 'ERR') $msg = $catData;
?>
        <div id="right_bar_middle">
		<div id="main_form_bg">
		<div id="main_form_bg_middle">
		<div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
		<div id="main_form_bg_middlebar">

		  <div id="banner_add_cads">REQUESTED CATEGORIES</div>
		  <div id="text_area_add_cads">
        <div class="common_text">
            <?php echo $pageContents['common_text'];?>
        </div>
        </div>

		<div id="list_add_cads">

              <div align="left">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="list_blackbg_summery">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="47%"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  >
      <tr>
        <td width="13" height="30"></td>
        <td height="30" width="125" class="pgBar">You have requested</td>
		<td width="178" height="30" class="pbYellow"><?php if ($objCategory->getTotalCount()) { echo $objCategory->getTotalCount(); } else { echo "0"; } ?> Categories</td>

      </tr>
    </table></td>
    <td width="50%" height="30">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <?php
        echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objCategory->pgBar."</div></td>";
     ?>
  </tr>
</table>    </td>
  </tr>
</table>                </td>
              </tr>

              <tr>
                <td height="10"></td>
              </tr>
			  	<tr>

			  		<td>
					<div class="wishlist_top_group_main">
						<div class="wishlist_top_group_left"></div>
						<div class="wishlist_top_group_middle">

							<div class="wishlist_category_selection_div"><span class="common_text">Category</span>
							  <form>
                                  <?php
									echo $objComponent->drop('category', $_REQUEST['category'], array(
                                        "1"=>"Building Supplies",
                                        "2"=>"Building Services",
                                        "3"=>"Classified Ads",
                                        ), 'mng_cladds_catdropdown', 'onchange="form.submit();"');
							?>
                              </form> 
							  </div>
						</div>
						<div class="wishlist_top_group_right"></div>
					</div>					</td>
					<tr>
						<td height="12">
                        <?php if($msg) echo $objCore->msgBox("CATEGORY",$msg,'99%'); ?>
                        </td>
					</tr>
					<tr>
						<td> <table width="652" border="0" cellspacing="0" cellpadding="0">
                                      <?php
              if ($catData[0] != 'ERR')
              {
              ?>
                       
  <tr>
    <td id="grid_left_end" width="6"></td>
    <td  class="grid_middle chagrs_grid_heading" >Image</td>
    <td  class="grid_break" width="1"></td>
    <td  class="grid_middle chagrs_grid_heading" >Category</td>
    <td  class="grid_break" width="1"></td>
    <td  class="grid_middle chagrs_grid_heading" >Level&nbsp;</td>
    <td  class="grid_break" width="1"></td>
    <td  class="grid_middle chagrs_grid_heading" >Time</td>
    <td  class="grid_break" width="1"></td>
	<td  class="grid_middle chagrs_grid_heading" >Status</td>
    <td  class="grid_break" width="1"></td>
    <td  class="grid_middle chagrs_grid_heading" >&nbsp;</td>
    <td id="grid_right_end" width="6"></td>
  </tr>
  <?php
    for ($i=0; $i<count($catData); $i++)
    {
  ?>
  <tr class="<?php echo $arrRowStyle[$i%2];?>" style="vertical-align:top">
    <td width="6"></td>
    <td class="chagrs_grid_text">
		<div class="manage_classified_image"><img src="<?php $image = $objCategory->image($catData[$i][3],$objCore->_SYS['CONF']['FTP_CATS'],$objCore->_SYS['CONF']['URL_IMAGES_CATS']); echo $image; ?>"/></div>
		<div class="zoom_icon_div"><a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $catData[$i][3]; ?>','categ');"><img src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/zoom.png" border="none"/></a></div></td>
    <td width="1"></td>
    <td class="chagrs_grid_text" ><?php echo $catData[$i][2]?></td>
    <td width="1"></td>
    <td class="chagrs_grid_text" ><?php echo $catData[$i][1]?></td>
    <td width="1"></td>
	<td class="chagrs_grid_text" ><?php echo date($objCore->gConf['DATE_FORMAT'], $catData[$i][5])."<br />".date($objCore->gConf['TIME_FORMAT'], $catData[$i][5]); ?></td>
    <td width="1"></td>
    <td class="chagrs_grid_text" ><?php echo $arrayStatus[$catData[$i][4]]; ?></td>
    <td width="1"></td>
    <?php
    //$exist = $objCategory->deleteCategoryItem($catData[$i][0], $catData[$i][1]);
    if ($catData[$i][4] == 'R' || $catData[$i][4] == 'Y' || $catData[$i][4] == 'D')
    {
    ?>
    <td class="chagrs_grid_text">
		<div class="edit_colmn_div"><img class="cursorHand" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/edit_inactive.gif" width="15" height="15" alt="edit" /><span class="inactive_text"> Edit</span></div>
		<div class="edit_colmn_div"><img class="cursorHand" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_inactive.gif" width="15" height="15" alt="delete"/><span class="inactive_text"> Delete</span></div>
	</td>
    <?php
    }
    else
    {
    ?>
    <td class="chagrs_grid_text">
		<div class="edit_colmn_div">
                    <a href="<?php echo $objCore->_SYS['CONF']['URL_REQUEST_LISTINGS'];?>/index.php?f=edit_cat&id_lvl=<?php echo $catData[$i][0]."||".$catData[$i][1];?>" style="text-decoration:none">
                        <img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/edit_active.gif" width="15" height="15" alt="edit"/><span class="text_normal"> Edit</span>
                    </a>
                </div>

                <div class="edit_colmn_div">
                    <a href="javascript:del('<?php echo $catData[$i][0]."||".$catData[$i][1]."||".$_REQUEST['category']."||cat"; ?>');"  style="text-decoration:none">
                        <img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_active.gif" width="15" height="15" alt="delete"/><span class="text_normal"> Delete</span>
                    </a>
                </div>
	</td>
    <?php
    }
    ?>
    <td width="6"></td>
  </tr>
  <?php
    }
  ?>

            <?php }?>
            </table>
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
                <td class="list_blackbg_summery">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="47%"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  >
      <tr>
        <td width="13" height="30"></td>
        <td height="30" width="125" class="pgBar">You have requested</td>
		<td width="178" height="30" class="pbYellow"><?php if ($objCategory->getTotalCount()) { echo $objCategory->getTotalCount(); } else { echo "0"; } ?> Categories</td>

      </tr>
    </table></td>
    <td width="50%" height="30">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
   <?php
        echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objCategory->pgBar."</div></td>";
   ?>
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
            <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/back-black.jpg" border="" ></a>
          </div>
        </div>

       <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
        </div>
        </div>
        </div>
        </div>