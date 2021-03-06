<?php
    session_start();

    if (isset($_SESSION['loggedInUserId'])) {
        header('Location: menuGlowne.php');
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
        <article id="main-content" class="py-5 height">
            <div class="container">
                <div class="row align-items-start justify-content-center">
                    <div class="col-lg-10 bg-primary rounded">
                        <h2 class="h6 text-light py-3 my-2 line-height">
                            Witaj w <i class="icon-home small-brand"></i><strong>HomeBudget</strong> - aplikacji, która pomoże Ci zapanować nad domowymi finansami.
                        </h2>
                        <p class="text-justify mb-1 line-height">Masz problem z organizacją swoich finansów?</p>
                            <p class="text-justify mb-1 line-height">Nie wiesz czy w danym okresie wychodzisz na plus czy na minus?</p>
                            <p class="text-justify line-height">Gubisz się w swoich przychodach i wydatkach?</p>
                            <p class="text-white text-justify mb-3">Skoro tak to ta aplikacja jest właśnie dla Ciebie. Dzięki Home Budget planowanie, organizacja, ewidencjonowanie swoich pieniędzy już nigdy nie będzie problemem, a Ty staniesz się mistrzem zarządzania!</p>
                    </div>
                    <div class="col-lg-10">
                        <div class="row align-items-start py-3">
                            <div class="col-sm-6 mx-auto my-3">
                                <p class="text-center text-light mb-1 my-2">
                                    Masz już konto?
                                </p>
                                <a href="logowanie.php" class="btn btn-success py-3 btn-block"><i class="icon-login mr-2"></i>Zaloguj się</a>
                            </div>
                            <div class="col-sm-6 mx-auto my-3">
                                <p class="text-center text-light mb-1 my-2">
                                    Jesteś nowym użytkownikiem?
                                </p>
                                <a href="rejestracja.php" class="btn btn-danger py-3 btn-block"><i class="icon-user-plus mr-2"></i>Zarejestruj się</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </article>
    </main>

    <!-- jQuery-->
    <script src="./js/jquery-3.5.1.min.js"></script>
    <!--bootstrap js-->
    <script src="./js/bootstrap.bundle.min.js"></script>

</body>
</html>