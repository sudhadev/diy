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

		if($msg)
		{
			echo $objCore->msgBox("GLOBAL_CONFIG",$msg,'75.99%');
		}	
		
		$configType = "DATE_TIME";
		$list_date_time=$objGlobalConfig->get_dList($configType);
		$configType = "REGISTRATION";
		$list_registration=$objGlobalConfig->get_dList($configType);
		$configType = "ORDER";
		$list_order=$objGlobalConfig->get_dList($configType);
		
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
	  <legend>Other Configurations </legend>
	  
	  
	  
	  
	  <table width="400" border="0">
  <tr>
    <td width="288"><strong>Date and Time Configuration</strong></td>
  </tr>
  <tr>
    <td>
	
	<table width="259" class="adminlist admintable" >
		<thead>
		  <tr>
			<th width="150"></th>
			<th></th>
		  </tr>
		  </thead>
				<tr>
			 <td class="key" align="right"> Date and Time Format </td>
	      <td>
		  <!--<input name="DATE_FORMAT" class="text_area" id="DATE_FORMAT" size="30" type="text" value="<?php echo $list[0][3]; ?>"/> -->
	        <label>
			<?php 	
		echo $objComponent->drop('DATE_FORMAT',$list_date_time[0][3],array("d-slh-m-slh-Y"=>"14/03/2001",
																  "d-slh-m-slh-y"=>"14/03/01",
																  "d-slh-n-slh-y"=>"14/3/01",
																  "Y-m-d"=>"2001-03-14",
																  "d M Y"=>"14 Mar 2001",
																  ),
								'', '');
			?>
			</label>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<lable>
			<?php

		echo $objComponent->drop('TIME_FORMAT', $list_date_time[1][3],array("H:i:s"=>"13:30:55",
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
			 <tfoot>
			  <tr>
				<td colspan="12"><del class="container">
				  <div class="pagination"> </div>
				</del> </td>
			  </tr>
			</tfoot>
		</table>
	
	</td>
  </tr>
    <tr>
    <td height="10"></td>
  </tr>
  <tr>
    <td><strong>Registration Pending Approval Configuration</strong></td>
  </tr>
  <tr>
    <td>
	
		<table width="259" class="adminlist admintable" >
		<thead>
		  <tr>
			<th width="150"></th>
			<th></th>
		  </tr>
		  </thead>
				<tr>
					 <td class="key" align="right">Registration Pending Approval</td>
				  <td>
				  <!--<input name="DATE_FORMAT" class="text_area" id="DATE_FORMAT" size="30" type="text" value="<?php echo $list[0][3]; ?>"/> -->
					<label>
					<?php 	
						echo $objComponent->drop('REGISTRATION_PENDING_APPROVAL', $list_registration[0][3],array("ON"=>"ON","OFF"=>"OFF"),'', '');
					?>
				   
				  </label>
				 
				  </td>
			 
				</tr>
			 <tfoot>
			  <tr>
				<td colspan="12"><del class="container">
				  <div class="pagination"> </div>
				</del> </td>
			  </tr>
			</tfoot>
		</table>
	
	</td>
  </tr>
   <tr>
    <td height="10"></td>
  </tr>

  <tr>
    <td><strong>VAT Calculation </strong></td>
  </tr>
  <tr>
    <td>
		<table width="259" class="adminlist admintable" >
		<thead>
		  <tr>
			<th width="150"></th>
			<th></th>
		  </tr>
		  </thead>
				<tr>
			  <td class="key" align="right"> Calculate VAT  </td>
	      <td><?php 	
		echo $objComponent->drop('ORDER_VAT_CALCULATE', $list_order[1][3],array("Y"=>"Yes", "N"=>"No", ),'', '');
			?></td>
        </tr>
		 <tr>
	      <td class="key" align="right"> VAT Percentage </td>
	      <td>
	        <label>
	        <input name="ORDER_VAT_VALUE" class="text_area numeric_txtFiled" id="ORDER_VAT_VALUE" size="7" type="text" value="<?php echo $list_order[0][3]; ?>"/>
	        </label></td>
			</tr>
			 <tfoot>
			  <tr>
				<td colspan="12"><del class="container">
				  <div class="pagination"> </div>
				</del> </td>
			  </tr>
			</tfoot>
		</table>
	</td>
  </tr>
   <tr>
    <td height="10"></td>
  </tr>
  <tr>
    <td><strong> Free Subscription </strong></td>
  </tr>
  <tr>
    <td>
		<table width="259" class="adminlist admintable" >
		<thead>
		  <tr>
			<th width="150"></th>
			<th></th>
		  </tr>
		  </thead>

		 <tr>
	      <td class="key" align="right">* Enter the Number of days</td>
	      <td>
	        <label>
	        <input name="GP_NUM_OF_DAYS" class="text_area numeric_txtFiled" id="GP_NUM_OF_DAYS" size="7" type="text" value="<?php echo $list_order[0][3]; ?>"/>
	        </label></td>
			</tr>
			 <tfoot>
			  <tr>
				<td colspan="12"><del class="container">
				  <div class="pagination"> </div>
				</del> </td>
			  </tr>
			</tfoot>
		</table>
	</td>
  </tr>
  

   <tr>
    <td height="10"></td>
  </tr>
  <tr>
    <td><label>
	<input type="button" name="Submit" value="Edit" onclick="getValues(qString(adminForm));"/>
	<input name="type" id="type" type="hidden" value="<?php echo "other";?>" />
  </label></td>
  </tr>
   
</table>
	  
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
	

