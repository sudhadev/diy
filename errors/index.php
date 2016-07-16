<?php 
      /*--------------------------------------------------------------------------\
	  '    This file is part of shoping Cart in module library of FUSIS           '
	  '    (C) Copyright 2004 www.fusis.com                                       '
	  ' ..........................................................................'
	  '                                                                           '
	  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
	  '    FILE            :  green_ideas.php    				          		  '
	  '    PURPOSE         :  provide the about us section of the system          '
	  '    PRE CONDITION   :  commented                                           '
	  '    COMMENTS        :                                                      '
	  '--------------------------------------------------------------------------*/
  
  	require_once("../classes/core/core.class.php");$objCore=new Core;
	
	
// Set error message
   switch($_REQUEST['err'])
    {
        case 403:
        {
            $msgTitle='403 Error- Forbidden!';
            $msgText="You are not permitted to access the requested URL ";
        }break;

        case 812:
        {
            $msgTitle='Error - Forbidden!';
            $msgText="You are not permitted to access the requested URL.
           
                Either the link has been expired or you have visit once before.
                <br/> <br/>
                If you use this link before, but didn't renew your Subscription/ Advertisement, you can always log into the system
                <a href=".$objCore->_SYS['CONF']['URL_LOGIN_FRONT'].">".$objCore->_SYS['CONF']['URL_LOGIN_FRONT']."</a>  and renew from there.<br/>";
        }break;


        default:
        {
            // default inclution

        }
    }
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
<div id="main_form_bg_topbar">
<img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg" /></div>
<div id="main_form_bg_middlebar">
<div id="banner"><?php echo $msgTitle;?></div>
<div id="outer">
<div id="outer_middle">

  <!-- Load the content from database. -->
  <div id="text_area" class="common_text" >
<br /><?echo $msgText;?>
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
