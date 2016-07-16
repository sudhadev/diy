<?php //$objSearch->dev=true;
            
	$totalCount = $objSearch->getTotalCount();
       
?>

<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar">
                <div id="text_area">
                    <div class="common_text"> 
                     <?php  //print_r($output); ?>
            <?php if ($totalCount) {echo $totalCount;} else {echo 0;} ?>  results found for <strong>‘<?php echo $_GET['keyword']; ?>’ in <?php if ($_REQUEST['categories'] == 1){echo "Building Supplies";}elseif ($_REQUEST['categories'] == 2){echo "Building Services";}elseif ($_REQUEST['categories'] == 3){echo "Classified Ads";} ?></strong><br />
                        <?php if ($_REQUEST['keyword'] != $output['correctWord'])
                        {
                             for($i=0;$i<count($output['dataCount']);$i++)
                             {
                                 $dataCount[] = $output['dataCount'][$i]['COUNT(*)'];
                             }
                             if ($dataCount) $dataCount = array_sum($dataCount);
                             $parameter = str_replace(" ", "+", $_REQUEST['keyword']);
                             if ($dataCount)
                             {
                            ?> 
                    <span class="common_text_ash">Did you mean ‘<a href="index.php?<?php echo str_replace("&keyword=".$parameter, "&keyword=".$output['correctWord'], $_SERVER['QUERY_STRING']); ?>""><?php echo $output['correctWord']; ?></a>’ (<?php echo $dataCount; ?> items) </span> </div>
                    <div class="no_data" style="width:600px">No Results Found.</div>
                    <?php
                             }
                             else
                             {
                    ?>
                    </div>
                    <?php
                             }
                    if ($totalCount && ($_REQUEST['categories']==2 || $_REQUEST['categories']==3)) include($objCore->_SYS['PATH']['COM_GROUP_BY']); ?>
                    <?php
                }
                elseif ($dataCount || !$totalCount)
                {
                
                ?>
                    <div class="no_data" style="width:600px">No Results Found.</div>
                <?php
                }
                else
                {
                    ?>
                <?php if ($totalCount && ($_REQUEST['categories']==2 || $_REQUEST['categories']==3)) include($objCore->_SYS['PATH']['COM_GROUP_BY']); ?>
                <span class="common_text_ash"></span></div>
                <?php
            } 
            if ($totalCount)
            {
            ?> 
            </div>
            <div class="page_braek"></div>
				<?php
				switch ($_REQUEST['categories'])
				{
       		case 1:
					{
						include($objCore->_SYS['PATH']['MATERIAL_LIST']);
					}break;
                    case 2:
					{
						include($objCore->_SYS['PATH']['SERVICE_LIST']);
					}break;
					case 3:
					{
						include($objCore->_SYS['PATH']['CLASSIFIED_LIST']);
					}break;
				}
				}
				?>
				                </div>
            </div>
				<div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
        </div>
    </div>
</div>