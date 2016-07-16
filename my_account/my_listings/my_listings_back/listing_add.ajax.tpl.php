<?php 
	/*---------------------------------------------------------------------------\
	'    This file is part of shoping Cart in module library of FUSIS            '
	'    (C) Copyright 2004 www.fusis.com                                        '
	' .......................................................................... '
	'                                                                            '
	'    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>          '
	'    FILE            :  my_account/my_listings/listing_add.ajax.tpl.php     	   '
	'    PURPOSE         :  list specifications page of the specification section'
	'    PRE CONDITION   :  commented                                            '
	'    COMMENTS        :                                                       '
	'---------------------------------------------------------------------------*/

	require_once("../../classes/core/core.class.php");$objCore=new Core;
	$objCore->auth(1,true);
	
	require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
	if(!is_object($objListing))
	{
		$objListing = new Listing;
	}
        if(!is_object($objCategory))
	{
		$objCategory = new Category;
	}

        require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
	if(!is_object($objComponent))
	{
		$objComponent = new Component();	
	}

	$module = "myListing";
	$function = "addList";
	
  	if($objCore->isAllowed($module, $function))
	{
		$arrParentId = explode('_',$_POST['ids']);
		
		$status="Y";
		$logId = $objCore->sessCusId;

		$specification_list = $objListing->get_dList_specification($arrParentId,$status,$objCore->sessCusId);

        /*
         * Get average prices
         */$avgArray=$objListing->getAvgByThirdlevelCategory($arrParentId[2]) ;


		if($specification_list == "")
		{		
                    //echo "<br/> We should add a link/button for \"Request Specificatoin\" from this area<br/><br/><br/>";
                        $msg=array('ERR','NOT_EXIST_SPEC');
			$i=1;
			if($msg)
			{
				echo $objCore->msgBox("LISTING",$msg,'99%')."||".$i."||";
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
                            <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS']."?req=spec&ids=".$_POST['ids'];?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/request_new_spec.jpg" alt="Request a new Specification" /></a>
                        </div>

                        <div class="my_listings_addbtn">
                            <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS']."?req=manufac&ids=".$_POST['ids'];?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/add_new_manuf.jpg" alt="Add a new Manufacturer" /></a>
                        </div>

                    </div>


                    <div class="top_group_right"></div>
                </div>
            </td></tr>
        <tr><td height="5px;"></td></tr>
    </tbody>
</table>
                <?php
                } else
		{
                    $arrRowStyle[0]="";
                    $arrRowStyle[1]="cadd_descriptionrow_gray";
                /*
                 * Create the option list for bulk discount drop down
                 * - Added by Saliya Wijesinghe 17th September 2009
                */
                $bdOptionList='';$blMax=$objCore->gConf['BULK_MAX'];$blDiff=$objCore->gConf['BULK_DIFFERENCE'];
                for($bl=0;$bl<$blMax;$bl+=$blDiff)
                {
                     $bdOptionList.='<option value="'.$bl.'" >'.$bl.'</option>'."\n";
                }

?>

<!-- Load the content from database. -->

<input name="specCount"  id="specCount"type="hidden" value="<?php echo count($specification_list);?>" />
      <table width="665" cellspacing="0" cellpadding="0" border="0" align="center">
        <tbody>
            <tr> <td height="10"></td></tr>
            <tr>
                <td id="grid_left_end" class="grid_end" width="6" height="36"/>
                <td class="grid_middle chagrs_grid_heading" width="230" height="36">Specifications</td><td class="grid_break" width="1" height="36"/>
                <td class="grid_middle chagrs_grid_heading" width="60" height="36">Average<br />Price</td><td class="grid_break" width="1" height="36"/>
                <td class="grid_middle chagrs_grid_heading" width="60" height="36">Unit<br />Cost (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>) </td><td class="grid_break" width="1" height="36"/>
                <td class="grid_middle chagrs_grid_heading" width="70" height="36">Bulk<br />Discount</td><td class="grid_break" width="1" height="36"/>
                <td class="grid_middle chagrs_grid_heading" width="60" height="36">Bulk<br />Price (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>) </td><td class="grid_break" width="1" height="36"/>
                <td class="grid_middle chagrs_grid_heading" width="60" height="36">Delivery<br /> (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>) </td><td class="grid_break" width="1" height="36"/>
                <td class="grid_middle chagrs_grid_heading" width="60" height="36">Listing<br />Active</td><!--<td class="grid_break" width="1" height="36"/>
                <td class="grid_middle chagrs_grid_heading" width="50" height="36">Clear Item</td>-->
           
                <td id="grid_right_end" class="grid_end" width="6" height="36"/> 
            </tr>
            <?php
                $lstCount=0; // to store number of listings
                
                $specListKeys=array_keys($specification_list);
                for($n=0;$n<count($specListKeys);$n++)
                {
                   
            ?>

            <?php

                $manufactListKeys=array_keys($specification_list[$specListKeys[$n]]);
                for($lsIt=0;$lsIt<count($manufactListKeys);$lsIt++)
                {
			$ids = $arrParentId[0]."_".$arrParentId[1]."_".$arrParentId[2]."_".$specListKeys[$n]."_".$manufactListKeys[$lsIt]."_".$specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][11];       
            ?>


            <tr><td>
                <input type="hidden" value="<?php echo $ids; ?>" id="ids[<?php echo $lstCount;?>]" name="ids[<?php echo $lstCount;?>]">
                <input type="hidden" value="<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt]; ?>" id="eleId[<?php echo $lstCount;?>]" name="eleId[<?php echo $lstCount;?>]">
            </td></tr>
            <?php if($lsIt==0){?>
            <tr class="<?php echo $arrRowStyle[$n%2];?>">
                <td width="6"/>
                <td class="chagrs_grid_text" colspan="15" style="font-size:11px;font-weight:bolder; padding: 8px 0px 0px 0px;"><?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][0];?>                </td>
                <td width="6"><td />
            </tr>
            <?php } // end if?>
            <tr class="<?php echo $arrRowStyle[$n%2];?>">
                <td width="6" height="41"></td>
                <td class="chagrs_grid_text list_style_spc2" style="padding-left:15px;"><?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][1];?> <br /> <a class="" href="JavaScript:newPopup('<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_listings/other-charges.php?pg=1&cid=<?php echo $arrParentId[2];?>&sid=<?php echo $specListKeys[$n];?>&mid=<?php echo $manufactListKeys[$lsIt];?>&t=<?php echo time();?>');">What are others charging?</a>
	
               </td>
                <td></td>
                <td class="chagrs_grid_text list_style numeric_texts"><?php /* Avarage Price   */ echo $objCore->_SYS['CONF']['CURRENCY']." ".number_format($avgArray[$specListKeys[$n]][$manufactListKeys[$lsIt]],2);//$specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][2];?></td>
                <td></td>
                <td class="chagrs_grid_text"><input type="text" value="<?php  /* Unit Cost*/ echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][3];?>" name="unit_cost_<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>" class="numeric_txtfield" id="unit_cost_<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>" size="4" onchange="checkValue('<?php echo $ids;?>','<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>');"/></td>
                <td></td>
                <td class="chagrs_grid_text">
                            <select name="select_bulk_discount_<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>" id="select_bulk_discount_<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>" class="mng_mylistings_short" onchange="checkValue('<?php echo $ids;?>','<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>');">
                            <?php
                               $optSelectedValue=$specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][4];
                               echo str_replace('value="'.$optSelectedValue.'"','value="'.$optSelectedValue.'" selected ',$bdOptionList)

                            ?>
                           </select>              </td>
                 <td></td>
                <td class="chagrs_grid_text"><input type="text" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][5];?>" name="bulk_price_<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>" id="bulk_price_<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>"  class="numeric_txtfield" size="4" onchange="checkValue('<?php echo $ids;?>','<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>');"/></td>
                <td></td>
                <td class="chagrs_grid_text"><input type="text" value="<?php echo $specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][6];?>" name="delivery_<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>" id="delivery_<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>" class="numeric_txtfield" size="4" onchange="checkValue('<?php echo $ids;?>','<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>');"/></td>
                <td></td>
                <td class="chagrs_grid_text">
                <?php $lstStatus=$specification_list[$specListKeys[$n]][$manufactListKeys[$lsIt]][7];?>
                          <select id="listing_active_<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>" class="mng_mylistings_short" name="listing_active_<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>" onchange="checkValue('<?php echo $ids;?>','<?php echo $specListKeys[$n]."_".$manufactListKeys[$lsIt];?>');">
                            <option value="Y"<?php if($lstStatus=="Y"){echo " selected ";}?> >Yes </option>
                            <option value="N"<?php if($lstStatus=="N"){echo " selected ";}?> >No </option>
                          </select>              </td>
                          <td></td>
             <!--   <td class="chagrs_grid_text"><input type="checkbox" id="checkbox" name="checkbox"/></td><td /> -->


                <td width="6"></td>
            </tr>


                 <?php $lstCount++; // Increase the count of listings
                 } ?>

            <?php 
            } ?>
           
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
                            <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS']."?req=spec&ids=".$_POST['ids'];?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/request_new_spec.jpg" alt="Request a new Specification" /></a>
          </div>

                        <div class="category_selection_div">
                            <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS']."?req=manufac&ids=".$_POST['ids'];?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/add_new_manuf.jpg" alt="Add a new Manufacturer" /></a>
                        </div>
                    </div>-->

                    <div class="top_group_middle">
                        <div class="my_listings_addbtn">
                            <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS']."?req=spec&ids=".$_POST['ids'];?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/request_new_spec.jpg" alt="Request a new Specification" /></a>
                        </div>

                        <div class="my_listings_addbtn">
                            <a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS']."?req=manufac&ids=".$_POST['ids'];?>"><img border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/add_new_manuf.jpg" alt="Add a new Manufacturer" /></a>
                        </div>
                        
                    </div>

                    <div class="top_group_right"></div>
                </div>
            </td></tr>
         <tr><td height="5px;"></td></tr>
    </tbody>
</table>







<?php	 
		}
	}
?>

									
	
