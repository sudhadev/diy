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
  
  require_once("../classes/core/core.class.php");$objCore=new Core;
   $objCore->auth(1,false);
  if($objCore->sessCusId)
  {
      header($objCore->_SYS['CONF']['URL_MY_ACCOUNT']);
  }
  
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
<link href="<?php echo $objCore->_SYS['CONF']['URL_CSS_FRONT']?>/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/login.js"></script>

</head>
<body <?php echo $jsBodyOnLoad;?> >
<div align="center">
  <div id="main_outer">
    <!--<div id="logo"></div> -->
    <div id="mainDiv">
      <div id="top_bar">
        <!-- START TOP HEADER-->
        <?php require_once($objCore->_SYS['PATH']['HEAD_FRONT']);?>
        <!-- END TOP HEADER-->
      </div>
      <!-- START BODY AREA-->
      <div id="middle_bar">
        <div id="middle_left_bar">
          <!-- START LEFT AREA-->
          <?php require_once($objCore->_SYS['PATH']['LEFT_FRONT']);?>
          <!-- END LEFT AREA-->
        </div>
        <div id="middle_right_bar">
          <!-- START CONTENT AREA-->
          <?php 
	switch($_REQUEST['f'])
	{
                case 'signup':
                include("signup.tpl.php");
                break;
		default:
		{
			// default inclution
			include("login.tpl.php");
		}
	}
?>
          <!-- END CONTENT AREA-->
        </div>
        <!-- END BODY AREA-->
      </div>
      <!-- START FOOTER AREA-->
      <?php require_once($objCore->_SYS['PATH']['FOOTER_FRONT']);?>
      <!-- END FOOTER AREA-->
    </div>
  </div>
</div>
</body>
</html>
