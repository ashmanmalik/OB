
<?php 

$url = "https://au-api.basiq.io/users/".$_GET['user']."/transactions?filter=account.id.eq(".$_GET['accountno'].")";
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
echo '<pre>';
echo json_encode($accounts, JSON_PRETTY_PRINT);
echo '</pre>';

?>
<?php
    $myObject = json_decode($resp, true);
    $transaction_data = $myObject["data"];

    $enrich_data = $myObject["data"]["enrich"]["location"]["geometry"]; 
    var_dump($enrich_data);

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

<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/tableExport.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/tableexport.jquery.plugin@1.10.21/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/export/bootstrap-table-export.min.js"></script>
<style>
#toolbar {
  margin: 0;
}
</style>
</head>
<body>

<div class="container">
  <h2> <button onclick="window.location='accountspage.php'" type="submit" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Back </button> Transactions <i class="fa fa-university" aria-hidden="true"></i></h2>
  <p> Congratulations! Below are all your transactions </p>            
  
 <div id="toolbar" class="select">
  <select class="form-control">
    <option value="all">Export All</option>
    <option value="selected">Export Selected</option>
  </select>
</div>
 
<table id="table"
  data-show-export="true"
  data-pagination="true"
  data-side-pagination="server"
  data-click-to-select="true"
  data-toolbar="#toolbar"
  data-search="true"
  data-show-toggle="true"
  data-mobile-responsive="true"
  data-show-columns="true">     
    <thead>
      <tr>
        <th> Date </th>
        <th> Description </th>
        <th> status </th>
        <th> amount </th>
        <th> balance </th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($transaction_data as $key => $item): 
      
      ?>
        <tr>
            <?php 
                    $krr = explode('T', $item["postDate"]);
             ?>
          <td><?PHP echo $krr[0]; ?></td>
          <td><?PHP echo $item["description"]; ?></td>
          <td><?PHP echo $item["status"]; ?></td>
          <td><?PHP echo $item["amount"]; ?></td>
          <td><?PHP echo $item["balance"]; ?></td>
          
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script>
  var $table = $('#table')

  $(function() {
    $('#toolbar').find('select').change(function () {
      $table.bootstrapTable('destroy').bootstrapTable({
        exportDataType: $(this).val(),
        exportTypes: ['json', 'xml', 'csv', 'txt', 'sql', 'excel', 'pdf'],
        columns: [
          {
            field: 'state',
            checkbox: true,
            visible: $(this).val() === 'selected'
          },
          {
            field: 'description',
            title: 'Description'
          }, {
            field: 'status',
            title: 'Status'
          }, {
            field: 'amount',
            title: 'Amount'
          }, 
          { 
            field: 'balance',
            title: 'balance'
          }, 
        ]
      })
    }).trigger('change')
  })
</script>
</body>
</html>


