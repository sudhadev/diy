<?

  /*--------------------------------------------------------------------------\
  '    This file is part of module library of FUSIS                           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Piyumi Edirimanne <piyumi1980@yahoo.com>                '
  '    FILE            :  dilivery_info.tpl.php                               '
  '    PURPOSE         :  Display Dilivery Information                        '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

?><?  $URL_PG=$base->_SW['DIR_MODULES']."/payments/".$base->_SW['GATE_WAY'].".logic.php";
                if(!file_exists($URL_PG)){


?>
                                                                        <table width="368" border="0">
                                      <tr>
                                        <td height="30" align="center" valign="middle" bgcolor="#FFFFCC"><strong><font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif">Issue In payment gateway Configuration. Please Contact Fusis IT team. </font></strong></td>
                                      </tr>
</table>
<?   }else{
     include($URL_PG);

         if($inv_Number){
                $orders->order_confrm($inv_Number);
                           $orderDat=$orders->d_list("ORDER.INV='$inv_Number'");

                   if($orderDat){
                                $orderInf=$orderDat[0];
                         }
                         // $email->dev='y';
                         $email-> send('order',$orderInf[16],$inv_Number);

         }
?>



 <table width="368"  border="0" cellpadding="0" cellspacing="0" class="shop_content_border">
                          <tr>
                            <td height="20" class="shop_content_line"><table width="100%" cellpadding="0" cellspacing="0" border="0">
                              <!-- heading -->
                              <tr>
                                <td width="32"><img src="<? echo $base->_SW['URL_SHOP'] ;?>/themes/<? echo $base->_SW['THEME_SHOP'];?>/images/misc/content_heading_bullete.gif" alt="" title="" width="32" height="32" /></td>
                                <td class="content_heading" valign="bottom"><?=$_LN['Finish']?>
                                </td>
                              </tr>
                              <!-- /heading -->
                              <!-- content section -->
                              <!-- /content section -->
                            </table></td>
   </tr>
                          <tr valign="top">
                            <td class=""><table width="100%"  border="0" cellspacing="0" cellpadding="0">
                              <tr>
                                <td width="3%">&nbsp;</td>
                                <td align="left" class="shop_contnt_text">&nbsp;</td>
                                <td width="2%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="95%" align="center" valign="top" class=""><table width="95%" border="0" align="center">
                                  <tr>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td><span class="shop_contnt_text"><strong>Thank you for your order.</strong></span></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td><span class="shop_contnt_text">We have recieved following order from you. </span></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td><? $UI='thanks';include $base->_LINK['COM+0002_1'];?></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                  </tr>
                                  <tr>
                                    <td class="shop_contnt_text">                                  One of our sales reprasantative will work on your order soon. <br />
You will recieve an email with all the information of your order and please keep that email for future reference.
                                      <br />
                                      If
                    you have any queries about your transaction Please contact Us with your invoice Number <u><b><? echo $inv_Number;?></b></u> (Please check your email) <br />
                    <br />
                    -<font size="2"><strong>
                    <?=$base->_SW['SHOP_TEAM'];?>
                    <br />
                    </strong></font><font color="#666666" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;<?=$_LN['Address'];?>
                    </strong>
                    <?=$base->_SW['SHOP_ADDRESS'];?>
                    </font><font color="#666666" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><br />
                    </strong><strong>&nbsp;&nbsp;
                    <?=$_LN['TelNo'];?>
                    </strong>
                    <?=$base->_SW['SHOP_TEL'];?>
                    </font><font color="#666666" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong><br />
                    </strong><strong>&nbsp;&nbsp;
                    <?=$_LN['FaxNo'];?>
                    </strong>
                    <?=$base->_SW['SHOP_FAX'];?>
                    </font> </font></td>
                                  </tr>
                                </table>                                </td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr>
                                <td height="33"></td>
                                <td height="33" align="center" valign="middle"></td>
                                <td height="33"></td>
                              </tr>
                            </table></td>
   </tr>
                        </table>
<? }?>