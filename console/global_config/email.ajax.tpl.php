<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  console/global_config/email.ajax.tpl.php  		  '
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
	$function = "dataList";
	
  	if($objCore->isAllowed($module, $function))
	{
		$configType = "E_MAIL";
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

	<form action="" method="get" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset id="page-middle-middle-content">
	  <legend>Email Configuration </legend>
	  <table class="admintable" width="600">
	    <tr>
	      <td class="key" align="right">Administrator</td>
	      <td><input name="MAIL_ADMIN" class="text_area" id="MAIL_ADMIN" size="50" type="text" value="<?php echo $list[0][3]; ?>"/>
			<div class="globalConfig_txt">
	         Will use as primary email for the system (for Registration, Contact us forms etc)		    </div></td>
        </tr> 
	   <!-- <tr>
	      <td class="key" align="right">Help Desk </td>
	      <td><input name="MAIL_HELP" class="text_area" id="MAIL_HELP" size="50" type="text" value="<?php echo $list[1][3]; ?>"/><div class="globalConfig_txt">This email address can be used for provide supports for the clients</div></td>
        </tr> -->
	    <tr>
	      <td class="key" align="right">Sales</td>
	      <td><input name="MAIL_SALES" class="text_area" id="MAIL_SALES" size="50" type="text" value="<?php echo $list[3][3]; ?>"/><div class="globalConfig_txt">All the order details will send to this address directly</div></td>
        </tr>
	    <tr>
          <td class="key" align="right">Returns</td>
	      <td><input name="MAIL_RETURNS" class="text_area" id="MAIL_RETURNS" size="50" type="text" value="<?php echo $list[2][3]; ?>"/>
        <div class="globalConfig_txt">  This is for technical purpose. All the unnecessary return emails will be directed to this address. (Better to keep the default address without doing changes)</div></td>
        </tr>
	    <tbody>
		<tr>
	      <td class="key" align="right" width="82">&nbsp;</td>
	      <td width="493"><label>
		 
		   <input type="button" name="Submit" value="Edit" onclick="getValues(qString(adminForm));"/>
	       <input name="type" id="type" type="hidden" value="<?php echo "email";?>" />

	  
	       
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
	

