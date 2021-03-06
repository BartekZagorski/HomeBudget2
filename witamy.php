<?php
session_start();

if (!isset($_SESSION['successfulRegistration'])) {
    header('Location: index.php');
    exit();
}
else {
    unset($_SESSION['successfulRegistration']);
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>HomeBudget.logowanie</title>
    <meta name="description" content="Program pomagający zapanować nad finansami domowymi">
	<meta name="keywords" content="finanse, budżet, pieniądze, bilans, saldo, wydatki, przychody, zakupy, oszczędności">
	<meta name="author" content="Bartłomiej Zagórski">
    <meta http-equiv="X-Ua-Compatible" content="IE=edge">
	
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/main.css">
	<link rel="stylesheet" href="./css/fontello.css">
	<link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400&display=swap" rel="preload" as="style">
    <link href="https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@400&display=swap" rel="stylesheet">  
	<!--[if lt IE 9]>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
	<![endif]-->
</head>
<body>
    <header>
        <div class="container-fluid">
            <div class="row" style="min-height: 131px;">
                <div class="col py-2 bg-primary">
                    <h1 class="text-capitalize text-light text-center mb-0">
                        <a href="index.php" id="logo"><i class="icon-home brand"></i><strong>HomeBudget</strong></a>
                    </h1>
                    <p class="small text-center my-0">
                        Pieniądze to nie wszystko, ale wszystko bez pieniędzy to nic.
                    </p>
                </div>
            </div>
        </div>
    </header>
    <main>
        <article id="main-content" class="py-3 height">
            <div class="container">
                <div class="row align-items-start justify-content-center">
                    <div class="col-md-8 mx-auto py-4">
                        <div class="card border-primary">
                            <div class="card-header bg-primary py-2 text-light text-center ">
                                <h3 class="h5 m-0">Witamy!</h3>
                            </div>
                            <div class="card-body border-primary py-3">
                                <p class="mb-4 mt-2 text-center">Rejestracja przebiegła pomyślnie. Możesz teraz przejść do logowania.</p>
                                <a href="logowanie.php" class="btn btn-success py-2 my-1 btn-block"><i class="icon-login mr-2"></i>Zaloguj się</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </article>
    </main>

    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>

</body>
</html>