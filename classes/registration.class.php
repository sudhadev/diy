<?php
	
	/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>      				'
  '    FILE            :  registration.class.php                              '
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
	$objCore->auth(1,false);
	
	class Registration //extends Customer
	{

		function __construct($gConf,$title='', $fName, $lName='', $email, $emailConfirm='', $password, $passwordConfirm='', $company='', $address='', $street='', $city='', $postal='', $country='', $phone='', $fax='', $mobile='', $cusType='', $latitude='', $longitude='', $subscription='', $package='')
		{				
			$this->objCustomer = new Customer($gConf);
			$this->objCustomer->setVariables($title, $fName, $lName, $email, $emailConfirm, $password, $passwordConfirm, $company, $address, $street, $city, $postal, $country, $phone, $fax, $mobile, $cusType, $latitude, $longitude, $subscription, $package);
		} 
		
		function register($cusType,$promo='',$promo_key='',$promo_code='')
		{ 		
                    if($promo=='P'){
                        $msg = $this->objCustomer->add($cusType,$promo,$promo_key,$promo_code);
                    }
                    else{
                        $msg = $this->objCustomer->add($cusType);
                    }
                            
                            return $msg;
		}
		function verify($cus_Id,$verify_code)
		{ 		
			$msg = $this->objCustomer->verify($cus_Id,$verify_code);
			return $msg;
		}
	}
	
?>
