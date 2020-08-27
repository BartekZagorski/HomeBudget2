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
    
        // Let login has only alphaumerical characters without national chars
        if (ctype_alnum($login)==false)
        {
            $_SESSION['allTestsPassed'] = false;
            $_SESSION['error_login']="Login może składać się tylko z liter i cyfr bez polskich znaków.";
        }
        $_SESSION['given_login']=$login;

    //end of ogin tests

    //password tests

        //sprawdźmy poprawność hasła
        $password = $_POST['password'];
        $confirmPassword = $_POST['password-confirm'];
    
        //let password has between 8 and 20 characters
    
        if (strlen($password)<8 || strlen($password)>20)
        {
            $_SESSION['allTestsPassed'] = false;
            $_SESSION['error_pass'] = "Hasło musi zawierać od 8 do 20 znaków";
        }

        $_SESSION['given_pass'] = $password;
    
   /*     //sprawdźmy czy hasło1 i hasło2 są takie same
    
        if ($haslo1 != $haslo2)
        {
            $wszystko_OK = false;
            $_SESSION['e_pass'] ="Podane hasła nie są identyczne";
        }
    
        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);*/





    //end of password tests


    if (!$_SESSION['allTestsPassed']) header('Location: rejestracja.php');








}   else {
    header('Location: index.php');
    exit();
}
?>