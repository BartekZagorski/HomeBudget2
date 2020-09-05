<?php
require_once "dbconnect.php";

$query = $dbConnection->prepare('SELECT name FROM `incomes_cattegories_assigned_to_users` WHERE user_id = :loggedID');
$query -> bindValue(':loggedID', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$query -> execute();

$incomesCattegories = $query -> fetchAll();

echo '<option value="" disabled selected hidden>Wybierz Kategorię</option>"';
foreach ($incomesCattegories as $inCat)
{
    if (isset($_SESSION['allTestsPassed']) && isset($_SESSION['chosenCattegory']) && $_SESSION['chosenCattegory'] == $inCat['name'])
    echo PHP_EOL.'<option value="'.$inCat['name'].'" selected>'.$inCat['name'].'</option>';
    else
    echo PHP_EOL.'<option value="'.$inCat['name'].'">'.$inCat['name'].'</option>';
}
?>