<?php
session_start();
	require_once("../classes/core/core.class.php");
	$objCore = new Core;
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	
	$objCustomer = new Customer();
	
	if ($_SERVER["REQUEST_METHOD"] <> "POST")
	{
 		die("Access Denied");
 	}	 
        
        
        
        $fields = $_POST['fields'];
        
        
        
        $array = explode('||', $fields);
        
        $keys_array = array();
        $vals_array  = array();
        $is_submit = 'no';
        
        foreach($array as $vals){
            
            $split = explode('=', $vals, 2);
            
            array_push($keys_array, $split[0]);
            array_push($vals_array, $split[1]);
        }
             
        $fields_array = array();
        
        array_push( $fields_array,'nothing');
        
        $msg_array = array();
		
        if(in_array('fName',$keys_array )){
			$fNameError  = $objCustomer->checkfName($vals_array[0]);
                        
                        if($fNameError[0]!=''){
                        array_push($msg_array, $fNameError[0]);
                        array_push($fields_array,'fName');
                        }
                        else{
                            
                        }
        }
                
        if(in_array('lName',$keys_array )){
			$lNameError  = $objCustomer->checklName($vals_array[1]);
                        
                        if($lNameError[0]!=''){
			array_push($msg_array, $lNameError[0]);
                        array_push($fields_array,'lName');
                        }
                         else{
                            
                        }
        }
        
        if(in_array('email',$keys_array )){
                     
           if( $objCustomer->checkEmail($vals_array[2], $vals_array[3], 'email')!=''){
               $emailError = $objCustomer->checkEmail($vals_array[2], $vals_array[3], 'email');
               array_push($fields_array,'email');
               array_push($msg_array, $emailError[0]);
           }
           
           
           else if($objCustomer->checkEmail($vals_array[2], $vals_array[3], 'emailConfirm') !='')
           {
           $emailError = $objCustomer->checkEmail($vals_array[2], $vals_array[3], 'emailConfirm');
           array_push($fields_array,'emailConfirm');
           array_push($msg_array, $emailError[0]);
           }
           
           
        
              else if($objCustomer->checkEmail($vals_array[2], $vals_array[3], '') !=''){
                   $emailError = $objCustomer->checkEmail($vals_array[2], $vals_array[3], '');
                   
                   array_push($fields_array,'email');
                   array_push($fields_array,'emailConfirm');
                   array_push($msg_array, $emailError[0]);
               }
        
           
           
                        else{
                            
                        }
        }
        
       if( in_array('password',$keys_array )){
           
                       if($objCustomer->checkPassword($vals_array[4], $vals_array[5], 'password' )!=''){
                         $passwordError = $objCustomer->checkPassword($vals_array[4], $vals_array[5], 'password' );
                         array_push($fields_array,'password');
                         array_push($msg_array, $passwordError[0]);
                       }
                        else if($objCustomer->checkPassword($vals_array[4], $vals_array[5], 'confirmPassword' )!=''){
                            $passwordError = $objCustomer->checkPassword($vals_array[4], $vals_array[5], 'confirmPassword' );
                            array_push($fields_array,'confirmPassword');
                            array_push($msg_array, $passwordError[0]);
                         
                        }
                       
                        else if($objCustomer->checkPassword($vals_array[4], $vals_array[5], '' )!=''){
                                $passwordError = $objCustomer->checkPassword($vals_array[4], $vals_array[5], '' );
                               
                                array_push($fields_array,'password');
                                array_push($fields_array,'confirmPassword');
                                array_push($msg_array, $passwordError[0]);           
                           
                        }
		
                        else{
                            
                        }
       }
       
//       if( in_array('company',$keys_array )){
//			$companyError = $objCustomer->checkCompany($vals_array[6]);
//                        
//                        if($companyError[0]!=''){
//			array_push($msg_array, $companyError[0]);
//                        array_push($fields_array,'company');
//                        }
//                        else{
//                            
//                        }
//       }
//       
//       if( in_array('address',$keys_array )){
//			$addressError = $objCustomer->checkAddress($vals_array[7]);
//                        
//                        if($addressError[0]!=''){
//			array_push($msg_array, $addressError[0]);
//                        array_push($fields_array,'address');
//                        }
//                        else{
//                            
//                        }
//       }
//       
//       if( in_array('street',$keys_array )){
//			$streetError = $objCustomer->checkStreet($vals_array[8]);
//                        
//                        if($streetError[0]!=''){
//			array_push($msg_array, $streetError[0]);
//                        array_push($fields_array,'street');
//                        }
//                        else{
//                            
//                        }
//       }
//       
//       if( in_array('city',$keys_array )){
//			$cityError = $objCustomer->checkCity($vals_array[9]);
//                        if($cityError[0]!=''){
//			array_push($msg_array, $cityError[0]);
//                        array_push($fields_array,'city');
//                        }
//                        else{
//                            
//                        }
//       }
//       
//       if( in_array('country',$keys_array )){
//			$countryError = $objCustomer->checkCountry($vals_array[10]);
//                        
//                        if($countryError[0]!=''){
//			array_push($msg_array, $countryError[0]);
//                        array_push($fields_array,'country');
//                        }
//                        else{
//                            
//                        }
//       }
//       
//       if( in_array('phone',$keys_array )){
//			$phoneError = $objCustomer->checkPhone($vals_array[11]);
//                        
//                        if($phoneError[0]!=''){
//			array_push($msg_array, $phoneError[0]);
//                        array_push($fields_array,'phone');
//                        }
//                        else{
//                            
//                        }
//       }
//       
//       if( in_array('mobile',$keys_array )){
//           if($vals_array[12]!=''){
//             $mobileError = $objCustomer->checkMobile($vals_array[12]);
//                        
//                        if($mobileError[0]!=''){
//			array_push($msg_array, $mobileError[0]);
//                        array_push($fields_array,'mobile');
//                        }  
//           }
//			
//                        else{
//                            
//                        }
//       }
//       
//       if( in_array('fax',$keys_array )){
//           if($vals_array[13]!=''){
//			$faxError = $objCustomer->checkFax($vals_array[13]);
//                        
//                        if($faxError[0]!=''){
//			array_push($msg_array, $faxError[0]);
//                        array_push($fields_array,'fax');
//                        }
//           }
//                        else{
//                            
//                        }
//       }

   if( in_array('security_code',$keys_array )){
   //  $img = ' CaptchaSecurityImages.php?width=150&height=40&characters=8';
       $is_submit = 'yes';
   if(($_SESSION['security_code'] == $vals_array[6]) && (!empty($_SESSION['security_code'])) ) {
 
      // Insert you code for processing the form here, e.g emailing the submission, entering it into a database. 
      unset($_SESSION['security_code']);
      
   } else {
       //array_push($msg_array, $faxError[0]);
       $captchaError = $objCustomer->checkCaptcha();
                           
			array_push($msg_array, $captchaError[0]);
                        array_push($fields_array,'security_code');
    
   }
   }
       
//       if( in_array('security_code',$keys_array )){
//			$captchaError = $objCustomer->checkCaptcha($vals_array[13]);
//                        
//                        if($captchaError[0]!=''){
//			array_push($msg_array, $captchaError[0]);
//                        array_push($fields_array,'security_code');
//                        }
//       }
       
       
                        foreach($msg_array as $vals){
                            $msg .= $objCore->_SYS['MSGS']['CUSTOMER'][$vals[1]][1];
                            $msg .= '<br/>';
                       }
                       
                       $err_header = "Please correct the following errors:";
                       
                   
                       //if(count($fields_array)>0){
                       foreach($fields_array as $vals){
                       $err_fields .= $vals.'|*|';
                       }
                       $err_fields = substr($err_fields, 0,strlen($err_fields)-3);
                       //}
       
                       //else{
                           //$err_fields = 'nothing';
                       //}
                       $msg_box = '<div class="msgBox" style="height: auto;padding-bottom: 5px;"> <div style="position:relative;"><strong>'.$err_header.'</strong> <a id="view_errors" onclick="slide();" style="position:absolute;right:20px;cursor:pointer;">View Details</a></div>
                        <div id="err_messages" style="display:none;"><span style="color: red;">'.$msg.'</span></div>    
                        </div>';
                       
//                       foreach($vals_array as $vals){
//                       $err_fields .= $vals.'|*|';
//                       }
                       
                       
                       
		if ($msg)
  		{
			echo $msg_box.'||'.$err_fields.'||'.$is_submit;
                        
		}
		else 
		{
			echo 'suceess||nothing||'.$is_submit;
		}
        

?>