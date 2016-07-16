<?php 
?>

<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">
        <div id="outer">
          <div id="outer_middle">
            <div id="banner" align="center">REGISTRATION SUCCESSFUL</div>
             <div id="text_area" class="common_text"> 
Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</br>             
             <p>Please select a subscription option</p>
              <div id="option_form">
              <div id="errors"></div>
                <form id="subscription" name="subscription" method="post" action="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/payments/index.php">
                  <div id="option_inerform">
                    <div class="option_form_selections">
                      <label>
                      <input name="selections" type="radio" id="materials" value="M" onClick="hidePackages(this.value);requestPackages(this.value, 'packages_m.ajax.php');"/>
                      </label>
                      Materials <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')" onmouseout="hidePopup()" />  </div>  
                    <div id="packages_m"></div>
                    <div class="option_form_selections">
                      <label>
                      <input type="radio" name="selections" id="services" value="S" onClick="hidePackages(this.value);requestPackages(this.value, 'packages_s.ajax.php');" /> 
                      </label>
                      Services <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')" onmouseout="hidePopup()" /> </div>
                    <div id="packages_s"></div>
                    <div class="option_form_selections">
                      <label>
                      <input type="radio" name="selections" id="classifiedAds" value="C" onClick="hidePackages(this.value);"/>
                      </label>
                      Classified Ads <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/info.png" onmouseover="showPopup('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.','#FFFFFF')" onmouseout="hidePopup()" /> </div>
                  </div>
                   <input type="hidden" id="f" name="f" value="confirm">
                </form>
              </div>
            </div>
            <div id="signup_butten" align="left"><a href="javascript:subscription.submit();"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/next-button.jpg" border="" onClick="subscription.submit();"/></a></div>
          </div>
        </div>
      </div>
      <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
    </div>
  </div>
</div>