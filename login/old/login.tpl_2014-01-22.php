<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  login.tpl.php                                       '
  '    PURPOSE         :  login interface for the users							   '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
   
?>

<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">
        <div id="loging_banner">USER LOGIN</div>
      	<div style="margin-left: -265px;margin-top:23px;float:left;width:670px">
        				<?php
							if($_REQUEST['err'])
							{
								
								$msg=array('ERR',$_GET['err']);
								echo $objCore->msgBox("LOGIN",$msg,'96%');
							} 
                                                                                                          
             ?>    
        </div>
     
             <div id="form_bg">               	

          <form action="<?php echo $objCore->_SYS['CONF']['URL_LOGIN_MODULE'];?>/process.php" method="get">
            <div id="form_outer">
              <div id="form_middle">
                <div id="form_cell_outer">
                  <div id="form_cell_left"> Username: </div>
                  <div id="form_cell_right">
                    <label>
                    <div align="left">
                      <input name="uid" type="text" id="uid" class="supplier_login_textfield" onfocus="handleLoginFields('none',this.name);" onblur="handleLoginFields('block',this.name);" onkeypress="handleLoginFields('change',this.name);" value="Email" style="color:#BBB;"/>
                    </div>
                    </label>
                  </div>
                </div>
                <div id="form_cell_outer">
                  <div id="form_cell_left"> Password: </div>
                  <div id="form_cell_right">
                    <label>
                    <div align="left">
                      <input name="pass" type="password" id="pass" class="supplier_login_textfield" />
                    </div>
                    </label>
                  </div>
                </div>
                <div id="form_cell_outer">
                  <div id="form_cell_left"></div>
                  <div id="form_cell_right">
                    <div id="form_cell_rightL">
                      <label>
                      <div align="left"><input type="image" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.png" width="81" height="25" border="0"/></div>
                      </label>
                    </div>
                    <div id="form_cell_rightR">Forgot your login details? <a href="javascript:requestForgotPassword('forgotpassword.ajax.php', document.getElementById('uid').value)">Click here ></a></div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div id="outer">
          <div id="outer_middle">
            <div id="banner" align="center">REGISTRATION</div>
            <div id="text_area" class="common_text"> If you would like to create listings on <strong>DIY PRICE CHECK </strong>you need to create a User Account first.<br />
              Registration is easy and only takes a few minutes.<br />
              <br />
              <div id="message_box_area">
			  <div class="message_box">
			  		<div class="top"> </div>
					<div class="mid">
					<h1>REGISTER AS A BUYER</h1>
					<p>Save searches to your wish list and from there create simple quotations.</p><br/><br/>
					<a href="<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>/signup/?guest=Y"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/sign-up-button.png" border="" /></a></div>
					<div class="bottom"> </div>
			  </div>
			  <div class="message_box">
			  		<div class="top"> </div>
					<div class="mid"><h1>REGISTER AS A SUPPLIER</h1>
<p>Subscribe to either Building Supplies or Services to advertise either prices of products you sell or services you offer, or simply advertise in Classified Ads.</p>
<a href="<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>/signup/"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/sign-up-button.png" border="" /></a>
</div>
					<div class="bottom"> </div>
			  </div>
			  </div>
              <input id="lfrom" name="lfrom" value="<?php echo $_REQUEST['lfrom'];?>" type="hidden"/>
            </div>
 
          </div>
        </div>
      </div>
      <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
    </div>
  </div>
</div>
