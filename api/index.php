
<?php 


// require_once __DIR__ . '/../vendor/autoload.php';

// // Tracy\Debugger::enable(Tracy\Debugger::DEVELOPMENT);
// // // throw new RuntimeException('Hello Tracy!');
// // Including Oden https://odan.github.io/session/v5/

// use Odan\Session\PhpSession;

// // Get all session variables
// $all = $session->all();

// var_dump($all);

// exit; 

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

	// echo '<pre>';
	// echo json_encode($enrich_data[$i]["enrich"], JSON_PRETTY_PRINT);
	// echo '</pre>'; 

	    if($enrich_data[$i]["enrich"]["location"]["geometry"]) {
	    	if ($enrich_data[$i]["enrich"]["location"]["geometry"]["lat"] != "" && $enrich_data[$i]["enrich"]["location"]["geometry"]["lng"] != "") { 
				$lat = $enrich_data[$i]["enrich"]["location"]["geometry"]["lat"];
		    	$lon = $enrich_data[$i]["enrich"]["location"]["geometry"]["lng"];
		    	$businessName = $enrich_data[$i]["enrich"]["merchant"]["businessName"];
		    	$planes[] = array($businessName, $lat, $lon);

	    	}
	    }

	  }

	}
	//echo json_encode($planes);
	$enriched_url = "indexdb.php?accountno=".$_GET['accountno']."&user=".$_GET['user']."&token=".$_GET["token"];
?>
<!DOCTYPE html>
<html>
<head>
    <title> Transactions Enriched Map </title>
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
    <script src="https://d19vzq90twjlae.cloudfront.net/leaflet-0.7/leaflet.js"></script>
    <script>
    var planes = <?php echo json_encode($planes); ?>; 

        var map = L.map('map').setView([-33.899629, 151.0656538], 13);
        mapLink = 
            '<a href="https://openstreetmap.org">OpenStreetMap</a>';
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
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
