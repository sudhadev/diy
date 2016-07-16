<?php 

	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
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
            $url = "f=result&tcid=".$_REQUEST['tcid']."&pcid=".$_REQUEST['pcid']."&categories=2&categoryId=".$_REQUEST['categoryId']."&resultsPerPage=".$_REQUEST['resultsPerPage'];
        }
        if ($_REQUEST['categoryId'] == 0)
        {   
            //echo 'search test << 1';
            $serviceList = $output['searchData'];
        }
        else
        {   //  joint with new services search list function 
           // echo 'search test';
            $serviceList = $objSearch->getServiceList_new($_REQUEST['keyword'], $_REQUEST['latitude'], $_REQUEST['longitude'], $_REQUEST['radius'], $_REQUEST['pg'], $_REQUEST['categoryId'], $url, $_REQUEST['resultsPerPage'], $_REQUEST['order_by']);
        }
        if (!$totalCount) $totalCount = $objSearch->getTotalCount();
        $arrClassifiedRowStyle[0]="cadds_search_descriptionrow";
        $arrClassifiedRowStyle[1]="cadds_search_descriptionrow cadd_descriptionrow_gray";
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
        if ($serviceList)
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
        <td height="30" width="250" class="catagories_item_yellow">Showing <?php if ($_REQUEST['pg'] == 1) { echo $_REQUEST['pg']; } else { echo ((($_REQUEST['pg']-1)*$pagination) + 1);}?> to <?php if ($pagination>$totalCount) { echo $totalCount; } else { echo $_REQUEST['pg']*$pagination; }?> of <?php echo $totalCount; ?> Items</td>
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
              </tr>
              <tr>
                <td class="search_partison">
                <div id="clear_selections"><img onclick="javascript:clearItems('S','<?php echo count($serviceList);?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/clear_selections_button.jpg" width="108" height="20" border="0"/></div>
                <div id="add_selections">
                    <?php         
                        if($objCore->sessCusId == "")
                        {
                            $onclck = "search_result_services.submit();";
                        }else
                        {
                            $onclck = "add('".count($serviceList)."');";
                        }

                        ?>
                         <img onclick="<?php echo $onclck;?>" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/wishlist.png" width="170" height="20" border="0" id="not-hover-BT" />
                        <img onclick="<?php echo $onclck;?>" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/wishlist_s.png" width="170" height="20" border="0"  id="hover-BT" style="display: none;" />
										
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

                    <form id="search_result_services" name="search_result_services" method="get" action="" >
                <?php
                    for ($i=0; $i<count($serviceList); $i++)
                    { $image = $objCategory->image($serviceList[$i][11],$objCore->_SYS['CONF']['FTP_SERVICES'],$objCore->_SYS['CONF']['URL_IMAGES_SERVICES']);
                ?>
                    <div class="<?php echo $arrClassifiedRowStyle[$i%2];?>">
                        <div id="searched_image" style="min-height: 210px;">
                             <?php echo '<a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=2&cid='.$serviceList[$i][6].'&lid='.$serviceList[$i][20].'&dis='.round($serviceList[$i][7], 2).'&unit=miles">'; ?>
                                <img  width="100" src="<?php echo $image; ?>"/>
                             <?php echo '</a>'; ?>
                            <div id="enlarge_image" class="common_text_ash" style="margin-left:25px;">
                               <?php 
                                    /*    echo '<a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=2&cid='.$serviceList[$i][6].'&lid='.$serviceList[$i][20].'&dis='.round($serviceList[$i][7], 2).'&unit=miles">';
                                            $image_array = array($serviceList[$i][11],$serviceList[$i][22],$serviceList[$i][23],$serviceList[$i][24]);
                                            echo "Photos (".  count(array_filter($image_array)).")";
                                        echo '</a>';
                                       */
                               ?>
    
       
                            </div>
                        </div>
                        <div class="classified_description_wraper">
                            <div class="select_wishlist">
                                <div class="where_text common_text_ash"> Where are they</div>
				<div class="select_wishlist_button">
                                    <img height="15" width="15" alt="where are they?" class="cursorHand" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/where_icon.jpg" onClick="JavaScript:PopupWhereAreThey('<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>/search/where_are_they.php?cid=<?php echo $serviceList[0][6]; ?>');"/>
                                </div>
                            </div>
                            <div class="description_text_big">
                                <?php
                                    echo '<a class="heading_link" href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=2&cid='.$serviceList[$i][6].'&lid='.$serviceList[$i][20].'&dis='.round($serviceList[$i][7], 2).'&unit=miles" style="font-family: Arial,Helvetica,sans-serif;color: #333333; font-size: 16px; font-weight: bold;">';
                                ?>
                                <?php echo ucwords($serviceList[$i][15]); ?>
                                <br/>
                                <?php echo $serviceList[$i][21]; ?>
                                <br/>
                                <?php echo '</a>'; ?>
                            </div>
                            <div class="classified_description_wraper">
                                <div class="classified_desc_subdiv">
                                    <div class="classified_desc_subdiv">
                                        <div class="classified_desc_subsec common_text" style="padding-left: 0px;">
                                            <?php echo $serviceList[$i][12].", ".$serviceList[$i][13]; ?>
                                        </div>
                                    </div>
                                    <div class="classified_desc_subdiv">
					<div class="description_text_big">
                                            <?php  echo '<a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=2&cid='.$serviceList[$i][6].'&lid='.$serviceList[$i][20].'&dis='.round($serviceList[$i][7], 2).'&unit=miles" style="font-family: Arial,Helvetica,sans-serif;color: #333333; font-size: 16px; font-weight: bold;">Services Offered:</a>'; 
                                            ?>
                                            <br/>
                                        </div>
                                        <div class="classified_desc_subsec common_text" style="padding-left: 0px;">
                                        <?php 
                                            if(strlen($serviceList[$i][9])>80){
                                                
                                                 echo substr(nl2br(htmlentities($serviceList[$i][9], 0, 130)) ,0,200).'<span>...</span><a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=2&cid='.$serviceList[$i][6].'&lid='.$serviceList[$i][20].'&dis='.round($serviceList[$i][7], 2).'&unit=miles" style="text-decoration:underline;font-weight:bold;"> more</a>';
                                            }else{
                                                 echo nl2br($serviceList[$i][9]).'<span>...</span><a href="'.$objCore->_SYS['CONF']['URL_FRONT'].'browse/?f=more&catid=2&cid='.$serviceList[$i][6].'&lid='.$serviceList[$i][20].'&dis='.round($serviceList[$i][7], 2).'&unit=miles" style="text-decoration:underline;font-weight:bold;"> more</a>';
                                            }
                                         ?>
                                       </div>
                                        <br/><br/>
					<div class="classified_desc_subsec common_text" style="margin-left: -4px;">
                                            <div class="classified_desc_subsec_sub">
                                                        <?php if($serviceList[$i][2]!=''){ ?>
                                                            <div class="classified_desc_subsec common_text">
                                                                Tel:&nbsp;<?php echo $serviceList[$i][2]; ?>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if($serviceList[$i][26]!=''){ ?>
                                                            <div class="classified_desc_subsec common_text">
                                                                Mob:&nbsp;<?php echo $serviceList[$i][26]; ?>
                                                            </div>
                                                        <?php } ?>
                                            </div>
                                            <div class="classified_desc_subsec common_text">
                                                Email:&nbsp;<a href="mailto:<?php echo $serviceList[$i][3]; ?>">
                                                    <?php echo $serviceList[$i][3]; ?>
                                                </a>
                                            </div>
					   
                                        </div>
				   </div>
                                   
                                    <div class="classified_desc_subsec common_text" style="margin-left: -4px;">
                                        <?php if($list[$i][25]!=""){?>
                                           <a href="<?php echo "http://".str_replace("http://", '', $list[$i][25]);?>">
                                               <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/visit-website.png"/>
                                           </a>
                                        <?php } ?> 
                                    </div>
                                        
                                    
                              </div>
                                <div class="rate_distance_maindiv">
                                    <div class="hourly_rate_main">
                                            <div class="hourly_rate hourly_rate_font">
                                                Call out charge: 
                                            </div>
                                            <div align="right" class="hourly_rate_amount hourly_rate_font">
                                                    <?php if($serviceList[$i][10]==0)echo "No"; else echo "(£) ".$serviceList[$i][10]; ?>
                                            </div>
                                    </div>
                                    <div class="distance_main">
                                            <div class="hourly_rate distance_font">
                                                Distance (<?php echo $unit; ?>) 
                                            </div>
                                            <div align="right" class="hourly_rate_amount distance_font">
                                                <?php //echo round($serviceList[$i][7], 2); 
                                                //change by maduranga
                                                    if($serviceList[$i][7]=='--'){ 
                                                        echo " - "; 
                                                    }else{ 
                                                        echo round($serviceList[$i][7], 2);
                                                    }
                                                ?>
                                            </div>
                                    </div>

                                </div>
                                <div>
                                    <a onclick="selectcheck('checkVal[<?php echo $i;?>]','<?php echo count($serviceList); ?>');" >
                                        <img class="img_button_add_to_wish_list" 
                                          src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/add-to-wish-list.png" 
                                          style="margin-left: 14px; margin-top: 10px; width: 136px; height: 23px;"/>
                                    </a>
                                     
                                     <input type="checkbox" class="wishlist_checkbox_ie" name="checkVal[<?php echo $i;?>]" id="checkVal[<?php echo $i;?>]" value="<?php echo $serviceList[$i][20];?>" 
                                            onclick="javascript:selectItems('<?php echo $serviceList[$i][2010];?>','<?php echo count($serviceList); ?>');" style="    margin-top: -2px;
                                            vertical-align: text-top;"/>

                                </div>
                        </div>

                    </div>
		</div>
                        
           <?php }/* End forloop*/ ?>
<input type="hidden" id="action" name="action" value="add"/>
                                <input type="hidden"  id="subscription" name="subscription" value="S"/>

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
                <div id="clear_selections"><img onclick="javascript:clearItems('S','<?php echo count($serviceList);?>');" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/clear_selections_button.jpg" width="108" height="20" border="0"/></div>
                <div id="add_selections">
                    <?php         
                        if($objCore->sessCusId == "")
                        {
                            $onclck = "search_result_services.submit();";
                        }else
                        {
                            $onclck = "add('".count($serviceList)."');";
                        }

                        ?>
                          <img onclick="<?php echo $onclck;?>" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/wishlist.png" width="170" height="20" border="0" id="not-hover-BT-2" />
                        <img onclick="<?php echo $onclck;?>" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/search_page/wishlist_s.png" width="170" height="20" border="0"  id="hover-BT-2" style="display: none;" />  
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
        <td height="30" width="250" class="catagories_item_yellow">Showing <?php if ($_REQUEST['pg'] == 1) { echo $_REQUEST['pg']; } else { echo ((($_REQUEST['pg']-1)*$pagination) + 1);}?> to <?php if ($pagination>$totalCount) { echo $totalCount; } else { echo $_REQUEST['pg']*$pagination; }?> of <?php echo $totalCount; ?> Items</td>
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
            <div class="no_data" style="width:642px;">No Listings Found.</div>
            <script language="javascript">
                document.getElementById("sortby_div").innerHTML='';
            </script>
<?php
}
?>        