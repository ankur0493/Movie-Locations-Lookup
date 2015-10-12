<!DOCTYPE html>
<html>
	<head>
		<title>Find San Francisco's Movie Shoot Locations</title>
		<style>
		html, body{
		height:100%;
		width:100%;
		}
		#searchForm{
		width: 15%;
		height:100%;
		position: absolute;
		}
		#map {
		margin-left: 19%;
		height:100%;
		width:79%;
		position: absolute;
		}
		</style>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script>
		
		function initMap(){
		var LatLng = {lat:37.714238, lng:-122.434268};
		var mapProp = {
		center : LatLng,
		zoom :17};
		var bounds = new google.maps.LatLngBounds();
		var map=new google.maps.Map(document.getElementById('map'), mapProp);
		var geocoder = new google.maps.Geocoder();
		var i = 0;
		$.post('top-locations.php','action=true', function(json){
			json1 = JSON.parse(json);
			for(i=0;i<(json1.length);i++){
			var latLng = new google.maps.LatLng(json1[i].lat, json1[i].lng); 
            // Creating a marker and putting it on the map
            var marker = new google.maps.Marker({
                position: latLng,
				map: map,
                title: json1[i].address
            });
				
			
	   bounds.extend(marker.position);
			}
			
			map.fitBounds(bounds);
			});
			
	
			
		}
		
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-_Vo0sBbCikp51LISXveBAE58eA88viA &callback=initMap" async defer></script>
		
		
	</head>
	<body>
	<div id="searchForm"></div>
	<div id="map"></div>
	</body>
</html>
