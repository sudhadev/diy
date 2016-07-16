<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Priya Saliya Wijesinghe <saliyasoft@yahoo.com>      '
  '    FILE            :  header.inc.php                                      '
  '    PURPOSE         :  provide the header for any section of the system    '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/ 
//echo $objCore->curPageURL();
//echo $objCore->curSection();
?><div id="debug"></div>
<div id="top-bar-left">
<div id="logo"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/small-logo.jpg" alt="logo" width="270" height="65" /></div>
</div>
<div id="top-bar-right">
<div class="top-bar-right-logout"> <a href="<?php echo $objCore->_SYS['CONF']['URL_LOGIN_MODULE'];?>/process.php?logout=y&cusr=0">Log Out <span><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/logout.gif" width="11" height="14"/> </span></a></div>
<div class="top-bar-right-welcome">Welcome <?php echo $objCore->sessData[0]." ".$objCore->sessData[1];?><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CONSOLE'];?>/blank.gif" width="12" height="13"/></div>
</div>
<div id="top-bar-shade">
<div class="activate_header"><?php echo $objCore->gConf['TITLE_CONSOLE'];?> : </div>
</div>