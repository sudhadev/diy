<?php
require_once($objCore->_SYS['PATH']['CLASS_ORDER']);
require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
$objOrder = new Order($objCore->gConf);
$objClassifiedAd = new ClassifiedAd();
$objListing = new Listing();
$orderDetails = $objOrder->getOrderDetails('', '', '', '', '', '', '', $objCore->sessCusId, 'time_order');
$totalCount = $objOrder->getTotalCount();
$classifiedInfo = $objClassifiedAd->total_ads_price($objCore->sessCusId);
$listingInfo = $objListing->getTotals($objCore->sessCusId,'Y');

require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
if(!is_object($objCustomer)) $objCustomer = new Customer(); 
$subcriptionData = $objCustomer->getStatus($objCore->sessCusId,'subs_type'); 
?>
<!-- START CONTENT AREA-->
<div id="right_bar_middle">
<div id="main_form_bg">
<div id="main_form_bg_middle">
<div id="main_form_bg_topbar">
<img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_top.jpg"></div>
<div id="main_form_bg_middlebar">
<div id="banner">My Account </div>

<?php
    if($objCore->isAuthorized(1, 'classified_ads'))
    {
?>
    <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/classified_ads/index.php?f=add"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/free-advertise.gif" alt=""  width="640" style="margin-top:15px;" border="0"></a>
 <?php 
    }
 ?>
 <div id="text_area" class="common_text">
     <?php if($subcriptionData['M'][4]=='E'||$subcriptionData['S'][4]=='E'){ ?>
<div class="msgBox" style="color:red;"> 
    <img src="http://demo.diypricecheck.co.uk/images/icons/suc.png" align="absmiddle"> &nbsp;Your subscription has expired and must be renewed for your company listing to be visible </div>

    <?php } ?>
  		<div class="supplier_area_yellowbg_heading">
            <div class="list_yellow_heading">My Profile</div></div>
            <div class="supplier_area_yellowbg_mid" speed="400" id="profile" groupname="account" style="display: block;">
            	<ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/my_profile_edit_details.jpg" alt="Edit Details" border="0" /><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_profile/">CHANGE ACCOUNT DETAILS</a><br>
				</ul>
             	<ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/my_profile_change_password.jpg" alt="Change Password" border="0" /><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/change_password">CHANGE PASSWORD</a><br></ul>
                <?php // Check My Subscription with User Authorizatoin module
                if($objCore->isAuthorized(1, 'my_subscriptions'))
                {
                 ?>
                <ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/my_profile_my_subscription.jpg" alt="My Subscription" border="0" /><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_subscriptions/">MY SUBSCRIPTIONS</a><br></ul>
                <?php }?>

           </div>
			<div class="supplier_area_yellowbg_bottom" style="padding-bottom:15px"></div>
           <?php  
                   if($objCore->isAuthorized(1, 'my_listings') && in_array("M",$objCore->sessUSubsTypes) && $subcriptionData['M'][4]=='Y')
                    {
            ?>
            <div class="supplier_area_yellowbg_heading">
            <div class="list_yellow_heading">My Listings</div></div>
            <div class="supplier_area_yellowbg_mid">
				<div class="supplier_area_summery_main">
					<div class="supplier_area_summery_text common_text_ash">Total Active Listings </div>
					<div class="supplier_area_summery_numeric common_text_bold"><?php echo $listingInfo[0]['total_count']; ?></div>
					<div class="supplier_area_summery_text common_text_ash">Total Amount (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)</div>
					<div class="supplier_area_summery_numeric common_text_bold"><?php echo $listingInfo[0]['total_sum']; ?></div>
				</div>

                <ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/my_listings_add.jpg" alt="Add Listings " border="0" /><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_listings">ADD LISTINGS</a><br></ul>
                <?php if($listingInfo[0]['total_count']) {?><ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/my_listings_manage.jpg" alt="Edit My Listings " border="0" /><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_listings_edit">EDIT MY LISTINGS</a><br></ul><?php }?>
			</div>
			<div class="supplier_area_yellowbg_bottom"></div>
            <?php
                    }
            ?>

           <?php 
                   if($objCore->isAuthorized(1, 'services') && in_array("S",$objCore->sessUSubsTypes)&& $subcriptionData['S'][4]=='Y')
                    {
            ?>
            <div class="supplier_area_yellowbg_heading">
            <div class="list_yellow_heading">My Services</div></div>
            <div class="supplier_area_yellowbg_mid">

                <ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/my_services.jpg" alt="Manage My Listings " border="0" /><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/services/">MANAGE MY SERVICES</a><br></ul>
			</div>
			<div class="supplier_area_yellowbg_bottom"></div>
            <?php
                    }
            ?>


           <?php
                   if($objCore->isAuthorized(1, 'classified_ads'))
                    {
            ?>
            <div class="supplier_area_yellowbg_heading">
            <div class="list_yellow_heading">My Classified Ads</div></div>
            <div class="supplier_area_yellowbg_mid">
				<div class="supplier_area_summery_main">
					<div class="supplier_area_summery_text common_text_ash">Total Ads </div>
					<div class="supplier_area_summery_numeric common_text_bold"><?php echo intval($classifiedInfo[0]); ?></div>
					<div class="supplier_area_summery_text common_text_ash">Total Amount (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)</div>
					<div class="supplier_area_summery_numeric common_text_bold"><?php echo $classifiedInfo[1]; ?></div>
				</div>

				<ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/classified_adds_add.jpg" alt="Add Listings" border="0" /><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/classified_ads/index.php?f=add" style="text-decoration: underline;">ADD CLASSIFIED ADS</a><br>
				</ul>
				<ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/classified_adds_edit.jpg" alt="Add Listings" border="0" /><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/classified_ads/index.php?f=manage" style="text-decoration: underline;">EDIT MY CLASSIFIED ADS</a><br>
				</ul>
                </div>
			<div class="supplier_area_yellowbg_bottom"></div>
            <?php
                    }
            ?>

           <?php
                   if($objCore->isAuthorized(1, 'my_requests'))
                    {
            ?>

                        <div class="supplier_area_yellowbg_heading">
            <div class="list_yellow_heading">My Requests</div></div>
            <div class="supplier_area_yellowbg_mid">
               	<ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/my_listings_add.jpg" alt="Add Listings" border="0" />
				<a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/new_listings/?req=cate&ids=1">NEW REQUESTS</a>
                 &nbsp;
                                (
                                <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/new_listings/?req=cate&ids=1">Building Supplies</a> |
                                <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/new_listings/?req=cate&ids=2">Building Services</a> | 
                                <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/new_listings/?req=cate&ids=3">Classified Ads</a>
                                )
                <br>
				</ul>
				<ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/requested_categories.jpg" alt="Requested Categories" border="0" /><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_requests/?category=1" style="text-decoration: underline;">REQUESTED CATEGORIES</a><br>
				</ul>
				<ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/requested_specifications.jpg" alt="Requested Specifications" border="0" /><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_requests/?f=spec&category=1" style="text-decoration: underline;">REQUESTED SPECIFICATIONS</a><br>
				</ul>
            </div>
			<div class="supplier_area_yellowbg_bottom"></div>
            <?php
                    }
            ?>

           <?php
                   if($objCore->isAuthorized(1, 'my_orders'))
                    {
            ?>
                        
                        <div class="supplier_area_yellowbg_heading">
            <div class="list_yellow_heading">My Orders</div></div>
            <div class="supplier_area_yellowbg_mid">
				<div class="supplier_area_summery_main">
					<div class="supplier_area_summery_text common_text_ash">Total Orders </div>
					<div class="supplier_area_summery_numeric common_text_bold"><?php echo $totalCount; ?></div>
					<div class="supplier_area_summery_text common_text_ash">Total Amount (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)</div>
					<div class="supplier_area_summery_numeric common_text_bold"><?php echo $orderDetails[1]; ?></div>
				</div>

				<ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/order_history.jpg" alt="Add Listings" border="0" /><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_orders/?pg=1" style="text-decoration: underline;">ORDER HISTORY</a><br>
				</ul>
				<ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/my_schedule.jpg" alt="Add Listings" width="30" style="margin-left:5px;" border="0" /><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_schedules/?pg=1" style="text-decoration: underline;">SCHEDULE PAYMENTS</a><br>
				</ul>


            </div>
			<div class="supplier_area_yellowbg_bottom"></div>
            <?php
                    }
            ?>
  			<!--MY QUOTAIONS TAB/BOX-->
           <?php
                   if($objCore->isAuthorized(1, 'my_quotations'))
                    {
            ?>

			<div class="supplier_area_yellowbg_heading">
            <div class="list_yellow_heading">My Quotations</div></div>
			<div class="supplier_area_yellowbg_mid">
              <?/*
				<div class="supplier_area_summery_main">
					<div class="supplier_area_summery_text common_text_ash">Total Quotations </div>
					<div class="supplier_area_summery_numeric common_text_bold">23</div>
					<div class="supplier_area_summery_text common_text_ash">Total Amount (&pound;)</div>
					<div class="supplier_area_summery_numeric common_text_bold">2,089.00</div>
				</div>
                */?>
				<ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/manage_my_quotations.jpg" alt="Manage My Quotations" border="0"/><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_quotations" style="text-decoration: underline;">MANAGE MY QUOTATIONS</a><br> 
				</ul>
            </div>
			<div class="supplier_area_yellowbg_bottom"></div>
            <?php
                    }
            ?>
                        
                        <div class="supplier_area_yellowbg_heading">
            <div class="list_yellow_heading">Email Subscriptions</div></div>
			<div class="supplier_area_yellowbg_mid">
              <?/*
				<div class="supplier_area_summery_main">
					<div class="supplier_area_summery_text common_text_ash">Total Quotations </div>
					<div class="supplier_area_summery_numeric common_text_bold">23</div>
					<div class="supplier_area_summery_text common_text_ash">Total Amount (&pound;)</div>
					<div class="supplier_area_summery_numeric common_text_bold">2,089.00</div>
				</div>
                */
              //echo $objCore->sessCusId;
              ?>
				<ul><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/manage_my_quotations.jpg" alt="Email Subscriptions" border="0"/><a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/?f=email_subscriptions" style="text-decoration: underline;">EMAIL SUBSCRIPTIONS</a><br> 
				</ul>
            </div>
			<div class="supplier_area_yellowbg_bottom"></div>
			<!--/PLACE THIS AREA TO MAKE/ MY QUOTAIONS TAB/BOX-->

  </div>

<!-- yellow part<div id="form_bg"> -->
<div id="form_outer">
<div id="form_middle">
 <div class="form_middle_text"><br>
   <br></div>
</div>
</div>
<!--</div>
</div>-->
</div>
</div>
<div id="main_form_bg_bottombar"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/main_form_bg_bottom.jpg"></div>
</div>
</div>
<!-- END CONTENT AREA-->