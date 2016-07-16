<?php

/*
 * --------------------------------------------------------------------------\
 * ' This file is part of module library of FUSIS '
 * ' (C) Copyright 2004 www.fusis.com '
 * ' ..........................................................................'
 * ' '
 * ' AUTHOR : Priya Saliya Wijesinghe <saliyasoft@yahoo.com> '
 * ' FILE : emails.class.php 				'
 * ' PURPOSE : class for users '
 * ' PRE CONDITION : commented '
 * ' COMMENTS : '
 * '--------------------------------------------------------------------------
 */
require_once ($objCore->_SYS ['PATH'] ['CLASS_SQL']);
require_once ($objCore->_SYS ['PATH'] ['CLASS_CURL']);
require_once ($objCore->_SYS ['PATH'] ['CLASS_CUSTOMER']);
class Email extends Sql {
	private $urlSystem;
	private $titleEmail;
	private $emailWebmaster;
	private $emailDeveloper;
	private $emailNoReply;
	private $cssFront;
	private $objCustomer;
	
	/*
	 */
	function __construct() {
		$this->core = new Core (); // Inherit configuration data;
		$this->urlSystem = $this->core->_SYS ['CONF'] ['URL_SYSTEM'];
		$this->cssFront = $this->core->_SYS ['CONF'] ['DIR_CSS_FRONT'];
		$this->emailDeveloper = $this->core->_SYS ['CONF'] ['MAIL_DEVELOPER'];
		$this->objCustomer = new Customer ();
		
		if (! $this->core->gConf) {
			$this->core->gConfig ();
		}
		// followings are editable via the backend
		$this->emailWebmaster = $this->core->gConf ['MAIL_ADMIN'];
		$this->emailSales = $this->core->gConf ['MAIL_SALES'];
		$this->emailNoReply = $this->core->gConf ['MAIL_RETURNS'];
		$this->titleEmail = $this->core->gConf ['TITLE_EMAILS'];
		
		$this->tblPrefix = $this->core->_SYS ['CONF'] ['PREFIX_TBL'];
		
		$this->cURL = new cURL ();
	}
	
	/*
	 */
	function send($module, $email, $id = '', $type = 'H', $param1 = '', $param2 = '') {
		$embed = $this->grab_html ( $module, $id, $param1, $param2 );
		$css = $this->grab_css ();
		$body = "<html><head></head><body><style>\n<!--\n\n" . $css . "\n\n--></style>" . "\n\n" . $embed . "</body></html>";
		// echo $body;
		switch ($module) {
			case "pending_Approval_mail_to_Customer": /* this mail function for product approval*/
        		$this->transmit ( $email, 'New Product Approval', $body, $type );
				break;
			
			case "pending_Approval_mail_to_Admin": /* this mail function for product approval*/
        			$this->transmit ( $email, 'Pending Approval', $body, $type );
				break;
			case "order" :
				
				// send email to client
				if ($this->objCustomer->isSubscribed ( $email, 'order' )) {
					$this->transmit ( $email, 'YOUR ORDER INFORMATION RECEIVED [' . $this->titleEmail . ']', $body, $type );
				}
				// send email to admin
				$em_body = $this->grab_html ( 'order_admin', $id, $param1 );
				$ebody = "<html><head><style>\n<!--\n\n" . $css . "\n\n--></style></head><body>" . "\n\n" . $em_body . "</body></html>";
				$this->transmit ( $this->emailSales, 'NEW ORDER RECEIVED [INVOICE: ' . $param1 . ']', $ebody, $type );
				break;
			
			case "register_supplier" :
				
				// send email to client
				if ($this->objCustomer->isSubscribed ( $email, 'register' )) {
					$this->transmit ( $email, 'WELCOME TO ' . $this->titleEmail . '', $body, $type );
				}
				// send email to admin
				$adminBody = $this->grab_html ( 'register_admin', $id );
				$this->transmit ( $this->emailWebmaster, 'NEW SUPPLIER REGISTRATION', $adminBody, $type );
				break;
			
			case "register_buyer" :
				
				// send email to client
				if ($this->objCustomer->isSubscribed ( $email, 'register' )) {
					$this->transmit ( $email, 'WELCOME TO ' . $this->titleEmail . '', $body, $type );
				}
				// send email to admin
				$adminBody = $this->grab_html ( 'register_buyer_admin', $id );
				$this->transmit ( $this->emailWebmaster, 'NEW BUYER REGISTRATION', $adminBody, $type );
				break;
			
			case "password" :
				
				// send email to client
				// if($this->objCustomer->isSubscribed($email, 'password')){
				$this->transmit ( $email, 'YOUR PASSWORD FOR [' . $this->titleEmail . ']', $body, $type );
				// }
				break;
			
			case "acc_moderation" :
				
				// send email to client
				$this->transmit ( $email, 'YOUR PASSWORD FOR [' . $this->titleEmail . ']', $body, $type );
				break;
			case "expiration" :
				
				// send email to client
				if ($this->objCustomer->isSubscribed ( $email, 'expiration' )) {
					$this->transmit ( $email, 'Item Expiration Notice [' . $this->titleEmail . ']', $body, $type );
				}
				break;
			case "renew" :
				
				// send email to client
				if ($this->objCustomer->isSubscribed ( $email, 'renew' )) {
					$this->transmit ( $email, 'Renewal Notice [' . $this->titleEmail . ']', $body, $type );
				}
				break;
			case "promo" :
				
				// send email to client
				// if($this->objCustomer->isSubscribed($email, 'promo')){
				$this->transmit ( $email, 'Promotional Code [' . $this->titleEmail . ']', $body, $type );
				// }
				break;
			case "promo_used" :
				
				// send email to client
				$this->transmit ( $email, 'Promotional Code used [' . $this->titleEmail . ']', $body, $type );
				break;
			case "promo_expire" :
				
				// send email to client
				$this->transmit ( $email, 'Promotional Code Expiration Alert [' . $this->titleEmail . ']', $body, $type );
				break;
			case "promo_expire_admin" :
				
				// send email to client
				$this->transmit ( $email, 'Promotional Code Expiration List [' . $this->titleEmail . ']', $body, $type );
				break;
			case "verify_supplier" :
				
				// send email to client
				// if($this->objCustomer->isSubscribed($email, 'register')){
				$this->transmit ( $email, 'WELCOME TO ' . $this->titleEmail . '', $body, $type );
				// }
				break;
			case "verify_buyer" :
				
				// send email to client
				// if($this->objCustomer->isSubscribed($email, 'register')){
				$this->transmit ( $email, 'WELCOME TO ' . $this->titleEmail . '', $body, $type );
				// }
				break;
			case "reset_verification_code" :
				
				// send email to client
				// if($this->objCustomer->isSubscribed($email, 'register')){
				$this->transmit ( $email, 'VERIFICATION CODE FOR ' . $this->titleEmail . '', $body, $type );
				// }
				break;
			// A++ send custemer email after adding data
			case "add_new_customer" :
				
				$this->transmit ( $email, 'New Customer Registration', $body, $type );
				break;
		}
	}
	
	/*
	 */
	function transmit($email, $subject, $body, $type) {
		if ($this->sendViaSMTP ( $email )) {
			// $this->emailWebmaster="jason@diypricecheck.com";
			
			// This email will be sent via a smtp server
			require_once ($this->core->_SYS ['PATH'] ['CLASS_SMTP']);
			if (! is_object ( $objSMTP ))
				$objSMTP = new Smtp ();
			$smtpResponse = $objSMTP->send ( $this->emailWebmaster, $email, $subject, $body );
			// $smtpResponse=$objSMTP->send($email, $email, $subject, $body);
			if ($smtpResponse) {
				$this->smtpMailLog ( $subject, $email );
			}
			
			if ($this->emailDeveloper) {
				@mail ( $this->emailDeveloper, $subject, $body, "From: " . $this->emailWebmaster . "\n $allHeaders" );
			}
		} else {
			// php mail function will be used for this email address
			/*
			 * Headers
			 */
			
			$allHeaders = "\nX-Priority: 1\nReturn-Path: <" . $this->emailWebmaster . ">\nReply-To: " . $this->emailNoReply . "\nX-Mailer: PHP/" . phpversion ();
			$allHeaders .= "\n charset=iso-8859-1\n";
			
			if ($type == "H") {
				$allHeaders .= "Content-Type: text/html;\n";
			}
			
			if ($this->dev == 'y') {
				echo "Subject : " . $subject . "<br/><br/>" . $body;
			}
			@mail ( $email, $subject, $body, "From: " . $this->emailWebmaster . "\n $allHeaders" );
			if ($this->emailDeveloper) {
				@mail ( $this->emailDeveloper, $subject, $body, "From: " . $this->emailWebmaster . "\n $allHeaders" );
			}
		} // end if - check smtp
	}
	
	/*
	 */
	function grab_css() {
		// $fileName=$this->cssFront."/email.css";
		$fileName = $this->urlSystem . "/css/email.css";
		if ($fileName) {
			$resCss = $this->cURL->get ( $fileName );
			if ($resCss ['code'] == 200) {
				return $resCss ['cr'];
			} else {
				return null;
			}
			
			// $fd = fopen ($fileName, "r");
			// while (!feof ($fd))
			// {
			// $buffer.= fgets($fd, 4096);
			// }
			// fclose ($fd);
			// $f_count=count($buffer[0]);
		}
		// return $buffer;
	}
	
	/*
	 */
	function grab_html($module, $id, $param1 = '', $param2 = '') {
		switch ($module) {
			case "pending_Approval_mail_to_Customer" :
				$page = "mail_to_customer.php?id=$id&specification=$param1&cus=$param2";
				break;
			
			case "pending_Approval_mail_to_Admin" :
				$page = "mail-to_admin.php?id=$id&specification=$param1&cus=$param2";
				break;
			
			case "register_supplier" :
				$page = "email_body_register_supplier.php?cid=$id&pass=$param1&flag=$param2";
				
				break;
			
			case "register_buyer" :
				$page = "email_body_register_buyer.php?cid=$id";
				break;
			
			case "order" :
				$page = "email_body_order.php?cid=$id&invoice=$param1";
				
				break;
			case "order_admin" :
				$page = "email_body_order_admin.php?cid=$id&invoice=$param1";
				break;
			
			case "register_admin" :
				$page = "email_body_register_admin.php?cid=$id";
				
				break;
			
			case "register_buyer_admin" :
				$page = "email_body_register_buyer_admin.php?cid=$id";
				
				break;
			
			case "password" :
				$page = "email_body_password.php?id=$id";
				
				break;
			case "expiration" :
				$page = "email_body_expiration_alert.php?acode=$id&name=$param1";
				
				break;
			case "renew" :
				$page = "email_body_renew.php?acode=$id&name=$param1";
				
				break;
			case "acc_moderation" :
				$page = "email_body_account_modarate.php?cid=$id&type=$param1";
				break;
			case "promo" :
				$page = "email_body_promotion_code.php?id=$id&em=$param1&subtype=$param2";
				break;
			case "promo_used" :
				$page = "email_body_promotion_code_used.php?id=$id&code=$param1";
				break;
			case "promo_expire" :
				$page = "email_body_promotion_code_expire.php?id=$id&code=$param1";
				break;
			case "promo_expire_admin" :
				$page = "email_body_promotion_code_expire_admin.php?id=$id&code=$param1";
				break;
			case "verify_supplier" :
				$page = "email_body_verify_supplier.php?id=$id&type=$param1";
				break;
			case "verify_buyer" :
				$page = "email_body_verify_buyer.php?id=$id&em=$param1";
				break;
			case "reset_verification_code" :
				$page = "email_body_reset_verificationcode.php?id=$id&em=$param1";
				break;
			/* case "add_new_customer" :
				$page = "email_body_add_new_customer.php?cid=$id&fname=$param1&lname=$param2";
				break; */
			case "add_new_customer" :
			$page = "email_body_register_supplier.php?cid=$id&fname=$param1&lname=$param2";
			break; 
		}
		
		$url = $this->urlSystem . "/modules/emails/" . $page;
		if ($url) {
			$resHtml = $this->cURL->get ( $url );
			if ($resHtml ['code'] == 200) {
				return $resHtml ['cr'];
			} else {
				return null;
			}
			
			// $fd = fopen ($url, "r");
			// while (!feof ($fd))
			// {
			// $buffer.= fgets($fd, 4096);
			// }
			// fclose ($fd);
			// $f_count=count($buffer[0]);
			//
			// }
			/*
			 * if (strstr(strtolower($_SERVER["HTTP_USER_AGENT"]), 'win'))
			 * {
			 * $fd = fopen ($url, "r");
			 * while (!feof ($fd))
			 * {
			 * $buffer.= fgets($fd, 4096);
			 * }
			 * fclose ($fd);
			 * $f_count=count($buffer[0]);
			 *
			 * }
			 * else
			 * {
			 * $fp = fsockopen($url, 80, $errno, $errstr, 30);
			 * if ($fp)
			 * {
			 * while (!feof($fp))
			 * {
			 * $buffer.=fgets($fp, 128);
			 * }
			 * fclose($fp);
			 * }
			 * }
			 * }
			 * return $buffer;
			 */
		}
	}
	private function sendViaSMTP($email) {
		// get email providers array
		$arrMailSP = explode ( "|spl|", $this->core->gConf ['MS_LIST'] );
		// print_r($arrMailSP);
		// prepare the sending email for checking
		$mailDomain = explode ( "@", $email );
		$mailDomainWithoutTLD = explode ( ".", $mailDomain [1] );
		// echo "--------->".$mailDomainWithoutTLD[0];
		// check for existance
		if (in_array ( $mailDomainWithoutTLD [0], $arrMailSP )) {
			return true;
		} else {
			return false;
		}
	} // End function sendViaSMTP
	private function smtpMailLog($subject, $email) {
		$this->query ( "INSERT INTO `" . $this->tblPrefix . "smtp_log`
                        (`subject`,`email`,`time`)
                        VALUES
                        ('" . $subject . "','" . $email . "'," . time () . ")
                    " );
	}
	public function pending_Approval_mail_to_Customer($to, $specification) {
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// $headers .= 'To: Admin <'.$this->emailWebmaster.'>' . "\r\n";
		$headers .= 'From: Reply-To <' . $this->emailNoReply . '>' . "\r\n";
		
		/*
		 * $body="<table>
		 * <tr>
		 * <td align='center'>New Product Approval</td>
		 * </tr>
		 * <tr>
		 * <td align='center'>
		 * <table>
		 * <tr>
		 * <td>Product Name </td>
		 * <td> : </td>
		 * <td>".$specification."</td>
		 * </tr>
		 * </table>
		 * </td>
		 * </tr>
		 * </table>";
		 */
		
		$url = $this->urlSystem . "/modules/emails/" . $page;
		$resHtml = $this->cURL->get ( $url );
		
		$smtpResponse = mail ( $this->emailWebmaster, 'New Product Approval', $body, $headers );
		
		if ($smtpResponse) {
			$this->smtpMailLog ( $subject, $to );
			return true;
		} else {
			return false;
		}
	}
	public function pending_Approval_mail_to_Admin($from, $specification, $keywords) { /* create by maduranga for email alert */
		// $this->core = new Core;
		require_once ($this->core->_SYS ['PATH'] ['CLASS_SMTP']);
		if (! is_object ( $objSMTP ))
			$objSMTP = new Smtp ();
		
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// $headers .= 'To: Admin <'.$this->emailWebmaster.'>' . "\r\n";
		$headers .= 'From: Reply-To <' . $this->emailNoReply . '>' . "\r\n";
		
		$body = "<table>
    				<tr>
						<td align='center'>Pending Approval</td>
    				</tr>
					<tr>
						<td align='center'>
    						<table>
								<tr>
									<td>Product Name </td>
									<td> : </td>
									<td>" . $specification . "</td>
								</tr>
							</table>
    					</td>
					</tr>
				</table>";
		
		/* email need to change */
		$smtpResponse = mail ( $this->emailWebmaster, ' Pending Approval ', $body, $headers );
		
		if ($smtpResponse) {
			$this->smtpMailLog ( $subject, $this->emailWebmaster );
			return true;
		} else {
			return false;
		}
	}
}

// end class
?>