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
		echo $objCore->msgBox("CUSTOMER",$msg,'98.99%');
	}             	
?>

<div id="toolbar-box">
<div class="t"></div>
			<div class="m">

<!-------------- Function form----------->

	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset  id="page-middle-middle-content">
	  <legend>Add New Customer</legend>
	  <table class="admintable" width="470">
             <input name="ctitle" class="text_area" id="ctitle" size="30" type="hidden" value="Mr."/>
        <tr>
          <td class="key" align="right">Company Name</td>
	      <td><input name="cfname" class="text_area" id="cfname" size="30" type="text" value="<?php echo $_POST['cfname'];?>"/></td>
        </tr>
        <tr>
          <td class="key" align="right">Username (Company Email)</td>
	      <td><input name="cemail" class="text_area" id="cemail" size="30" type="text" value="<?php echo $_POST['cemail'];?>"/></td>
        </tr>
	    
        <tr>
          <td class="key" align="right">Password</td>
	      <td><input name="cpass" class="text_area" id="cpass" size="30" type="text" value="<?php echo $_POST['cpass'];?>"/></td>
        </tr>
        <tr>
          <td class="key" align="right">Subscription</td>
	      <td>
                  <select name="subscription">
                      <option value="M">Supplies</option>
                      <option value="S">Services</option>
                      </select>
              </td>
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