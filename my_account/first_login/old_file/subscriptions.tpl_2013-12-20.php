<?php
require_once($objCore->_SYS['PATH']['CLASS_GLOBAL_CONFIG']);
if(!is_object($objGlobalConfig)) $objGlobalConfig= new GlobalConfig;
$arrSuppliesOptions=$objGlobalConfig->getSuppliesFares('ByMonthFilterd');
//print_r($_POST);
?>

<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar">
                <div id="outer">
                    <div id="outer_middle">
                        <?php
                        if(!$objCore->sessCusId) 
                        {
                        ?>
                        <div id="banner" align="center">REGISTRATION SUCCESSFUL</div>
                        <div id="text_area" class="common_text">
                           <p> <?php echo $pageContents['common_text'];?></p>
                        <?php }
                        else
                        ?><div id="text_area" class="common_text">
                            <div id="option_form">
                                <div id="errors"></div>
                                <form id="frmSubcriptions" name="frmSubcriptions" method="post" action="<?php  str_replace("http://", "https://", $objCore->_SYS['CONF']['URL_MY_ACCOUNT'])."/payments/index.php";?>" >
                                    

                                <div id="option_inerform">

<!--                                    <div class="option_form_selections">
                                        <label>
                                            <input name="selections" id="subsNone" value="" type="radio" checked="true" onclick="toggleStatus();selectSubOpt('');">
                                        </label>
                                    -----</div>-->

                                    <div class="option_form_selections">
                                        <label>
                                            <input name="selections" id="materials" value="M" onclick="selectSubOpt('M');"  type="radio" checked="true">
                                        </label>
                                    Supplies</div>
                                    <div class="option_form_sub_selections">
                                        <div id="suppliers_container">
                                            <div id="prBox" class="active" <?php if($errMsg){?> style="background-color: #fcc;"<?php }?>>
                                                <span id="msg"> <?php echo $errMsg;?></span>
                                                <span class="textMain">If You have a promotional code please enter it here.</span> <input id="prCode" name="prCode"  value="<?php if(isset($_REQUEST['promo_code'])) echo $_REQUEST['promo_code']; else echo $_REQUEST['prCode'];?>" />
                                                <br/> <span class="text">* You should select the exact Listing Package (Bronze, Silver or Gold) which has been sent with the promotional code.
                                                Upon Completing the trial period you will receive an email to renew the subscription.</span>
                                            <?php //print_r($_SESSION); ?>
                                            </div>
                                            <div id="elementsToOperateOn">

                                                <table  id="subsSupplies" class="subs_suppDisable" border="0" cellpadding="0" cellspacing="2" width="100%">
                                                    <tbody><tr><td colspan="3"><span id="clistplan" class="inactive">Choose Your Listing Plan</span></td></tr>
                                                        <tr>
                                                            <td class="heading_bronze" id="hg">Bronze <?php echo $objCore->gConf['SUBSCRIPTION_BRONZE']?></td>
                                                            <td class="heading_silver">Silver <?php echo $objCore->gConf['SUBSCRIPTION_SILVER']?></td>
                                                            <td class="heading_glod">Gold <?php echo $objCore->gConf['SUBSCRIPTION_GOLD']?></td>
                                                        </tr>
                                                        <?php
                                                        $arraySubs=array('Bronze','Silver','Silver');
                                                        $subStyle=array('light','dark');
                                                        $rowIndex=0;
                                                        for($row=0;$row<4;$row++) {
                                                            if($arrSuppliesOptions[$row][0][2]||$arrSuppliesOptions[$row][1][2]||$arrSuppliesOptions[$row][2][2]) {
                                                                ?>
                                                        <tr>
                                                            <?php
                                                            for($col=0;$col<3;$col++) {
                                                                ?>
                                                            <td class="<?php echo strtolower($arraySubs[$col]);?>_<?php echo $subStyle[$row%2]?>"><label>
                                                                    <?php //print_r($arrSuppliesOptions[$row][$col])
                                                                    ?>

                                                                    <?php
                                                                    if($arrSuppliesOptions[$row][$col][2]) {
                                                                        echo '<input disabled="disabled" name="packages" id="'.strtolower($arrSuppliesOptions[$row][$col][6]).$arrSuppliesOptions[$row][$col][5].'" value="'.$arrSuppliesOptions[$row][$col][6].'||'.$arrSuppliesOptions[$row][$col][5].'" onclick="handleButtons(\''.strtolower($objCore->_SYS['CONF']['SUBCRIPTIONS']['M'][$arrSuppliesOptions[$row][$col][6]]).'\');selectOpt(\'M\');" type="radio">';
                                                                        echo str_pad($arrSuppliesOptions[$row][$col][5],2,"0",STR_PAD_LEFT)." Months  - ".$objCore->_SYS['CONF']['CURRENCY']." ".$arrSuppliesOptions[$row][$col][2];

                                                                    }

                                                                    ?>
                                                            </label></td>
                                                            <?php

                                                        }selectSubOpt

                                                        ?>

                                                        </tr>
                                                        <?php

                                                        $rowIndex++;
                                                    } // end if
                                                } // end main loop
                                                ?>
                                                        <tr style="text-align:center;">
                                                            <td class="heading_bronze_bot"><div align="center"><input type="button" value="" id="bronze" name="bronze" onclick="frmSubcriptions.submit();" style="display: block;"/></div></td>
                                                            <td class="heading_silver"><div align="center"><input type="button" value="" id="silver" name="silver" onclick="frmSubcriptions.submit();" style="display: none;"/></div></td>
                                                            <td class="heading_glod_bot"><div align="center"><input type="button" value="" id="gold" name="gold" onclick="frmSubcriptions.submit();" style="display: none;"/></div></td>
                                                        </tr>
                                                </tbody></table>
                                                <input  name="selMOption" id="selMOption" value="b3" type="hidden">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="option_form_selections">
                                        <label>
                                            <input name="selections" id="services" value="S" onclick="selectSubOpt('S');" type="radio" >
                                        </label>
                                    Services</div>
                                        
                                    <div id="elementsToOperateOn2" class="option_form_sub_selections">
                                        <div id="prBox" class="active" <?php if($errMsg){?> style="background-color: #fcc;"<?php }?>>
                                                <span id="msg"> <?php echo $errMsg;?></span>
                                                <span class="textMain">If You have a promotional code please enter it here.</span> <input id="prCode" name="prCode"  value="<?php if(isset($_REQUEST['promo_code'])) echo $_REQUEST['promo_code']; else echo $_REQUEST['prCode'];?>" />
                                                <br/> <span class="text">* You should select the exact Listing Package which has been sent with the promotional code.
                                                Upon Completing the trial period you will receive an email to renew the subscription.</span>
                                            <?php //print_r($_SESSION); ?>
                                            </div>
                                        <table id="subsServices" class="subs_servDisable" border="0" cellpadding="0" cellspacing="2" width="200">
                                            <tbody><tr>
                                                    <td class="heading_services" id="hg">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td class="services_light">
                                                        <label>
                                                            <input name="packages" type="radio" id="one_month" value="1" <?php if ($_REQUEST['packages'] == '1') ?> checked="true" onClick="selectOpt('S');" />
                                                        </label>
                                                    1 Month - <?php echo $objCore->_SYS['CONF']['CURRENCY']." ".$objCore->gConf["SUBSCRIPTION_1MONTH_PRICE"]?>      </td>

                                                </tr>
                                                <tr class="data">
                                                    <td class="services_dark">
                                                        <label>
                                                            <input type="radio" name="packages" id="three_months" value="3" onClick="selectOpt('S');"/>
                                                        </label>
                                                        3 Months - <?php echo $objCore->_SYS['CONF']['CURRENCY']." ".$objCore->gConf["SUBSCRIPTION_3MONTH_PRICE"]?>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="services_light">
                                                        <label>
                                                            <input type="radio" name="packages" id="six_months" value="6" onClick="selectOpt('S');"/>
                                                    6 Months - <?php echo $objCore->_SYS['CONF']['CURRENCY']." ".$objCore->gConf["SUBSCRIPTION_6MONTH_PRICE"]?></label></td>

                                                </tr>
                                                <tr class="data_bg">
                                                    <td class="services_dark"><label>
                                                            <input type="radio" name="packages" id="one_year" value="12" onClick="selectOpt('S');"/>
                                                            12 Months - <?php echo $objCore->_SYS['CONF']['CURRENCY']." ".$objCore->gConf["SUBSCRIPTION_1YEAR_PRICE"]?>
                                                    </label></td>
                                                </tr>
                                                <tr>
                                                    <td class="heading_services_bot"><input name="gold" value="" type="button" onclick="frmSubcriptions.submit();"></td>
                                                </tr>
                                        </tbody></table>
                                    </div>
                                    <input id="f" name="f" value="confirm" type="hidden">
                                    <input id="firstLogin" name="firstLogin" value="y" type="hidden">
                                    <?/*
                                          <div class="option_form_selections">
                                                          <label>
                                                          <input name="selections" id="none" value=""  type="radio" checked="false" onclick="disableAll();">
                                                          </label>
                                                          None of above </div>

                                           </div>
                                                                            */?>
                                </div>



                                <div class="option_form_selections">
                                    <label>
                                        <input type="radio" id="classified" name="classified" value="C" />
                                    </label>
                                Classified Ads </div>
                                <div class="option_form_sub_selections" style="padding:5px;width:570px;">
                                    <?php echo $pageContents['option_form_sub_selections'];?>
                                    <br/><br/><input id="clAds" name="cadd" value="" type="button" onclick="frmSubcriptions.submit();">
                                </div>





                            </div>
                            <? /*
                                                <div id="option_inerform">
                                                <div class="option_form_selections">
                                                  <label>
                                                  <input name="selections" type="radio" id="materials" value="M" onClick="hidePackages(this.value);requestPackages(this.value, 'packages_m.ajax.php');"/>
                                                  </label>
                                                  Supplies <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')" onmouseout="hidePopup()" />  </div>
                                                <div id="packages_m"></div>
                                                <div class="option_form_selections">
                                                  <label>
                                                  <input type="radio" name="selections" id="services" value="S" onClick="hidePackages(this.value);requestPackages(this.value, 'packages_s.ajax.php');" />
                                                  </label>
                                                  Services <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')" onmouseout="hidePopup()" /> </div>
                                                <div id="packages_s"></div>
                                                <div class="option_form_selections">
                                                  <label>
                                                  <input type="radio" id="classified" value="C" checked="true" disabled />
                                                  </label>
                                                  Classified Ads <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')" onmouseout="hidePopup()" />  </div>
                                                  <div class="option_form_sub_selections" style="padding:5px;width:570px;">
                                                  <?php echo $pageContents['option_form_sub_selections'];?>
                                                  </div>
                                                  <input name="cadd" value="Subscribe" type="button" onclick="frmSubcriptions.submit();">
                                              </div>
                                                        */ ?>
                            <input type="hidden" id="f" name="f" value="confirm">
                            </form>
                        </div>
                    </div>
                    <div id="signup_butten" align="left">
                        <?/*
                                    <a href="javascript:subscription.submit();"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/next-button.jpg" border="" onClick="subscription.submit();"/></a>
                                                */?>
                    </div>
                </div>
            </div>
        </div>
        <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
    </div>
</div>
</div>
<script language="javascript">
    toggleStatus()
    handleButtons('bronze');

</script>