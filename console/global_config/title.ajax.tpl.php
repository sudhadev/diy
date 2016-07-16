<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  console/global_config/subscription.ajax.tpl.php  	  '
  '    PURPOSE         :  edit email page of the global configuration section '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
  
	require_once("../../classes/core/core.class.php");$objCore=new Core;
	
	/**
	* Display the logged user.
	*/
	$objCore->auth(0,true);
  
	/** 
	* Create an object to the GlobalConfig class.
	*/
  	require_once($objCore->_SYS['PATH']['CLASS_GLOBAL_CONFIG']);
	
	if(!is_object($objGlobalConfig))
	{
		$objGlobalConfig= new GlobalConfig;
	}
	
	$module = "globalConfiguration";
	$function = "subscription";
	
  	if($objCore->isAllowed($module, $function))
	{
		$configType = "TITLES";
		
		if($msg)
		{
			echo $objCore->msgBox("GLOBAL_CONFIG",$msg,'75.99%');
		}	
		$list=$objGlobalConfig->get_dList($configType);
		
?>

<div id="toolbar-box">
<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
</div>
			<div class="m">

<!-------------- Function form----------->

	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset id="page-middle-middle-content">
	  <legend>Title Configuration </legend>
	  <table class="admintable" width="470">
	    <tr>
	      <td class="key" align="right"> Admin Console </td>
	      <td><input name="TITLE_CONSOLE" class="text_area" id="TITLE_CONSOLE" size="40" type="text" value="<?php echo $list[0][3]; ?>"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">Front Site</td>
	      <td><input name="TITLE_FRONT" class="text_area" id="TITLE_FRONT" size="40" type="text" value="<?php echo $list[1][3]; ?>"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">Invoices</td>
	      <td><input name="TITLE_INVOICE" class="text_area" id="TITLE_INVOICE" size="40" type="text" value="<?php echo $list[2][3]; ?>"/></td>
        </tr>
	    <tr>
	      <td class="key" align="right">Emails</td>
	      <td><input name="TITLE_EMAILS" class="text_area" id="TITLE_EMAILS" size="40" type="text" value="<?php echo $list[3][3]; ?>"/>
		  <div class="globalConfig_txt">
	         This title will be added to the email subject
		    </div>
		  </td>
        </tr>
	    <tbody>
		<tr>
	      <td class="key" align="right" width="131">&nbsp;</td>
	      <td width="327"><label>
		 
	        <input type="button" name="Submit" value="Edit" onclick="getValues(qString(adminForm));"/>
			<input name="type" id="type" type="hidden" value="<?php echo "titles";?>" />
	       
	      </label></td>
	    </tr>
	  </tbody></table>
	  </fieldset>
	</form>
 
<!--------------END Function form----------->

<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
<?php  
}
?>
	

