<?php

    $arrRowStyle[0]="";
    $arrRowStyle[1]="ash_strip";
   // $totalCount = $objOrder->getTotalCount();
    $pagination = $objCore->gConf['RECS_IN_LIST_FRONT'];
    $paymentDetails = $objPayment->diyRecurringProfileListByCustomerFutureShedules($objCore->sessCusId,$_REQUEST['pg']);
    $totalCount = $objPayment->getTotalCount();
   
?>
 
<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">
                  <div id="banner">Scheduled Payments</div>
                  <div class="list">
                    <div align="left">
                      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td class="list_blackbg_summery"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="47%"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  >
                                    <tr>
                                      <td width="10" height="30"></td>
                                      <td height="30" width="250"class="pbYellow">Showing <?php if ($_REQUEST['pg'] == 1) { echo $_REQUEST['pg']; } else { echo ((($_REQUEST['pg']-1)*$pagination) + 1);}?> to <?php if ($pagination>$totalCount) { echo $totalCount; } else { echo $_REQUEST['pg']*$pagination; }?> of <?php echo $totalCount; ?> Items</td>
                                      <td width="1" height="30"></td>
                                      <td width="234" height="30"  class="pgBar" ></td>
                                    </tr>
                                  </table></td>
                                <td width="50%" height="30"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
                                    <tr>
                                       <?php
                                            echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objPayment->pgBar."</div></td>";
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
                                <td width="" height="36" class=" grid_middle chagrs_grid_heading">Order Title</td>
                                <td width="1" height="36" class="grid_break"></td>
                                <td width="100" height="36" class=" grid_middle  chagrs_grid_heading" style="padding-right:3px;text-align:right">Total Amount (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)</td>
                                <td width="1" height="36" class="grid_break"></td>
                                <td width="100" height="36" class=" grid_middle  chagrs_grid_heading" style="text-align:center">Next Payment</td>
                                <td width="6" height="36" class="grid_end" id="grid_right_end"></td>
                              </tr>
                              <?php
                              $secureURL=str_replace("http://", "https://",$objCore->_SYS['CONF']['URL_MY_ACCOUNT']).'/my_schedules/';
                              for ($i = 0; $i < count($paymentDetails); $i++)
                              {
                              ?>
                              <tr class="<?php echo $arrRowStyle[$i%2];?>">
                                <td width="6"></td>
                                <td class="chagrs_grid_text"><a href="<?php echo $secureURL;?>/?f=view&cid=<?php echo $paymentDetails[$i][3];?>&pfid=<?php echo $paymentDetails[$i][4];?>&pg=<?php echo $_REQUEST['pg']; ?>"><?php echo $paymentDetails[$i][13];?></a></td>
                                <td></td>
                                <td class="chagrs_grid_text"  style="padding-right:3px;text-align:right"><?php echo number_format(($paymentDetails[$i][6] + $paymentDetails[$i][7]),2);?></td>
                                <td></td>
                                <td width="" class="chagrs_grid_text"><div align="center"><?php echo date($objCore->gConf['DATE_FORMAT'], $paymentDetails[$i][9]);?></div></td>
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
                                      <td height="30" width="250"class="pbYellow">Showing <?php if ($_REQUEST['pg'] == 1) { echo $_REQUEST['pg']; } else { echo ((($_REQUEST['pg']-1)*$pagination) + 1);}?> to <?php if ($pagination>$totalCount) { echo $totalCount; } else { echo $_REQUEST['pg']*$pagination; }?> of <?php echo $totalCount; ?> Items</td>
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
