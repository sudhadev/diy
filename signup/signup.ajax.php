<?php
	if ($_SERVER["REQUEST_METHOD"] <> "POST") 
 		die("Access Denied");
 	
 	require_once("../classes/core/core.class.php");
 	$objCore=new Core;
	require_once($objCore->_SYS['PATH']['CLASS_GEO']); //Making a referance to Geo Class 
	require_once($objCore->_SYS['PATH']['CLASS_COUNTRY']);
	$objCountry=new Country;
	
 	$formName = "reg"; // Registration Form Name 
	$submitButtonName = "register"; // Submit Button Name
	$mapsUrl = $objCore->_SYS['GEO']['URL']; // Google Maps URL  
	$apiKey = $objCore->_SYS['GEO']['KEY']; // Google Maps API Key for the Server 

	$objGeo = new Geo(); // Creating an Object from Geo Class 
	$map = $objGeo->getCoordinates($formName, '', '',$apiKey, $mapsUrl); // Calling the method getCoordinates() 
?>

<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">
        <div id="outer">
          <div id="outer_middle">
            <div id="banner" align="center">REGISTRATION</div>
             <div id="text_area" class="common_text"> 
              <div id="option_form">
              	<div id="validate"></div>
                <form id="<?=$formName; ?>" name="<?=$formName; ?>" method="POST" action="index.php">
                  <div class="option_form_catagori_head">PERSONAL DETAILS</div>
                  <div class="option_form_catagories">
                    <div class="text_fieldBlock_left">Title:</div>
                    <div class="text_fieldBlock_right">
                      <select name="title" id="title" >
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
                      <input name="fName" type="text" id="fName" size="20" onBlur="validate(this.id, this.value);"/>
                      </label>
                      <br /> 
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.</div>
                    <div class="text_fieldBlock_left">Last Name:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="lName" type="text" id="lName" size="30" onBlur="validate(this.id, this.value);"/>
                      </label>
                      <br /> 
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.</div>
                    <div class="text_fieldBlock_left">E-mail:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="email" type="text" id="email" size="30" onBlur="var validated = validate(this.id, this.value); if (validated) validateEmail(this.value, document.<?=$formName; ?>.emailConfirm.value);"/>
                      </label>
                      <br />
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.</div>
                    <div class="text_fieldBlock_left">Confirm E-mail:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="emailConfirm" type="text" id="emailConfirm" size="30" onBlur="var validated = validate(this.id, this.value); if (validated) validateEmail(document.<?=$formName; ?>.email.value, this.value);"/>
                      </label>
                      <br />
                      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.</div>
                    <div class="text_fieldBlock_left">Password:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="password" type="password" id="password" size="20" onBlur="var validated = validate(this.id, this.value); if (validated) validatePassword(this.value, document.<?=$formName; ?>.confirmPassword.value);"/>
                      </label>
                      <br /> 
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.</div>
                    <div class="text_fieldBlock_left">Confirm Password:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="confirmPassword" type="password" id="confirmPassword" size="20" onBlur="var validated = validate(this.id, this.value); if (validated) validatePassword(document.<?=$formName; ?>.password.value, this.value);"/>
                      </label>
                      <br /> 
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.</div>
                  <div class="option_form_catagori_head">ADDRESS</div>
                  <div class="option_form_catagories">
                    <div class="text_fieldBlock_left">Company:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="company" type="text" id="company" size="30"/>
                      </label>
                    </div>
                    <div class="text_fieldBlock_left">Address:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="address" type="text" id="address" size="30" onBlur="validate(this.id, this.value);"/>
                      </label>
                      <br /> 
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.</div>
                  </div>
                  <div class="text_fieldBlock_left">Street:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <input name="street" type="text" id="street" size="25" onBlur="validate(this.id, this.value);"/>
                    </label>
                      <br /> 
                     Street</div>
                  <div class="text_fieldBlock_left">City:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <input name="city" type="text"  id="city" size="20" onBlur="validate(this.id, this.value);"/>
                    </label>
                      <br /> 
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.</div>
                  <div class="text_fieldBlock_left">Post Code:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <input type="text" name="postcode" id="postcode" />
                    </label>
                  </div>
                  <div class="text_fieldBlock_left">Country:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    	<?php $objCountry->style=''; // css style for country drop down
									$objCountry->name='country'; // name of the drop down
									$objCountry->ln='en';
									$objCountry->event='onChange="validate(this.id, this.value);"';
									echo $objCountry->drop('UK', $objCountry->ln, $objCountry->event);
							?> 
                    </label>
                      <br /> 
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.</div>
                  <div class="option_form_catagori_head">CONTACT DETAILS</div>
                  <div class="option_form_catagories">
                    <div class="text_fieldBlock_left">Phone:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input type="text" name="phone" id="phone" onBlur="validate(this.id, this.value);"/>
                      </label>
                      <br /> 
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.</div>
                    <div class="text_fieldBlock_left">Fax:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input type="text" name="fax" id="fax" />
                      </label>
                    </div>
                    <div class="text_fieldBlock_left">Mobile:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input type="text" name="mobile" id="mobile" />
                      </label>
                    </div>
                  </div>
                  <br/>
                  <div class="option_form_catagori_head">SYSTEMS</div>
                  <div class="option_form_catagories">
                    <div class="text_fieldBlock_left_capture_text">Entering this code you help  <b>DIY PIRCE CHECK</b> to prevent spam and fake registrations.</div>
                    <div class="text_fieldBlock_left_capture"><img id="captcha" src="captcha.php" /><a class="text_fieldBlock_left_capture_text" href="javascript:reloadCaptcha();">Try a new code</a></div>
                    
                    <div class="text_fieldBlock_right_capture">
                      <label>
                      <input type="text" name="security_code" id="security_code"  onChange="if(this.value.length==8){requestCaptcha(this.value, 'validate');}"/>
                      </label>
                      <br /> 
                     Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur vehicula nunc in nunc.</div>
                  <input type="hidden" id="cusType" name="cusType" value="">
                  <!-- Hidden field for Customer type. Supplier/Buyer  -->
                  <input type="hidden" id="confirmedLatitude" name="confirmedLatitude" value="">
                  <!-- Hidden field for Latitude -->
                  <input type="hidden" id="confirmedLongitude" name="confirmedLongitude" value="">
                  <!-- Hidden field for Longitude -->
                  <input type="hidden" id="action" name="action" value="register">
                  <input type="hidden" id="f" name="f" value="">
                  <!-- Hidden fields for subscription options -->
                  <input type="hidden" id="materials" name="materials" value="">
                  	<input type="hidden" id="gold" name="gold" value="">
                  	<input type="hidden" id="silver" name="silver" value="">
                  	<input type="hidden" id="bronze" name="bronze" value="">
                  <input type="hidden" id="services" name="services" value="">
                  <input type="hidden" id="classifiedAds" name="classifiedAds" value="">
                  </div>
                  <div id="submit" class="submit_butten" align="left">
                  <label id="validationOk" style="display:block"></label>
                  <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="" onClick="initialize(); showAddress(document.<?=$formName; ?>.address.value+' '+document.<?=$formName; ?>.street.value+' '+document.<?=$formName; ?>.city.value+' '+document.<?=$formName; ?>.country.value); showMap(); return false;"/>
                  <label id="validationFailed" style="display:none"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit_blink.jpg" border="" /></label>
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
