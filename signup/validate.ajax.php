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
        
        foreach($array as $vals){
            
            $split = explode('=', $vals, 2);
            
            array_push($keys_array, $split[0]);
            array_push($vals_array, $split[1]);
        }
             
        $fields_array = array();
        
        array_push( $fields_array,'nothing');
        
        $msg_array = array();
        
        $is_submit = 'no';
		
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
       
       if( in_array('company',$keys_array )){
			$companyError = $objCustomer->checkCompany($vals_array[6]);
                        
                        if($companyError[0]!=''){
			array_push($msg_array, $companyError[0]);
                        array_push($fields_array,'company');
                        }
                        else{
                            
                        }
       }
       
       if( in_array('address',$keys_array )){
			$addressError = $objCustomer->checkAddress($vals_array[7]);
                        
                        if($addressError[0]!=''){
			array_push($msg_array, $addressError[0]);
                        array_push($fields_array,'address');
                        }
                        else{
                            
                        }
       }
       
       if( in_array('street',$keys_array )){
			$streetError = $objCustomer->checkStreet($vals_array[8]);
                        
                        if($streetError[0]!=''){
			array_push($msg_array, $streetError[0]);
                        array_push($fields_array,'street');
                        }
                        else{
                            
                        }
       }
       
       if( in_array('city',$keys_array )){
			$cityError = $objCustomer->checkCity($vals_array[9]);
                        if($cityError[0]!=''){
			array_push($msg_array, $cityError[0]);
                        array_push($fields_array,'city');
                        }
                        else{
                            
                        }
       }
       
        if( in_array('postcode',$keys_array )){
			$postcodeError = $objCustomer->checkPostcode($vals_array[10]);
                        if($postcodeError[0]!=''){
			array_push($msg_array, $postcodeError[0]);
                        array_push($fields_array,'postcode');
                        }
                        else{
                            
                        }
       }
       if( in_array('country',$keys_array )){
			$countryError = $objCustomer->checkCountry($vals_array[11]);
                        
                        if($countryError[0]!=''){
			array_push($msg_array, $countryError[0]);
                        array_push($fields_array,'country');
                        }
                        else{
                            
                        }
       }
       
       if( in_array('phone',$keys_array )){
			$phoneError = $objCustomer->checkPhone($vals_array[12]);
                        
                        if($phoneError[0]!=''){
			array_push($msg_array, $phoneError[0]);
                        array_push($fields_array,'phone');
                        }
                        else{
                            
                        }
       }
       
       if( in_array('mobile',$keys_array )){
           if($vals_array[13]!=''){
             $mobileError = $objCustomer->checkMobile($vals_array[13]);
                        
                        if($mobileError[0]!=''){
			array_push($msg_array, $mobileError[0]);
                        array_push($fields_array,'mobile');
                        }  
           }
			
                        else{
                            
                        }
       }
       
       if( in_array('fax',$keys_array )){
           if($vals_array[14]!=''){
			$faxError = $objCustomer->checkFax($vals_array[14]);
                        
                        if($faxError[0]!=''){
			array_push($msg_array, $faxError[0]);
                        array_push($fields_array,'fax');
                        }
           }
                        else{
                            
                        }
       }

   if( in_array('security_code',$keys_array )){
       $is_submit = 'yes';
   //  $img = ' CaptchaSecurityImages.php?width=150&height=40&characters=8';
   if(($_SESSION['security_code'] == $vals_array[15]) && (!empty($_SESSION['security_code'])) ) {
 
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
        
//                if (!isset($_REQUEST['fName'])){
//                    $fNameError  = $objCustomer->checkfName($_REQUEST['fName']);
//                    $msg = $fNameError[0]; 
//                    $field1 = "fName"; 
//                }
//        
//		if (isset($_REQUEST['fName']))
//		{
//			$fNameError  = $objCustomer->checkfName($_REQUEST['fName']);
//			$msg = $fNameError[0]; 
//			$field1 = "fName"; 
//		} 
//                
//		elseif (isset($_REQUEST['lName']))
//		{
//			$lNameError  = $objCustomer->checklName($_REQUEST['lName']);
//			$msg = $lNameError[0]; 
//			$field1 = "lName"; 
//		}
//		elseif (isset($_REQUEST['email']) && isset($_REQUEST['emailConfirm']))
//		{	
//			if ($_REQUEST['email'] != '' && $_REQUEST['emailConfirm'] != '')
//			{
//				$emailError = $objCustomer->checkEmail($_REQUEST['email'], $_REQUEST['emailConfirm'], '');
//				$msg = $emailError[0]; 
//			}
//			$field1 = "email";
//			$field2 = "emailConfirm";	
//		} 
//		elseif (isset($_REQUEST['email']))
//		{
//			$emailError = $objCustomer->checkEmail($_REQUEST['email'], $_REQUEST['emailConfirm'], 'email');
//			$msg = $emailError[0]; 
//			$field1 = "email";
//		}
//		elseif (isset($_REQUEST['emailConfirm']))
//		{	
//			$emailError = $objCustomer->checkEmail($_REQUEST['email'], $_REQUEST['emailConfirm'], 'emailConfirm');
//			$msg = $emailError[0];
//			$field1 = "emailConfirm";		
//		}
//		elseif (isset($_REQUEST['password']) && isset($_REQUEST['confirmPassword']))
//		{	
//			if ($_REQUEST['password'] != '' && $_REQUEST['confirmPassword'] != '')
//			{
//				$passwordError = $objCustomer->checkPassword($_REQUEST['password'], $_REQUEST['confirmPassword'], '');
//				$msg = $passwordError[0];
//			}
//			$field1 = "password";
//			$field2 = "confirmPassword";	 	
//		}
//		elseif (isset($_REQUEST['password']))
//		{ 
//			$passwordError = $objCustomer->checkPassword($_REQUEST['password'], $_REQUEST['confirmPassword'], 'password' );
//			$msg = $passwordError[0]; 
//			$field1 = "password";  
//		}
//		elseif (isset($_REQUEST['confirmPassword']))
//		{
//			$passwordError = $objCustomer->checkPassword($_REQUEST['password'], $_REQUEST['confirmPassword'], 'confirmPassword' );
//			$msg = $passwordError[0]; 
//			$field1 = "confirmPassword";
//		}
//		elseif (isset($_REQUEST['address']))
//		{
//			$addressError = $objCustomer->checkAddress($_REQUEST['address']);
//			$msg = $addressError[0]; 
//			$field1 = "address"; 
//		}
//		elseif (isset($_REQUEST['street']))
//		{
//			$streetError = $objCustomer->checkStreet($_REQUEST['street']);
//			$msg = $streetError[0]; 
//			$field1 = "street"; 
//		}
//		elseif (isset($_REQUEST['city']))
//		{
//			$cityError = $objCustomer->checkCity($_REQUEST['city']);
//			$msg = $cityError[0];
//			$field1 = "city"; 
//		}
//		elseif (isset($_REQUEST['country']))
//		{
//			$cityError = $objCustomer->checkCountry($_REQUEST['country']);
//			$msg = $cityError[0]; 
//			$field1 = "country"; 
//		}
//		elseif (isset($_REQUEST['phone']))
//		{
//			$phoneError = $objCustomer->checkPhone($_REQUEST['phone']);
//			$msg = $phoneError[0]; 
//			$field1 = "phone";  
//		}
//		
//		if ($msg)
//  		{
//			echo $objCore->msgBox("CUSTOMER",$msg)."||".$field1."||".$field2;
//		}
//		else 
//		{
//			echo "||".$field1."||".$field2;  
//		}

?>
