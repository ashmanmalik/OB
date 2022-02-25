<?php 


header('content-type: application/json');
echo json_encode(['time' => time(), 'date' => date('d.m.Y'), 'tech' => 'Vercel']);

var_dump($_POST);
// Definining Variable for Now to Check. 
// Validation needs to be added soon. 
$mobile = json_decode( $_POST['mobile'] );
$email = json_decode( $_POST['name'] );

echo "Mobile: ".$mobile."| Email: " $email;

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

echo "Server token : ".$server_obj->access_token; 

// Calling token for Client_access EP to use it into Consent. 

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
$data = '{"scope": "CLIENT_ACCESS"}';
curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$client_token = curl_exec($curl);
curl_close($curl);

$client_obj = json_decode( $server_token );


echo "client token : ".$server_obj->access_token;


// Calling user EP to generate a user using token. 



// ... 

// .. Redirecting the user to Consent.basiq.io 
// .. Redirecting back to index.html for now .. 
// .. Update the user accounts // 
// .. update the user transactions using Pagination.. 



?>