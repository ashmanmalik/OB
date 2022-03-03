
<?php 

$url = "https://au-api.basiq.io/users/".$_GET['user']."/transactions?filter=account.id.eq(".$_GET['accountno'].")";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$headers = array(
   "Accept: application/json",
   "Authorization: Bearer {$_GET['token']}",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

$accounts = json_decode( $resp );

// //Print the array in a simple JSON format
// echo '<pre>';
// echo json_encode($accounts, JSON_PRETTY_PRINT);
// echo '</pre>';


?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="ilmu-detil.blogspot.com">
	<title> Mapper </title>
	<!-- Bagian css -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/ilmudetil.css">
	
	<!-- Bagian js -->
	<script src='assets/js/jquery-1.10.1.min.js'></script>       
    
	<script src="assets/js/bootstrap.min.js"></script>
	<!-- akhir dari Bagian js -->
	<script src="https://maps.google.com/maps/api/js?sensor=false"></script>
	
	<script>
		
    var marker;
      function initialize() {
		  
		// Variabel untuk menyimpan informasi (desc)
		var infoWindow = new google.maps.InfoWindow;
		
		//  Variabel untuk menyimpan peta Roadmap
		var mapOptions = {
          mapTypeId: google.maps.MapTypeId.ROADMAP
        } 
		
		// Pembuatan petanya
		var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
              
        // Variabel untuk menyimpan batas kordinat
		var bounds = new google.maps.LatLngBounds();

		// Pengambilan data dari database
		<?php

   //          $query = mysqli_query($con,"select * from data_location");
			// while ($data = mysqli_fetch_array($query))
			// {
			// 	$nama = $data['desc'];
			// 	$lat = $data['lat'];
			// 	$lon = $data['lon'];
				
			// 	echo ("addMarker($lat, $lon, '<b>$nama</b>');\n");                        
			// }

			$myObject = json_decode($resp, true);
			$transaction_data = $myObject["data"];

			$enrich_data = $myObject["data"]; 
			for ($i=0; $i<500; $i++) {
			  if ($enrich_data[$i]["enrich"]["location"]) { 
			    if($enrich_data[$i]["enrich"]["location"]["geometry"]) {

			    $lat = $enrich_data[$i]["enrich"]["location"]["geometry"]["lat"];
			    $lon = $enrich_data[$i]["enrich"]["location"]["geometry"]["lng"];
			    // echo '<pre>';
			    // echo json_encode($enrich_data[$i]["enrich"]["location"]["geometry"], JSON_PRETTY_PRINT);
			    // echo '</pre>';
			    echo ("addMarker($lat, $lon, '<b>$nama</b>');\n");

			    }
			  }
			}
          ?>
		  
		// Proses membuat marker 
		function addMarker(lat, lng, info) {
			var lokasi = new google.maps.LatLng(lat, lng);
			bounds.extend(lokasi);
			var marker = new google.maps.Marker({
				map: map,
				position: lokasi
			});       
			map.fitBounds(bounds);
			bindInfoWindow(marker, map, infoWindow, info);
		 }
		
		// Menampilkan informasi pada masing-masing marker yang diklik
        function bindInfoWindow(marker, map, infoWindow, html) {
          google.maps.event.addListener(marker, 'click', function() {
            infoWindow.setContent(html);
            infoWindow.open(map, marker);
          });
        }
 
        }
      google.maps.event.addDomListener(window, 'load', initialize);
    
	</script>
	
</head>
<body onload="initialize()">
<div class="container" style="margin-top:10px">	
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-default">g
					<div class="panel-body">
						<div id="map-canvas" style="width: 700px; height: 600px;"></div>
					</div>
			</div>
		</div>	
	</div>
</div>	
</body>
</html>
