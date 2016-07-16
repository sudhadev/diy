<?php
	
    
    if(!is_object($objCategory))
    {
        require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
        $objCategory = new Category;
    }
    if(!is_object($objComponent))
    {
        require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
        $objComponent = new Component();
    }
    
    /*
     * Added by Saliya -------------------------->
     */

       // get longitude and latitiude from the sys support data table
          $longAndLat=explode("|DLM|",$objCore->sysVars['Geo']);
      // get address
          $searchCont=explode("|DLM|",$objCore->sysVars['Search']);
          if($searchCont[2]){$_REQUEST['address']=$searchCont[2];}


        if($objCore->sessCusId) // to take necessory information for search component for registerd customers
        {
            if(!is_object($objCustomer))
            {
                require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
                $objCustomer = new Customer;
            }

            // get the Geo information
            $cusDataForGeo=$objCustomer->getCustomerData($objCore->sessCusId);


            if(!$_REQUEST['address'])
            {
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
    
    /*
     *  <-------------------------- Added by Saliya
     */

 
	require_once($objCore->_SYS['PATH']['CLASS_GEO']); //Making a referance to Geo Class 
    
    
    
    
  	$formName = "search"; // Registration Form Name
  	$mapsUrl = $objCore->_SYS['GEO']['URL']; // Google Maps URL  
  	$apiKey = $objCore->_SYS['GEO']['KEY']; // Google Maps API Key for the Server 
  	$objGeo = new Geo(); // Creating an Object from Geo Class 
  	$map = $objGeo->getCoordinates($formName, $submissionType, $ajaxFunction, $apiKey, $mapsUrl);
  	$radiusMax = $objCore->gConf['SEARCH_RADIOUS_MAX'];;
    $radiusDifference = $objCore->gConf['SEARCH_RADIOUS_DIFFERENCE'];
    $unit = $objCore->gConf['SEARCH_UNIT'];
?>

              <div id="middle_end_banner_header"></div>
              <div id="middle_end_banner_content" align="left">
              <form name="<?=$formName; ?>" id="<?=$formName; ?>" action="<?php echo $objCore->_SYS['CONF']['URL_FRONT'];?>/search/index.php" method="get">
			  <!-- search table -->
              <div>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tbody>
					<tr><td class="banner_heading_balck" width="83%">&nbsp;</td>
                    </tr>
                </tbody></table>
				</div>
              <div id="new_search">

			<!--NEW SEARCH TABLE STARTS-->

			  <table width="85%" align="center" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td class="search_tbl_space1">&nbsp;</td>
				  </tr>
				  <tr>
					<td>
                    	<?php
							$categories = $objCategory->getTopcList('drop', 'categories','new_search_textbox width_adjust_drop_down', $_REQUEST['categories']);
							echo $categories;
						?>
                    </td>
				  </tr>
				  <tr>
					<td class="search_tbl_space1">&nbsp;</td>
				  </tr>
				  <tr>
					<td><label>
                          <input name="keyword" class="new_search_textbox width_adjust_text_box" id="keyword" type="text" value="<?php echo $_REQUEST['keyword']; ?>" onkeypress="handleSearchFields('change',this.name);return enter_key_pressed(event,'search');" onfocus="handleSearchFields('none',this.name);" onblur="handleSearchFields('block',this.name);">
                          </label></td>
				  </tr>
				  <tr>
					<td class="search_tbl_space2">&nbsp;</td>
				  </tr>
				  <tr>
					<td><label>
                          <input name="address" id="address" class="new_search_textbox width_adjust_text_box" type="text"  value="<?php echo $_REQUEST['address']; ?>" onkeypress="handleSearchFields('change',this.name);return enter_key_pressed(event,'search');" onfocus="handleSearchFields('none',this.name);" onblur="handleSearchFields('block',this.name);"><input type="hidden" id="hidAddress" value="<?php echo $_REQUEST['address']; ?>"/>
                          </label></td>
				  </tr>
				  <tr>
					<td class="search_tbl_space1">&nbsp;</td>
				  </tr>
				  <tr>
					<td>
					<label>
					<?php
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
                        echo $objComponent->drop('radius', $_REQUEST['radius'],$radiusArray, 'new_search_textbox width_adjust_radious', '',$initOpt);
                        ?></label></td>
				  </tr>
				  <tr><td class="search_tbl_space3">&nbsp;

                    <!-- Hidden fields for Search-->
                    <?php 


                    ?>
                                <input type="hidden" id="confirmedLatitude" name="confirmedLatitude" value="<?php echo $longAndLat[0];?>">               
                                <input type="hidden" id="confirmedLongitude" name="confirmedLongitude" value="<?php echo $longAndLat[1];?>">
                                <input type="hidden" id="order_by" name="order_by" value="0">
                                <input type="hidden" id="categoryId" name="categoryId" value="0">
                                <input type="hidden" id="specificationId" name="specificationId" value="0">
                                <input type="hidden" id="manufacturerId" name="manufacturerId" value="0">    
                                <input type="hidden" id="pg" name="pg" value="1">  
     
                  </td></tr>
				  <tr><td><div align="left"><img class="cursorHand" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/go-button-small.jpg" width="170" height="48" border="0" onClick="if(validToSearch()){initialize(); showAddress(document.<?=$formName; ?>.address.value); showMap(); return false;}"/></div></td></tr>
				  </table>
				 <!--NEW SEARCH TABLE ENDS-->

				</div>
				<!-- / search table -->
			  <!-- search table -->
				 <div id="map"> <?php echo $map; ?> </div>
				 </form>
                  </div> 
              <div id="middle_end_banner_bottom"></div>
