<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  console/users/user_edit.tpl.php                     '
  '    PURPOSE         :  edit users page of the user section                 '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
?>

<!-- Call to dList funtion and take correspond values that match with ID into a $list array.  -->
<?php
	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);$objComponent=new Component;
	require_once($objCore->_SYS['PATH']['CLASS_LISTING']);$objListing=new Listing;

	$list = $objManufacturer->get_dList($_REQUEST['id']);	
	$user = $objManufacturer->getUser($list[0][2]);
	//$list = $objListing->get_dList($_REQUEST['id']);	
?>

<!-- Display the error messages  -->
<?php
	if($msg)
	{
		echo $objCore->msgBox("MANUFACTURER",$msg,'98.99%');
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
<table width="250" border="0">
  <tr valign="top">
    <td>
	
	
	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" style="left:auto">
	  <fieldset id="page-middle-middle-content">
	  <legend>Edit Manufacturer - <?php echo $list[0][1]; ?></legend>
	  <table class="admintable" width="440">
	  
        <tr style="background-color:#FFFFEA">
        <td colspan="2" align="left">Please note that editing this is at your own risk! All the Manufacture names in listings will be effected.</td>
        <td></td>
        </tr> 	  
	    <tr>

	      <td class="key" align="right">Manufacturer</td>
	      <td><input name="mname" class="text_area" id="mname" size="30" type="text" value="<?php echo $list[0][1]; ?>"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">Added By </td>
	      <td><?php echo $user; ?></td>
        </tr>
	    <tr>
          <td class="key" align="right">Added Date</td>
	      <td><?php echo date($objCore->gConf['DATE_FORMAT'],$list[0][3]);?></td>
        </tr>
	    <tbody>
		<tr>
	      <td class="key" align="right" width="131">&nbsp;</td>
	      <td width="327"><label>
	        <input type="submit" name="Submit" value="Edit"/>
	        <input type="hidden" name="action"  value="edit"/>
	      </label></td>
	    </tr>
	  </tbody></table>
	  </fieldset>
	</form>
	
	
	</td>
	
	<td> </td>
	
    <td>
	
	
	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data" style="right:auto">
	  <fieldset id="page-middle-middle-content">
	  <legend>Merge Manufacturer</legend>
	  <table class="admintable" width="480">
	    <tr valign="top" style="background-color:#FFFFEA">
	      <td height="50" colspan="2" align="left">Please note that once you merge manufactures, all the Listings with the  Manufacturer (1) will be merge with Manufacture (2), then the system  will remove the Manufacture (1) from the system. this process will not  be able to recall and you needs to be very carefully.</td>
	      </tr>
	    <tr valign="top">
	      <td class="key" align="right">Merge Manufacturer</td>
	      <td><strong><?php echo $list[0][1]; ?></strong> (1)</td>
        </tr>
	    <tr>
          <td class="key" align="right">With </td>
	      <td>
		  <label>
			<?php 
				$list_mNames=$objManufacturer->get_dList();
				$arr = array();
				for($n=0; $n<count($list_mNames);$n++)
				{	
					$arr[$list_mNames[$n][1]] = $list_mNames[$n][1];
				}
				echo $objComponent->drop('mergeData', $list[0][1],$arr,'', '');
			?> (2)          </label></td>
        </tr>
	    <tbody>
		<tr>
	      <td class="key" align="right" width="131">&nbsp;</td>
	      <td width="327"><label>
	        <input type="submit" name="Submit" value="Merge" onclick="merg('<?php echo $_REQUEST['id'];?>');"/>
	        <input type="hidden" name="action"  value="merge"/>
			 <input type="hidden" name="manufac"  value="<?php echo $list[0][1]; ?>"/>
	      </label></td>
	    </tr>
	  </tbody></table>
	  </fieldset>
	</form>
	
	
	</td>
  </tr>
</table>

	


		
	
<!--------------END Function form----------->

<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>


	

