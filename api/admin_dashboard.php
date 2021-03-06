<?php 
// Calling Token EP  once when a request is made. 

$url = "https://au-api.basiq.io/token";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "basiq-version: 3.0",
   "Content-Type: application/x-www-form-urlencoded",
   "Authorization: Basic NzM4NDE4YjktNDdlYy00OGI2LTg5ODEtNjg0OGI3NzU2ZDczOjgxM2RhNDc3LTU5YjEtNDFlOS1iOGE5LWM5MzExMDRmNDI5OQ==",
   "Content-Length: 0",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$server_token = curl_exec($curl);
curl_close($curl);


$server_obj = json_decode( $server_token );


$url = "https://au-api.basiq.io/users";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Accept: application/json",
   "Authorization: Bearer $server_obj->access_token",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
//for debug only!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);


$user_object = json_decode( $resp );
$myObject = json_decode($resp, true);
$users_bucket = $myObject["data"];



// This is to create a client Access token and Action in this case is always connect

// Calling token for Client_access EP to use it into Consent. 

$url0 = "https://au-api.basiq.io/token";

$curl0 = curl_init($url0);
curl_setopt($curl0, CURLOPT_URL, $url0);
curl_setopt($curl0, CURLOPT_POST, true);
curl_setopt($curl0, CURLOPT_RETURNTRANSFER, true);

$headers0 = array(
   "Content-Type: application/json",
   "Authorization: Basic NzM4NDE4YjktNDdlYy00OGI2LTg5ODEtNjg0OGI3NzU2ZDczOjgxM2RhNDc3LTU5YjEtNDFlOS1iOGE5LWM5MzExMDRmNDI5OQ==",
   "basiq-version: 3.0",
);
curl_setopt($curl0, CURLOPT_HTTPHEADER, $headers0);
$data0 = '{"scope": "CLIENT_ACCESS", "userId": '.json_encode($myObject["data"][0]["id"]).'}';
curl_setopt($curl0, CURLOPT_POSTFIELDS, $data0);

//for debug only!
curl_setopt($curl0, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl0, CURLOPT_SSL_VERIFYPEER, false);

$client_token = curl_exec($curl0);
curl_close($curl0);
//var_dump($client_token);


$client_obj = json_decode( $client_token );


// 


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title> Pie Chart from Data </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/searchpanes/2.0.0/css/searchPanes.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.4/css/select.dataTables.min.css">

  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/searchpanes/2.0.0/js/dataTables.searchPanes.min.js"></script>
<script src="https://cdn.datatables.net/select/1.3.4/js/dataTables.select.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
    // Create DataTable
    var table = $('#example').DataTable({
        dom: 'Pfrtip',
    });
    //table.ajax.reload();
 
    // Create the chart with initial data
    var container = $('<div/>').insertBefore(table.table().container());
 
    var chart = Highcharts.chart(container[0], {
        chart: {
            type: 'pie',
        },
        title: {
            text: 'Users on Basiq Dashboard',
        },
        series: [
            {
                data: chartData(table),
            },
        ],
    });
 
    // On each draw, update the data in the chart
    table.on('draw', function () {
        chart.series[0].setData(chartData(table));
    });
});
 
function chartData(table) {
    var counts = {};
 
    // Count the number of entries for each position
    table
        .column(1, { search: 'applied' })
        .data()
        .each(function (val) {
            if (counts[val]) {
                counts[val] += 1;
            } else {
                counts[val] = 1;
            }
        });
 
    // And map it to the format highcharts uses
    return $.map(counts, function (val, key) {
        return {
            name: key,
            y: val,
        };
    });
}
</script>
</head>
<body>

<div class="container">
  <table id="example"
  data-mobile-responsive="true"
 class="display" style="width:100%">
        <thead>
            <tr>
                <th>id</th>
                <th>email</th>
                <th>mobile</th>
                <th>createdTime</th>
                <th>actions</th>
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
              <td> <a href="https://consent.basiq.io/home?userId=<?php echo $item["id"]; ?>&token=<?php echo $client_obj->access_token; ?>&action=connect" > Connect </a> | <a href="listaccounts.php?userId=<?php echo $item["id"]; ?>&token=<?php echo $server_obj->access_token ?>"> View accounts </a> | <a id="deletingdata" href="delete.php?userId=<?php echo $item["id"]; ?>&token=<?php echo $server_obj->access_token ?>"> Delete </a></td>
            </tr>
          <?php endforeach; 

          ?>
        </tbody>
        <tfoot>
            <tr>
                <th>id</th>
                <th>email</th>
                <th>mobile</th>
                <th>createdTime</th>
                <th>actions</th>
            </tr>
        </tfoot>
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
