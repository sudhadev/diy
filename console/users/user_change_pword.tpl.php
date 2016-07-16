<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  console/users/user_change_pword.tpl.php             '
  '    PURPOSE         :  change passwrod users page of the user section      '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
?>

<!-- Call to dList funtion and take correspond values that match with ID into a $list array.  -->
<?php
	$list=$objUser->get_dList($objCore->sessUId);
?>

<!-- Display the error messages  -->
<?php
	if($msg)
	{
		echo $objCore->msgBox("USER",$msg,'98.99%');
	} 
?>

<div id="toolbar-box"><!-------------- END Top tool bar with functionality name-----------><div id="element-box">
<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
</div>
			<div class="m">

<!-------------- Function form----------->

	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset id="page-middle-middle-content">
	  <legend>Change My Password  </legend>
	  <table class="admintable" width="470">
	    <tr>
	      <td class="key" align="right">Username </td>
	      <td><?php echo $list[0][3]; ?></td>
        </tr>
	    <tr>
          <td class="key" align="right">Current Password </td>
	      <td><input name="cpword" class="text_area" id="cpword" size="30" type="password"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">New Password </td>
	      <td><input name="npword" class="text_area" id="npword" size="30" type="password"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">Retype Password </td>
	      <td><input name="rpword" class="text_area" id="rpword" size="30" type="password"/></td>
        </tr>
	    <tbody>
		<tr>
	      <td class="key" align="right" width="131">&nbsp;</td>
	      <td width="327"><label>
	        <input type="submit" name="Submit" value="Change"/>
	        <input type="hidden" name="action"  value="change"/>
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


	

