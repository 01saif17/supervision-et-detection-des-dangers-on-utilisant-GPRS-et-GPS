<?php

require 'config.php';
$sql = "SELECT * FROM tbl_gps WHERE ( id > (SELECT COUNT(*) FROM tbl_gps) - 50)";
$result = $db->query($sql);

if (!$result) {
  { echo "Error: " . $sql . "<br>" . $db->error; }
}

$rows = $result -> fetchAll(PDO::FETCH_NUM);

//print_r($row);

//header('Content-Type: application/json');
//echo json_encode($rows);

?>
<html>
    <head>
    <title> Saif Bourghiba </title>
</head>
<div class="header">
  <h1>projet for all</h1>
  <p>voila les dernieres positions de votre drone </p>
  <!--<h1>welcome to my project #sakka_anis #ala_besbes #zeineb_slimen</h1>-->
</div>

<style>
body {
	font-family: Arial;
}

#map-layer {
	margin: 75px 100px;

	min-height: 900;
}
</style>

<body>
    
   
    <div id="map-layer">
	</div>
	
	<script>
	     var map;
	     var location;
         window.initMap = function(){
            var mapLayer = document.getElementById("map-layer");
				var centerCoordinates = new google.maps.LatLng(35.7625, 10.8089);
				var defaultOptions = { center: centerCoordinates, zoom: 15}
				map = new google.maps.Map(mapLayer, defaultOptions);
    
  <?php foreach($rows as $location){ 
	    $lat= $location[1];
		$lng = $location[2];
		$date_time = $location[3];
		$gaz = $location[4];
	
		?>
    
 		
 		

new google.maps.Marker({
    position:{ lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>},
    map,
    title: "35.124647,10.245863"
         
           
    
  });
  
//   <?php 	} ?>

 	
 }
  window.initMap;
	</script>
		
	<script async defer
	src="https://maps.googleapis.com/maps/api/js?key=**your API key **&callback=initMap">
	</script>
	
	
    <div id="link_wrapper">
		</div>


<script>
function loadXMLDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("link_wrapper").innerHTML =
      this.responseText;
    }
  };
  xhttp.open("GET", "server.php", true);
  xhttp.send();
}
setInterval(function(){
	loadXMLDoc();


},1000);

window.onload = loadXMLDoc;
</script>
</body>
<style>
/* Style the body */
body {
  font-family: Arial;
  margin: 0;
}

/* Header/ Title */
.header {
  padding: 50px;
  text-align: center;
  background: #A9A9A9; 
  color: white;
  font-size: 50px;
}

</style>
