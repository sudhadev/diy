<?php //ini_set('display_errors','1');
	  /*--------------------------------------------------------------------------\
	  '    This file is part  module library of FUSIS                             '
	  '    (C) Copyright 2002-2009 www.fusis.com                                  '
	  ' ..........................................................................'
	  '                                                                           '
	  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>      	  '
	  '    FILE            :  index.php                                           '
	  '    PURPOSE         :  provide the frame for lising section         		  '
	  '    PRE CONDITION   :  commented                                           '
	  '    COMMENTS        :                                                      '
	  '--------------------------------------------------------------------------*/
  
   	require_once("../../classes/core/core.class.php");$objCore=new Core;
	
	/**
	* Display the logged user.
	*/
	$objCore->auth(1,true);
	
	/** 
	* Create an object to the Listing class.
	*/
  	require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
	
	if(!is_object($objListing))
	{
		$objListing = new Listing;
	}

 // Content inclusion
    include("my_listing.content.php");
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php require_once($objCore->_SYS['PATH']['HEAD_HTML_FRONT']);?>
<script src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT']?>/listings.js" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.js"></script>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'];?>/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="<?php echo $objCore->_SYS['CONF']['URL_JS_FRONT'];?>/diQuery-collapsiblePanel.js"></script>
<script>

	$(document).ready(function() {
        $(".collapsibleContainer").collapsiblePanel();
    });

</script>
<link rel="stylesheet" href="css/autosuggest_inquisitor.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="<?php echo $objCore->_SYS['CONF']['URL_CSS_FRONT']?>/listings.css" type="text/css" media="screen" charset="utf-8" />


<style type="text/css">
.error {color: #000000; border:1px solid #FF0000; background: #FFFFFF; }

.collapsibleContainer
{
}
.collapsibleContainerTitle
{
    cursor:pointer;
    margin-left:25px;
    font-weight: bold;
}
.collapsibleContainerTitle div
{
    padding-top:5px;
    padding-left:10px;
}
.collapsibleContainerContent
{
    padding: 10px;
}

    #tbl_in_info_box td{
        font-family: Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-size-adjust: none;
    font-style: normal;
    font-variant: normal;
    font-weight: normal;
    line-height: normal;
    text-align: left;
    height:20px;

    }
    </style>
</head>
<body <?php echo $jsBodyOnLoad;?>>
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
	<?php 
		switch($_REQUEST['f'])
		 {
                    
                        case 'del':
                            $objListing->deleteListingFull($_GET['delId']);
                            include ("listing.tpl.php");
                            //header("Location:http://diypricecheck.co.uk/my_account/my_listings");
                            break;
                        case 'del_from_edit':
                            $objListing->deleteListingFull($_GET['delId']);
                            include ("listing.tpl.php");
                            //header("Location:http://diypricecheck.co.uk/my_account/my_listings_edit");
                            break;
			default:
			{
				include ("listing.tpl.php");
			}
		 }           
	?>
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
