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
	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);$objComponent=new Component;

	
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
		$configType = $_REQUEST['type'];
		
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
	  <legend>Order Configuration </legend>
	  <table class="admintable" width="470">
	    <tr>
	      <td class="key" align="right"> Vat Value </td>
	      <td><input name="ORDER_VAT_VALUE" class="text_area numeric_txtFiled" id="ORDER_VAT_VALUE" size="10" type="text" value="<?php echo $list[0][3]; ?>"/></td>
        </tr>
		 <tr>
	      <td class="key" align="right"> State of Vat Calculation </td>
	      <td>
	        <label>
			<?php 	
		echo $objComponent->drop('ORDER_VAT_CALCULATE', $list[1][3],array("Y"=>"Yes", "N"=>"No", ),'', '');
			?>
			</label></td>
        </tr>
	    <tbody>
		<tr>
	      <td class="key" align="right" width="175">&nbsp;</td>
	      <td width="283"><label>
		 
	        <input type="button" name="Submit" value="Edit" onclick="getValues(qString(adminForm));"/>
	        <input name="type" id="type" type="hidden" value="<?php echo $configType;?>" />
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
	

