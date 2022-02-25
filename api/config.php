<?php 


//header('content-type: application/json');
//echo json_encode(['time' => time(), 'date' => date('d.m.Y'), 'tech' => 'Vercel']);

//var_dump($_POST);
// Definining Variable for Now to Check. 
// Validation needs to be added soon. 
echo $email = $_POST['email'];
echo "\n";
echo $mobile = $_POST['mobile'];

//echo "Mobile: ".$mobile."| Email: " $email;

// Calling Token EP  once when a request is made. 

$url = "https://au-api.basiq.io/token";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: application/x-www-form-urlencoded",
   "basiq-version: 3.0",
   "Authorization: Basic NzM4NDE4YjktNDdlYy00OGI2LTg5ODEtNjg0OGI3NzU2ZDczOmQ4OTVlZmUzLTcwOTMtNDdlZC1hN2NmLTVmMWFkNGJlY2MwOA==",
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
echo "\n";
echo $server_obj->access_token; 
echo "\n";

echo "\n";
echo "\n";
echo "\n";

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

$data = '{"email": '.json_encode($email).', "phone": '.json_encode($mobile).'}';

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);
$user_object = json_decode( $resp );

echo "\n";
echo $user_object->id; 
echo "\n"; 



// Calling token for Client_access EP to use it into Consent. 

$url2 = "https://au-api.basiq.io/token";

$curl11 = curl_init($url2);
curl_setopt($curl11, CURLOPT_URL, $url2);
curl_setopt($curl11, CURLOPT_POST, true);
curl_setopt($curl11, CURLOPT_RETURNTRANSFER, true);

$headers1 = array(
   "Content-Type: application/x-www-form-urlencoded",
   "basiq-version: 3.0",
   "Authorization: Basic NzM4NDE4YjktNDdlYy00OGI2LTg5ODEtNjg0OGI3NzU2ZDczOmQ4OTVlZmUzLTcwOTMtNDdlZC1hN2NmLTVmMWFkNGJlY2MwOA==",
);
curl_setopt($curl11, CURLOPT_HTTPHEADER, $headers1);
$data2 = '{"scope": "CLIENT_ACCESS"}';
curl_setopt($curl11, CURLOPT_POSTFIELDS, $data2);
//for debug only!
curl_setopt($curl11, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl11, CURLOPT_SSL_VERIFYPEER, false);

$client_token = curl_exec($curl11);
curl_close($curl11);

$client_obj = json_decode( $client_token );

echo "client token : ".$client_obj->access_token;


$redirect_url = 'https://consent.basiq.io/home?userId='.$user_object->id.'&token='.$client_obj->access_token; 

echo $redirect_url; 

header("location: ".$redirect_url. "");


?>
