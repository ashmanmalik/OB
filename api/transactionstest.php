
<?php 


$url = "https://au-api.basiq.io/users/89fe0b3d-e992-4fb7-9d26-0b522cb88378/transactions";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Accept: application/json",
   "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJwYXJ0bmVyaWQiOiI0MzhjYWUxNS03YzE4LTRiYmYtYjg1ZS01NTZiNDlkZDUyNTkiLCJhcHBsaWNhdGlvbmlkIjoiNzM4NDE4YjktNDdlYy00OGI2LTg5ODEtNjg0OGI3NzU2ZDczIiwic2NvcGUiOiJTRVJWRVJfQUNDRVNTIiwic2FuZGJveF9hY2NvdW50IjpmYWxzZSwiY29ubmVjdF9zdGF0ZW1lbnRzIjp0cnVlLCJlbnJpY2giOiJwYWlkIiwiZW5yaWNoX2FwaV9rZXkiOiJuRlpYZXJHcEY3N2Vvd010ZG92Z2phWE9iZmdvdDM0OTE3Unc4aGlaIiwiZW5yaWNoX2VudGl0eSI6dHJ1ZSwiZW5yaWNoX2xvY2F0aW9uIjp0cnVlLCJlbnJpY2hfY2F0ZWdvcnkiOnRydWUsImFmZm9yZGFiaWxpdHkiOiJwYWlkIiwiaW5jb21lIjoicGFpZCIsImV4cGVuc2VzIjoicGFpZCIsImV4cCI6MTY0NjAyNDU2NSwiaWF0IjoxNjQ2MDIwOTY1LCJ2ZXJzaW9uIjoiMy4wIiwiZGVuaWVkX3Blcm1pc3Npb25zIjpbXX0.nfgFsm-O98mnnuErubSCVuIRm0Q9zkFLGqwMhzRl-vo",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

$accounts = json_decode( $resp );

// //Notify the browser about the type of the file using header function
// //header('Content-type: text/javascript');

// //Print the array in a simple JSON format

// echo '<pre>';
// echo json_encode($accounts, JSON_PRETTY_PRINT);
// echo '</pre>';

?>
<?php
    $myObject = json_decode($resp, true);
    $transaction_data = $myObject["data"];
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title> Transactions </title>
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

</head>
<body>

<div class="container">
  <h2> <button onclick="window.location='accountspage.php'" type="submit" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </button> Transactions <i class="fa fa-university" aria-hidden="true"></i></h2>
  <p> Congratulations! Below are all your transactions </p>            
 
  
<table
  id="myTable"
  data-show-columns="true"
  data-search="true"
  data-mobile-responsive="true"
  data-check-on-init="true"> 
    <thead>
      <tr>
        <th> Date </th>
        <th> Description </th>
        <th> status </th>
        <th> amount </th>
        <th> balance </th>
        <th> RoundUps </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($transaction_data as $key => $item): 
      
      ?>
        <tr>
            <?php 
	 		    $count = 0;
	 		    function round_up ( $value, $precision ) { 
				    $pow = pow ( 10, $precision ); 
				    return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow; 
				} 
	 		    //$final = ceil(round($item["balance"], 2)) - round($item["balance"], 2); 
				//$count += $final; 
	            $krr = explode('T', $item["postDate"]);
             ?>
          <td><?PHP echo $krr[0]; ?></td>
          <td><?PHP echo $item["description"]; ?></td>
          <td><?PHP echo $item["status"]; ?></td>
          <td><?PHP echo $item["amount"]; ?></td>
          <td><?PHP echo $item["balance"]; ?></td>
          <td><?PHP echo $round_up($item["balance"], 2); ?></td>
          
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script>

  $(function() {
    $('#myTable').bootstrapTable()
  })

</script>
</body>
</html>


