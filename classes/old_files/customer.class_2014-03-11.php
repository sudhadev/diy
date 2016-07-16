<?php

/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>      				'
  '    FILE            :  customer.class.php                                  '
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

if($incWithinCore) {
    require_once($this->_SYS['PATH']['CLASS_SQL']);
    require_once($this->_SYS['PATH']['CLASS_PAYPAL_WRAPPER']);

}
else {
    require_once($objCore->_SYS['PATH']['CLASS_SQL']);
    require_once($objCore->_SYS['PATH']['CLASS_EMAIL']);
    require_once($objCore->_SYS['PATH']['SESS']);
    require_once($objCore->_SYS['PATH']['SESS']);
    require_once($objCore->_SYS['PATH']['CLASS_PAYPAL_WRAPPER']);

}

class Customer extends Sql {
    private $title;
    private $fName;
    private $lName;
    private $email;
    private $emailConfirm;
    private $password;
    private $passwordConfirm;
    private $company;
    private $address;
    private $street;
    private $city;
    private $postal;
    private $country;
    private $phone;
    private $fax;
    private $mobile;
    private $cusType;
    private $latitude;
    private $longitude;
    private $subscription;
    private $package;
    private $package_type_extend;
    private $tblPrefix;
    private $gConf;
    private $gold;
    private $silver;
    private $bronze;
    private $pendingApproval;
    private $lConf;
    private $recordsConsole;
    private $loggedUserId;
    private $loggedUser;
    function __construct($gConf='') {
        parent:: __construct();
        $this->tblPrefix = $this->core->_SYS['CONF']['PREFIX_TBL'];
        $this->gConf = $gConf;
        $this->gold = $this->gConf['SUBSCRIPTION_GOLD'];
        $this->silver = $this->gConf['SUBSCRIPTION_SILVER'];
        $this->bronze = $this->gConf['SUBSCRIPTION_BRONZE'];
        $this->pendingApproval = $this->gConf['REGISTRATION_PENDING_APPROVAL'];
        $this->recordsConsole = $this->gConf['RECS_IN_LIST_CONSOLE'];
        /**
         *  Require the login config file
         * *IMPORTANT - It should be require() here, NOT require_once()
         */
        $this->_SYS['CONF']=$this->core->_SYS['CONF'];
        require($this->core->_SYS['PATH']['LOGIN_CONF']);
        $this->lConf=$_LCONF;
        $this->loggedUserId;
        $this->core->sessCusId;
        if(strlen($this->loggedUserId)<11) $this->loggedUser="Admin";

    }

    function setVariables($title, $fName, $lName, $email, $emailConfirm, $password, $passwordConfirm, $company, $address, $street, $city, $postal, $country, $phone, $fax, $mobile, $cusType, $latitude, $longitude, $subscription, $package,$package_type_extend) {
        $this->title = $title;
        $this->fName = $fName;
        $this->lName = $lName;
        $this->email = $email;
        $this->emailConfirm = $emailConfirm;
        $this->password = $password;
        $this->passwordConfirm = $passwordConfirm;
        $this->address = $address;
        $this->street = $street;
        $this->city = $city;
        $this->postal = $postal;
        $this->country = $country;
        $this->phone = $phone;
        $this->fax = $fax;
        $this->mobile = $mobile;
        $this->company = $company;
        $this->cusType = $cusType;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->subscription = $subscription;
        $this->package = $package;
        $this->package_type_extend = $package_type_extend;
    }

    function add($cusType,$promo='',$promo_key='',$promo_code='') {
        
        $encyptedPassword = $this->encryptPassword($this->password);
        $customerExists = $this->checkCustomerExists($this->email);
        $passwordError = $this->checkPassword($this->password, '', 'password');
        $passwordConfirmError = $this->checkPassword('', $this->passwordConfirm, 'passwordConfirm');
        $emailError = $this->checkEmail($this->email, '', 'email');
        $emailConfirmError = $this->checkEmail('', $this->emailConfirm, 'emailConfirm');
        $addressError = $this->checkAddress($this->address);
        $fNameError = $this->checkfName($this->fName);
        $lNameError = $this->checklName($this->lName);
        //$companyError = $this->checkCompany($this->company);
        $countryError = $this->checkCountry($this->country);
        $cityError = $this->checkCity($this->city);
        $streetError = $this->checkStreet($this->street);
        $phoneError = $this->checkPhone($this->phone);
        $customerId = $this->base64key();
        $verificationkey = $this->createKey();
        $expire_time = time()+(3600*24);

        if ($this->pendingApproval == 'OFF') {
            $customerStatus = 'Y';
        }
        else {
            $customerStatus = 'W';
        }
        
        if($promo=='P'){
            $register_status = 'E';
        }
        else{
            $register_status = 'P';
        }
        

        if ($customerExists[1] == true) {
            return $customerExists[0];
        }
        elseif ($fNameError[1] == true) {
            return $fNameError[0];
        }
        elseif ($lNameError[1] == true) {
            return $lNameError[0];
        }
        elseif ($emailError[1] == true) {
            return $emailError[0];
        }
        elseif ($emailConfirmError[1] == true) {
            return $emailConfirmError[0];
        }
        elseif ($passwordError[1] == true) {
            return $passwordError[0];
        }
        elseif ($passwordConfirmError[1] == true) {
            return $passwordConfirmError[0];
        }
        elseif ($addressError[1] == true && $cusType == "S") {
            return $addressError[0];
        }
        elseif ($streetError[1] == true && $cusType == "S") {
            return $streetError[0];
        }
        elseif ($cityError[1] == true && $cusType == "S") {
            return $cityError[0];
        }
        elseif ($countryError[1] && $cusType == "S") {
            return $countryError[0];
        }
        elseif ($phoneError[1] == true && $cusType == "S") {
            return $phoneError[0];
        }
        else {
            switch ($cusType) {
                case "S": {
                    
                       $sql = "INSERT INTO `".$this->tblPrefix."customers` (`customer_id`, `customer_type`, `title`, `f_name`, `l_name`, `dob`, `company`, `address`, `street`, `city`, `postal`, `state`, `country`, `telephone`, `fax`, `mobile`, `email`, `password`, `last_logged_ip`, `last_logged_time`, `added_date`, `latitude`, `longitude`, `customer_status`,`ver_key`,`expire_time`,`register_status`) VALUES ('".$customerId."', 'S', '".$this->title."', '".ucwords($this->fName)."', '".ucwords($this->lName)."', '', '".$this->company."',  '".ucwords($this->address)."', '".ucwords($this->street)."', '".ucwords($this->city)."', '".strtoupper($this->postal)."', '', '".$this->country."', '".$this->phone."', '".$this->fax."', '".$this->mobile."', '".$this->email."', '".$encyptedPassword."', '".$_SERVER['REMOTE_ADDR']."', '".time()."', '".time()."', '".$this->latitude."', '".$this->longitude."', '".$customerStatus."','".$verificationkey."','".$expire_time."','".$register_status."')";
  
                    }break;

                case "B": {
                        $sql = "INSERT INTO `".$this->tblPrefix."customers` (`customer_id`, `customer_type`, `title`, `f_name`, `l_name`, `dob`, `company`, `address`, `street`, `city`, `postal`, `state`, `country`, `telephone`, `fax`, `mobile`, `email`, `password`, `last_logged_ip`, `last_logged_time`, `added_date`, `latitude`, `longitude`, `customer_status`,`ver_key`,`expire_time`) VALUES ('".$customerId."', 'B', '".$this->title."', '".$this->fName."', '".$this->lName."', '', '".$this->comapany."',  '".$this->address."', '".$this->street."', '".$this->city."', '".$this->postal."', '', '".$this->country."', '".$this->phone."', '".$this->fax."', '".$this->mobile."', '".$this->email."', '".$encyptedPassword."', '".$_SERVER['REMOTE_ADDR']."', '".time()."', '".time()."', '".$this->latitude."', '".$this->longitude."', 'Y','".$verificationkey."','".$expire_time."')";
                    }break;
            }

            $result = $this->query($sql);
            if ($result) {
                
                $sql_subscription = "INSERT INTO `".$this->tblPrefix."email_subscriptions` (`cus_Id`) VALUES ('".$customerId."')";
                $this->query($sql_subscription);
                
                if($cusType == "S") {
                    //$resultSubscription = $this->query($sqlSubscription);
                    
                	/* Add maduranga */
                	
                	$baseDir=$this->_SYS['CONF']['FTP_LISTINGS']."/".$customerId;
                	 
                	if(!is_dir($baseDir)) {
                		mkdir($baseDir,0750);
                		mkdir($baseDir."/large/",0750);
                		mkdir($baseDir."/thumbs/",0750);
                	}
                	if(!is_dir($baseDir."/large/")) {
                		mkdir($baseDir."/large/",0750);
                	}
                	if(!is_dir($baseDir."/thumbs/")) {
                		mkdir($baseDir."/thumbs/",0750);
                	}
                	 
                	/*************/
                	
                    if($register_status=='P'){
                       $objEmail = new Email();
                        $objEmail->send('verify_supplier', $this->email, $customerId,'H',$this->password);
                        $customerId = urlencode($customerId);
                        $redirect =  $this->config['URL_FRONT'].'/signup/?f=verify&uid='.$customerId.'&email='.$this->email.'&ps='.$this->password.'&fr=acc';
                    //return array('SUC','DONE_SUPPLIER');
                        header("Location: $redirect"); 
                    }
                    else{
                        
                        $objSession = new Session();
                        $objSession->config=$this->lConf;
                        $objSession->login($this->email, $this->password, 1,'','',$this->core->_SYS['CONF']['URL_MY_ACCOUNT']."/first_login/?f=select_subscription&promo_key=".$promo_key.'&promo_code='.$promo_code.'');
                        $redirect =  $this->config['URL_FRONT'].'/my_account/first_login/?f=select_subscription&promo_key='.$promo_key.'&promo_code='.$promo_code.'';
                         header("Location: $redirect"); 
                    }
                    
                                   
                    //$objEmail->send('register_supplier', $this->email, $customerId);
                    /*
                         * Create the user session. User will be logged in to the system automatically with this
                    */
//                    $objSession = new Session();
//                    $objSession->config=$this->lConf;
//                    $objSession->login($this->email, $this->password, 1,'','',$this->core->_SYS['CONF']['URL_MY_ACCOUNT']."/");


                }
                else if ($cusType == "B") {
                    //$resultSubscription = $this->query($sqlSubscription);
                    $objEmail = new Email();
                    $objEmail->send('verify_buyer', $this->email, $customerId);
                    
                    $customerId = urlencode($customerId);
                    
                    //$objEmail->send('register_buyer', $this->email, $customerId);

                    //$objSession = new Session();
                    //$objSession->config=$this->lConf;
                    //$objSession->login($this->email, $this->password, 1,'','',$this->core->_SYS['CONF']['URL_MY_ACCOUNT']."/");
                    $redirect =  $this->config['URL_FRONT'].'/signup/?f=verify&uid='.$customerId.'&email='.$this->email.'&fr=acc';
                    //return array('SUC','DONE_BUYER');
                    header("Location: $redirect");
                    
                }
            }
            else {
                return array('ERR','NOT_ADDED');
            }
        }
    }
    
    
    function addAdmin($cusType) {
        
        $encyptedPassword = $this->encryptPassword($this->password);
        $customerExists = $this->checkCustomerExists($this->email);
        $passwordError = $this->checkPassword($this->password, '', 'password');
        $passwordConfirmError = $this->checkPassword('', $this->passwordConfirm, 'passwordConfirm');
        $emailError = $this->checkEmail($this->email, '', 'email');
        $emailConfirmError = $this->checkEmail('', $this->emailConfirm, 'emailConfirm');
        
        $fNameError = $this->checkCompany($this->fName);
        $customerId = $this->base64key();
        $customerStatus = 'Y';
        $register_status = 'Y';
       

        if ($customerExists[1] == true) {
            return $customerExists[0];
        }
        elseif ($fNameError[1] == true) {
            return $fNameError[0];
        }
        
        elseif ($emailError[1] == true) {
            return $emailError[0];
        }
        
        elseif ($passwordError[1] == true) {
            return $passwordError[0];
        }
        
        else {
            switch ($cusType) {
                case "S": {
                    
                       $sql = "INSERT INTO `".$this->tblPrefix."customers` (`customer_id`, `customer_type`, `title`, `f_name`, `l_name`, `dob`, `company`, `address`, `street`, `city`, `postal`, `state`, `country`, `telephone`, `fax`, `mobile`, `email`, `password`, `last_logged_ip`, `last_logged_time`, `added_date`, `latitude`, `longitude`, `customer_status`,`ver_key`,`expire_time`,`register_status`,`pass`) VALUES ('".$customerId."', 'S', '".$this->title."', '".ucwords($this->fName)."', '".ucwords($this->lName)."', '', '".$this->company."',  '".ucwords($this->address)."', '".ucwords($this->street)."', '".ucwords($this->city)."', '".strtoupper($this->postal)."', '', '".$this->country."', '".$this->phone."', '".$this->fax."', '".$this->mobile."', '".$this->email."', '".$encyptedPassword."', '".$_SERVER['REMOTE_ADDR']."', '".time()."', '".time()."', '".$this->latitude."', '".$this->longitude."', '".$customerStatus."','".$verificationkey."','".$expire_time."','".$register_status."', '".$this->password."')";
  
                    }break;

                case "B": {
                        $sql = "INSERT INTO `".$this->tblPrefix."customers` (`customer_id`, `customer_type`, `title`, `f_name`, `l_name`, `dob`, `company`, `address`, `street`, `city`, `postal`, `state`, `country`, `telephone`, `fax`, `mobile`, `email`, `password`, `last_logged_ip`, `last_logged_time`, `added_date`, `latitude`, `longitude`, `customer_status`,`ver_key`,`expire_time`,`pass`) VALUES ('".$customerId."', 'B', '".$this->title."', '".$this->fName."', '".$this->lName."', '', '".$this->comapany."',  '".$this->address."', '".$this->street."', '".$this->city."', '".$this->postal."', '', '".$this->country."', '".$this->phone."', '".$this->fax."', '".$this->mobile."', '".$this->email."', '".$encyptedPassword."', '".$_SERVER['REMOTE_ADDR']."', '".time()."', '".time()."', '".$this->latitude."', '".$this->longitude."', 'Y','".$verificationkey."','".$expire_time."', '".$this->password."')";
                    }break;
            }

            $result = $this->query($sql);
            if ($result) {
                
                $sql_subscription = "INSERT INTO `".$this->tblPrefix."email_subscriptions` (`cus_Id`) VALUES ('".$customerId."')";
                $this->query($sql_subscription);
                
                $expire = strtotime('+1 month', time());
                $this->setSubcriptons($customerId, $this->subscription, $this->package,$expire,'admin' ,  $this->package_type_extend);
                $objEmail = new Email();
                $objEmail->send('register_supplier', $this->email, $customerId, 'H',$this->password,'admin');
                
                /* Add maduranga */
                
                $baseDir=$this->_SYS['CONF']['FTP_LISTINGS']."/".$customerId;
                	
                if(!is_dir($baseDir)) {
                	mkdir($baseDir,0750);
                	mkdir($baseDir."/large/",0750);
                	mkdir($baseDir."/thumbs/",0750);
                }
                if(!is_dir($baseDir."/large/")) {
                	mkdir($baseDir."/large/",0750);
                }
                if(!is_dir($baseDir."/thumbs/")) {
                	mkdir($baseDir."/thumbs/",0750);
                }
                	
                /*************/
                
                
                return array('SUC','DONE');
                
            }
            else {
                return array('ERR','NOT_ADDED');
            }
        }
    }
    
    //create an entry in pre-customer table and 
    function verify($cus_Id,$verify_code=''){
        
        $sql = "SELECT email,password,ver_key,register_status,customer_type,expire_time FROM `".$this->tblPrefix."customers` WHERE customer_id = '".$cus_Id."'";
        
        $result = $this->query($sql);
        
        //echo $cus_Id;
        //print_r($result);
        //exit();
        //echo $result[0]['password'];
        if($result){
            if($result[0]['register_status']=='E'){
                //return array('ERR','ALREADY_ACTIVATED');
                $objSession = new Session();
                $objSession->config=$this->lConf;
                $objSession->login($result[0]['email'], $result[0]['password'], 1,'','verification',$this->core->_SYS['CONF']['URL_MY_ACCOUNT']."/");
            }
            else if($result[0]['expire_time']<time()){
                return array('ERR','TIME_EXPIRED');
            }
        elseif($result[0]['ver_key']==$verify_code){
            $sql_update = "UPDATE `".$this->tblPrefix."customers` SET `register_status` = 'E' WHERE customer_id = '".$cus_Id."'";
            $this->query($sql_update);

            $objEmail = new Email();
            if($result[0]['customer_type']=="S"){
                //print_r($this->lConf);
                $objEmail->send('register_supplier', $result[0]["email"], $cus_Id);
                //$objSession = new Session();
                $return_array = array($result[0]["email"],$result[0]['password']);
               //$objSession->config=$this->lConf;
                //$objSession->login($result[0]['email'], $result[0]['password'], 1,'','verification',$this->core->_SYS['CONF']['URL_MY_ACCOUNT']."/");
                return array('SUC',$return_array);
            }
            else{
                $objEmail->send('register_buyer', $result[0]["email"], $cus_Id);
                $objSession = new Session();
                $objSession->config=$this->lConf;
                $objSession->login($result[0]['email'], $result[0]['password'], 1,'','verification',$this->core->_SYS['CONF']['URL_FRONT']."/");
                return array('SUC','DONE_REGISTER');
            }
            
            
            
            
        }
        else{
            if($verify_code=='first'){
                
            }
            else{
                return array('ERR','INVALID_VERIFICATION_CODE');
            }
            
        }  
        }
        else{
           return array('ERR','USER_NOT_FOUND');
        }
        
    }
    //Generate random customer_id
    function  base64key() {
        // declare the $key variable
        $key = "";
        $alph_small = range("a","z");
        $alph_caps = range("A","Z");
        $alphKeyLength=54;
        $alphaTxt='###aaAAAaA##AaaAAaAaaaaaAA#aaA###AAAAAAAaaa###aaAAAAaa';

        for($i = 0; $i < $alphKeyLength; $i++) {
            if($alphaTxt[$i]=="#") {
                $key .= rand(0,9);
            }elseif($alphaTxt[$i]=="a") {
                $key .= $alph_small[rand(0,25)];
            }else {
                $key .= $alph_caps[rand(0,25)];
            }
        }
        return $key.time();
    }

    //Validate email
    function isValidEmail($email) {
        $pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$";
        if (eregi($pattern, $email)) {
            return true;
        }
        else {
            return false;
        }
    }

    //Encrypting pasword
    function encryptPassword($password) {
        $encryptedPassword = md5($password);
        return $encryptedPassword;
    }

    //Check Customer already exists or not
    function checkCustomerExists($email) {
        $sql = "SELECT COUNT(*) FROM `".$this->tblPrefix."customers` WHERE email='".$email."'";
        $result=$this->query($sql);
        if($result[0]["COUNT(*)"]>0) {
            $msg = array('ERR', 'CUS_EXISTS');
            return array($msg, true);
        }
        else {
            return false;
        }
    }

    //Check Password
    function checkPassword($password, $passwordConfirm, $field) {
        if ($field == 'password') {
            if(empty($password)) {
                $msg = array('ERR', 'PW_BLANK');
                return array($msg, true);
            }
            elseif (strlen($password) <= 5) {
                $msg = array('ERR', 'PW_MIN');
                return array($msg, true);
            }
        }
        elseif ($field == 'confirmPassword') {
            if(empty($passwordConfirm)) {
                $msg = array('ERR', 'CPW_BLANK');
                return array($msg, true);
            }
            elseif (strlen($passwordConfirm) <= 5) {
                $msg = array('ERR', 'PW_NOTMATCH');
                return array($msg, true);
            }
        }
        elseif((!empty($password) && !empty($passwordConfirm)) && $password != $passwordConfirm) {
            $msg = array('ERR', 'PW_NOTMATCH');
            return array($msg, true);
        }
        else {
            return false;
        }
    }

    //Check Email
    function checkEmail($email, $emailConfirm, $field) {
        if ($field == 'email') {
            if(empty($email)) {
                $msg = array('ERR', 'EMAIL_BLANK');
                return array($msg, true);
            }
            elseif(!$this->isValidEmail($email)) {
                $msg = array('ERR', 'EMAIL_NOT_VALID');
                return array($msg, true);
            }
            elseif ($this->checkCustomerExists($email) != false) {
                return $this->checkCustomerExists($email);
            }
        }
        elseif ($field == 'emailConfirm') {
            if(empty($emailConfirm)) {
                $msg = array('ERR', 'CON_EMAIL_BLANK');
                return array($msg, true);
            }
            elseif(!$this->isValidEmail($emailConfirm)) {
                $msg = array('ERR', 'CON_EMAIL_NOT_VALID');
                return array($msg, true);
            }
            elseif ($this->checkCustomerExists($emailConfirm) != false) {
                return $this->checkCustomerExists($emailConfirm);
            }
        }
        elseif($email != $emailConfirm) {
            $msg = array('ERR', 'EMAIL_NOTMATCH');
            return array($msg, true);
        }
        else {
            return false;
        }
    }

    //Check Address
    function checkAddress($address) {
        if(empty($address)) {
            $msg = array('ERR', 'ADDRESS_BLANK');
            return array($msg, true);
        }
        else {
            return false;
        }
    }
    
    //Check first name
    function checkfName($fName) {
//        if (empty($fName)) {
//            $msg = array('ERR', 'FNAME_BLANK');
//            return array($msg, true);
//        }
        if ((preg_match ('/[^a-z ]/i', $fName))>0) {
            $msg = array('ERR', 'FNAME_CHAR');
            return array($msg, true);
        }
        else {
            return false;
        }
    }
    
    
    //Check last name
    function checklName($lName) {
//        if (empty($lName)) {
//            $msg = array('ERR', 'LNAME_BLANK');
//            return array($msg, true);
//        }
        //else 
            if ((preg_match ('/[^a-z ]/i', $lName))>0) {
            $msg = array('ERR', 'LNAME_CHAR');
            return array($msg, true);
        }
        else {
            return false;
        }
    }

    
   
    //Check country
    function checkCountry($country) {
        if(empty($country)) {
            $msg = array('ERR', 'COUNTRY_BLANK');
            return array($msg, true);
        }
        else {
            return false;
        }
    }

    //Check company
    		function checkCompany($company)
		{ 
			if(empty($company)) 
			{
				$msg = array('ERR', 'COMPANY_BLANK');
				return array($msg, true);
			}
			else
			{
				return false;  
			}
		}

    //Check phone
    function checkPhone($phone) {
        if(empty($phone)) {
            $msg = array('ERR', 'PHONE_BLANK');
            return false;
        }
        if (!($this->isNaN($phone))) {
            $msg = array('ERR', 'PHONE_NOT_NUMERIC');
            return array($msg, true);
        }
        elseif (strlen($phone) < 8) {
            $msg = array('ERR', 'PHONE_MIN');
            return array($msg, true);
        }
        else {
            return false;
        }
    }

        //Check mobile
    function checkMobile($mobile) {
    if(!empty($mobile)) {
//            $msg = array('ERR', 'MOBILE_BLANK');
//            return false;
//        }
        if (!($this->isNaN($mobile))) {
            $msg = array('ERR', 'MOBILE_NOT_NUMERIC');
            return array($msg, true);
        }
        elseif (strlen($mobile) < 8) {
            $msg = array('ERR', 'MOBILE_MIN');
            return array($msg, true);
        }
        else {
            return false;
        }
    }
    }

        //Check fax
    function checkFax($fax) {
       if(!empty($fax)) {
       if (!($this->isNaN($fax))) {
            $msg = array('ERR', 'FAX_NOT_NUMERIC');
            return array($msg, true);
        }
        elseif (strlen($fax) < 8) {
            $msg = array('ERR', 'FAX_MIN');
            return array($msg, true);
        }
        else {
            return false;
        }
       }
    }
    
function checkPostcode (&$toCheck) {
      if(empty($toCheck)) {
            $msg = array('ERR', 'POSTCODE_BLANK');
            return array($msg, true);
        }
      else{
  // Permitted letters depend upon their position in the postcode.
  $alpha1 = "[abcdefghijklmnoprstuwyz]";                          // Character 1
  $alpha2 = "[abcdefghklmnopqrstuvwxy]";                          // Character 2
  $alpha3 = "[abcdefghjkpmnrstuvwxy]";                            // Character 3
  $alpha4 = "[abehmnprvwxy]";                                     // Character 4
  $alpha5 = "[abdefghjlnpqrstuwxyz]";                             // Character 5
  
  // Expression for postcodes: AN NAA, ANN NAA, AAN NAA, and AANN NAA with a space
  $pcexp[0] = '^('.$alpha1.'{1}'.$alpha2.'{0,1}[0-9]{1,2})([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$';

  // Expression for postcodes: ANA NAA
  $pcexp[1] =  '^('.$alpha1.'{1}[0-9]{1}'.$alpha3.'{1})([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$';

  // Expression for postcodes: AANA NAA
  $pcexp[2] =  '^('.$alpha1.'{1}'.$alpha2.'{1}[0-9]{1}'.$alpha4.')([[:space:]]{0,})([0-9]{1}'.$alpha5.'{2})$';
  
  // Exception for the special postcode GIR 0AA
  $pcexp[3] =  '^(gir)(0aa)$';
  
  // Standard BFPO numbers
  $pcexp[4] = '^(bfpo)([0-9]{1,4})$';
  
  // c/o BFPO numbers
  $pcexp[5] = '^(bfpo)(c\/o[0-9]{1,3})$';
  
  // Overseas Territories
  $pcexp[6] = '^([a-z]{4})(1zz)$/i';

  // Load up the string to check, converting into lowercase
  $postcode = strtolower($toCheck);

  // Assume we are not going to find a valid postcode
  $valid = false;
  
  // Check the string against the six types of postcodes
  foreach ($pcexp as $regexp) {
  
    if (ereg($regexp,$postcode, $matches)) {
			
      // Load new postcode back into the form element  
		  $postcode = strtoupper ($matches[1] . ' ' . $matches [3]);
			
      // Take account of the special BFPO c/o format
      $postcode = ereg_replace ('C\/O', 'c/o ', $postcode);
      
      // Remember that we have found that the code is valid and break from loop
      $valid = true;
      break;
    }
  }
    
  // Return with the reformatted valid postcode in uppercase if the postcode was 
  // valid
  if (!$valid){
       $msg = array('ERR', 'POSTCODE_INVALID');
         return array($msg, true);
	  
	} 
	else {
           //$toCheck = $postcode; 
		return false;
}
    
}
}//Check postcode

    function checkCaptcha() {
      
            $msg = array('ERR', 'CAPTCHA_NOT_MATCH');
            return array($msg, true);
       
    }
    
    //checking 	numeric or not
    function isNaN($var) {
        $pattern = "^(\()?([0-9]{1,4})(\))?(\-)?( )?([0-9]{2,10})( )?(\-)?( )?([0-9]{0,10})$";
        $var = trim($var);
        return ereg($pattern, $var);
    }

    //Check street
    function checkStreet($street) {
        if(empty($street)) {
            $msg = array('ERR', 'STREET_BLANK');
            return array($msg, true);
        }
        else {
            return false;
        }
    }

    //Check city
    function checkCity($city) {
        if(empty($city)) {
            $msg = array('ERR', 'CITY_BLANK');
            return array($msg, true);
        }
        else {
            return false;
        }
    }

    //Generate random string
    function generateRandomString($numOfCharacters) {
        // List all possible characters
        $possible = '123456789ABCDEFGHIJKLMNOPQSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $code = null;
        $i = 0;
        while ($i < $numOfCharacters) {
            $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
            $i++;
        }
        return $code;
    }

    //Function to reset Password
    function resetPassword($email) {
        $sql = "SELECT COUNT(*) FROM `".$this->tblPrefix."customers` WHERE email='".$email."'";
        $result=$this->query($sql);
        if($result[0]["COUNT(*)"]>0) {
            $sql = "SELECT customer_id FROM `".$this->tblPrefix."customers` WHERE email='".$email."'";
            $customerId = $this->query($sql);
            $newPassword = $this->generateRandomString(8);
            $encryptedPassword = $this->encryptPassword($newPassword);
            $sql = "UPDATE `".$this->tblPrefix."customers` SET password = '".$encryptedPassword."' WHERE email='".$email."'";
            $this->query($sql);
            $objEmail = new Email();
            if($this->dev) $objEmail->dev=true;
            $objEmail->send('password', $email, $newPassword."|x|".$customerId[0]['customer_id']."|x|reset");
            $msg = array('SUC', 'PASSWORD_CHANGED');
            return $msg;
        }
        else {
            $msg = array('ERR', 'CUS_NOT_EXISTS');
            return $msg;
        }
    }

        //Function to reset Verification code
    function resetVerificationCode($uid) {
        $sql = "SELECT COUNT(*),email FROM `".$this->tblPrefix."customers` WHERE customer_id='".$uid."'";
        $result=$this->query($sql);
        if($result[0]["COUNT(*)"]>0) {
            
             $newVerificationCode = $this->createKey();
            
            $expire_time = time()+(3600*24);
            
            $sql = "UPDATE `".$this->tblPrefix."customers` SET ver_key = '".$newVerificationCode."', expire_time = '".$expire_time."' WHERE customer_id='".$uid."'";
            $this->query($sql);
            $objEmail = new Email();
            if($this->dev) $objEmail->dev=true;
            $objEmail->send('reset_verification_code', $result[0]["email"], $newVerificationCode."|x|".$uid."|x|reset");
            //$msg = array('SUC', 'VERIFYCODE_CHANGED');
            $msg = "Security code has been changed. Please check your email.";
            return $msg;
        }
        else {
            //$msg = array('ERR', 'CUS_NOT_EXISTS');
            $msg = "Email address is blank or email not exists";
            return $msg;
        }
    }
    //Function to update last logged IP address and date/time
    function lastLogged($customer_id) {
        $sql = "UPDATE `".$this->tblPrefix."customers` SET last_logged_ip='".$_SERVER['REMOTE_ADDR']."', last_logged_time='".time()."' WHERE customer_id='".$customer_id."'";
        $this->query($sql);
        return true;
    }

    //Function to get the status of a customer
    function getStatus($customer_id,$listType='default') {
        $sql = "SELECT customers.customer_status, customers.customer_type,
                    subscriptions.subscription_type, subscriptions.package_type,
                    subscriptions.subscription_status, subscriptions.expire,
                    subscriptions.no_of_listings,subscriptions.package_type_extend,
                    subscriptions.recurring_profile_id,subscriptions.last_modified
                    FROM `".$this->tblPrefix."customers` customers
                    LEFT OUTER JOIN `".$this->tblPrefix."subscriptions` subscriptions
                    ON customers.customer_id=subscriptions.customer_id
                    WHERE customers.customer_id='".$customer_id."'";
        $result = $this->query($sql);

        switch($listType) {
            case 'subs_type':// returns the array by subscription type
                {
                    for($i=0;$i<count($result);$i++) {
                        $currentSubsType=$result[$i]['subscription_type'];
                        $list[$currentSubsType][]=$result[$i]['customer_status'];
                        $list[$currentSubsType][]=$result[$i]['customer_type'];
                        $list[$currentSubsType][]=$result[$i]['subscription_type'];//2
                        $list[$currentSubsType][]=$result[$i]['package_type'];
                        $list[$currentSubsType][]=$result[$i]['subscription_status'];
                        $list[$currentSubsType][]=$result[$i]['expire'];
                        $list[$currentSubsType][]=$result[$i]['no_of_listings']; //6
                        $list[$currentSubsType][]=$result[$i]['package_type_extend'];
                        $list[$currentSubsType][]=$result[$i]['recurring_profile_id'];//8
                        $list[$currentSubsType][]=$result[$i]['last_modified'];//9

                    }
                }
                break;
            default:
                for($i=0;$i<count($result);$i++) {
                    $list[$i][]=$result[$i]['customer_status'];//0
                    $list[$i][]=$result[$i]['customer_type'];//1
                    $list[$i][]=$result[$i]['subscription_type'];//2
                    $list[$i][]=$result[$i]['package_type'];//3
                    $list[$i][]=$result[$i]['subscription_status'];//4
                    $list[$i][]=$result[$i]['expire'];//5
                    $list[$i][]=$result[$i]['no_of_listings'];//6
                    $list[$i][]=$result[$i]['package_type_extend'];//7
                    $list[$i][]=$result[$i]['recurring_profile_id'];//8
                    $list[$i][]=$result[$i]['last_modified'];//9

                }
        }

        return $list;
    }




    function setStatus($customer_id, $status='', $sub='', $type='') {
        if ($type == 'cus') {
            if($status == 'A') {$status = 'Y';}
            $sql = "UPDATE `".$this->tblPrefix."customers` SET customer_status='".$status."' WHERE customer_id='".$customer_id."'";
            if ($this->query($sql) && $status == 'Y') {
                return array('SUC', 'CUS_ACTIVATED');
            }
            elseif ($this->query($sql) && $status == 'R') {
                return array('SUC', 'CUS_REJECTED');
            }
            else {
                return true;
            }
        }
        elseif ($type == 'sub') {
            $sql = "UPDATE `".$this->tblPrefix."subscriptions` SET subscription_status='".$status."' WHERE customer_id='".$customer_id."' AND subscription_type='".$sub."'";
            if ($this->query($sql))
                return true;
        }
    }


    function getCustomerData($customer_id) {
        $sql = "SELECT customers.f_name, customers.l_name, customers.company, customers.address,
     customers.street, customers.city, customers.postal, customers.country, customers.telephone, customers.fax,
customers.mobile, customers.email, customers.show_website, customers.title,   customers.latitude, customers.longitude,customers.id, customers.website, customers.mon,customers.sat,customers.sun,
subscriptions.subscription_type, subscriptions.package_type FROM `".$this->tblPrefix."customers`
customers LEFT OUTER JOIN `".$this->tblPrefix."subscriptions` subscriptions ON customers.customer_id=subscriptions.customer_id
WHERE customers.customer_id='".$customer_id."'";
        $result = $this->query($sql);
        for($i=0;$i<count($result);$i++) {
            $list[$i][]=$result[$i]['f_name'];//0
            $list[$i][]=$result[$i]['l_name'];//1
            $list[$i][]=$result[$i]['company'];//2
            $list[$i][]=$result[$i]['address'];//3
            $list[$i][]=$result[$i]['street'];//4
            $list[$i][]=$result[$i]['city'];//5
            $list[$i][]=$result[$i]['postal'];//6
            $list[$i][]=$result[$i]['country'];//7
            $list[$i][]=$result[$i]['telephone'];//8
            $list[$i][]=$result[$i]['fax'];//9
            $list[$i][]=$result[$i]['mobile'];//10
            $list[$i][]=$result[$i]['email'];//11
            $list[$i][]=$result[$i]['subscription_type'];//12
            $list[$i][]=$result[$i]['package_type'];//13
            $list[$i][]=$result[$i]['title'];//14
            $list[$i][]=$result[$i]['latitude'];//15
            $list[$i][]=$result[$i]['longitude'];//16
            $list[$i][]=$result[$i]['id'];//17
            $list[$i][]=$result[$i]['mon'];//18
            $list[$i][]=$result[$i]['sat'];//19
            $list[$i][]=$result[$i]['sun'];//20
            $list[$i][]=$result[$i]['website'];//21
            $list[$i][]=$result[$i]['show_website'];//22
        }

        return $list;
    }

    // Call to dList function to take correspond values that match with ID into a $list array.
    function get_dList($id='', $customerType='', $customerStatus='', $search='', $searchBy='',$sortBy='') {
        if($id!='') {
            $where = "WHERE id='".$id."'";
        }
        elseif ($customerType!='' && $customerStatus!='' && $search!='' && $searchBy!='') {
            if ($searchBy == 'Name') {
                $where = "WHERE customer_type='".$customerType."' AND customer_status='".$customerStatus."' AND f_name LIKE '%".$search."%' OR l_name LIKE '%".$search."%' ORDER BY ".$sortBy."";
            }
            elseif ($searchBy == 'E-mail') {
                $where = "WHERE customer_type='".$customerType."' AND customer_status='".$customerStatus."' AND email LIKE '%".$search."%' ORDER BY ".$sortBy."";
            }
        }
        elseif ($customerType!='' && $customerStatus!='') {
            $where = "WHERE customer_type='".$customerType."' AND customer_status='".$customerStatus."' ORDER BY ".$sortBy."";
        }
        $list=$this->dList($where);
        return $list;
    }

    // Take correspond values that match with ID into a $list array.
    function dList($where='') {
        $result=$this->query("SELECT * FROM `".$this->tblPrefix."customers` ".$where."");
        for($i=0;$i<count($result);$i++) {
            $list[$i][]=$result[$i]['customer_id'];//0
            $list[$i][]=$result[$i]['f_name']; // 1
            $list[$i][]=$result[$i]['l_name']; // 2
            $list[$i][]=$result[$i]['email']; // 3
            $list[$i][]=$result[$i]['telephone']; // 4
            $list[$i][]=$result[$i]['added_date']; // 5
            $list[$i][]=$result[$i]['id']; // 6
            $list[$i][]=$result[$i]['pass']; // 7
        }
        return $list;
    }

    function deleteCustomer($customer_id) {
        $sql = "UPDATE `".$this->tblPrefix."customers` SET customer_status='D' WHERE customer_id='".$customer_id."'";
        if ($this->query($sql)) {
            return array('SUC', 'CUSTOMER_DELETED');
        }
        else {
            return array('ERR', 'CUSTOMER_NOT_DELETED');
        }
    }

    function updateContact($customerId, $phone, $fax, $mobile) {
        $phoneError = $this->checkPhone($phone);
        $mobileError = $this->checkMobile($mobile);
        $faxError = $this->checkFax($fax);
        if ($phoneError[1]) {
            return $phoneError[0];
        }
        elseif($mobileError[1]){
            return $mobileError[0];
        }
        elseif($faxError[1]){
            return $faxError[0];
        }
        else {
            $sql = "UPDATE `".$this->tblPrefix."customers` SET telephone='".$phone."', fax='".$fax."', mobile='".$mobile."' WHERE customer_id='".$customerId."'";
            $this->query($sql);
            return array('SUC', 'CONTACT_UPDATED');
        }
    }

    function updatePersonal($customerId, $title, $fName, $lName, $email, $emailConfirm) {
        //$fNameError = $this->checkfName($fName);
        $lNameError = $this->checklName($lName);
        if (($email == '' || $emailConfirm == '') && ($this->checkCustomerExists($email) == false || $this->checkCustomerExists($emailConfirm)== false) || $email != $emailConfirm) {
            $emailError = $this->checkEmail($email, '', 'email');
            $emailConfirmError = $this->checkEmail('', $emailConfirm, 'emailConfirm');
            $emailMatchError = $this->checkEmail($email, $emailConfirm, '');
        }

//        if ($fNameError[1]) {
//            return $fNameError[0];
//        }
//        elseif ($lNameError[1]) {
//            return $lNameError[0];
//        }
        elseif ($emailError[1]) {
            return $emailError[0];
        }
        elseif ($emailConfirmError[1]) {
            return $emailConfirmError[0];
        }
        elseif ($emailMatchError[1]) {
            return $emailMatchError[0];
        }
        else {
            $sql = "UPDATE `".$this->tblPrefix."customers` SET title='".$title."', f_name='".$fName."', l_name='".$lName."', email='".$email."' WHERE customer_id='".$customerId."'";
            $this->query($sql);
            return array('SUC', 'PERSONAL_UPDATED');
        }
    }

    function updateAddress($customerId, $company, $address, $street, $city, $postcode, $country, $latitude, $longitude) {
        $companyError = $this->checkCompany($company);
        $countryError = $this->checkCountry($country);
        $cityError = $this->checkCity($city);
        $postcodeError = $this->checkPostcode($postcode);
        $addressError = $this->checkAddress($address);
        $streetError = $this->checkStreet($street);
        if ($countryError[1]) {
            return $countryError[0];
        }
        elseif ($cityError[1]) {
            return $cityError[0];
        }
        elseif ($postcodeError[1]) {
            return $postcodeError[0];
        }
        elseif ($addressError[1]) {
            return $addressError[0];
        }
        elseif ($streetError[1]) {
            return $streetError[0];
        }
        else {
            $sql = "UPDATE `".$this->tblPrefix."customers` SET company='".ucwords($company)."', address='".ucwords($address)."', street='".ucwords($street)."', city='".ucwords($city)."', postal='".strtoupper($postcode)."',  country='".$country."', latitude='".$latitude."', longitude='".$longitude."' WHERE customer_id='".$customerId."'";
            $this->query($sql);
            return array('SUC', 'ADDRESS_UPDATED');
        }
    }
      function time_array(){                        $time_array = array();                        $time_array = array(0=>'Closed');                                                $e=6;                                                for($i=6;$i<24;$i++){                            $time_array[$e] = $i.':00';                            $e++;                            $time_array[$e] = $i.':30';                            $e++;                        }               return $time_array;    }
    function updateBusiness($customerId, $mon, $sat,$sun, $website, $show_website){
        //$this->dev = true;
         $sql = "UPDATE `".$this->tblPrefix."customers` SET mon='".$mon."', sat='".$sat."', sun='".$sun."', website='".$website."', show_website = '".$show_website."' WHERE customer_id='".$customerId."'";
         $this->query($sql);
         return array('SUC', 'BUSINESS_UPDATED');
    }

    function updateSubcriptons($customerId, $subscription, $package,$expire,$packageExtend='',$profileId='') {

        switch ($subscription) {
            case 'M': {
                    $sqlSelect = "SELECT subscription_type,package_type,expire,no_of_listings FROM `".$this->tblPrefix."subscriptions` WHERE customer_id='".$customerId."' AND subscription_type='M'";
                    $resultSelect = $this->query($sqlSelect);

                    if (count($resultSelect) > 0) {
                        switch ($package) {
                            case 'G': {
                                    //$noOfListings = $resultSelect[0]['no_of_listings'] + $this->gold;
                                    $noOfListings=$this->gold;
                                }break

                                ;
                            case 'S': {
                                    $noOfListings =  $this->silver;
                                }break

                                ;
                            case 'B': {
                                    $noOfListings =  $this->bronze;
                                }break

                                ;
                        }

                        /**
                         * Set expiration time
                         */

//                        if($resultSelect[0]['expire']=='') $resultSelect[0]['expire']=time();
//                        if($resultSelect[0]['package_type']==$package) {
//                            // time expanding
//                            $expire = $resultSelect[0]['expire'];
//                        }
//                        else {
//                            // time should keep as it is
//                            if(!$expire || $expire<time() ||strlen($expire)<10)  $expire = mktime(0, 0, 0, date("m"), date("d"), date("Y", time())+1);
//                        }

                        $sql = "UPDATE `".$this->tblPrefix."subscriptions`
                                SET package_type='".$package."', last_modified='".time()."',
                                no_of_listings='".$noOfListings."', expire='".$expire."',
                                package_type_extend='".$packageExtend."',recurring_profile_id='".$profileId."',
                                subscription_status='Y',alert='N' WHERE customer_id='".$customerId."' AND subscription_type='M'";
                    }
                    else {
                        switch ($package) {
                            case 'G': {
                                    $noOfListings = $this->gold;
                                }break

                                ;
                            case 'S': {
                                    $noOfListings = $this->silver;
                                }break

                                ;
                            case 'B': {
                                    $noOfListings = $this->bronze;
                                }break

                                ;
                        }
                        // time should keep as it is
                        if(!$expire || $expire<time() ||strlen($expire)<10) $expire = mktime(0, 0, 0, date("m"), date("d"), date("Y", time())+1);

                        $sql = "INSERT INTO `".$this->tblPrefix."subscriptions`
                                (`customer_id`, `subscription_type`, `package_type`,
                                `date`, `last_modified`, `expire`, `no_of_listings`,
                                `subscription_status`,`package_type_extend`,`recurring_profile_id`)
                                VALUES ('".$customerId."', 'M', '".$package."', '".time()."',
                                '".time()."', '".$expire."', '".$noOfListings."', 'Y',
                                '".$packageExtend."', '".$profileId."')";
                    }
                }break

                ;
            case 'S': {
                    $sqlSelect = "SELECT subscription_type, expire, no_of_listings FROM `".$this->tblPrefix."subscriptions` WHERE customer_id='".$customerId."' AND subscription_type='S'";
                    $resultSelect = $this->query($sqlSelect);

                    if (count($resultSelect) > 0) {
                        /*
                         * Control Invalid dates
                        */
//                            if($resultSelect[0]['expire'])
//                            {
//                                if(date("Y",$resultSelect[0]['expire'])<2008) $resultSelect[0]['expire']=time();
//                            }
//                            else
//                            {
//                                $resultSelect[0]['expire']=time();
//                            }
//
//						if ($package != '12')
//						{
//							$expire = mktime(0, 0, 0, date("m", intval($resultSelect[0]['expire']))+$package, date("d", intval($resultSelect[0]['expire'])), date("Y", intval($resultSelect[0]['expire'])));
//						}
//						else
//						{
//							$expire = mktime(0, 0, 0, date("m", $resultSelect[0]['expire']), date("d", $resultSelect[0]['expire']), date("Y", $resultSelect[0]['expire'])+1);
//						}
                        $sql = "UPDATE `".$this->tblPrefix."subscriptions` SET package_type='".$package."', last_modified='".time()."', expire='".$expire."', subscription_status='Y',recurring_profile_id='".$profileId."',alert='N' WHERE customer_id='".$customerId."' AND subscription_type='S'";
                    }
                    else {
//						if ($package != '12')
//						{
//							$expire = mktime(0, 0, 0, date("m", time())+$package, date("d"), date("Y"));
//						}
//						else
//						{
//							$expire = mktime(0, 0, 0, date("m"), date("d"), date("Y", time())+1);
//						}
                        $sql = "INSERT INTO `".$this->tblPrefix."subscriptions` (`customer_id`, `subscription_type`, `package_type`, `date`, `last_modified`, `expire`, `no_of_listings`, `subscription_status`,`recurring_profile_id`) VALUES ('".$customerId."', 'S', '".$package."', '".time()."', '".time()."', '".$expire."', '0', 'Y','".$profileId."')";
                    }
                }
        }
        $result = $this->query($sql);
        return true;
    }

    function changePassword($customerId, $password, $newPassword, $newPasswordConfirm) {
        $sql = "SELECT COUNT(*) FROM `".$this->tblPrefix."customers` WHERE customer_id='".$customerId."' AND password='".$this->encryptPassword($password)."'";
        $result=$this->query($sql);
        if($result[0]["COUNT(*)"]>0) {
            $passwordError = $this->checkPassword($newPassword, '', 'password');
            $passwordConfirmError = $this->checkPassword('', $newPasswordConfirm, 'passwordConfirm');
            $passwordMatchError = $this->checkPassword($newPassword, $newPasswordConfirm, '');
            if ($passwordError[1]) {
                return $passwordError[0];
            }
            elseif ($passwordConfirmError[1]) {
                return $passwordConfirmError[0];
            }
            elseif ($passwordMatchError[1]) {
                return $passwordMatchError[0];
            }
            else {
                $encryptedPassword = $this->encryptPassword($newPassword);
                $sql = "UPDATE `".$this->tblPrefix."customers` SET password = '".$encryptedPassword."', pass = '".$newPassword."' WHERE customer_id='".$customerId."'";
                $this->query($sql);
                $sql_email = "SELECT email FROM `".$this->tblPrefix."customers` WHERE customer_id='".$customerId."'";
                $result = $this->query($sql_email);
                $email = $result[0]["email"];
                $objEmail = new Email();
                //$objEmail->send('password', $email, $email."||".$newPassword."||change");
                $objEmail->send('password', $email, $newPassword."|x|".$customerId."|x|");
                $msg = array('SUC', 'PASSWORD_CHANGED');
                return $msg;
            
            }
        }
        else {
            $msg = array('ERR', 'WRONG_PASSWORD');
            return $msg;
        }
    }

    function setSubcriptons($customerId, $subscription='C', $package='',$expire='',$flag='', $package_type_extend='') {
        if(!$subscription) $subscription='C';
        if(!$expire) $expire=time();
        $sqlCount = "SELECT COUNT(*) FROM `".$this->tblPrefix."subscriptions` WHERE customer_id='".$customerId."' AND subscription_type='".$subscription."'";
        $result = $this->query($sqlCount);
        if ($result[0]['COUNT(*)'] == 0) {
            if (empty($subscription)) {
                $status = 'Y';
                $subscription = 'C';
            }
            else {
                if($flag=="admin"){
                    $status = 'Y';
                    $no_of_listings = "50";
                }
                else{
                    $status = 'N';
                    $no_of_listings = "";
                }
            }
            $sql = "INSERT INTO `".$this->tblPrefix."subscriptions` (`customer_id`, `subscription_type`, `package_type`,`package_type_extend`, `date`, `last_modified`, `expire`, `no_of_listings`, `subscription_status`) VALUES ('".$customerId."', '".$subscription."', '".$package."', '".$package_type_extend."', '".time()."', '', '".$expire."', '".$no_of_listings."', '".$status."')";
            if ($this->query($sql)) {
                if ($subscription == 'C') {
                    $this->setStatus($customerId, 'Y', '', 'cus');
                }
                return true;
            }
        }
    }

    function removeSubscriptions($customerId, $subscription) {
        if ($subscription!='C') {

            $sqlCount = "SELECT COUNT(*) FROM `".$this->tblPrefix."subscriptions` WHERE customer_id='".$customerId."'
                      AND subscription_type='".$subscription."' AND `date`=`expire` AND subscription_status='N' ";  
            $result = $this->query($sqlCount);

            if ($result[0]['COUNT(*)'] == 1) {
                $sql=" DELETE FROM `".$this->tblPrefix."subscriptions` WHERE customer_id='".$customerId."'
                      AND subscription_type='".$subscription."' AND `date`=`expire` AND subscription_status='N'";

                return $this->query($sql);
            }
        }

    }

    /*
         * gets listing data for each top level category, category and sub-category for a specific supplier
         * inputs: $customerId, $topId, $catId, $subCatId, $tblId=''
         * outputs: an array of data according to the top level category 
    */
    function getListings($customerId, $topId, $catId, $subCatId, $tblId='',$time='', $pg=1, $url='') {

        switch ($time) {

            case "all": {
                    $tfm = 1;
                    $tto = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));

                }break

                ;
            case "date": {
                    $tfm = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                    $tto = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
                }break

                ;
            case "week": {
                    $tfm = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                    $tto = mktime(0, 0, 0, date("m"), date("d")-7, date("Y"));
                }break

                ;
            case "month": {
                    $tfm = mktime(0, 0, 0, date("m"), 0, date("Y"));
                    $tto = mktime(0, 0, 0, date("m")+1,0, date("Y"));

                }


        }

        // admin could be able to see all the listings without any issue
        //
        if($this->loggedUser!="Admin") $sqlHidModaratedList="AND (listing_active='Y' OR listing_active='N')";
        //echo date("d/m/Y h:i:s A",$tfm); echo "<br />";echo date("d/m/Y h:i:s A",$tto);
        //$this->dev=true;

        switch ($topId) {
            case 1: {
                    if ($catId && $subCatId) {

                        if(empty($tfm) && empty($tto) ) {

                            $sql = "SELECT specifications.specification, manufacturers.manufacturer, listing_materials.unit_cost,listing_materials.supplier_id,
listing_materials.bulk_discount, listing_materials.bulk_price, listing_materials.delivery, listing_materials.supplier_code, listing_materials.id, listing_materials.listing_active, listing_materials.deact_reason, listing_materials.image as list_image, listing_materials.description as list_desc, categories.image, specifications.keywords FROM `".$this->tblPrefix."listing_materials`
listing_materials JOIN `".$this->tblPrefix."specifications` specifications ON listing_materials.specification_id=specifications.id JOIN
`".$this->tblPrefix."manufacturers` manufacturers ON listing_materials.manufacturer_id=manufacturers.id JOIN `".$this->tblPrefix."categories` categories ON listing_materials.category_id_2=categories.id WHERE listing_materials.supplier_id='".$customerId."'
AND listing_materials.category_id_1='".$catId."' AND listing_materials.category_id_2='".$subCatId."' $sqlHidModaratedList";
                        }else {
                            $sql = "SELECT specifications.specification, manufacturers.manufacturer,listing_materials.supplier_id, listing_materials.unit_cost, customers.title,customers.f_name,customers.l_name,
listing_materials.bulk_discount, listing_materials.bulk_price, listing_materials.delivery, listing_materials.id, listing_materials.supplier_code, listing_materials.listing_active, listing_materials.deact_reason, listing_materials.image as list_image, listing_materials.description as list_desc,categories.image, specifications.keywords FROM `".$this->tblPrefix."listing_materials`
listing_materials JOIN `".$this->tblPrefix."specifications` specifications ON listing_materials.specification_id=specifications.id JOIN
`".$this->tblPrefix."manufacturers` manufacturers ON listing_materials.manufacturer_id=manufacturers.id JOIN `".$this->tblPrefix."categories` categories ON listing_materials.category_id_2=categories.id JOIN `".$this->tblPrefix."customers` customers ON (listing_materials.supplier_id = customers.customer_id) WHERE (listing_materials.added_time between '".$tfm."' AND '".$tto."' )
AND listing_materials.category_id_1='".$catId."' AND listing_materials.category_id_2='".$subCatId."' $sqlHidModaratedList";
                        }

                        if ($tblId) {
                            $sql.= " AND listing_materials.id='".$tblId."'";
                        }
                        $result = $this->queryPg($sql, $pg, $this->recordsConsole, $url);

                        if ($result) {
                            for($i=0;$i<count($result);$i++) {
                                $list[$i][]=$result[$i]['specification'];       //0
                                $list[$i][]=$result[$i]['manufacturer'];        //1
                                $list[$i][]=$result[$i]['unit_cost'];           //2
                                $list[$i][]=$result[$i]['bulk_discount'];       //3
                                $list[$i][]=$result[$i]['bulk_price'];          //4
                                $list[$i][]=$result[$i]['delivery'];            //5
                                $list[$i][]=$result[$i]['id'];                  //6
                                $list[$i][]=$result[$i]['listing_active'];      //7
                                $list[$i][]=$result[$i]['image'];               //8
                                $list[$i][]=$result[$i]['keywords'];            //9
                                $list[$i][]=$result[$i]['supplier_id'];     //10
                                if(!empty($tfm) && !empty($tto)) {

                                    $list[$i][]=$result[$i]['title'];           //11
                                    $list[$i][]=$result[$i]['f_name'];          //12
                                    $list[$i][]=$result[$i]['l_name'];          //13
                                }
                                $list[$i][14]=$result[$i]['deact_reason'];      //14
                                $list[$i][15]=$result[$i]['list_image'];        //15
                                $list[$i][16]=$result[$i]['list_desc'];         //16
                                $list[$i][17]=$result[$i]['supplier_code'];     //17
                            }
                            return $list;
                        }
                        else {
                            return array('ERR', 'NO_RESULT');
                        }
                    }
                    else {
                        return array('ERR', 'SUB_CAT_NOT_SELECTED');
                    }
                }break

                ;

            case 2: {
                    if ($catId || $subCatId) {
                        if(empty($tfm) && empty($tto) ) {
                            // chelanga changing the value status field M to N
                            $sql = "SELECT business_name, affiliations, price, call_out_charge, image, contact_person, accreditation, website, id, status, keywords, deact_reason
 FROM `".$this->tblPrefix."services` WHERE supplier_id='".$customerId."' AND category_id_1='".$catId."' AND category_id_2='".$subCatId."' $sqlHidModaratedList";
                        }else {
                            $sql = "SELECT services.business_name, services.affiliations, services.price, services.call_out_charge,services.image, services.contact_person, services.accreditation, services.website, services.id, services.status, services.keywords, services.deact_reason , services.added_date , customers.customer_id, customers.title,customers.f_name,customers.l_name
 FROM `".$this->tblPrefix."services` services JOIN `".$this->tblPrefix."customers` customers ON (services.supplier_id = customers.customer_id) WHERE (services.added_date between '".$tfm."' AND '".$tto."') AND category_id_1='".$catId."' AND category_id_2='".$subCatId."'";
                        }
                        if ($tblId) {
                            $sql.= " AND id='".$tblId."'";
                        }
                        $result = $this->queryPg($sql, $pg, $this->recordsConsole, $url);
                        //  print_r( $result);
//echo $result[0]['added_date'];
                        //     echo date("d/m/Y h:i:s A",$result[0]['added_date']);
                        if ($result) {
                            for($i=0;$i<count($result);$i++) {
                                $list[$i][]=$result[$i]['business_name'];//0
                                $list[$i][]=$result[$i]['affiliations'];//1
                                $list[$i][]=$result[$i]['price'];//2
                                $list[$i][]=$result[$i]['call_out_charge'];//3
                                $list[$i][]=$result[$i]['image'];//4
                                $list[$i][]=$result[$i]['contact_person'];//5
                                $list[$i][]=$result[$i]['accreditation'];//6
                                $list[$i][]=$result[$i]['website'];//7
                                $list[$i][]=$result[$i]['id'];//8
                                $list[$i][]=$result[$i]['status'];//9
                                $list[$i][]=$result[$i]['keywords'];//10
                                $list[$i][]=$result[$i]['deact_reason'];//11
                                if(!empty($tfm) && !empty($tto)) {
                                    $list[$i][]=$result[$i]['customer_id'];//12
                                    $list[$i][]=$result[$i]['title'];//13
                                    $list[$i][]=$result[$i]['f_name'];//14
                                    $list[$i][]=$result[$i]['l_name'];//15
                                }


                            }


                            return $list;
                        }
                        else {
                            return array('ERR', 'NO_RESULT');
                        }
                    }
                    else {
                        return array('ERR', 'SUB_CAT_NOT_SELECTED');
                    }
                }break

                ;

            case 3: {
                    if ($catId || $subCatId) {

                        if(empty($tfm) && empty($tto) ) {
                            $sql = "SELECT ad_title, price, image, invoice_no, id, status, keywords, notes, deact_reason FROM `".$this->tblPrefix."classified_ads` WHERE supplier_id='".$customerId."'
AND category_id_1='".$catId."' AND category_id_2='".$subCatId."' $sqlHidModaratedList";
                        }else {
                            $sql = "SELECT classads.ad_title, classads.price, classads.image, classads.invoice_no, classads.id, classads.status, classads.keywords, classads.notes, classads.deact_reason , customers.customer_id, customers.title,customers.f_name,customers.l_name FROM `".$this->tblPrefix."classified_ads` classads JOIN `".$this->tblPrefix."customers` customers ON (classads.supplier_id = customers.customer_id) WHERE (classads.added_date between '".$tfm."' AND '".$tto."')
AND classads.category_id_1='".$catId."' AND classads.category_id_2='".$subCatId."' $sqlHidModaratedList";
                        }

                        if ($tblId) {
                            $sql.= " AND id='".$tblId."'";
                        }
                        $result = $this->queryPg($sql, $pg, $this->recordsConsole, $url);

                        if ($result) {
                            for($i=0;$i<count($result);$i++) {
                                $list[$i][]=$result[$i]['ad_title'];//0
                                $list[$i][]=$result[$i]['price'];//1
                                $list[$i][]=$result[$i]['image'];//2
                                $list[$i][]=$result[$i]['invoice_no'];//3
                                $list[$i][]=$result[$i]['id'];//4
                                $list[$i][]=$result[$i]['status'];//5
                                $list[$i][]=$result[$i]['keywords'];//6
                                $list[$i][]=$result[$i]['notes'];//7
                                $list[$i][]=$result[$i]['deact_reason'];//8
                                if(!empty($tfm) && !empty($tto)) {
                                    $list[$i][]=$result[$i]['customer_id'];//9
                                    $list[$i][]=$result[$i]['title'];//10
                                    $list[$i][]=$result[$i]['f_name'];//11
                                    $list[$i][]=$result[$i]['l_name'];//12
                                }
                            }

                            return $list;
                        }
                        else {
                            return array('ERR', 'NO_RESULT');
                        }
                    }
                    else {
                        return array('ERR', 'SUB_CAT_NOT_SELECTED');
                    }
                }break

                ;
        }
    }

    /*
         * return the total count of listings for a supplier
         * inputs: customer_id
         * outputs: number of listings for supplies, services and classified-ads
         * remarks: commented in classes listings, services and classified_ads 
    */
    function getListingCount($var) {

        /* Re Arranged by Saliya - 1011 - Mar -02 */
        $tfm = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        switch($var) {

            case "all": {
                    // default values will be taken
                } break
                ;
            case "date": {                  
                    $tto = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
                    $timeBetween=" between '".$tfm."' AND '".$tto."'";
                } break
                ;
            case "week": {
                    $tfm = mktime(0, 0, 0, date("m"), date("d")-6, date("Y"));
                    $tto = mktime(0, 0, 0, date("m"), date("d")+1, date("Y"));
                    $timeBetween=" between '".$tfm."' AND '".$tto."'";
                } break
                ;
            case "month": {                    
                    $tto = mktime(0, 0, 0, date("m")+1,0, date("Y"));
                    $timeBetween=" between '".$tfm."' AND '".$tto."'";
                } break
                ;
            default: {
                $sqlExtra=" supplier_id='".$var."' AND ";                   
                }
        } // End Switch
            
            if($timeBetween)$sqlExtraSupplies   =" ( listing_materials.added_time  $timeBetween ) AND ";
            if($timeBetween)$sqlExtraServices   =" ( added_date  $timeBetween ) AND ";
            if($timeBetween)$sqlExtraClassified =" ( added_date  $timeBetween ) AND ";

            $sqlSupplies = "SELECT COUNT(*) FROM `".$this->tblPrefix."listing_materials` listing_materials
            JOIN `".$this->tblPrefix."specifications` specifications
                ON listing_materials.specification_id=specifications.id
            JOIN `".$this->tblPrefix."manufacturers` manufacturers
                ON listing_materials.manufacturer_id=manufacturers.id
            JOIN `".$this->tblPrefix."categories` categories
                ON listing_materials.category_id_2=categories.id
                WHERE $sqlExtraSupplies (listing_active='Y' OR listing_active='M')";
            
            $sqlServices = "SELECT COUNT(*) FROM `".$this->tblPrefix."services`
                WHERE $sqlExtraServices (status='Y' OR status='M')";
            
            $sqlClassifieds = "SELECT COUNT(*) FROM `".$this->tblPrefix."classified_ads`
                WHERE $sqlExtraClassified (status='Y' OR status='M')";
            $resultSupplies=$this->query($sqlSupplies);
            $resultServices=$this->query($sqlServices);
            $resultClassifieds=$this->query($sqlClassifieds);

            $resultArray[]['COUNT(*)']=$resultSupplies[0]['COUNT(*)'];
            $resultArray[]['COUNT(*)']=$resultServices[0]['COUNT(*)'];
            $resultArray[]['COUNT(*)']=$resultClassifieds[0]['COUNT(*)'];
            
            return $resultArray;

            /* purpose of this code change is to optimize the existing queries and return the result acordin
             * to the previous method, in order to minimize the impact of this code change for other modules.
             */

    }

    /*
         * returns the ids of listing added categories and sub-categories for a supplier
         * inputs: customer_id
         * outputs: ids
    */
    function getListingIds($customerId) {
        $sql = "SELECT `category_id_0`, `category_id_1` ,`category_id_2` FROM `".$this->tblPrefix."listing_materials` WHERE supplier_id='".$customerId."' UNION
SELECT `category_id_0`, `category_id_1` ,`category_id_2` FROM `".$this->tblPrefix."services` WHERE supplier_id='".$customerId."' UNION
SELECT `category_id_0`, `category_id_1` ,`category_id_2` FROM `".$this->tblPrefix."classified_ads` WHERE supplier_id='".$customerId."'";
        //echo  $sql;
        $result = $this->query($sql);
        for($i=0;$i<count($result);$i++) {
            $list[$i][]=$result[$i]['category_id_0'];//0
            $list[$i][]=$result[$i]['category_id_1'];//1
            $list[$i][]=$result[$i]['category_id_2'];//2
        }
        return $list;

    }



    /*
       * Function to check expiaration on a given subscription data array
    */
    function getSubscriptionStatus($subcriptionData,$subscription="M") {

        for ($i=0; $i<count($subcriptionData); $i++) {
            if($subcriptionData[$i][2]==$subscription) {
                $freez=$i;
                break;
            }
        }

        // we have the requested subscription as $freez
        //
        // Now we can check whether specific profile has been expired or not

        $toBeExpired=$subcriptionData[$freez][5];
        if($toBeExpired){
            $toBeAlerted= mktime(0, 0, 0, date("m",$toBeExpired)  , date("d",$toBeExpired)-14, date("Y",$toBeExpired));
        }
        

        // Check profile if available
        if($subcriptionData[$freez][8]) {
            $profileFound=true;
            // Rucurring profile found
            // Profile details in the 100th index
            $cyclesRemaining=$subcriptionData[$freez][100]['RecurringPaymentsSummary']['NumberCyclesRemaining'];
            if($cyclesRemaining==-1||$cyclesRemaining>0) {
                $activeSchedule=true;
            }
            else {
                $activeSchedule=false;
            }
        }
        else {
            $profileFound=false;
        }

        // we have necessory information in our hand now
        // lets do checking each status

        if($toBeExpired<time()) {
            $flag[0]='EXPIRED';
        }
        elseif($toBeAlerted<time()) {
            $flag[0]='ACTIVE'; // currently active

            if($activeSchedule) {
                $flag[1]='AUTO'; // auto payment on
            }
            else {
                $flag[1]='TO-EXPIRE'; // auto payment on
            }



        }
        else {
            $flag[0]='ACTIVE'; // Active
            if($activeSchedule) $flag[1]='AUTO'; // auto payment on
        }

        return array(
                // TO be expanded when necessory
                'Subscription'=>'',
                'Package'=>'',
                'Expire'=>$toBeExpired,

                'Flags'=>$flag,
        );



    } 
    
    function isSubscribed($cus_email,$subscription){
        $sql = "SELECT ".$subscription." from `".$this->tblPrefix."email_subscriptions` WHERE cus_Id=(SELECT customer_id FROM `".$this->tblPrefix."customers` WHERE email = '".$cus_email."')";
        $result = $this->query($sql);
        
        //print_r($result);
        //echo $result[0][$subscription];
        if($result[0][$subscription]=='Y'){
            return true;
            
        }
        else{
            return false;
        }
    }
    
        private function createKey($alphKeyLength=8 /* length of key*/,$addTime=false) {
        // declare the $key variable
        $key = "";

        $alphSmall = range("a","z"); // create an array for simple letters
        $alphCaps = range("A","Z");  // create an array for capital letters
        $alphNum = range(0,9);  // create an array for numbers
        $alphSpec = array('.','_','@',"|","*",","); // *NOTE - dont use   & ] %  ? [


        $alphArray=array_merge($alphSmall,$alphCaps,$alphNum,$alphSpec);
        $alphArrayLength=count($alphArray)-1;


        for($i = 0; $i < $alphKeyLength; $i++) {

            $key .= $alphArray[rand(0,$alphArrayLength)];

        } // End of the for loop

        if($addTime) $key.=time();//  add the timestamp

        return $key;

    }// End - function
    
    function getVerifiationCode($id){
        $sql = "SELECT ver_key FROM `".$this->tblPrefix."customers` WHERE customer_id='".$id."'";
        
        $result = $this->query($sql);
        
        if($result['register_status']=='E'){
            return array();
        }
        else{
            return $result;
        }
    }
    
    function getVerificationLinks($id,$pass=''){
         $sql = "SELECT ver_key,email FROM `".$this->tblPrefix."customers` WHERE customer_id='".$id."'";
        
        $result = $this->query($sql);
        $links = array();
        
       if($result){
           $links['activate'] = "<a href='http://".$_SERVER['SERVER_NAME'].$this->config['URL_FRONT']."/signup/?f=verify&uid=".$id."&email=".$result[0]['email']."&ver_code=".$result[0]['ver_key']."&ps=$pass'>Activate</a>";
           
           $links['reset'] = "<a href='http://".$_SERVER['SERVER_NAME'].$this->config['URL_FRONT']."/signup/?f=reset&uid=".$id."&email=".$result[0]['email']."'>Reset</a>";
           
           
           return $links;
       }
    }
    
    function getEmailSubscriptions($id){
         $sql = "SELECT * FROM `".$this->tblPrefix."email_subscriptions` WHERE cus_Id='".$id."'";
        
        $result = $this->query($sql);
        
        
       if($result){
           return $result;
       }
    }
    function updateEmailSubscriptions($id,$order,$password,$expiration,$renew,$promo){
        
        if($order=='true'){
            $order = 'Y';
        }
        else{
            $order = 'N';
        }
        if($password=='true'){
            $password = 'Y';
        }
        else{
            $password = 'N';
        }
        if($expiration=='true'){
            $expiration = 'Y';
        }
        else{
             $expiration = 'N';
        }
        if($renew=='true'){
            $renew = 'Y';
        }
        else{
            $renew = 'N';
        }
        if($promo=='true'){
            $promo = 'Y';
        }
        else{
            $promo = 'N';
        }
        
        $sql = "UPDATE `".$this->tblPrefix."email_subscriptions` SET `order` ='".$order."', `password` = '".$password."', `expiration` = '".$expiration."', `renew` = '".$renew."', `promo` = '".$promo."' WHERE cus_Id='".$id."'";
        
        $this->query($sql);
      
        return array('SUC', 'EMAIL_SUBSCRIPTIONS_UPDATED');
        
        //return "kaw";
    }
     function getCustomerByEmail($email){
        $sql = " WHERE email = '$email'";
       return $this->dList($sql);
        
    }
} // End - Class

?>