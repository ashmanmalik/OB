<?php 


header('content-type: application/json');
echo json_encode(['time' => time(), 'date' => date('d.m.Y'), 'tech' => 'Vercel']);

var_dump($_POST);

// Calling Token EP  once when a request is made. 

$url = "https://au-api.basiq.io/token";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: application/x-www-form-urlencoded",
   "basiq-version: 2.1",
   "Authorization: Basic OTgzMGZhNmMtYjIyMi00ZDg2LWJhMjYtNjkyZjEwNDI2ZjQ4Ojc0OTE5YWJlLWM2MDktNDJmNi04YzBhLWRjMzE5ZDA5Zjk0Nw==",
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
var_dump($server_token);

// Calling token for Client_access EP to use it into Consent. 

$url = "https://au-api.basiq.io/token";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Content-Type: application/x-www-form-urlencoded",
   "basiq-version: 2.1",
   "Authorization: Basic OTgzMGZhNmMtYjIyMi00ZDg2LWJhMjYtNjkyZjEwNDI2ZjQ4Ojc0OTE5YWJlLWM2MDktNDJmNi04YzBhLWRjMzE5ZDA5Zjk0Nw==",
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
var_dump($client_token);


// Calling user EP to generate a user using token. 

// ... 

// .. Redirecting the user to Consent.basiq.io 
// .. Redirecting back to index.html for now .. 
// .. Update the user accounts // 
// .. update the user transactions using Pagination.. 



?>