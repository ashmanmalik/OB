<?php 


$u_ID = $_GET["userId"];
$_token = $_GET["token"];

?>


<script type="text/javascript">

var userID = <?php echo $u_ID; ?>; 
var token = <?php echo $_token; ?>;

	var url = "https://au-api.basiq.io/users/"+userID+"";

var xhr = new XMLHttpRequest();
xhr.open("DELETE", url);

xhr.setRequestHeader("Authorization", "Bearer "+token);

xhr.onreadystatechange = function () {
   if (xhr.readyState === 4) {
      console.log(xhr.status);
      if (xhr.status == 204)  { 
      	window.location.href = "https://ob-omega.vercel.app/api/admin_dashboard.php";
      }
      else { 
      	console.log("user already deleted");

      }
      //console.log(xhr.responseText);
   }};

xhr.send();

</script>