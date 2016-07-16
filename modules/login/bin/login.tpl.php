<?
 /*--------------------------------------------------------------------------\
  '    This file is part of module library of FUSIS                           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Piyumi Edirimanne <piyumi1980@yahoo.com>      	  '
  '    FILE            :  console\login\tpl\login.tpl.php                     '
  '    PURPOSE         :  Template Of Admin Login                             '
  '    PRE CONDITION   :  not required                                        '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

  // error massage
    $errMsg['428']="<b>ERROR:</b> Missing Username or Password!!";
    $errMsg['422']="<b>ERROR:</b> Password Incorrect!!";
    $errMsg['426']="<b>ERROR:</b> User not found!!";
?>

<table width="350"  border="0" align="left" cellpadding="0" cellspacing="0" class="frame">
<form name="frmMain" method="post" action="<?=$base->_SW['URL_LOGIN_SHOP'];?>/process.php">

      <tr>
        <td><table width="100%"  border="0" cellpadding="0" cellspacing="0" background="">
          <tr>
            <td width="50">&nbsp;</td>
            <td valign="top"><table width="99%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="23" colspan="2"> <? if($errNo){ ?>
                  <span class="style1"><font color="#FF0000" size="2" face="Arial, Helvetica, sans-serif"><? echo $errMsg[$errNo];?></font></span>
                  <? }else if($flagPWSend=="Y"){ echo "<span class=\"green\">&nbsp;Your Password has been sent to your email address</span>";?>
                  <? } else{ ?>
                  <? }?>
         </span> </td>
              <tr>
                <td height="19" colspan="2" class="txt_black">&nbsp;</td>
                </tr>
              <tr>
                <td width="28%" height="10" class="txt_black">User Name </td>
                <td width="72%"><input name="uid" type="text" class="txt_black" id="uid" size="20" maxlength="20" value="<? echo $_REQUEST['uid'];?>"></td>
              </tr>
              <tr>
                <td height="26" class="txt_black">Password</td>
                <td><input name="pass" type="password" class="txt_black" id="pass" size="20" maxlength="10">                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                  </td>
              </tr>
              <tr>
                <td height="26" class="txt_black">&nbsp;</td>
                <td><input name="imageField" type="image" src="<?=$base->_SW['URL_IMAGES_CONSOLE'];?>/buttons/btn_signin.jpg" border="0"></td>
              </tr>
            </table></td>
            <td width="2%">&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
   
</form> </table>