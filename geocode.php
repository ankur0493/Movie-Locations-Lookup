<html>
	<head>
	<style>
	html,body{
	width: 100%;
	height: 100%;
	}
	#loc{
	height: 9%;
	width:100%;
	}
	#map{
	height:50%;
	width:70%;
	}
	</style>
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script>
	
	
	function write(){
	$.post('geocode-locations.php','data='+LatLngLst, function(data){
	alert(data);
	});
	}
	
	function initMap(){
	var LatLng= {lat:37.714238, lng:-122.434268};
	var mapProp = {
	center: LatLng,
	zoom: 1
	};
	var map = new google.maps.Map(document.getElementById("map"), mapProp);
	var geocoder = new google.maps.Geocoder();
	$.post('location-search.php','data=true', function(data){
	var address = JSON.parse(data);
	});
	var timeout = 0;
	for(i=0;i<(address.length);i++){
	setTimeout(function(){
	getCoord(geocoder,map,i,address);
	},timeout);
	timeout +=500
	}
	write();
	}
var LatLngLst = [];
	function getCoord(geocoder,map,i,address){
	geocoder.geocode( {'address': address[i]+"San Francisco"}, function(results, status) {
		  if (status == google.maps.GeocoderStatus.OK) {
		  var p = results[0].geometry.location;
          var latitude=p.lat();
          var longitude=p.lng();
			LatLngLst.push({
			address: address[i],
			lat: latitude,
			lng: longitude});
			var marker = new google.maps.Marker({
				map: map,
				position: results[0].geometry.location
				
			});
		  } else {
			alert("Geocode was not successful for the following reason: " + status);
		  }
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