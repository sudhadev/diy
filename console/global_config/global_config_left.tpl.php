<?php 

  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  globalConfig.tpl.php                                '
  '    PURPOSE         :  left panel of the Global Cofiguration               '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
  	$module = "globalConfiguration";
	$function = "dataList";
	
  	if($objCore->isAllowed($module, $function))
	{
?>

<div id="globalConfigList_body">
	<fieldset id="globalConfigList">
		  <legend align="center">Global Configuration </legend>	
    		 <a class="glbl_conf_lft_bar" style="text-decoration:none" href="javascript: update('email.ajax.tpl.php');">Emails</a> <br />
			 <a class="glbl_conf_lft_bar" style="text-decoration:none" href="javascript: update('subscription.ajax.tpl.php');">Subscriptions</a> <br />
			 <a class="glbl_conf_lft_bar"  style="text-decoration:none" href="javascript: update('search.ajax.tpl.php');">Search</a> <br />
			 <a class="glbl_conf_lft_bar"  style="text-decoration:none" href="javascript: update('title.ajax.tpl.php');">Titles</a> <br />
		 	 <a class="glbl_conf_lft_bar"  style="text-decoration:none" href="javascript: update('discount.ajax.tpl.php');">Discount</a> <br />
			 <a class="glbl_conf_lft_bar"  style="text-decoration:none" href="javascript: update('recs_in_list.ajax.tpl.php');">Records In List</a> <br />
			 <a class="glbl_conf_lft_bar"  style="text-decoration:none" href="javascript: update('other_config.ajax.tpl.php');">Other Configurations </a> <br />
			 <a class="glbl_conf_lft_bar"  style="text-decoration:none" href="javascript: update('company.ajax.tpl.php');">Company Details </a> <br />
			 <a class="glbl_conf_lft_bar"  style="text-decoration:none" href="javascript: update('email_server_exceptions.ajax.tpl.php');">Mail Services </a> <br />
		
	</fieldset>
</div>

<?php } ?>