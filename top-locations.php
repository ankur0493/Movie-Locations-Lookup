<?php
if($_POST['action'] == true)
{
	$url = "JSON\movie_data.json";
	$json = file_get_contents($url);
	$data = json_decode($json,TRUE);
	$locations = array();
	foreach($data as $value){
		if(array_key_exists("locations", $value)){
		array_push($locations, $value["locations"]);
		}
	}
	$location_frequencies = array_count_values($locations);
	arsort($location_frequencies);
	$top_locations = array();
	foreach ($location_frequencies as $key => $value){
	if($value>=1){
	array_push($top_locations, $key);
	}
	}
	$top_locations = json_encode($top_locations);
	echo $top_locations;
}
else{
echo "Error";
}
?>