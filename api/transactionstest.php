
<?php 


$url = "https://au-api.basiq.io/users/".$_GET["userId"]."/transactions";

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
    $transaction_data = $myObject["data"];
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title> Transactions </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css" rel="stylesheet">

<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/mobile/bootstrap-table-mobile.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js" defer></script>
<style type="text/css">
	body {margin:2em;}
tfoot tr, thead tr {
	background: light gray;
}
tfoot td {
	font-weight:bold;
}
</style>
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
      	<!-- Test one -->
        <th> Description </th>
        <th> status </th>
        <th> amount </th>
        <th> balance </th>
        <th> RoundUps </th>
      </tr>
    </thead>
    	<tfoot>
		<tr>
			<td></td>
			<td></td>
			<td>Totals</td>
			<td></td>
			<td></td>
		</tr>
	</tfoot>
    <tbody>
      <?php foreach($transaction_data as $key => $item): 
      
      ?>
        <tr>
            <?php 
	 		    $count = 0;

	 		    $final = ceil(round($item["balance"], 2)) - round($item["balance"], 2); 
				//$count += $final; 
	            $krr = explode('T', $item["postDate"]);
             ?>
          <td><?PHP echo $item["description"]; ?></td>
          <td><?PHP echo $item["status"]; ?></td>
          <td><?PHP echo $item["amount"]; ?></td>
          <td><?PHP echo $item["balance"]; ?></td>
          <td><?PHP echo round($final, 2, PHP_ROUND_HALF_UP); ?></td>
          
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
<script>
  $(document).ready(function() {
	// DataTable initialisation
	$('#myTable').DataTable(
		{
			"paging": false,
			"autoWidth": true,
			"footerCallback": function ( row, data, start, end, display ) {
				var api = this.api();
				nb_cols = api.columns().nodes().length;
				var j = 3;
				while(j < nb_cols){
					var pageTotal = api
                .column( j, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return Number(a) + Number(b);
                }, 0 );
          // Update footer
          $( api.column( j ).footer() ).html(pageTotal);
					j++;
				} 
			}
		}
	);
});

</script>
</body>
</html>


