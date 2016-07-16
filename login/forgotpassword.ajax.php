<?php

	if ($_SERVER["REQUEST_METHOD"] <> "POST") 
 		die("Access Denied");
 	
 	require_once("../classes/core/core.class.php");
 	$objCore=new Core;
?>

<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">
        <div id="loging_banner">PASSWORD RESET<br/></div>
        <br /><br />
						<div id="text_area" class="common_text">Put your registered username (email) in the box below to receive a new password.</div>
        <div id="result"></div>
        <div id="form_bg" style="height:287px;">
          <form name="frmLogin" id="frmLogin" method="POST">
            <div id="form_outer">
              <div id="form_middle">
                <div id="form_cell_outer">
                  <div id="form_cell_left"> Username: </div>
                  <div id="form_cell_right">
                    <label>
                    <div align="left">
                      <input name="uid" type="text" id="uid" size="30" value="<?php //echo $_REQUEST['uid'];?>" onfocus="handleLoginFields('none',this.name);" onblur="handleLoginFields('block',this.name);" onkeypress="handleLoginFields('change',this.name);" style="<?php if(strtolower($_REQUEST['uid'])=="email"){ echo "color:#BBB;";}?>" />
                    </div>
                    </label>
                  </div>
                </div>
                <div id="form_cell_outer">
                  <div id="form_cell_left"></div>
                  <div id="form_cell_right">
                    <div id="form_cell_rightL" style="width:255px !important;">
                      <label>
                      <div align="left" id="password_reset_form"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" width="81" height="25" border="0" onClick="doReset('password_reset.ajax.php', document.frmLogin.uid.value)">
                       <div id="preLoaderContainer" style="display:none;float:right;">
                                                                      
                                                                                        <img border="0" alt="Processing Image" title="Processing Image" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/icons/ajax-loader.gif">
                                                                                    
                                                                                      <span class="common_text">Processing ... Please wait.</span>
                                                                                   
                                                                    </div>
                      </div>
                     
                      </label>
                      
                    </div>
                      
                  </div>
                </div>
              </div>
            </div>

          </form>
            
        </div>
        
        <div id="register_outer">
         <div id="register_outer_middle">
         </div>
       </div>
      <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
    </div>
  </div>
</div>
</div> 
