<?php
    session_start();
    if (!isset($_SESSION['loggedInUserId'])) {
        header('Location: index.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>HomeBudget</title>
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

<?php    
require_once "temp.php"; 
?> 
<!-- <header>
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
    </header> -->

    <nav class="navbar navbar-light bg-light p-0 navbar-expand-lg main-navbar">
        <button type="button" class="navbar-toggler m-1 order-first" data-toggle="collapse" data-target="#navbarLinks">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse " id="navbarLinks">
            <ul class="navbar-nav mr-auto">
                <li class="navbar-item pt-2">
                    <a href="menuGlowne.php" class="nav-link active"><i class="icon-home-1 mx-1"></i>Strona Główna</a>
                </li>
                <li class="navbar-item pt-2">
                    <a href="dodajPrzychod.html" class="nav-link"><i class="icon-dollar mx-1"></i>Dodaj Przychód</a>
                </li>
                <li class="navbar-item pt-2">
                    <a href="dodajWydatek.html" class="nav-link"><i class="icon-basket mx-1"></i>Dodaj Wydatek</a>
                </li>
                <li class="navbar-item pt-2">
                    <a href="przegladajBilans.html" class="nav-link"><i class="icon-chart-bar mx-1"></i>Przeglądaj Bilans</a>
                </li>
                <li class="navbar-item pt-2">
                    <a href="ustwienia.html" class="nav-link"><i class="icon-cog mx-1"></i>Ustawienia</a>
                </li>
                <li class="navbar-item pt-2">
                    <a href="index.php" class="nav-link" id="logout-link"><i class="icon-logout mx-1"></i>Wyloguj się</a>
                </li>
            </ul>
        </div>
        <div class="navbar-item text-primary mr-3 pt-1">
            <p class="m-1 pt-2"><i class="icon-user mr-1 mb-0"></i>Zalogowany jako: 
        <?php
            echo $_SESSION['login'];
        ?>
        </p>
        </div>
    </nav>

    <main>
        <article id="main-content" class="py-5 height-navbar">

        </article>
    </main>

    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>


    <script>
            $(document).ready(function(){
                $("#logout-link").click(function()
                    {
                        $.post("logout.php")
                    });
                    });
    </script>

</body>
</html>