<!DOCTYPE html>
<html>
	<head>
		<title>Find San Francisco's Movie Shoot Locations</title>
		<style>
		html, body{
		height:100%;
		width:100%;
		}
		#map {
		margin-left: 25%;
		margin-top:15%;
		height:70%;
		width: 50%;
		}
		#message{
		height: 20%;
		width: 20%;
		}
		</style>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script>
		
		function initMap(){
		var LatLng = {lat:37.714238, lng:-122.434268};
		var mapProp = {
		center : LatLng,
		zoom :11};
		
		var map=new google.maps.Map(document.getElementById('map'), mapProp);
		var geocoder = new google.maps.Geocoder();

		$.post('top-locations.php','action=true', function(json){
			json1 = JSON.parse(json);
			$.each(json1, function(key, data) {
            var latLng = new google.maps.LatLng(data.lat, data.lng); 
            // Creating a marker and putting it on the map
            var marker = new google.maps.Marker({
                position: latLng,
                title: data.address
            });
			
			});
			});
			
	
			
		}
		
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-_Vo0sBbCikp51LISXveBAE58eA88viA &callback=initMap" async defer></script>
		
		
	</head>
	<body>
	<div id="message"></div>
	<div id="map"></div>
	</body>
</html>
