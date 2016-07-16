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
		//$configType = $_REQUEST['type'];
		
		$configType	= "SUBSCRIPTION";
		$list_subscription = $objGlobalConfig->get_dList($configType);
		$configType	= "CLASSIFIED_ADS";
		$list_classified_ads = $objGlobalConfig->get_dList($configType);


    $arrFares=$objGlobalConfig->getSuppliesFares();
    print_r($fares);
?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>


<div id="toolbar-box">
<div class="t"><div class="t">
  <div class="t"></div>
		 		</div>
</div>
			<div class="m">

<!-------------- Function form----------->

	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset id="page-middle-middle-content">
	  <legend>Subscription Configuration </legend>
	  
	  <table width="400" border="0">
  <tr>
    <td width="288"><strong>Building Supplies </strong></td>
  </tr>
  <tr>
    <td>
	<table width="275" border="0" class="adminlist" >
	<thead>
      <tr>
        <th width="81">Package</th>
        <th width="99">No of Products </th>
      </tr>
	  </thead>
      <tr>
        <td align="left">Gold</td>
        <td><input name="SUBSCRIPTION_GOLD" class="text_area numeric_txtFiled" id="SUBSCRIPTION_GOLD" size="10" type="text" value="<?php echo $list_subscription[0][3]; ?>"/></td>
      </tr>
      <tr>
        <td align="left">Silver</td>
        <td><input name="SUBSCRIPTION_SILVER" class="text_area numeric_txtFiled" id="SUBSCRIPTION_SILVER" size="10" type="text" value="<?php echo $list_subscription[1][3]; ?>"/></td>
      </tr>
      <tr>
        <td align="left">Bronze</td>
        <td><input name="SUBSCRIPTION_BRONZE" class="text_area numeric_txtFiled" id="SUBSCRIPTION_BRONZE" size="10" type="text" value="<?php echo $list_subscription[2][3]; ?>"/></td>
      </tr>
	     <tfoot>
          <tr>
            <td colspan="12"><del class="container">
              <div class="pagination"> </div>
            </del> </td>
          </tr>
        </tfoot>
		
    </table>
    <br/>
    <span style="background:#eeeeee;border: solid 1px #999999;padding:2px 10px 2px 10px;margin-top:16px;font-family:sans-serif"><a href="javascript: update('supplies_fares.ajax.tpl.php');">Click here to update Fare [Building Supplies]</a></span>

	</td>
  </tr>

    <tr>
    <td height="10"></td>
  </tr>
  <tr>
    <td><strong>Building Services </strong></td>
  </tr>
  <tr>
    <td>
	<table width="274" border="0" class="adminlist" >
	<thead>
      <tr>
        <th width="188">Period</th>
        <th width="76" class="adminlistRight">Price (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)</th>
      </tr>
	  </thead>
      <tr>
        <td>1 Month </td>
        <td align="right"><input name="SUBSCRIPTION_1MONTH_PRICE" class="text_area numeric_txtFiled" id="SUBSCRIPTION_1MONTH_PRICE" size="10" type="text" value="<?php echo $list_subscription[6][3]; ?>"/></td>
      </tr>
      <tr>
        <td>3 Months </td>
        <td align="right"><input name="SUBSCRIPTION_3MONTH_PRICE" class="text_area numeric_txtFiled" id="SUBSCRIPTION_3MONTH_PRICE" size="10" type="text" value="<?php echo $list_subscription[7][3]; ?>"/></td>
      </tr>
      <tr>
        <td>6 Months </td>
        <td align="right"><input name="SUBSCRIPTION_6MONTH_PRICE" class="text_area numeric_txtFiled" id="SUBSCRIPTION_6MONTH_PRICE" size="10" type="text" value="<?php echo $list_subscription[8][3]; ?>"/></td>
      </tr>
      <tr>
        <td>1 Year </td>
        <td align="right"><input name="SUBSCRIPTION_1YEAR_PRICE" class="text_area numeric_txtFiled" id="SUBSCRIPTION_1YEAR_PRICE" size="10" type="text" value="<?php echo $list_subscription[9][3]; ?>"/></td>
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
  <?php /*?>
  <tr>
    <td><strong>Classified Ads </strong></td>
  </tr>
  <tr>
    <td>
		<table width="259" class="adminlist admintable" >
		<thead>
		  <tr>
			<th width="185"></th>
			<th></th>
		  </tr>
		  </thead>
				<tr>
			  <td class="key" align="right"> Allow free of charge upto(Total Amount)</td>
			  <td width="71"><input name="CLASSIFIED_ADS_AMOUNT" class="text_area numeric_txtFiled" id="CLASSIFIED_ADS_AMOUNT" size="10" type="text" value="<?php echo $list_classified_ads[0][3]; ?>"/>&nbsp;<?php echo $objCore->_SYS['CONF']['CURRENCY'];?></td>
				</tr>
			<tr>
			  <td class="key" align="right">Commission Percentage</td>
			  <td><input name="CLASSIFIED_ADS_PERCENTAGE" class="text_area numeric_txtFiled" id="CLASSIFIED_ADS_PERCENTAGE" size="10" type="text" value="<?php echo $list_classified_ads[1][3]; ?>"/>&nbsp;%</td>
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
  <? */?>

  <tr>
    <td><label>
	<input type="button" name="Submit" value="Edit" onclick="getValues(qString(adminForm));"/>
	<input name="type" id="type" type="hidden" value="<?php echo "subscription";?>" />
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
	<div id="debug"></div>

