<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>         '
  '    FILE            :  console/users/user_list.tpl.php                     '
  '    PURPOSE         :  list users page of the user section                 '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
?>

<!-- Display the successfull messages  -->
<?php
	if($msg)
	{
		echo $objCore->msgBox("USER",$msg,'98.99%');
	}
	$list=$objUser->get_dList();
    $arrUserRoles=$objUser->getUserRoles();
?>
	
<fieldset id="page-middle-middle-content">
<legend>User List </legend>

<table  cellspacing="1" class="adminlist" width="100%">
  <thead>
    <tr>
      <th width="7%" height=""> # </th>
      <th width="16%" class="title"> <a  title="" href="javascript:tableOrdering('c.title','desc','');">First Name</a> </th>
      <th width="17%" nowrap="nowrap"> <a  href="javascript:tableOrdering('c.state','desc','');">Last Name </a> </th>
      <th width="16%" nowrap="nowrap"><a  href="javascript:tableOrdering('c.state','desc','');">Username</a></th>
      <th width="16%" nowrap="nowrap"><a  href="javascript:tableOrdering('c.state','desc','');">User Role</a></th>
      <th width="19%" nowrap="nowrap" class="title"><a  href="javascript:tableOrdering('frontpage','desc','');">E-Mail</a></th>
      <th width="17%" align="center"><a  href="javascript:tableOrdering('c.created','desc','');">Last Visit </a></th>
	  	<th width="4%" class="title">&nbsp;</th>
	<th width="4%" class="title">&nbsp;</th>
    </tr>
  </thead>
  <tbody>
    <!-- Retriew data from database and display the data corresponding fields -->
    <?php 
		for($n=0;$n<count($list);$n++)
		{
			$rowNo=$n+1;
	?>
    <tr class="row0">
      <td align="left"><?php echo $rowNo; ?> </td>
      <td align="left"><?php echo $list[$n][1];?></td>
      <td align="left"><span class="editlinktip hasTip"><a onclick="return listItemTask('cb0','unpublish')" href="javascript:void(0);"></a></span> <?php echo $list[$n][2];?></td>
      <td align="left"><a title="No" onclick="return listItemTask('cb0','toggle_frontpage')" href="javascript:void(0);"></a> <?php echo $list[$n][3];?></td>
      <td align="left"><a title="No" onclick="return listItemTask('cb0','toggle_frontpage')" href="javascript:void(0);"></a> <?php echo $arrUserRoles[$list[$n][6]];?></td>
      <td align="left"><?php echo $list[$n][4];?> </td>
	  
      <td nowrap="nowrap" align="left"><?php echo date($objCore->gConf['DATE_FORMAT']."   ".$objCore->gConf['TIME_FORMAT'],$list[$n][5]);?></td>
	  	<td align="center">
			<a href="index.php?f=edit&amp;id=<?php echo $list[$n][0];?>">
				<img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/edit.png" title="Edit" alt="Edit"/>			</a>		</td>
	<td align="center">
		<?php if($list[$n][0]!=$objCore->sessUId){?>	
			<a href="javascript:del('<?php echo $list[$n][0];?>');"><img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/delete.png" title="Delete" alt="Delete"/>			</a>
		<?php } else{?>
			<a href="javascript:del_restrict();"><img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/delete.png" title="Delete" alt="Delete"/></a>
		<?php } ?>	</td>
    </tr>
    <?php }?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="12"><del class="container">
        <div class="pagination">        </div>
      </del> </td>
    </tr>
  </tfoot>
</table>
</fieldset>
