<?php 

session_start();
ob_start(); 

$api_Key = "NzM4NDE4YjktNDdlYy00OGI2LTg5ODEtNjg0OGI3NzU2ZDczOmQ4OTVlZmUzLTcwOTMtNDdlZC1hN2NmLTVmMWFkNGJlY2MwOA=="; 
// Validation needs to be added at some point here. (Server side Scripting)
$email = $_POST['email'];
$mobile = "+".$_POST['mobile'];

// Calling Token EP  once when a request is made. 
$url = "https://au-api.basiq.io/token";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Need to Store the API key in the database. 

$headers = array(
   "Content-Type: application/x-www-form-urlencoded",
   "basiq-version: 3.0",
   "Authorization: Basic {$api_Key}",
   "Content-Length: 0",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$data = '{"scope": "SERVER_ACCESS"}';
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$server_token = curl_exec($curl);
curl_close($curl);

$server_obj = json_decode( $server_token );

// Calling user EP to generate a user using token. 

$url = "https://au-api.basiq.io/users";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Authorization: Bearer {$server_obj->access_token}",
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

$data = '{"email": '.json_encode($email).', "mobile": '.json_encode($mobile).'}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
$user_object = json_decode( $resp );

// Calling token for Client_access EP to use it into Consent. 

$url0 = "https://au-api.basiq.io/token";

$curl0 = curl_init($url0);
curl_setopt($curl0, CURLOPT_URL, $url0);
curl_setopt($curl0, CURLOPT_POST, true);
curl_setopt($curl0, CURLOPT_RETURNTRANSFER, true);

$headers0 = array(
   "Content-Type: application/json",
   "Authorization: Basic NzM4NDE4YjktNDdlYy00OGI2LTg5ODEtNjg0OGI3NzU2ZDczOjljZDM1Yjc1LTc3ZGYtNDVkMC1hMjVlLTEwOGQ5Y2U0NzdlNA==",
   "basiq-version: 3.0",
);
curl_setopt($curl0, CURLOPT_HTTPHEADER, $headers0);

$data0 = '{"scope": "CLIENT_ACCESS", "userId": $user_object->id}';

curl_setopt($curl0, CURLOPT_POSTFIELDS, $data0);

//for debug only!
curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);

$client_token = curl_exec($curl0);
curl_close($curl0);
var_dump($client_token);


$client_obj = json_decode( $client_token );

echo $client_obj->access_token;
exit;

?> 

<?php
$redirect_url = 'https://consent.basiq.io/home?userId='.$user_object->id.'&token='.$client_obj->access_token; 

setcookie("userId", $user_object->id , time() + 3600);
setcookie("clientToken", $client_obj->access_token , time() + 3600);
setcookie("serverToken", $server_obj->access_token , time() + 3600);

header('Access-Control-Allow-Origin: location: '.$redirect_url.'');
//sleep(3);
$response = new stdClass;
$response->status = "success";
$response->url = $redirect_url;
die(json_encode($response));

ob_end_flush(); 

?>


