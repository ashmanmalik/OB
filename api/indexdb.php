
<?php 
// https://ashmanmalik.github.io/portifolio/assets/data-1646700991936.csv
// Converting csv to JSON and reading data...

$url = 'https://ashmanmalik.github.io/portifolio/data.json';
$json = file_get_contents($url);
$data = json_decode($json);

var_dump($data[0]);

echo "<p>&nbsp;</p>";
var_dump($data["location_formatted_address"]);



exit();
exit; 

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


	$myObject = json_decode($resp, true);
	$transaction_data = $myObject["data"];
	$enrich_data = $myObject["data"]; 
	for ($i=0; $i<500; $i++) {
	  if ($enrich_data[$i]["enrich"]["location"]) { 
	   //  if($enrich_data[$i]["enrich"]["location"]["geometry"]) {
	   //  	if ($enrich_data[$i]["enrich"]["location"]["geometry"]["lat"] != "" && $enrich_data[$i]["enrich"]["location"]["geometry"]["lng"] != "") { 
				// $lat = $enrich_data[$i]["enrich"]["location"]["geometry"]["lat"];
		  //   	$lon = $enrich_data[$i]["enrich"]["location"]["geometry"]["lng"];
		  //   	$planes[] = array("test", $lat, $lon);
		      	

	   //  	}
	   //  }
	echo '<pre>';
    echo json_encode($enrich_data[$i]["enrich"], JSON_PRETTY_PRINT);
    echo '</pre>';
	  }

	}
	//echo json_encode($planes);
	$enriched_url = "indexdb.php?accountno=".$_GET['accountno']."&user=".$_GET['user']."&token=".$_GET["token"];
	exit;
?>
<!DOCTYPE html>
<html>
<head>
    <title> Simple Map </title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://d19vzq90twjlae.cloudfront.net/leaflet-0.7/leaflet.css" />
    <style type="text/css">
    	#refreshButton {
		  position: absolute;
		  top: 20px;
		  right: 20px;
		  padding: 10px;
		  z-index: 400;
		}
    </style>
</head>
<body>

    <div id="map" style=" height: 1000px"></div>
    <a id="refreshButton" href="<?php echo $enriched_url; ?>"> Convert Addresses to Lat Long </a>

    <script src="https://d19vzq90twjlae.cloudfront.net/leaflet-0.7/leaflet.js">
    </script>

    <script>
    var planes = <?php echo json_encode($planes); ?>; 
	
    // //var planes = [
    // ["abc", "-33.899629","151.0656538"],
    // ["xyz", "-28.0291428","153.4337534"],
    // ]; 
	
	// //var planes = [
	// 	["7C6B07",-40.99497,174.50808],
	// 	["7C6B38",-41.30269,173.63696],
	// 	["7C6CA1",-41.49413,173.5421],
	// 	["7C6CA2",-40.98585,174.50659],
	// 	["C81D9D",-40.93163,173.81726],
	// 	["C82009",-41.5183,174.78081],
	// 	["C82081",-41.42079,173.5783],
	// 	["C820AB",-42.08414,173.96632],
	// 	["C820B6",-41.51285,173.53274]
	// 	];

        var map = L.map('map').setView([-33.899629, 151.0656538], 8);
        mapLink = 
            '<a href="https://openstreetmap.org">OpenStreetMap</a>';
        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; ' + mapLink + ' Contributors',
            maxZoom: 18,
            }).addTo(map);

		for (var i = 0; i < planes.length; i++) {
			marker = new L.marker([planes[i][1],planes[i][2]])
				.bindPopup(planes[i][0])
				.addTo(map);
		}
// require_once __DIR__ . '/../vendor/autoload.php';

// Tracy\Debugger::enable(Tracy\Debugger::DEVELOPMENT);

// throw new RuntimeException('Hello Tracy!');
               
    </script>
</body>
</html>
