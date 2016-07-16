<?php
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
if(!is_object($objCustomer)) $objCustomer = new Customer(); 

require_once($objCore->_SYS['PATH']['CLASS_PAYMENT']);
if(!is_object($objPayment))$objPayment = new Payment($objCore->gConf);


$subcriptionData = $objCustomer->getStatus($objCore->sessCusId);

for($ms=0;$ms<count($subcriptionData);$ms++) {
    if($subcriptionData[$ms][8]) {
        $subcriptionData[$ms][100]=$objPayment->diyRecurringProfileGetFromGateway($subcriptionData[$ms][8]);
    }

}



$sStatus= $objCustomer->getSubscriptionStatus($subcriptionData);



// prepare styles
$arrRowStyle[0]="";
$arrRowStyle[1]="ash_strip";

$arrIcons['ACTIVE']='<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_FRONT'].'/icons/ok.png" alt="Active" title="Active" />';
$arrIcons['EXPIRED']='<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_FRONT'].'/icons/issue.png" alt="Expired" title="Expired" />';
$arrIcons['TO-EXPIRE']='<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_FRONT'].'/icons/thumb_down.png" alt="Auto Renew:  Off" title="Auto Renew:  Off " />';
$arrIcons['AUTO']='<img src="'.$objCore->_SYS['CONF']['URL_IMAGES_FRONT'].'/icons/thumb_up.png" alt="Auto Renew:  On" title="Auto Renew:  On" />';


require_once($objCore->_SYS['PATH']['CLASS_GLOBAL_CONFIG']);
if(!is_object($objGlobalConfig)) $objGlobalConfig= new GlobalConfig;
$arrSuppliesOptions=$objGlobalConfig->getSuppliesFares('ByMonthFilterd');

if($objCore->_SYS['ENV']=='LIVE') {
    $sysURL=str_replace("http://", "https://", $objCore->_SYS['CONF']['URL_SYSTEM']);
}else {
    $sysURL=$objCore->_SYS['CONF']['URL_SYSTEM'];
}
?>

<!-- START CONTENT AREA-->
<div id="right_bar_middle">
    <div id="main_form_bg">
        <div id="main_form_bg_middle">
            <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
            <div id="main_form_bg_middlebar">
                <div id="outer">
                    <div id="outer_middle">
                        <div id="banner" align="center">MY SUBSCRIPTIONS</div>
                        <div id="text_area" class="common_text"><span style="color:red;">IMPORTANT : </span> If you want to subscribe to both Building Supplies and Building Services, the businesses must have the same address and contact details, as the details taken during registration are used for both businesses. If you have businesses with different addresses and contact details, you will need to register each business separately.
                            <ol>
                                <li>To subscribe as a Supplier or Service provider, click button next to Supplies or Services below. </li>
                                <li>Then, choose a package that suits your requirements. For more details of packages, go to <a href="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM'];?>/fees_schedule.php" target="_blank">Fee Schedule</a>.</li>
                            </ol>
                            <br/><br/>
                            <div class="list_yellowbg_heading">
                                <div class="double_arrow"><a href=""><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" border="0" height="14" width="14"></a></div>
                                <div class="list_yellow_heading">Current Subscriptions</div></div><br/><br/><br/>
                            <table width="652px" cellspacing="0" cellpadding="0" border="0" align="center">
                                <tbody>
                                    <tr>
                                        <td width="652px" valign="top" align="center"><table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                                                <tbody><tr>
                                                        <td height="36" width="6" id="grid_left_end" class="grid_end"/>
                                                        <td height="36" width="134" class="grid_middle chagrs_grid_heading">Subscription</td>
                                                        <td height="36" width="1" class="grid_break"/>
                                                        <td height="36" width="134" class="grid_middle chagrs_grid_heading">Package</td>
                                                        <td height="36" width="1" class="grid_break"/>
                                                        <td width="134" class="grid_middle chagrs_grid_heading">Number of Listings</td>
                                                        <td width="1" class="grid_break"/>
                                                        <td height="36" width="134" class="grid_middle chagrs_grid_heading">Date of Expire</td>
                                                        <td height="36" width="6" id="grid_right_end" class="grid_end"/>
                                                    </tr>
<?php 
                                                    for ($i=0; $i<count($subcriptionData); $i++) {
                                                        if ($subcriptionData[$i][2] != null && $subcriptionData[$i][3] != null) {
                                                            $temp[] = $arrSubscriptions[$subcriptionData[$i][2]][$subcriptionData[$i][3]];
                                                            $temp['expire'][] = $subcriptionData[$i][4];

                                                        }
                                                        else {
                                                            $temp[] = $arrSubscriptions[$subcriptionData[$i][2]];
                                                        }

                                                        if($subcriptionData[$i][2]!="C") {
                                                            $thisSub=$objCustomer->getSubscriptionStatus($subcriptionData,$subcriptionData[$i][2]);
                                                        }

                                                        // flag if supplier already subscribed to the meterials (supplies)
                                                          if($subcriptionData[$i][2]=="M") $flagSupplies=true;
                                                        ?>
                                                    <tr  class="<?php echo $arrRowStyle[$i%2];?>">
                                                        <td width="6"/>
                                                        <td width="134" class="chagrs_grid_text"><?php echo ($arrSubscriptions[$subcriptionData[$i][2]]['OPTION']);
                                                        ?></td>
                                                        <td/>
                                                        <td width="134" class="chagrs_grid_text"><div align="left"><?php if ($arrSubscriptions[$subcriptionData[$i][2]][$subcriptionData[$i][3]] == '') echo "<I>none</I>"; else if ($subcriptionData[$i][2] == 'S') echo $arrSubscriptions[$subcriptionData[$i][2]][$subcriptionData[$i][3]]." "; else echo $arrSubscriptions[$subcriptionData[$i][2]][$subcriptionData[$i][3]];
    if($subcriptionData[$i][7]) echo " [".str_pad($subcriptionData[$i][7],2,"0",STR_PAD_LEFT)." Months]";?></div></td>
                                                        <td/>
                                                        <td width="134" class="chagrs_grid_text"><div align="left"><?php if ($subcriptionData[$i][6] && $temp['expire'][0] != 'E') echo $subcriptionData[$i][6]; elseif ($subcriptionData[$i][6] && $temp['expire'][0] == 'E') echo $subcriptionData[$i][6]." (Listings Exceeded)"; else echo "<I>none</I>"; ?></div></td>
                                                        <td width="1"/>
                                                        <td width="134" class="chagrs_grid_text"><div align="left">
    <?php

    if($subcriptionData[$i][2]!="C") {
        echo '<div style="float:left;padding-right:5px;">';
                                                                        echo $thisSub['Expire']? date($objCore->gConf['DATE_FORMAT'], $thisSub['Expire']): '-';
                                                                        echo "</div>";
                                                                        echo "<div>";
                                                                        echo $arrIcons[$thisSub['Flags'][0]];
                                                                        if($thisSub['Flags'][1]) echo $arrIcons[$thisSub['Flags'][1]];
                                                                        echo "</div>";

                                                                    }
                                                                    else {
                                                                        echo '<div style="float:left;padding-right:38px;">';
                                                                        echo  "<I>None</I>";
                                                                        echo "</div><div>";
                                                                        echo $arrIcons['ACTIVE'];
                                                                        echo "</div>";
                                                                    }


                                                                    ?></div></td>
                                                        <td width="6"/>
                                                    </tr>
                                                                    <?php
}
?>
                                            </table>
                                        </td>
                                    </tr>
                            </table>
                            <br/><a id="upgSubscript"></a>
                            <div class="list_yellowbg_heading">
                                <div class="double_arrow"><a href=""><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/double-arrows.jpg" border="0" height="14" width="14"></a></div>
                                <div class="list_yellow_heading">Upgrade Subscriptions</div></div>

                            <div style="width: 630px; margin-top: 10px; margin-left: 5px; display: block;" class="commonInfoBox" id="specialInfo">
                                <div style="display: block;" id="addSecCat">
                                    <strong>Note*:</strong> The system will not do any automatic refunding.<br/>
                                    If you are planing to pay for the same subscription or to degrade the current subscription,
                                    we advice you to wait till the last month of your subscription (Or until the expiry note appears on above table)
                                    , in order to avoid paying any excess payments.


                                </div>
                            </div>
                            <div id="option_form">
                                <form id="frmSubcriptions" name="frmSubcriptions" method="POST" action="<?php /* removed echo purposly*/  $sysURL."/my_account/payments/?listing=".$_REQUEST['listing']; ?>">

                                    <div id="option_inerform">
                                        <div class="option_form_selections">
                                            <label>
                                                <input name="selections" id="materials" value="M" onclick="selectSubOpt('M');"  type="radio">
                                            </label>
                                            Supplies</div>
                                        <div class="option_form_sub_selections">
                                            <div id="suppliers_container">
                                                <?php if(!$flagSupplies){?>
                                                <div id="prBox" class="inactive" <?php if($errMsg) {?> style="background-color: #fcc;"<?php }?>>
                                                    <span id="msg"> <?php echo $errMsg;?></span>
                                                    <span class="textMain">If You have a promotional code please enter it here.</span> <input id="prCode" name="prCode"  value="<?php echo $_REQUEST['prCode']?>" />
                                                    <br/> <span class="text">* You should select the exact Listing Package (Bronze, Silver or Gold) which has been sent with the promotional code.
                                                        Upon Completing the trial period you will receive an email to renew the subscription.</span>
                                                </div>
                                                <?php } ?>
                                                <div id="elementsToOperateOn">

                                                    <table  id="subsSupplies" class="subs_suppDisable" border="0" cellpadding="0" cellspacing="2" width="100%">
                                                        <tbody><tr><td colspan="3">Choose Your Listing Plan</td></tr>
                                                            <tr>
                                                                <td class="heading_bronze" id="hg">Bronze <?php echo $objCore->gConf['SUBSCRIPTION_BRONZE']?></td>
                                                                <td class="heading_silver">Silver <?php echo $objCore->gConf['SUBSCRIPTION_SILVER']?></td>
                                                                <td class="heading_glod">Gold <?php echo $objCore->gConf['SUBSCRIPTION_GOLD']?></td>
                                                            </tr>
<?php
$arraySubs=array('Bronze','Silver','Gold');
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
                                                <input name="selections" id="services" value="S" onclick="selectSubOpt('S');" type="radio" checked="true">
                                            </label>
                                            Services</div>
                                        <div id="elementsToOperateOn2" class="option_form_sub_selections">
                                            <table  id="subsServices" class="subs_servEnable" border="0" cellpadding="0" cellspacing="2" width="200">
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
                                    </div>



<?php /*




<div id="option_inerform">
    <div class="option_form_selections">
      <label>
      <?php 
                if  (($temp[0] != 'Gold' && $temp[1] != 'Gold' && $temp[2] != 'Gold') || $temp['expire'][0] == 'E')
				{     
      ?>
      <input name="selections" type="radio" id="materials" value="M"  onClick="selectSubOpt('M');"/>
      </label>
      Supplies</div>
      <div class="option_form_sub_selections">
      <?php
        $flgMOptions=false;$selMOption='';
      	if (($temp[0] != 'Bronze' && $temp[0] != 'Silver') && ($temp[1] != 'Bronze' && $temp[1] != 'Silver') && ($temp[2] != 'Bronze' && $temp[2] != 'Silver') || $temp['expire'][0] == 'E')
      	{
      ?> 
      <div class="option_form_sub_text_selections" style="background:#ccc;padding:2px 8px 2px 8px;">
        <label >
     
        Bronze</label>
        </div>
        <div style="padding-left:30px;">
        <?php $arrSuppliesOptions=$objGlobalConfig->getSuppliesFares('ByPlan');
              foreach($arrSuppliesOptions['B'] as $keySO=>$valueSO)
              {
                    
                    if($valueSO[2]>0) 
                    {
                        echo "<label><input type=\"radio\" name=\"packages\" id=\"b$keySO\" value=\"B||$keySO\"  onClick=\"selectOpt('M');\"/>".$keySO." Months Subscription - ".$objCore->_SYS['CONF']['CURRENCY']." ".$valueSO[2]."</label><br/>";
                        if($flgMOptions==false) $selMOption="b$keySO";$flgMOptions=true;
                    }
              }

        ?>
        </div>
        <?php
        	}
        	if (($temp[0] != 'Silver' && $temp[1] != 'Silver' && $temp[2] != 'Silver') || $temp['expire'][0] == 'E')
        	{
        ?> 
      <div class="option_form_sub_text_selections" style="background:#ccc;padding:2px 8px 2px 8px;">
        <label>
        

        </label>
        Silver</div>
        <div style="padding-left:30px;">
        <?php
              foreach($arrSuppliesOptions['S'] as $keySO=>$valueSO)
              {
                    
                    if($valueSO[2]>0)
                    {
                        echo "<label><input type=\"radio\" name=\"packages\" id=\"s$keySO\" value=\"S||$keySO\"  onClick=\"selectOpt('M');\"/>".$keySO." Months Subscription - ".$objCore->_SYS['CONF']['CURRENCY']." ".$valueSO[2]."</label><br/>";
                        if($flgMOptions==false) $selMOption="s$keySO";$flgMOptions=true;
                    }
              }

        ?>
        </div>
        <?php 
          }
        ?> 
     <!--  <div class="option_form_sub_text_selections"> -->
        <div class="option_form_sub_text_selections" style="background:#ccc;padding:2px 8px 2px 8px;">
          <label>
          
          <?php if($flgMOptions==false){$selMOption='gold';$flgMOptions=true;}  ?>
          Gold</label>
        </div>
        <input type="hidden" name="selMOption" id="selMOption" value="<?php echo $selMOption;?>">
        <div style="padding-left:30px;">
        <?php 
              foreach($arrSuppliesOptions['G'] as $keySO=>$valueSO)
              {
                    
                    if($valueSO[2]>0) echo "<label><input type=\"radio\" name=\"packages\" id=\"g$keySO\" value=\"G||$keySO\"  onClick=\"selectOpt('M');\"/>".$keySO." Months Subscription - ".$objCore->_SYS['CONF']['CURRENCY']." ".$valueSO[2]."</label><br/>";
              }
              //print_r($arrSuppliesOptions['G']);

              }
		      if (true)
		      {
        ?>
        </div>
      <!-- </div> -->
      </div>
      <div class="option_form_selections">
      <label>
      <input type="radio" name="selections" id="services" value="S"  <?php if ($_REQUEST['selections'] == 'S') ?> checked="true" onClick="selectSubOpt('S');"/>
      </label>
      Services</div>
           <div class="option_form_sub_selections">
      <div class="option_form_sub_text_selections"> 
        <label>
        <input name="packages" type="radio" id="one_month" value="1" <?php if ($_REQUEST['packages'] == '1') ?> checked="true" onClick="selectOpt('S');" />
        </label>
        1 Month - <?php echo $objCore->_SYS['CONF']['CURRENCY']." ".$objCore->gConf["SUBSCRIPTION_1MONTH_PRICE"]?></div>
      <div class="option_form_sub_text_selections">
        <label>
        <input type="radio" name="packages" id="three_months" value="3" onClick="selectOpt('S');"/>
        </label>
        3 Months - <?php echo $objCore->_SYS['CONF']['CURRENCY']." ".$objCore->gConf["SUBSCRIPTION_3MONTH_PRICE"]?></div>
     <!--  <div class="option_form_sub_text_selections"> -->
        <div class="option_form_sub_text_selections">
          <label>
          <input type="radio" name="packages" id="six_months" value="6" onClick="selectOpt('S');"/>
          6 Months - <?php echo $objCore->_SYS['CONF']['CURRENCY']." ".$objCore->gConf["SUBSCRIPTION_6MONTH_PRICE"]?></label>
        </div>
        <div class="option_form_sub_text_selections">
          <label>
          <input type="radio" name="packages" id="one_year" value="12" onClick="selectOpt('S');"/>
          1 Year - <?php echo $objCore->_SYS['CONF']['CURRENCY']." ".$objCore->gConf["SUBSCRIPTION_1YEAR_PRICE"]?></label>
        </div>
        <?php 
				}        
        ?> 
      <!-- </div> -->
      </div>
      <input type="hidden" id="f" name="f" value="confirm">
      </div>
                                    */ ?>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
                <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
            </div>
        </div>
    </div>
</div>
<script language="javascript">

    handleButtons('bronze');
    selectSubOpt('M');
</script>