<?php
//error: Google Maps JavaScript API error: ApiNotActivatedMapError
//solution: click "APIs and services" Link
//			click "Enable APIs and services" button
//			Select "Maps JavaScript API" then click on enable

require 'config.php';
$sql = "SELECT * FROM **** WHERE 1"; // (****)  name of your table created in phpmyadmin
$result = $db->query($sql);

if (!$result) {
  { echo "Error: " . $sql . "<br>" . $db->error; }
}

$rows = $result -> fetchAll(PDO::FETCH_NUM);

//print_r($row);

//header('Content-Type: application/json');
//echo json_encode($rows);


?>
	

	<table class="table">
			<thead>
				<th>lat</th>
				<th>lng</th>
				<th>date_time</th>
				<th>gaz</th>
				
			
	 		</thead>
	<?php foreach($rows as $location){ 
	    $lat= $location[1];
		$lng = $location[2];
		$date_time = $location[3];
		$gaz= $location[4];
		
		?>
		<script>
		
		var location = new google.maps.LatLng(<?php echo $lat; ?>,<?php echo $lng; ?>);
		console.log(location);
	 function addMarker(feature) {
          var marker = new google.maps.Marker({
            position: feature.position,
// i need to add here the info 
            //icon: icons[feature.type].icon,
            map: map
          });

          var popup = new google.maps.InfoWindow({
                    content: feature.position.toString(),
     //or here   the info             
                    maxWidth: 300
                });

          google.maps.event.addListener(marker, "click", function() {
                    if (currentPopup != null) {
                        currentPopup.close();
                        currentPopup = null;
                    }
                    popup.open(map, marker);
                    currentPopup = popup;
                });
                google.maps.event.addListener(popup, "closeclick", function() {
                    map.panTo(center);
                    currentPopup = null;
                });
        }
        </script>
<tbody>
				<tr>
					<td><?php echo $lat; ?></td>
					<td><?php echo $lng; ?></td>
					<td><?php echo $date_time; ?></td>
					<td><?php echo $gaz; ?></td>
				
				</tr>
			</tbody>
	
	<?php 	} ?>
	
	</table>
	
<style>
table {
  border-collapse: middle;
  width: 100%;
}

th, td {
  padding: 15px;
  text-align: left;
  border-bottom: 10px solid #ddd;
}
tr:hover {background-color: red ;}
</style>

