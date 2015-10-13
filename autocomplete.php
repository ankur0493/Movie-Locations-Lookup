<?php
$query = $_POST['q'];
$url = "JSON\movie_data.json";
$json = file_get_contents($url);
$data = json_decode($json,TRUE);
$unique_titles = array();
$suggestion = "";
foreach ($data as $value){
if(!in_array($value["title"],$unique_titles)){
array_push($unique_titles, $value["title"]);
}
}
$titles = array();
?>
<ul id="movie-list">
<?php
foreach ($unique_titles as $value){
if($query){
	if(stristr($value,$query)){
	?>
	<li onClick="selectMovie('<?php echo $value; ?>');"><?php echo $value; ?></li>	
	<?php
	}
	}
}
?>
</ul>
<?php
?>