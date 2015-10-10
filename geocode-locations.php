<?php
if($_POST['data']){
$file = fopen("geoLocations.json", "w") or die("Unable to open file");
fwrite($file, $_POST['data']);
fclose($file);
echo "Success";
}
else{
echo "Errkofef";
}
?>