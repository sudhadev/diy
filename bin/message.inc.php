<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  head.inc.php                                        '
  '    PURPOSE         :  header file                                         '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

	if($objCore->msgKey=='LOGIN')
	{
		$msgImage=$objCore->_SYS['MSGS']['LOGIN'][$_GET['err']][0];
		$msgText=$objCore->_SYS['MSGS']['LOGIN'][$_GET['err']][1];
		$msgWidth="94%";
	}
	else
	{
		$msgImage=$objCore->_SYS['MSGS'][$objCore->msgKey][$msg[1]][0];
		$msgText=$objCore->_SYS['MSGS'][$objCore->msgKey][$msg[1]][1];
		$msgWidth="98.5%";
	}	
	
	
	
?>
<table width="<?php echo $msgWidth;?>" border="0" align="center">
    <tr>
       <td class=""><div class="info_msg_box"> <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/icons/<?php echo strtolower($msgImage);?>.png" align="absmiddle"/> &nbsp;<?php echo $msgText;?> </div></td>
    </tr>
    <tr>
        <td ></td>
    </tr>
</table> 
                        

