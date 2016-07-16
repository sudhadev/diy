<?php

/*
 * --------------------------------------------------------------------------\
 * ' This file is part of shoping Cart in module library of FUSIS '
 * ' (C) Copyright 2004 www.fusis.com '
 * ' ..........................................................................'
 * ' '
 * ' AUTHOR : Ashan Rupasinghe '
 * ' FILE : console/users/blog_post_list.tpl.php '
 * ' PURPOSE : list users page of the user section '
 * ' PRE CONDITION : commented '
 * ' COMMENTS : '
 * '--------------------------------------------------------------------------
 */
?>

<!-- Display the successfull messages  -->
<?php
if ($msg) {
	echo $objCore->msgBox ( "BLOG", $msg, '98.99%' );
}
 $paginationSize = $objCore->gConf['RECS_IN_LIST_CONSOLE'];
	$list=$objBlog->get_dList('',$_REQUEST['pg'],$paginationSize); 
/* $list = $objBlog->get_dList (); */
?>
<div align="right"><?php echo $objBlog->pgBar; ?></div>
<fieldset id="page-middle-middle-content">
	<legend>Post List </legend>

	<table cellspacing="1" class="adminlist" width="100%">
		<thead>
			<tr>
				<th width="3%" height="">#</th>
				<th width="48%" class="title"><a
					title="Click to sort by this column"
					href="javascript:tableOrdering('c.title','desc','');">Title</a></th>
				<!-- <th width="45%" nowrap="nowrap"> <a title="Click to sort by this column" href="javascript:tableOrdering('c.state','desc','');">Content</a> </th> -->
				<th width="10	%" nowrap="nowrap"><a
					title="Click to sort by this column"
					href="javascript:tableOrdering('c.state','desc','');">Post by </a></th>
				<th width="10%" nowrap="nowrap"><a
					title="Click to sort by this column"
					href="javascript:tableOrdering('c.state','desc','');">Post Date</a></th>
				<th width="10%" nowrap="nowrap"><a
					title="Click to sort by this column"
					href="javascript:tableOrdering('c.state','desc','');">Modified by </a></th>
				<th width="10%" nowrap="nowrap"><a
					title="Click to sort by this column"
					href="javascript:tableOrdering('c.state','desc','');">Modified Date</a></th>
				<th width="3%" class="title">&nbsp;</th>
				<th width="3%" class="title">&nbsp;</th>
				<th width="3%" class="title">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
			<!-- Retriew data from database and display the data corresponding fields -->
    <?php
				for($n = 0; $n < count ( $list ); $n ++) {
					$rowNo = $n + 1;
					
					?>
    <tr class="row0">
				<td align="left"><?php echo $rowNo; ?> </td>
				<td align="left"><a
					href="index.php?f=edit&amp;id=<?php echo $list[$n][0];?>"><?php echo $list[$n][1];?></a></td>
				<!-- <td align="left"><span class="editlinktip hasTip"><a onclick="return listItemTask('cb0','unpublish')" href="javascript:void(0);"></a></span> --> <?php // echo $list[$n][2];?>
				<!-- </td
	  
      >-->
				<td nowrap="nowrap" align="left"><?php echo $list[$n][3];?></td>
				<td align="left"><?php echo $list[$n][4];?></td>
				<td nowrap="nowrap" align="left"><?php echo $list[$n][5];?></td>
				<td align="left"><?php echo $list[$n][6];?></td>
				<td align="center"><a
					href="javascript:postpublish(<?php echo '\''.$list[$n][0].'\',\''.$list[$n][7].'\',\''.$list[$n][8].'\'';?>);"
					title="<?php if ($list[$n][7]==1){echo "click here to UNPUBLISH this post";}else{echo "click here to PUBLISH this post";}?>">
						<img height="13" width="12"
						src="<?php
					if ($list [$n] [7] == 1) {
						echo $objCore->_SYS ['CONF'] ['URL_ICONS_CONSOLE'] . '/active.png';
					} else {
						echo $objCore->_SYS ['CONF'] ['URL_ICONS_CONSOLE'] . '/inactive.png';
					}
					?>" />
				</a></td>
				<td align="center"><a
					href="index.php?f=edit&amp;id=<?php echo $list[$n][0];?>&amp;pg=<?php echo $list[$n][8]?>"> <img
						height="13" width="12"
						src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/edit.png" /></a></td>
				<td align="center"><a
					href="javascript:del('<?php echo $list[$n][0];?>');"><img
						height="13" width="12"
						src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/delete.png" />
				</a></td>

			</tr>
    <?php }?>
  </tbody>
		<tfoot>
			<tr>
				<td colspan="12"><del class="container">
						<div class="pagination"></div>
					</del></td>
			</tr>
		</tfoot>
	</table>
</fieldset>
