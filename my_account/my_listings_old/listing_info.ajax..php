<?php

  /*--------------------------------------------------------------------------\
  '    This file is part  module library of FUSIS                             '
  '    (C) Copyright 2002-2009 www.fusis.com                                  '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Lakshyami Nanayakkara <lakshyami@gmail.com>     	  '
  '    FILE            :  listing_add_edit.ajax.php          		  '
  '    PURPOSE         :  provide listings for any section of the system      '
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

	require_once("../../classes/core/core.class.php");$objCore=new Core;
	
	require_once($objCore->_SYS['PATH']['CLASS_LISTING']);$objListing = new Listing;
	
	//Display the logged user.
  	$objCore->auth(1,true);

        // changed by saliya 24th Nov 2010
        $listingData = $objListing->calculate_credit($objCore->sessCusId);

        $credit = $listingData['listCanAdd'];


	
?>
<?php if ($listingData['listAvailable'] < 20) { ?>
                    <div style="width: 630px; margin-top: 10px; margin-left: 5px; display: block;" class="commonInfoBox" id="specialInfo">
                        <div style="display: block;" id="addSecCat">

                            <strong>Note*:</strong>
                            Please note that while your current subscription allows you to have <strong><?php echo $listingData['listAllowed'] ?> active listings</strong>,
                            you have added <strong> <?php echo $listingData['listTotal'] ?> listings</strong> to the system.
                            <strong><?php echo $listingData['listActive'] ?> listings are in active mode</strong> and <strong><?php echo $listingData['listInactive'] ?> listings are in inactive mode</strong>.
                            <br/><br/>You can add only <strong><?php echo $listingData['listCanAdd'] ?> more active listings</strong> and
                            we recommend you to <a href="<?php echo $objCore->_SYS['CONF']['URL_MY_ACCOUNT'];?>/my_subscriptions/?selections=S&packages=1#upgSubscript"><strong>upgrade your subscription</strong></a>.            </div>
                    </div>
<?php } else {?>
&nbsp;
<?php } ?>