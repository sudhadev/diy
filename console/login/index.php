<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  index.php                                           '
  '    PURPOSE         :  provide the frame for any section of the system     '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
  require_once("../../classes/core/core.class.php");$objCore=new Core;

  
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_CONSOLE']);?>
		<link href="<?php echo $objCore->_SYS['CONF']['URL_CSS_CONSOLE'];?>/login.css" rel="stylesheet" type="text/css" />

</head>

<body>
<br />
<form action="<?php echo $objCore->_SYS['CONF']['URL_LOGIN_MODULE']?>/process.php" method="post" name="frmLogin" id="frmLogin">
  <table border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
  
      <td width="50%" align="left" valign="top" id="loginBorder"><div id="loginImage"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/small-logo.jpg" /></div>
          <div>
            <table width="550" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="25">&nbsp;</td>
              </tr>
              <!--- MESSAGE START-->
              <tr>
                <td >
               	<?php
							if($_REQUEST['err'])
							{
								$msg=array('ERR',$_GET['err']);
								echo $objCore->msgBox("LOGIN",$msg,'96%');
							}             	
               	?>
                </td>
              </tr>
				<!--- MESSAGE END-->
              <tr>
                <td><table width="407" border="0" cellpadding="0" cellspacing="2" id="loginTable">
                    <tr>
                      <td width="83" height="125" align="right" valign="top"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/admin_img.jpg" width="60" height="63" /></td>
                      <td width="318" align="left" valign="top" class="td_align_form"><div id="loginTitle">Welcome to DIY Price Check Admin Console </div>
                          <div>Enter your username and password to log in</div>
                        <div></div>
                        <div>
                            <table width="301" border="0" cellpadding="0" cellspacing="2">
                              <tr>
                                <td align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top">&nbsp;</td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top">&nbsp;</td>
                              </tr>
                              <tr>
                                <td width="76" align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top">&nbsp;</td>
                              </tr>
                              <tr>
                                <td align="left" valign="top" class="head_text">Username : </td>
                                <td align="left" valign="top"><input name="uid" id="uid" type="text" class="txt_box" /></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top" class="head_text">Password : </td>
                                <td align="left" valign="top"><input name="pass" id="pass" type="password" class="txt_box" /></td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top">&nbsp;</td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top"><input type="hidden" name="cusr" value="0"><input name="Submit" type="submit" class="search_fill" value="Login" />
                                </td>
                              </tr>
                              <tr>
                                <td align="left" valign="top">&nbsp;</td>
                                <td align="left" valign="top">&nbsp;</td>
                              </tr>
                            </table>
                        </div></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top">&nbsp;</td>
                      <td align="left" valign="top"><a href="#"  class="link_more"></a></td>
                    </tr>
                </table></td>
              </tr>
              <tr>
                <td height="30">&nbsp;</td>
              </tr>
            </table>
          </div>
        <div id="footer">
				<?php require_once($objCore->_SYS['PATH']['FOOT_CONSOLE']);	?>        
        </div></td>
    
    </tr>
  </table>
</form>
</body>
</html>
