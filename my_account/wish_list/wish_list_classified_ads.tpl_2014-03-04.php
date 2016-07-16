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
  $unit = $objCore->gConf['SEARCH_UNIT'];
  
 
?>


<div>
    
    <table width="652" border="0" cellspacing="0" cellpadding="0" >
        <?php  // add by maduranga
            if(isset ($_REQUEST['selectParent'])){ }
            else {
        ?>
        <tr>
            <td ></td>
            <td height="10" ></td>
            <td ></td>
        </tr>
        <?php } ?>
        <tr>
            <td id="grid_left_end" width="6"></td>
            <td class="grid_middle chagrs_grid_heading" >Listing / Classified Ads </td>
            <td id="grid_right_end" width="6"></td>
        </tr>
    </table>
    <table width="652" border="0" cellspacing="0" cellpadding="0" >

      <?php
       
        for($i=0; $i< count($listValues); $i++)
        {
            for($j=0; $j< count($listValues[$i]); $j++)
            {
      ?>

<tr class="<?php echo $arrRowStyle[($i)%2];?>">
    <td><div class="cadds_search_descriptionrow">

         <div id="searched_image">
             <?php
                 $imgUrl = $objCategory->image($listValues[$i][$j][11],$objCore->_SYS['CONF']['FTP_CLAS_ADS'],$objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS']);
              ?>
             <img src="<?php echo $imgUrl;?>" width="70"/>

        <div id="enlarge_image" class="common_text_ash">
            <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search-icon.jpg" width="14" height="15" /> <a href="javascript:zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $listValues[$i][$j][11]; ?>','clas_ads');">Enlarge Image</a>
        </div>

        </div>
            
        <div class="classified_description_wraper">
			<div class="select_wishlist">
				<div class="select_wishlist_button_left" style="padding-top:4px">
				 <img class="cursorHand" onclick="javascript:del('<?php echo 'C'.$listValues[$i][$j][14];?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_image.jpg" width="11" height="12" alt="delete image" />
				</div>
				<div class="select_wishlist_text common_text">Delete</div>
			</div>
        <div class="description_text_big"><strong><?php echo $listValues[$i][$j][8];?></strong><br /></div>
			<div class="classified_description_wraper">

			<div class="classified_desc_subdiv">
				<div class="classified_desc_subdiv">
					<div class="description_subdiv common_text_ash">Area:</div>
					<div class="classified_desc_subsec common_text"><?php echo $listValues[$i][$j][12].", ".$listValues[$i][$j][13];?></div>
				</div>
				<div class="classified_desc_subdiv">
					<div class="description_subdiv common_text_ash">Contact:</div>
					<div class="classified_desc_subsec common_text">
						<div class="classified_desc_subsec_sub"><?php echo $listValues[$i][$j][0]." ".$listValues[$i][$j][1];?><br /><?php echo $listValues[$i][$j][2];?></div>
						<div class="classified_desc_subsec_sub">
							<div class="description_subdesc_mailicon"></div>
							<div class="description_subdesc_mailad"><a href="mailto:<?php echo $listValues[$i][$j][3]; ?>" title="mailto:<?php echo $listValues[$i][$j][3]; ?>"><?php echo $listValues[$i][$j][3];?></a></div>
						</div>
					</div>
				</div>
			</div>

			<div class="rate_distance_maindiv">
			<div class="hourly_rate_main">
				<div class="hourly_rate hourly_rate_font">Price (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)</div>
				<div class="hourly_rate_amount hourly_rate_font" align="right"><?php echo $listValues[$i][$j][10];?></div>
			</div>
			<div class="distance_main">
				<div class="hourly_rate distance_font">Distance (<?php echo $unit; ?>)</div>
				<div class="hourly_rate_amount distance_font" align="right"><?php echo round($listValues[$i][$j][7],2);?></div>
			</div><?php //echo $listValues[$i][7]; ?>
		</div>
		</div>
        <div class="classified_description_sub_wraper">
        <div class="description_subdiv common_text_ash">
        Notes:        </div>
        <div class="classified_description_subdesc common_text">
            <?php echo $listValues[$i][$j][9];?>
        </div>
        </div>
 </div>
</div>

    </td>
</tr>




 <?php
    }
} ?>
    </table>
</div>



<?php } ?>