<?php
$url = "JSON\movie_data.json";
$json = file_get_contents($url);
$data = json_decode($json,TRUE);
$unique_titles = array();
$unique_locations = array();
foreach ($data as $value){
if(array_key_exists("locations", $value))
{
if(!in_array($value["locations"],$unique_locations)){
array_push($unique_locations, $value["locations"]);
}}
};
$locations= json_encode($unique_locations);
?>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>Google Maps</title>
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
  </head>
  <body>

    
    <div id="map" style="width:600px;height:400px;"></div>
    <div id="messages"></div>

    <script type="text/javascript">
    //<![CDATA[
    

    // delay between geocode requests - at the time of writing, 100 miliseconds seems to work well
    var delay = 100;


      // ====== Create map objects ======
      var infowindow = new google.maps.InfoWindow();
      var latlng = new google.maps.LatLng(-34.397, 150.644);
      var mapOptions = {
        zoom: 8,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      var geo = new google.maps.Geocoder(); 
      var map = new google.maps.Map(document.getElementById("map"), mapOptions);
      var bounds = new google.maps.LatLngBounds();

      // ====== Geocoding ======
      function getAddress(search, next) {
        geo.geocode({address:search+', San Francisco '}, function (results,status)
          { 
            // If that was successful
            if (status == google.maps.GeocoderStatus.OK) {
              // Lets assume that the first marker is the one we want
              var p = results[0].geometry.location;
              var lat=p.lat();
              var lng=p.lng();
              // Output the data
                var msg = 'address="' + search + '" lat=' +lat+ ' lng=' +lng+ '(delay='+delay+'ms)<br>';
                document.getElementById("messages").innerHTML += msg;
			LatLngLst.push({
			address: search,
			lat: lat,
			lng: lng});
			
              // Create a marker
              createMarker(search,lat,lng);
            }
            // ====== Decode the error status ======
            else {
              // === if we were sending the requests to fast, try this one again and increase the delay
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

     // ======= Function to create a marker
     function createMarker(add,lat,lng) {
       var contentString = add;
       var marker = new google.maps.Marker({
         position: new google.maps.LatLng(lat,lng),
         map: map,
         zIndex: Math.round(latlng.lat()*-100000)<<5
       });

      google.maps.event.addListener(marker, 'click', function() {
         infowindow.setContent(contentString); 
         infowindow.open(map,marker);
       });

       bounds.extend(marker.position);

     }

      // ======= An array of locations that we want to Geocode ========
      var addresses = <?php echo $locations; ?>;

      // ======= Global variable to remind us what to do next
      var nextAddress = 700;
	  var LatLngLst = [];

      // ======= Function to call the next Geocode operation when the reply comes back

      function theNext() {
        if (nextAddress < addresses.length) {
          setTimeout('getAddress("'+addresses[nextAddress]+'",theNext)', delay);
          nextAddress++;
        } else {
          // We're done. Show map bounds
          map.fitBounds(bounds);
		  JsonLocations = JSON.stringify(LatLngLst);
		  $.ajax({
			type: "POST",
			url: "geocode-locations.php",
			data: {data: JsonLocations},
			success: function(data){
			alert(data);
			}
			});
		  
		  
		  $.data('geocode-locations.php',LatLngLst,function(data){
			alert(data);
			});
        }
      }

      // ======= Call that function for the first time =======
      theNext();

    // This Javascript is based on code provided by the
    // Community Church Javascript Team
    // http://www.bisphamchurch.org.uk/   
    // http://econym.org.uk/gmap/

    //]]>
    </script>
  </body>

</html>




