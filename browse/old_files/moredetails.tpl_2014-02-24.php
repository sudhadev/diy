<script>
    function togglediv(divid){
        
        if(divid=='spec'){
            document.getElementById('description_text').style.display = 'none';
            document.getElementById('desc').style.background = '#FFCC00';
            document.getElementById('spec').style.background = '#FFFFFF';
            document.getElementById('specification_text').style.display = 'block';
        }
        else{
            document.getElementById('specification_text').style.display = 'none';
            document.getElementById('spec').style.background = '#FFCC00';
            document.getElementById('desc').style.background = '#FFFFFF';
            document.getElementById('description_text').style.display = 'block';
        }
        
    }

</script>


<?php 

require_once("../classes/core/core.class.php");
 	$objCore=new Core;
 	$objCore->auth(1,false);
             
require_once($objCore->_SYS['PATH']['CLASS_WISH_LIST']);
require_once($objCore->_SYS['PATH']['CLASS_LISTING']);
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
require_once($objCore->_SYS['PATH']['CLASS_SPECIFICATION']);

if(!is_object($objListing)) {
	$objListing = new Listing();
}
if(!is_object($objSpec)) {
	$objSpec = new Specification();
}
if(!is_object($objCustomer)) {
	$objCustomer = new Customer();
}

if(!is_object($objWishList))
{
    $objWishList = new WishList($objCore->gConf);
}
        $customerData=$objCustomer->getCustomerData($_REQUEST['cid']);
 	$customerInfo = $customerData[0];
        $lid = $_REQUEST['lid'];
        
        $where = " WHERE `id` = ".$lid."";
        
        $list = $objListing->dList($where);
        
        $arrParentId = explode('_',$list[0][1].'_'.$list[0][2].'_'.$list[0][3].'_'.$list[0][4]);
        
       $speclist = $objSpec->get_dList_edit($arrParentId);
        //print_r($arrParentId);
        
 	require_once($objCore->_SYS['PATH']['CLASS_COUNTRY']); 
	$objCountry=new Country();  	
        

?>
<!--<div style="float: left; margin-left: 14px;">
    <a href='javascript:history.back()'  style="color: #316ac5; font-size: 15px;margin-bottom: 20px;"><< Back to listings</a>
    </div>

<br/><br/>-->
<form id="moredetails_supplies" name="moredetails_supplies" method="POST" action="<?php echo $objCore->_SYS['CONF']['URL_LOGIN_FRONT'];?>">
    
    <table style="float:left;">
        <tr>
            <td style="vertical-align: top;">                
                <div class="add_classified_formmain" style="width:365px;margin-left: 4px;margin-top: -3px;">
			<div class="configure_quot_tabs">
                                <div class="moredetails_tabs_desc  cursorHand" id="tabDescription" onClick="showDescription();"></div>
								<div class="moredetails_tabs_spec spec_inactive cursorHand" id="tabSpecification" onClick="showSpecification();"> </div>
								</div>
                                <div class="more_details_desc_top"></div>
                <div class="more_details_desc_middle" style="display: block;width: 365px;min-height: 180px;" id="divDescription">
                                          <!--  personal data -->
                                                        	 <div id="personal_result"  style="margin-right:10px;">
                                                                   <p style="margin: 2.0px 5.0px 2.0px 2.0px; font: 12.0px 'Arial'">
                <span style="font-family: Arial; text-align: left;float: left;padding: 3px;">
                    <span style="font-size: 16px;font-weight: bold;text-align: justify;"><?php echo strtoupper($list[0][21]); ?></span><br/>
        <?php echo '<br/>'. nl2br(str_replace('-amp;','&',htmlspecialchars_decode($list[0][15]))).'<br/><br/>';
               // echo $list[0][20];?></span>
            </p>
                                                                 </div>
                                                                 
                                                                 </div>
                                
                                
                <div class="more_details_desc_middle" style="display: none;width: 365px;min-height: 180px;" id="divSpecification">
                                          <!--  personal data -->
                                                        	 <div id="personal_result"  style="margin-right:10px;">
                                                                   <p style="margin: 2.0px 5.0px 2.0px 2.0px; font: 12.0px 'Times New Roman'">
                                                                       <span style="font-family: Arial; text-align: left;float: left;padding: 3px;"><span style="font-size: 16px;font-weight: bold;">
<!--SPECIFICATION-->
</span><?php echo '<br/>'. nl2br(str_replace('-amp;','&',htmlspecialchars_decode($list[0][20]))).'<br/><br/>';
               // echo $list[0][20];?></span>
            </p>
                                                                 </div>
                                                                 
                                                                 </div>
                                <div class="more_details_desc_bottom">
                        </div>
                </div>
                
                
                <br/>
            <div style="float: left;margin-left: 4px;margin-top: 10px;margin-bottom: 10px;">
                <?php
                
                if($objCore->sessCusId == "") {
                            $onclck = "moredetails_supplies.submit()";
                        }else {
                            $onclck = "add_more('".$_REQUEST['lid']."');";
                        }
$onclck = "add('1');";

                        ?>
        <img onclick="<?php echo $onclck; ?>" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/add-to-wish-list.png"/>
        <div id="error_msg" style="width:350px; margin-left:0px">
                                                    </div>
        </div>
                
            <br/>
             <div id="product_details" style="float:left;margin-left: 4px;">
            
            <table width="300" class="common_text">
                <?php if($_REQUEST['dis']!=""){?>
                <tr>
                    <td width="110"><strong>Distance</strong>
                        </td>
                        <td width="10">:
                        </td>
                        <td><?php echo $_REQUEST['dis'];?>&nbsp;<?php echo $objCore->gConf['SEARCH_UNIT'];?>
                        </td>
                </tr>
                <?php } ?>
                <tr>
                   <td width="110"><strong>Unit Price</strong>
                        </td>
                        <td width="10">:
                        </td>
                        <td>&pound; <?php echo $list[0][6];?>
                        </td>
                </tr>
                <tr>
                    <td><strong>Bulk Discount</strong>
                        </td>
                        <td width="10">:
                        </td>
                        <td><?php echo $list[0][7];?>+
                        </td>
                </tr>
                <tr>
                    <td><strong>Bulk Price</strong>
                        </td>
                        <td width="10">:
                        </td>
                        <td>&pound; <?php echo $list[0][8];?>
                        </td>
                </tr>
                <tr>
                    <td><strong>Delivery</strong>
                        </td>
                        <td width="10">:
                        </td>
                        <td><?php echo $list[0][17]=="1"?"Yes":"Pickup Only";?>
                        </td>
                </tr>
                <tr>
                    <td><strong>Delivery Cost</strong>
                        </td>
                        <td width="10">:
                        </td>
                        <td><?php echo $list[0][18]=="0"?"Ring for Details":"£".$list[0][18];?>
                        </td>
                </tr>
                <?php if($list[0][16]!=''){ ?>
                <tr>
                    <td><strong>Supplier Code</strong>
                        </td>
                        <td width="10">:
                        </td>
                        <td><?php echo $list[0][16];?>
                        </td>
                </tr>
                <?php } ?>
                </table>
            
            </div>
        </td>
        
            <td style="float: left;padding-right: 12px;vertical-align: top;">
            <iframe src="image-gallery.php?catid=1&lid=<?php echo $list[0][0]; ?>&cid=<?php echo $_REQUEST['cid']; ?>" width='320px' height='400px' frameborder='0' style="margin-top: -7px;" scrolling="no"></iframe>
            </td>
            
            </tr>
            
            <tr>
                <td>
                    
        <?php if($list[0][19]!=''){ ?>                
        <div id="product_url" style="float: left;margin-left: 4px;">
            <a href="<?php echo "http://".str_replace("http://", '', $list[0][19]);?>" target="_blank"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/product-web-link.png" border="0" style="margin-top: 10px;"/></a>
        <br/>
        <br/>
        </div>
                    <?php }
                    else{
                        ?>
                    <div id="product_url" style="float: left;margin-left: 10px;height: 30px;">
                        <br/>
        <br/>
          </div>
                    
                    <?php
                    }
                    ?>
               </td>
               <td>
                   </td>
                   </tr>
                  
                   <tr>
                       <td style="vertical-align: top;padding-top: 10px;">
       
            
      <div class="supplier_data" style="float: left;padding-left: 4px;">    
          <div class="common_text" style="font-size: 16px;margin-left: 2px;"><strong>Supplier</strong></div>
<table class="common_text" width="300">
    <tr><td width="110"><strong>Company </strong></td>
        <td width="10">:
                        </td>
                        <td style="padding-left: 0px;"><?php echo $customerInfo[2]; ?> 
                        </td>
    </tr>
    <tr><td><b>Address </b></td>
        <td width="10;">:
                        </td>
        <td><?php echo $customerInfo[3].",".$customerInfo[4].",".$customerInfo[5]."";?> 
        </td>
    </tr>
    
    <tr><td></td>
        <td width="10">
                        </td>
        <td><?php echo $customerInfo[6].",".$objCountry->arrCountry[$customerInfo[7]];?> 
        </td>
    </tr>
    
    <?php if($customerInfo[8]!=''){?>
    <tr>
        <td><b>Telephone </b></td>
        <td width="10">:
                        </td>
        <td><?php echo $customerInfo[8];?> </td>
    </tr>
    <?php } if($customerInfo[10]!=''){?>
    <tr>
        <td><b>Mobile </b></td>
        <td width="10">:
                        </td>
        <td><?php echo $customerInfo[10];?> </td></tr>
    <tr>
        <?php } if($customerInfo[9]!=''){ ?>
        <td><b>Fax </b></td>
        <td width="10">:
                        </td>
        <td><?php echo $customerInfo[9];?> </td></tr>
    <?php } ?>
    <tr><td><b>Email </b></td>
        <td width="10">:
                        </td>
        <td><a href="mailto:<?php echo $customerInfo[11];?>"><?php echo $customerInfo[11];?></a> </td></tr>
    
    <tr><td style="vertical-align: top;"><b>Opening Times </b></td>
        <td width="10" style="vertical-align: top;">:
                        </td>
        <td>
            <?php
            $mon_det = explode('_', $customerInfo[18]);
            $sat_det = explode('_', $customerInfo[19]);
            $sun_det = explode('_', $customerInfo[20]);
            
            $time_array=$objCustomer->time_array();
            
            ?>
            <table cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td width="30">
            Mon - Fri</td> <td width="10"></td><td>
            <?php //echo $mon_det[0]==0?"Closed":$mon_det[0].":00 - ".$mon_det[1].':00';?>
             <?php echo $mon_det[0]==0?"Closed":$time_array[$mon_det[0]]." - ".$time_array[$mon_det[1]].' ';?>
                        </td></tr>
             <tr>  <td>
                    Saturday</td> <td width="10"></td>
                      <?php
                        if($sat_det[0]==0){
                             echo "<td align='center'>Closed</td>";
                        }
                        else{
                             echo "<td>".$time_array[$sat_det[0]]." - ".$time_array[$sat_det[1]]."</td>";
                        }
                            ?>
             </tr>
             <tr>
                        <td>
                    Sunday</td> <td width="10px"></td>
                        <?php
                        if($sun_det[0]==0){
                            echo "<td align='center'>Closed</td>";
                        }
                        else{
                            echo "<td>".$time_array[$sun_det[0]]." - ".$time_array[$sun_det[1]]."</td>";
                        }
                            ?>
                        </tr>
                </tbody>
            </table>
        </td></tr>
    <?php 
    //echo substr($customerInfo[22],0,1);
    if(substr($customerInfo[22],0,1)=='1'){
        if($customerInfo[21]!=''){ 
            ?>
    <tr><td><a href="<?php echo "http://".str_replace("http://", '', $customerInfo[21]);?>" target="_blank"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/visit-website.png" border="0" style="margin-top: 10px;"/></a>
       </td>
        <td width="10">
                        </td>
        <td></td></tr>
    <?php } }?>
</table>
          
</div>
            </td>
            <td style="text-align: left;">
                <iframe src="map.php?cid=<?php echo $_REQUEST['cid']; ?>" width='320px' height='320px' frameborder='0' scrolling="no"></iframe>
            </td></tr>

               <tr>
                   <td style="text-align:left;">
                   <a href='javascript:history.back()' style="font-size: 12px;margin-bottom: 20px;font-weight: bold;"><div class="supplier_area_summery_text common_text_ash" style="/* for firefox, safari, chrome, etc. */
-webkit-transform: rotate(180deg);
-moz-transform: rotate(180deg);
/* for ie */
filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);padding-top: 1px;width: 1px;margin-left: -10px;margin-right: 5px;">
                       </div></a>
                   <a href='javascript:history.back()' style="font-size: 12px;margin-bottom: 20px;font-weight: bold;">Back to listings</a>
                   </td>
               </tr>
                   </table>

    <!--input type="hidden"  id="subscription" name="subscription" value="<?php //echo $customerData[0][12]; ?>"/-->
    <?php if($_REQUEST['catid']==1){ // edit by maduranga ?>
        <input type="hidden"  id="subscription" name="subscription" value="M"/>
    <?php }else { ?>
        <input type="hidden"  id="subscription" name="subscription" value="<?php echo $customerData[0][12]; ?>"/>
    <?php } ?>
        
    <input type="hidden"  id="listing_id[0]" name="listing_id[0]" value="<?php echo $_REQUEST['lid']; ?>"/>
    <input type="hidden"  id="quantity[0]" name="quantity[0]" value="1"/>
    <input id="checkVal[0]" type="checkbox" value="<?php echo $_REQUEST['lid']; ?>" name="checkVal[0]" style="display: none;" checked="checked" />
    <?php //print_r($customerData); ?>
    </form>

