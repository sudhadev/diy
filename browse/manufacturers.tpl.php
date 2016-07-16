<?php
require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
$objListing = new Listing(); 
$manufac = $objListing->getManufacturers($_REQUEST['catId'], $_REQUEST['specId']); 
$numOfManufacturersInList=4;

for($a=0;$a<count($manufac);$a++){
    $manufacArray[$manufac[$a]['specification']][] = $manufac[$a]['manufacturer'];
    $manufacDataArray[$manufac[$a]['specification']][] = array($manufac[$a]['specification_id'],$manufac[$a]['manufacturer_id'],$manufac[$a]['manufacturer']);
}
$topList=$objCategory->getTopcList();
for ($m=0; $m<count($list); $m++)
{
    if ($list[$m][0]==$_REQUEST['pcid']) $temp = $m;
}
$listSub=$objCategory->getSubcList($list[$temp][0],'sub_arr');
for ($n=0; $n<count($listSub); $n++)
{
    if ($listSub[$n][0]==$_REQUEST['catId']) $tempSub = $n;
}
?> 
<div id="middle_right_bar">
<div id="middle_center_bar">
    <div id="middle_center_bar_header"></div>
    <div id="middle_center_bar_content">
        <div id="banner">Specifications</div>
        <div class="breadcrumb"><a href="?tcid=<?php echo $_REQUEST['tcid'];?>"><?php echo $topList[$_REQUEST['tcid']]['category']?></a> > <a href="?f=slist&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo $_REQUEST['pcid'];?>"><?php echo $list[$temp][3];?></a> > <?php echo $listSub[$tempSub][3];?></div>
        <?php
        $manufacKeyArray=array_keys($manufacArray);
        for($a=0;$a<count($manufacArray);$a++){
            ?>
        <div class="middle_center_bar_cells">
            <div class="middle_center_bar_cells_head">
                <div class="sub_title" id="browseManufact" ><?php echo $manufacKeyArray[$a];?></div>
                </div>
                <div class="nav-menu">
                    <ul>
                        <?php for($b=0;$b<count($manufacArray[$manufacKeyArray[$a]]);$b++){
                        	$p_count=$objListing->getListingsforACategory_supply_2( 1, $_REQUEST['pcid'] ,$_REQUEST['catId'] , $manufacDataArray[$manufacKeyArray[$a]][$b][0], $manufacDataArray[$manufacKeyArray[$a]][$b][1]);
                        	?>
                        <li>
                        	<a href="?f=result&tcid=<?php echo $_REQUEST['tcid'];?>&categories=1&categoryId=<?php echo $_REQUEST['catId'];?>&specificationId=<?php echo $manufacDataArray[$manufacKeyArray[$a]][$b][0];?>&manufacturerId=<?php echo $manufacDataArray[$manufacKeyArray[$a]][$b][1];?>&order_by=<?php echo $_REQUEST['order_by']?>&pg=1">
                        		<?php echo $manufacArray[$manufacKeyArray[$a]][$b];?>
                        	</a> [<?php echo $p_count; ?>]
                        </li>
                        <?php }?>
                    </ul>
                </div>
                <div class="middle_center_bar_cells_foot">
                </div>
            </div>
            <?php
        }
        ?>
        </div>
        <div id="middle_center_bar_bottom"> </div>
    </div>

<?php include($objCore->_SYS['PATH']['RIGHT_FRONT']);?>
</div>