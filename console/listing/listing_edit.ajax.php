<?php

	require_once("../../classes/core/core.class.php");
	$objCore = new Core;
    $objCore->auth(0,true);
	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
    require_once($objCore->_SYS['PATH']['CLASS_SERVICE']);
    require_once($objCore->_SYS['PATH']['CLASS_CLASSIFIED_ADS']);
    require_once($objCore->_SYS['PATH']['CLASS_COMPONENT']);
    require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
    require_once($objCore->_SYS['PATH']['CLASS_LISTING']);

    $objComponent = new Component();
	$objCustomer = new Customer($objCore->gConf);
    $objCategory = new Category();
    $objService = new Service();

	if ($_SERVER["REQUEST_METHOD"] <> "POST")
	{
 		die("Access Denied");
 	}
    $str = explode('_', $_REQUEST['ids']);//$objCustomer->dev=true; echo __FILE__.__LINE__."<br/>";
    $output = $objCustomer->getListings($_REQUEST['cusId'], $str[0], $str[1], $str[2], $str[3]); //print_r($output);
    $topList=$objCategory->getTopcList();
     
    if ($str[0])
    {
        $list=$objCategory->getSubcList($topList[$str[0]]['id'],'sub_arr');
        for ($m=0; $m<count($list); $m++)
        {
            if ($list[$m][0]==$str[1]) $temp = $m;
        }
    }
    if ($str[2])
    {
        $listSub=$objCategory->getSubcList($list[$temp][0],'sub_arr');
        for ($n=0; $n<count($listSub); $n++)
        {
            if ($listSub[$n][0]==$str[2]) $tempSub = $n;
        }
    }
    
    
    if ($str[0] == 1)
    {
         if(!is_object($objListing)) $objListing= new Listing();

?>

<div id="toolbar-box">
<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
</div>
			<div class="m">
	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset id="page-middle-middle-content">
	  <legend>Edit Listing (<?php echo $topList[$str[0]]['category']?> > <?php echo $list[$temp][3];?> > <?php echo $listSub[$tempSub][3];?>)</legend>
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
    <td width="470"><table width="470" class="admintable">
	    <tbody><tr>
	      <td align="right" class="key">Specification<span class="required_fields"/></td>
	      <td><?php echo $output[0][0]; ?></td>
        </tr>
	    <tr>
          <td align="right" class="key">Manufacturer</td>
	      <td><?php echo $output[0][1]; ?></td>
        </tr>
	    <tr>
          <td align="right" class="key">Unit Cost (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)<span class="required_fields"/></td>
	      <td><?php echo $output[0][2]; ?></td>
        </tr>
        <tr>
          <td align="right" class="key">Bulk Discount (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)<span class="required_fields"/></td>
	      <td><?php echo $output[0][3]; ?></td>
        </tr>
        <tr>
          <td align="right" class="key">Bulk Price (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)<span class="required_fields"/></td>
	      <td><?php echo $output[0][4]; ?></td>
        </tr>
        <tr>
          <td align="right" class="key">Delivery (<?php echo $objCore->_SYS['CONF']['CURRENCY'];?>)<span class="required_fields"/></td>
	      <td><?php echo $output[0][5]; ?></td>
        </tr>
        <tr>
          <td class="key" align="right">Image<span class="required_fields"></span></td>
	      <td>
             <?php  $imgUrl = $objListing->image($output[0][15],$objCore->_SYS['CONF']['FTP_LISTINGS'],$objCore->_SYS['CONF']['URL_IMAGES_LISTINGS'],$output[0][10]);
                                              ?>
                    <img src="<?php echo $imgUrl;?>"   width="50" border="0" style="padding-right:8px;" />
          <br/>
          <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $output[0][15]."_spl_".$output[0][10]; ?>','listing');"><img src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/zoom.png"/></a>
          <br/>
          </td>
        </tr>
        <tr>
          <td align="right" class="key">Description</td>
	      <td><?php echo $output[0][16]; ?></td>
        </tr>
        <tr>
          <td align="right" class="key">Keywords<span class="required_fields"/></td>
	      <td><?php echo str_replace("\n","<br/>", $output[0][9]); ?></td>
        </tr>
        
	    </tbody><tbody>
		<tr>
	      <td width="131" align="right"> </td>
	      <td width="327"><label>
	        <input type="button" value="Back" name="Back" onClick="getListings('<?php echo $_REQUEST['cusId'];?>' , '<?php echo $str[0]."_".$str[1]."_".$str[2];?>');"/>
	      </label></td>
	    </tr>
	  </tbody></table>
	  		</td>
			<td valign="top" align="right">
			<table width="190" cellspacing="5" cellpadding="2" border="0" style="border: 1px dashed rgb(204, 204, 204);">
				<tbody><tr><td class="right_table_top"><img width="14" height="14" style="vertical-align: bottom;" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/more_info.png"/> This listing is <span id="spanStatus"><?php if ($output[0][7] == Y) { ?> Active <?php } else { ?> Inactive <?php } ?></span></td></tr>
				<tr>
				<td>You can Activate or Deactivate any listing as the administrator.<br/>

				</td>
				</tr>

               
				<tr id="reason"  style="display:<?php if ($output[0][7] == Y) {echo "block";}else{echo "none";}?>;" >
				<td class="right_table_padding"><span>Reason for Deactivation</span><textarea id="reason_text" style=""></textarea></td>
				</tr>
				<tr id="reasonD"  style="display:<?php if ($output[0][7] == Y) {echo "none";}else{echo "block";}?>;<?php if ($output[0][7] == 'M') {?>background-color:#ffffee;<?php }?>" >
				<td class="right_table_padding"><?php if ($output[0][7] == 'M') {?><span><u>Reason for Deactivation</u></span><br/><?php echo $output[0][14];?><?php }?></td>
				</tr>
				<tr>
                <td class="right_table_padding" style="text-align:center">
                <input type="hidden" id="faAjax" value="y"/>
                <input type="hidden" id="faPage" value="listing"/>
                <input type="hidden" id="faId" value="<?php echo $str[0]."_".$output[0][6]; ?>"/>

                <input type="button"  id="faButton" name="submit" value="<?php if ($output[0][7] == Y) { echo " Deactivate ";}else{echo "     Activate     ";} ?>" <?php if ($output[0][7] =='Y') {?> onclick="javascript:deactivate();" <?php } else {?> onclick="javascript:activate();<?php }?>" />
              </td>
                </tr>
			</tbody></table>
			
			</td>
			
		</tr>
	</tbody></table>
	  </fieldset>
	</form>
<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
            </div>

<?php
    }
    else if ($str[0] == 2)
    {
    	
?>

<div id="toolbar-box">
<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
</div>
			<div class="m">
	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset id="page-middle-middle-content">
	  <legend>Edit Listing (<?php echo $topList[$str[0]]['category']?> > <?php echo $list[$temp][3];?> > <?php echo $listSub[$tempSub][3];?>)</legend>
      <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
    <td width="470">
      <table class="admintable" width="470">
	    <tr>
	      <td class="key" align="right">Business Name<span class="required_fields"></span></td>
	      <td><?php echo $output[0][0]; ?></td>
        </tr>
	    <tr>
          <td class="key" align="right">Affiliations</td>
	      <td><?php echo $output[0][1]; ?></td>
        </tr>
	    <tr>
          <td class="key" align="right">Price<span class="required_fields"></span></td>
	      <td><?php echo $output[0][2]; ?></td>
        </tr>
        <tr>
          <td class="key" align="right">Call Out Charge<span class="required_fields"></span></td>
	      <td><?php echo $output[0][3]; ?></td>
        </tr>
        <tr>
          <td class="key" align="right">Image<span class="required_fields"></span></td>
	      <td>
          <img width="50" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_SERVICES'];?>/thumbs/<?php echo $output[0][4]; ?>"/>
          <br/>
          <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $output[0][4]; ?>','services');"><img src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/zoom.png"/></a>
          <br/>
          </td>
        </tr>
        <tr>
          <td class="key" align="right">Contact Person<span class="required_fields"></span></td>
	      <td><?php echo $output[0][5]; ?></td>
        </tr>
        <tr>
          <td class="key" align="right">Accreditation<span class="required_fields"></span></td>
          <td><?php $acc = explode('||', $output[0][6]); for ($i=0; $i<count($acc); $i++){echo $acc[$i]."<br />";} ?></td>
        </tr>
        <tr>
          <td class="key" align="right">Website<span class="required_fields"></span></td>
	      <td><?php echo $output[0][7]; ?></td>
        </tr>
        <tr>
          <td class="key" align="right">Keywords<span class="required_fields"></span></td>
	      <td><?php echo $output[0][10]; ?></td>
        </tr>
        <tbody>
		<tr>
	      <td width="131" align="right"> </td>
	      <td width="327"><label>
	        <input type="button" value="Back" name="Back" onClick="getListings('<?php echo $_REQUEST['cusId'];?>' , '<?php echo $str[0]."_".$str[1]."_".$str[2];?>');"/>
	      </label></td>
	    </tr>
        </tbody>
	    </table>
        </td>
			<td valign="top" align="right">
            <table width="190" cellspacing="5" cellpadding="2" border="0" style="border: 1px dashed rgb(204, 204, 204);">
				<tbody><tr><td class="right_table_top"><img width="14" height="14" style="vertical-align: bottom;" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/more_info.png"/> This listing is <span id="spanStatus"><?php if ($output[0][9] == Y) { ?> Active <?php } else { ?> Inactive <?php } ?></span></td></tr>
				<tr>
				<td>You can Activate or Deactivate any listing as the administrator.<br/>

				</td>
				</tr>


				<tr id="reason"  style="display:<?php if ($output[0][9] == Y) {echo "block";}else{echo "none";}?>;" >
				<td class="right_table_padding"><span>Reason for Deactivation</span><textarea id="reason_text" style=""></textarea></td>
				</tr>
				<tr id="reasonD"  style="display:<?php if ($output[0][9] == Y) {echo "none";}else{echo "block";}?>;<?php if ($output[0][9] == 'M'){?>background-color:#ffffee;<?php }?>" >
				<td class="right_table_padding"><?php if ($output[0][9] == 'M'){?><span>Reason for Deactivation</span><br/><?php echo $output[0][11];?><?php }?></td>
				</tr>

				<tr>
                <td class="right_table_padding" style="text-align:center">
                <input type="hidden" id="faAjax" value="y"/>
                <input type="hidden" id="faPage" value="listing"/>
                <input type="hidden" id="faId" value="<?php echo $str[0]."_".$output[0][8]; ?>"/>

                <input type="button"  id="faButton" name="submit" value="<?php if ($output[0][9] == Y) { echo " Deactivate ";}else{echo "     Activate     ";} ?>" <?php if ($output[0][9] =='Y') {?> onclick="javascript:deactivate();" <?php } else {?> onclick="javascript:activate();<?php }?>" />
              </td>
                </tr>
			</tbody></table>

			</td>
        </tbody>
        </table>
	  </fieldset>
	</form>
<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
            </div>
<?php
    }
    else if ($str[0] == 3)
    {
?>

<div id="toolbar-box">
<div class="t">
		 		<div class="t">
					<div class="t"></div>
		 		</div>
</div>
			<div class="m">
	<form action="" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">
	  <fieldset id="page-middle-middle-content">
	  <legend>Edit Listing (<?php echo $topList[$str[0]]['category']?> > <?php echo $list[$temp][3];?> > <?php echo $listSub[$tempSub][3];?>)</legend>
	  <table width="100%" cellspacing="0" cellpadding="0" border="0">
      <tbody><tr>
    <td width="470">
      <table class="admintable" width="470">
	    <tr>
	      <td class="key" align="right">Ad Title<span class="required_fields"></span></td>
	      <td><?php echo $output[0][0]; ?></td>
        </tr>
	    <tr>
          <td class="key" align="right">Price</td>
	      <td><?php echo $output[0][1]; ?></td>
        </tr>
        <tr>
          <td class="key" align="right">Image<span class="required_fields"></span></td>
	      <td>
          <img width="50" src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_CLAS_ADS'];?>/thumbs/<?php echo $output[0][2]; ?>"/>
          <br/>
          <a href="javascript: zoom('<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/zoom_prods.php','<?php echo $output[0][2]; ?>','clas_ads');"><img src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/zoom.png"/></a>
          <br/>
          </td>
        </tr>
        <tr>
          <td class="key" align="right">Notes<span class="required_fields"></span></td>
	      <td><?php echo $output[0][7]; ?></td>
        </tr>
        <tr>
          <td class="key" align="right">Keywords<span class="required_fields"></span></td>
	      <td><?php echo $output[0][6]; ?></td>
        </tr>
        <tbody>
		<tr>
	      <td width="131" align="right"> </td>
	      <td width="327"><label>
	        <input type="button" value="Back" name="Back" onClick="getListings('<?php echo $_REQUEST['cusId'];?>' , '<?php echo $str[0]."_".$str[1]."_".$str[2];?>');"/>
	      </label></td>
	    </tr>
        </tbody>
        </table>
        </td>
        <td valign="top">

                    <table width="190" cellspacing="5" cellpadding="2" border="0" style="border: 1px dashed rgb(204, 204, 204);">
				<tbody><tr><td class="right_table_top"><img width="14" height="14" style="vertical-align: bottom;" src="<?php echo $objCore->_SYS['CONF']['URL_ICONS_CONSOLE']; ?>/more_info.png"/> This listing is <span id="spanStatus"><?php if ($output[0][5] == Y) { ?> Active <?php } else { ?> Inactive <?php } ?></span></td></tr>
				<tr>
				<td>You can Activate or Deactivate any listing as the administrator.<br/>

				</td>
				</tr>


				<tr id="reason"  style="display:<?php if ($output[0][5] == Y) {echo "block";}else{echo "none";}?>;" >
				<td class="right_table_padding"><span>Reason for Deactivation</span><textarea id="reason_text" style=""></textarea></td>
				</tr>
				<tr id="reasonD"  style="display:<?php if ($output[0][5] == Y) {echo "none";}else{echo "block";}?>;<?php if ($output[0][5] == 'M') {?>background-color:#ffffee;<?php }?>" >
				<td class="right_table_padding"><?php if ($output[0][5] == 'M') {?><span>Reason for Deactivation</span><br/><?php echo $output[0][8];?><?php }?></td>
				</tr>
				<tr>
                <td class="right_table_padding" style="text-align:center">
                <input type="hidden" id="faAjax" value="y"/>
                <input type="hidden" id="faPage" value="listing"/>
                <input type="hidden" id="faId" value="<?php echo $str[0]."_".$output[0][4]; ?>"/>

                <input type="button"  id="faButton" name="submit" value="<?php if ($output[0][5] == Y) { echo " Deactivate ";}else{echo "     Activate     ";} ?>" <?php if ($output[0][5] =='Y') {?> onclick="javascript:deactivate();" <?php } else {?> onclick="javascript:activate();<?php }?>" />
              </td>
                </tr>
			</tbody></table>



			</td>
	  </tbody></table>
	  </fieldset>
	</form>
<div class="clr"></div>
			</div>
			<div class="b">
				<div class="b">
					<div class="b"></div>
				</div>
			</div>
            </div>

<?php
    }
?>