<?php
require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
$objListing = new Listing(); 
$specs = $objListing->getSpecifications($_REQUEST['catId']);

/*
echo '<pre>';
print_r($specs);
echo '</pre>';*/

$numOfManufacturersInList=4;
// added by chelanga to specify number of mafacture's and spec display on page
$numOfManufacAndSpecDis = 2;

for($a=0;$a<count($specs);$a++){

    $specArray[$specs[$a]['specification']][] = $specs[$a]['manufacturer'];

    $specDataArray[$specs[$a]['specification']][] = array($specs[$a]['specification_id'],$specs[$a]['manufacturer_id'],$specs[$a]['manufacturer']);
}


$topList=$objCategory->getTopcList();
$list=$objCategory->getSubcList($topList[$_REQUEST['tcid']]['id'],'sub_arr');
for ($m=0; $m<count($list); $m++)
{
    if ($list[$m][0]==$_REQUEST['pcid']) $temp = $m;
}
$listSub=$objCategory->getSubcList($list[$temp][0],'sub_arr');
for ($n=0; $n<count($listSub); $n++)
{
    if ($listSub[$n][0]==$_REQUEST['catId']) $tempSub = $n;
}
$arrRowStyle[0]="spec_table_left";
$arrRowStyle[1]="spec_table_right";
?> 
<div id="middle_right_bar">
    <div id="middle_center_bar">
        <div id="middle_center_bar_header"></div>
        <div id="middle_center_bar_content">
            <?php
            if (count($specs)==0)
            {
                ?>
            <div id="banner">Specifications</div>

            <div class="breadcrumb"><a href="?tcid=<?php echo $_REQUEST['tcid'];?>"><?php echo $topList[$_REQUEST['tcid']]['category']?></a> > <a href="?f=slist&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo $_REQUEST['pcid'];?>"><?php echo $list[$temp][3];?></a> > <?php echo $listSub[$tempSub][3];?></div>
            <div class="no_data">No Suppliers found <?php /*No Specifications Found for <?php echo $listSub[$tempSub][3];*/?></div>
        </div>

        <div id="middle_center_bar_bottom"> </div>
    </div>

        <?php include($objCore->_SYS['PATH']['RIGHT_FRONT']);?>
</div>
<?php 
}
else
{
?>
<div id="banner">Specifications</div>

<div class="breadcrumb"><a href="?tcid=<?php echo $_REQUEST['tcid'];?>"><?php echo $topList[$_REQUEST['tcid']]['category']?></a> > <a href="?f=slist&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo $_REQUEST['pcid'];?>"><?php echo $list[$temp][3];?></a> > <?php echo $listSub[$tempSub][3];?></div>
<div id="spec_table_main">
    <?php
    $specKeyArray=array_keys($specArray);
    $itemCounter=0;
    
  

    for($a=0;$a<count($specArray)/2;$a++){
        ?>
    <div class="spec_table_line">
        <div class="<?php echo $arrRowStyle[0];?>">
            <div class="spec_table_topics">
                <div class="sub_title"><?php echo $specKeyArray[$itemCounter];?>
                    <?php /*<a href="?f=manufac&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo $_REQUEST['pcid'];?>&catId=<?php echo $_REQUEST['catId'];?>&specId=<?php echo $specDataArray[$specKeyArray[$itemCounter]][0][0];?>"><?php echo $specKeyArray[$itemCounter];?></a> */?>
                </div>
            </div>
            <div class="spec-menu">

                <ul>
                    <?php  
                    	$b2=$d3=0;
                    	for($b=0;$b<count($specArray[$specKeyArray[$itemCounter]]);$b++) {
                        // added by chelanga for more link to display
                        
						//  change by maduranga 
						
							$p_count=$objListing->getListingsforACategory_supply_2( 1, $_REQUEST['pcid'] ,$_REQUEST['catId'] , $specDataArray[$specKeyArray[$itemCounter]][$b][0],  $specDataArray[$specKeyArray[$itemCounter]][$b][1]);
							if($p_count){ 
								$d3++;
								if($b2<4){
								$b2++;
									
					?>
                    		<li><a href="?f=result&tcid=<?php echo $_REQUEST['tcid'];?>&categories=1&categoryId=<?php echo $_REQUEST['catId'];?>&specificationId=<?php echo $specDataArray[$specKeyArray[$itemCounter]][$b][0];?>&manufacturerId=<?php echo $specDataArray[$specKeyArray[$itemCounter]][$b][1];?>&order_by=<?php echo $_REQUEST['order_by']?>&pg=1"><?php echo $specArray[$specKeyArray[$itemCounter]][$b];?>
                    			</a>[<?php echo $p_count; ?>]</li>
                    	<?php } } ?>
                <?php  } ?>

                </ul>
            </div>
            <!-- manufacture more link -->

            <div class="spec_table_foot">
                <?php  // added by chelanga
					
					if($d3>$b2){
                //if(count($specArray[$specKeyArray[$itemCounter]]) > $numOfManufacAndSpecDis) {  ?>
                <a href="?f=manufac&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo $_REQUEST['pcid'];?>&catId=<?php echo $_REQUEST['catId'];?>&specId=<?php echo $specDataArray[$specKeyArray[$itemCounter]][0][0];?>">More></a>
                <?php  }  
                
                ?>          
            </div>

        </div> <?php  $itemCounter++; ?>

        <div class="<?php echo $arrRowStyle[1];?>">
            <div class="spec_table_topics">
                <div  class="sub_title"><?php echo $specKeyArray[$itemCounter];?>
                 <?php /*<a href="?f=manufac&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo $_REQUEST['pcid'];?>&catId=<?php echo $_REQUEST['catId'];?>&specId=<?php echo $specDataArray[$specKeyArray[$itemCounter]][0][0];?>"><?php echo $specKeyArray[$itemCounter];?></a>*/?>
                </div>
            </div>
            <div class="spec-menu">


                <ul>
                    <?php  //  change by maduranga 
                    $b2=$d3=0;
                    for($b=0;$b<count($specArray[$specKeyArray[$itemCounter]]);$b++){
                    	$p_count=$objListing->getListingsforACategory_supply_2( 1, $_REQUEST['pcid'] ,$_REQUEST['catId'] , $specDataArray[$specKeyArray[$itemCounter]][$b][0],  $specDataArray[$specKeyArray[$itemCounter]][$b][1]);
                    	?>
							<?php if($p_count){ 
								$d3++;
								if($b2<4){
								$b2++;
								
							 ?>
                    		<li><a href="?f=result&tcid=<?php echo $_REQUEST['tcid'];?>&categories=1&categoryId=<?php echo $_REQUEST['catId'];?>&specificationId=<?php echo $specDataArray[$specKeyArray[$itemCounter]][$b][0];?>&manufacturerId=<?php echo $specDataArray[$specKeyArray[$itemCounter]][$b][1];?>&order_by=<?php echo $_REQUEST['order_by']?>&pg=1"><?php echo $specArray[$specKeyArray[$itemCounter]][$b];?>
                    			</a>[<?php echo $p_count; ?>]</li>
                    		<?php }}
					 	  }?>
                </ul>
            </div>
            <!-- specification more link -->
            <div class="spec_table_foot">
                <?php  //added by chelanga
					 if($d3>$b2){ 	  
                //if(count($specArray[$specKeyArray[$itemCounter]]) > $numOfManufacAndSpecDis && $specDataArray[$specKeyArray[$itemCounter]][0][0]) { ?>
                <a href="?f=manufac&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo $_REQUEST['pcid'];?>&catId=<?php echo $_REQUEST['catId'];?>&specId=<?php echo $specDataArray[$specKeyArray[$itemCounter]][0][0];?>">More></a>
                <?php  } ?>
            </div>

        </div><?php  $itemCounter++;?>
    </div>
    <?php
	}
	?>
</div>
</div>
<div id="middle_center_bar_bottom"> </div>
</div>
<!-- search com -->
<?php include($objCore->_SYS['PATH']['RIGHT_FRONT']);?>
<!-- /search com -->
    <?php
}
?>
<!--  This div was commented by chelanga to correct the copy right logo alignment issue -->		  
<!--</div>-->