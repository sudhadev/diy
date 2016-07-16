<?php 
    /*--------------------------------------------------------------------------\
    '    This file is part of shoping Cart in module library of FUSIS           '
    '    (C) Copyright 2004 www.fusis.com                                       '
    ' ..........................................................................'
    '                                                                           '
    '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
    '    FILE            :  console/category/category_add.ajax.tpl.php          '
    '    PURPOSE         :  add users page of the user section                  '
    '    PRE CONDITION   :  commented                                           '
    '    COMMENTS        :                                                      '
    '--------------------------------------------------------------------------*/
  
  require_once("../../classes/core/core.class.php");$objCore=new Core;
  $objCore->auth(1,true);

  require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
  require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
  require_once($objCore->_SYS['PATH']['CLASS_SPECIFICATION']);
  include_once("new_listing.process.php");
  include_once("new_listing.content.php");

  if(!is_object($objSpecification))
    {
        $objSpecification= new Specification;
    }


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
    <script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/new_listing.js"></script>
    <script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/animatedcollapse.js"></script>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_AUTOSUGGEST_MODULE'];?>/bsn.AutoSuggest_c_2.0.js"></script>
<script type="text/javascript">
	animatedcollapse.addDiv('cate', 'fade=0,speed=400,group=new_listings,<?php echo $cate;?>')
	animatedcollapse.addDiv('spec', 'fade=0,speed=400,group=new_listings,<?php echo $spec;?>')
	animatedcollapse.addDiv('manufac', 'fade=0,speed=400,group=new_listings,<?php echo $manufac;?>')

	//fires each time a DIV is expanded/contracted
	animatedcollapse.ontoggle=function($, divobj, state)
	{ 
		//$: Access to jQuery
		//divobj: DOM reference to DIV being expanded/ collapsed. Use "divobj.id" to get its ID
		//state: "block" or "none", depending on state
	}

	animatedcollapse.init()
</script> 
</head>
<body <?php echo $jsBodyOnLoad;?> >
<div align="center">
  <div id="main_outer">
    <div id="logo"></div>
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
            default:
            {
                    include("new_listing.tpl.php");
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
