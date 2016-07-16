<?php
	
	/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>      				'
  '    FILE            :  geo.class.php                                			'
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

	class Geo
	{
	
		//Getting the Latitude and Longitude Values, Map  
		function getCoordinates($formName, $submissionType='', $ajaxFunction='', $apiKey, $mapsUrl)
		{ 
/*	<script type="text/javascript" src="<?php echo $mapsUrl;?>?file=api&amp;v=3&amp;sensor=false&amp;key=<?php echo $apiKey;?>;&amp;region=GB"></script>
	*/
?>
	<script type="text/javascript" src="<?php echo $mapsUrl;?>?file=api&amp;v=3&amp;sensor=false&amp;key=<?php echo $apiKey;?>&amp;region=GB"></script>
   <script type="text/javascript">
		var map = null;
		var geocoder = null; 
		var submissionType = '<?php echo $submissionType; ?>';
		var ajaxFunction = '<?php echo $ajaxFunction; ?>'; 
		
        /*
         * Check the validity of the Search form data before show the map
         * added by Saliya Wijesinghe
         */
        function validToSearch()
        {
            // validating
                var kword= document.getElementById("keyword").value;
                var cLatitude=document.<?=$formName;?>.confirmedLatitude.value;
                var cLongitude=document.<?=$formName;?>.confirmedLongitude.value;
                var address =document.getElementById("address").value;

                var msgErrorKeyword='Plaster or Plasterers';
                var msgErrorAddress='London Regents St or W1B 1JA';
                var valid=true;

                if(kword=='' || kword==msgErrorKeyword)
                {
                    document.getElementById("keyword").setAttribute("style", "border:1px solid #FF0000;");
                    document.getElementById("keyword").value=msgErrorKeyword;
                    valid=false;
                }

                if(address=='' || address==msgErrorAddress)
                {
                    document.getElementById("address").setAttribute("style", "border:1px solid #FF0000;");
                    document.getElementById("address").value=msgErrorAddress;
                    valid=false;
                }


                if(!valid) return false;
            
            
            // end validating
            if(valid)
                {
                  //  var addressNew=document.getElementById("address").value;
                    var addressOld=document.getElementById("hidAddress").value;
                    if((cLatitude!=''&& cLongitude!='') && (address==addressOld)){
                            document.<?=$formName;?>.latitude.value = document.<?=$formName;?>.confirmedLatitude.value;
                            document.<?=$formName;?>.longitude.value = document.<?=$formName;?>.confirmedLongitude.value;
                            document.<?=$formName;?>.submit();
                       }
                       else
                       {
                           return true;
                       }

                
            }else{
                 //return true;
            }
           
        }

        
		function initialize()
		{
			if (GBrowserIsCompatible())
			{
				map = new GMap2(document.getElementById("map_canvas"));
                //alert(map);
				map.setCenter(new GLatLng(51.5001524, -0.1262362), 13);
				map.addControl(new GSmallMapControl());
				geocoder = new GClientGeocoder();
			}
		}
		
		function getAddress(overlay, latlng) 
		{
  			if (latlng != null)
  			{
    			address = latlng;
    			geocoder.getLocations(latlng, showNewAddress);
  			}
		}
		
		
		//Getting the Latitude/Longitude values and Location Map   
		function showAddress(address)
		{
            address=address + ', UK';
			if (geocoder)
			{
				geocoder.getLatLng(
          		address,
          		function(point)
          		{
            		if (!point)
            		{
              			document.getElementById("msg").innerHTML = "We couldn't find Latitude/Longitude values for your location: " + address + "." + "Please manually enter them below.";
              			document.<?=$formName;?>.latitude.value = "0.0000";
              			document.<?=$formName;?>.longitude.value = "0.0000";
              			document.<?=$formName;?>.confirm.value = "I will Enter GeoCode Later";
            		} 
            		else
            		{
              			map.setCenter(point, 13);
              			var marker = new GMarker(point, {draggable: true});
              			map.addOverlay(marker);
              			marker.openInfoWindowHtml(address);
              			GEvent.addListener(marker, "dragstart", function() 
              			{
            				map.closeInfoWindow();
            			});
            			GEvent.addListener(marker, "dragend", function() 
            			{     					
      						getAddress(null , marker.getLatLng());
    						});
              			var str = point.toString();
              			var str2 = str.substring(1, str.length-1);
              			geocode = str2.split(", ");
              			document.getElementById("msg").innerHTML = "We found Latitude/Longitude values for your location: " + address + "." + "Please drag and drop the position marker to the correct position or manually edit GPS details below if there is any difference.";
              			document.<?=$formName;?>.confirm.value = "Confirm";
              			document.<?=$formName;?>.latitude.value = geocode[0];
              			document.<?=$formName;?>.longitude.value = geocode[1];
              			document.<?=$formName;?>.confirmedLatitude.value = document.<?=$formName;?>.latitude.value;
							document.<?=$formName;?>.confirmedLongitude.value = document.<?=$formName;?>.longitude.value;
            		}
          		}
        		);
      	}
    	}
    
    	function showNewAddress(response) 
    	{
  			map.clearOverlays();
  			if (!response || response.Status.code != 200)
  			{
    			alert("Status Code:" + response.Status.code);
  			} 
  			else 
  			{
    		place = response.Placemark[0];
    		point = new GLatLng(place.Point.coordinates[1],
                        place.Point.coordinates[0]);
    		marker = new GMarker(point, {draggable: true});
    		map.addOverlay(marker);
    		marker.openInfoWindowHtml(place.address);
    		document.getElementById("msg").innerHTML = "We found Latitude/Longitude values for your location: " + (place.address).toString(); + "." + "Please manually edit them below if there is any difference.";
         document.<?=$formName;?>.latitude.value = place.Point.coordinates[1];
         document.<?=$formName;?>.longitude.value = place.Point.coordinates[0];
         document.<?=$formName;?>.confirmedLatitude.value = document.<?=$formName;?>.latitude.value;
			document.<?=$formName;?>.confirmedLongitude.value = document.<?=$formName;?>.longitude.value;
         GEvent.addListener(marker, "dragstart", function() 
         { 
         	map.closeInfoWindow();
        	});
         GEvent.addListener(marker, "dragend", function() 
         {
      		getAddress(null , marker.getLatLng());
    		});
  			}
		}
    
    		
		//Pop-Up the Location Map with Geocodes 
		function showMap()
		{
			var geoMap = document.getElementById("geoMap");
			var bg = document.getElementById("bg");
			var windowSize = getSize(); 
  			var scrolledValue = getScrollXY();
			geoMap.style.display = 'block';
			geoMap.style.position = 'absolute'; 
			geoMap.style.top = windowSize[1] + scrolledValue[1] - 500 + 'px';
			geoMap.style.left = windowSize[0] + scrolledValue[0] - 700 + 'px';
			geoMap.style.padding = '10px';
			geoMap.style.fontFamily = 'Arial';
			geoMap.style.fontSize = '11px'; 
			geoMap.style.zIndex = '100';
			geoMap.style.backgroundColor = "#FFFFFF";
			geoMap.style.border = 'thick solid #808080';
			map.checkResize();
  			bg.style.width = windowSize[0] + scrolledValue[0] ;
  			bg.style.height = windowSize[1] + scrolledValue[1]; 
			bg.style.display = 'block';
			bg.style.backgroundColor = "#000000";
			bg.style.opacity = '0.7';
			bg.style.filter = 'alpha(opacity=70)';
			bg.style.zIndex = '90';
		}
		
		//When clicked on the Relocate button 
		function doRelocate()
		{
			document.<?=$formName;?>.confirmedLatitude.value = document.<?=$formName;?>.latitude.value;
			document.<?=$formName;?>.confirmedLongitude.value = document.<?=$formName;?>.longitude.value;
			map.setCenter(new GLatLng(document.<?=$formName;?>.confirmedLatitude.value, document.<?=$formName;?>.confirmedLongitude.value),  13);
         map.clearOverlays();
         var marker = new GMarker(new GLatLng(document.<?=$formName;?>.confirmedLatitude.value, document.<?=$formName;?>.confirmedLongitude.value), {draggable: true});
			map.addOverlay(marker);
    		GEvent.addListener(marker, "dragstart", function() 
    		{
         	map.closeInfoWindow();
         });
         GEvent.addListener(marker, "dragend", function() 
         {     					
      		getAddress(null , marker.getLatLng());
    		});
		}
		

		function getSize()
		{
  			var myWidth = 0;
  			myHeight = 0;
  			if( typeof( window.innerWidth ) == 'number' )
  			{
    		//Non-IE
    		myWidth = window.innerWidth;
    		myHeight = window.innerHeight;
  			} 
  			else 
  				if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) )
  				{
    			//IE 6+ in 'standards compliant mode'
    			myWidth = document.documentElement.clientWidth;
    			myHeight = document.documentElement.clientHeight;
  				} 
  				else 
  					if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) 
  					{
    				//IE 4 compatible
    				myWidth = document.body.clientWidth;
    				myHeight = document.body.clientHeight;
  				}
  			return [ myWidth, myHeight ]; 
		}

		function getScrollXY()
		{
  			var scrOfX = 0, scrOfY = 0;
  			if( typeof( window.pageYOffset ) == 'number' ) 
  			{
    			//Netscape compliant
    			scrOfY = window.pageYOffset;
    			scrOfX = window.pageXOffset;
  			} else 
  				if( document.body && ( document.body.scrollLeft || document.body.scrollTop ) )
  				{
    				//DOM compliant
    				scrOfY = document.body.scrollTop;
    				scrOfX = document.body.scrollLeft;
  				} 
  				else 
  					if( document.documentElement && ( document.documentElement.scrollLeft || document.documentElement.scrollTop ) )
  					{
    					//IE6 standards compliant mode
    					scrOfY = document.documentElement.scrollTop;
    					scrOfX = document.documentElement.scrollLeft;
  				}
  			return [ scrOfX, scrOfY ];
		}
		
		function doSubmit()
		{			
			 if (submissionType == 'ajax')
			 {		 	
			 	<?php echo $ajaxFunction; ?>
			 	document.getElementById("geoMap").style.display = 'none';
			 	document.getElementById("bg").style.display = 'none';
			 }
			 else 
			 {
			 	document.<?=$formName;?>.submit(); 
			 }	
		}
		
		function doExit()
		{
			document.getElementById("geoMap").style.display = 'none';
			document.getElementById("bg").style.display = 'none';
		}		 	
   </script>

<?php
				return "<table><tr><td><div id=\"geoMap\" style=\"width: 500px;  display: none;\"><div id=\"map_canvas\" style=\"width: 500px; height: 300px;\"></div><br/><div id=\"msg\"></div><br/><div id=\"manual\"><input type=\"text\" id=\"latitude\" name=\"latitude\"/><input type=\"text\" id=\"longitude\" name=\"longitude\"/><br/> <input type=\"button\" name=\"relocate\" value=\"Relocate\" onClick=\"doRelocate();\"/><input type=\"button\" name=\"confirm\" id =\"confirm\" value=\"Confirm\" onClick=\"doSubmit();\"/><input type=\"button\" name=\"exit\" id =\"exit\" value=\"Exit\" onClick=\"doExit();\"/></div></div></td></tr></table>";  
		
		}
		 
		//Getting the Search Points
		function getPoints($latitude, $longitude, $radius)
		{
			for($angle = 0; $angle < 360; $angle +=90)
			{
				$x[] = $latitude + ($radius)*cos($angle); 
				$y[] = $longitude + ($radius)*sin($angle);
 			} 
			return array($x,$y); 			
		}
		
	}
	 
?>