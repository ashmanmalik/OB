

<?php 

$cltkn = $_COOKIE["clientToken"];
$svr = $_COOKIE["serverToken"];
$usr = $_COOKIE["userId"]; 
$job = $_GET['jobId'];

// Call Accounts API and populate the lists below ...

$url = "https://consent.basiq.io/home?userId=".$usr."&token=".$cltkn."&action=connect";
$manageUrl = "https://consent.basiq.io/home?userId=".$usr."&token=".$cltkn."&action=manage"; 
$svrurl = "listaccounts.php?userId=".$usr."&token=".$svr;
$trv_url = "transactionstest.php?userId=".$usr."&token=".$svr;

// Use the User token and generate a new token:: 

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
$data0 = '{"scope": "CLIENT_ACCESS", "userId": '.json_encode($usr).'}';
curl_setopt($curl0, CURLOPT_POSTFIELDS, $data0);

//for debug only!
curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);

$client_token = curl_exec($curl0);
curl_close($curl0);
//var_dump($client_token);


$client_obj = json_decode( $client_token );

// Need Client Token & UserID for implement the userConsent is applicable.. If Not send action=null otherwise connect..

$url = "https://au-api.basiq.io/users/".$usr."/consents";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$headers = array(
   "Accept: application/json",
   "Authorization: Bearer {$cltkn}",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

$consentObject = json_decode( $resp, true );
$CnSentObj = $consentObject["data"][0]["type"];

if ($CnSentObj == "error") { 
    $action = null; 
} else if ($CnSentObj == "consent") { 
    $action = "connect";
}

//var_dump($consentObject);


$newurl = "https://consent.basiq.io/home?userId=".$usr."&token=".$client_obj->access_token."&action=".$action;

// -- --------- -----------------  ------------------------------------------

// Retrieving a Job based on the Job id: 

$urlforjob = "https://au-api.basiq.io/jobs/".$job;

$curler = curl_init($urlforjob);
curl_setopt($curler, CURLOPT_URL, $urlforjob);
curl_setopt($curler, CURLOPT_RETURNTRANSFER, true);

$headersOne = array(
   "Accept: application/json",
   "Authorization: Bearer {$svr}",
);

curl_setopt($curler, CURLOPT_HTTPHEADER, $headersOne);
//for debug only!
curl_setopt($curler, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curler, CURLOPT_SSL_VERIFYPEER, false);

$resp_job = curl_exec($curler);
curl_close($curler);
var_dump($resp_job);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Ashman Malik">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> Mobile Version | BASIQ Integration </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.1.4/tailwind.min.css" />   
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<!--     <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />
 -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!--
    <script type="text/javascript">
        
        var client_access_token = <?php //echo json_encode($client_obj->access_token); ?>;
        sessionStorage.setItem("clientToken", client_access_token );
        var clientToken = sessionStorage.getItem("clientToken");
        console.log(clientToken); 
        //sessionStorage.clear(); // This will destroy session on Logout .. 
    </script>
-->
</head>

<body>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-sm-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                     <div class="text-center my-5">
                        <h2> Accounts & Transactions </h2>
                    </div>
                     <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <h1 class="fs-4 card-title fw-bold mb-4"> PHP Integration with BASIQ </h1>
                            <form method="post"> 
                                <div class="mb-3">
                                    <a href="<?php echo $newurl; ?>"><i class="fa fa-home"></i> Connect Another Bank Account</a>
                                </div>

                                <div class="mb-3">
                                    <a href="<?php echo $manageUrl; ?>"><i class="fa fa-home"></i> Manage Consent </a>
                                </div>


                                <div class="mb-3">
                                <a href="<?php echo $svrurl; ?>"><i class="fa fa-bars"></i> Accounts</a>
                                </div>

                                <div class="d-flex align-items-center">
                                    <a href="<?php echo $trv_url; ?>"><i class="fa fa-th-list"></i> Transactions</a>
                                </div>
                            </form>                            
                        </div>
                        <div class="card-footer py-3 border-0">
                            <div class="text-center">
                                <a href="../index.html"><i class="fa fa-home"></i> I have disclosed All my accounts </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


</body>
</html>

