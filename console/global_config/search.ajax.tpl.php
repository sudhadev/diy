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
		$configType = "SEARCH";
		
		if($msg)
		{
			echo $objCore->msgBox("GLOBAL_CONFIG",$msg,'75.99%');
		}	
		$list=$objGlobalConfig->get_dList($configType);
		
		if($list[0][3] == "miles")
		{
			$selectMile = "checked";
		} elseif($list[0][3] == "km")
		{
			$selectKm = "checked";
		}
?>

<div id="toolbar-box">
<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
</div>
			<div class="m">

<!-------------- Function form----------->

	<form action="" method="post" name="searchFrm" id="searchFrm" enctype="multipart/form-data">
	  <fieldset id="page-middle-middle-content">
	  <legend>Search Configuration </legend>
	  <table class="admintable" width="470">
	    <tr>
	      <td class="key" align="right"> Radious Mesuring Unit </td>
	      <td>
		  <p>
	        <label><input type="radio" name="SEARCH_UNIT" id="SEARCH_UNIT_1" value="miles" <?php echo $selectMile;?>/>Miles</label>
	        <br />
	        <label><input type="radio" name="SEARCH_UNIT" id="SEARCH_UNIT_2" value="km" <?php echo $selectKm;?>/>Kilometers</label>
	        <br />
          </p></td>
	    </tr>
	    <tr>
          <td class="key" align="right">Maximum Radious</td>
	      <td><input name="SEARCH_RADIOUS_MAX" class="text_area numeric_txtFiled" id="SEARCH_RADIOUS_MAX" size="20" type="text" value="<?php echo $list[1][3]; ?>"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">Radious Difference (Miles/ Km)</td>
	      <td><input name="SEARCH_RADIOUS_DIFFERENCE" class="text_area numeric_txtFiled" id="SEARCH_RADIOUS_DIFFERENCE" size="20" type="text" value="<?php echo $list[2][3]; ?>"/></td>
        </tr>
	    <tr>
	      <td class="key" align="right">Number of Records per Result page </td>
	      <td><input name="SEARCH_RECS_IN_LIST" class="text_area numeric_txtFiled" id="SEARCH_RECS_IN_LIST" size="20" type="text" value="<?php echo $list[3][3]; ?>"/></td>
        </tr>
	    <tbody>
		<tr>
	      <td class="key" align="right" width="258">&nbsp;</td>
	      <td width="200"><label>
		 
	        <input type="button" name="Submit" value="Edit" onclick="getValues(qString(searchFrm));"/>
	        <input name="type" id="type" type="hidden" value="<?php echo "search";?>" />
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
	

