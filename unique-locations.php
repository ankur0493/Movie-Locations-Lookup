<?php
if($_POST['data'] == true){
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
echo json_encode($unique_locations);
}
?>