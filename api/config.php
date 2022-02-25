<?php 


header('content-type: application/json');
echo json_encode(['time' => time(), 'date' => date('d.m.Y'), 'tech' => 'Vercel']);

$_mo =  $_POST['mobile']; 
$_email = $_POST['email'];

if ($_mo == "" || $_email == "") { 
	echo "The mobile number or email was empty, please try again";
	header('./index.html');
	exit; 
} else { 
	echo $_m; 
	echo " "; 
	echo $_email;

}

?>