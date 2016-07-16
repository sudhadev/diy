<?php 
  	  /*--------------------------------------------------------------------------\
	  '    This file is part of shoping Cart in module library of FUSIS           '
	  '    (C) Copyright 2004 www.fusis.com                                       '
	  ' ..........................................................................'
	  '                                                                           '
	  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
	  '    FILE            :  privacy_policy.php    				          	  '
	  '    PURPOSE         :  provide the privacy policy section of the system    '
	  '    PRE CONDITION   :  commented                                           '
	  '    COMMENTS        :                                                      '
	  '--------------------------------------------------------------------------*/
  
  	require_once("classes/core/core.class.php");$objCore=new Core;
	
	/**
	* Display the logged user.
	*/
	$objCore->auth(1,false);
	
 	$pageId=16;
	include($objCore->_SYS['PATH']['CLASS_CMS']);
	if(!is_object($objCms))
	{
		$objCms= new Cms;
	}
	$list=$objCms->get_dList($pageId);	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>

</head>
<body <?php echo $jsBodyOnLoad;?> >
<div align="center">
<div id="main_outer">
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
<div id="right_bar_middle">
<div id="main_form_bg">
<div id="main_form_bg_middle">
<div id="main_form_bg_topbar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
<div id="main_form_bg_middlebar">
<div id="banner"><?php echo $list[0][1];?></div>
<div id="outer">
<div id="outer_middle">

  <!-- Load the content from database. -->
  <div id="text_area" class="common_text"> 
  <?php echo $list[0][2];?><br />
    <br />
  </div>

<!-- yellow part<div id="form_bg"> -->
<div id="form_outer">
<div id="form_middle">
 <div class="form_middle_text"><br />
   <br /></div>
</div>
</div>
</div>
<div id="signup_butten" align="left"><a href="#"></a></div>
</div>
</div>
</div>
<div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg" /></div>
</div>
</div>
</div>
<!-- END CONTENT AREA-->
</div>
<!-- END BODY AREA-->
<!-- START FOOTER AREA-->
<?php require_once($objCore->_SYS['PATH']['FOOTER_FRONT']);?>
<!-- END FOOTER AREA-->
</div>
</div>
</div>
</div>
</body>
</html>
