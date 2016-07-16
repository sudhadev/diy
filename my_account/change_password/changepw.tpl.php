
<?php

?>

<!-- START CONTENT AREA-->
<div id="right_bar_middle">
<div id="main_form_bg">
<div id="main_form_bg_middle">
<div id="main_form_bg_topbar">
<img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
<div id="main_form_bg_middlebar">
<div id="banner">CHANGE PASSWORD</div>
<div id="outer">
<div id="outer_middle">

  <div id="text_area" class="common_text">
   <div id="option_form">
    <div class="common_text">If you can’t remember your password, log out, then, go to log back in and use "forgot your login details" reminder. </div><br/>
            
              			<div id="result_pw"></div>
                <form id="frmChangePW" name="frmChangePW" method="POST" action="">
   <div class="text_fieldBlock_left">Password:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="password" type="password" id="password" class="myprof_changepw_txtfield"/>
                      </label>
                      <br /> 
                    </div>
                    <div class="text_fieldBlock_left">New Password:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="newPassword" type="password" id="newPassword" class="myprof_changepw_txtfield"/>
                      </label>
                      <br /> 
                    </div>
                     <div class="text_fieldBlock_left">Confirm New Password:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="confirmNewPassword" type="password" id="confirmNewPassword" class="myprof_changepw_txtfield"/>
                      </label>
                      <br />
                      </div>
                    </form>
                    </div>
                   <div id="submit" class="submit_butten" align="left">
                  <label id="changepw">
                  <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/cancel.jpg" border="" ></a>
                  <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="" class="curserHand" onClick="changePassword('<?php echo $objCore->sessCusId; ?>', document.frmChangePW.password.value, document.frmChangePW.newPassword.value, document.frmChangePW.confirmNewPassword.value)"></label>
                 <div id="preLoaderContainer" style="display:none;float:right;margin-left: 5px;">
                                                                      
                                                                                        <img border="0" alt="Processing Image" title="Processing Image" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/icons/ajax-loader.gif">
                                                                                    
                                                                                      <span class="common_text">Processing ... Please wait.</span>
                                                                                   
                                                                    </div>
                   </div> 
       	

                    </div>  
  </div>

<!-- yellow part<div id="form_bg"> -->
<div id="form_outer">
<div id="form_middle">
 <!--<div class="form_middle_text"><br />
   <br /></div> -->
</div>
</div>
</div>
<!--<div id="signup_butten" align="left"><a href="#"></a></div>-->
</div>
</div>
   <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div> 
</div>

</div>
<!-- END CONTENT AREA-->
