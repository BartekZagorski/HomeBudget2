<?php
require_once "dbconnect.php";

$query = $dbConnection->prepare('SELECT name FROM `expenses_cattegories_assigned_to_users` WHERE user_id = :loggedID');
$query -> bindValue(':loggedID', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$query -> execute();

$expensesCattegories = $query -> fetchAll();

echo '<option value="" disabled selected hidden>Wybierz Kategorię</option>"';
foreach ($expensesCattegories as $exCat)
{
    if (isset($_SESSION['allTestsPassed']) && isset($_SESSION['chosenCattegory']) && $_SESSION['chosenCattegory'] == $exCat['name'])
    echo PHP_EOL.'<option value="'.$exCat['name'].'" selected>'.$exCat['name'].'</option>';
    else
    echo PHP_EOL.'<option value="'.$exCat['name'].'">'.$exCat['name'].'</option>';
}
?>