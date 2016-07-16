<!--start fb shair script-->
<!--end fb share script -->
<?php 

require_once("../classes/core/core.class.php");
 	$objCore=new Core;
 	//$objCore->auth(1,false);

require_once($objCore->_SYS['PATH']['CLASS_SERVICE']);
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
require_once($objCore->_SYS['PATH']['CLASS_SEARCH']);

 if (!is_object($objService))
    {
        $objService = new Service;
    }

if(!is_object($objCustomer)) {
	$objCustomer = new Customer();
}
if(!is_object($objSearch)) {
	$objSearch = new Search($objCore->gConf);
}

        $customerData=$objCustomer->getCustomerData($_REQUEST['cid']);
 	$customerInfo = $customerData[0];
        $lid = $_REQUEST['lid'];
        //echo $lid;
        $where = " WHERE `id` = $lid";
        
        $list = $objService->dList($where);
        
?>

  <table style="float:left;" width="95%">
        <tr>
            <td width="300px" style="vertical-align: top;">
<!--        <div id="toggle_buttons" style="float:left; margin-left: 6px;height: 25px;">
        <a style="text-decoration: none;" href="javascript:togglediv('desc');"><div id="desc" style="display:inline;border: 1px solid #FFCC00;margin-right: 10px;padding:5px;">
           <span style="margin:10px;"> <strong>Services Offered</strong> </span>
            </div></a>

            </div>
           <br/>
        <div id="text_area_desc" style="margin-left: 6px;float:left;">
            <div id="description_text" style="border: 1px solid #FFCC00;min-height: 200px;float: left;width: 300px;">
            <p style="margin: 5.0px 5.0px 5.0px 5.0px; font: 12.0px 'Arial';float: left;text-align: left;">
                
                    <?php echo $list[0][5]; ?><br/>
     
            </p>
            
            </div>
            </div>-->
                    
                     <div class="add_classified_formmain" style="width:365px;margin-left: 4px;margin-top: -4px;">
			<div class="configure_quot_tabs">
                                <div class="moredetails_tabs_serv  cursorHand" id="tabDescription"> </div>
					</div>
                                <div class="more_details_desc_top"> </div>
                <div class="more_details_desc_middle" style="display: block;width: 365px;min-height: 190px;" id="divDescription">
                                          <!--  personal data -->
                                                        	 <div id="personal_result"  style="margin-right:10px;">
                                                                   <p style="margin: 2.0px 5.0px 2.0px 2.0px; font: 12.0px 'Arial'">
                <span style="font-family: Arial; text-align: left;float: left;padding: 3px;">
                    <?php echo nl2br($list[0][5]); ?></span>
            </p>
                                                                 </div>
                                                                 
                                                                 </div>
                                
             
                                <div class="more_details_desc_bottom">
                        </div>
                </div><!-- fb and twitter share start --><?php 
$currentUrl="http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
?>
<div class="fb-share-button" data-href="<?php $currentUrl;?>" data-layout="button_count" style="margin-left: 6px;"></div>
<a href="https://twitter.com/share" class="twitter-share-button" data-text="DIY:" data-count="horizontal">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],
p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){
js=d.createElement(s);js.id=id;
js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}
(document, 'script', 'twitter-wjs');</script><!-- fb and twitter share end -->
                    
                    
                    
        </td>
        <td style="float: right;">
       
            <iframe src="image-gallery.php?catid=2&lid=<?php echo $lid; ?>" width='330px' height='400px' frameborder='0' style="margin-top: -7px;" scrolling="no" id="fbtake"></iframe>
            </td>
            </tr>

                   <tr>
                       <td style="vertical-align: top;padding-top: 10px;">
       
            
      <div class="supplier_data" style="float: left;">    
          <div class="common_text" style="font-size: 16px;margin-left: 6px;"><strong>Company Details </strong></div>
<table class="common_text">
    <tr><td style="padding-left: 6px; width: 98px;"><b>Company </b></td>
        <td width="10px;">:
                        </td>
                        <td style="padding-left: 0px"><?php echo strtoupper($customerInfo[2]); ?> 
                        </td>
    </tr>
    <tr><td style="padding-left: 6px"><b>Address </b></td>
        <td width="10px;">:
                        </td>
        <td><?php echo $customerInfo[3].",".$customerInfo[4].",".$customerInfo[5]."";?> 
        </td>
    </tr>
    
    <tr><td style="padding-left: 6px"></td>
        <td width="10px;">
                        </td>
        <td><?php echo $customerInfo[6].",".$objCountry->arrCountry[$customerInfo[7]];?> 
        </td>
    </tr>
    
    <?php if($customerInfo[8]!=''){?>
    <tr>
        <td style="padding-left: 6px"><b>Telephone </b></td>
        <td width="10px;">:
                        </td>
        <td><?php echo $customerInfo[8];?> </td>
    </tr>
    <?php } if($customerInfo[10]!=''){?>
    <tr>
        <td style="padding-left: 6px"><b>Mobile </b></td>
        <td width="10px;">:
                        </td>
        <td><?php echo $customerInfo[10];?> </td></tr>
    <tr>
        <?php } if($customerInfo[9]!=''){ ?>
        <td style="padding-left: 6px"><b>Fax </b></td>
        <td width="10px;">:
                        </td>
        <td><?php echo $customerInfo[9];?> </td></tr>
    <?php } ?>
    <tr><td style="padding-left: 6px"><b>Email </b></td>
        <td width="10px;">:
                        </td>
        <td><a href="mailto:<?php echo $customerInfo[11];?>"><?php echo $customerInfo[11];?></a> </td></tr>
    <tr><td style="padding-left: 6px"><b>Website </b></td>
        <td width="10px;">:
                        </td>
        <td> 
            
            <?php if($customerInfo[21]){ /* change by maduranga - for display website */?>
                <a href="<?php echo "http://".str_replace("http://", '', $customerInfo[21]);?>" target="_blank">
                    <?php echo "http://".str_replace("http://", '', $customerInfo[21]);?>
                </a>
            <?php } ?>
        </td>
    </tr>
    
    			<?php 
            		if($_REQUEST['latitude'] && $_REQUEST['longitude']){
	
	            		$distance_claculate = $objSearch->getDistance_ni_moreInfo( $_REQUEST['cid'], $_REQUEST['latitude'], $_REQUEST['longitude']);
	            		$distance_claculate = round($distance_claculate, 2);
					}
            	?>
    
    <tr><td style="padding-left: 6px"><b>Distance </b></td>
        <td width="10px;">:
                        </td>
                        <td>
                        	<?php if($distance_claculate){ echo $distance_claculate; }else{ echo $_REQUEST['dis']; } ?>&nbsp; <?php echo $_REQUEST['unit']; ?></td>
       </tr>
	       
    <?php 
    if(substr($customerInfo[22],0,1)=='1'){
    if($customerInfo[21]!=''){ ?>
    <tr><td><a href="<?php echo "http://".str_replace("http://", '', $customerInfo[21]);?>" target="_blank"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/visit-website.png" border="0" style="margin-top: 10px;" target="_blank"/></a>
       </td>
        <td width="10px;">
                        </td>
        <td></td></tr>
    <?php }} ?>
    
</table>
          
</div>
            </td>
            <td>
                <iframe src="map.php?cid=<?php echo $_REQUEST['cid']; ?>" width='330px' height='350px' frameborder='0' style="float:right;text-align: left;" scrolling="no"></iframe>
                
            </td></tr>
               <tr>
                   <td style="text-align: left;">
                   <a href='javascript:history.back()' style="font-size: 12px;margin-bottom: 20px;font-weight: bold;"><div class="supplier_area_summery_text common_text_ash" style="/* for firefox, safari, chrome, etc. */
-webkit-transform: rotate(180deg);
-moz-transform: rotate(180deg);
/* for ie */
filter: progid:DXImageTransform.Microsoft.BasicImage(rotation=2);padding-top: 1px;width: 0px;margin-left: -10px;margin-right: 5px;">
                       </div>
                   Back to listings</a>
                   </td>
               </tr>
                   </table>


