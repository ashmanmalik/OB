
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

// //Print the array in a simple JSON format
// echo '<pre>';
// echo json_encode($accounts, JSON_PRETTY_PRINT);
// echo '</pre>';

?>
<?php
    $myObject = json_decode($resp, true);
    $account_data = $myObject["data"];
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title> Accounts </title>
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
  <h2> <button onclick="window.location='accountspage.php'" type="submit" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </button> Accounts <i class="fa fa-university" aria-hidden="true"></i></h2>
  <p> Congratulations! The below are the accounts which BASIQ has fetched! to view transactions for each account click on the below </p>  
 
 
 <table
  id="myTable"
  data-show-columns="true"
  data-search="true"
  data-mobile-responsive="true"
  data-check-on-init="true"> 
 
    <thead>
      <tr>
        <th> Account Name </th>
        <th> Account No </th>
        <th> Account Type </th>
        <th> Available </th>
        <th> Balance </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($account_data as $key => $item): 
      
      ?>
        <tr>
            <?php  if ($item["status"] == "available" ) {  ?>
          <td><a href="accounttransactions.php?accountno=<?PHP echo $item["id"]; ?>&user=<?php echo $_GET['userId']; ?>&token=<?php echo $_GET['token']; ?>"> <?PHP echo $item["name"]; ?> </a></td>
          <?php } else {  ?>
          <td><?PHP echo $item["name"]; ?> </td>
          <?php } ?>
          <td><?PHP echo substr_replace($item["accountNo"], str_repeat('*', strlen($item["accountNo"])-4), 0, -4); ?></td>
          <td><?PHP echo $item["class"]["type"]; ?></td>
          <td><?PHP echo $item["availableFunds"]; ?></td>
          <td><?PHP echo $item["balance"]; ?></td>
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



<!---->