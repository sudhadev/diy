<?php
$objSpecification->pgBarStrPrevious='<span id="pgBarImgPre">Previous </span>';
$objSpecification->pgBarStrNext='<span id="pgBarImgNext">Next </span>';
$specData = $objSpecification->getRequestedSpecifications($objCore->sessCusId, $_REQUEST['category'], $_REQUEST['pg'], 'f=spec&category=1');
?>

        <div id="right_bar_middle">
		<div id="main_form_bg">
		<div id="main_form_bg_middle">
		<div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
		<div id="main_form_bg_middlebar">

		  <div id="banner">REQUESTED SPECIFICATIONS</div>
		  <div id="text_area">
        <div class="common_text">Below you can see the list of your Requested Specifications showing their status.
If the request is pending, you can edit or delete the request.
Once the listing is active, you need to return to Supplier Area, then Add Listings, where you can find your approved specifications to add you prices, image etc. </div>
        </div>

		<div class="list">

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
		<td width="178" height="30" class="pbYellow"><?php echo $objSpecification->getTotalCount(); ?> Specifications</td>

      </tr>
    </table></td>
    <td width="50%" height="30">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
     <?php
        echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objSpecification->pgBar."</div></td>";
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
                <?php
                if($specData[1]=='NO_RESULTS')$msg=$specData;


                if($msg)
                    {
                        echo $objCore->msgBox("SPECIFICATION",$msg,'99%');
                    } ?> 
					<tr>
						<td height="12"></td>
					</tr>
					<tr>
						<td><table width="652" border="0" cellspacing="0" cellpadding="0">
                        
  <?php 
  if($specData[1]!='NO_RESULTS'){
  ?>                      
  <tr>
    <td id="grid_left_end" width="6"></td>
    <td class="grid_middle chagrs_grid_heading">Specification</td>
    <td class="grid_break" width="1"></td>
    <td class="grid_middle chagrs_grid_heading">Category</td>
    <td class="grid_break" width="1"></td>
    <td class="grid_middle chagrs_grid_heading">Manufacturer</td>
    <td class="grid_break" width="1"></td>
    <td class="grid_middle chagrs_grid_heading">Time</td>
    <td class="grid_break" width="1"></td>
	<td class="grid_middle chagrs_grid_heading">Status</td>
    <td class="grid_break" width="1"></td>
    <td class="grid_middle chagrs_grid_heading"></td>
    <td id="grid_right_end" width="6"></td>
  </tr>
  <?php 
    for ($i=0; $i<count($specData); $i++)
    {
  ?>
  <tr class="<?php echo $arrRowStyle[$i%2];?>" style="vertical-align:top">
    <td width="6"></td>
    <td class="chagrs_grid_text"><?php echo $specData[$i][1]; ?></td>
    <td width="1"></td>
    <td class="chagrs_grid_text"><?php echo $specData[$i][7]; ?></td>
    <td width="1"></td>
    <td class="chagrs_grid_text"><?php if ($specData[$i][8]) { echo $specData[$i][8]; } else { echo "none"; } ?></td>
    <td width="1"></td>
	<td class="chagrs_grid_text"><?php echo date($objCore->gConf['DATE_FORMAT'], $specData[$i][6])."<br />".date($objCore->gConf['TIME_FORMAT'], $specData[$i][6]); ?></td>
    <td width="1"></td>
    <td class="chagrs_grid_text"><?php echo $arrayStatus[$specData[$i][5]]; ?></td>
    <td width="1"></td>
    <?php
    if ($specData[$i][5] == 'R' || $specData[$i][5] == 'Y' || $specData[$i][5] == 'D')
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
                    
                     <a href="<?php echo $objCore->_SYS['CONF']['URL_REQUEST_LISTINGS'];?>/index.php?f=edit_spec&ids=<?php echo $specData[$i][2]."||".$specData[$i][3]."||".$specData[$i][4]."||".$specData[$i][0];?>&manu=<?php echo $specData[$i][8];?>" style="text-decoration:none">
                         <img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/edit_active.gif" width="15" height="15" alt="edit" /><span class="text_normal"> Edit</span>
                     </a>
                </div>
		<div class="edit_colmn_div">
                    
                    <a href="javascript:del('<?php echo $specData[$i][2]."||".$specData[$i][3]."||".$specData[$i][4]."||".$specData[$i][0]."||".$_REQUEST['f']."||".$_REQUEST['category']; ?>');"  style="text-decoration:none">
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
  
  <?php
    }
  ?>
  
  
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
		<td width="178" height="30" class="pbYellow"><?php echo $objSpecification->getTotalCount(); ?> Specifications</td>

      </tr>
    </table></td>
    <td width="50%" height="30">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <?php
        echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objSpecification->pgBar."</div></td>";
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