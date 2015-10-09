<?php
$url = "JSON\movie_data.json";
$json = file_get_contents($url);
$data = json_decode($json,TRUE);
$unique_titles = array();
$unique_locations = array();
foreach ($data as $value){
if(!in_array($value["title"],$unique_titles)){
array_push($unique_titles, $value["title"]);
}
if(array_key_exists("locations", $value))
{
if(!in_array($value["locations"],$unique_locations)){
array_push($unique_locations, $value["locations"]);
}}
};

var_dump($unique_titles);
echo nl2br("\n\n\n\n");
var_dump($unique_locations);

?>