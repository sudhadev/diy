<?php
require_once($objCore->_SYS['PATH']['CLASS_GEO']); //Making a referance to Geo Class 
	require_once($objCore->_SYS['PATH']['CLASS_COUNTRY']);
	$objCountry=new Country;
 	$formName = "reg"; // Registration Form Name 
	$submitButtonName = "register"; // Submit Button Name
    if ($_REQUEST['guest'] != 'Y')
    {
	$mapsUrl = $objCore->_SYS['GEO']['URL']; // Google Maps URL  
	$apiKey = $objCore->_SYS['GEO']['KEY']; // Google Maps API Key for the Server 

	$objGeo = new Geo(); // Creating an Object from Geo Class 
	$map = $objGeo->getCoordinates($formName, '', '',$apiKey, $mapsUrl); // Calling the method getCoordinates()
?>

<?php//$image = 'CaptchaSecurityImages.php?width=150&height=40&characters=8'; 
////unset($_SESSION['security_code_new']);
//$image_new = '<img id="captcha" src="'.$image.'">';
//
//echo $image_new;
?>

<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">
        <div id="outer">
          <div id="outer_middle">
            <div id="banner" align="center"><?php if($_REQUEST['guest']=="BS") echo "Register as a supplier"; else echo "WELCOME" ; ?></div>
             <div id="text_area" class="common_text">
            
            <?php 
            if($_REQUEST['guest']=="BS") 
                echo $pageContents['textBuyerToSupplier'];
            elseif($_REQUEST['guest']=="AL")
                echo $pageContents['loggedinotheruser'];
            else
                echo $pageContents['textSupplier'];
            
            ?>

         
              <div id="option_form">
              	<div id="validate"></div>
                <form id="<?=$formName; ?>" name="<?=$formName; ?>" method="POST" action="?action=register">
                  <div class="option_form_catagori_head">PERSONAL DETAILS</div>
                  <div class="option_form_catagories">
                    <div class="text_fieldBlock_left">Title:</div>
                    <div class="text_fieldBlock_right">
                      <select name="title" id="title" class="myprof_editdetails_mrtxtfield" >
                        <option value="">--</option>
                        <option value="Mr.">Mr.</option>
                        <option value="Miss.">Miss.</option>
                        <option value="Mrs.">Mrs.</option>
                        <option value="Dr.">Dr.</option>
                      </select>
                    </div>
                    <div class="text_fieldBlock_left">First Name:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <!--<input name="fName" type="text" id="fName" class="signup_short_txtfields" size="20" onBlur="validate(this.id, this.value);"/>-->
                      <input name="fName" type="text" id="fName" class="signup_short_txtfields" size="20" onfocus="removeMyClass(this);"/>
                      </label>
                      <br /> 
                     </div>
                    <div class="text_fieldBlock_left">Last Name:</div>
                    
                    <div class="text_fieldBlock_right">
                      <label>
                      <!--<input name="lName" class="signup_txtfields" type="text" id="lName" size="30" onBlur="validate(this.id, this.value);"/>-->
                         
                      <input name="lName" class="signup_txtfields" type="text" id="lName" size="30" onfocus="removeMyClass(this);"/>
                      </label>
                      <br /> 
                      </div>
                    <div class="text_fieldBlock_left">E-mail:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <!--<input name="email" class="signup_txtfields" type="text" id="email" size="30" onBlur="var validated = validate(this.id, this.value); if (validated) validateEmail(this.value, document.<?=$formName; ?>.emailConfirm.value);"/>-->
                        <?php if(isset($_REQUEST['email'])){
                        ?>
                          <input name="email" class="signup_txtfields" type="text" id="email" size="30" value="<?php echo $_REQUEST['email']; ?>" onfocus="removeMyClass(this);" readonly="readonly"/>
                          <?php
                    }
                    else{
                        ?>
                          <input name="email" class="signup_txtfields" type="text" id="email" size="30" onfocus="removeMyClass(this);"/>
                          
                          <?php
                    }
?>
                          
                          
                      </label>
                      <br />
                      </div>
                    <div class="text_fieldBlock_left">Confirm E-mail:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                          <?php if(isset($_REQUEST['email'])){
                        ?>
                      <!--<input name="emailConfirm" class="signup_txtfields" type="text" id="emailConfirm" size="30" onBlur="var validated = validate(this.id, this.value); if (validated) validateEmail(document.<?=$formName; ?>.email.value, this.value);"/>-->
                        <input name="emailConfirm" class="signup_txtfields" type="text" id="emailConfirm" value="<?php echo $_REQUEST['email']; ?>" size="30" onfocus="removeMyClass(this);" readonly="readonly"/>
                        <?php
                    }
                    else{
                        ?>
                         <input name="emailConfirm" class="signup_txtfields" type="text" id="emailConfirm" size="30" onfocus="removeMyClass(this);"/>
                       
                          
                          <?php
                    }
?>
                      </label>
                      <br />
                      </div>
                    
                    <div class="text_fieldBlock_left">Password:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <!--<input name="password" type="password" class="signup_short_txtfields" id="password" size="20" onBlur="var validated = validate(this.id, this.value); if (validated) validatePassword(this.value, document.<?=$formName; ?>.confirmPassword.value);"/>-->
                      <input name="password" type="password" class="signup_short_txtfields" id="password" size="20" onfocus="removeMyClass(this);"/>
                      </label>
                      <br /> 
                     </div>
                    <div class="text_fieldBlock_left">Confirm Password:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <!--<input name="confirmPassword" class="signup_short_txtfields" type="password" id="confirmPassword" size="20" onBlur="var validated = validate(this.id, this.value); if (validated) validatePassword(document.<?=$formName; ?>.password.value, this.value);"/>-->
                      <input name="confirmPassword" class="signup_short_txtfields" type="password" id="confirmPassword" size="20" onfocus="removeMyClass(this);"/>
                      </label>
                      <br /> 
                     </div>
                  <div class="option_form_catagori_head">ADDRESS</div>
                  <div class="option_form_catagories">
                    <div class="text_fieldBlock_left">Company:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="company" type="text" class="signup_txtfields" id="company" size="30" onfocus="removeMyClass(this);"/>
                      </label>
                    </div>
                    <div class="text_fieldBlock_left" >Address:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <!--<input name="address" type="text" class="signup_txtfields" id="address" size="30" onBlur="validate(this.id, this.value);"/>-->
                      <input name="address" type="text" class="signup_txtfields" id="address" style="text-transform: capitalize;" size="30" onfocus="removeMyClass(this);"/>
                      </label>
                      <br /> 
                     </div>
                  </div>
                  <div class="text_fieldBlock_left">Street:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <!--<input name="street" type="text" id="street" class="signup_short_txtfields" size="25" onBlur="validate(this.id, this.value);"/>-->
                    <input name="street" type="text" id="street" class="signup_short_txtfields" style="text-transform: capitalize;" size="25" onfocus="removeMyClass(this);"/>
                    </label>
                      <br /> 
                     </div>
                  <div class="text_fieldBlock_left">City:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                   <!-- <input name="city" type="text"  id="city" class="signup_short_txtfields" size="20" onBlur="validate(this.id, this.value);"/>-->
                    <input name="city" type="text"  id="city" class="signup_short_txtfields" style="text-transform: capitalize;" size="20" onfocus="removeMyClass(this);"/>
                    </label>
                      <br /> 
                     </div>
                  <div class="text_fieldBlock_left">Post Code:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <input class="signup_short_txtfields" type="text" name="postcode" id="postcode" style="text-transform: uppercase;" onfocus="removeMyClass(this);"/>
                    </label>
                  </div>
                  <div class="text_fieldBlock_left">Country:</div>
                  <div class="text_fieldBlock_right">
                    <!--<label>
                    	<?php /*$objCountry->style='signup_txtfields'; // css style for country drop down
									$objCountry->name='country'; // name of the drop down
									$objCountry->ln='en';
									$objCountry->event='onChange="validate(this.id, this.value);"';
									echo $objCountry->drop('UK', $objCountry->ln, $objCountry->event);*/
							?> 
                    </label>-->
                    <label>
                    	<?php $objCountry->style='signup_txtfields'; // css style for country drop down
									$objCountry->name='country'; // name of the drop down
									$objCountry->ln='en';
									//$objCountry->event='onChange="validate(this.id, this.value);"';
									echo $objCountry->drop('UK', $objCountry->ln, $objCountry->event);
							?> 
                    </label>
                      <br /> 
                     </div>
                  <div class="option_form_catagori_head">CONTACT DETAILS</div>
                  <div class="option_form_catagories">
                    <div class="text_fieldBlock_left">Phone:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <!--<input type="text" name="phone" class="signup_short_txtfields" id="phone" onBlur="validate(this.id, this.value);"/>-->
                      <input type="text" name="phone" class="signup_short_txtfields" id="phone" onfocus="removeMyClass(this);"/>
                      </label>
                      <br /> 
                     </div>
                    <div class="text_fieldBlock_left">Fax:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input type="text" class="signup_short_txtfields" name="fax" id="fax" onfocus="removeMyClass(this);"/>
                      </label>
                    </div>
                    <div class="text_fieldBlock_left">Mobile:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input type="text" name="mobile" class="signup_short_txtfields" id="mobile" onfocus="removeMyClass(this);"/>
                      </label>
                    </div>
                  </div>
                  <br/>

                  
                  <div class="option_form_catagori_head">SYSTEMS</div>
                  <div class="option_form_catagories">
                    <div class="text_fieldBlock_left_capture_text">Entering this code you help  <b>DIY PRICE CHECK</b> to prevent spam and fake registrations.</div>
                    <div id="validate_captcha"></div>
                    <div class="text_fieldBlock_left_capture"><img src="captcha.php" id="captcha"><a class="text_fieldBlock_left_capture_text" href="javascript:reloadCaptcha();">Try a new code</a></div>
                    <div id="test"><?php //echo $_SESSION['security_code']; ?></div>
                    <div class="text_fieldBlock_right_capture">
                      <label>
                          <input type="text" class="signup_short_txtfields" name="security_code" id="security_code" 
                                                             onfocus="validate('fName='+document.reg.fName.value+//0
                                                                               '||lName='+document.reg.lName.value+//1
                                                                               '||email='+document.reg.email.value+//2
                                                                               '||emailConfirm='+document.reg.emailConfirm.value+//3
                                                                               '||password='+document.reg.password.value+//4
                                                                               '||confirmPassword='+document.reg.confirmPassword.value+//5
                                                                               '||company='+document.reg.company.value+//6
                                                                               '||address='+document.reg.address.value+//7
                                                                               '||street='+document.reg.street.value+//8
                                                                               '||city='+document.reg.city.value+//9
                                                                               '||postcode='+document.reg.postcode.value+//10
                                                                               '||country='+document.reg.country.value+//11
                                                                               '||phone='+document.reg.phone.value+//12
                                                                               '||mobile='+document.reg.mobile.value+//13
                                                                               '||fax='+document.reg.fax.value//14
                                                                               
                                                                           
                                                                               );" />
<!--                      <input type="text" class="signup_short_txtfields" name="security_code" id="security_code"/>-->
<!--                      <input type="hidden" name="captcha_value" id="captcha_value" value="requestCaptcha(document.reg.security_code.value, 'validate');">-->
                      </label>
                      <br /> 
                     </div>
                  <input type="hidden" id="cusType" name="cusType" value="S"/>
                  <!-- Hidden field for Customer type. Supplier/Buyer  -->
                  <input type="hidden" id="confirmedLatitude" name="confirmedLatitude" value=""/>
                  <!-- Hidden field for Latitude -->
                  <input type="hidden" id="confirmedLongitude" name="confirmedLongitude" value=""/>
                  <!-- Hidden field for Longitude -->
                  <input type="hidden" id="action" name="action" value="register"/>
                  <input type="hidden" id="f" name="f" value=""/>
                  <input type="hidden" id="session_captcha" name="session_captcha" value="no"/>
                  <?php
                  if(isset($_REQUEST['email'])){
                  ?>
                  <input type="hidden" id="promo_key" name="promo_key" value="<?php echo urldecode($_REQUEST['key']); ?>"/>
                  <input type="hidden" id="promo_code" name="promo_code" value="<?php echo urldecode($_REQUEST['code']); ?>"/>
                  <?php
                  }
                  ?>
                  
                 
                  </div>                  
                 
                  
                  <div id="submit" class="submit_butten" align="left" >
                      <span id="checkbox" style="display:block;margin-bottom: 20px;">
                          <input type="checkbox" id="terms" name="terms" value="agree" onclick="checkStatus(this);" disabled/> &nbsp; I agree to the <a href="/registration_terms.php" target="_blank">DIY Registration Terms & Conditions</a>
                      
                      </span>
                      <span id="checkbox_en" style="display:none;margin-bottom: 20px;">
                          <input type="checkbox" id="terms" name="terms" value="agree" onclick="checkStatus(this);" style="outline:1px solid red;"/> &nbsp; I agree to the <a href="/registration_terms.php" target="_blank">DIY Registration Terms & Conditions</a>
                          
                      </span>
                      <input id="checkbox_status" type="hidden" val="no"/>
                      <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>"><img border="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/cancel.jpg"></a>
                
                      
                 <label id="validationOk" style="cursor:pointer;display: none;"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="" 
                                                                        onClick="validate('fName='+document.reg.fName.value+//0
                                                                               '||lName='+document.reg.lName.value+//1
                                                                               '||email='+document.reg.email.value+//2
                                                                               '||emailConfirm='+document.reg.emailConfirm.value+//3
                                                                               '||password='+document.reg.password.value+//4
                                                                               '||confirmPassword='+document.reg.confirmPassword.value+//5
                                                                               '||company='+document.reg.company.value+//6
                                                                               '||address='+document.reg.address.value+//7
                                                                               '||street='+document.reg.street.value+//8
                                                                               '||city='+document.reg.city.value+//9
                                                                               '||postcode='+document.reg.postcode.value+//10
                                                                               '||country='+document.reg.country.value+//11
                                                                               '||phone='+document.reg.phone.value+//12
                                                                               '||mobile='+document.reg.mobile.value+//13
                                                                               '||fax='+document.reg.fax.value+//14
                                                                               '||security_code='+document.reg.security_code.value//15
                                                                           
                                                                               );"
                                                                               
                                                                               
                                                                               
                                                                               /></label>
                      <label id="validationFailed" ><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit_blink.jpg" border="" /></label>
                  </div>
                  <div id="map"> <?php echo $map; ?> </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
    </div>
  </div>
</div>
<?php
    }
    else if ($_REQUEST['guest'] == 'Y')
    {
        $geoData = $objCore->sysVars['Geo'];
		if (!is_null($geoData))
		{
			$strGeo = explode("|DLM|", $geoData);
		}
?>
<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">
        <div id="outer">
          <div id="outer_middle">
            <div id="banner" align="center">WELCOME</div>
             <div id="text_area" class="common_text"><?php echo $pageContents['textBuyer'];?>
          
              <div id="option_form">
              	<div id="validate"><?php //if ($msg) echo $objCore->msgBox("CUSTOMER",$msg,'96%'); ?></div>
                <form id="<?=$formName; ?>" name="<?=$formName; ?>" method="POST" action="<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>/signup/?guest=Y">
 <div class="option_form_catagori_head">PERSONAL DETAILS</div>
                  <div class="option_form_catagories">
                    <div class="text_fieldBlock_left">Title:</div>
                    <div class="text_fieldBlock_right">
                      <select name="title" id="title" class="myprof_editdetails_mrtxtfield" >
                        <option value="">--</option>
                        <option value="Mr.">Mr.</option>
                        <option value="Miss.">Miss.</option>
                        <option value="Mrs.">Mrs.</option>
                        <option value="Dr.">Dr.</option>
                      </select>
                    </div>
                    <div class="text_fieldBlock_left">First Name:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="fName" type="text" id="fName" class="signup_short_txtfields" size="20"  value="" onfocus="removeMyClass(this);"/>
                      </label>
                      <br />
                     </div>
                    <div class="text_fieldBlock_left">Last Name:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="lName" class="signup_txtfields" type="text" id="lName" size="30"  value="" onfocus="removeMyClass(this);"/>
                      </label>
                      <br />
                      </div>
                    <div class="text_fieldBlock_left">E-mail:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="email" class="signup_txtfields" type="text" id="email" size="30" value="" onfocus="removeMyClass(this);"/>
                      </label>
                      <br />
                      </div>
                    <div class="text_fieldBlock_left">Confirm E-mail:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="emailConfirm" class="signup_txtfields" type="text" id="emailConfirm" size="30"  value="" onFocus="removeMyClass(this);"/>
                      </label>
                      <br />
                      </div>
                    <div class="text_fieldBlock_left">Password:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="password" class="signup_short_txtfields" type="password" id="password" size="20"  value="" onfocus="removeMyClass(this);"/>
                      </label>
                      <br />
                     </div>
                    <div class="text_fieldBlock_left">Confirm Password:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="confirmPassword" class="signup_short_txtfields" type="password" id="confirmPassword" size="20"  value="" onfocus="removeMyClass(this);"/>
                      </label>
                      <br /> 
                     </div>
                     <div class="option_form_catagori_head">SYSTEMS</div>
                  <div class="option_form_catagories">
                    <div class="text_fieldBlock_left_capture_text">Entering this code you help  <b>DIY PRICE CHECK</b> to prevent spam and fake registrations.</div>
                    <div class="text_fieldBlock_left_capture"><img id="captcha" src="captcha.php" /><a class="text_fieldBlock_left_capture_text" href="javascript:reloadCaptcha();">Try a new code</a></div>
                    <div class="text_fieldBlock_right_capture">
                      <label>
                      <input type="text" name="security_code" class="signup_short_txtfields" id="security_code" onfocus="validateBuyer('fName='+document.reg.fName.value+
                                                                               '||lName='+document.reg.lName.value+
                                                                               '||email='+document.reg.email.value+
                                                                               '||emailConfirm='+document.reg.emailConfirm.value+
                                                                               '||password='+document.reg.password.value+
                                                                               '||confirmPassword='+document.reg.confirmPassword.value
        
                                                                               );"/>
                      </label>
                      <br />
                     </div>
                    
                    
                  <input type="hidden" id="cusType" name="cusType" value="B">
                  <!-- Hidden field for Customer type. Supplier/Buyer  -->
                  <input type="hidden" id="confirmedLatitude" name="confirmedLatitude" value="<?php echo $strGeo[0]; ?>">
                  <!-- Hidden field for Latitude -->
                  <input type="hidden" id="confirmedLongitude" name="confirmedLongitude" value="<?php echo $strGeo[1]; ?>">
                  <!-- Hidden field for Longitude -->
                  <input type="hidden" id="action" name="action" value="register">
                  <input type="hidden" id="f" name="f" value="">
                 
                  </div>
                    
                     <?php //print_r($_SESSION); ?>
                  <div id="submit" class="submit_butten" align="left">
                      <span id="checkbox" style="display:block;margin-bottom: 20px;">
                          <input type="checkbox" id="terms" name="terms" value="agree" onclick="checkStatusBuyer(this);" disabled/> &nbsp; I agree to the <a href="/registration_terms.php" target="_blank">DIY Registration Terms & Conditions</a>
                      
                      </span>
                      <span id="checkbox_en" style="display:none;margin-bottom: 20px;">
                          <input type="checkbox" id="terms" name="terms" value="agree" onclick="checkStatusBuyer(this);" style="outline:1px solid red;"/> &nbsp; I agree to the <a href="/registration_terms.php" target="_blank">DIY Registration Terms & Conditions</a>
                      
                      </span>
                      
                      <input id="checkbox_status" type="hidden" val="no"/>
                        <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>"><img border="" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/cancel.jpg"></a>
                                                  
                  <label id="button" style="cursor:pointer;display:none;">
                      <img id="validation_button" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="" 
                                                                               onClick="validateBuyer('fName='+document.reg.fName.value+
                                                                               '||lName='+document.reg.lName.value+
                                                                               '||email='+document.reg.email.value+
                                                                               '||emailConfirm='+document.reg.emailConfirm.value+
                                                                               '||password='+document.reg.password.value+
                                                                               '||confirmPassword='+document.reg.confirmPassword.value+
                                                                               '||security_code='+document.reg.security_code.value
        
                                                                               );"/>
                      
<!--                      <input id="validation_button" width="81" type="image" height="25" border="0" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" 
                                                          onClick="validateBuyer('fName='+document.reg.fName.value+
                                                                               '||lName='+document.reg.lName.value+
                                                                               '||email='+document.reg.email.value+
                                                                               '||emailConfirm='+document.reg.emailConfirm.value+
                                                                               '||password='+document.reg.password.value+
                                                                               '||confirmPassword='+document.reg.confirmPassword.value+
                                                                               '||security_code='+document.reg.security_code.value
        
                                                                               );">-->
                  </label>
                         <label id="validationFailed" ><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit_blink.jpg" border="" /></label>
      
                  </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
    </div>
  </div>
</div>
<?php
    }
?>