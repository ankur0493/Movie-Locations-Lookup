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
		#loc{
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

		$.post('top-locations.php','action=true', function(data){
			var locations = JSON.parse(data);
			$(document.getElementById('loc')).html(locations);
			});
			
	
			
		}
		
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-_Vo0sBbCikp51LISXveBAE58eA88viA &callback=initMap" async defer></script>
		
		
	</head>
	<body>
	<div id="loc"></div>
	<div id="map"></div>
	</body>
</html>
