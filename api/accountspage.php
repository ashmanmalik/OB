<?php 


session_start();

$cltkn = $_SESSION["client_access_token"];
$svr = $_SESSION["server_access_token"];
$usr = $_SESSION["user"]; 

// Call Accounts API and populate the lists below ...

$url = "https://consent.basiq.io/home?userId=".$usr."&token=".$cltkn;

$svrurl = "listaccounts.php?userId=".$usr."&token=".$svr;

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title> Accounts </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>


<div class="container">
    <div class="row h-100">
        <div class="col-sm-12 my-auto">
            <div class="card card-block w-25 mx-auto" style="top:350px;">
            <button onclick="window.location='<?php echo $url; ?>'" type="submit" class="btn btn-primary">Connect Another Bank Account</button>
	  <p>&nbsp;</p>
	  <button onclick="window.location='<?php echo $svrurl; ?>'" type="submit" class="btn btn-success">I have disclosed All Accounts</button> 
	        </div>
        </div>
    </div>
</div>


</body>
</html>
