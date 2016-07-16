<?php

  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>     	  '
  '    FILE            :  /bin/ajax/contact_us.ajax.php       			      '
  '    PURPOSE         :  provide contact_us for any section of the system    '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

	require_once("../../classes/core/core.class.php");$objCore=new Core;
	
	/** 
	* Display the logged user.
	*/
  	$objCore->auth(1,false);
	
	if($_REQUEST['val']!="")
	{
		$errorValue=$_REQUEST['val'];
		checkData($errorValue,$objCore);
	
	} else
	{
		$subject=$_REQUEST['subj'];
		$firstName=$_REQUEST['fn'];
		$lastName=$_REQUEST['ln'];
		$contactNo=$_REQUEST['cn'];
		$email=$_REQUEST['email'];
		$organisation=$_REQUEST['orga'];
		$selection=$_REQUEST['sele'];
		$comment=$_REQUEST['comme'];
		$other=$_REQUEST['other'];
		submitFields($objCore, $subject, $firstName, $lastName, $contactNo, $email, $organisation, $selection, $comment, $other);
	}
	
	/** 
	* check the server side validation and send the appropriate success or error message to the javascript code.
	*/
	function submitFields($objCore, $subject, $firstName, $lastName, $contactNo, $email, $organisation, $selection, $comment, $other)
	{
		if($subject == "" || $firstName == "" || $lastName == "" || $contactNo == "" || $email == "" || $selection == "")
		{
			$msg=array('ERR','BLANK');
			 
		} elseif(!(check_numeric($contactNo)))
		{
			$msg=array('ERR','INVALID_PHONE'); 
			
		} elseif(strlen($contactNo)<8)
		{
			$msg=array('ERR','INVALID_LENGTH'); 
			
		} elseif(!(isValidEmail($email)))
		{
			$msg=array('ERR','EMAIL'); 
			
		} elseif($selection=="other")
		{
			if($other=="")
			{
				$msg=array('ERR','BLANK');
				
			} else
			{
				send_mail($objCore, $subject, $firstName, $lastName, $contactNo, $email, $organisation, $selection, $comment, $other);	
			}
		} else
		{
			send_mail($objCore, $subject, $firstName, $lastName, $contactNo, $email, $organisation, $selection, $comment, $other);
		} 
		
		if($msg)
		{
			echo $objCore->msgBox("CONTACT_US",$msg,'96%');	
		}
		return $msg;
	}
	
	/**
	* Check the email address is correctly insert at the revalidation part.
	*/
	function isValidEmail($email)
	{
		$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
		if (eregi($pattern, $email))
		{
			return true;
			
		}else
		{
			return false;
		}   
	}
	
	/** 
	* check the contact number is numeric one.
	*/
	/*function check_numeric($contactNo) 
	{
		$phone_pattern ="^[-]?[0-9]+([\.][0-9]+)?$";
		
		if (ereg($phone_pattern,$contactNo))
		{
			return true;
		} else
		{
			return false;
		}
	}*/
		
	function check_numeric($contactNo) 
	{
		$pattern = "^(\()?([0-9]{1,4})(\))?(\-)?( )?([0-9]{2,10})( )?(\-)?( )?([0-9]{0,10})$";
		$contactNo = trim($contactNo);
		return ereg($pattern, $contactNo);
	}

	/** 
	* Send the appropriate error message to the javascript code.
	*/
	function checkData($errorValue,$objCore)
	{
		switch($errorValue)
		{
			case 1:
			{
				$msg=array('ERR','BLANK'); 
			}break;
			
			case 2:
			{
				$msg=array('ERR','INVALID_PHONE'); 
			}break;
			
			case 3:
			{
				$msg=array('ERR','INVALID_LENGTH'); 
			}break;
	
			case 4:
			{
				$msg=array('ERR','EMAIL'); 
			}break;
		}
		
		if($msg)
		{
			echo $objCore->msgBox("CONTACT_US",$msg,'99%');	
		}
	}
	
	/**
	* Send the mail and send the appropriate success or error message to the javascript code.
	*/
	function send_mail($objCore, $subject, $firstName, $lastName, $contactNo, $email, $organisation, $selection, $comment, $other)
	{
		$howUKnow="";
	
		if($selection=="other")
		{
			$howUKnow ="Other : ".$other;
		} else{
			$howUKnow = $selection;
		}
	
		if($organisation=="")
		{
			$organisation ="Not fill";
		} else{
			$organisation =$organisation;
		}

		if($comment=="")
		{
			$comment ="Not fill";
		} else{
			$comment =$comment;
		}
	
		$senderName = $firstName." ".$lastName; /** sender's name. */
		$senderEmailAdd = $email; /** sender's e-mail address. */
	
		$recipient = $objCore->gConf['MAIL_ADMIN'];/** recipient email address - info@fusis.com. */
				
		$mailBody = "First Name:\t".$firstName.
						"\nLast Name:\t".$lastName.
						"\nContact Number:\t".$contactNo.
						"\nOrganisation:\t".$organisation.
						"\nHow did you hear about us?\t".$howUKnow.
						"\nComments:\t".$comment;
						
		$subject = "[".$objCore->gConf['TITLE_EMAILS']."] ".$subject;
		$header = "From: ".$senderName." <".$senderEmailAdd.">\r\n"; /** content of the mail. */
	
		$val="";	
	
		if (mail($recipient, $subject, $mailBody, $header))
		{
			$msg=array('SUC','SEND_EMAIL');
			$val="SUC";	
			
		} else{
			$msg=array('ERR','NOT_SEND_EMAIL'); 
			$val="ERR";	
		} 
		
		if($msg)
		{		
			echo $objCore->msgBox("CONTACT_US",$msg,'99%')."||".$val;
		}
		
	}
	
?>