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
	$list=$objUser->get_dList($_REQUEST['id']);
?>

<!-- Display the error messages  -->
<?php
	if($msg)
	{
		echo $objCore->msgBox("USER",$msg,'98.99%');
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

	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset id="page-middle-middle-content">
	  <legend>Edit User </legend>
	  <table class="admintable" width="470">
	    <tr>
	      <td class="key" align="right">Username</td>
	      <td><?php echo $list[0][3]; ?></td>
        </tr>
	    <tr>
          <td class="key" align="right">First Name</td>
	      <td><input name="fname" class="text_area" id="fname" size="30" type="text" value="<?php echo $list[0][1]; ?>"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">Last Name</td>
	      <td><input name="lname" class="text_area" id="lname" size="30" type="text" value="<?php echo $list[0][2]; ?>"/></td>
        </tr>
	    <tr>
          <td class="key" align="right">User Role</td>
	      <td>
          <select name="uRole" class="text_area" id="uRole" type="text" value="<?php echo $_POST['uRole'];?>">
          <?php
            $userRoles=$objUser->getUserRoles();
            $uerKeys=array_keys($userRoles);
            if($list[0][6]=='') $list[0][6]=1;
            for($ur=0;$ur<count($userRoles);$ur++)
            {
                if($list[0][6]==$uerKeys[$ur]){ $selOption="Selected"; }else{ $selOption="";}


          ?>
                <option value="<?php echo $uerKeys[$ur];?>" <?php echo $selOption;?>><?php echo $userRoles[$uerKeys[$ur]]?></option>
          <?php
            }
          ?>
          </select></td>
        </tr>
	    <tr>
	    <tr>
          <td class="key" align="right">E-mail</td>
	      <td><input name="email" class="text_area" id="email" size="30" type="text" value="<?php echo $list[0][4]; ?>" /></td>
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

<!--------------END Function form----------->

<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>


	

