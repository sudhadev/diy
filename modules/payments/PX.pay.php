<?

  /*--------------------------------------------------------------------------\
  '    This file is part of module library of FUSIS                           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  client_info.tp.php                                      '
  '    PURPOSE         :  Footer for Admin console                            '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------
  */
  
  include($base->_SW['DIR_MODULES']."/payments/PX.functions.php");
  //Set Billing Address
  $billingAddress=$orders->cInfo[0][6];
  if($orders->cInfo[0][7]){$billingAddress.="\n".$orders->cInfo[0][7];}
  if($orders->cInfo[0][8]){$billingAddress.="\n".$orders->cInfo[0][8];}
  if($orders->cInfo[0][10]){$billingAddress.="\n".$orders->cInfo[0][10];}
  if($orders->cInfo[0][11]){$billingAddress.="\n".$orders->cInfo[0][11];}

  //Set Delevery Address
  $deleveryAddress=$orders->cInfo[0][20];
  if($orders->cInfo[0][21]){$deleveryAddress.="\n".$orders->cInfo[0][21];}
  if($orders->cInfo[0][22]){$deleveryAddress.="\n".$orders->cInfo[0][22];}
  if($orders->cInfo[0][24]){$deleveryAddress.="\n".$orders->cInfo[0][24];}
  if($orders->cInfo[0][25]){$deleveryAddress.="\n".$orders->cInfo[0][25];}

  

  
 // PROTX CODE 
  
/**********************************************************************
** Script Name:   submit3.php                                        **
** Version:       1.3 - 21-jan-05                                    **
** Author:        Pat Fox                                            **
** Function:      This page contains the hidden and encrypted        **
**                information that would be sent to a client         **
**                browser as part of a normal transaction.           **
**                                                                   **
** Revision History:                                                 **
** Version  Author      Date and notes                               **
**    1.0   Mat Peck    18/01/2002 - First ASP release               **
**    1.1   Mat Peck    04/04/2002 - Extended for 2.20 protocol      **
**    1.2   Pat Fox     30/07/2002 - PHP version                     **
**    1.2   Tony Welch  9/07/2003 - Addition of post code fields 2.21**
**    1.3   Peter G     21-jan-05 - Add new 2.22 fields to crypt     **
***********************************************************************/

// ** retrieve the information posted from the previous form. **
$ThisVendorTxCode = $invoice_number;
$ThisAmount = $total_Amount;
$ThisCurrency = $base->_SW['CURRENCY_PAY_GATE'];
$ThisDescription = $base->_SW['SHOP_NAME']." Online Shop";
$ThisCustomerEmail= $orders->cInfo[0][15];;
$ThisCustomerName= $orders->cInfo[0][2]." ".$orders->cInfo[0][3];
$ThisVendorEmail= $base->_SW['MAIL_PAY_GATE'];
$ThisDeliveryAddress= $deleveryAddress;
$ThisDeliveryPostCode= $orders->cInfo[0][23];
$ThisBillingAddress= $billingAddress;
$ThisBillingPostCode= $orders->cInfo[0][9];
// new 2.22 fields
$ThisContactNumber = $orders->cInfo[0][13];
$ThisContactFax = $orders->cInfo[0][14];
$ThisAllowGiftAid = 0;
$ThisApplyAVSCV2 = 0;
$ThisApply3DSecure = 0;

if (isset($ShoppingBasket)) {
  $ThisShoppingBasket= $_REQUEST['ShoppingBasket'];
} else {
  $ThisShoppingBasket="OFF";  
}

//** Build the crypt string plaintext **
$stuff = "VendorTxCode=" . $ThisVendorTxCode . "&";
$stuff .= "Amount=" . $ThisAmount . "&";
$stuff .= "Currency=" . $ThisCurrency . "&";
$stuff .= "Description=" . $ThisDescription . "&";
$stuff .= "SuccessURL=" . $MyServer . "/thanks/?f=tks&";
$stuff .= "FailureURL=" . $MyServer . "/thanks/?f=err&";

if ($ThisCustomerEmail) {
  $stuff .= "CustomerEmail=" . $ThisCustomerEmail . "&";
}
if ($ThisVendorEmail) {
  $stuff .= "VendorEmail=" . $ThisVendorEmail . "&";
}
if ($ThisCustomerName) {
  $stuff .= "CustomerName=" . $ThisCustomerName . "&";
}
if ($ThisDeliveryAddress) {
  $stuff .= "DeliveryAddress=" . $ThisDeliveryAddress . "&";
}
if ($ThisDeliveryPostCode) {
  $stuff .= "DeliveryPostCode=" . $ThisDeliveryPostCode . "&";
}
if ($ThisBillingAddress) {
  $stuff .= "BillingAddress=" . $ThisBillingAddress . "&";
}
if ($ThisBillingPostCode) {
  $stuff .= "BillingPostCode=" . $ThisBillingPostCode . "&";
}
// new 2.22 fields
if ($ThisContactNumber) {
  $stuff .= "ContactNumber=" . $ThisContactNumber . "&";
}
if ($ThisContactFax) {
  $stuff .= "ContactFax=" . $ThisContactFax . "&";
}
if ($ThisAllowGiftAid) {
  $stuff .= "AllowGiftAid=" . $ThisAllowGiftAid . "&";
}
if ($ThisApplyAVSCV2) {
  $stuff .= "ApplyAVSCV2=" . $ThisApplyAVSCV2 . "&";
}
if ($ThisApply3DSecure) {
  $stuff .= "Apply3DSecure=" . $ThisApply3DSecure . "&";
}

if ($ThisShoppingBasket=="ON") {
  $stuff .= "Basket=3:Sony SV-234 DVD Player:1:£170.20:£29.79:£199.99:£199.99:The Fast and The Furious Region 2 DVD:2:£17.01:£2.98:£19.99:£39.98:Delivery:1:£4.99:----:£4.99:£4.99&";
}

$stuff .= "";

// ** Encrypt the plaintext string for inclusion in the hidden field **
$crypt = base64Encode(SimpleXor($stuff,$EncryptionPassword));

/*
** A fully functional script would connect up to your database here and save this information **
** For example, if you had a mySQL data source OrderDSN, containing an orders tables keyed on **
** the VendorTxCode field the following code would save this information                      **
** This assumes some info in a session variable (user name, address, order details etc)       **

// Open the database
//$db = mysql_connect("myServer", "myUserName", "myPassword");
$db = mysql_connect("localhost", "php-stickman-w", "yikes");
mysql_select_db("OrderDSN",$db);

// Create a variable to hold the date (UNIX timestamp in this example)
$ThisDate = date('U');

// Update the order details
$sql = "INSERT INTO tblOrders(VendorTxCode,Amount,OrderDate,Name,Address,OrderDetails,Status,StatusDetail,VPSTxID,TxAuthNo)
        VALUES (
        '$ThisVendorTxCode',
        $ThisAmount,
        $ThisDate,
        '$SESSION_ClientName',
        '$SESSION_ClientAddress',
        '$SESSION_OrderDetails',
        'New',
        'Sent to user for sumbission',
        null,
        null
        )";
                                       
$result = mysql_query($sql,$db);
*/  
  
 ?>
<table width="95%" border="0" align="center">
  <tr>
    <td align="right">
            <!-- ************************************************************************************* -->
            <!-- This form is all that is required to submit the payment information to the VSP system -->
            </P>
            <FORM ACTION="<? echo($vspsite); ?>" METHOD="post" ID="frmPay" NAME="frmPay">
            <INPUT TYPE="hidden" NAME="VPSProtocol" VALUE="2.22">
            <INPUT TYPE="hidden" NAME="TxType" VALUE="PAYMENT">
            <INPUT TYPE="hidden" NAME="Vendor" VALUE=<? echo($VendorName);?>>
            <INPUT TYPE="hidden" NAME="Crypt" VALUE="<? echo($crypt); ?>">
			<input type="button" name="pay_now" value="<?=$_LN['PAYNOW'];?>"  class="btn_Common" onclick="frmPay.submit();"/>
             </FORM>
            <!-- ************************************************************************************* -->
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
