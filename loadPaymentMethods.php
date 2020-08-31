<?php
require_once "dbconnect.php";

$query = $dbConnection->prepare('SELECT name FROM `payment_method_assigned_to_user` WHERE user_id = :loggedID');
$query -> bindValue(':loggedID', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
$query -> execute();

$paymentMethods = $query -> fetchAll();

echo '<option value="" disabled selected hidden>Wybierz Sposób Płatności</option>';
$iter = 1;
foreach ($paymentMethods as $payMet)
{
    echo PHP_EOL.'<option value="'.$iter++.'">'.$payMet['name'].'</option>';
}
?>