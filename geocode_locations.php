<?php
	$url = "JSON\movie_data.json";
	$json = file_get_contents($url);
	$data = json_decode($json,TRUE);
	?>
	<html>
	<head>
	<title>Geocoding...</title>
	<script type='text/javascript/'>
	var delay = 100;
	var nextAddress = 0;
	
	var infowindow = new google.maps.InfoWindow();
      var latlng = new google.maps.LatLng(-34.397, 150.644);
      var mapOptions = {
        zoom: 8,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      var geocoder = new google.maps.Geocoder(); 
      var map = new google.maps.Map(document.getElementById("map"), mapOptions);
      var bounds = new google.maps.LatLngBounds();
	  
	theNext();
	
	if (nextAddress < addresses.length) {
          setTimeout('getAddress("'+addresses[nextAddress]+'",theNext)', delay);
          nextAddress++;
        } else {
          
          map.fitBounds(bounds);
        }
      }
	
	function createMarker(add,lat,lng) {
       var contentString = add;
       var marker = new google.maps.Marker({
         position: new google.maps.LatLng(lat,lng),
         map: map,
         zIndex: Math.round(latlng.lat()*-100000)<<5
       });

	   
	function getAddress(search, next) {
        geocoder.geocode({address:search}, function (results,status)
          { 
            
            if (status == google.maps.GeocoderStatus.OK) {
            
              var p = results[0].geometry.location;
              var lat=p.lat();
              var lng=p.lng();
            
                var msg = 'address="' + search + '" lat=' +lat+ ' lng=' +lng+ '(delay='+delay+'ms)<br>';
                document.getElementById("messages").innerHTML += msg;
            
              createMarker(search,lat,lng);
            }
            
            else {
            if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                nextAddress--;
                delay++;
              } else {
                var reason="Code "+status;
                var msg = 'address="' + search + '" error=' +reason+ '(delay='+delay+'ms)<br>';
                document.getElementById("messages").innerHTML += msg;
              }   
            }
            next();
          }
        );
      }
</script>
</head>
<body>
<div id="map"></div>
</body>
</html>