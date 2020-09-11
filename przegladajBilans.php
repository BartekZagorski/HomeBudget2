<?php
    session_start();
    if (!isset($_SESSION['loggedInUserId'])) {
        header('Location: index.php');
        exit();
    }


    require_once "browseStatementOfCurrentMonth.php";

    $incomes = $incomesAccordingToCattegories->fetchAll();
    $expenses = $expensesAccordingToCattegories->fetchAll();
    $incomesAll = $incomesFully->fetchAll();
    $expensesAll = $expensesFully->fetchAll();
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
            <div class="container">
                <div class="row">
                    <div class="col px-0">
                        <div class="dropdown">
                            <button type="button" class="btn btn-success dropdown-toggle float-right" data-toggle="dropdown">
                                wybierz okres
                            </button>
                            <div class="dropdown-menu dropdown-menu-right py-0">
                                <button type="button" class="dropdown-item">Bieżący Miesiąc</button>
                                <button type="button" class="dropdown-item" id="previousMonth">Poprzedni Miesiąc</button>
                                <button type="button" class="dropdown-item">Bieżący Rok</button>
                                <button type="button" class="dropdown-item" data-toggle="modal" data-target="#choose-period">Inny okres</button>
                            </div>
                        </div>
                        
                    </div>
                </div>
             
                <div class="row" id="browseStatement">
                    <div class="col px-0 my-2 mx-auto">
                        <h2 class="h5 bg-primary text-light text-center py-2 mb-1"><i class="icon-chart-bar"></i>Przegląd bilansu z bieżącego miesiąca </br> <?= "(od ".date('01-m-Y')." do ".date('t-m-Y').")";?></h2>
                        <div class="row p-2 m-0 border-bottom border-primary">
                            <div class="col-md-8 col-lg-6 px-1 d-flex align-items-center mx-auto">
                                <table class="table table-dark table-bordered table-sm table-striped text-center table-hover mb-2">
                                    <thead class="bg-primary text-light">
                                        <tr><th colspan="3" class="text-uppercase bg-success"> Przychody według kategorii</th></tr>

                                        <?php
                                        if (empty($incomes))
                                        {
                                            echo '<tr><th class="font-weight-normal"> Brak przychodów w wybranym okresie !</th></tr>
                                            </thead>';
                                        }
                                        else
                                        {
                                            echo '<tr><th>Lp.</th><th>Kategoria</th><th>Kwota</th></tr>
                                            </thead>
                                            <tbody>';
                                        
                                            $iter = 1;
                                            $sum = 0;
                                            foreach ($incomes as $income)
                                            {
                                                echo "<tr><td>".$iter++.".</td><td>{$income["kategoria"]}</td><td>{$income["przychód"]}</td></tr>";
                                                $sum+=$income["przychód"];
                                            }
                                            echo "<tr><td>suma:</td><td></td><td>".number_format($sum, 2)."</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>  
                            </div>
                            <div class="col-md-8 col-lg-6 px-1 d-flex align-items-center mx-auto">
                                <table class="table table-dark table-bordered table-sm table-striped text-center table-hover mb-2">
                                    <thead class="bg-primary text-light">
                                        <tr><th colspan="3" class="text-uppercase bg-success"> Wydatki według kategorii</th></tr>
                                        <?php
                                            if (empty($expenses))
                                            {
                                                echo '<tr><th class="font-weight-normal"> Brak wydatków w wybranym okresie !</th></tr>
                                                </thead>';
                                            }
                                            else
                                            {
                                                echo '<tr><th>Lp.</th><th>Kategoria</th><th>Kwota</th></tr>
                                                </thead>
                                                <tbody>';
                                                $iter = 1;
                                                $sum = 0;
                                                foreach ($expenses as $expense)
                                                {
                                                    echo "<tr><td>".$iter++.".</td><td>{$expense["kategoria"]}</td><td>{$expense["wydatek"]}</td></tr>";
                                                    $sum+=$expense["wydatek"];
                                                }
                                                echo "<tr><td>suma:</td><td></td><td>".number_format($sum, 2)."</td></tr>";
                                            }
                                        ?>
                                    </tbody>
                                </table>  
                            </div>
                        
                        </div>

                        <div class="row p-2 m-0 border-bottom border-primary">
                            <div class="col-md-10 col-lg-8 px-1 d-flex align-items-center mx-auto">
                                <table class="table table-dark table-bordered table-sm table-striped text-center table-hover mb-2">
                                    <thead class="bg-primary text-light">
                                        <tr><th colspan="5" class="text-uppercase bg-success"> Przychody zestawienie szczegółowe</th></tr>
                                        <?php
                                        if (empty($incomesAll))
                                        {
                                            echo '<tr><th class="font-weight-normal"> Brak przychodów w wybranym okresie !</th></tr>
                                            </thead>';
                                        }
                                        else
                                        {
                                            echo
                                            '<tr><th scope="col">Lp.</th><th scope="col">Kwota</th><th scope="col">Kategoria</th><th scope="col">Data</th><th scope="col">Komentarz</th></tr>
                                            </thead>
                                            <tbody>';
                                        
                                            $iter = 1;
                                            $sum = 0;
                                            foreach ($incomesAll as $income)
                                            {
                                                echo "<tr><td>".$iter++.".</td><td>{$income["amount"]}</td><td>{$income["name"]}</td></td><td>{$income["date_of_income"]}</td></td><td>{$income["income_comment"]}</td></tr>";
                                                $sum+=$income["amount"];
                                            }
                                            echo "<tr><td>suma:</td><td>".number_format($sum, 2)."</td><td></td><td></td><td></td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>  
                            </div>
                            <div class="col-md-10 col-lg-8 px-1 d-flex align-items-center mx-auto">
                                <div class="table-responsive">
                                    <table class="table table-dark table-bordered table-sm table-striped text-center table-hover mb-2">
                                        <thead class="bg-primary text-light">
                                            <tr><th colspan="6" class="text-uppercase bg-success"> Wydatki zestawienie szczegółowe</th></tr>
                                            <?php
                                            if (empty($expensesAll))
                                            {
                                                echo '<tr><th class="font-weight-normal"> Brak wydatków w wybranym okresie !</th></tr>
                                                </thead>';
                                            }
                                            else
                                            {
                                            echo 
                                                '<tr><th scope="col">Lp.</th><th scope="col">Kwota</th><th scope="col">Kategoria</th><th scope="col">Metoda Płatnosci</th><th scope="col">Data</th><th scope="col">Komentarz</th></tr>
                                                </thead>
                                                <tbody>';
                                            
                                                $iter = 1;
                                                $sum = 0;
                                                foreach ($expensesAll as $expense)
                                                {
                                                    echo "<tr><td>".$iter++.".</td><td>{$expense["amount"]}</td><td>{$expense["1"]}</td><td>{$expense["2"]}</td></td><td>{$expense["date_of_expense"]}</td></td><td>{$expense["expense_comment"]}</td></tr>";
                                                    $sum+=$expense["amount"];
                                                }
                                                    echo "<tr><td>suma:</td><td>".number_format($sum, 2)."</td><td></td><td></td><td></td><td></td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div> 
                            </div>
                        
                        </div>                    

                    </div>
                </div>
            </div>
        </article>
    </main>

    <!--modal choose period-->

    <div class="modal bd-example-modal-sm fade" id="choose-period">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Wybierz okres</h3>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form>
                        <label class="control-label mb-1">Wybierz datę początkową:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text px-2"><i class="icon-calendar"></i></span>
                            </div>
                            <input type="date" name="start-date" id="start-date" class="form-control" required>
                        </div>
                        <label class="control-label mb-1">Wybierz datę końcową:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend d-flex justify-content-center">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </div>
                            <input type="date" name="end-date" id="end-date" class="form-control" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-outline-success py-1"><i class="icon-plus-circled"></i>zatwierdź</button>
                            <button type="button" class="btn btn-outline-danger py-1" data-dismiss="modal"><i class="icon-cancel-circled"></i>anuluj</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery-->
    <script src="./js/jquery-3.5.1.min.js"></script>
    <!--bootstrap js-->
    <script src="./js/bootstrap.bundle.min.js"></script>

    <script>
            $(document).ready(function(){
                $("#previousMonth").click(function()
                    {
                        $("#browseStatement").load("browseStatementOfPreviousMonth.php");
                    });
                });
    </script>

</body>
</html>