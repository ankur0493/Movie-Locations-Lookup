<!DOCTYPE html>
<html>
	<head>
		<title>Find San Francisco's Movie Shoot Locations</title>
		<style>
		html, body{height:100%; width:100%;}
		#searchForm{padding: 10px; border: #F0F0F0 1px solid;}
		#map {margin-top:0px; height:79%; width:100%; position: absolute;}
		.search{ border: 1px solid #F0F0F0; margin: 2px 0px; padding:40px;}
		#movie-list{float:left; list-style:none; margin:0; padding:0; width:190px; position:relative; z-index: 1;}
		#movie-list li{padding: 10px; background:#FAFAFA;border-bottom:#F0F0F0 1px solid;}
		#movie-list li:hover{background:#F0F0F0;}
		#submit{border-radius:5px; padding:5px;}
		</style>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script>
		$(document).ready(function(){
		//define the autocomplete function
			$("#searchForm").keyup(function(){
				$.ajax({
					type: "POST",
					url: "autocomplete.php",
					data:'q='+$(this).val(),
					success: function(data){
						$("#suggestion-box").show();
						$("#suggestion-box").html(data);
					}
				});
			});
		});
		
		function selectMovie(val) {
			$("#searchForm").val(val);
			$("#suggestion-box").hide();
		}
		
		//fetch locations where the selected movie has been shot
		function movieLocations(){
			var movieName = $("#searchForm").val();
				$.ajax({
					type: "POST",
					url: "location-search.php",
					data: 'mov='+movieName,
					success: function(data){
						deleteMarkers();
						createMarkers(data);
					}
				});
			
		}
		
		//function to remove previous markers from the map
		function deleteMarkers(){
			for (var i = 0; i < markers.length; i++) {
				markers[i].setMap(null);
			}
		}
		var markers = [];
		
		//function to put markers on the map
		function createMarkers(data){
		markers = []; //empty the markers array
			json1 = JSON.parse(data);
			for(var i=0;i<(json1.length);i++){
				var latLng = new google.maps.LatLng(json1[i].lat, json1[i].lng); 
				// Creating a marker and putting it on the map
				var marker = new google.maps.Marker({
					position: latLng,
					map: map,
					title: json1[i].address
				});
				bounds.extend(marker.position);
				markers.push(marker); //create an array of the existing markers
			}
			map.fitBounds(bounds);
		}
		
		function initMap(){
			var LatLng = {lat:37.714238, lng:-122.434268};
			var mapProp = {
				center : LatLng,
				zoom :17
			};
			//declare global variables bounds and map using 'window' function
			window.bounds = new google.maps.LatLngBounds();
			window.map=new google.maps.Map(document.getElementById('map'), mapProp);
			$.post('unique-locations.php','action=true', function(data){
				createMarkers(data);
			});
		}
		
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-_Vo0sBbCikp51LISXveBAE58eA88viA &callback=initMap" async defer></script>
		
		
	</head>
	<body>
	<div class="search">
		<input type="text" id="searchForm" placeholder="Enter Movie Name" />
		<button id="submit" onclick="movieLocations()">Let's find out the shoot locations</button>
		<div id="suggestion-box"></div>
	</div>
	
	
	<div id="map"></div>
	</body>
</html>
