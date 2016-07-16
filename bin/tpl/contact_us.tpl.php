<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  /bin/tpl/contact_us.tpl.php                         '
  '    PURPOSE         :  display contact_us template                         '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

?>

<div id="right_bar_middle">
<div id="main_form_bg">
<div id="main_form_bg_middle">
<div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
<div id="main_form_bg_middlebar">
<div id="outer">
<div id="outer_middle">
<div id="banner" align="center">CONTACT US</div>
<div id="text_area" class="common_text"> 
<strong><?php echo $objCore->gConf['DIY_COMPANY_NAME'];?></strong>
  <br />
  <?php
      if($objCore->gConf['DIY_ADDRESS']) $diyDetails= $objCore->gConf['DIY_ADDRESS']."<br />";
      if($objCore->gConf['DIY_STREET']) $diyDetails.= $objCore->gConf['DIY_STREET']."<br />";
      if($objCore->gConf['DIY_CITY']) $diyDetails.= $objCore->gConf['DIY_CITY']."<br />";
      if($objCore->gConf['DIY_COUNTRY']) $diyDetails.= $objCore->gConf['DIY_COUNTRY']."<br />";
      if($objCore->gConf['DIY_POSTAL']) $diyDetails.= $objCore->gConf['DIY_POSTAL']."<br />";


      echo $diyDetails;

  ?><br />
  <strong>
      <?php
          if($objCore->gConf['DIY_TELEPHONE']) $diyConDetails= "Telephone : ".$objCore->gConf['DIY_TELEPHONE']."<br />";
          if($objCore->gConf['DIY_FAX']) $diyConDetails.= "Fax : ".$objCore->gConf['DIY_FAX']."<br />";
          if($objCore->gConf['DIY_EMAIL']) $diyConDetails.= "Email : ".$objCore->gConf['DIY_EMAIL']."<br />";
        echo $diyConDetails
      ?>
  </strong>
 <div id="contact_us_form"> 
   <br />
 <div id="contact_us_form_heading">CONTACT DETAILS
 </div>
 
<!--<div id="divCaptcha"></div>-->

 <div id="contact_us_form_middle" style="width:600px;">
<div id="message_holder">
	<div id="error_msg" style="width:500px; margin-left:8px"></div>
	<table width="98%" border="0" align="center">
		<tr>
			<td class="" style="padding-top:10px;"><div id="divProcess">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Please wait...</div></td>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table> 
</div>
   <form id="frmContactUs" name="frmContactUs" method="post" action="">
    
     <div class="contact_fieldBlock_left">Subject:<span class="required_fields">*</span></div>
     <div class="contact_fieldBlock_right">
    <label>
    
    <input name="subject" type="text" id="subject" class="contactus_txtfield" value="<?php echo $_POST['subject'];?>"/>
    </label>
  </div>
  <div class="contact_fieldBlock_left">First Name:<span class="required_fields">*</span></div>
  <div class="contact_fieldBlock_right">
    <label>
    
    <input name="fname" type="text" id="fname" class="contactus_txtfield" value="<?php echo $_POST['fname'];?>" />
    </label>
  </div>
  <div class="contact_fieldBlock_left">Last Name:<span class="required_fields">*</span></div>
   <div class="contact_fieldBlock_right">
    <label>
    
    <input name="lname" type="text" id="lname" class="contactus_txtfield" value="<?php echo $_POST['lname'];?>"  />
    </label>
  </div>
    <div class="contact_fieldBlock_left">Contact Number:<span class="required_fields">*</span></div>
    <div class="contact_fieldBlock_right">
    <label>
    
    <input name="cno" type="text" id="cno" class="contactus_txtfield" value="<?php echo $_POST['cno'];?>" />
    </label>
  </div>
    <div class="contact_fieldBlock_left">Email Address:<span class="required_fields">*</span></div>
   <div class="contact_fieldBlock_right">
    <label>
    <input name="email" type="text" id="email" class="contactus_txtfield" value="<?php echo $_POST['email'];?>" />
    </label>
  </div>
  <div class="contact_fieldBlock_left">Organisation:</div>
   <div class="contact_fieldBlock_right">
    <label>
    <input name="organisation" type="text" id="organisation" class="contactus_txtfield" value="<?php echo $_POST['organisation'];?>" />
    </label>
  </div>
  <div class="contact_fieldBlock_left">How did you hear about us?<span class="required_fields">*</span></div>
   <div class="contact_fieldBlock_right">
   <label>
    <select name="select" id="select" onchange="displayTextBox();" class="contactus_txtfield">
		<option id="choose" value="" selected="selected">Choose One</option>
     	<option value="email">Email</option>
		<option value="newspaper">Newspaper</option>
		<option value="online">Online</option>
		<option value="radio">Radio</option>
		<option value="tv">TV</option>
		<option value="other">Other</option>
    </select>
    </label> 
	<div id="otherWay" >
		<label>
			<textarea name="textArea" id="textArea" class="contactus_txtfield" ></textarea>
		</label>
	</div>
  </div>
  <div class="contact_fieldBlock_left">Comments:</div>
   <div class="contact_fieldBlock_right">
    <label>
	<textarea name="comment" id="comment" class="contactus_txtfield"></textarea>
    </label>
  </div>
   <div class="contact_fieldBlock_left"><a href="javascript:getData();" ><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="0" width="81" height="25" /></a></div> 
     </form>
   </div>
    </div> 
 </div>
</div>
</div>
</div>
<div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
</div>
</div>
</div>