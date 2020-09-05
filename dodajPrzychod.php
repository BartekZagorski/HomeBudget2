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
    <script src="defDate.js"></script>
</head>

<body>

    <?php    
    require_once "headerAndNavbar.php"; 
    ?> 
    
    <main>
        <article id="main-content" class="py-3 height-navbar">
            <div class="container">
                <div class="row align-items-start justify-content-center">
                    <div class="col-md-8 mx-auto py-4">
                        <div class="card border-primary">
                            <div class="card-header bg-primary py-2 text-light text-center text-capitalize">
                                <h3 class="h5 m-0"><i class="icon-dollar"></i>dodaj przychód</h3>
                            </div>
                            <div class="card-body border-primary py-2">
                                <form action="addIncome.php" method="POST">
                                    <div class="input-group mt-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text px-2"><i class="icon-money"></i></span>
                                        </div>
                                        <input type="number" name="amount" id="amount" step="0.01" class="form-control" placeholder="podaj kwotę" onfocus="this.placeholder=''" onblur="this.placeholder='podaj kwotę'"
                                            <?php 
                                                if (isset($_SESSION['allTestsPassed']) && !$_SESSION['allTestsPassed'])
                                                {
                                                    echo 'value = "'.$_SESSION['given_amount'].'"';
                                                }
                                            ?>
                                        required>
                                    </div>
                                    <?php
                                        if (isset($_SESSION['error_amount']))
                                        {
                                            echo "<p class=\"mt-1 text-danger small\">{$_SESSION['error_amount']}</p>";
                                            unset($_SESSION['error_amount']);
                                        }
                                    ?>
                                    <div class="input-group mt-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text px-2"><i class="icon-calendar"></i></span>
                                        </div>
                                        <input type="date" name="date" id="date" class="form-control" required>
                                    </div>
                                    <?php
                                        if (isset($_SESSION['error_date']))
                                        {
                                            echo "<p class=\"mt-1 text-danger small\">{$_SESSION['error_date']}</p>";
                                            unset($_SESSION['error_date']);
                                        }
                                    ?>
                                    <div class="input-group mt-3">
                                        <select class="form-control" name="cattegory" required>
                                            <?php
                                            require_once "loadIncomesCattegories.php";
                                            ?>
                                        </select>
                                    </div>
                                    <?php
                                    ?>
                                    <div class="input-group mt-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text px-2"><i class="icon-edit"></i></span>
                                        </div>
                                        <input type="text" name="comment" id="comment" class="form-control" placeholder="komentarz" onfocus="this.placeholder=''" onblur="this.placeholder='komentarz'">
                                    </div>
                                    <?php
                                        if (isset($_SESSION['error_comment']))
                                        {
                                            echo "<p class=\"mt-1 text-danger small\">{$_SESSION['error_comment']}</p>";
                                            unset($_SESSION['error_comment']);
                                        }
                                    ?>
                                    <div class="d-flex justify-content-around">
                                        <button type="submit" class="btn btn-outline-success mt-3"><i class="icon-plus-circled"></i>dodaj</button>
                                        <a href="menuGlowne.php" class="btn btn-outline-danger mt-3">
                                            <i class="icon-cancel-circled"></i>anuluj
                                        </a>
                                    </div>
                                </form>
                                <?php
									if (isset($_SESSION['allTestsPassed'])) unset($_SESSION['allTestsPassed']);
								?>
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