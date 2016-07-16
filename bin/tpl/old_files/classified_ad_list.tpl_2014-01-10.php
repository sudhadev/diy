<?php
    $arrClassifiedRowStyle[0]="cadds_search_descriptionrow";
    $arrClassifiedRowStyle[1]="cadds_search_descriptionrow cadd_descriptionrow_gray";
    require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
    require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
        if (!is_object($objCategory))
        {
            $objCategory = new Category();
        }
        $objComponent = new Component();
        require_once($objCore->_SYS['PATH']['CLASS_SEARCH']);
		if (!is_object($objSearch))
        {
            $objSearch = new Search($objCore->gConf);
        }
        $objSearch->pgBarStrPrevious='<span id="pgBarImgPre">Previous </span>';
        $objSearch->pgBarStrNext='<span id="pgBarImgNext">Next </span>';
        if ($objCore->curSection() == 'search')
        {
            $url = "categories=".$_REQUEST['categories']."&keyword=".$_REQUEST['keyword']."&radius=".$_REQUEST['radius']."&categoryId=".$_REQUEST['categoryId']."&latitude=".$_REQUEST['latitude']."&longitude=".$_REQUEST['longitude'];
        }
        elseif ($objCore->curSection() == 'browse')
        {
            $topList=$objCategory->getTopcList();
            $list=$objCategory->getSubcList($topList[$_REQUEST['tcid']]['id'],'sub_arr');
            for ($m=0; $m<count($list); $m++)
            {
                if ($list[$m][0]==$_REQUEST['pcid']) $temp = $m;
            }
            $listSub=$objCategory->getSubcList($list[$temp][0],'sub_arr');
            for ($n=0; $n<count($listSub); $n++)
            {
                if ($listSub[$n][0]==$_REQUEST['categoryId']) $tempSub = $n;
            }
            $url = "f=result&tcid=".$_REQUEST['tcid']."&pcid=".$_REQUEST['pcid']."&categories=3&categoryId=".$_REQUEST['categoryId']."&resultsPerPage=".$_REQUEST['resultsPerPage'];
        }
        if ($_REQUEST['categoryId'] == 0)
        {
           $Classifiedlist  = $output['searchData'];
        }
        else
        {
            $Classifiedlist = $objSearch->getClassifiedList($_REQUEST['keyword'], $_REQUEST['latitude'], $_REQUEST['longitude'], $_REQUEST['radius'], $_REQUEST['pg'], $_REQUEST['categoryId'], $url, $_REQUEST['resultsPerPage'], $_REQUEST['order_by']);
        }
        if (!$totalCount) $totalCount = $objSearch->getTotalCount();
        $unit = $objCore->gConf['SEARCH_UNIT'];
        $radiusDifference = $objCore->gConf['SEARCH_RADIOUS_DIFFERENCE'];
        $pagination = $objCore->gConf['SEARCH_RECS_IN_LIST'];
        if ($_REQUEST['resultsPerPage'] != 0 && $_REQUEST['resultsPerPage'] != $pagination) $pagination = $_REQUEST['resultsPerPage'];
        if ($objCore->curSection() == 'browse')
        {
        ?>
        <div class="breadcrumb"><?php echo $topList[$_REQUEST['tcid']]['category']?> > <?php echo $list[$temp][3]; if ($listSub[$tempSub][3]) {?> > <?php echo $listSub[$tempSub][3]; }?></div>
        <?php
        }
        if ($Classifiedlist)
        {
?>
        <div class="classified_search_list">
          <div align="left">
            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td class="list_blackbg_summery">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="47%"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  >
      <tr>
        <td width="10" height="30"></td>
        <td height="30" width="250"class="catagories_item_yellow">Showing <?php if ($_REQUEST['pg'] == 1) { echo $_REQUEST['pg']; } else { echo ((($_REQUEST['pg']-1)*$pagination) + 1);}?> to <?php if ($pagination>$totalCount) { echo $totalCount; } else { echo $_REQUEST['pg']*$pagination; }?> of <?php echo $totalCount; ?> Items</td>
        <td width="1" height="30"></td>
        <?php include("search_drop.php"); ?>
      </tr>
    </table></td>
    <td width="40%" height="30">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
     <?php
        echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objSearch->pgBar."</div></td>";
     ?>
  </tr>
</table>    </td>
  </tr>
</table>                </td>
              </tr>
              
              <tr>
                <td height="10"></td>
              </tr> <tr>
                <td class="search_partison">
                <div id="clear_selections"><img onclick="javascript:clearItems('C','<?php echo count($Classifiedlist);?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/clear_selections_button.jpg" width="108" height="20" border="0"/></div>
                <div id="add_selections">
                    <?php
                        if($objCore->sessCusId == "")
                        {
                            $onclck = "search_result_classified.submit();";
                        }else
                        {
                            $onclck = "add('".count($Classifiedlist)."');";
                        }

                        ?>

                        <img onclick="<?php echo $onclck;?>" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/wish_list_button.jpg" width="170" height="20" border="0" />
                    <!--<img onclick="search_result_classified.submit();" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/wish_list_button.jpg" width="170" height="20" border="0" />-->
                            
                </div>       
               </td>
                                       
              </tr>
              <tr>
			  	<td>
                                    <div id="message_holder">
                                        <div id="error_msg" style="width:605px; margin-left:0px">
                                            <?php
                                                if($msg)
                                                {
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
                            
                                    <form id="search_result_classified" name="search_result_classified" method="get" action="" >
                <?php
                    for ($i=0; $i<count($Classifiedlist); $i++)
                    {
                        $image = $objCategory->image($Classifiedlist[$i][11],$objCore->_SYS['CONF']['FTP_CLAS_ADS'],$objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS']);
                ?>

                <div class="<?php echo $arrClassifiedRowStyle[$i%2];?>">
                    <div id="searched_image" style="min-height: 210px;">
                        <a href="<?php echo $objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=3&cid='.$Classifiedlist[$i][6].'&lid='.$Classifiedlist[$i][14]; ?>">
                            <img src="<?php echo $image; ?>" width="100" border="0">
                            </a>
<div id="enlarge_image" class="common_text_ash" style="margin-left:25px;">
<!--<img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search-icon.jpg" width="14" height="15" /> <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $Classifiedlist[$i][11]; ?>','clas_ads');">Enlarge Image</a></div>-->
<a href="<?php echo $objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=3&cid='.$Classifiedlist[$i][6].'&lid='.$Classifiedlist[$i][14]; ?>">        
<?php
        $image_array = array($Classifiedlist[$i][11],$Classifiedlist[$i][17],$Classifiedlist[$i][18],$Classifiedlist[$i][19]);
        
        echo "Photos (".  count(array_filter($image_array)).")";
        
        ?>
    </a>
        </div>
        
        </div>
        
              <div class="description_text_big" >
        <a href="<?php echo $objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=3&cid='.$Classifiedlist[$i][6].'&lid='.$Classifiedlist[$i][14]; ?>" style="font-family: Arial,Helvetica,sans-serif;color: #333333;
    font-size: 16px;
    font-weight: bold;"><?php echo $Classifiedlist[$i][15]; ?>
         <br/>
        <?php echo ucwords($Classifiedlist[$i][8]); ?>
              </a>
              </div>
			<div class="classified_description_wraper">
			<div class="classified_desc_subdiv" style="width: 300px;">
                            <p class="common_text">
                                <?php 
                                                    if(strlen($Classifiedlist[$i][9])>130){
                                                        echo substr($Classifiedlist[$i][9], 0, 130).'<span>...</span><a <a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=3&cid='.$Classifiedlist[$i][6].'&lid='.$Classifiedlist[$i][14].'" style="text-decoration:underline;font-weight:bold;"> more</a>';
                                                    }
                                                    else{
                                                        echo $Classifiedlist[$i][9].'<span>...</span><a <a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=3&cid='.$Classifiedlist[$i][6].'&lid='.$Classifiedlist[$i][14].'" style="text-decoration:underline;font-weight:bold;"> more</a>';
                                                       
                                                    }
                                                    
                                                    ?>
                                </p>
                                <br/>
                                
                                                    <div class="description_text_big">Contact Seller<br/></div>
                                                    <table class="common_text" style="margin-left:-3px;">
                                                        <tr>
                                                            <td>Seller</td>
                                                            <td>:</td>
                                                            <td><?php echo $Classifiedlist[$i][16];?></td>
                                                            </tr>
                                                            <tr>
                                                            <td>Tel</td>
                                                            <td>:</td>
                                                            <td><?php echo $Classifiedlist[$i][2];?></td>
                                                            </tr>
                                                            <tr>
                                                            <td>Email</td>
                                                            <td>:</td>
                                                            <td><a href="mailto:<?php echo $Classifiedlist[$i][3];?>"><?php echo $Classifiedlist[$i][3];?></a></td>
                                                            </tr>
                                                        </table>
                                                   
<!--				<div class="classified_desc_subdiv">
					<div class="description_subdiv common_text_ash_bold">Area:</div>
					<div class="classified_desc_subsec common_text"><?php echo $Classifiedlist[$i][12].", ".$Classifiedlist[$i][13]; ?></div>
				</div>
				<div class="classified_desc_subdiv">
					<div class="description_subdiv common_text_ash_bold">Contact:</div>
					<div class="classified_desc_subsec common_text">
						<div class="classified_desc_subsec_sub"><a href="JavaScript:Popup('<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>/search/info.php?cid=<?php echo $Classifiedlist[$i][6]; ?>');"><?php echo $Classifiedlist[$i][0]." ".$Classifiedlist[$i][1]; ?></a><br /><?php echo $Classifiedlist[$i][2]; ?></div>
						<div class="classified_desc_subsec_sub">
							<div class="description_subdesc_mailicon"></div>
							<div class="description_subdesc_mailad"><a href="mailto:<?php echo $Classifiedlist[$i][3]; ?>"><?php echo $Classifiedlist[$i][3]; ?></a></div>
						</div>
					</div>
				</div>-->
                              
			</div>
                
                            <div class="classified_description_wraper" style="display:inline;float: none;">
<!--			<div class="select_wishlist">
			  <div class="select_wishlist_text common_text_ash">Select for wish list</div>
				<div class="select_wishlist_button">
				 <input type="checkbox" name="checkVal[<?php echo $i;?>]" id="checkVal[<?php echo $i;?>]" class="select_wishlist_button"  value="<?php echo $Classifiedlist[$i][14];?>"/>
				</div>
			</div>-->
                            
			<div class="rate_distance_maindiv" style="width: auto; max-width: 220px;">
			<div class="hourly_rate_main">
				<div class="hourly_rate hourly_rate_font" style="width: 82px;">Price: </div>
				<div class="hourly_rate_amount hourly_rate_font" style="">£ <?php echo $Classifiedlist[$i][10]; ?></div>
			</div>
			<div class="distance_main">
				<div class="hourly_rate distance_font" style="width:82px;">Distance:</div>
				<div class="hourly_rate_amount distance_font" style="width: auto;max-width: 220px;"><?php if($objCore->sessCusId=="") echo " - "; else echo round($Classifiedlist[$i][7], 2).' '.$unit; ?></div>
                               <?php  //print_r($Classifiedlist[$i]); ?>
			</div>
            </div>  
                        <?php //echo $_REQUEST['latitude'], $_REQUEST['longitude']; ?><br/><br/>
                        <?php //echo $Classifiedlist[$i][20], $Classifiedlist[$i][21]; ?>
                        <div>
                        <img onclick="selectcheck('checkVal[<?php echo $i;?>]');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/add-to-wish-list.png" style="margin-left: 14px; margin-top: 10px;"/>
            <input type="checkbox" name="checkVal[<?php echo $i;?>]" id="checkVal[<?php echo $i;?>]" value="<?php echo $Classifiedlist[$i][14];?>" onclick="javascript:selectItems('<?php echo $Classifiedlist[$i][14];?>');" style="    margin-top: -2px;
    vertical-align: text-top;"/>
                                 
            </div>
		</div>
<!--        <div class="classified_description_sub_wraper">
        <div class="description_subdiv common_text_ash_bold">
        Notes:        </div>
        <div class="classified_description_subdesc common_text"><?php echo $Classifiedlist[$i][9]; ?></div>
        </div>-->
 </div>
</div>
    <?php } ?>

  <input type="hidden" id="action" name="action" value="add"/>
                                <input type="hidden"  id="subscription" name="subscription" value="C"/>

                              <?php
                                if ($objCore->curSection() == 'search')
                                {
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
                                        <input type="hidden" id="longitude" name="longitude" value="<?php echo $strSearch[9];?>">
                                        <input type="hidden" id="pg" name="pg" value="<?php echo $strSearch[10];?>">
                                        <?php }
                                        elseif ($objCore->curSection() == 'browse')
                                        {
                                        ?>
                                        <input type="hidden" id="f" name="f" value="<?php echo $strBrowse[0];?>">
                                        <input type="hidden" id="tcid" name="tcid" value="<?php echo $strBrowse[1];?>">
                                        <input type="hidden" id="pcid" name="pcid" value="<?php echo $strBrowse[8];?>">
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
                <td class="search_partison">
                <div id="clear_selections"><img onclick="javascript:clearItems('C','<?php echo count($Classifiedlist);?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/clear_selections_button.jpg" width="108" height="20" border="0"/></div>
                <div id="add_selections">
                    <?php
                        if($objCore->sessCusId == "")
                        {
                            $onclck = "search_result_classified.submit();";
                        }else
                        {
                            $onclck = "add('".count($Classifiedlist)."');";
                        }

                        ?>

                        <img onclick="<?php echo $onclck;?>" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/wish_list_button.jpg" width="170" height="20" border="0" />
                    <!--<img onclick="search_result_classified.submit();" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/wish_list_button.jpg" width="170" height="20" border="0" />-->
                            
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
                <td class="list_blackbg_summery">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="47%"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  >
      <tr>
        <td width="10" height="30"></td>
        <td height="30" width="250"class="catagories_item_yellow">Showing <?php if ($_REQUEST['pg'] == 1) { echo $_REQUEST['pg']; } else { echo ((($_REQUEST['pg']-1)*$pagination) + 1);}?> to <?php if ($pagination>$totalCount) { echo $totalCount; } else { echo $_REQUEST['pg']*$pagination; }?> of <?php echo $totalCount; ?> Items</td>
        <td width="1" height="30"></td>
        <?php include("search_drop.php"); ?>
      </tr>
    </table></td>
    <td width="45%" height="30">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
     <?php
        echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objSearch->pgBar."</div></td>";
     ?>
  </tr>
</table>

    </td>
  </tr>
</table>

                </td>
              </tr>

              <tr>
                <td height="10"></td>
              </tr>
              <tr></tr>
               </table>
               
          </div>
        </div>
<?php
}
else
{
?>      
			<div class="no_data" style="width:642px">No Listings Found.</div>
                        
            <script language="javascript">
                document.getElementById("sortby_div").innerHTML='';
            </script>
<?php
}

if($objCore->sessCusId == ""){
    ?>
    <script language="javascript">
                //document.getElementById("sortby_div").innerHTML='';
                var values = document.getElementById("sortby_div").innerHTML;
                values = values.replace('<option value="1">Nearest</option>', '');
                document.getElementById("sortby_div").innerHTML = values;
            </script>
            <?php
}
?> 