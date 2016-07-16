<?php
?>
 <td width="240" height="30"  class="catagories_item_ddwhite" ><form action="<?php if ($objCore->curSection() == 'search') echo $objCore->_SYS['CONF']['URL_FRONT'].'/search/'; else echo $objCore->_SYS['CONF']['URL_FRONT'].'/browse/';?>"> Show <?php
            echo $objComponent->drop('resultsPerPage', $_REQUEST['resultsPerPage'], array(
				$objCore->gConf['SEARCH_RECS_IN_LIST']=>$objCore->gConf['SEARCH_RECS_IN_LIST']." Items",
                "5"=>"5 Items",
				"10"=>"10 Items",
				"15"=>"15 Items",
				"20"=>"20 Items",
			), 'pagination_drop', 'onchange=form.submit()');
                                    //echo $strSearch.'-------------------------------';
                                    //print_r($strSearch).'+++++++++++++++++++++++++++';
					if ($objCore->curSection() == 'search')
							{
						if ($_REQUEST['categories']== '1') 
                                                    if($strSearch)
                                                     if(!is_array($strSearch))   
                                                        $strSearch_arr = explode("|DLM|", $strSearch);
                                                     else
                                                         $strSearch_arr = $strSearch;
							?> &nbsp;Per Page
								<input type="hidden" id="categories" name="categories" value="<?php echo $strSearch_arr[0];?>">
								<input type="hidden" id="keyword" name="keyword" value="<?php echo $strSearch_arr[1];?>">
								<input type="hidden" id="address" name="address" value="<?php echo $strSearch_arr[2];?>">
								<input type="hidden" id="radius" name="radius" value="<?php echo $strSearch_arr[3];?>">
								<input type="hidden" id="order_by" name="order_by" value="<?php echo $strSearch_arr[4];?>">
								<input type="hidden" id="categoryId" name="categoryId" value="<?php echo $strSearch_arr[5];?>">
								<input type="hidden" id="specificationId" name="specificationId" value="<?php echo $strSearch_arr[6];?>">
								<input type="hidden" id="manufacturerId" name="manufacturerId" value="<?php echo $strSearch_arr[7];?>">
								<input type="hidden" id="latitude" name="latitude" value="<?php echo $strSearch_arr[8];?>">
								<input type="hidden" id="longitude" name="longitude" value="<?php echo $strSearch_arr[9];?>">
								<input type="hidden" id="pg" name="pg" value="<?php echo $strSearch_arr[10];?>">
                                                                
								<?php }
								elseif ($objCore->curSection() == 'browse')
								{
                                                                    // print_r($strBrowse);
								if ($_REQUEST['categories']== '1') 
                                                                    if($strBrowse)
                                                                    $strBrowse_arr = explode("|DLM|", $strBrowse);
                                                                   // print_r($strBrowse);
								?> &nbsp;Per Page
                                                                
								<input type="hidden" id="f" name="f" value="<?php echo $strBrowse_arr[0];?>">
								<input type="hidden" id="tcid" name="tcid" value="<?php echo $strBrowse_arr[1];?>">
                                <input type="hidden" id="pcid" name="pcid" value="<?php echo $strBrowse_arr[8];?>">
								<input type="hidden" id="categoryId" name="categoryId" value="<?php echo $strBrowse_arr[2];?>">
								<input type="hidden" id="specificationId" name="specificationId" value="<?php echo $strBrowse_arr[3];?>">
								<input type="hidden" id="manufacturerId" name="manufacturerId" value="<?php echo $strBrowse_arr[4];?>">
								<input type="hidden" id="order_by" name="order_by" value="<?php echo $strBrowse_arr[5];?>">
								<input type="hidden" id="pg" name="pg" value="<?php echo $strBrowse_arr[6];?>">
								<input type="hidden" id="categories" name="categories" value="<?php echo $strBrowse_arr[7];?>">
                                                                
                                                               
								<?php }?>
							</form></td>