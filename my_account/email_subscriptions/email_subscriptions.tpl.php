<?php
	/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.tekmaz.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Sudharahan Ramasubramaniam <sudharshan@tekmaz.com>      				'
  '    FILE            :  email_subscriptions.tpl.php                                  	'
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

 	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
 	
	if(!is_object($objCustomer))
	{
		$objCustomer= new Customer;
	}
	
 	$customerData=$objCustomer->getEmailSubscriptions($objCore->sessCusId);
 	$customerInfo = $customerData[0];
 	 
?>
<!-- START CONTENT AREA-->

<div id="right_bar_middle">
  <div id="main_form_bg">
    <div id="main_form_bg_middle">
      <div id="main_form_bg_topbar"> <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
      <div id="main_form_bg_middlebar">
      
      <!-- $$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$ -->
      
      <div id="main_form_bg_middlebar">
                  <!---------------------------------------------------------------------------------------------------->
                  <div id="banner_add_cads">CHANGE EMAIL SUBSCRIPTIONS</div>
                  <div id="text_area_add_cads">
                    <div class="common_text">Below are the current email subscription. To change the subscriptions please select the check boxes and press the "submit" button.  </div>
                  </div>
                  <div id="list_add_cads">
                    <div align="left">
                      <table width="100%" cellspacing="0" cellpadding="0" border="0" align="center">
                        <tbody>
                          <tr>
                            <td>
								<div class="add_classified_formmain">
								<div class="configure_quot_tabs">
                               
                                <div class="configure_quot_frame_top"> </div>


								     <div class="add_classified_formmiddle" style="display: block;" id="divProfilePersonal">
                                          <!--  personal data -->
                                                        	 <div id="email_subscription_result"  style="margin-right:10px;"></div>
                                                        <form id="email_subscriptions" name="email_subscriptions" method="POST" action="/my_account/?action=email_sub&f=email_subscriptions">
                                                          <div class="" style="margin-top:15px;">
                                                              
                                                              <?php
                                                             
                                                              $mandatory_fields = array('register');
                                                              
                                                              $labels = array('Order Products','Registration','Passsword','Expiration','Renewal','Promo code');
                                                              
                                                              $i = 0;
                                                              
                                                              foreach($customerInfo AS $key=>$vals){
                                                                  if($vals=='Y')
                                                                      $status = 'checked';
                                                                  else
                                                                      $status = '';
                                                                  if(in_array($key,$mandatory_fields)){
                                                                      $disabled = 'disabled';
                                                                  }
                                                                  else{
                                                                      $disabled = '';
                                                                  }
                                                                  if($key=='cus_Id'){
                                                                      echo '<input type="hidden" name="id" value="'.$vals.'"/>';
                                                                  }
                                                                  else{
                                                                      
                                                                       echo ' <div class="text_fieldBlock_left">'.ucwords($labels[$i]).'</div>
                                                            <div class="text_fieldBlock_right">
                                                            <input type="checkbox" name="'.$key.'" '.$status.' '.$disabled.'/>
                                                            </div>';
                                                                       $i++;
                                                                  }
                                                                 
                                                              }
                                                              
                                                              ?>
                                                              
<!--                                                            <div class="text_fieldBlock_left">Register</div>
                                                            <div class="text_fieldBlock_right">
                                                            <input type="checkbox" name="register" disabled/>
                                                            </div>
                                                            <div class="text_fieldBlock_left">Subscription</div>
                                                            <div class="text_fieldBlock_right">
                                                              <label>
                                                              <input type="checkbox" name="subscription" />    
                                                              </label>
                                                                  </div>
                                                            <div class="text_fieldBlock_left">Expiration</div>
                                                            <div class="text_fieldBlock_right">
                                                              <label>
                                                              <input type="checkbox" name="verification" />
                                                              </label>
                                                                  </div>
                                                            <div class="text_fieldBlock_left">Promocode</div>
                                                            <div class="text_fieldBlock_right">
                                                              <label>
                                                                  <input type="checkbox" name="promocode" /> </label>
                                                                  </div>
                                                            <div class="text_fieldBlock_left">Renewal</div>
                                                            <div class="text_fieldBlock_right">
                                                              <label>
                                                              <input type="checkbox" name="renew" /></label>
                                                                  </div>
                                                          </div>-->
                                                          <label id="submit_contact_details" ><img style="margin: 40px 0px 0px 20px;" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/submit.jpg" border="" 
                                                                                                   onClick="updateEmailSubscriptions(
                                                                                                       document.email_subscriptions.id.value,
                                                                                                       document.email_subscriptions.order.checked,
                                                                                                       document.email_subscriptions.password.checked, 
                                                                                                       document.email_subscriptions.expiration.checked, 
                                                                                                       document.email_subscriptions.renew.checked, 
                                                                                                       document.email_subscriptions.promo.checked 
                                                                                                       )"/>
                                                          <div id="preLoaderContainer" style="display:none;">
                                                                      
                                                                                        <img border="0" alt="Processing Image" title="Processing Image" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/icons/ajax-loader.gif">
                                                                                    
                                                                                      <span class="common_text">Processing ... Please wait.</span>
                                                              
                                                          
                                                          </label>
                     
                                                                    </div>
                                                        </form>

                                          <!-- / personal data -->
                                     </div>
								     
                </form>

                                           
                                           <!-- /Address data -->
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
      
     
      
      

      <div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
    </div>
  </div>
</div>
<script type="text/javascript" language="javascript"> 
//animatedcollapse.toggle('personal');
</script>
<!-- END CONTENT AREA-->

