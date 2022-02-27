<?php 
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

 
// Fetch All users below: 


$url = "https://au-api.basiq.io/users";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Accept: application/json",
   "Authorization: Bearer {$server_obj->access_token}",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

$myObject = json_decode($resp, true);
$users_bucket = $myObject["data"];


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title> Users </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css" rel="stylesheet">

<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>


  <style>
    #myInput {
  background-image: url('searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}
</style>
</head>
<body>

<div class="container">
  <h2> <button onclick="window.location='../index.html'" type="submit" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </button> Users <i class="fa fa-university" aria-hidden="true"></i> (<?php echo $myObject["size"]; ?>) </h2>
      

 <table
  id="myTable"
  data-show-columns="true"
  data-search="true"
  data-mobile-responsive="true"
  data-check-on-init="true"> 
  <!--<table id="myTable" class="table">-->
    <thead>
      <tr>
        <th> Id </th>
        <th> email </th>
        <th> mobile </th>
        <th> createdTime </th>
        <th> action </th>
        
      </tr>
    </thead>
    <tbody>
      <?php foreach($users_bucket as $key => $item): 
      
      ?>
        <tr>
          <td><?PHP echo $item["id"]; ?></td>
          <td><?PHP echo $item["email"]; ?></td>
          <td><?PHP echo $item["mobile"]; ?></td>
          <td><?PHP echo $item["createdTime"]; ?></td>
          <td><a href="delete.php?userid=<?php echo $item["id"]; ?>&token=<?php echo $server_obj->access_token ?>"> delete user </a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>


<script>

  $(function() {
    $('#myTable').bootstrapTable()
  })

function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>
</body>
</html>


