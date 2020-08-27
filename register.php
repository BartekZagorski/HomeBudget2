<?php
session_start();

if (isset($_POST['email'])) {

    //echo "wyslano formularz"; - pierwszy teścik zaliczony :-D

    $_SESSION['allTestsPassed'] = true;

    //email tests

    $email = $_POST['email'];

    $emailSafe = filter_var($email, FILTER_SANITIZE_EMAIL);

    if (filter_var($emailSafe, FILTER_VALIDATE_EMAIL)==false || $emailSafe != $email)
    {
        $_SESSION['allTestsPassed'] = false;
        $_SESSION['error_email']="Podany adres email jest niepoprawny";
        $_SESSION['given_email'] = $email;
    }

    //end of email tests

    //login tests

        $login = $_POST['login'];

        // Let nick have between 3 and 20 characters
        if (strlen($login)<3 || strlen($login)>20)
        {
            $_SESSION['allTestsPassed'] = false;
            $_SESSION['error_login']="Login musi posiadać od 3 do 20 znaków";
        }
    
        // Let nick has only alphaumerical characters without national chars
        if (ctype_alnum($login)==false)
        {
            $_SESSION['allTestsPassed'] = false;
            $_SESSION['error_login']="Login może składać się tylko z liter i cyfr bez polskich znaków.";
        }
        $_SESSION['given_login']=$login;


    if (!$_SESSION['allTestsPassed']) header('Location: rejestracja.php');








}   else {
    header('Location: index.php');
    exit();
}
?>