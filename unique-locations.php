<?php
if($_POST['action'] == true)
{
	$url = "JSON\movie_data.json";
	$json = file_get_contents($url);
	$data = json_decode($json,TRUE); //fetch data for all the movies
	$locations = array();
	foreach($data as $value){
		if(array_key_exists("locations", $value)){ //check if the 'locations' key is present in the current index
		array_push($locations, $value["locations"]); //push the location name to a seperate array
		}
	}
	$location_frequencies = array_count_values($locations); // count the frequencies of the locations
	arsort($location_frequencies); //sort the frequencies
	$top_locations = array();
	foreach ($location_frequencies as $key => $value){
	if($value>=0){
		array_push($top_locations, $key); //push the locations with frequency more than a certain value to a seperate array
	}
	/*
	The unique locations can also be generated by using the array_unique function
	
	$top_locations = array_unique($locations);
	
	Rest of the code remains the same
	*/
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