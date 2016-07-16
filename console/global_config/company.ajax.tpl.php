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
	$function = "company";
	
  	if($objCore->isAllowed($module, $function))
	{
		$configType = "DIY_DETAILS";
		
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
	      <td class="key" align="right"> Company Name </td>
	      <td><input name="DIY_COMPANY_NAME" class="text_area" id="DIY_COMPANY_NAME" size="40" type="text" value="<?php echo $list[0][3]; ?>"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">Address</td>
	      <td><input name="DIY_ADDRESS" class="text_area" id="DIY_ADDRESS" size="40" type="text" value="<?php echo $list[1][3]; ?>"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">Street</td>
	      <td><input name="DIY_STREET" class="text_area" id="DIY_STREET" size="40" type="text" value="<?php echo $list[2][3]; ?>"/></td>
        </tr>
        <tr>
          <td class="key" align="right">City</td>
	      <td><input name="DIY_CITY" class="text_area" id="DIY_CITY" size="40" type="text" value="<?php echo $list[2][3]; ?>"/></td>
        </tr>

	    <tr>
          <td class="key" align="right">Country</td>
	      <td><strong>United Kingdom</strong><input name="DIY_COUNTRY" class="text_area" id="DIY_COUNTRY" size="40" type="hidden" value="United Kingdom"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">Postal Code</td>
	      <td><input name="DIY_POSTAL" class="text_area" id="DIY_POSTAL" size="40" type="text" value="<?php echo $list[2][3]; ?>"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">Telephone</td>
	      <td><input name="DIY_TELEPHONE" class="text_area" id="DIY_TELEPHONE" size="40" type="text" value="<?php echo $list[2][3]; ?>"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">Fax</td>
	      <td><input name="DIY_FAX" class="text_area" id="DIY_FAX" size="40" type="text" value="<?php echo $list[2][3]; ?>"/></td>
        </tr>
	    <tr>
	      <td class="key" align="right">Email</td>
	      <td><input name="DIY_EMAIL" class="text_area" id="DIY_EMAIL" size="40" type="text" value="<?php echo $list[3][3]; ?>"/>

        </tr>
	    <tbody>
		<tr>
	      <td class="key" align="right" width="131">&nbsp;</td>
	      <td width="327"><label>
		 
	        <input type="button" name="Submit" value="Edit" onclick="getValues(qString(adminForm));"/>
			<input name="type" id="type" type="hidden" value="<?php echo "company";?>" />
	       
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
	

