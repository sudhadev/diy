<?php

/*
 * --------------------------------------------------------------------------\
 * ' This file is part of shoping Cart in module library of FUSIS '
 * ' (C) Copyright 2004 www.fusis.com '
 * ' ..........................................................................'
 * ' '
 * ' AUTHOR : Ashan Rupasinghe <ashanrupasinghe11@gmail.com> '
 * ' FILE : console/users/blog_post_edit.tpl.php '
 * ' PURPOSE : edit users page of the user section '
 * ' PRE CONDITION : commented '
 * ' COMMENTS : '
 * '--------------------------------------------------------------------------
 */
?>

<!-- Call to dList funtion and take correspond values that match with ID into a $list array.  -->
<?php
// require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);$objComponent=new Component;
// require_once($objCore->_SYS['PATH']['CLASS_LISTING']);$objListing=new Listing;
$id = $_REQUEST ['id'];
$list = $objBlog->get_dList ( $id );
//print_r ( $list );

// $user = $objManufacturer->getUser($list[0][2]);
// $list = $objListing->get_dList($_REQUEST['id']);
?>

<!-- Display the error messages  -->
<?php
if ($msg) {
	echo $objCore->msgBox ( "BLOG", $msg, '98.99%' );
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
		<form action="" method="post" name="adminForm" id="adminForm"
			enctype="multipart/form-data" style="left: auto">
			<fieldset id="page-middle-middle-content">
				<legend>Edit Post - <?php echo $list[0][1]; ?></legend>
				<table class="admintable" width="440">

					<tr style="background-color: #FFFFEA">

						<td></td>
					</tr>
					<tr>

						<td class="key" align="right">Title</td>
						<td><input name="mname" class="text_area" id="mname" size="30"
							type="text" value="<?php echo $list[0][1]; ?>" /></td>
					</tr>
					<tr>
						<td class="key" align="right">Content</td>
						<td><textarea><?php echo $list[0][2]; ?></textarea></td>
					</tr>
					<tbody>
						<tr>
							<td class="key" align="right" width="131">&nbsp;</td>
							<td width="327"><label> <input type="submit" name="Submit"
									value="Edit" /> <input type="hidden" name="action" value="edit" />
							</label></td>
						</tr>
					</tbody>
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