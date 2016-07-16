<?php
  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Saliye Wijesinge - Created using an existing code    '
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

.redBox {
    border:red solid 1px;
    background:#ffffcc;
}

.greenBox {
    border:teal solid 1px;
}
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
	  <legend>Supplier Fare Configuration </legend>
	  
	  <table width="400" border="0">
  <tr>
    <td width="288"><strong>Building Supplies </strong></td>
  </tr>
  <tr>
    <td>


    <table border="0" class="adminlist" style="width:600px;" >
	<thead>
      <tr>
        <th width="200"></th>
       <?php
        foreach($objCore->_SYS['CONF']['SUBCRIPTIONS']['M'] as $key=>$value)
        {
           if($key!='OPTION')
           {

       ?>
         <th width="81"><?php echo $value;?></th>
       <?php
           } // End if
         } // end loop - td
       ?>
      </tr>
	  </thead>
      <?php
        $arrSubFrequency=array(1,3,6,12);
        
        for($p=0;$p<count($arrSubFrequency);$p++)
        {
      ?>
      <tr>     
      <td align="left"><?php echo str_pad($arrSubFrequency[$p],2,"0",STR_PAD_LEFT);?> Month Subscription</td>
       <?php

        foreach($objCore->_SYS['CONF']['SUBCRIPTIONS']['M'] as $key=>$value)
        {
           if($key!='OPTION') 
           {

      ?>          
            <td><input name="SUP_FARE_<?php echo $arrSubFrequency[$p];?>___<?php echo $key;?>" class="text_area numeric_txtFiled <?php if((int)$arrFares[$arrSubFrequency[$p]][$key][2]) echo "greenBox"; else echo "redBox";?>" id="SUP_FARE[<?php echo $arrSubFrequency[$p];?>][<?php echo $key;?>]" size="10" type="text" value="<?php echo $arrFares[$arrSubFrequency[$p]][$key][2]; ?>"/></td>
      <?php
           } // ind if
        } // end loop - td
      ?>
      </tr>
      <?php
        } // end loop -tr
      ?>

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
    <td><label>
	<input type="button" name="Submit" value="Edit" onclick="getValues(qString(adminForm));"/>
	<input type="button" name="cancel" value="Cancel" onclick="update('subscription.ajax.tpl.php');"/>
	<input name="type" id="type" type="hidden" value="<?php echo "supplies_fares";?>" />
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


