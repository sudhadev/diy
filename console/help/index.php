<?php 
  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  index.php                                           '
  '    PURPOSE         :  provide the help frame forthe system                '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
  	require_once("../../classes/core/core.class.php");$objCore=new Core;
	$objCore->auth(0,false);
	if($objCore->sessUId==''){
		header('Location:help_not_privileges.html');
	} else{
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
	<head>
		<link href="help.css" rel="stylesheet" type="text/css" />

		<script src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/help_animatedcollapse.js" type="text/javascript"></script>
		<script src="<?php echo $objCore->_SYS['CONF']['URL_JS_CONSOLE']?>/help_jquery.min.js" type="text/javascript"></script>
		
		<script type="text/javascript">
			animatedcollapse.addDiv('showHide_menu_user', 'fade=1,speed=500,group=menu_event')
			animatedcollapse.addDiv('showHide_menu_customer', 'fade=1,speed=500,group=menu_event')
			animatedcollapse.addDiv('showHide_menu_revenue', 'fade=1,speed=500,group=menu_event')
			animatedcollapse.addDiv('showHide_menu_category', 'fade=1,speed=500,group=menu_event')
			animatedcollapse.addDiv('showHide_menu_specification', 'fade=1,speed=500,group=menu_event')
			animatedcollapse.addDiv('showHide_menu_manufacturer', 'fade=1,speed=500,group=menu_event')
			animatedcollapse.ontoggle=function($, divobj, state){ 
			}
			animatedcollapse.init()
		</script>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-family:Arial, Helvetica, sans-serif;
}
-->
</style></head>
	<body>
    <div align="left">
    <div id="main_outer">
		<!-- START PAGE HEADER -->
		<div id="top-bar-shade-help">
			<div class="activate_header">
				Help - DIY Price Check 
			</div>
		</div>
		<!-- END PAGE HEADER -->
		<!-- START PAGE MIDDLE -->
		<!-- START CONTENT AREA --> 
		<div id="help_area">
		<table width="100%" border="0" cellpadding="0" cellspacing="0" id="all_tbl">
			<tr>
			  <td width="20%" valign="top"><div id="left_bar">
                <table width="100%" border="0" id="left_tbl">
                  <tr>
                    <td height="10"></td>
                  </tr>
				  
				  
                   <tr>
                    <td height="auto"><div class="main_menu"> <a href="javascript:animatedcollapse.toggle('showHide_menu_user')" style="text-decoration:none"><strong>Users </strong></a> </div></td>
                  </tr>
                   <tr>
                    <td><div id="showHide_menu_user" groupname="menu_event" speed="400">
                        <table width="98%" border="0" id="sub_menu_tbl">
                          <tr>
                            <td height="auto"><div class="sub_menu"> <a href="en/help_user_management.html#add_user" target="ifrmHelp" style="text-decoration:none"> Add New User</a> </div></td>
                          </tr>
                          <tr>
                            <td height="auto"><div class="sub_menu"> <a href="en/help_user_management.html#user_list" target="ifrmHelp" style="text-decoration:none">User List</a> </div></td>
                          </tr>
                          <tr>
                            <td height="auto"><div class="sub_menu"> <a href="en/help_user_management.html#change_pword" target="ifrmHelp" style="text-decoration:none">Change My Password </a> </div></td>
                          </tr>
                        </table>
                    	</div></td>
                  </tr>
				
				  
				<tr>
					<td height="auto"><div class="main_menu"> <a href="javascript:animatedcollapse.toggle('showHide_menu_customer')" style="text-decoration:none"><strong>Customers</strong></a> </div>
					</td>
				</tr>
				 <tr>
                    <td><div id="showHide_menu_customer" style="display: block;" groupname="menu_event" speed="400">
                        <table width="98%" border="0" id="sub_menu_tbl">
                          <tr>
                            <td height="auto"><div class="sub_menu"> <a href="en/help_customer_management.html#customer_list" target="ifrmHelp" style="text-decoration:none"> Customer List</a> </div></td>
                          </tr>
                          <tr>
                            <td height="auto"><div class="sub_menu"> <a href="en/help_customer_management.html#pending_approval" target="ifrmHelp" style="text-decoration:none">Pending Approval</a> </div></td>
                          </tr>
                        </table>
                    	</div></td>
                  </tr>
				
				
				 <tr>
                    <td height="auto"><div class="main_menu"> <a href="javascript:animatedcollapse.toggle('showHide_menu_revenue')" style="text-decoration:none"><strong>Revenue</strong></a> </div></td>
                  </tr>
                   <tr>
                    <td><div id="showHide_menu_revenue" style="display: block;" groupname="menu_event" speed="400">
                        <table width="98%" border="0" id="sub_menu_tbl">
                          <tr>
                            <td height="auto"><div class="sub_menu"> <a href="en/help_revenue_management.html" target="ifrmHelp" style="text-decoration:none"> Order List</a> </div></td>
                          </tr>
                        </table>
                    	</div></td>
                  </tr>
				
				
				
				<tr>
                    <td height="auto"><div class="main_menu"> <a href="javascript:animatedcollapse.toggle('showHide_menu_category')" style="text-decoration:none"><strong>Categories</strong></a> </div></td>
                </tr>
				<tr>
                    <td><div id="showHide_menu_category" style="display: block;" groupname="menu_event" speed="400">
                        <table width="98%" border="0" id="sub_menu_tbl">
                          <tr>
                            <td height="auto"><div class="sub_menu"> <a href="en/help_category_management.html#add_category" target="ifrmHelp" style="text-decoration:none"> Add Categories</a> </div></td>
                          </tr>
                          <tr>
                            <td height="auto"><div class="sub_menu"> <a href="en/help_category_management.html#category_list" target="ifrmHelp" style="text-decoration:none">Category List</a> </div></td>
                          </tr>
                        </table>
                    	</div></td>
                  </tr>
				
				
				<tr>
                    <td height="auto"><div class="main_menu"> <a href="javascript:animatedcollapse.toggle('showHide_menu_specification')" style="text-decoration:none"><strong>Specifications </strong></a> </div></td>
                </tr>
				<tr>
                    <td><div id="showHide_menu_specification" style="display: block;" groupname="menu_event" speed="400">
                        <table width="98%" border="0" id="sub_menu_tbl">
                          <tr>
                            <td height="auto"><div class="sub_menu"> <a href="en/help_specification_management.html#add_specification" target="ifrmHelp" style="text-decoration:none"> Add Specifications</a> </div></td>
                          </tr>
                          <tr>
                            <td height="auto"><div class="sub_menu"> <a href="en/help_specification_management.html#specification_list" target="ifrmHelp" style="text-decoration:none">Specification List</a> </div></td>
                          </tr>
                        </table>
                    	</div></td>
                  </tr>
				
				
				 <tr>
                    <td height="auto">
					<div class="main_menu"> <a href="en/help_global_configuration.html" target="ifrmHelp" style="text-decoration:none"><strong> Global Configuration</strong></a>					</div>					</td>
                 </tr>
				
				
                  <tr>
                    <td height="auto">
					<div class="main_menu"> <a href="en/help_content_management.html" target="ifrmHelp" style="text-decoration:none"><strong> CMS</strong></a>					</div>					</td>
                  </tr>
				  
				  
				 <tr>
                    <td height="auto"><div class="main_menu"> <a href="javascript:animatedcollapse.toggle('showHide_menu_manufacturer')" style="text-decoration:none"><strong>Manufacturers </strong></a> </div></td>
                  </tr>
                   <tr>
                    <td><div id="showHide_menu_manufacturer" style="display: block;" groupname="menu_event" speed="400">
                        <table width="98%" border="0" id="sub_menu_tbl">
                          <tr>
                            <td height="auto"><div class="sub_menu"> <a href="en/help_manufacturer_management.html#add_manufacturer" target="ifrmHelp" style="text-decoration:none"> Add Manufacturers</a> </div></td>
                          </tr>
                          <tr>
                            <td height="auto"><div class="sub_menu"> <a href="en/help_manufacturer_management.html#manufacturer_list" target="ifrmHelp" style="text-decoration:none">Manufacturer List</a> </div></td>
                          </tr>
                        </table>
                    	</div></td>
                  </tr>
				
                
                  <tr>
                    <td height="1"></td>
                  </tr>
                </table>
		      </div></td>
	    <td width="75%" valign="top">
				  <div id="ifrm">
				    <iframe id="ifrmHelp" name="ifrmHelp" frameborder="0" src="help_home.html">
                    <p>Your browser does not support iframes.</p>
				    </iframe>
				  </div>				</td>
		  </tr>
		</table>
	</div>
    		<!-- END CONTENT AREA -->  
		<!-- END PAGE MIDDLE -->		
        </div>
        </div>		
	</body>
</html>
<?php } ?>