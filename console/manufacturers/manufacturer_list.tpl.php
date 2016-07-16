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
		echo $objCore->msgBox("MANUFACTURER",$msg,'98.99%');
	}
	$paginationSize = $objCore->gConf['RECS_IN_LIST_CONSOLE'];
	$list=$objManufacturer->get_dList('',$_REQUEST['pg'],$paginationSize);
?>
 <div align="right"><?php echo $objManufacturer->pgBar; ?></div>	
<fieldset id="page-middle-middle-content">
<legend>Manufacturer List </legend>

<table  cellspacing="1" class="adminlist" width="100%">
  <thead>
    <tr>
      <th width="5%" height=""> # </th>
      <th width="36%" class="title"> <a title="Click to sort by this column" href="javascript:tableOrdering('c.title','desc','');">Manufacturer</a> </th>
      <th width="28%" nowrap="nowrap"> <a title="Click to sort by this column" href="javascript:tableOrdering('c.state','desc','');">Added By </a> </th>
      <th width="23%" nowrap="nowrap"><a title="Click to sort by this column" href="javascript:tableOrdering('c.state','desc','');">Added Date </a></th>
     
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
			
			$list_email=$objManufacturer->getAddedBy($list[$n][2]);
			
	?>
    <tr class="row0">
      <td align="left"><?php echo $rowNo; ?> </td>
      <td align="left"><?php echo $list[$n][1];?></td>
      <td align="left"><span class="editlinktip hasTip"><a onclick="return listItemTask('cb0','unpublish')" href="javascript:void(0);"></a></span> <?php echo $list_email;?></td
	  
      ><td nowrap="nowrap" align="left"><?php echo date($objCore->gConf['DATE_FORMAT']."   ".$objCore->gConf['TIME_FORMAT'],$list[$n][3]);?></td>
	  	<td align="center">
			<a href="index.php?f=edit&amp;id=<?php echo $list[$n][0];?>">
				<img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/edit.png"/></a></td>
	<td align="center">
			<a href="javascript:del('<?php echo $list[$n][0];?>');"><img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/delete.png"/>			</a>
	</td>
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
