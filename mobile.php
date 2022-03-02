

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Ashman Malik">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title> Mobile Version | BASIQ Integration </title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.1.4/tailwind.min.css" />   
    <link rel="stylesheet" href="style.css" />   
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<!--     <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />
 -->
    <!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
     --><script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <style type="text/css">
        #loader {
          display: none;
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          width: 100%;
          background: rgba(0,0,0,0.75) url(loading2.gif) no-repeat center center;
          z-index: 10000;
        }
    </style>
	<style>
		body{
			  font-family: 'Mukta', sans-serif;
				height:100vh;
				min-height:550px;
				background-image: url(technology-background-1632715.jpg);
				background-repeat: no-repeat;
				background-size:cover;
				background-position:center;
				position:relative;
			    overflow-y: hidden;
			}
		 h2 { 
		 color: white;
		 } 
		 .my-5 { 
		 	background-color: rgb(4, 4, 4, 0.6);

		  }
		 #loader {
          display: none;
          position: fixed;
          top: 0;
          left: 0;
          right: 0;
          bottom: 0;
          width: 100%;
          background: rgba(0,0,0,0.75) url(loading2.gif) no-repeat center center;
          z-index: 10000;
        }
	</style>
</head>

<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
					 <div class="text-center my-5">
					 	<h2> PHP Integration with BASIQ </h2>
					</div>
					 <div class="card shadow-lg">
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Demo Project</h1>
							<form method="post"> 
								<div class="mb-3">
									<label class="mb-2 text-muted" for="email">E-Mail Address</label>
									<input id="email" type="email" class="form-control" name="email" placeholder="Email" required autofocus>
									<div class="invalid-feedback">
										Email is invalid
									</div>
								</div>

								<div class="mb-3">
									<div class="mb-2 w-100">
										<label class="text-muted" for="password">Mobile No</label>
									</div>
									<input id="password" name="mobile" placeholder="614XXXXXXXX" pattern="[0-9]{5}[0-9]{3}[0-9]{3}" class="form-control" required>
								    <div class="invalid-feedback">
								    	Mobile Number is invalid
							    	</div>
								</div>

								<div class="d-flex align-items-center">
									<button type="submit" class="btn btn-primary ms-auto">
										Connect my Bank Account
									</button>
								</div>
							</form>
						</div>
						<div class="card-footer py-3 border-0">
							<div class="text-center">
								BASIQ Integration with PHP, AJAX & JQUERY
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>

<div id="loader"></div>

<script src="https://code.jquery.com/jquery.js"></script>
 
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script>
var spinner = $('#loader');
$(function() {
  $('form').submit(function(e) {
    e.preventDefault();
    spinner.show();
    $.ajax({
      url: '/api/config.php',
      data: $(this).serialize(),
      method: 'post',
      dataType: 'JSON'
    }).done(function(resp) {
      spinner.hide();
      //alert(resp.status);
      window.location.href= resp.url;
    });
  });
});
</script>


</body>
</html>
