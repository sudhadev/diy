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
    <td align="right"><form id="frmPay" name="frmPay" method="post" action="http://www.fusissoft.co.uk/payment_gateway/">
      <input name="fp_back_url" type="hidden" id="fp_back_url" value="<? echo $objCore->_SYS['CONF']['URL_SYSTEM'] ;?>/my_account/payments/" />
      <input name="fp_invoice" type="hidden" id="fp_invoice" value="<?=$invoice_number;?>" />
      <input name="fp_amount" type="hidden" id="fp_amount" value="<?=$invoice_amount;?>" />
<a href="javascript:frmPay.submit();"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/next-button.jpg" border="" onclick="frmPay.submit();"/></a></div>
<!--       <a href="javascript: frmPay.submit();"></a>
      <input type="button" name="pay_now" id="pay_now" value="Proceed"  class="btn_Common" onclick="frmPay.submit();"/> -->
    </form>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
