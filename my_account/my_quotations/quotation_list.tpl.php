<?     
       // Page bar sectio added by saliya
       $objQuotation->pgBarStrPrevious='<span id="pgBarImgPre">Previous </span>';
       $objQuotation->pgBarStrNext='<span id="pgBarImgNext">Next </span>';


       $list = $objQuotation->getQuotationList($_GET['pg']);?>
<div id="right_bar_middle">
            <div id="main_form_bg">
              <div id="main_form_bg_middle">
                <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg"/></div>
                <div id="main_form_bg_middlebar">
                  <!---------------------------------------------------------------------------------------------------->
                  <div id="banner_add_cads">MANAGE MY QUOTATIONS</div>
                  <div id="text_area_add_cads">
                    <div class="common_text"><?php echo $pageContents['common_text'];?></div>
                  </div>
                  <div id="list_add_cads">
                    <div align="left">
                      <table border="0" align="center" width="100%" cellspacing="0" cellpadding="0">
                        <tbody>
                          <tr>
                            <td class="list_blackbg_summery"><table border="0" width="100%" cellspacing="0" cellpadding="0">
                                <tbody><tr>
                                  <td width="47%"><table border="0" align="left" width="100%" cellspacing="0" cellpadding="0">
                                      <tbody><tr>
                                        <td width="13" height="30"/>
                                        <td width="71" height="30" class="pgBar">You have </td>
                                        <td width="239" height="30" class="pbYellow"><? echo $objQuotation->getQuotationCount();?>&nbsp;Quotation(s)</td>
                                      </tr>
                                    </tbody></table></td>
                                    <?php
     echo "<td class=\"catagories_item_white\"><div align=\"right\">".$objQuotation->pgBar."</div></td>";
                    ?>
                                </tr>
                              </tbody></table></td>
                          </tr>
                          <?php if(count($list)){?>
                          <tr>
                            <td height="16"/>
                          </tr>
                          <tr><td>
                              <div id="messageBox" name="messageBox">
                                <?php

                                    if($msg)
                                    {
                                        echo $objCore->msgBox("QUOTATIONS",$msg,'99%');

                                    } 
                               ?>
                              </div>
                          
                          </td></tr>
                          <tr>
                            <td><div class="add_classified_formmain">
                                
                                
                                
                                  <table border="0" width="652" cellspacing="0" cellpadding="0">
                                    <tbody><tr>
                                      <td> </td>
                                    </tr>
                                    <tr>
                                      <td>
                                      <table border="0" width="652" cellspacing="0" cellpadding="0">
                                          <tbody><tr>
                                            <td width="6" id="grid_left_end"/>
                                            <td class="grid_middle chagrs_grid_heading">Quotation</td>
                                            <td width="1" class="grid_break"/>
                                            <td class="grid_middle chagrs_grid_heading">Title</td>
                                            <td width="1" class="grid_break"/>
                                            <td class="grid_middle chagrs_grid_heading">Amount</td>
                                            <td width="1" class="grid_break"/>
                                            <td class="grid_middle chagrs_grid_heading">Date</td>
                                            <td width="1" class="grid_break"/>
                                            <td class="grid_middle chagrs_grid_heading"/>
                             				<td width="6" id="grid_right_end"/>
                                          </tr>
                                          <? for ($n=0; count($list)>$n; $n++ ){ ?>
                                          <tr style="vertical-align: top;" class="<? echo ($n%2)? 'cadd_descriptionrow_gray': '';?>">
                                            <td width="6"/>
                                            <td class="chagrs_grid_text"><strong><a href="javascript: print_pg('print_quotation.php?id=<?php echo $list[$n][0];?>');"><?=$list[$n][2];?></a></strong></td>
                                            <td width="1"/>
                                            <td class="chagrs_grid_text"><?=$list[$n][3];?></td>
                                            <td width="1"/>
                                            <td class="chagrs_grid_text numeric_texts"><strong><?php echo $list[$n][5];?></strong></td>
                                            <td width="1"/>
                                            <td class="chagrs_grid_text"><?php echo date($objCore->gConf['DATE_FORMAT'],$list[$n][6]);?><br/><?php echo date($objCore->gConf['TIME_FORMAT'],$list[$n][6]);?>
											</td>
                                            <td width="1"/>
                                           	<td class="chagrs_grid_text"><div class="edit_colmn_div"><a href="<?=$objCore->_SYS['CONF']['URL_FRONT'].'/my_account/my_quotations/?f=item&qid='.$list[$n][0];?>"><img border="0" width="15" height="15" alt="Configure" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/configure_icon.gif"/> Configure</a></div>
                                              <div class="edit_colmn_div"><a href="<?=$objCore->_SYS['CONF']['URL_FRONT'].'/my_account/my_quotations/?f=recreate&qid='.$list[$n][0];?>" onClick="rectreate(this); return false;"><img border="0" width="15" height="15" alt="Recreate" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/recreate_icon.gif"/> Recreate</a></div>
										    <div class="edit_colmn_div"><a href="<?=$objCore->_SYS['CONF']['URL_FRONT'].'/my_account/my_quotations/?f=del&qid='.$list[$n][0];?>" onclick="delQuot(this); return false;"><img border="0" width="15" height="15" alt="Delete" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/delete_active.gif"/> Delete</a></div></td>
                                            <td width="6"/>
                                          </tr> <? } ?>
                                        </tbody></table>
                                        </td>
                                    </tr>
                                    <tr>
                                      <td> </td>
                                    </tr>
                                  </tbody></table>
                               
                              </div></td>
                          </tr>
                          <?php }?>
                          <tr>
                            <td height="10"/>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!---------------------------------------------------------------------------------------------------->
                </div>
                <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
              </div>
            </div>
          </div>
