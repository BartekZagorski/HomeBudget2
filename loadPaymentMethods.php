<?php
require_once "dbconnect.php";

$query = $dbConnection->prepare('SELECT name FROM `payment_method_assigned_to_user` WHERE user_id = :loggedID');
$query -> bindValue(':loggedID', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$query -> execute();

$paymentMethods = $query -> fetchAll();

echo '<option value="" disabled selected hidden>Wybierz Sposób Płatności</option>';
foreach ($paymentMethods as $payMet)
{
    if (isset($_SESSION['allTestsPassed']) && isset($_SESSION['chosenMethod']) && $_SESSION['chosenMethod'] == $payMet['name'])
    echo PHP_EOL.'<option value="'.$payMet['name'].'" selected>'.$payMet['name'].'</option>';
    else
    echo PHP_EOL.'<option value="'.$payMet['name'].'">'.$payMet['name'].'</option>';
}