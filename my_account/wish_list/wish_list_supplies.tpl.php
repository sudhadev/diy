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


 require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
 if(!is_object($objListing)) $objListing= new Listing();
?>


<div align="left">

 <form id="wishList_supplies" name="wishList_supplies" method="get" action="" >
     <input type="hidden" id="count" name="count" value="<?php echo count($listValues);?>"/>
     
    <table width="652" border="0" cellspacing="0" cellpadding="0" >

			<?php /*
             echo '<pre>';
             print_r($listValues); 
             echo '</pre>';*/
             ?>
       <!-- <tr>
            <td><?php echo "hooooooo"; ?></td>
             <?php
             //print_r($objSearch);
            // print_r($listValues);
             echo "+++".$objSearch->getTotalCount()."***".$objSearch->pgBar;
             echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objSearch->pgBar."</div></td>";?>
           <td>&nbsp;</td>
        </tr> -->

        
      <tr>
        <td id="grid_left_end" width="6"></td>
        <td class="grid_middle chagrs_grid_heading" >Listing / Supplier</td>
        <td class="grid_break" width="1"></td>
        <td class="grid_middle chagrs_grid_heading" >Dist. (miles)</td>
        <td class="grid_break" width="1"></td>
        <td class="grid_middle chagrs_grid_heading" style="width:10%;">Unit <br/>Price (£)</td>
        <td class="grid_break" width="1"></td>
        <td class="grid_middle chagrs_grid_heading" >Qty.</td>
        <td class="grid_break" width="1"></td>
        <td class="grid_middle chagrs_grid_heading" >Total Cost (£)</td>
        <td class="grid_break" width="1"></td>
        <td class="grid_middle chagrs_grid_heading" >Delete</td>
        <td id="grid_right_end" width="6"></td>
        
      </tr>
      
      <?php
      //echo "count = ".$gblCount."<br />";
      //print_r($listValues);
        for($i=0; $i< count($listValues); $i++)
        {
            for($j=0; $j< count($listValues[$i]); $j++)
            {
      ?>


      <tr valign="top" class="<?php echo $arrRowStyle[($i)%2];?>">
        <td width="6"></td>
        <td class="chagrs_grid_text"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
              <td rowspan="4" valign="top">
                  <?php  $imgUrl = $objListing->image($listValues[$i][$j][19],$objCore->_SYS['CONF']['FTP_LISTINGS'],$objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'],$listValues[$i][$j][11]); ?>
                <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $listValues[$i][$j][19]."_spl_".$listValues[$i][$j][11]; ?>','listing');"><img src="<?php echo $imgUrl;?>"   width="50" border="0" style="padding-right:8px;" align="left"/></a>
              </td>
            <td>

                 <strong>
                 <?php //$distance = round($listValues[$i][$j][12], 2);?>
                 <?php echo '<a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=1&cid='.$listValues[$i][$j][11].'&lid='.$listValues[$i][$j][18].'&dis='.$distance.'">';?>
                 	<?php echo $listValues[$i][$j][16]." ".$listValues[$i][$j][10];?>
                 <?php echo '</a>';?>
                 <br/>Manufacturer - <?php echo $listValues[$i][$j][15];?></strong>
                <span style="font-size:10px;"> <?php echo "<br/>".$listValues[$i][$j][20];?></span>
            </td>
          </tr>


          <tr> 
              <td><hr style="color:#ddd;background-color: #ddd;border: 1px solid;"/><?php echo $listValues[$i][$j][0]." ".$listValues[$i][$j][1]." - ".$listValues[$i][$j][2];?></td>
          </tr>
          
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                
                <td width="5%"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/e-mail.jpg" width="13" height="9" border="0"/></td>
                <td width="95%" class="common_text_ash"><a href="mailto:<?php echo $listValues[$i][$j][3]; ?>" title="mailto:<?php echo $listValues[$i][$j][3]; ?>"> Email Supplier</a></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        <td width="1"></td>
        <td class="chagrs_grid_text numeric_texts" ><strong><?php echo round($listValues[$i][$j][12],2);?></strong></td>
        <td width="1"></td>
        <td class="chagrs_grid_text numeric_texts">
        <?php  
        //print_r($listValues[$i][$j]);
        if($listValues[$i][$j][7]>0){ 
          if($listValues[$i][$j][7] <= $listValues[$i][$j][qty])
           {
           echo '<STRIKE>'.$listValues[$i][$j][6].'</STRIKE>';
           echo '<br>';
           echo $listValues[$i][$j][8];
           
       } 
       else{
           echo $listValues[$i][$j][6];
           
       }
       }
       else{
           echo $listValues[$i][$j][6];
           
       }
       ?></td>
        <td width="1"></td>
        <td class="chagrs_grid_text numeric_texts">
            
            <label>
               <input id="quantity[]" name="quantity[]" type="text" class="list_style_spc2 numeric_texts" style="width:30px" value="<?php echo $listValues[$i][$j]["qty"];?>"/>
                <input type="hidden" id="listing_id[]" name="listing_id[]" value="<?php echo $listValues[$i][$j][18]; ?>"/>
            </label>
            
        </td>
        <td width="1"></td>
        <td class="chagrs_grid_text numeric_texts" width="50px"><strong>
                <?php //print_r($listValues[$i][$j]); ?>
       <?php  if($listValues[$i][$j][7]>0 ){if($listValues[$i][$j][7]<=$listValues[$i][$j][qty])
           {
           echo number_format($listValues[$i][$j][8]*$listValues[$i][$j]["qty"],2,'.','');
           
       }
       else{
           echo number_format($listValues[$i][$j][6]*$listValues[$i][$j]["qty"],2,'.','');
           
       }
       
       }
       else{
           echo number_format($listValues[$i][$j][6]*$listValues[$i][$j]["qty"],2,'.','');
           
       }
       ?></strong></td>
        <td width="1"></td>
        <td class="chagrs_grid_text" ><div align="center"><img class="cursorHand" onclick="javascript:del('<?php echo 'M'.$listValues[$i][$j][18];?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_image.jpg" width="11" height="12" border="0" style="padding-top:2px;"/></div></td>
        <td width="6"></td>
      </tr>

      <?php
            }
        }
      ?>
      

    </table>
 <input type="hidden" id="action" name="action" value="add"/>
 </form>
     <table border="0" cellspacing="0" cellpadding="0">
         <tr>
             <td height="10"></td>
         </tr>
         <tr>
           <td class="search_partison" align="left">
               <div id="clear_selections"></div>

               <div align="right" id="add_selections">
                    
                    <a href="javascript:wishList_supplies.submit();"><img onclick="wishList_supplies.submit();" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/update_wishlist.jpg" width="109" height="20" border="0" /></a>
                </div>

           </td>
        </tr>
    </table> 
    
</div> 



<?php } ?>