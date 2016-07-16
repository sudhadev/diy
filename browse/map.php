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
<html>
    <head>
        <script src="<?php echo $objCore->_SYS['GEO']['URL']; ?>?file=api&amp;v=2&amp;key=<?php echo $objCore->_SYS['GEO']['KEY']; ?> &sensor=false"
            type="text/javascript"></script>
    <script type="text/javascript">

    function initialize() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map_canvas"));
        var point = new GLatLng(<?php echo $customerInfo[15]; ?> , <?php echo $customerInfo[16]; ?>); 
        map.addControl(new GSmallMapControl());
        map.addControl(new GMapTypeControl());
        map.setCenter(point, 13);
		  var marker = new GMarker(point);
        map.addOverlay(marker);
      }
    }

    </script>
        
    </head>
    <body onload="initialize()" onunload="GUnload()">
        
    <div id="map_canvas" style="width: 310px; height: 300px; border: 1px solid rgb(128, 128, 128);"><?php //print_r($customerData); ?></div>
    
    
    
</body>
</html>