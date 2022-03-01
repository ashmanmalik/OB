

<?php 

session_start();


echo $_SESSION['data'];
//Display 'data'.
echo '<script> alert(sessionStorage.getItem("data")); </script>';

exit; 
// $cltkn = $_SESSION["client_access_token"];
// $svr = $_SESSION["server_access_token"];
// $usr = $_SESSION["user"]; 


// Call Accounts API and populate the lists below ...

$url = "https://consent.basiq.io/home?userId=".$usr."&token=".$cltkn;
$svrurl = "listaccounts.php?userId=".$usr."&token=".$svr;
$trv_url = "transactionstest.php?userId=".$usr."&token=".$svr;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Ashman Malik">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> Mobile Version | BASIQ Integration </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/1.1.4/tailwind.min.css" />   
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <!-- Bootstrap Font Icon CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<!--     <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />
 -->
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
    <section class="h-100">
        <div class="container h-100">
            <div class="row justify-content-sm-center h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                     <div class="text-center my-5">
                        <h2> Accounts & Transactions </h2>
                    </div>
                     <div class="card shadow-lg">
                        <div class="card-body p-5">
                            <h1 class="fs-4 card-title fw-bold mb-4"> PHP Integration with BASIQ </h1>
                            <form method="post"> 
                                <div class="mb-3">
                                    <a href="<?php echo $url; ?>"><i class="fa fa-home"></i> Connect Another Bank Account</a>
                                </div>

                                <div class="mb-3">
                                <a href="<?php echo $svrurl; ?>"><i class="fa fa-bars"></i> Accounts</a>
                                </div>

                                <div class="d-flex align-items-center">
                                    <a href="<?php echo $trv_url; ?>"><i class="fa fa-th-list"></i> Transactions</a>
                                </div>
                            </form>                            
                        </div>
                        <div class="card-footer py-3 border-0">
                            <div class="text-center">
                                <a href="../index.html"><i class="fa fa-home"></i> I have disclosed All my accounts </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>


</body>
</html>

