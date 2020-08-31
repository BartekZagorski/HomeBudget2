<?php
require_once "dbconnect.php";

$query = $dbConnection->prepare('SELECT name FROM `expenses_cattegories_assigned_to_users` WHERE user_id = :loggedID');
$query -> bindValue(':loggedID', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$query -> execute();

$expensesCattegories = $query -> fetchAll();

echo '<option value="" disabled selected hidden>Wybierz Kategorię</option>"';
$iter = 1;
foreach ($expensesCattegories as $exCat)
{
    echo PHP_EOL.'<option value="'.$iter++.'">'.$exCat['name'].'</option>';
}
?>