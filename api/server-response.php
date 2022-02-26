
<?php 


$url = "https://au-api.basiq.io/users/".$_GET['userId']."/accounts";

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

//Notify the browser about the type of the file using header function
//header('Content-type: text/javascript');

echo json_encode($accounts, JSON_PRETTY_PRINT);

?>