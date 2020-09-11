<?php
$firstDayOfThisMonth = date("Y-m-01");
$lastDayOfThisMonth = date("Y-m-t");

require_once "dbconnect.php";

$incomesAccordingToCattegories = $dbConnection -> prepare('SELECT name as kategoria, SUM(amount) as przychód FROM incomes, incomes_cattegories_assigned_to_users as c WHERE incomes.user_id = :user_id AND c.id = income_cattegory_assigned_to_user_id AND date_of_income BETWEEN :begin AND :end GROUP BY income_cattegory_assigned_to_user_id ORDER BY przychód DESC');
$incomesAccordingToCattegories -> bindValue(':user_id', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$incomesAccordingToCattegories -> bindValue(':begin', $firstDayOfThisMonth, PDO::PARAM_STR);
$incomesAccordingToCattegories -> bindValue(':end', $lastDayOfThisMonth, PDO::PARAM_STR);
$incomesAccordingToCattegories -> execute();

$expensesAccordingToCattegories = $dbConnection -> prepare('SELECT name as kategoria, SUM(amount) as wydatek FROM expenses, expenses_cattegories_assigned_to_users as c WHERE expenses.user_id = :user_id AND c.id = expense_cattegory_assigned_to_user_id AND date_of_expense BETWEEN :begin AND :end GROUP BY expense_cattegory_assigned_to_user_id ORDER BY wydatek DESC');
$expensesAccordingToCattegories -> bindValue(':user_id', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$expensesAccordingToCattegories -> bindValue(':begin', $firstDayOfThisMonth, PDO::PARAM_STR);
$expensesAccordingToCattegories -> bindValue(':end', $lastDayOfThisMonth, PDO::PARAM_STR);
$expensesAccordingToCattegories -> execute();

$incomesFully = $dbConnection -> prepare('SELECT amount, name, date_of_income, income_comment FROM incomes_cattegories_assigned_to_users as c, incomes WHERE incomes.user_id = :user_id AND income_cattegory_assigned_to_user_id = c.id AND date_of_income BETWEEN :begin AND :end ORDER BY date_of_income DESC, amount DESC');
$incomesFully -> bindValue(':user_id', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$incomesFully -> bindValue(':begin', $firstDayOfThisMonth, PDO::PARAM_STR);
$incomesFully -> bindValue(':end', $lastDayOfThisMonth, PDO::PARAM_STR);
$incomesFully -> execute();

$expensesFully = $dbConnection -> prepare('SELECT amount, c.name, p.name, date_of_expense, expense_comment FROM expenses_cattegories_assigned_to_users as c, payment_method_assigned_to_user as p, expenses WHERE expenses.user_id = :user_id AND expense_cattegory_assigned_to_user_id = c.id AND payment_method_assigned_to_user_id = p.id AND date_of_expense BETWEEN :begin AND :end ORDER BY date_of_expense DESC, amount DESC');
$expensesFully -> bindValue(':user_id', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$expensesFully -> bindValue(':begin', $firstDayOfThisMonth, PDO::PARAM_STR);
$expensesFully -> bindValue(':end', $lastDayOfThisMonth, PDO::PARAM_STR);
$expensesFully -> execute();

?>