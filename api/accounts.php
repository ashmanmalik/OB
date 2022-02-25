<!DOCTYPE html>
<html lang="en">
<head>
  <title> Accounts </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<style>
.container {
  height: 200px;
  position: relative;
  border: 3px solid green;
}

.vertical-center {
  margin: 0;
  position: absolute;
  top: 50%;
  -ms-transform: translateY(-50%);
  transform: translateY(-50%);
}
</style>

<div class="container">
  <div class="vertical-center">
	  <button onclick="window.location='https://consent.basiq.io/home'" type="submit" class="btn btn-primary">Connect Another Bank Account</button>
	  <p>&nbsp;</p>
	  <button type="submit" class="btn btn-success">I have disclosed All Accounts</button>    
  </div>
</div>

</body>
</html>
