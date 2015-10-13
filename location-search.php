<?php
if($_POST['mov']){ //check of the 'mov' argument is supplied or not
	$mov  = $_POST['mov'];
	$url = "JSON\movie_data.json";
	$json = file_get_contents($url);
	$data = json_decode($json,TRUE); //fetch the information for all the movies
	$locations = array(); 
	foreach($data as $value){ //run a loop through  the movies data
		if($value['title'] == $mov){ //check if the 'mov' argument is equal to the movie name in the current index of the movie data
			if($value['locations']){
				array_push($locations,$value['locations']); //push all the locations for the selected movie in an array
			}
		}	
	}
	$locData = array();
	$url2 = "JSON\geoLocations2.json";
	$json2 = file_get_contents($url2);
	$data2 = json_decode($json2,TRUE); //fetch geocoded data for all the locations
	$i = NULL;
	for($i=0;$i<count($locations);$i++){
		foreach($data2 as $value){
			if($locations[$i] == $value['address']){
				array_push($locData,$value); //push geocodes for the selected locations to an array
			}
		}
	}
	echo(json_encode($locData)); //output the geocoded data
}
?>