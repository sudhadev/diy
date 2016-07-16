<?php
require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
$objCategory = new Category();
print_r($objCategory->getRequestedCategories($objCore->sessCusId, $_REQUEST['category']));
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
		<td width="178" height="30" class="pbYellow">15 Categories</td>

      </tr>
    </table></td>
    <td width="50%" height="30">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td>&nbsp;</td>
    <td width="15" class="pgBar selected"><div align="center">1</div></td>
    <td width="15" class="pgBar"><div align="center"><a href="#">2</a></div></td>
    <td width="15" class="pgBar"><div align="center"><a href="#">3</a></div></td>
    <td width="40" class="pgBar"><div align="center"><a href="#">Next</a></div></td>
    <td width="25" class="pgBar"><div align="left"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/next_arrow.jpg" width="11" height="11" /></div></td>
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
							  <select name="category" class="category_selection">
							  	<option value="Building Services">Building Services</option>
							 	<option value="Classified Ads">Classified Ads</option>
							  	<option value="Building Supplies">Building Supplies</option>
							  </select>
							  </div>
						</div>
						<div class="wishlist_top_group_right"></div>
					</div>					</td>
					<tr>
						<td height="12"></td>
					</tr>
					<tr>
						<td><table width="652" border="0" cellspacing="0" cellpadding="0">
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
  <tr style="vertical-align:top">
    <td width="6"></td>
    <td class="chagrs_grid_text">
		<div class="manage_classified_image">image</div>
		<div class="zoom_icon_div">zoom</div></td>
    <td width="1"></td>
    <td class="chagrs_grid_text" >Plasterboard - Plasterboard Tapered Edged</td>
    <td width="1"></td>
    <td class="chagrs_grid_text" >1</td>
    <td width="1"></td>
	<td class="chagrs_grid_text" >02/07/2009<br />11:10:24 AM</td>
    <td width="1"></td>
    <td class="chagrs_grid_text" >Approved</td>
    <td width="1"></td>
    <td class="chagrs_grid_text" >
		<div class="edit_colmn_div"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/edit_inactive.gif" width="15" height="15" alt="edit" /><span class="inactive_text">&nbsp;Edit</span></div>
		<div class="edit_colmn_div"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_inactive.gif" width="15" height="15" alt="delete" /><span class="inactive_text">&nbsp;Delete</span></div>
	</td>
    <td width="6"></td>
  </tr>
  <tr class="cadd_descriptionrow_gray" style="vertical-align:top">
    <td width="6"></td>
    <td class="chagrs_grid_text" >
	<div class="manage_classified_image">image</div>
	<div class="zoom_icon_div">zoom</div>	</td>
    <td width="1"></td>
    <td class="chagrs_grid_text" >Wallboard - Predeco Wallboard T</td>
    <td width="1"></td>
    <td class="chagrs_grid_text" >2</td>
    <td width="1"></td>
    <td class="chagrs_grid_text" >08/07/2009<br />06:10:24 PM</td>
    <td width="1"></td>
	<td class="chagrs_grid_text" >Pending</td>
    <td width="1"></td>
    <td class="chagrs_grid_text" >
		<div class="edit_colmn_div"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/edit_active.gif" width="15" height="15" alt="edit" /><span class="text_normal">&nbsp;Edit</span></div>
		<div class="edit_colmn_div"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_active.gif" width="15" height="15" alt="delete" /><span class="text_normal">&nbsp;Delete</span></div>
	</td>
    <td width="6"></td>
  </tr>
</table>						</td>
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
		<td width="178" height="30" class="pbYellow">15 Categories</td>

      </tr>
    </table></td>
    <td width="50%" height="30">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td>&nbsp;</td>
    <td width="15" class="pgBar selected"><div align="center">1</div></td>
    <td width="15" class="pgBar"><div align="center"><a href="#">2</a></div></td>
    <td width="15" class="pgBar"><div align="center"><a href="#">3</a></div></td>
    <td width="40" class="pgBar"><div align="center"><a href="#">Next</a></div></td>
    <td width="25" class="pgBar"><div align="left"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/next_arrow.jpg" width="11" height="11" /></div></td>
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
          </div>
        </div>

       <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
        </div>
        </div>
        </div>
        </div>