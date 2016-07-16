<?php

  /*--------------------------------------------------------------------------\
  '    This file is part of shoping Cart in module library of FUSIS           '
  '    (C) Copyright 2004 www.fusis.com                                       '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris<j.heshan@gmail.com>         			'
  '    FILE            :  /bin/tpl/home.tpl.php                         		'
  '    PURPOSE         :  display home template                         		'
  '    PRE CONDITION   :  commented                                           '
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

    /*
     * Added by Saliya -------------------------->
     */

       // get longitude and latitiude from the sys support data table
          $longAndLat=explode("|DLM|",$objCore->sysVars['Geo']);



		//	$longAndLat2=explode("||",$longAndLat[0]);
			
		//	print_r($longAndLat);
			
		/*	
		if($longAndLat2){
			$longAndLat[0]=$longAndLat2[0];
			$longAndLat[1]=$longAndLat2[1];
			
		}*/
		
       // get address 
          $searchCont=explode("|DLM|",$objCore->sysVars['Search']);
          if($searchCont[2]){$_REQUEST['address']=$searchCont[2];}
       

        if($objCore->sessCusId && $objCore->sessCusId!="") // to take necessory information for search component for registerd customers
        {
            if(!is_object($objCustomer))
            {
                require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
                $objCustomer = new Customer;
            }

            // get the Geo information
            $cusDataForGeo=$objCustomer->getCustomerData($objCore->sessCusId);

            if(!$_REQUEST['address'] || $longAndLat[2]=='1')
            {
            	if($longAndLat[2]=='1'){
            		$_REQUEST['address']='';
            	}
                if($cusDataForGeo[0][3]) $_REQUEST['address'].=$cusDataForGeo[0][3]." ";
                if($cusDataForGeo[0][4]) $_REQUEST['address'].=$cusDataForGeo[0][4]." ";
                if($cusDataForGeo[0][5]) $_REQUEST['address'].=$cusDataForGeo[0][5]." ";
                if($cusDataForGeo[0][6]) $_REQUEST['address'].=$cusDataForGeo[0][6]." ";
                if($cusDataForGeo[0][7]) $_REQUEST['address'].=$cusDataForGeo[0][7]." ";
                $longAndLat[0]=$cusDataForGeo[0][15];
                $longAndLat[1]=$cusDataForGeo[0][16];
            }
            
            
           
           
           //confirmedLatitude confirmedLongitude


        }
//        else{
//            $_REQUEST['address'] = "";
//            $longAndLat[0]="";
//            $longAndLat[1]="";
//        }

    /*
     *  <-------------------------- Added by Saliya
     */
	
        
?>

               <!-- <div id="middle_center_bar" style="padding-left:17px">-->
                 <div id="middle_center_bar">   
                    <div id="middle_center_bar_middle">
                        <div id="form_outer_text"></div>
                        <div id="form_outer_text1">
                        </div>
                        <div id="home_form_outer">
                            <form name="<?=$formName; ?>" id="<?=$formName; ?>" action="<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>/search/index.php" method="get" >
                                <div id="catagory_type_outer">
                                    <div id="catagory_type_middle1"></div>
                                    <div id="catagory_type_middle2">
                                        <label></label>
                                        <label>
                                            <div align="left">
                                                <?php
                                                $categories = $objCategory->getTopcList('drop', 'categories',' categoryDrop',$_REQUEST['categories']);
                                                echo $categories;
                                                ?>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div id="key_words_outer">
                                    <div id="catagory_type_middle1"></div>
                                    <div id="catagory_type_middle2">
                                        <label>
                                            <div align="left">
                                                <input name="keyword" type="text" id="keyword" value="Plaster or Plasterers" class="homePageSearchBoxes" onkeypress="handleSearchFields('change',this.name);return enter_key_pressed(event,'search');" onfocus="handleSearchFields('none',this.name);" onblur="handleSearchFields('block',this.name);" />
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div  id="enter_place_outer">
                                    <div id="catagory_type_middle1"></div>
                                    <div id="catagory_type_middle2">
                                        <label>
                                            <div align="left">
                                               
                                                <input name="address" type="text" id="address" 
                                                     value="<?php 
//                                                                if($objCore->sessCusId==""){
                                                                   if(!$_REQUEST['address'])
                                                                        echo "London Regents St or W1B 1JA";
                                                                   else
                                                                        echo ucwords($_REQUEST['address']);
                                                                
//                                                                else{
//                                                                    if(!$_REQUEST['address'])
//                                                                        echo "London Regents St or W1B 1JA";
//                                                                    else
//                                                                        echo ucwords($_REQUEST['address']);
//                                                                } 
                                                            ?>"  
                                                      class="homePageSearchBoxes" 
                                                      onkeypress="handleSearchFields('change',this.name);return enter_key_pressed(event,'search');" 
                                                      onfocus="handleSearchFields('none',this.name);" onblur="handleSearchFields('block',this.name);"  
                                                      style="<?php if($_REQUEST['address']!=""){echo "color:#333";} ?>" />
                                                <input type="hidden" id="hidAddress" value="<?php echo $_REQUEST['address']; ?>"/>                                          
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <div id="search_radios_outer">
                                    <div id="catagory_type_middle1"></div>
                                    <div id="catagory_type_middle2">
                                        <label>
                                            <div align="left">
                                                <?php
                                                    $radiusMax = $objCore->gConf['SEARCH_RADIOUS_MAX'];;
                                                    $radiusDifference = $objCore->gConf['SEARCH_RADIOUS_DIFFERENCE'];
                                                    $unit = $objCore->gConf['SEARCH_UNIT'];
                                                    for($i=0;$i<=$radiusMax;$i=$i+$radiusDifference)
                                                    {   
                                                        if ($i==0)
                                                        {
                                                            //$radiusArray[$i] = '--';
                                                        }
                                                        else
                                                        {
                                                            $radiusArray[$i] = $i." ".$unit;
                                                        }
                                                    }
                                                    $initOpt='<option value="600">National</option>';
                                                    echo $objComponent->drop('radius', '',$radiusArray, 'style="width: 260px"', '',$initOpt);
                                                ?>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                                <!-- Hidden field for Latitude -->
                                <input type="hidden" id="confirmedLatitude" name="confirmedLatitude" value="<?php echo $longAndLat[0];?>"/>
                                <!-- Hidden field for Longitude -->
                                <input type="hidden" id="confirmedLongitude" name="confirmedLongitude" value="<?php echo $longAndLat[1];?>"/>
                                <input type="hidden" id="order_by" name="order_by" value="0"/>
                                <input type="hidden" id="categoryId" name="categoryId" value="0"/>
                                <input type="hidden" id="specificationId" name="specificationId" value="0"/>
                                <input type="hidden" id="manufacturerId" name="manufacturerId" value="0"/>    
                                <input type="hidden" id="pg" name="pg" value="1"/>    
                                <div id="go_button_outer">
                                    <div id="go_button">
                                        <div align="left">
                                            <img class="cursorHand" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/go-button.jpg" border="0" onClick="if(validToSearch()){initialize(); showAddress(document.<?=$formName; ?>.address.value); showMap(); return false;}">
                                        </div>
                                    </div>
                                </div>
                                <div id="map"> 
                                    <?php echo $map; ?> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
               <!-- <div id="middle_end_bar" style="padding-left:18px">-->
                  <div id="middle_end_bar">
                    <div id="middle_end_bar_middle">
                        <div id="middle_end_banner1">
                            
                        </div>
                        <div id="middle_end_banner2">
                            <a href="<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?><?php echo $objCore->sessCusId!=""? "my_account/":"login/";?>" >
                                <img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/sign-up-ad.gif" border="0" /> 
                            </a>
                        </div>
                    </div>
                </div>
 