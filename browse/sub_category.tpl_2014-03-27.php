<?php

$pcid=$_REQUEST['pcid'];


//$objCategory->dev=true;
// Get requested 2nd level category
	$secondLevelCat=$objCategory->getCategory($pcid);
// Get Top level category
	$topLevelCat=$objCategory->getCategory($secondLevelCat['parent']);
//    require_once($objCore->_SYS['PATH']['CLASS_LISTING']);$objListing=new Listing();
//    $objListing->dev=true;echo "==========================";
//$listingCountForCategories=$objListing->getListingCountsByACategory('70','3','1'); echo $listingCountForCategories;


/*
 * Check for uncategorised listings
 */
    if($_REQUEST['tcid']=='2' ||$_REQUEST['tcid']=='3')
    {
        switch ($_REQUEST['tcid'])
        {
            case '2':
                {
                    // for services
                    require_once($objCore->_SYS['PATH']['CLASS_SERVICE']);if(!is_object($objService)) $objService=new Service();
                    $listCount=$objService->getListingCountsByCategories($_REQUEST['tcid'],$pcid);
                }
                break;
            case '3':
                {
                    // for classified ads

                    require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);if(!is_object($objClassifiedAd)) $objClassifiedAd = new ClassifiedAd($objCore->gConf);
                    $listCount=$objClassifiedAd->getListingCountsByCategories($_REQUEST['tcid'],$pcid);
                }
                break;

        }

        
    }
?> 
        <div id="middle_right_bar">
          <div id="middle_center_bar">
            <div id="middle_center_bar_header"></div>
            <div id="middle_center_bar_content">
            
             
            
               <div id="banner"><?php echo $topLevelCat['category']?></div>
              
              <?php
     
             	
             	 	//get sub category list
             	 	$listSub=$objCategory->getSubcList($pcid,'sub_arr');
                    
             	 	// chelanga - get the second level category             	  
             	 	$breadCrumleve2[1] = $secondLevelCat['category'];//(explode('-',$secondLevelCat['category']));
             	  
              ?>
                   
               <div class="breadcrumb"><a href="?tcid=<?php echo $_REQUEST['tcid'];?>"> <?php echo $topLevelCat['category']; ?> </a> > <?php echo $breadCrumleve2[1]; ?> </div>
              
                   
		              <div class="middle_center_bar_cells">
                      <?php /*?>
		                <div class="middle_center_bar_cells_head">
                  <?php   switch ($_REQUEST['tcid']) {
                           case 2:
                           {
                      ?>
                                <div ><a href="?f=result&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo $secondLevelCat['id'];?>&categories=2&categoryId=<?php echo $secondLevelCat['id'];?>&pg=1"><?php echo $secondLevelCat['category'];?></a> </div>
                  <?php    } break;
                           case 3:
                           {
                      ?>
                                <div ><a href="?f=result&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo $secondLevelCat['id'];?>&categories=3&categoryId=<?php echo $secondLevelCat['id'];?>&pg=1"><?php echo $secondLevelCat['category'];?></a></div>
                      <?php
                           }break;
                           default:
                           { ?>
                                <div ><a href="?f=slist&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo $secondLevelCat['id'];?>"><?php echo $secondLevelCat['category'];?></a> </div>
                      <?php     } ?>
                        <?php } ?>
                        </div>
                        <?php */?>

                       <?php
                        /*
                         * Uncategorised listings are available
                         */
                          if($listCount)
                          {
                       ?>
                       <div class="nav-menu">
                       <ul>
                            <li><a href="?f=result&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo $secondLevelCat['id'];?>&categories=<?php echo $_REQUEST['tcid'];?>&categoryId=<?php echo $secondLevelCat['id'];?>&pg=1">Miscellaneous</a></li>
                        </ul>
                       </div>

                       <?php
                          }
                       ?>



                        <?php
                          if(count($listSub))
                            {// if there isnt any sub category no point of showing the top level

                        ?>
		                <div class="nav-menu">
		                  <ul>
		                  <?php
		                  	// Start 3rd level category loop

		                  	for($d=0;$d<count($listSub);$d++){
		                  		// get listing for each level 3 category
		                  	  $numListings = $objListing->getListingsforACategory($_REQUEST['tcid'],$_REQUEST['pcid'],$listSub[$d][0]);
		                  	  
		                  ?>
		                  <?php  switch ($_REQUEST['tcid']) {
                                 case 2:
                                 {
                          ?>
                                    <li><a href="?f=result&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo  $_REQUEST['pcid'];?>&categories=2&categoryId=<?php echo $listSub[$d][0];?>&pg=1" ><?php echo $listSub[$d][3];?></a>&nbsp;[<?php echo $numListings;?>]</li>
		                  <?php 
                                 }break;
                                 case 3:
                                 {
                          ?>
                                    <li><a href="?f=result&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo  $_REQUEST['pcid'];?>&categories=3&categoryId=<?php echo $listSub[$d][0];?>&pg=1" ><?php echo $listSub[$d][3];?></a>&nbsp;[<?php echo $numListings;?>]</li>
                          <?php
                                 }break;
                                 default:
                                 {
                          ?>
                                    <li><a href="?f=spec&tcid=<?php echo $_REQUEST['tcid'];?>&pcid=<?php echo  $_REQUEST['pcid'];?>&catId=<?php echo $listSub[$d][0];?>" ><?php echo $listSub[$d][3];?></a>&nbsp;[<?php echo $numListings;?>]</li>
                          <?php
                                 }break;
                                }
		                    }
		                  ?>

		                  </ul>
		                </div>
		                <div class="middle_center_bar_cells_foot">

		                	</div>
		              
              <?php 
              		  } // end if for sub category list count
                      ?>

                      </div>
                      <?php
              			 if (count($listSub)==0) 
              			 {	
    			  ?>            
					<div class="no_data">No Sub-Categories Found for <?php echo $secondLevelCat['category'];?></div>
					<?php } ?>
              </div>
            <div id="middle_center_bar_bottom">	        
             </div>
          </div>
          
			<?php include($objCore->_SYS['PATH']['RIGHT_FRONT']);?>
        </div>
