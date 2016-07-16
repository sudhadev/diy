<?php
    $arrRowStyle[0]="";
    $arrRowStyle[1]="ash_strip";
    $totalCount = $objOrder->getTotalCount();
	$pagination = $objCore->gConf['RECS_IN_LIST_FRONT'];
    $arrSubscriptions =$objCore->_SYS['CONF']['SUBCRIPTIONS'];

?>
 
<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">
                  <div id="banner">Purchase history</div>
                  <div class="list">
                    <div align="left">
                      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td class="list_blackbg_summery"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="47%"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  >
                                    <tr>
                                      <td width="10" height="30"></td>
                                      <td height="30" width="250"class="pbYellow">Showing <?php if ($_REQUEST['pg'] == 1) { echo $_REQUEST['pg']; } else { echo ((($_REQUEST['pg']-1)*$pagination) + 1);}?> to <?php if ($_REQUEST['pg']*$pagination>$totalCount) { echo $totalCount; } else { echo $_REQUEST['pg']*$pagination; }?> of <?php echo $totalCount; ?> Items</td>
                                      <td width="1" height="30"></td>
                                      <td width="234" height="30"  class="pgBar" ></td>
                                    </tr>
                                  </table></td>
                                <td width="50%" height="30"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                    <tr>
                                       <?php
                                            echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objOrder->pgBar."</div></td>";
                                       ?>
                                    </tr>
                                  </table></td>
                              </tr>
                            </table></td>
                        </tr>
                        <tr>
                          <td height="10"></td>
                        </tr>
                        <tr>
                          <td ><table width="652" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="6" height="36" class="grid_end" id="grid_left_end"></td>
                                <td   class="grid_middle chagrs_grid_heading" style="width:75px;">Invoice No</td>
                                <td width="1"  class="grid_break"></td>
                                <td  class="grid_middle chagrs_grid_heading"  >Description</td>
                                <td width="1" class="grid_break"></td>
                                <td  class="grid_middle  chagrs_grid_heading" style="width:80px;" >Amount (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)</td>
                                <td width="1"  class="grid_break"></td>
                                <td  class="grid_middle  chagrs_grid_heading" style="width:140px;">Date & Time</td>
                                <td width="6"  class="grid_end" id="grid_right_end"></td>
                              </tr>
                              <?php
                              for ($i = 0; $i < count($orderDetails); $i++)
                              {
                              ?>
                              <tr class="<?php echo $arrRowStyle[$i%2];?>">
                                <td width="6"></td>
                                <td class="chagrs_grid_text"><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_orders/index.php?f=view&invoice_no=<?php echo $orderDetails[$i][0];?>&pg=<?php echo $_REQUEST['pg']; ?>"><?php echo $orderDetails[$i][0];?></a></td>
                                <td></td>
                                <td class="chagrs_grid_text">
                                <?php 
                                    // show the initial title
                                     echo $orderDetails[$i][26];
                                      ?>
                                </td>
                                <td></td>
                                <td class="chagrs_grid_text" style="text-align:right;padding-right:5px;"><?php echo $orderDetails[$i][2];?></td>
                                <td></td>
                                <td class="chagrs_grid_text"><div align="center"><?php echo date($objCore->gConf['DATE_FORMAT']." ".$objCore->gConf['TIME_FORMAT'], $orderDetails[$i][1]);?></div></td>
                                <td width="6"></td>
                              </tr>
                              <?php
                              }
                              ?>
                            </table>
                        <tr>
                          <td height="10"></td>
                        </tr>
                        <tr>
                          <td class="list_blackbg_summery"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="47%"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  >
                                    <tr>
                                      <td width="10" height="30"></td>
                                      <td height="30" width="250"class="pbYellow">Showing <?php if ($_REQUEST['pg'] == 1) { echo $_REQUEST['pg']; } else { echo ((($_REQUEST['pg']-1)*$pagination) + 1);}?> to <?php if ($_REQUEST['pg']*$pagination>$totalCount) { echo $totalCount; } else { echo $_REQUEST['pg']*$pagination; }?> of <?php echo $totalCount; ?> Items</td>
                                      <td width="1" height="30"></td>
                                      <td width="234" height="30"  class="pgBar" ></td>
                                    </tr>
                                  </table></td>
                                <td width="50%" height="30"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                    <tr>
                                       <?php
                                            echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objOrder->pgBar."</div></td>";
                                       ?>
                                    </tr>
                                  </table></td>
                              </tr>
                            </table></td>
                        </tr>
                        </td>

                        </tr>

                      </table>
                      <br />
                      <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/back-black.jpg" border="" ></a>
                    </div>
                  </div>
      </div>
      <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
    </div>
  </div>
</div>
