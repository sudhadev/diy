<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  left.inc.php                                        '
  '    PURPOSE         :  left panel                                          '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
if(!is_object($objCategory)) {
    $objCategory = new Category(); 
}
$cArray = array_values($objCategory->getTopcList()); 



if (!($objCore->curSection() == 'browse')) {
    require_once($objCore->_SYS['PATH']['CLASS_SEARCH']);
    $objSearch = new Search($objCore->gConf);
    $url = "categories=".$_REQUEST['categories']."&keyword=".$_REQUEST['keyword']."&radius=".$_REQUEST['radius']."&categoryId=".$_REQUEST['categoryId']."&latitude=".$_REQUEST['latitude']."&longitude=".$_REQUEST['longitude'];
    switch ($_REQUEST['categories']) {
        case 1: {
                $output = $objSearch->doSearch($_REQUEST['keyword'], $_REQUEST['latitude'], $_REQUEST['longitude'], $_REQUEST['radius'], $_REQUEST['pg'], $_REQUEST['categoryId'], $_REQUEST['order_by'], $_REQUEST['specificationId'], $_REQUEST['manufacturerId']);
            }break;
        case 2: {
                $output = $objSearch->getServices($_REQUEST['keyword'], $_REQUEST['latitude'], $_REQUEST['longitude'], $_REQUEST['radius'], $_REQUEST['pg'], $_REQUEST['categoryId'], $url, $_REQUEST['resultsPerPage'], $_REQUEST['order_by']);
            }break;
        case 3: {
                $output = $objSearch->getClassifieds($_REQUEST['keyword'], $_REQUEST['latitude'], $_REQUEST['longitude'], $_REQUEST['radius'], $_REQUEST['pg'], $_REQUEST['categoryId'], $url, $_REQUEST['resultsPerPage'], $_REQUEST['order_by']);
            }break;
    }
    $unit = $objCore->gConf['SEARCH_UNIT'];
    $radiusDifference = $objCore->gConf['SEARCH_RADIOUS_DIFFERENCE'];
    $pagination = $objCore->gConf['SEARCH_PAGINATION_SIZE'];
    $link = '';

    if ($_REQUEST['categories'] == 1 && $output['refineData']) {
        $flgRefineSearch=true;// this indicates that the page displayed refine search option
        
?>

<div id="middle_left_bar_middle">
    <div id="tag_image_2big">
        <div id="tag_heading">REFINE SEARCH</div>
    </div>
    <div class="tag_partision">
        <div class="double_arrow cursorHand"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" onclick="toggleTabs('rsType');"/></div>
        <div class="tag_heading_big cursorHand"  onclick="toggleTabs('rsType');">Type</div>
    </div>
    <div class="tag_bg_big" id="rsType" style="display:block;"><div id="catagories-outer" >
      <div class="catagories">
        <?php
        //echo $output['parameters'];
        $strTemp = explode("||", $output['parameters']);
        $new_array = array();
        for($i=0;$i<count($output[refineData]);$i++) {
                            $new_array[$output[refineData][$i][category]] = $output[refineData][$i];
        }
        ksort($new_array);
        
         foreach($new_array as $newvals) {
            
            if ($newvals['refine_type'] == 'type') {
                $link = str_replace("&categoryId=".$_REQUEST['categoryId']."&specificationId=".$_REQUEST['specificationId']."&manufacturerId=".$_REQUEST['manufacturerId'], "&categoryId=".$newvals['id']."&specificationId=0&manufacturerId=0",$_SERVER['QUERY_STRING']);
                if ($strTemp[0]==$newvals['id']) {
                    echo "<div class=\"selected_left\"><a href=\"index.php?".$link."\">".$newvals[category]."</a><span class=\"catagories_item_yellow\"> (".$newvals['COUNT(*)'].")</span></div>";
                }
                else {
                    echo "<div class=\"catagories_item\"><a href=\"index.php?".$link."\">".$newvals[category]."</a><span class=\"catagories_item_yellow\"> (".$newvals['COUNT(*)'].")</span></div>";
                }
            }
                        }
                        
//        for($i=0;$i<count($output[refineData]);$i++) {
//            if ($output[refineData][$i]['refine_type'] == 'type') {
//                $link = str_replace("&categoryId=".$_REQUEST['categoryId']."&specificationId=".$_REQUEST['specificationId']."&manufacturerId=".$_REQUEST['manufacturerId'], "&categoryId=".$output[refineData][$i]['id']."&specificationId=0&manufacturerId=0",$_SERVER['QUERY_STRING']);
//                if ($strTemp[0]==$output[refineData][$i]['id']) {
//                    echo "<div class=\"selected_left\"><a href=\"index.php?".$link."\">".$output[refineData][$i][category]."</a><span class=\"catagories_item_yellow\"> (".$output[refineData][$i]['COUNT(*)'].")</span></div>";
//                                }
//                                else {
//                                    echo "<div class=\"catagories_item\"><a href=\"index.php?".$link."\">".$output[refineData][$i][category]."</a><span class=\"catagories_item_yellow\"> (".$output[refineData][$i]['COUNT(*)'].")</span></div>";
//                                }
//                                $count[] = $output['refineData'][$i]['COUNT(*)'];
//                            }
//                        }
                        ?>
            </div>
        </div>
    </div>

    <div class="tag_partision">
        <div class="double_arrow cursorHand" onclick="toggleTabs('rsSpec');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" /></div>
        <div class="tag_heading_big cursorHand" onclick="toggleTabs('rsSpec');">Specifications</div>
    </div>
    <div class="tag_bg_big" id="rsSpec" style="display:block;"><div id="catagories-outer">
            <div class="catagories">
                        <?php
         $new_array = array();
        for($i=0;$i<count($output[refineData]);$i++) {
                            $new_array[$output[refineData][$i][category]] = $output[refineData][$i];
        }
        ksort($new_array);
        foreach($new_array as $newvals) {
            
            if ($newvals['refine_type'] == 'specification') {
                $link = str_replace("&specificationId=".$_REQUEST['specificationId']."&manufacturerId=".$_REQUEST['manufacturerId'], "&specificationId=".$newvals['id']."&manufacturerId=0", $_SERVER['QUERY_STRING']);
                if ($strTemp[1]==$newvals['id']) {
                    echo "<div class=\"selected_left\"><a href=\"index.php?".$link."\">".$newvals[category]."</a><span class=\"catagories_item_yellow\"> (".$newvals['COUNT(*)'].")</span></div>";
                }
                else {
                    echo "<div class=\"catagories_item\"><a href=\"index.php?".$link."\">".$newvals[category]."</a><span class=\"catagories_item_yellow\"> (".$newvals['COUNT(*)'].")</span></div>";
                }
            }
                        }
                        //print_r($new_array);
                        ?>
            </div>
        </div>
    </div>

    <div class="tag_partision"  onclick="toggleTabs('rsMan');">
        <div class="double_arrow  cursorHand"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" /></div>
        <div class="tag_heading_big  cursorHand">Manufacturer</div>
    </div>
    <div class="tag_bg_big" id="rsMan" style="display:block;"><div id="catagories-outer">
            <div class="catagories">
                        <?php
//                        for($i=0;$i<count($output[refineData]);$i++) {
//                            if ($output[refineData][$i]['refine_type'] == 'manufacturer') {
//                                $link = str_replace("&manufacturerId=".$_REQUEST['manufacturerId'],"&manufacturerId=".$output[refineData][$i]['id'],$_SERVER['QUERY_STRING']);
//                                if ($strTemp[2]==$output[refineData][$i]['id']) {
//                    echo "<div class=\"selected_left\"><a href=\"index.php?".$link."\">".$output[refineData][$i][category]."</a><span class=\"catagories_item_yellow\"> (".$output[refineData][$i]['COUNT(*)'].")</span></div>";
//                }
//                else {
//                    echo "<div class=\"catagories_item\"><a href=\"index.php?".$link."\">".$output[refineData][$i][category]."</a><span class=\"catagories_item_yellow\"> (".$output[refineData][$i]['COUNT(*)'].")</span></div>";
//                }
//            }
//        }
           for($i=0;$i<count($output[refineData]);$i++) {
                            $new_array[$output[refineData][$i][category]] = $output[refineData][$i];
        }
        ksort($new_array);
        foreach($new_array as $newvals) {
            
            if ($newvals['refine_type'] == 'manufacturer') {
                $link = str_replace("&manufacturerId=".$_REQUEST['manufacturerId'],"&manufacturerId=".$newvals['id'],$_SERVER['QUERY_STRING']);
                if ($strTemp[2]==$newvals['id']) {
                    echo "<div class=\"selected_left\"><a href=\"index.php?".$link."\">".$newvals[category]."</a><span class=\"catagories_item_yellow\"> (".$newvals['COUNT(*)'].")</span></div>";
                }
                else {
                    echo "<div class=\"catagories_item\"><a href=\"index.php?".$link."\">".$newvals[category]."</a><span class=\"catagories_item_yellow\"> (".$newvals['COUNT(*)'].")</span></div>";
                }
            }
                        }             
        ?>
            </div>
        </div>
    </div>
</div>

<?php
    }
    elseif ($_REQUEST['categories'] == 2 && $output['refineData']) {
        $flgRefineSearch=true;// this indicates that the page displayed refine search option
?>

<div id="middle_left_bar_middle">
    <div id="tag_image_2big">
        <div id="tag_heading">REFINE SEARCH</div>
    </div>
    <div class="tag_partision cursorHand" onclick="toggleTabs('rsCat');">
        <div class="double_arrow"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" /></div>
        <div class="tag_heading_big">Categories</div>
    </div>
    <div class="tag_bg_big" id="rsCat" style="display:block;" ><div id="catagories-outer">
            <div class="catagories">
                        <?php
        for ($i=0; $i<count($output['refineData']); $i++) {
            $link = str_replace("&categoryId=".$_REQUEST['categoryId'],"&categoryId=".$output['refineData'][$i]['id'],$_SERVER['QUERY_STRING']);
            if ($output['parameters']==$output[refineData][$i]['id']) {
                echo "<div class=\"selected_left\"><a href=\"index.php?".$link."\">".$output['refineData'][$i][category]."</a><span class=\"catagories_item_yellow\"> (".$output['refineData'][$i]['COUNT(*)'].")</span></div>";
            }
            else {
                echo "<div class=\"catagories_item\"><a href=\"index.php?".$link."\">".$output['refineData'][$i][category]."</a><span class=\"catagories_item_yellow\"> (".$output['refineData'][$i]['COUNT(*)'].")</span></div>";
            }
            $count[] = $output['refineData'][$i]['COUNT(*)'];

        }
        ?>
            </div>
        </div>
    </div>
</div>

<?php
    }
    elseif ($_REQUEST['categories'] == 3 && $output['refineData']) {
    $flgRefineSearch=true;// this indicates that the page displayed refine search option
?>

<div id="middle_left_bar_middle">
    <div id="tag_image_2big">
        <div id="tag_heading">REFINE SEARCH</div>
    </div>
    <div class="tag_partision cursorHand" onclick="toggleTabs('rsCat');">
        <div class="double_arrow"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" /></div>
        <div class="tag_heading_big">Catogories</div>
    </div>
    <div class="tag_bg_big"   id="rsCat" style="display:block;" ><div id="catagories-outer">
            <div class="catagories">
                        <?php
                        for ($i=0; $i<count($output['refineData']); $i++) {
                            $link = str_replace("&categoryId=".$_REQUEST['categoryId'],"&categoryId=".$output['refineData'][$i]['id'],$_SERVER['QUERY_STRING']);
                            if ($output['parameters']==$output[refineData][$i]['id']) {
                echo "<div class=\"selected_left cursorHand\"><a href=\"index.php?".$link."\">".$output['refineData'][$i][category]."</a><span class=\"catagories_item_yellow\"> (".$output['refineData'][$i]['COUNT(*)'].")</span></div>";
            }
            else {
                echo "<div class=\"catagories_item\"><a href=\"index.php?".$link."\">".$output['refineData'][$i][category]."</a><span class=\"catagories_item_yellow\"> (".$output['refineData'][$i]['COUNT(*)'].")</span></div>";
            }
            $count[] = $output['refineData'][$i]['COUNT(*)'];
        }
        ?>
            </div>
        </div>
    </div>
</div>

<?php
    }
    if ($output['refineData']) {
?>

<div class="tag_partision"  onclick="toggleTabs('rsRad');">
    <div class="double_arrow cursorHand"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" /></div>
    <div class="tag_heading_big cursorHand">Radius</div>
</div>
<div class="tag_bg_big" id="rsRad" style="display:block;"><div id="catagories-outer">
        <div class="catagories">
            <div id="radious_desc">Currently <span id="radious_desc_yellow"> <?php echo $_REQUEST['radius']." ".$unit; ?></span></div>
            <div class="radious_plus"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/plus.jpg" width="11" height="11" /></div>
            <div class="radious"><a href="index.php?<?php echo str_replace("&radius=".$_REQUEST['radius'],"&radius=".((int)$_REQUEST['radius'] + $radiusDifference),$_SERVER['QUERY_STRING']); ?>">Increase by <?php echo $radiusDifference." ".$unit; ?></a></div>
            <div class="radious_minus"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/minus.jpg" /></div>
            <div class="radious"><a href="index.php?<?php echo str_replace("&radius=".$_REQUEST['radius'],"&radius=".((int)$_REQUEST['radius'] - $radiusDifference),$_SERVER['QUERY_STRING']); ?>">Decrease by <?php echo $radiusDifference." ".$unit; ?></a></div>
        </div>
    </div>
</div>
<div id="tag_image_footer"></div>
<div id="space"></div>
<div><?php include($objCore->_SYS['PATH']['SEARCH_COM']);?></div>
<div id="space"></div>

<?php
    }
    if ($count) $count = array_sum($count); // number of total search records
}?>

<?php 
switch($objCore->curSection()) {

    case "my_listings":
    case "my_listings_edit":
        {


?>
<div id="middle_left_bar_middle">
    <div id="tag_image_2"></div>
    <div id="tag_image_3"><div id="tag_image_3_heading"></div></div>
    <div id="tag_bg">
        <div id="tag_bg_middle">

            <div id="catagories-outer">

    <?php
   // for($tc=0;$tc<count($cArray);$tc++) {

    // set the arrow direction (image)
        $_REQUEST['tcid']==$cArray[$tc]['id']?$arrowDirection='up':$arrowDirection='down';
        $tcidCurrent=$_REQUEST['tcid'];
        $linkfolder=$objCore->curSection();
        ?>
                <div class="catagories">
                    <div class="catagories_arrow"><a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/my_account/<?php echo $linkfolder;?>/"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/<?php echo $arrowDirection;?>-arrow.jpg" border="0" /></a></div>
                    <div class="catagories_name"><a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/my_account/<?php echo $linkfolder;?>/"><?php echo $cArray[0]['category'];?></a></div>
        <?php
        

              if($objCore->curSection()=="my_listings_edit")
              {
                  $list=$objCategory->getCategoryByCustomerListing($objCore->sessCusId, 1);
              }
              else
              {
                  $list=$objCategory->getSubcList(1,'sub_arr');
              }
                  
                  
            for($l=0;$l<count($list);$l++) {
                ?>
                    <div class="catagories_item_browse"><a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/my_account/<?php echo $linkfolder;?>/?tids=<?php echo $cArray[0]['id'];?>_<?php echo $list[$l][0];?>"><?php echo $list[$l][3];?></a></div>
            <?php
        
        ?>


        <?php
        }// end 1st level loop

        ?>
                </div>
    <?php
    //}
?>
                                    <div class="catagories_item_browse" style="padding-top:12px;margin-left:-2px;">
                                    <?php if($objCore->isAuthorized(1, 'my_listings')) {

                                            if($objCore->curSection()=="my_listings")
                                            {
                                                if(!is_object($objListing)){ require_once($objCore->_SYS['PATH']['CLASS_LISTING']);$objListing = new Listing();}
                                                $listingInfo=$objListing->getTotals($objCore->sessCusId);
                                                if($listingInfo[0]['total_count']){
                                                    $link='_edit';$lText='Edit My Listings';
                                                }

                                            }
                                            else
                                            {
                                                $link='';$lText='Add Listings';
                                            }

                                            if($lText){
                                    ?>
                                        <span  style="padding-bottom:20px;"><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT']."/my_listings".$link; ?>"><strong><?php echo $lText;?></strong></a></span><br/><br/>
                                    <?php
                                            } // end if lText
                                    }?>

                                    <?php if($objCore->isAuthorized(1, 'new_listings')) {?>
                                        <span><a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS']."?req=cate&ids=".$cArray[0]['id'];?>"><strong>Add New Category</strong></a></span>
                                    <?php }?>
                                    </div>
<?php
   /*
     * COMMENTED TO HIDE INSTANT EXPAND AND COLLAPSE MECHANISM
     * & TO KEEP THE FORMAT IN CONSISTANCE WITH THE BROWSE SECTION
     * BY THE REQUEST OF JASON
     * - SALIYA WIJESINGHE - 2010-09-15 *
    ?>

            <div class="catagories">
                            <ul id="dhtmlgoodies_tree" class="dhtmlgoodies_tree">

                            <?php //for ($s=0;$s<count($cArray);$s++)
                                    //{
                            ?>
                                <li class="catagories_name">
                                    <a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/my_account/my_listings/?tid=<?php echo $cArray[0]['id'];?>" cPath="<?php echo $cArray[0]['id'];?>" ><?php echo $cArray[0]['category'];?></a>
                                    
                                    <ul class="catagories_item_browse">
                                        <li class="catagories_item_browse" parentId="<?php echo $cArray[0]['id'];?>"><a href="">Loading...</a></li>
                                        </ul>
                                    <div class="catagories_item_browse" style="padding-top:12px;margin-left:-2px;">
                                    <?php if($objCore->isAuthorized(1, 'my_listings')) {

                                            if($objCore->curSection()=="my_listings")
                                            { 
                                                if(!is_object($objListing)){ require_once($objCore->_SYS['PATH']['CLASS_LISTING']);$objListing = new Listing();}
                                                $listingInfo=$objListing->getTotals($objCore->sessCusId);      
                                                if($listingInfo[0]['total_count']){
                                                    $link='_edit';$lText='Edit My Listings';
                                                }
                                                
                                            }
                                            else
                                            {
                                                $link='';$lText='Add Listings';
                                            }

                                            if($lText){
                                    ?>
                                        <span  style="padding-bottom:20px;"><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT']."/my_listings".$link; ?>"><strong><?php echo $lText;?></strong></a></span><br/><br/>
                                    <?php
                                            } // end if lText
                                    }?>

                                    <?php if($objCore->isAuthorized(1, 'new_listings')) {?>
                                        <span><a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS']."?req=cate&ids=".$cArray[0]['id'];?>"><strong>Add New Category</strong></a></span>
                                    <?php }?>
                                    </div>
                                </li>

                            <?php
                                    //}
                            ?>
                            </ul>
			</div>

<?php */?>
			<div class="catagories">
			<div class="catagories_arrow"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/white-arrow.jpg" /></div>
			<div class="catagories_name"><a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/browse/">Browse all categories</a></div>
			</div>
            <?php if(!$objCore->sessCusId || ($objCore->sessCusId && $objCore->isAuthorized(1, 'classified_ads'))) {?>
            }
			<div class="catagories">
			<div class="catagories_arrow"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/white-arrow.jpg" /></div>
			<div class="catagories_name"><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/classified_ads/index.php?f=add">Place a Classified Ad</a></div>
            </div>
            <?php }?>
            </div>

          
        </div>
        <div id="tag_image_footer"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/catogory-footer.gif" /></div>
    </div>
</div>
       <script type="text/javascript">
            initTree("2","<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>",'<?php if($objCore->curSection()=="my_listings_edit") echo $objCore->sessCusId."|spl|_edit";?>');
        </script>
                        <?php 		$boolCTreeDisplayed=true;
                    } break;// end my_listing case
                   
                    ?>

<?php 	
    } // End Switch
?>

<?php // BROWSE CATEGORY BOX DISYPAY ------------------------------------------------->
            // following tree will be displays if not any of the category tree variation
            // not displayed above

if(!$boolCTreeDisplayed && $objCore->curSection()!="search" ||($objCore->curSection()=='search' && !$flgRefineSearch)) {
    ?>
<div id="middle_left_bar_middle">
    <div id="tag_image_2" <?php if ($objCore->curSection() == 'search' && $output['refineData']) { echo "style=height:20px"; }?>></div>
    <div id="tag_image_3"><div id="tag_image_3_heading"></div></div>
    <div id="tag_bg">
        <div id="tag_bg_middle">
            <div id="catagories-outer">

    <?php
    for($tc=0;$tc<count($cArray);$tc++) {

    // set the arrow direction (image)
        $_REQUEST['tcid']==$cArray[$tc]['id']?$arrowDirection='up':$arrowDirection='down';
        $tcidCurrent=$_REQUEST['tcid'];
        ?>
                <div class="catagories">
                    <div class="catagories_arrow"><a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/browse/?tcid=<?php echo $cArray[$tc]['id'];?>&ctcid=<?php echo $tcidCurrent;?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/<?php echo $arrowDirection;?>-arrow.jpg" border="0" /></a></div>
                    <div class="catagories_name"><a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/browse/?tcid=<?php echo $cArray[$tc]['id'];?>&ctcid=<?php echo $tcidCurrent;?>"><?php echo $cArray[$tc]['category'];?></a></div>
        <?php
        if($_REQUEST['tcid']==$cArray[$tc]['id']) {

            $list=$objCategory->getSubcList($cArray[$tc]['id'],'sub_arr');
            for($l=0;$l<count($list);$l++) {
                ?>
                    <div class="catagories_item_browse"><a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/browse/?f=slist&tcid=<?php echo $cArray[$tc]['id'];?>&pcid=<?php echo $list[$l][0];?>"><?php echo $list[$l][3];?></a></div>
            <?php
        }// end 2nd level loop
        ?>

                   <?php if($objCore->isAuthorized(1, 'new_listings')) {?>
                    <div class="catagories_item_browse"  style="padding-top:7px"><a href="<?php echo $objCore->_SYS['CONF']['URL_NEW_LISTINGS']."?req=cate&ids=".$cArray[$tc]['id'];?>"><strong>Add New Category</strong></a></div>
                    <?php }?>
        <?php
        }// end 1st level loop
       
        ?>
                </div>
    <?php
    }
    ?>


                <div class="catagories">
                    <div class="catagories_arrow"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/white-arrow.jpg" /></div>
                    <div class="catagories_name"><a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/browse/">Browse all categories</a></div>
                </div>
                <?php if(!$objCore->sessCusId || ($objCore->sessCusId && $objCore->isAuthorized(1, 'classified_ads'))) {?>
                <div class="catagories">
                <div class="catagories_arrow"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/white-arrow.jpg" /></div>
                <div class="catagories_name"><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/classified_ads/index.php?f=add">Place a Classified Ad</a></div>     
                </div>
                <?php }?>
            </div>
        </div>
        <div id="tag_image_footer"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/catogory-footer.gif" /></div>
    </div>
</div
><?php
                } // end adding browese section
                ?>

<?php
if(!is_object($objSearch)) {
    $objSearch = new Search($objCore->gConf);
                    }
    $curPage=$objCore->curPage();
if ($output['dataCount'] || (!$objSearch->getTotalCount() && $output || ($curPage=='green_ideas.php'|| $curPage=='about_us.php'|| $curPage=='contact_us.php' ))) {
 ?>
<div id="space"></div>
<div><?php include($objCore->_SYS['PATH']['SEARCH_COM']);?></div>
<div id="space"></div>
<?php }
?>
<?php if($objCore->curSection() == 'browse'){ ?>
<div id="space"></div>
<div><?php include($objCore->_SYS['PATH']['SEARCH_COM']);?></div>
<div id="space"></div>
<?php } ?>