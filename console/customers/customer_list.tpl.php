<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>          		'
  '    FILE            :  customer_list.tpl.php                     				'
  '    PURPOSE         :                   												'
  '    PRE CONDITION   :                                             			'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
?>
<?php
	
	require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
	$objComponent = new Component();
	if ($_REQUEST['customer_type'] && $_REQUEST['customer_status'])
	{
		$list=$objCustomer->get_dList('', $_REQUEST['customer_type'], $_REQUEST['customer_status'], $_REQUEST['search'], $_REQUEST['search_by'], $_REQUEST['sort_by']);
		if ($list == null ) $msg = array('ERR', 'NO_MATCHES');
	}
	else
	{
		$list=$objCustomer->get_dList('', 'S', 'Y', '', '', 'added_date');
	}
	if($msg)
	{
		echo $objCore->msgBox("CUSTOMER",$msg,'96%');
	}

?>
<fieldset  style="border:1px solid #CCCCCC"id="page-middle-middle-content">
<legend>Search</legend>
<form id="frm" action="">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" id="tblSearch">
      <tbody>
        <tr align="center">
          <td height="23"> </td>
          <td><table cellspacing="0" cellpadding="0" border="0">
              <tbody>
                <tr>
                  <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td width="10"> </td>
                          <td><input type="text" value="<?php echo $_REQUEST['search']; ?>" size="30" id="search" class="" name="search"/></td>
                          <td width="80" align="center">By</td>
									<td><?php
									echo $objComponent->drop('search_by', $_REQUEST['search_by'], array(
				"Name"=>"Name",
				"E-mail"=>"E-Mail",
			), '', '');
							?></td>
                          <td> </td>
                          <td width="60" align="center"><input type="submit" value="Search" class="btn_common" name="button2"/>
                            <input type="hidden" value="1" id="pg" name="pg"/></td>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="20"> </td>
                  <td width="20" class="vertical-line"></td>
                  <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td width="60" align="center">Filter&nbsp;By</td>
                          <td><?php
									echo $objComponent->drop('customer_type', $_REQUEST['customer_type'], array(
				"S"=>"Suppliers",
				"B"=>"Buyers",
			), '', 'onchange="form.submit();"');
							?></td>
                          <td> </td>
                          <td> </td>
                          <td> </td>
									<td><?php
									echo $objComponent->drop('customer_status', $_REQUEST['customer_status'], array(
				"Y"=>"Active",
				"A"=>"Approved",
				"N"=>"Inactive",
				"D"=>"Deleted",
				"B"=>"Blocked",
				"W"=>"Waiting",
				"R"=>"Rejected",
			), '', 'onchange="form.submit();"');
							?></td>
                          <td> </td>
                          <td> </td>
                          <td> </td>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="20"> </td>
                  <td width="20" class="vertical-line"></td>
                  <td>
                    <table width="100%" cellspacing="0" cellpadding="0" border="0">
                      <tbody>
                        <tr>
                          <td width="60" align="center">Sort&nbsp;By</td>
									<td><?php
									echo $objComponent->drop('sort_by', $_REQUEST['sort_by'], array(
				"l_name"=>"Name",
				"email"=>"E-Mail",
			), '' , 'onchange="form.submit();"');
							?></td>
                          <td> </td>
                        </tr>
                      </tbody>
                    </table></td>
                  <td width="10"> </td>
                </tr>
              </tbody>
            </table></td>
          <td width="15"> </td>
        </tr>
      </tbody>
    </table>
  </form>
  </fieldset>
<fieldset  id="page-middle-middle-content">
 <legend>Customer List</legend>
<table  cellspacing="1" class="adminlist" width="100%">
  <thead>
    <tr>
      <th width="" height=""> # </th>
      <th width="" class="title"> <a title="Click to sort by this column" href="javascript:tableOrdering('c.title','desc','');">First Name</a> </th>
      <th width="" nowrap="nowrap"> <a title="Click to sort by this column" href="javascript:tableOrdering('c.state','desc','');">Last Name </a> </th>
      <th width="" nowrap="nowrap"><a title="Click to sort by this column" href="javascript:tableOrdering('c.state','desc','');">Email</a></th>
      <th width="" nowrap="nowrap">Password</th>
      <th width="" nowrap="nowrap" class="title"><a title="Click to sort by this column" href="javascript:tableOrdering('frontpage','desc','');">Telephone</a></th>
      <th width="" align="center"><a title="Click to sort by this column" href="javascript:tableOrdering('c.created','desc','');">Date</a></th>
      <th width="" class="title"><a title="Click to sort by this column" href="javascript:tableOrdering('c.id','desc','');"></a></th>
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
      <td align="left"><?php echo $list[$n][7];?> </td>
      <td align="left"><?php echo $list[$n][4];?> </td>
      <td nowrap="nowrap" align="left"><?php echo date($objCore->gConf['DATE_FORMAT']." ".$objCore->gConf['TIME_FORMAT'],$list[$n][5]);?></td>
      <td align="center"><a href="index.php?f=more&amp;id=<?php echo $list[$n][0];?>" alt="More Info" title="More Info"> <img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/more_info.png"/></a>&nbsp;&nbsp;&nbsp; 
      <?php
        if ($_REQUEST['customer_status'] != 'W' && $_REQUEST['customer_status'] != 'R')
        {
      ?>
      <a href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/revenue/index.php?id=<?php echo $list[$n][0];?>" alt="Order Details" title="Order Details"> <img height="16" width="16" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/orders.png"/></a>&nbsp;&nbsp;&nbsp;
      <a href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/listing/index.php?id=<?php echo $list[$n][0];?>" alt="Listings" title="Listings"> <img height="16" width="16" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/listings.png"/></a>&nbsp;&nbsp;&nbsp;
      <a href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/cus_listings/index.php?cusId=<?php echo $list[$n][0];?>&f=add" alt="Manage Listings" title="Manage Listings"> <img height="16" width="16" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/list_edit.png"/></a>&nbsp;&nbsp;&nbsp;
      <?php
        }
        if ($_REQUEST['customer_status'] != 'D')
        {
      ?>
      	<a href="javascript:del('<?php echo $list[$n][0];?>');" alt="Delete" title="Delete"><img height="13" width="12" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/delete.png"/></a> 
      <?php } ?>
    </tr>
    <?php }?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="12"><del class="container">
        <div class="pagination"> </div>
        </del> </td>
    </tr>
  </tfoot>
</table>
</fieldset>
