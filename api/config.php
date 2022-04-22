<?php 

session_start(); 
ob_start(); 

 $api_Key = "NzM4NDE4YjktNDdlYy00OGI2LTg5ODEtNjg0OGI3NzU2ZDczOmEyOTA0YjcyLTc0ZjctNDIxOC04ZmIxLTYwZWRmZmEwYjU0Mw=="; 
//$api_Key = "YjZmMTY2NjYtYzc4Yy00YmY4LTliOGYtMjZkZGFiNmNmMGU4OmE2ODA3NjBkLTE0MzItNDg0NS04MmEzLTNjNzJhMzg4NzU0NQ=="; 
// Validation needs to be added at some point here. (Server side Scripting)

if (!empty($_POST['email'])) {
   $email = $_POST['email'];
}

if (!empty($_POST['mobile'])) {
   $mobile = "+".$_POST['mobile'];
}


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

//Print the array in a simple JSON format
echo '<pre>';
echo json_encode($server_token, JSON_PRETTY_PRINT);
echo '</pre>';

// Calling user EP to generate a user using token. 

$urls = "https://au-api.basiq.io/users";

$curls = curl_init($urls);
curl_setopt($curls, CURLOPT_URL, $urls);
curl_setopt($curls, CURLOPT_POST, true);
curl_setopt($curls, CURLOPT_RETURNTRANSFER, true);

$headerss = array(
   "Authorization: Bearer {$server_obj->access_token}",
   "Content-Type: application/json",
);
curl_setopt($curls, CURLOPT_HTTPHEADER, $headerss);

$datas = '{"email": '.json_encode($email).', "mobile": '.json_encode($mobile).'}';

// var_dump($datas);


curl_setopt($curls, CURLOPT_POSTFIELDS, $datas);

//for debug only!
curl_setopt($curls, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curls, CURLOPT_SSL_VERIFYPEER, false);

$resps = curl_exec($curls);
curl_close($curls);

$user_object = json_decode( $resps );

// var_dump($user_object);
// exit();
// exit; 

// Calling token for Client_access EP to use it into Consent. 

$url0 = "https://au-api.basiq.io/token";

$curl0 = curl_init($url0);
curl_setopt($curl0, CURLOPT_URL, $url0);
curl_setopt($curl0, CURLOPT_POST, true);
curl_setopt($curl0, CURLOPT_RETURNTRANSFER, true);

$headers0 = array(
   "Content-Type: application/json",
   "Authorization: Basic NzM4NDE4YjktNDdlYy00OGI2LTg5ODEtNjg0OGI3NzU2ZDczOmEyOTA0YjcyLTc0ZjctNDIxOC04ZmIxLTYwZWRmZmEwYjU0Mw==",
   "basiq-version: 3.0",
);
curl_setopt($curl0, CURLOPT_HTTPHEADER, $headers0);
$data0 = '{"scope": "CLIENT_ACCESS", "userId": '.json_encode($user_object->id).'}';
curl_setopt($curl0, CURLOPT_POSTFIELDS, $data0);

//for debug only!
curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);

$client_token = curl_exec($curl0);
curl_close($curl0);
//var_dump($client_token);


$client_obj = json_decode( $client_token );


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

<script type="text/javascript">
	var client_access_token = <?php echo json_encode($client_obj->access_token); ?>;
	var user_id = <?php echo json_encode($user_object->id); ?>;
	var sos = <?php echo json_encode($server_obj->access_token); ?>;

	sessionStorage.setItem("userId", user_id);
	sessionStorage.setItem("clientToken", client_access_token);
	sessionStorage.setItem("serverToken", sos);
</script>


