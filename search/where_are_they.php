<?php
	require_once("../classes/core/core.class.php");
 	$objCore=new Core;
 	$objCore->auth(1,false);
 	require_once($objCore->_SYS['PATH']['CLASS_CUSTOMER']);
 	$objCustomer = new Customer();
 	$customerData=$objCustomer->getCustomerData($_REQUEST['cid']);
 	$customerInfo = $customerData[0];
 	require_once($objCore->_SYS['PATH']['CLASS_COUNTRY']); 
	$objCountry=new Country();
    require_once($objCore->_SYS['PATH']['CLASS_SERVICE']);
    if (!is_object($objService))
    {
        $objService = new Service;
    }
    $serviceData = $objService->getServiceData($_REQUEST['cid']);
    require_once($objCore->_SYS['PATH']['CLASS_CATEGORY']);
    if(!is_object($objCategory))
    {
        $objCategory = new Category();
    }
    $listSub=$objCategory->getSubcList($serviceData[0][1],'sub_arr');
    for ($n=0; $n<count($listSub); $n++)
    {
        if ($listSub[$n][0]==$serviceData[0][2]) $tempSub = $n;
    }
    
	
?>



<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>Where Are They</title>
    <link href="<?php echo $objCore->_SYS['CONF']['URL_CSS_FRONT'];?>/master.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $objCore->_SYS['GEO']['URL']; ?>?file=api&amp;v=2&amp;key=<?php echo $objCore->_SYS['GEO']['KEY']; ?>"
            type="text/javascript"></script>
    <script type="text/javascript">

    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        var point = new GLatLng(<?php echo $customerInfo[15]; ?> , <?php echo $customerInfo[16]; ?>); 
        map.setCenter(point, 13);
		  var marker = new GMarker(point);
        map.addOverlay(marker);
      }
    }

    </script>
  </head>
  <body onload="initialize()" onunload="GUnload()">
<!-- START PAGE HEADER -->
<div id="top-bar-left">
<div id="logo"><img src="<?php echo $objCore->_SYS['CONF']['URL_IMAGES_FRONT'];?>/small-logo.jpg" alt="logo" width="270" height="65" /></div>
</div>
<div id="top-bar-shade">
<div class="activate_header">More Information - <?php echo $customerInfo[0]." ".$customerInfo[1]; ?></div>
</div>
<!-- START PAGE MIDDLE -->
<div id="page-middle" style="width: 560px;padding-bottom: 15px;padding-top: 15px;padding-left: 15px;overflow: hidden">
<div id="page-middle-middle" style="width: 555px;">
<div id="page-middle-content" style="width: 550px;">
<div id="page-middle-middle-content" style="width: 540px;">
<div style="width: auto;" id="commercial_cleaners_page_middle">
<div id="commercial_cleaners_middle_content">
<table class="text_normal">
    <tbody><tr>
      <td width="186" style="padding-left: 10px; width: auto;"><strong>Business Name</strong></td>
      <td width="10" style="padding-left: 35px;"> <strong>:</strong></td>
      <td width="311" style="padding-left: 2px;" class="text_normal"><?php echo $serviceData[0][9]; ?></td>
    </tr>
    <tr>
      <td style="padding-left: 10px;" class="text_normal"><strong>Category </strong></td>
      <td width="10" style="padding-left: 35px;"> <strong>:</strong></td>
      <td class="text_normal"><?php echo $listSub[$tempSub][3]; ?></td>
    </tr>
    <tr>
      <td valign="top" style="padding-left: 10px;" class="text_normal"><strong>Service Description  </strong></td>
      <td width="10" style="padding-left: 35px;"> <strong>:</strong></td>
      <td class="text_normal"><?php echo $serviceData[0][5]; ?></td>
    </tr>
   <?php
     if($serviceData[0][6]>0)
     {
   ?>
    <tr>
      <td valign="top" style="padding-left: 10px;" class="text_normal"><strong>Hourly Rate</strong></td>
      <td width="10" style="padding-left: 35px;"> <strong>:</strong></td>
      <td class="text_normal"><?php echo $objCore->_SYS['CONF']['CURRENCY']." ".number_format($serviceData[0][6],2); ?></td>
    </tr>
    <?php }?>
   <?php
     if($serviceData[0][7]>0)
     {
   ?>
    <tr>
      <td valign="top" style="padding-left: 10px;" class="text_normal"><strong>Call Out Charge</strong></td>
     <td width="10" style="padding-left: 35px;"> <strong>:</strong></td>
      <td class="text_normal"><?php echo $objCore->_SYS['CONF']['CURRENCY']." ".number_format($serviceData[0][7],2); ?></td>
    </tr>
<?php }?>
<!-- tr>
      <td style="padding-left: 10px;vertical-align:top;" class="text_normal"><strong>Accreditation</strong></td>
      <td width="10" style="padding-left: 35px;"> <strong>:</strong></td>
      <td class="text_normal">
      <?php
            $accData=explode("||",$serviceData[0][12]);
            foreach($accData as $accItem)
            {
                if($accItem) echo $accItem."<br/>";
            }
      ?>

      </td>
    </tr-->
	<tr><td style="padding-left: 10px;"> </td>
	  <td> </td>
	  <td> </td></tr>
</tbody></table>

<table class="text_normal">
    <tbody>
        <!--<tr><td width="175" style="padding-left: 10px; width: auto;"> </td>
        <td width="15" style="padding-left: 0px;"> </td>
        <td width="207" style="padding-left: 0px;"> </td>
    </tr>-->
    <tr>
      <td style="padding-left: 10px;" class="text_normal"><strong>Name of person to contact</strong></td>
       <td width="10" style="padding-left: 3px;"> <strong>:</strong></td>
      <td valign="top" class="text_normal"><?php echo $customerInfo[0].' '.$customerInfo[1]; ?></td>
      </tr>
    <tr>
      <td valign="top" style="padding-left: 10px;" class="text_normal"><strong>Address</strong></td>
      <td width="10" style="padding-left: 3px;" valign="top"> <strong>:</strong></td>
      <td class="text_normal"><?php echo $customerInfo[3].", ".$customerInfo[4]."<br />".$customerInfo[5]."<br />".$customerInfo[6]."<br />".$objCountry->arrCountry[$customerInfo[7]];?><br/>
      </td>
      </tr>

<!--<table width="600" cellspacing="0" cellpadding="0" border="0">
  <tbody><tr>
    <td width="338" rowspan="2"></td>

  </tr><tr>
  <?php $image = $objCategory->image($serviceData[0][8],$objCore->_SYS['CONF']['FTP_SERVICES'],$objCore->_SYS['CONF']['URL_IMAGES_SERVICES']); ?>
    <td valign="middle" align="center" style="border: medium solid rgb(180, 180, 180);"><img height="150" width="200" alt="logo" src="<?php echo $image."?t=".time();?>"/></td>
  </tr>
</tbody></table>-->

</tbody></table>
<div style="padding-left:160px;margin:15px 0px 15px 0px;">
    <table width="600" cellspacing="0" cellpadding="0" class="common_text">
    <tbody>
    <tr><td style="overflow: hidden; padding-left: 10px; padding-right: 10px;"><div style="border: thick solid rgb(128, 128, 128); width: 300px; height: 200px;" id="map_canvas"><img height="200" width="300" alt="logo" src="info.php_files/g_map.jpg"/></div></td></tr>
</tbody></table>
</div>


    <table class="text_normal">
    <tbody>
        <tr><td width="185" style="padding-left: 10px; width: auto;"> </td>
        <td width="15" style="padding-left: 0px;"> </td>
        <td width="207" style="padding-left: 0px;"> </td>
    </tr>

    <tr>
      <td style="padding-left: 10px;" class="text_normal"><strong>Tel</strong></td>
      <td width="10" style="padding-left: 98px;"> <strong>:</strong></td>
      <td class="text_normal"><?php echo $customerInfo[8];?></td>
      </tr>
    <tr><td style="padding-left: 10px;" class="text_normal"><strong>Mobile</strong></td>
      <td width="10" style="padding-left: 98px;"> <strong>:</strong></td>
      <td class="text_normal"><?php echo $customerInfo[10];?></td>
    </tr>
    <tr><td style="padding-left: 10px;" class="text_normal"><strong>Email</strong></td>
      <td width="10" style="padding-left: 98px;"> <strong>:</strong></td>
      <td class="text_normal"><a href="mailto:<?php echo $customerInfo[11];?>"><?php echo $customerInfo[11];?></a> </td>
    </tr>
	<tr><td style="padding-left: 10px;" class="text_normal"><strong>Website</strong></td>
      <td width="10" style="padding-left: 98px;"> <strong>:</strong></td>
      <td class="text_normal"><a target="_blank" href="<?php echo $serviceData[0][13]; ?>"><?php echo $serviceData[0][13]; ?></a> </td>
    </tr>
</tbody></table>

</div>
</div>
</div>
</div>
</div>
</div>
<!-- ENDPAGE MIDDLE -->
  </body>
</html>