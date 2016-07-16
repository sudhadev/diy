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
	  <legend>Date and Time Configuration </legend>
	  <table class="admintable" width="470">
	    <tr>
	      <td class="key" align="right"> Date and Time Format </td>
	      <td>
		  <!--<input name="DATE_FORMAT" class="text_area" id="DATE_FORMAT" size="30" type="text" value="<?php echo $list[0][3]; ?>"/> -->
	        <label>
			<?php 	
		echo $objComponent->drop('DATE_FORMAT', $list[0][3],array("d/m/Y"=>"14/03/2001",
																  "d/m/y"=>"14/03/01",
																  "d/n/y"=>"14/3/01",
																  "Y-m-d"=>"2001-03-14",
																  "d F Y"=>"14 March 2001",
																  ),
								'', '');
			?>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<lable>
			<?php

		echo $objComponent->drop('TIME_FORMAT', $list[1][3],array("H:i:s"=>"13:30:55",
																  "h:i:s A"=>"01:30:55PM",
																  "g:i:s A"=>"1:30:55PM",
																  ),
										'', '');
			?>
			
	    <!--    <select name="DATE_FORMAT" id="DATE_FORMAT" class="text_area">
	          <option>m-d-Y  H:i:s</option>
	          <option>format1</option>
	          <option>format2</option>
            </select> -->
          </label></td>
        </tr>
	    <tbody>
		<tr>
	      <td class="key" align="right" width="181">&nbsp;</td>
	      <td width="277"><label>
		 
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
	

