<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  console/users/user_add.tpl.php                      '
  '    PURPOSE         :  add users page of the user section                  '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
?>

<!-- Display the error messages  -->

<?php 
	if($msg)
	{
		echo $objCore->msgBox("MANUFACTURER",$msg,'98.99%');
	}             	
?>

<div id="toolbar-box">
<div class="t"></div>
			<div class="m">

<!-------------- Function form----------->

	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset  id="page-middle-middle-content">
	  <legend>Add New Manufacturer </legend>
	  <table class="admintable" width="470">
	    <tr>
          <td class="key" align="right">Manufacturer Name</td>
	      <td><input name="mname" class="text_area" id="mname" size="30" type="text" value="<?php echo $_POST['mname'];?>"/></td>
        </tr>
	    <tbody>
		<tr>
	      <td class="key" align="right" width="131">&nbsp;</td>
	      <td width="327"><label>
	        <input type="submit" name="Submit" value="Add"/>
	        <input type="hidden" name="action"  value="add"/>
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


	

