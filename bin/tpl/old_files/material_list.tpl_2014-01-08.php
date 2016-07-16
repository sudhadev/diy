<?php 
$arrRowStyle[0]="";
$arrRowStyle[1]="ash_strip";
require_once($objCore->_SYS['PATH']['CLASS_SEARCH']);
require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
$objComponent = new Component();	 	
$objSearch = new Search($objCore->gConf);
require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
if(!is_object($objListing)) $objListing=new Listing();

$objSearch->pgBarStrPrevious='<span id="pgBarImgPre">Previous </span>';
$objSearch->pgBarStrNext='<span id="pgBarImgNext">Next </span>';
$str = explode("||", $output['parameters']);
if ($_REQUEST['categoryId'] == 0) $_REQUEST['categoryId'] = $str[0]; 
if ($_REQUEST['specificationId'] == 0) $_REQUEST['specificationId'] = $str[1]; 
if ($_REQUEST['manufacturerId'] == 0) $_REQUEST['manufacturerId'] = $str[2];
if ($objCore->curSection() == 'search') {
    $str = "categories=".$_REQUEST['categories']."&keyword=".$_REQUEST['keyword']."&address=".$_REQUEST['address']."&radius=".$_REQUEST['radius']."&order_by=".$_REQUEST['order_by']."&categoryId=".$_REQUEST['categoryId']."&specificationId=".$_REQUEST['specificationId']."&manufacturerId=".$_REQUEST['manufacturerId']."&latitude=".$_REQUEST['latitude']."&longitude=".$_REQUEST['longitude'];
}
elseif ($objCore->curSection() == 'browse') {
    $str = "f=result&tcid=".$_REQUEST['tcid']."&categoryId=".$_REQUEST['categoryId']."&specificationId=".$_REQUEST['specificationId']."&manufacturerId=".$_REQUEST['manufacturerId']."&order_by=".$_REQUEST['order_by'];
}
$parentList=$objCategory->getParentCpath($_REQUEST['categoryId']);
$parentId = $parentList[1]['category'];
//$objSearch->dev=true;
//echo $_REQUEST['latitude'];
if($_REQUEST['latitude']==0.0000||$_REQUEST['longitude']==0.0000){
   // echo 'adsssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss';
    $list = $objSearch->getSuppliers($_REQUEST['categoryId'], $_REQUEST['specificationId'], $_REQUEST['manufacturerId'], $_REQUEST['pg'], $_REQUEST['resultsPerPage'], $str, $_REQUEST['order_by'], $_REQUEST['keyword'], '', '', $_REQUEST['radius'],'','Y',$_REQUEST['preOrder'],$_REQUEST['dir']);
}
else{
    $list = $objSearch->getSuppliers($_REQUEST['categoryId'], $_REQUEST['specificationId'], $_REQUEST['manufacturerId'], $_REQUEST['pg'], $_REQUEST['resultsPerPage'], $str, $_REQUEST['order_by'], $_REQUEST['keyword'], $_REQUEST['latitude'], $_REQUEST['longitude'], $_REQUEST['radius'],'','Y',$_REQUEST['preOrder'],$_REQUEST['dir']);

}
$totalCount = $objSearch->getTotalCount();
$unit = $objCore->gConf['SEARCH_UNIT'];
$radiusDifference = $objCore->gConf['SEARCH_RADIOUS_DIFFERENCE'];
$pagination = $objCore->gConf['SEARCH_RECS_IN_LIST'];
//echo '<pre>';
//print_r($list);
//echo '</pre>';
//exit;


if ($_REQUEST['resultsPerPage'] != 0 && $_REQUEST['resultsPerPage'] != $pagination) $pagination = $_REQUEST['resultsPerPage'];


?>


<div class="search_description">
     <?php if ($totalCount==0)  { ?> 
                       <div class="no_data" style="width:600px">No Results Found.</div>   
                       <?php } else {  ?>
    <div id="searched_image"><img src="<?php $image = $objCategory->image($list[0][13],$objCore->_SYS['CONF']['FTP_CATS'],$objCore->_SYS['CONF']['URL_IMAGES_CATS']);
                                  echo $image; ?>" width="100" />
       
        <div id="enlarge_image" class="common_text_ash"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search-icon.jpg" width="14" height="15" /> <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $list[0][13]; ?>','categ');">Enlarge Image</a></div>
    </div>
    <div class="description_wraper_main">
        <div class="description_wraper description_text_big"><?php echo $parentId; ?> -<span class="description_text_normal"> <?php echo $list[0][16]; ?></span><br></div>
        <div id="average-price-bg">
            <span class="average-price">Average Unit Price (inc VAT)</span> <br/><span class="average-price-big">£<?php echo $list[0][17]; ?></span>
        </div>
    </div>
    <div class="description_sub_wraper_main">
        <div class="description_sub_wraper">
            <div class="description_sub common_text_ash">
                Notes:
            </div> 
            <div id="read_init" class="description_subdesc common_text" group="read_more" style="display:block"><?php //echo mb_substr($list[0][14], 0, 10)."..."; ?><?php echo substr($list[0][14], 0, 10)."..."; ?><br />
                <a href="javascript:animatedcollapse.toggle('read')">Read more</a><span class="read-more-bg"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/read-more.jpg" /></span></div>
            <div id="read" class="description_subdesc common_text" group="read_more" style="display:none">
                <?php echo $list[0][14]; ?><br /><a href="javascript:animatedcollapse.toggle('read_init')">Read Less</a><span class="read-more-bg"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/read-less.jpg" /></span>
            </div>
        </div>
        <div class="description_sub_wraper">
            <div class="description_sub common_text_ash">
                Manufacturer:
            </div> 
            <div class="description_subdesc common_text">
                <?php echo $list[0][15]; ?>
            </div>
        </div>
        <div class="description_sub_wraper">
            <div class="description_sub common_text_ash">
                Specifications:
            </div>
            <div class="description_subdesc common_text">
                <?php echo $list[0][10]; ?>
            </div>
        </div>
    </div> 
</div>


<div class="list">
       <div align="left">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
             
            <tr>
                <td class="list_blackbg_summery"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        
                      
                        <tr>
                            
                            <td width="47%"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  >
                                    <tr>
                                        <td width="10" height="30"></td>
                                        <td height="30" width="240"class="catagories_item_yellow">Showing <?php if ($_REQUEST['pg'] == 1) {
                                                echo $_REQUEST['pg'];
                                            } else {
                                                echo ((($_REQUEST['pg']-1)*$pagination) + 1);
                                            }?> to <?php if ($pagination>$totalCount) {
                                                echo $totalCount;
                                            } else {
                                                echo $_REQUEST['pg']*$pagination;
                                            }?> of <?php echo $totalCount; ?> Items</td>
                                        
                                        <td width="1" height="30"></td>
                                        <?php include("search_drop.php"); ?>
                                    </tr>
                                </table></td>
                            <td width="40%" height="30"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                    <tr>
                                        <td>
                                            <?php
                                            echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objSearch->pgBar."</div></td>";
                                            ?>
                                        </td>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td height="10"/>
            </tr>
            <tr>
                
                
                <td class="search_partison">

                    <div id="clear_selections">

                        <!-- <form id="clear_values" name="clear_values" action="">
                              <input type="hidden" id="action" name="action" value="add"/>
                            </form>  -->
                        <img onclick="javascript:clearItems('M','<?php echo count($list);?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/clear_selections_button.jpg" width="108" height="20" border="0"/>

                    </div>
                    <div id="add_selections">
                        <?php

                        if($objCore->sessCusId == "") {
                            $onclck = "search_result_supplies.submit();";
                        }else {
                            $onclck = "add('".count($list)."');";
                        }

                        ?>

                        <img onclick="<?php echo $onclck;?>" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/wish_list_button.jpg" width="170" height="20" border="0" />
                           <!--<img onclick="add('<?php echo count($list);?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/wish_list_button.jpg" width="170" height="20" border="0" />
                             <img onclick="search_result_supplies.submit();" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/wish_list_button.jpg" width="170" height="20" border="0" />-->

                    </div>

                </td>
            </tr>
             
            <tr>
                <td>
                    <div id="message_holder">
                        <div id="error_msg" style="width:605px; margin-left:0px">
                            <?php
                            if($msg) {

                                echo $objCore->msgBox("WISHLIST",$msg,'99%');
                            }
                            ?>
                        </div>
                        <table width="100%" border="0" align="center">
                            <tr>
                                <td class="" style="padding-top:10px;"><div id="divProcess" style="width:570px; margin-left:0px">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Uploading Image...</div></td>
                            </tr>
                            <tr>
                                <td></td>
                            </tr>
                        </table>
                    </div>

                    <?php //echo "=======>".$objCore->_SYS['CONF']['URL_SYSTEM']."/browse/index.php?".$_SERVER['QUERY_STRING']."<br />";?>
                    <form id="search_result_supplies" name="search_result_supplies" method="get" action="" >

                        <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0">
                            <td height="5"></td>
                            <tr>
                                <td colspan="9" align="left" valign="top">

                                    <div class="left_supplier<?php echo $_REQUEST['order_by'] == '1'? "_sorted":"";// Changed by Saliya?>">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="5" height="51"></td>
                                            </tr>
                                        </table>
                                    </div>


                                    <?php
                                    if($_REQUEST['latitude'] && $_REQUEST['longitude']) {
                                        $tableWidth='100%';
                                        $divStyle='';
                                    }
                                    else {
                                        $tableWidth='365px';
                                        $divStyle='width:365px;';
                                    }

                                    ?>
                                    <?php
                                    /*
                                     * For the hyperlink
                                     * $direction=!($_REQUEST['direction']);
                                     */


                                    if($_REQUEST['order_by']>0)
                                    {
                                    $prev_order = $_REQUEST['order_by'];
                                    }
                                    else{
                                        $prev_order = 1;
                                    }

                                    if($_REQUEST['dir']=="false")
                                    {
                                        $dir = 'true';
                                    }
                                    else{
                                        $dir = 'false';
                                    }

                                    $query_string = preg_replace('/(\w+)&preOrder=(\w*)(&?)(\w*)/', '$1$3$4', $_SERVER['QUERY_STRING']);
                                    $query_string = preg_replace('/(\w+)&dir=(\w*)(&?)(\w*)/', '$1$3$4', $query_string);

                                    ?>

                                    <div class="supplier<?php echo $_REQUEST['order_by'] == '1'? "_sorted":"";// Changed by Saliya?>" style="<?php echo $divStyle;?>">
                                        <table width="<?php echo $tableWidth;?>" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="5" height="20"></td>
                                                <td height="20" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td width="59" align="right" valign="top" class="sort">Order By</td>
                                                            <td width="306" align="right"><a href="index.php?<?php echo str_replace("&order_by=".$_REQUEST['order_by'],"&order_by=1",$query_string); ?>&preOrder=<?php echo $prev_order; ?>&dir=<?php echo $dir; ?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" border="0"/></a></td>
                                                            <td width="3"></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                            <tr>
                                                <td width="5"></td>
                                                <td class="list_style_spc1">Supplier</td>
                                            </tr>
                                        </table>
                                    </div>



                                    <?php

                                    if ($_REQUEST['latitude'] && $_REQUEST['longitude']) {
                                        ?>
                                    <div class="distance<?php echo $_REQUEST['order_by'] == '2'? "_sorted":"";// Changed by Saliya?>">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="5" height="20"></td>
                                                <td height="20" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="right"><a href="index.php?<?php echo str_replace("&order_by=".$_REQUEST['order_by'],"&order_by=2",$query_string); ?>&preOrder=<?php echo $prev_order; ?>&dir=<?php echo $dir; ?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" border="0" /></a></td>
                                                            <td width="3"></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                            <tr>
                                                <td width="5"></td>
                                                <td class="list_style_spc1">Dist.
                                                    (<?php echo $unit; ?>)</td>
                                            </tr>
                                        </table>
                                    </div>
                                        <?php

                                    }

                                    ?>
                                    <div class="delivery_S<?php echo $_REQUEST['order_by'] == '3'? "_sorted":"";// Changed by Saliya?>">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="5" height="20"></td>
                                                <td height="20" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="right"><a href="index.php?<?php echo str_replace("&order_by=".$_REQUEST['order_by'],"&order_by=3",$query_string); ?>&preOrder=<?php echo $prev_order; ?>&dir=<?php echo $dir; ?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" border="0" /></a></td>
                                                            <td width="3"></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                            <tr>
                                                <td width="5"></td>
                                                <td class="list_style_spc1">Min. Del.(£)</td>
                                            </tr>
                                        </table>
                                    </div>


                                    <div class="bulk_Discount_S<?php echo $_REQUEST['order_by'] == '4'? "_sorted":"";// Changed by Saliya?>">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="5" height="20"></td>
                                                <td height="20" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="right"><a href="index.php?<?php echo str_replace("&order_by=".$_REQUEST['order_by'],"&order_by=4",$query_string); ?>&preOrder=<?php echo $prev_order; ?>&dir=<?php echo $dir; ?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" border="0" /></a></td>
                                                            <td width="3"></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                            <tr>
                                                <td width="5"></td>
                                                <td class="list_style_spc1">Bulk
                                                    Disc.</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="unit_Price<?php echo $_REQUEST['order_by'] == '5'? "_sorted":"";// Changed by Saliya?>">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="5" height="20"></td>
                                                <td height="20" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="right"><a href="index.php?<?php echo str_replace("&order_by=".$_REQUEST['order_by'],"&order_by=5",$query_string); ?>&preOrder=<?php echo $prev_order; ?>&dir=<?php echo $dir; ?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" border="0" /></a></td>
                                                            <td width="3"></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                            <tr>
                                                <td width="5"></td>
                                                <td class="list_style_spc1">Unit <br />
                                                    Price(£)</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <div class="bulk_Price_S<?php echo $_REQUEST['order_by'] == '6'? "_sorted":"";// Changed by Saliya?>">

                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="5" height="20"></td>
                                                <td height="20" align="right"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td align="right"><a href="index.php?<?php echo str_replace("&order_by=".$_REQUEST['order_by'],"&order_by=6",$query_string); ?>&preOrder=<?php echo $prev_order; ?>&dir=<?php echo $dir; ?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" border="0" /></a></td>
                                                            <td width="3"></td>
                                                        </tr>
                                                    </table></td>
                                            </tr>
                                            <tr>
                                                <td width="5"></td>
                                                <td class="list_style_spc1">Bulk <br />
                                                    Price(£)</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="quantity_Requires">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="5" height="20"></td>
                                                <td height="20" align="right"></td>
                                            </tr>
                                            <tr>
                                                <td width="5"></td>
                                                <td class="list_style_spc1">Qty.</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="wish_list">
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td width="5" height="20"></td>
                                                <td height="20" align="right"></td>
                                            </tr>
                                            <tr>
                                                <td width="5" ></td>
                                                <td class="list_style_spc1">Wish List</td>
                                            </tr>
                                        </table>
                                    </div></td>
                            </tr>

                            <?php
                            /*
                                     * Start displaying the list
                                     * all the conditional statmensts relating to populate the listing should be end before this line - saliya
                            */
                            for($i=0;$i<count($list);$i++) {
                                ?>
                            <tr>
                                <td height="5"></td>
                            </tr>
                            <tr class="<?php echo $arrRowStyle[$i%2];?>">
                                    <?php if($_REQUEST['latitude'] && $_REQUEST['longitude']) {?>
                                <td width="315" height="50" align="center" valign="middle">
                                            <?php } else {?>
                                <td width="370" height="50" align="center" valign="middle">
                                            <?php }?>
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                            <td width="5" height="15">

                                            </td>
                                            <td height="15" class="list_style_spc3"><div style="float:left;min-height: 210px;">
                                            <?php  
                                            
                                            if($list[$i][19]==""||$list[$i][19]=="no_image.jpg"){
                                                
                                                $imgUrl = $objListing->image($list[$i][29],$objCore->_SYS['CONF']['FTP_SPECS'],$objCore->_SYS['CONF']['URL_IMAGES_SPECS'],''); 
                                            }
                                            else{
                                              $imgUrl = $objListing->image($list[$i][19],$objCore->_SYS['CONF']['FTP_LISTINGS'],$objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'],$list[$i][11]);
                                              
                                            }
                                            
                                            
                                            ?>
<!--                         <a href="<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>browse/?f=more&catid=1&cid=<?php echo $list[$i][11]; ?>&lid=<?php echo $list[$i][18]; ?>">-->
                                              <img src="<?php echo $imgUrl;?>" width="90" border="0" style="padding-right:8px; padding-left: 5px;padding-top: 5px;"/>
<!--                                </a>-->
                                                    <br/>
     <span class="common_text_ash" style="margin-left:25px;">
       
<?php

 $image_array = array($list[$i][19],$list[$i][25],$list[$i][26],$list[$i][27]);
        $count = 0;
        
        foreach($image_array as $image){
            if($image==''||$image=='no_image.jpg'){
                
            }
            else{
                $count++; 
            }
}
if($count==0){
    if($list[$i][29]!=''||$list[$i][29]!='no_image.jpg'){
        $image_array = array($list[$i][13]);
        $count = 1;
    }
    else{
        
    }
    
}
if ($_REQUEST['latitude'] && $_REQUEST['longitude']) {

    $distance = round($list[$i][12], 2);

}


echo '<a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=1&cid='.$list[$i][11].'&lid='.$list[$i][18].'&dis='.$distance.'">Photos ('.$count.') </a>';
  

        ?>
    
       
       </span>
                                                </div>
                                                <div class="supplies_text_common" style="margin-left: 100px; padding-top: 5px;text-align: left;margin-bottom: 10px;"> 
                                                    <strong><?php echo strtoupper($list[$i][15]); ?>&nbsp;<?php echo $list[$i][10]?></strong>
                                                    <br/><br/>
                                                    <?php 
                                                    if($list[$i][20]){
                                                    if(strlen($list[$i][20])>130){
                                                        echo substr($list[$i][20], 0, 130).'<span>...</span><a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=1&cid='.$list[$i][11].'&lid='.$list[$i][18].'&dis='.$distance.'" style="text-decoration:underline;font-weight:bold;"> more</a>';
                                                    }
                                                    else{
                                                        echo $list[$i][20].'<a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=1&cid='.$list[$i][11].'&lid='.$list[$i][18].'&dis='.$distance.'" style="text-decoration:underline;font-weight:bold;"> more</a>';
                                                       
                                                    }
                                                    }
                                                    ?>
                                                    <br/><br/><br/><strong><?php echo '<a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=1&cid='.$list[$i][11].'&lid='.$list[$i][18].'&dis='.$distance.'">'.strtoupper($list[$i][21]).'</a>';?></strong><br/><br/><?php echo $list[$i][23];?> &nbsp; <?php echo strtoupper($list[$i][24]);?><br/><br/>
                                                    
                                                    Tel:&nbsp;<?php echo $list[$i][2];?><br/><br/>
                                                    
                                                    <span>Email:&nbsp;<a href="mailto:<?php echo $list[$i][3];?>" style="text-decoration:underline;font-weight: bold;"><?php echo $list[$i][3];?></a></span><br/><br/>
                                                    <?php if($list[$i][30]!=""){?>
                                                    <span style="margin-left: 0px;"><a target="_blank" href="<?php echo "http://".str_replace("http://", '', $list[$i][30]);?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/visit-website.png"/></a></span> 
                                                    <?php } ?>
                                                    
                                                </div></td>
                                        </tr>
                                    </table></td>
                                    <?php if ($_REQUEST['latitude'] && $_REQUEST['longitude']) {?>
                                <td width="55" height="50" align="center" valign="middle" class="list_style_spc3"><div align="center"><?php echo round($list[$i][12], 2);?> </div></td>
                                        <?php }?>
                                <td width="43" height="50" align="center" valign="middle" class="list_style_spc3"><div align="center" class="list_style_spc3">&pound;<?php echo $list[$i][9]; ?></div></td>
                                <td width="46" height="50" align="center" valign="middle" class="list_style_spc3"><div align="center"><?php echo $list[$i][7]."+"; ?></div></td>
                                <td width="48" height="50" align="center" valign="middle" class="list_style_spc1"><div align="center">&pound;<?php echo $list[$i][6]; ?></div></td>
                                <td width="48" height="50" align="center" valign="middle" class="list_style_spc3"><div align="center">&pound;<?php echo $list[$i][8]; ?></div></td>
                                <td width="52" height="50" align="center" valign="middle">
                                    <div id="qty">
                                        <input id="quantity[<?php echo $i;?>]" name="quantity[<?php echo $i;?>]" type="text" class="list_style_spc2" style="width:25px" value="<?php echo $_REQUEST['quantity'][$i];?>"/>
                                    </div>
                                </td>
                                <td width="46" height="50" align="center" valign="middle"><label>
                                        <input type="checkbox" name="checkVal[<?php echo $i;?>]" id="checkVal[<?php echo $i;?>]" value="<?php echo $list[$i][18];?>" onclick="javascript:selectItems('<?php echo $list[$i][18];?>');"/>
                                    </label></td> 
                            </tr>
                            <tr>
                                <td height="2">
                                    <input type="hidden" id="listing_id[<?php echo $i;?>]" name="listing_id[<?php echo $i;?>]" value="<?php echo $list[$i][18]; ?>"/>
                                </td>
                            </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <input type="hidden" id="action" name="action" value="add"/>
                        <input type="hidden"  id="subscription" name="subscription" value="M"/>

                        <?php
                        if ($objCore->curSection() == 'search') {
                            $strSearch = explode("|DLM|", $objCore->sysVars['Search']);
                            ?>
                        <input type="hidden" id="categories" name="categories" value="<?php echo $strSearch[0];?>">
                        <input type="hidden" id="keyword" name="keyword" value="<?php echo $strSearch[1];?>">
                        <input type="hidden" id="address" name="address" value="<?php echo $strSearch[2];?>">
                        <input type="hidden" id="radius" name="radius" value="<?php echo $strSearch[3];?>">
                        <input type="hidden" id="order_by" name="order_by" value="<?php echo $strSearch[4];?>">
                        <input type="hidden" id="categoryId" name="categoryId" value="<?php echo $strSearch[5];?>">
                        <input type="hidden" id="specificationId" name="specificationId" value="<?php echo $strSearch[6];?>">
                        <input type="hidden" id="manufacturerId" name="manufacturerId" value="<?php echo $strSearch[7];?>">
                        <input type="hidden" id="latitude" name="latitude" value="<?php echo $strSearch[8];?>">
                        <input type="hidden" id="longitude" name="longitude" value="<?php echo $strSearch[9];?>"/>
                        <input type="hidden" id="pg" name="pg" value="<?php echo $strSearch[10];?>"/>
                            <?php }
                        elseif ($objCore->curSection() == 'browse') {
                            ?>
                        <input type="hidden" id="f" name="f" value="<?php echo $strBrowse[0];?>">
                        <input type="hidden" id="tcid" name="tcid" value="<?php echo $strBrowse[1];?>">
                        <input type="hidden" id="categoryId" name="categoryId" value="<?php echo $strBrowse[2];?>">
                        <input type="hidden" id="specificationId" name="specificationId" value="<?php echo $strBrowse[3];?>">
                        <input type="hidden" id="manufacturerId" name="manufacturerId" value="<?php echo $strBrowse[4];?>">
                        <input type="hidden" id="order_by" name="order_by" value="<?php echo $strBrowse[5];?>">
                        <input type="hidden" id="pg" name="pg" value="<?php echo $strBrowse[6];?>">
                        <input type="hidden" id="categories" name="categories" value="<?php echo $strBrowse[7];?>">
                            <?php }?>

                    </form>
                </td>
            </tr> 
            <tr>
                <td height="10"></td>
            </tr>
            <tr>
                <td class="search_partison">

                    <div id="clear_selections">

                        <!-- <form id="clear_values" name="clear_values" action="">
                              <input type="hidden" id="action" name="action" value="add"/>
                            </form>  -->
                        <img onclick="javascript:clearItems('M','<?php echo count($list);?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/clear_selections_button.jpg" width="108" height="20" border="0"/>

                    </div>
                    <div id="add_selections">
                        <?php

                        if($objCore->sessCusId == "") {
                            $onclck = "search_result_supplies.submit();";
                        }else {
                            $onclck = "add('".count($list)."');";
                        }

                        ?>

                        <img onclick="<?php echo $onclck;?>" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/wish_list_button.jpg" width="170" height="20" border="0" />
                         
                    </div>

                </td>
            </tr>
            <tr>
                <td height="10"/>
            </tr>
             
        </table>
    </div>



    <div align="left">
        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
                <td class="list_blackbg_summery"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="47%"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  >
                                    <tr>
                                        <td width="10" height="30"></td>
                                        <td height="30" width="240"class="catagories_item_yellow">Showing <?php if ($_REQUEST['pg'] == 1) {
                                                echo $_REQUEST['pg'];
                                            } else {
                                                echo (($_REQUEST['pg']*$pagination) + 1);
                                            }?> to <?php if ($pagination>$totalCount) {
                                                echo $totalCount;
                                            } else {
                                                echo $_REQUEST['pg']*$pagination;
                                            }?> of <?php echo $totalCount; ?> Items</td>
                                        <td width="1" height="30"></td>
                                        <?php include("search_drop.php"); ?>
                                    </tr>
                                </table></td>
                            <td width="40%" height="30"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                    <tr>
                                        <?php
                                        echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objSearch->pgBar."</div></td>";
                                        ?>
                                    </tr>
                                </table></td>
                        </tr>
                    </table></td>
            </tr>
             <?php
                }
               ?>
            <tr>
                <td height="10"></td>
            </tr>
            <tr></tr>
        </table>
