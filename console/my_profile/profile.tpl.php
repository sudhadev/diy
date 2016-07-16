<?php
	/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>      				'
  '    FILE            :  profile.tpl.php                                  	'
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

 	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
 	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
	if(!is_object($objCustomer))
	{
		$objCustomer= new Customer;
	}
	if (!is_object($objComponent))
	{
		$objComponent = new Component();
	}
 	
 	$customerData=$objCustomer->getCustomerData($objCore->sessCusId);
 	$customerInfo = $customerData[0];
 	require_once($objCore->_SYS['PATH']['CLASS_COUNTRY']); 
	$objCountry=new Country();
	require_once($objCore->_SYS['PATH']['CLASS_GEO']);
	$formName = "address_details"; // Form Name
	$submissionType = "ajax";
	$ajaxFunction = "callAjax();";
	$mapsUrl = $objCore->_SYS['GEO']['URL']; // Google Maps URL  
	$apiKey = $objCore->_SYS['GEO']['KEY']; // Google Maps API Key for the Server
	$objGeo = new Geo(); // Creating an Object of Geo Class 
	$map = $objGeo->getCoordinates($formName, $submissionType, $ajaxFunction, $apiKey, $mapsUrl); // Calling the method getCoordinates()   
?>
<!-- START CONTENT AREA-->

<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_middlebar">
      
      <!-- $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ -->
      <fieldset  id="page-middle-middle-content">
      <div id="main_form_bg_middlebar">
          <?php
          if($msg)
            echo $objCore->msgBox("CUSTOMER",$msg,'96%');
          ?>
                 <!---------------------------------------------------------------------------------------------------->
                  <div id="banner_add_cads">ADD NEW CUSTOMER</div>
                  <div id="text_area_add_cads" style="visibility: hidden;">
                    <div class="common_text">
<!--                        Below are the account details held at present. If your would like to change any information, click on either of the tabs, Personal Details, Address or Contact Details, change the relevant information and press the "submit" button.  </div>-->
                  If your would like to change any information, click on either of the tabs, Personal Details,  Address, Contact Details or Business Details to change the relevant information and then press the "submit" button.
                    
                    </div>
                      </div>
                  <div id="list_add_cads">
                    <div align="left">
                      <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                        <tbody>
                          <tr>
                            <td>
								<div class="add_classified_formmain">
								<div class="configure_quot_tabs">
                                <div class="myprofile_tabs_personal_details  cursorHand" id="tabProfilePersonal" onClick="showProfilePersonal();"> </div>
								<div class="myprofile_tabs_address address_inactive cursorHand" id="tabProfileAddress" onClick="showProfileAddress();"> </div>
								<div class="myprofile_tabs_contacts contacts_inactive cursorHand" id="tabProfileContact" onClick="showProfileContact();"> </div>
                                                                <div class="myprofile_tabs_business business_inactive cursorHand" id="tabProfileBusiness" onClick="showProfileBusiness();"> </div>
								</div>
                                <div class="configure_quot_frame_top"> </div>


								     <div class="add_classified_formmiddle" style="display: block;" id="divProfilePersonal">
                                          <!--  personal data -->
                                                        	 <div id="personal_result"  style="margin-right:10px;"></div>
                                                        <form id="personal_details" name="address_details" method="POST" action="">
                                                          <div class="" style="margin-top:15px;">
                                                            <div class="text_fieldBlock_left">Title:</div>
                                                            <div class="text_fieldBlock_right">
                                                            <?php 	 echo $objComponent->drop('title', $title, array(
                                                                        ""=>"--",
                                                                        "Mr."=>"Mr.",
                                                                        "Miss."=>"Miss.",
                                                                        "Mrs."=>"Mrs.",
                                                                        "Dr."=>"Dr."
                                                                    ), 'myprof_editdetails_mrtxtfield', '');
                                                            ?>
                                                            </div>
                                                            
                                                            <div class="text_fieldBlock_left">Type:</div>
                                                            <div class="text_fieldBlock_right">
                                                            <?php 	 echo $objComponent->drop('type', $type, array(
                                                                        
                                                                        "M"=>"Supplies",
                                                                        "S"=>"Services",
                                                                    ), 'myprof_editdetails_mrtxtfield', '');
                                                            ?>
                                                            </div>
                                                            
                                                            <div class="text_fieldBlock_left">First Name:</div>
                                                            <div class="text_fieldBlock_right">
                                                              <label>
                                                                  <input name="fName" type="text" id="fName" class="myprof_editdetails_txtfield" value="<?php echo ucwords($fname); ?>"/>
                                                              </label>
                                                                  </div>
                                                            <div class="text_fieldBlock_left">Last Name:</div>
                                                            <div class="text_fieldBlock_right">
                                                              <label>
                                                              <input name="lName" type="text" id="lName" class="myprof_editdetails_txtfield" value="<?php echo ucwords($lname); ?>"/>
                                                              </label>
                                                                  </div>
                                                            <div class="text_fieldBlock_left">E-mail:</div>
                                                            <div class="text_fieldBlock_right">
                                                              <label>
                                                                  <input name="email" type="text" id="email" class="myprof_editdetails_txtfield" value="<?php echo $email; ?>"/>
                                                              </label>
                                                                  </div>
                                                            <div class="text_fieldBlock_left">Confirm E-mail:</div>
                                                            <div class="text_fieldBlock_right">
                                                              <label>
                                                              <input name="emailConfirm" type="text" id="emailConfirm" class="myprof_editdetails_txtfield" value="<?php echo $email; ?>"/>
                                                              </label>
                                                                  </div>
                                                            <div class="text_fieldBlock_left">Password:</div>
                                                            <div class="text_fieldBlock_right">
                                                              <label>
                                                              <input name="password" type="password" id="emailConfirm" class="myprof_editdetails_txtfield" value="<?php echo $password; ?>"/>
                                                              </label>
                                                                  </div>
                                                          </div>
<!--                                                          <label id="submit_contact_details" ><img style="margin: 40px 0px 0px 20px;" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="" 
                                                                                                   onClick="updatePersonal('<?php echo $objCore->sessCusId; ?>', document.personal_details.title.value, document.personal_details.fName.value, document.personal_details.lName.value, document.personal_details.email.value, document.personal_details.emailConfirm.value)"/></label>
                                                        </form>-->

                                          <!-- / personal data -->
                                     </div>
								     <div class="add_classified_formmiddle" style="display: none;" id="divProfileAddress">
                                           <!-- Address data -->
         
                <div id="address_result"  style="margin-right:10px;"></div>
                <!--<form id="address_details" name="address_details" method="POST" action="">-->
                  <div class="option_form_catagories" style="border:none"> </div>
                    <div class="text_fieldBlock_left">Company:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="company" type="text" maxlength="27" id="company"  class="myprof_editdetails_txtfield myprof_editdetails_txtfield_company" value="<?php echo $company; ?>"/>
                      <div id="myprof_editdetails_txtfield_text_block"></div>
                      </label>
                    </div>
                    <div class="text_fieldBlock_left">Address:</div>
                    <div class="text_fieldBlock_right">
                      <label>
                      <input name="address" type="text" id="address" class="myprof_editdetails_txtfield" style="text-transform: capitalize;" value="<?php echo ucwords($address); ?>"/>
                      </label>
             
                  </div>
                  <div class="text_fieldBlock_left">Street:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <input name="street" type="text" id="street" class="myprof_editdetails_txtfield" style="text-transform: capitalize;" value="<?php echo ucwords($street); ?>"/>
                    </label>
                    <br />
						  </div>
                  <div class="text_fieldBlock_left">City:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <input name="city" type="text"  id="city" class="myprof_editdetails_txtfield" style="text-transform: capitalize;" value="<?php echo ucwords($city); ?>"/>
                    </label>
                    <br />
						  </div>
                  <div class="text_fieldBlock_left">Post Code:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                        <input type="text" name="postcode" id="postcode" class="myprof_editdetails_txtfield" style="text-transform:  uppercase;" value="<?php echo strtoupper($postcode); ?>"/>
                    </label>
                  </div>
                  <div class="text_fieldBlock_left">Country:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <?php $objCountry->style='myprof_editdetails_txtfield'; // css style for country drop down
									$objCountry->name='country'; // name of the drop down
									$objCountry->ln='en';
									$objCountry->event='';

									echo $objCountry->drop($country, $objCountry->ln, $objCountry->event);
							?>
                    </label>
						</div>
						<!-- Hidden field for Latitude -->
                  <input type="hidden" id="confirmedLatitude" name="confirmedLatitude" value="<?php echo $latitude; ?>">
                  <!-- Hidden field for Longitude -->
                  <input type="hidden" id="confirmedLongitude" name="confirmedLongitude" value="<?php echo $longitude; ?>">
                  <input type="hidden" id="customerId" name="customerId" value="">
                  
                   <label id="submit_contact_details">
                      <input type="button" name="submit" value="See Map" style="margin: 40px 0px 0px 20px;" 
                             onClick="initialize();fixed_map_location();showMap();"></label>
                      
                      
<!--                  <label id="submit_contact_details">
                      <img style="margin: 40px 0px 0px 20px;" 
                           src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" 
                           border="" 
                           onClick="initialize(); 
                              fixed_map_location();
                               showMap();
                   "/>
                      
                       showAddress(document.<?=$formName; ?>.address.value+' '+document.<?=$formName; ?>.street.value+' '+document.<?=$formName; ?>.city.value+' '+document.<?=$formName; ?>.country.value+' '+document.<?=$formName; ?>.postcode.value);  
                  </label>-->
                  <div id="map"> <?php echo $map; ?> </div>
                <!--</form>-->

                                           
                                           <!-- /Address data -->
                                     </div>
								     <div class="add_classified_formmiddle" style="display: none;" id="divProfileContact">
                                            <!-- Contact data -->
                 	 <div id="contact_result"  style="margin-right:10px;"></div>
                <!--<form id="contact_details" name="contact_details" method="POST" action="">-->
                  <div class="option_form_catagories" style="border:none"></div>
                  <div class="text_fieldBlock_left">Phone:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <input type="text" name="phone" id="phone" class="myprof_editdetails_txtfield" value="<?php echo $phone; ?>"/>
                    </label>
						</div>
                  <div class="text_fieldBlock_left">Fax:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <input type="text" name="fax" id="fax" class="myprof_editdetails_txtfield" value="<?php echo $fax; ?>"/>
                    </label>
                  </div>
                  <div class="text_fieldBlock_left">Mobile:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <input type="text" name="mobile" id="mobile" class="myprof_editdetails_txtfield" value="<?php echo $mobile; ?>"/>
                    </label>
                  </div>
                  <!--<label id="submit_contact_details"><img style="margin: 40px 0px 0px 20px;" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="" onClick="updateContact('<?php echo $objCore->sessCusId; ?>', document.contact_details.phone.value, document.contact_details.fax.value, document.contact_details.mobile.value)"/></label>-->


                <!--</form>-->
                                             
                                            <!-- /Contact data -->
                                     </div>


								
                                 <div class="add_classified_formmiddle" style="display: none;" id="divProfileBusiness">
                                            <!-- Business data -->
                 	 <div id="business_result"  style="margin-right:10px;"></div>
                <!--<form id="business_details" name="business_details" method="POST" action="">-->
                    <?php 
                      /*  $time_array = array();
                        $time_array = array(0=>'Closed');
                        
                        $e=6;                        
                        for($i=6;$i<24;$i++){
                            $time_array[$e] = $i.':00';
                            $e++;
                            $time_array[$e] = $i.':30';
                            $e++;
                        }*/
                    
                        $time_array=$objCustomer->time_array();
                        
                        //print_r($time_array);
                        
                        $mon_det = explode('_', $mon);
                        $sat_det = explode('_', $sat);
                        $sun_det = explode('_', $sun);
                        
                        ?>
                  <div class="option_form_catagories" style="border:none;"><div id="banner_add_cads" style="width:480px;">ADD YOUR WEBSITE ADDRESS AND OPENING TIMES</div></div>
                  
                  <div class="text_fieldBlock_left">Website:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <input type="text" name="website" id="website" value="<?php echo $website;?>" class="myprof_editdetails_mrtxtfield" style="width:150px;"/>
                        
                    </label>
                  </div>
                   <div class="text_fieldBlock_left" style="display: none;">Which listings would you like you website link to appear on :</div>
                  <div class="text_fieldBlock_right" style="display: none;">
                      <table><tr><td>
                                   <span style="    font-family: Tahoma,Arial,Helvetica,sans-serif;
    font-size: 13px;
   ">
                                       
                  <?php
                  
                 
                  $stat_L = "";
                  $stat_C = "";
                  
                  if((substr($customerInfo[22], 0, 1))==1){
                      $stat_L = "checked";
                  }
                  if(substr($customerInfo[22], 2)){
                      $stat_C = "checked";
                  }
                  
                 
                  if($customerInfo[12]=="S") echo "Services"; else echo "Supplies";
                  ?>
                                  </span></td>
                                  <td style="text-align: right;">
                                      
                    <label>&nbsp;<input type="checkbox" name="listing" id="listing" onclick="changestatus('listing','list_st');" <?php echo $stat_L; ?>/></label><br/>        
                    </td></tr>
                      <tr><td>
                    <span style="    font-family: Tahoma,Arial,Helvetica,sans-serif;
    font-size: 13px;
    ">Classified Ads&nbsp;</span></td><td style="text-align: right;">
                         <label><input type="checkbox" name="class_ad" id="class_ad" onclick="changestatus('class_ad','class_st');" <?php echo $stat_C; ?>/> </label>     
                   </td></tr>
                      </table>
                  </div>
                   <input type="hidden" name="list_st" id="list_st" value=""/>
                      <input type="hidden" name="class_st" id="class_st" value=""/>
                  <div class="text_fieldBlock_left">Monday To Friday:</div>
                  <div class="text_fieldBlock_right">
                    <label>  
                        <select name="mon_open" id="mon_open" class="myprof_editdetails_mrtxtfield" style="width:65px;">
                        <?php
                        foreach($time_array as $key=>$vals){
                            if($key==$mon_det[0]){
                                echo '<option value="'.$key.'" selected>'.$vals.'</option>';
                            }
                            else{
                                echo '<option value="'.$key.'">'.$vals.'</option>';
                            }
                            
                        }
                        ?>
                            </select>
                    </label>
                      
                      <label>  
                        <select name="mon_close" id="mon_close" class="myprof_editdetails_mrtxtfield" style="width:65px;">
                        <?php
                       foreach($time_array as $key=>$vals){
                            if($key==$mon_det[1]){
                                 echo '<option value="'.$key.'" selected>'.$vals.'</option>';
                            }
                            else{
                                echo '<option value="'.$key.'">'.$vals.'</option>';
                            }
                        }
                        ?>
                            </select>
                    </label>
                      
						</div>
                  <div class="text_fieldBlock_left">Saturday:</div>
                  <div class="text_fieldBlock_right">
                    <label>
                    <select name="sat_open" id="sat_open" class="myprof_editdetails_mrtxtfield" style="width:65px;">
                        <?php
                        foreach($time_array as $key=>$vals){
                            if($key==$sat_det[0]){
                                  echo '<option value="'.$key.'" selected>'.$vals.'</option>';
                            }
                            else{
                                echo '<option value="'.$key.'">'.$vals.'</option>';
                            }
                        }
                        ?>
                            </select>
                        </label>
                      <label>
                        <select name="sat_close" id="sat_close" class="myprof_editdetails_mrtxtfield" style="width:65px;">
                        <?php
                        foreach($time_array as $key=>$vals){
                           if($key==$sat_det[1]){
                                  echo '<option value="'.$key.'" selected>'.$vals.'</option>';
                            }
                            else{
                                echo '<option value="'.$key.'">'.$vals.'</option>';
                            }
                        }
                        ?>
                            </select>
                    </label>
                  </div>
                  <div class="text_fieldBlock_left">Sunday:</div>
                  <div class="text_fieldBlock_right">
                     <label>
                    <select name="sun_open" id="sun_open" class="myprof_editdetails_mrtxtfield" style="width:65px;">
                        <?php
                        foreach($time_array as $key=>$vals){
                            if($key==$sun_det[0]){
                                  echo '<option value="'.$key.'" selected>'.$vals.'</option>';
                            }
                            else{
                                echo '<option value="'.$key.'">'.$vals.'</option>';
                            }
                        }
                        ?>
                            </select>
                        </label>
                      
                      <label>
                        <select name="sun_close" id="sun_close" class="myprof_editdetails_mrtxtfield" style="width:65px;">
                        <?php
                        foreach($time_array as $key=>$vals){
                           if($key==$sun_det[1]){
                                  echo '<option value="'.$key.'" selected>'.$vals.'</option>';
                            }
                            else{
                                echo '<option value="'.$key.'">'.$vals.'</option>';
                            }
                        }
                        ?>
                            </select>
                    </label><br/><br/>
                      <label id="submit_contact_details">
                      <input type="submit" name="submit" value="Submit" style="margin: 40px 0px 0px 20px;"></label>
                  </div>
                  
                  
<!-- <label id="submit_contact_details"><img style="margin: 40px 0px 0px 20px;" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="" onClick="alert(document.business_details.list_st.value+'_'+document.business_details.class_st.value)"/></label>-->

                </form>
                                             
                                            <!-- /Business Data -->
                                     </div>

						</div>
                        <div class="add_classified_formbottom"/>
                        </td>
                          </tr>
                          <tr>
                            <td height="10">
                          </td></tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!---------------------------------------------------------------------------------------------------->
                </div>
      </fieldset>
      </div>
  </div>
</div>
<script type="text/javascript" language="javascript"> 
//animatedcollapse.toggle('personal');
</script>
<script>
    function changestatus(divId,divTrgt){
    
    if(document.getElementById(divId).checked)
        document.getElementById(divTrgt).value = '1';
        else
             document.getElementById(divTrgt).value = '0';
        
    
}
    </script>
<!-- END CONTENT AREA-->
