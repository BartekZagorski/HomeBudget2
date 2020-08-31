<?php
require_once "dbconnect.php";

$query = $dbConnection->prepare('SELECT name FROM `incomes_cattegories_assigned_to_users` WHERE user_id = :loggedID');
$query -> bindValue(':loggedID', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$query -> execute();

$incomesCattegories = $query -> fetchAll();

echo '<option value="" disabled selected hidden>Wybierz Kategorię</option>"';
$iter = 1;
foreach ($incomesCattegories as $inCat)
{
    echo PHP_EOL.'<option value="'.$iter++.'">'.$inCat['name'].'</option>';
}
?>