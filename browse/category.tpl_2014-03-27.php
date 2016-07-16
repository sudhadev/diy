<?php
$numOfSubCatsInList=2;

?> 
        <div id="middle_right_bar">
        <div id="middle_center_bar">
        <div id="middle_center_bar_header"></div>
        <div id="middle_center_bar_content">
              <?php
              
              // Start 1st level category loop
              	
              	 $topList=$objCategory->getTopcList();
                 
             	 for($tl=1;$tl<=count($topList);$tl++){
                     if(($_REQUEST['tcid'] && ($_REQUEST['tcid']==$topList[$tl]['id'])) ||!$_REQUEST['tcid'] ){
                 
              ?>           
              <div id="banner"><?php echo $topList[$tl]['category']?></div>
                        
              <?php
              	// Start 2nd level category loop
              	              	
              	 $list=$objCategory->getSubcList($topList[$tl]['id'],'sub_arr');
              	 
              	// echo count($list);
                 
              	 //print_r($list);
              	 //exit;
                 
              	 $pointer = 1;
             	 for($l=0;$l<count($list);$l++){
             	 	//get sub category list
             	 	$listSub=$objCategory->getSubcList($list[$l][0],'sub_arr');
             	 	
             	 	if(count($listSub))
             	 	{// if there isnt any sub category no point of showing the top level
                            if($pointer%2==1){
                                $class = "middle_center_bar_cells";
                            }
                            else{
                                $class = "middle_center_bar_cells_right";
                            }
                            $pointer++;
              ?>
              
		              <div class="middle_center_bar_cells">
		                <div class="middle_center_bar_cells_head">
		                
		                  <div ><a href="?f=slist&tcid=<?php echo $topList[$tl]['id'];?>&pcid=<?php echo $list[$l][0];?>"><?php echo $list[$l][3];?></a></div>
                        </div>
		                <div class="nav-menu">
		                  <ul>
		                  <?php
		                   	// Start 3rd level category loop
		                  	(count($listSub)>$numOfSubCatsInList)? $loopTill=$numOfSubCatsInList-1: $loopTill=$loopTill;
		                  	 for($d=0;$d<=$loopTill;$d++){
                               // get listing for each level 3 category added by chelanga
                               
		                  	  $numListings = $objListing->getListingsforACategory($topList[$tl]['id'],$list[$l][0],$listSub[$d][0]); 
		                  	              		
                                switch ($topList[$tl]['id'])
                                {
                                    case 2:
                                    { ?>
                                        <li><a href="?f=result&tcid=<?php echo $topList[$tl]['id'];?>&pcid=<?php echo $list[$l][0];?>&categories=2&categoryId=<?php echo $listSub[$d][0];?>&pg=1" ><?php echo $listSub[$d][3];?></a> <?php if($listSub[$d][0]>0) { ?>  &nbsp;[<?php echo $numListings;?>] <?php }?></li>
                               <?php     }break;
                                    case 3:
                                    { ?>
                                        <li><a href="?f=result&tcid=<?php echo $topList[$tl]['id'];?>&pcid=<?php echo $list[$l][0];?>&categories=3&categoryId=<?php echo $listSub[$d][0];?>&pg=1" ><?php echo $listSub[$d][3];?></a><?php if($listSub[$d][0]>0) { ?> &nbsp;[<?php echo $numListings;?>]<?php }?></li>
                               <?php     }break;
                                    default:
                                    { ?>
                                        <li><a href="?f=spec&tcid=<?php echo $topList[$tl]['id'];?>&pcid=<?php echo $list[$l][0];?>&catId=<?php echo $listSub[$d][0];?>" ><?php echo $listSub[$d][3];?></a><?php if($listSub[$d][0]>0) { ?> &nbsp;[<?php echo $numListings;?>]<?php }?></li>
                               <?php     }break;
                                }
                                }?>
		                  </ul>
		                </div>
		                <div class="middle_center_bar_cells_foot">
		                <?php 
		                // changed by chelanga 
		                if(count($listSub) > $numOfSubCatsInList) {
		                   ?>
		                		<a href="?f=slist&tcid=<?php echo $topList[$tl]['id'];?>&pcid=<?php echo $list[$l][0];?>">More></a>
		                <?php 
		                	}
		                	//end
		                	?>	
		                	</div>
		              </div>
              <?php 
              		  } // end if for sub category list count
              			}// End 2nd level category loop
              
                if($tl!=(count($topList))&& !$_REQUEST['tcid'])
                { // horizontal line break wont need to the last record set
              ?>
           
              <div class="page_braek"></div>
    			  <?php 
    			  	}
                     }// End if -> check whether top level category selected or not
    			  }// End 1st level category loop
    			  ?>             

              </div>
            <div id="middle_center_bar_bottom">           
            </div>
          </div>

		  <!-- search com -->
			<?php include($objCore->_SYS['PATH']['RIGHT_FRONT']);?>
		  <!-- /search com -->
        </div>