
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

//Notify the browser about the type of the file using header function
//header('Content-type: text/javascript');

//Print the array in a simple JSON format
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
  <h2>Accounts</h2>
  <p> Congratulations! The below are the accounts which BASIQ has fetched! to view transactions for each account click on the below </p>  
  
  <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Account names.." title="Type in a name">
  
  <table id="myTable" class="table">
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
            <?php  if ($item["class"]["type"] == "transaction" ) {  ?>
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
function myFunction() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
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



<!---->