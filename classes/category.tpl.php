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
                 
              	 print_r($list);
              	 exit;
                 
              	 $pointer = 1;
             	 for($l=0;$l<count($list);$l++){
             	 	//get sub category list
             	 	$listSub=$objCategory->getSubcList($list[$l][0],'sub_arr');
             	 	
             	 	if(count($listSub))
             	 	{// if there isnt any sub category no point of showing the top level
                            if($pointer%2==1){
                