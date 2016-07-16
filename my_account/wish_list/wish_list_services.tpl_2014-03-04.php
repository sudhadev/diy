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
        <?php // add by maduranga
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
            <td class="grid_middle chagrs_grid_heading" >Listing / Services</td>
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
                 $imgUrl = $objCategory->image($listValues[$i][$j][11],$objCore->_SYS['CONF']['FTP_SERVICES'],$objCore->_SYS['CONF']['URL_IMAGES_SERVICES']);
              ?>
             <img src="<?php echo $imgUrl;?>" width="70"/>

        <div id="enlarge_image" class="common_text_ash">
        
            <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search-icon.jpg" width="14" height="15" /> <a href="javascript:zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $listValues[$i][$j][11]; ?>','services');">Enlarge Image</a>
        </div>
             
        </div>

        <div class="classified_description_wraper">
			<div class="select_wishlist">
			  <div class="where_text common_text_ash">&nbsp;Where are they</div>
                                <div class="select_wishlist_button"><img height="15" width="15" alt="where are they?" class="cursorHand" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/where_icon.jpg" onClick="JavaScript:PopupWhereAreThey('<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>/search/where_are_they.php?cid=<?php echo $listValues[$i][$j][6]; ?>');"/></div>
                        </div>
        <div class="description_text_big"><strong><?php echo $listValues[$i][$j][8];?></strong><br /></div>
        
        <div class="description_sub_wraper">
        <div class="description_wraper_sr common_text"><?php echo $listValues[$i][$j][2];?></div>
        
        <div class="description_wraper_sr common_text"><?php echo $listValues[$i][$j][9];?></div>
        
        
        <div class="description_wraper_sr common_text">
            <a href="<?php echo $listValues[$i][$j][19];?>" target="_blank"><?php echo $listValues[$i][$j][19];?></a></div>
        </div>
		
		<div class="description_wraper_right">
		<div class="rate_distance_maindiv">
			<div class="hourly_rate_main">
				<div class="hourly_rate hourly_rate_font">Hourly Rate (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)</div>
				<div class="hourly_rate_amount hourly_rate_font" align="right"><?php echo $listValues[$i][$j][10];?></div>
			</div>
			<div class="distance_main">
				<div class="hourly_rate distance_font">Distance (<?php echo $unit; ?>)</div>
				<div class="hourly_rate_amount distance_font" align="right"><?php echo round($listValues[$i][$j][7],2);?></div>
			</div>
		</div>
		<div class="select_wishlist" style="padding-top:15px">
				<div class="select_wishlist_button_left" style="padding-top:4px">
				<img class="cursorHand" onclick="javascript:del('<?php echo 'S'.$listValues[$i][$j][20];?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_image.jpg" width="11" height="12" alt="delete image" />
				</div>
				<div class="select_wishlist_text common_text">Delete</div>
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