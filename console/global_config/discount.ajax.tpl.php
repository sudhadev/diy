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
		$configType = "DISCOUNT";
		
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
	  <legend>Discount Configuration </legend>
	  
	  
	  
	  
	  
	  <table width="322" border="0">
  <tr>
    <td width="316"><strong>Supplier Listings - Bulk Discount List</strong></td>
  </tr>
  <tr>
    <td>
	<table width="259" class="adminlist admintable" >
	<thead>
      <tr>
        <th width="142"></th>
		<th></th>
      </tr>
	  </thead>
      	    <tr>
	      <td class="key" align="right"> Maximum Value</td>
	      <td width="105"><input name="BULK_MAX" class="text_area numeric_txtFiled" id="BULK_MAX" size="15" type="text" value="<?php echo $list[0][3]; ?>"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">Difference between Values </td>
	      <td><input name="BULK_DIFFERENCE" class="text_area numeric_txtFiled" id="BULK_DIFFERENCE" size="15" type="text" value="<?php echo $list[1][3]; ?>"/></td>
        </tr>
	     <tfoot>
          <tr>
            <td colspan="12"><del class="container">
              <div class="pagination"> </div>
            </del> </td>
          </tr>
        </tfoot>
    </table>	</td>
  </tr>
  
   <tr>
    <td height="10"></td> 
  </tr>

  <tr>
    <td><label>
		<input type="button" name="Submit" value="Edit" onclick="getValues(qString(adminForm));"/>
	   <input name="type" id="type" type="hidden" value="<?php echo "discount";?>" />
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
	

