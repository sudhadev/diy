<?php

 	require_once("../classes/core/core.class.php");
 	$objCore=new Core;
?>
<script>
    function submitform(){
        document.forms["verififcation"].submit();
    }
    </script>
<div id="right_bar_middle">
  <div id="main_form_bg">
      
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">
        <?php if($msg[0]=='ERR'){ ?>
          <div id="validate"><div class="msgBox" id="msgBox" style="width:90%;text-align: left;"> 
          <?php echo $objCore->_SYS['MSGS']['CUSTOMER'][$msg[1]][1];?>
          </div></div>
          <?php } ?>
          <?php if($_GET['fr']=='acc'){ ?>
          <div id="validate"><div class="msgBox" id="msgBox" style="width:90%;text-align: left; height: 40px;font-size: 12px;line-height: 1.5em;"> 
            
                Security code mailed to: <?php echo $_GET['email'];?><br/>
                      Validity Period: Valid only for 24 hours<br/>
           
                  </div></div>
          <?php } ?>
          <div id="resetted" style="display:none;">
          <div class="msgBox" id="msgBox" style="width:90%;text-align: left; font-size: 12px;line-height: 1.5em;border: 1px solid blue;"> 
            
                Security code has been changed. Please check your email.
           
                  </div>
</div>
          <br/>
          <div id="loging_banner">ACCOUNT VERIFICATION<br/></div>
          <br/>
    <div id="text_area" class="common_text">Put the received verification code in the box below and click submit to enable your account with DIY Price Check.</div>
        
        <div id="form_bg" style="height:287px;">
          <form name="verification" id="verification" method="post" action="/signup/?f=verify">
            <div id="form_outer">
              <div id="form_middle">
                <div id="form_cell_outer">
                  <div id="form_cell_left" style="width: 130px;"> 
                      <label>
                          Enter the verification code:   
                          </label>
                 </div>
                    
                      <div id="form_cell_right" style="width: 200px;">
                      <input name="ver_code" type="text" id="ver_code" size="30" value=""/>
                  </div>
                       </div>
                   <div id="form_cell_outer">
                  <div id="form_cell_left" style="width: 110px;"></div>
                  <div id="form_cell_right" style="width: 255px;">

                      <input name="uid" type="hidden" id="uid" value="<?php echo urldecode($_REQUEST['uid']);?>"/>
                      <div id="reset_code" style="width: 410px;">
                      <a id="reset_code" name="reset_code" onclick="resetVerificationCode(document.getElementById('uid').value)" style="text-decoration: underline !important;cursor: pointer;float: left;margin-left: 25px;">Click here to reset the verification code</a>
                      <div id="preLoaderContainer" style="float:right;display:none;">
                                                                      
                                                                                        <img border="0" alt="Processing Image" title="Processing Image" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/icons/ajax-loader.gif">
                                                                                    
                                                                                      <span class="common_text">Processing ... Please wait.</span>
                                                                                   
                                                                    </div>  
                      </div> 
                      <br/>
                  </div>
                  </div>
                   <div id="form_cell_outer">
                        <div id="form_cell_left" style="width: 45px;"></div>
                  <div id="form_cell_right" style="width: 255px;">

                       
                          <input type="image" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" id="submit" width="81" height="25" border="0" onclick="submitform();" style="cursor: pointer;"/>
                       
                          
                      
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

