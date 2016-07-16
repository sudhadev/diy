<?php
	require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
	$objCategory = new Category;
	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
	$objComponent = new Component();	 
	require_once($objCore->_SYS['PATH']['CLASS_GEO']); //Making a referance to Geo Class 
  	$formName = "search"; // Registration Form Name
  	$mapsUrl = $objCore->_SYS['GEO']['URL']; // Google Maps URL  
  	$apiKey = $objCore->_SYS['GEO']['KEY']; // Google Maps API Key for the Server 
  	$objGeo = new Geo(); // Creating an Object from Geo Class 
  	$map = $objGeo->getCoordinates($formName, $submissionType, $ajaxFunction, $apiKey, $mapsUrl);
  	$radiusMax = $objCore->gConf['SEARCH_RADIOUS_MAX'];;
   $radiusDifference = $objCore->gConf['SEARCH_RADIOUS_DIFFERENCE'];
   $unit = $objCore->gConf['SEARCH_UNIT'];
?>

              <div id="middle_end_banner_header"></div>
              <div id="middle_end_banner_content" align="left">
              <form name="<?=$formName; ?>" id="<?=$formName; ?>" action="<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>/search/index.php" method="get">
			  <!-- search table -->
              <div>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <?php if ($objCore->curSection() == 'search') {?>
                        <td width="83%"  class="banner_heading_balck">New Search</td>
                        <td width="17%"><a href="javascript:animatedcollapse.toggle('new_search');"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" width="14" height="14" onClick="if(document.getElementById('new_search').style.display == 'none') document.getElementById('middle_end_banner_bottom').style.background = "background-image: url('../images/search_bottom.jpg') no-repeat"; else document.getElementById('middle_end_banner_bottom').style.background = 'background-image: url('../images/search_bottom_yellow.jpg') no-repeat';"/></a></td>
                        <?php } else {?>
                        <td width="83%"  class="banner_heading_balck">Search</td>
                        <?php }?>
                      </tr>
                    </table></div>
                    <?php if ($objCore->curSection() == 'search') {?>
              <div id="new_search" groupname="search" style="display:none">
                    <?php } else {?>
              <div id="new_search" groupname="search" style="display:block">
              <?php }?>
              <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="center"></td>
                  </tr>
                  <tr>
                    <td height="6"></td>
                  </tr>
                  <tr>
                    <td class="common_text_bold">1.	SELECT A CATEGORY TYPE
					
					</td>
                  </tr>
                  <tr>
                    <td height="2
                    "></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="84%"><label>
							 
                            <div align="left">
							  <?php
								$categories = $objCategory->getTopcList('drop', 'categories','new_search_textbox width_adjust_drop_down');
								echo $categories;
								?>
                            </div>
                        </label></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="6"></td>
                  </tr>
                  <tr>
                    <td class="common_text_bold">2.	ENTER KEYWORD(S)</td>
                  </tr>
                  <tr>
                    <td height="2"></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="84%"><div align="left">
                          <label>
                          <input name="keyword" type="text"  class="new_search_textbox width_adjust_text_box" id="keyword"/>
                          </label>
                        </div></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="6"></td>
                  </tr>
                  <tr>
                    <td class="common_text_bold">3.	ENTER A POSTCODE, <br />
                    STREET OR PLACE </td>
                  </tr>
                  <tr>
                    <td height="2
                    "></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="83%"><div align="left">
                          <label>
                          <input name="address" type="text" id="address" class="new_search_textbox width_adjust_text_box" />
                          </label>
                        </div></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="6"></td>
                  </tr>
                  <tr>
                    <td class="common_text_bold">4.	SELECT A SEARCH RADIOUS </td>
                  </tr>
                  <tr>
                    <td height="2
                    "></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="83%"><div align="left">
                          <label>
                                                                          <?php
                                                for($i=0;$i<=$radiusMax;$i=$i+$radiusDifference)
                                                {
                                                    if ($i==0)
                                                    {
                                                        $radiusArray[$i] = '--';
                                                    }
                                                    else
                                                    {
                                                        $radiusArray[$i] = $i." ".$unit;
                                                    }
                                                }
                                                echo $objComponent->drop('radius', '',$radiusArray, 'new_search_textbox width_adjust_radious', '');
                                                ?>
                          </label>
                        </div></td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td height="8"></td>
                  </tr>
                  <input type="hidden" id="confirmedLatitude" name="confirmedLatitude" value="">
                                <!-- Hidden field for Longitude -->
                                <input type="hidden" id="confirmedLongitude" name="confirmedLongitude" value="">
                                <input type="hidden" id="order_by" name="order_by" value="0">
                                <input type="hidden" id="refineId" name="refineId" value="0">
                  <tr>
                    <td><div align="left"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/go-button-small.jpg" width="170" height="48" border="0" onClick="initialize(); showAddress(document.<?=$formName; ?>.address.value); showMap(); return false;"/></div></td>
                  </tr>
                  <tr>
                    <td height="5"></td>
                  </tr>
                </table></div>
				<!-- / search table -->
				 <div id="map"> <?php echo $map; ?> </div>
				 </form>
                  </div> 
              <div id="middle_end_banner_bottom"></div>
