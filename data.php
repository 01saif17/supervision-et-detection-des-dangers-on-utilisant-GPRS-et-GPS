<?php 

require 'config.php';
echo "saiff";
echo "<br>";
$lat = $_GET['lat'];
$lng = $_GET['lng'];
$gaz = $_GET['gaz'];

echo $lat;
echo "<br>";
echo $lng;
echo "<br>";
echo $gaz;

// $sql = "INSERT INTO tbl_gps (lat, lng, created_date)
// VALUES (lat, lng, '2022-02-12')";
 $sql = "INSERT INTO tbl_gps(lat,lng,gaz) 
 	VALUES(".$lat.",".$lng.",".$gaz.")";

if($db->query($sql) === FALSE)
	{ echo "Error: " . $sql . "<br>" . $db->error; }

echo "<br>";
//echo $db->insert_id;