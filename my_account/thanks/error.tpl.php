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
                                <td height="20">&nbsp;</td>
                                <td width="95%" align="center" valign="top" class="">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr> 
							<tr>
                                <td width="3%">&nbsp;</td>
                                <td align="left" class="shop_contnt_text">&nbsp;Because an error occurred in the payment process, you will not be charged for this transaction, even if an authorization was given by the bank. Please Contact Us If you need further Assistance.<br />
                                  <br />
                                -<strong>
                                <?=$base->_SW['SHOP_TEAM'];?>
                                </strong>-<br />
                                <font color="#666666" size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>&nbsp;&nbsp;&nbsp;<?=$_LN['Address'];?>
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
                                </font> </font><br /></td>
                                <td width="2%">&nbsp;</td>
                              </tr>
                              <tr>
                                <td>&nbsp;</td>
                                <td width="95%"  height="20" align="center" valign="top" class="">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                            </table></td>
   </tr>
                        </table>
<? }?>