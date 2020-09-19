<?php
if (!isset($_SESSION['loggedInUserId'])) session_start();
$periodBegin = $_POST['beginDate'];
$periodEnd = $_POST['endDate'];

require_once "dbconnect.php";

$incomesAccordingToCattegories = $dbConnection -> prepare('SELECT name as kategoria, SUM(amount) as przychód FROM incomes, incomes_cattegories_assigned_to_users as c WHERE incomes.user_id = :user_id AND c.id = income_cattegory_assigned_to_user_id AND date_of_income BETWEEN :begin AND :end GROUP BY income_cattegory_assigned_to_user_id ORDER BY przychód DESC');
$incomesAccordingToCattegories -> bindValue(':user_id', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$incomesAccordingToCattegories -> bindValue(':begin', $periodBegin, PDO::PARAM_STR);
$incomesAccordingToCattegories -> bindValue(':end', $periodEnd, PDO::PARAM_STR);
$incomesAccordingToCattegories -> execute();

$expensesAccordingToCattegories = $dbConnection -> prepare('SELECT name as kategoria, SUM(amount) as wydatek FROM expenses, expenses_cattegories_assigned_to_users as c WHERE expenses.user_id = :user_id AND c.id = expense_cattegory_assigned_to_user_id AND date_of_expense BETWEEN :begin AND :end GROUP BY expense_cattegory_assigned_to_user_id ORDER BY wydatek DESC');
$expensesAccordingToCattegories -> bindValue(':user_id', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$expensesAccordingToCattegories -> bindValue(':begin', $periodBegin, PDO::PARAM_STR);
$expensesAccordingToCattegories -> bindValue(':end', $periodEnd, PDO::PARAM_STR);
$expensesAccordingToCattegories -> execute();

$incomesFully = $dbConnection -> prepare('SELECT amount, name, date_of_income, income_comment FROM incomes_cattegories_assigned_to_users as c, incomes WHERE incomes.user_id = :user_id AND income_cattegory_assigned_to_user_id = c.id AND date_of_income BETWEEN :begin AND :end ORDER BY date_of_income DESC, amount DESC');
$incomesFully -> bindValue(':user_id', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$incomesFully -> bindValue(':begin', $periodBegin, PDO::PARAM_STR);
$incomesFully -> bindValue(':end', $periodEnd, PDO::PARAM_STR);
$incomesFully -> execute();

$expensesFully = $dbConnection -> prepare('SELECT amount, c.name, p.name, date_of_expense, expense_comment FROM expenses_cattegories_assigned_to_users as c, payment_method_assigned_to_user as p, expenses WHERE expenses.user_id = :user_id AND expense_cattegory_assigned_to_user_id = c.id AND payment_method_assigned_to_user_id = p.id AND date_of_expense BETWEEN :begin AND :end ORDER BY date_of_expense DESC, amount DESC');
$expensesFully -> bindValue(':user_id', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$expensesFully -> bindValue(':begin', $periodBegin, PDO::PARAM_STR);
$expensesFully -> bindValue(':end', $periodEnd, PDO::PARAM_STR);
$expensesFully -> execute();

echo
'
    <div class="col px-0 my-2 mx-auto">
        <h2 class="h5 bg-primary text-light text-center py-2 mb-1"><i class="icon-chart-bar"></i>Przegląd bilansu z wybranego okresu </br> (od '.date('d-m-Y', strtotime($_POST['beginDate'])).' do '.date('d-m-Y', strtotime($_POST['endDate'])).')</h2>
        <div class="row p-2 m-0 border-bottom border-primary">
            <div class="col-md-8 col-lg-6 px-1 d-flex align-items-center mx-auto">
                <table class="table table-dark table-bordered table-sm table-striped text-center table-hover mb-2">
                    <thead class="bg-primary text-light">
                        <tr><th colspan="3" class="text-uppercase bg-success"> Przychody według kategorii</th></tr>';

                        $incomes = $incomesAccordingToCattegories->fetchAll();
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
                        
                echo    '</tbody>
                </table>  
            </div>
            <div class="col-md-8 col-lg-6 px-1 d-flex align-items-center mx-auto">
                <table class="table table-dark table-bordered table-sm table-striped text-center table-hover mb-2">
                    <thead class="bg-primary text-light">
                        <tr><th colspan="3" class="text-uppercase bg-success"> Wydatki według kategorii</th></tr>';
                        
                            $expenses = $expensesAccordingToCattegories->fetchAll();
                            if (empty($expenses))
                            {
                                echo '<tr><th class="font-weight-normal"> Brak wydatków w wybranym okresie !</th></tr>
                                </thead>';
                            }
                            else
                            {
                                echo '<tr><th>Lp.</th><th>Kategoria</th><th>Kwota</th></tr>
                                </thead>
                                <tbody id="expenses-according-to-cattegories">';
                                $iter = 1;
                                $sum = 0;
                                foreach ($expenses as $expense)
                                {
                                    echo "<tr><td>".$iter++.".</td><td>{$expense["kategoria"]}</td><td>{$expense["wydatek"]}</td></tr>";
                                    $sum+=$expense["wydatek"];
                                }
                                echo "<tr><td>suma:</td><td></td><td>".number_format($sum, 2)."</td></tr>";
                            }
                        
                echo    '</tbody>
                </table>  
            </div>
        
        </div>

        <div class="row p-2 m-0 border-bottom border-primary">
            <div class="col-md-10 col-lg-8 px-1 d-flex align-items-center mx-auto">
                <div class="table-responsive text-nowrap">    
                    <table class="table table-dark table-bordered table-sm table-striped text-center table-hover mb-2">
                        <thead class="bg-primary text-light">
                            <tr><th colspan="5" class="text-uppercase bg-success"> Przychody zestawienie szczegółowe</th></tr>';
                            
                            $incomes = $incomesFully->fetchAll();
                            $incomesSum = 0;
                            if (empty($incomes))
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
                                foreach ($incomes as $income)
                                {
                                    echo "<tr><td>".$iter++.".</td><td>{$income["amount"]}</td><td>{$income["name"]}</td></td><td>{$income["date_of_income"]}</td></td><td>{$income["income_comment"]}</td></tr>";
                                    $incomesSum+=$income["amount"];
                                }
                                echo "<tr><td>suma:</td><td>".number_format($incomesSum, 2)."</td><td></td><td></td><td></td></tr>";
                            }
                            
                    echo    '</tbody>
                    </table>
                </div>      
            </div>
            <div class="col-md-10 col-lg-8 px-1 d-flex align-items-center mx-auto">
                <div class="table-responsive text-nowrap">
                    <table class="table table-dark table-bordered table-sm table-striped text-center table-hover mb-2">
                        <thead class="bg-primary text-light">
                            <tr><th colspan="6" class="text-uppercase bg-success"> Wydatki zestawienie szczegółowe</th></tr>';
                            
                            $expenses = $expensesFully->fetchAll();
                            $expensesSum = 0;
                            if (empty($expenses))
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
                                foreach ($expenses as $expense)
                                {
                                    echo "<tr><td>".$iter++.".</td><td>{$expense["amount"]}</td><td>{$expense["1"]}</td><td>{$expense["2"]}</td></td><td>{$expense["date_of_expense"]}</td></td><td>{$expense["expense_comment"]}</td></tr>";
                                    $expensesSum+=$expense["amount"];
                                }
                                    echo "<tr><td>suma:</td><td>".number_format($expensesSum, 2)."</td><td></td><td></td><td></td><td></td></tr>";
                            }
                            $balance = $incomesSum - $expensesSum;
                    echo    '</tbody>
                    </table>
                </div> 
            </div>
        
        </div>
        <div class="row p-2 m-0 border-bottom border-primary">
            <div class="col-md-10 col-lg-8 px-1 mx-auto">
                <div>
                    <p class="bg-success h3 text-light pt-2 pb-1 text-center text-uppercase r">Bilans: '.number_format($balance, 2).'</p>';
                    if ($balance>=0)
                        echo '<p class="bg-primary text-center text-light p-1 mb-1">Gratulacje, świetnie zarządzasz swoimi finansami!</p>';
                    else echo '<p class="bg-primary text-center text-light p-1 mb-1">Uwaga! Popadasz w długi!</p>';
            echo    '</div>
            </div>
        </div>                  
    </div>
';
?>