<?php

?>

<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">
        <div id="loging_banner">WELCOME</div>
        <div id="outer">
          <div id="outer_middle">
            <div align="justify" id="text_area" class="common_text"> <div align="justify"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.</div> <br /> 
              <br />
            </div>
            <div id="form_bg">
            <form name="frmSubcriptions" action="<?php echo $objCore->_SYS['CONF']['URL_SYSTEM']; ?>/my_account/payments/" method="POST">
<!--             <input type="hidden" id="f" name="f" value="confirm"> -->
            <input type="hidden" id="selections" name="selections" value="<?php echo $_REQUEST['selections']; ?>">
            <input type="hidden" id="packages" name="packages" value="<?php echo $_REQUEST['packages']; ?>">
            </form>
              <div id="form_outer">
                <div id="form_middle">
                  <div class="form_middle_text">You will need to pay <strong>£<?php echo $payArray[$_REQUEST['selections']][$_REQUEST['packages']]?> </strong>for the selected subscription option.<br />
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.<br />
                    <br />
                  </div>
                </div>
              </div>
            </div>
            <div id="signup_butten" align="left"><a href="javascript:frmSubcriptions.submit();"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/next-button.jpg" border="" onClick="frmSubcriptions.submit();"/></a></div>
          </div>
        </div>
      </div>
      <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
    </div>
  </div>
</div>