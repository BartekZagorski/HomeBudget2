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
require_once "headerAndNavbar.php"; 
?> 

    <main>
        <article id="main-content" class="py-5 height-navbar">
            <?php
            if (isset($_SESSION['actionDone']))
            {
            echo
                '<div class="container">
                    <div class="row align-items-start justify-content-center">
                        <div class="col-sm-7 col-md-6 col-lg-5 col-xl-4 mx-auto py-4">
                            <div class="card border-primary">
                                <div class="card-header bg-primary py-2 text-light text-center ">
                                    <h3 class="h5 m-0">Sukces!</h3>
                                </div>
                                <div class="card-body border-primary py-3">';
                                    if ($_SESSION['actionDone']==="addIncome")
                                    {
                                        echo '<p class="mt-1 mb-2 text-center">Przychód dodano pomyślnie.</p>';
                                    }
                                    else
                                    {
                                        echo '<p class="mt-1 mb-2 text-center">Wydatek dodano pomyślnie.</p>';
                                    }
                                    echo
                                    '<div class="d-flex justify-content-center">
                                        <a href="menuGlowne.php" class="btn btn-success pt-2 pb-1 px-4 my-1"><i class="icon-plus-circled mr-1"></i>OK</a>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            unset($_SESSION['actionDone']);
            }
            ?>
        </article>
    </main>

    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="./js/bootstrap.bundle.min.js"></script>


</body>
</html>