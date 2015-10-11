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
	if($value>=3){
	array_push($top_locations, $key);
	}
	}
	$TopLocData = array();
	$url2 = "JSON\geoLocations2.json";
	$json2 = file_get_contents($url2);
	$data2 = json_decode($json2,TRUE);
	$i = NULL;
	for($i=0;$i<count($top_locations);$i++){
	foreach($data2 as $value){
	if($top_locations[$i] == $value['address']){
	array_push($TopLocData,$value);
	}
	}
	}
	echo(json_encode($TopLocData));

}
else{
echo "Error";
}
?>