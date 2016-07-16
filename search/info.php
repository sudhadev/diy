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
?>

<!DOCTYPE html "-//W3C//DTD XHTML 1.0 Strict//EN" 
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title>More Information</title>
    <link href="<?php echo $objCore->_SYS['CONF']['URL_CSS_FRONT'];?>/master.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo $objCore->_SYS['GEO']['URL']; ?>?file=api&amp;v=2&amp;key=<?php echo $objCore->_SYS['GEO']['KEY']; ?> &sensor=false"
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
<!-- END PAGE HEADER -->

<!-- START PAGE MIDDLE -->
<div id="page-middle" style="width: auto">
<div id="page-middle-middle" style="width: auto">
<div id="page-middle-content" style="width: auto">
<div id="page-middle-middle-content" style="width: auto">
<table class="common_text">
    <tr><td style="padding-left: 10px; width: auto"><b>Company: </b></td><td style="padding-left: 0px"><?php echo $customerInfo[2]; ?> </td></tr>
    <tr><td style="padding-left: 10px"><b>Address: </b></td><td><?php echo $customerInfo[3].",".$customerInfo[4].",".$customerInfo[5].",".$customerInfo[6].",".$objCountry->arrCountry[$customerInfo[7]];?> </td></tr>
    <tr><td style="padding-left: 10px"><b>Telephone: </b></td><td><?php echo $customerInfo[8];?> </td></tr>
    <tr><td style="padding-left: 10px"><b>Fax: </b></td><td><?php echo $customerInfo[9];?> </td></tr>
    <tr><td style="padding-left: 10px"><b>Mobile: </b></td><td><?php echo $customerInfo[10];?> </td></tr>
    <tr><td style="padding-left: 10px"><b>Email: </b></td><td><?php echo $customerInfo[11];?> </td></tr>
</table>
<table class="common_text">
    <tr><td style="padding-left: 10px"><center><b>Location Map</b></center></td></tr>
    <tr><td style="padding-left: 10px; padding-right: 10px"><div id="map_canvas" style="width: 500px; height: 300px; border: thick solid rgb(128, 128, 128);"></div></td></tr>
</table>
</div>
</div>
</div>
</div>
<!-- ENDPAGE MIDDLE -->
  </body>
</html>