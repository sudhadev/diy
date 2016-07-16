<?php	// Create an object to the User class.
  	require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
	if(!is_object($objCategory))
	{
		$objCategory= new Category;
	}


 $pattern = '/'.$objCore->curSection().'/';
 $url = $objCore->curPageURL();

preg_match($pattern, $url, $selc, PREG_OFFSET_CAPTURE);
?>

<ul id="menu">
    <?php // Check User Module with User Authorizatoin - Added by saliya
        if($objCore->isAuthorized(0, 'users'))
        {
    ?>
	<li class="node <?php echo ($selc[0][0]=="users")?"selc":"";?>"><a>Users</a>
		<ul style="width: 145px;">
		<li style="width: 145px;"><a class="icon-1-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/users/?f=add">Add Users</a></li>
		<li style="width: 145px;"><a class="icon-2-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/users/?">User List</a></li>
		<li style="width: 145px;" class="separator"><span></span></li>
		<li style="width: 145px;"><a class="icon-3-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/users/?f=change">Change My Password</a></li>
		</ul>
	</li>
	<?php } ?>
    <?php // Check User Module with User Authorizatoin - Added by saliya
        if($objCore->isAuthorized(0, 'customers'))
        {
    ?>
	<li class="node <?php echo($selc[0][0]=="customers")?"selc":"";?>"><a>Customers</a>
		<ul style="width: 110px;">
                <li style="width: 145px;"><a class="icon-4-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/my_profile/">Add Customers</a></li>
		<li style="width: 145px;"><a class="icon-4-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/customers/">Customer List</a></li>
		<li style="width: 145px;"><a class="icon-5-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/customers/?search=&search_by=Name&pg=1&customer_type=S&customer_status=W&sort_by=l_name">Pending Approval</a></li>
		<li style="width: 145px;"><a class="icon-23-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/customers/?f=prcd">Promotion Codes</a></li>
		<li style="width: 145px;"><a class="icon-23-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/customers/?f=prcd_list">Promotion Codes List</a></li>
                </ul>
	</li>
	<?php } ?>
    <?php // Check User Module with User Authorizatoin - Added by saliya
        if($objCore->isAuthorized(0, 'revenue'))
        {
    ?>
	<li class="node <?php echo($selc[0][0]=="revenue")?"selc":"";?>"><a>Revenue</a>
		<ul style="width: 110px;">
		<li style="width: 145px;"><a class="icon-6-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/revenue/">Completed Orders</a></li>
		<li style="width: 145px;" class="separator"><span></span></li>
        <li style="width: 170px;"><a class="icon-20-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/revenue/?f=fadd">Incomplete Orders</a></li>
		<li style="width: 170px;"><a class="icon-21-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/revenue/?f=odrf">Refunded Transactions</a></li>
		<li style="width: 170px;"><a class="icon-22-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/revenue/?f=sdul">Scheduled Payments</a></li>

		</ul>
	</li>
	<?php } ?>
    <?php // Check User Module with User Authorizatoin - Added by saliya
        if($objCore->isAuthorized(0, 'category'))
        {
    ?>
	<li class="node <?php echo($selc[0][0]=="category")?"selc":"";?>"><a>Categories</a>
		<ul style="width: 140px;">
		<li style="width: 140px;"><a class="icon-7-menu"  href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/category/?f=add">Add Categories</a>
</li>
		<li style="width: 140px;"><a class="icon-8-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/category/?f=list">Category List</a></li>
		<li style="width: 140px;"><a class="icon-9-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/category/?f=plist">Pending Approval</a></li>
                </ul>
	</li>
	<?php } ?>
    <?php // Check User Module with User Authorizatoin - Added by saliya
        if($objCore->isAuthorized(0, 'specifications'))
        {
    ?>
	<li class="node <?php echo($selc[0][0]=="specifications")?"selc":"";?>"><a>Specifications</a>
		<ul style="width: 140px;">
		<li style="width: 140px;"><a class="icon-10-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/specifications/?f=add">Add Specifications</a></li>
		<li style="width: 140px;"><a class="icon-11-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/specifications/?f=list">Specification List</a></li>
                <li style="width: 140px;"><a class="icon-12-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/specifications/?f=plist">Pending Approval</a></li>
		</ul>
	</li>
	<?php } ?>
    <?php // Check User Module with User Authorizatoin - Added by saliya
        if($objCore->isAuthorized(0, 'listing'))
        {
    ?>
	<li class="node <?php echo($selc[0][0]=="listing")?"selc":"";?>"><a href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/listing/index.php?time=all">Listings</a>
	</li>
	<?php } ?>
    <?php // Check User Module with User Authorizatoin - Added by saliya
        if($objCore->isAuthorized(0, 'global_config'))
        {
    ?>
	<li class="node <?php echo($selc[0][0]=="global_config")?"selc":"";?>"><a href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/global_config">Global Configuration</a>
	</li>
	<?php } ?>
    <?php // Check User Module with User Authorizatoin - Added by saliya
        if($objCore->isAuthorized(0, 'cms'))
        {
    ?>
	<li class="node <?php echo($selc[0][0]=="cms")?"selc":"";?>"><a>CMS</a>
		<ul style="width: 140px;">
		<li style="width: 140px;"><a class="icon-13-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/cms/?f=edit&pid=13">About Us</a></li>
		<li style="width: 140px;"><a class="icon-14-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/cms/?f=edit&pid=16">Privacy Policy</a></li>
		<li style="width: 140px;"><a class="icon-15-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/cms/?f=edit&pid=17">Green Ideas</a></li>
		<li style="width: 160px;"><a class="icon-18-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/cms/?f=edit&pid=18">Terms and conditions</a></li>
		<li style="width: 160px;"><a class="icon-24-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/cms/?f=edit&pid=19">Fees Schedule</a></li>
		<li style="width: 160px;"><a class="icon-18-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/cms/?f=edit&pid=20">Registration Terms</a></li>
		
                </ul>
  </li>
	<?php } ?>
    <?php // Check User Module with User Authorizatoin - Added by saliya
        if($objCore->isAuthorized(0, 'manufacturers'))
        {
    ?>
	<li class="node <?php echo($selc[0][0]=="manufacturers")?"selc":"";?>"><a>Manufacturers</a>
		<ul style="width: 140px;">
		<li style="width: 140px;"><a class="icon-16-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/manufacturers/?f=add">Add Manufacturers</a></li>
		<li style="width: 140px;"><a class="icon-17-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/manufacturers/?f=list">Manufacturer List</a></li>
		</ul>
	</li>
	<?php } ?>
    <?php // Check User Module with User Authorizatoin - Added by saliya
        if($objCore->isAuthorized(0, 'help'))
        {
    ?>
	<li class="node <?php echo($selc[0][0]=="help")?"selc":"";?>"><a>Help</a>
		<ul style="width: 110px;">
		<li style="width: 110px;"><a class="icon-18-help" href="JavaScript:newPopup('<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/help/index.php');">Index</a></li>
		<li style="width: 110px;"><a class="icon-19-help" href="#">About</a></li>
		</ul>
	</li>
	<?php } ?>
	<?php // Check User Module with User Authorizatoin - Added by Ashan
       // if($objCore->isAuthorized(0, 'blog'))
        //{
    ?>
	<li class="node <?php echo($selc[0][0]=="blog")?"selc":"";?>"><a>Blog</a>
		<ul style="width: 140px;">
		<li style="width: 140px;"><a class="icon-7-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/blog/?f=add">Add Post</a></li>
		<li style="width: 140px;"><a class="icon-8-menu" href="<?php echo $objCore->_SYS['CONF']['URL_CONSOLE'];?>/blog/?f=list">Post List</a></li>
		
		
		
                </ul>
  </li>
	<?php //} ?>

</ul>
