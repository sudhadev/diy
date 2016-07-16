<?

  /*--------------------------------------------------------------------------\
  '    This file is part of module library of FUSIS                           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  PX.logic.php                                        '
  '    PURPOSE         :  Logic for filter invoice number                     '
  '    PRE CONDITION   :  depend on the payment gateway                       '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------
  */
   include($base->_SW['DIR_MODULES']."/payments/PX.functions.php");
	
   if($_REQUEST['f']=="tks"){
   
			/***********************************************************************
			** Script Name:   completed.php                                       **
			** Version:       1.3 - 21-jan-05                                     **
			** Author:        Pat Fox                                             **
			** Function:      A samples SuccessURL page                           **
			**                                                                    **
			** Revision History:                                                  **
			** Version  Author      Date and notes                                **
			**    1.0   Mat Peck    18/01/2002 - First ASP release                **
			**    1.1   Pat Fox     30/07/2002 - PHP version                      **
			**    1.2   Tony Welch  9/07/2003 - Addition of post code fields 2.21 **
			**    1.3   Peter G     21-jan-05 - Implement protocol version 2.22   **
			************************************************************************/

			/*************************************************************************************************
			 We need to decode the information sent back to us in the crypt field and break them into
			 fields we can use on our page
			*************************************************************************************************/

			// ** Decode the crypt field that was sent back to us **

			$Decoded=SimpleXor(base64Decode($_REQUEST['crypt']),$EncryptionPassword);

			// ** Split out the useful information into variables we can use **
			$values = getToken($Decoded);

			$VendorTxCode = $values['VendorTxCode'];
			$Status = $values['Status'];
			$VPSTxID = $values['VPSTxId'];
			$TxAuthNo = $values['TxAuthNo'];
			$AVSCV2 = $values['AVSCV2'];
			$Amount = $values['Amount'];
			// protocol 2.22 fields
			$AddressResult = $values[ 'AddressResult' ];
			$PostCodeResult = $values[ 'PostCodeResult' ];
			$CV2Result = $values[ 'CV2Result' ];
			$GiftAid = $values[ 'GiftAid' ];
			$VBVSecureStatus = $values[ '3DSecureStatus' ];
			$CAVV = $values[ 'CAVV' ];

			/*
			** A fully functional script would connect up to your database here and save this information **
			** For example, if you had a mySQL data source OrderDSN, containing an orders tables keyed on **
			** the VendorTxCode field the following code would save this information                      **

			// Open the database
			$db = mysql_connect("myServer", "myUserName", "myPassword");
			mysql_select_db("OrderDSN",$db);

			// Update the order details
			$sql = "UPDATE tblOrders
			        SET
			        Status='Authorised',
			        TxAuthNo= '$TxAuthNo',
			        VPSTxID='$VPSTxID'
			        WHERE VendorTxCode= '$VendorTxCode'
			        ";

			$result = mysql_query($sql,$db);
			*/
   
   
   
      $inv_Number=$VendorTxCode; 
   
   }
   
   

   


 ?>
