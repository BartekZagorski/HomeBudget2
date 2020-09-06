<?php

session_start();

if(!isset($_POST['amount']))
{
    header('Location: menuGlowne.php');
    exit();
}

$_SESSION['allTestsPassed'] = true;

//amount tests

$amountGiven = number_format($_POST['amount'], 2, ".", "");

$_SESSION['given_amount'] = $amountGiven;

//check whether $amountGiven is a numeric

if (!is_numeric($amountGiven))
{
    $_SESSION['allTestsPassed'] = false;
    $_SESSION['error_amount'] = "Podana wartość nie jest liczbą";
}
//let amount take values between 0 and 999 999.99
else if ($amountGiven<0 || $amountGiven > 999999.99)
{
    $_SESSION['allTestsPassed'] = false;
    $_SESSION['error_amount'] = "Podana wartość nie jest liczbą z przedziału od 0 do 999,999.99";
}

//end of amount tests

//date tests

$dateFromPost = $_POST['date'];

$_SESSION['dateGiven'] = $dateFromPost;

function validateDate ($date, $format='Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}

if (validateDate($dateFromPost))
{
    $dateGiven = DateTime::createFromFormat('Y-m-d', $dateFromPost);

    $lastDayOfThisMonth = new DateTime('last day of this month');
    $lastDayOfThisMonth -> modify('last day of this month');

    // let day take values between 2000-01-01 and last day of current month

    if ($dateGiven < DateTime::createFromFormat('Y-m-d', '2000-01-01') || $dateGiven > $lastDayOfThisMonth)
    {
        $_SESSION['allTestsPassed'] = false;
        $_SESSION['error_date'] = "Podana data nie jest z przedziału od 01-01-2000 do ".$lastDayOfThisMonth->format('d-m-Y');
    }  
}
else
{
    $_SESSION['allTestsPassed'] = false;
    $_SESSION['error_date'] = "Podana data jest nieprawidłowa";
}

//end of date tests

//comment test

//let comment has less than or equal 100 chars

$commentGiven = $_POST['comment'];

$_SESSION['commentGiven'] = $commentGiven;

$_SESSION['chosenCattegory'] = $_POST['cattegory'];

$_SESSION['chosenMethod'] = $_POST['method'];

if (strlen($commentGiven)>100)
{
    $_SESSION['allTestsPassed'] = false;
    $_SESSION['error_comment'] = "komentarz nie może mieć nie więcej niż 100 znaków. Aktualna liczba znaków wynosi: ".strlen($commentGiven);
}

if (!$_SESSION['allTestsPassed'])
{
    header('Location: dodajWydatek.php');
    exit();
}
else
{
    unset($_SESSION['given_amount']);
    unset($_SESSION['dateGiven']);
    unset($_SESSION['chosenCattegory']);
    unset($_SESSION['commentGiven']);
    unset($_SESSION['chosenMethod']);

    require_once "dbconnect.php";

    if (empty($_POST['comment']))
    {
        $query = $dbConnection->prepare('INSERT INTO expenses SELECT NULL, :user_id, e.id, p.id, :amount, :date, NULL FROM expenses_cattegories_assigned_to_users as e, payment_method_assigned_to_user as p WHERE e.name = :cattegory AND e.user_id = :user_id2 AND p.name = :method AND p.user_id = :user_id3');
    }
    else
    {
        $query = $dbConnection->prepare('INSERT INTO expenses SELECT NULL, :user_id, e.id, p.id, :amount, :date, :comment FROM expenses_cattegories_assigned_to_users as e, payment_method_assigned_to_user as p WHERE e.name = :cattegory AND e.user_id = :user_id2 AND p.name = :method AND p.user_id = :user_id3');
        $query->bindValue(':comment', $commentGiven, PDO::PARAM_STR);
    }
        $query->bindValue(':user_id', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
        $query->bindValue(':amount', $amountGiven, PDO::PARAM_STR);
        $query->bindValue(':date', $dateFromPost, PDO::PARAM_STR);
        $query->bindValue(':cattegory', $_POST['cattegory'], PDO::PARAM_STR);
        $query->bindValue(':user_id2', $_SESSION['loggedInUserId'], PDO::PARAM_INT);
        $query->bindValue(':method', $_POST['method'], PDO::PARAM_STR);
        $query->bindValue(':user_id3', $_SESSION['loggedInUserId'], PDO::PARAM_INT);

        $query->execute();

        $_SESSION['actionDone'] = "addExpense";
        header('Location: menuGlowne.php');
        exit();
}

?>