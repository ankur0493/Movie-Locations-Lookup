<?php
if($_POST['data']){
$url = $_SERVER["DOCUMENT_ROOT"]."/JSON/geoLocations2.json";
$file = fopen($url, "a") or die("Unable to open file");
$data = json_decode(stripslashes($_POST['data']));
$data = json_encode($data);
fwrite($file, $data);
fclose($file);
echo "Success";
}
else{
echo "Error. Could not write to file.";
}
?>