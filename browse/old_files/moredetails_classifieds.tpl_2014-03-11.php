<?php 

require_once("../classes/core/core.class.php");
 	$objCore=new Core;
 	//$objCore->auth(1,false);
             
require_once($objCore->_SYS['PATH']['CLASS_WISH_LIST']);
require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);

require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
require_once($objCore->_SYS['PATH']['CLASS_SEARCH']);

        if (!is_object($objCategory))
        {
            $objCategory = new Category();
        }
        $objComponent = new Component();
        require_once($objCore->_SYS['PATH']['CLASS_SEARCH']);
	if (!is_object($objClassified))
        {
            $objClassified = new ClassifiedAd($objCore->gConf);
        }

if(!is_object($objCustomer)) {
	$objCustomer = new Customer();
}

if(!is_object($objSearch)) {
	$objSearch = new Search($objCore->gConf);
}

if(!is_object($objWishList))
{
    $objWishList = new WishList($objCore->gConf);
}
        $customerData=$objCustomer->getCustomerData($_REQUEST['cid']);
 	$customerInfo = $customerData[0];
        $lid = $_REQUEST['lid'];
        
        $where = " WHERE `id` = ".$lid."";
        
        $list = $objClassified->dList($where);
        
 	require_once($objCore->_SYS['PATH']['CLASS_COUNTRY']); 
	$objCountry=new Country();  	
        

?>
    <table style="float:left;" width="100%">
        <tr>
            <td style="vertical-align: top;">
<!--                <table style="margin-left: -10px;">
                    <tr><td colspan="2">
        <span style="margin-left: 14px; font-family: arial; font-size: 18px; font-weight: bold;float: left;margin-top: -10px;"><?php echo $list[0][5]; ?></span></td></tr>
        <tr><td width="300px"><span style="margin-left: 14px; font-family: arial; font-size: 18px; font-weight: bold;float: left;">£ &nbsp; <?php echo $list[0][8]; ?></span></td>
        <td width="100px"><a href=""><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/add-to-wish-list.png" border="0"/></a></td></tr>
       <tr>
                <td style="vertical-align: top; padding: 17px 15px 5px;">
                    <span class="common_text" style="float: left;">
                        <?php echo $list[0][7]; ?>
                        </span>
                    
        </td>
        
        </table>-->
                
                <div class="add_classified_formmain" style="width:365px;margin-left: 4px;margin-top: -4px;">
			<div class="configure_quot_tabs">
                                <div class="moredetails_tabs_desc" id="tabDescription"> </div>
									</div>
                                <div class="more_details_desc_top"> </div>
                <div class="more_details_desc_middle" style="display: block;width: 365px;min-height: 190px;" id="divDescription">
                                          <!--  personal data -->
                                                        	 <div id="personal_result"  style="margin-right:10px;">
                                                                   <p style="margin: 2.0px 5.0px 2.0px 2.0px; font: 12.0px 'Arial'">
                <span style="margin-left: 10px;font-family: arial; font-size: 18px; font-weight: bold;float: left;">
                    <?php echo $list[0][5]; ?></span><br/><br/>
                    <span style="margin-left: 10px;font-family: arial; font-size: 16px; font-weight: bold;float: left;">£&nbsp;<?php echo $list[0][8]; ?></span><br/><br/>   
                
                    <span class="common_text" style="float: left;margin-left: 10px;">
                        <?php echo $list[0][7]; ?>
                        </span>
                
            </p>
                                                                 </div>
                                                                 
                                                                 </div>
                                
             
                                <div class="more_details_desc_bottom">
                        </div>
                </div>
                
                </td>
        <td style="vertical-align: top;float: left;">
       
            <iframe src="image-gallery.php?catid=3&lid=<?php echo $list[0][0]; ?>&cid=<?php echo $_REQUEST['cid']; ?>" width='330px' height='400px' frameborder='0' scrolling="no"></iframe>
            </td>
            </tr>
            
                   <tr>
                      <td style="vertical-align: top;">
       
            
      <div class="supplier_data" style="float: left; margin-top: 8px;">    
          <div class="common_text" style="font-size: 16px;margin-left: 6px;"><strong>Contact Seller</strong></div>
<table class="common_text">
    <tr><td style="padding-left: 4px; width: 98px;"><b>Seller </b></td>
        <td width="4px;">:
                        </td>
                        <td style="padding-left: 0px"><?php echo $customerInfo[2]; ?> 
                        </td>
    </tr>
    <?php if($customerInfo[10]!=''){?>
    <tr>
        <td style="padding-left: 4px"><b>Mobile </b></td>
        <td width="10px;">:
                        </td>
        <td><?php echo $customerInfo[10];?> </td></tr>
   
    <?php } ?>
    <tr><td style="padding-left: 4px"><b>Email </b></td>
        <td width="10px;">:
                        </td>
        <td><a href="mailto:<?php echo $customerInfo[11];?>"><?php echo $customerInfo[11];?></a> </td></tr>
    
    <?php 
    if(substr($customerInfo[22],2)=='1'){
    if($customerInfo[21]!=''){ ?>
    <tr><td><a href="<?php echo "http://".str_replace("http://", '', $customerInfo[21]);?>" target="_blank"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/visit-website.png" border="0" style="margin-top: 10px;" target="_blank"/></a>
       </td>
        <td width="10px;">
                        </td>
        <td></td></tr>
    <?php } } ?>
    
</table>
          
</div>
            </td>
            <td>
               
            <iframe src="map.php?cid=<?php echo $_REQUEST['cid']; ?>" width='330px' height='320px' frameborder='0' style="float:right;text-align: left;" scrolling="no"></iframe>
            
        
                
                
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


