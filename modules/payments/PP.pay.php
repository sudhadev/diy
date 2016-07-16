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
  
//$cid=$_REQUEST['id'];
 ?>
<table width="95%" border="0" align="center">
  
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><form id="frmPay" name="form1" method="post" action="http://www.fusissoft.co.uk/payment_gateway/">
      <input name="fp_back_url" type="hidden" id="fp_back_url" value="<? echo $base->_SW['URL_SHOP'] ;?>/thanks/" />
      <input name="fp_invoice" type="hidden" id="fp_invoice" value="<?=$invoice_number;?>" />
      <input name="fp_amount" type="hidden" id="fp_amount" value="<?=$invoice_amount;?>" />
      <a href="javascript: frmPay.submit();"><img src="<? echo $base->_SW['URL_SHOP'] ;?>/themes/<? echo $base->_SW['THEME_SHOP'];?>/images/buttons/btn_pay_now.gif" width="65" height="19" border="0" /></a><input type="button" name="pay_now" value="<?=$_LN['PAYNOW'];?>"  class="btn_Common" onclick="frmPay.submit();"/>
    </form>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
