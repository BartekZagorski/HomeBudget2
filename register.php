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
    }

    $_SESSION['given_email'] = $email;

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


        //Let's check whether a password is identical that confirmPassword

        if ($password != $confirmPassword)
        {
            $_SESSION['allTestsPassed'] = false;
            $_SESSION['error_pass'] = "Podane hasła nie są identyczne";
        }

        $_SESSION['given_pass_confirm'] = $confirmPassword;
    
        //let password has between 8 and 20 characters
    
        if (strlen($password)<8 || strlen($password)>20)
        {
            $_SESSION['allTestsPassed'] = false;
            $_SESSION['error_pass'] = "Hasło musi zawierać od 8 do 20 znaków";
        }

        $_SESSION['given_pass'] = $password;
    
    //end of password tests

    //connect to database -->


    if (!$_SESSION['allTestsPassed']){
        header('Location: rejestracja.php');
    } else {
        require_once "dbconnect.php";

        $query = $dbConnection->prepare('SELECT id FROM users WHERE email = :email');
        $query->bindValue(':email', $email, PDO::PARAM_STR);
        $query->execute();

        $fetchedID = $query->fetch();

        if ($fetchedID) {
            $_SESSION['allTestsPassed'] = false;
            $_SESSION['error_email'] = "Istnieje konto o podanym adresie email";
        }

        $query = $dbConnection->prepare('SELECT id FROM users WHERE login = :login');
        $query->bindValue(':login', $login, PDO::PARAM_STR);
        $query->execute();

        $fetchedID = $query->fetch();

        if ($fetchedID) {
            $_SESSION['allTestsPassed'] = false;
            $_SESSION['error_login'] = "Istnieje konto o podanym loginie";
        }


        if (!$_SESSION['allTestsPassed']){
            header('Location: rejestracja.php');
            exit();
        } else {
            unset($_SESSION['given_email']);
            unset($_SESSION['given_login']);
            unset($_SESSION['given_pass']);
            unset($_SESSION['given_pass_confirm']);
    
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            //adding new record to table users
            $query = $dbConnection->prepare('INSERT INTO users VALUES (NULL, :login, :pass, :email)');
            $query->bindValue(':login', $login, PDO::PARAM_STR);
            $query->bindValue(':pass', $passwordHash, PDO::PARAM_STR);
            $query->bindValue(':email', $email, PDO::PARAM_STR);
            $query->execute();

            //fetch just registerred user id

            $query = $dbConnection->prepare('SELECT id FROM users WHERE login = :login');
            $query->bindValue(':login', $login, PDO::PARAM_STR);
            $query->execute();

            $justRegisterredUser = $query->fetch(); 

            $justRegisterredUserId = $justRegisterredUser['id'];

            //adding new records to table incomesCattegoriesAssignedToUser from table incomesCattegoriesDefault

            $query = $dbConnection->prepare('INSERT INTO incomes_cattegories_assigned_to_users SELECT NULL, :id, name FROM incomes_cattegories_default');
            $query->bindValue(':id', $justRegisterredUserId, PDO::PARAM_INT);
            $query->execute();

            //adding new records to table paymentMethodsAssignedToUser from table paymentMethodsDefault

            $query = $dbConnection->prepare('INSERT INTO payment_method_assigned_to_user SELECT NULL, :id, name FROM payment_method_default');
            $query->bindValue(':id', $justRegisterredUserId, PDO::PARAM_INT);
            $query->execute();

            //adding new records to table expensesCattegoriesAssignedToUser from table expensesCattegoriesDefault

            $query = $dbConnection->prepare('INSERT INTO expenses_cattegories_assigned_to_users SELECT NULL, :id, name FROM expenses_cattegories_default');
            $query->bindValue(':id', $justRegisterredUserId, PDO::PARAM_INT);
            $query->execute();

            $_SESSION['successfulRegistration'] = true;
            header ('Location: witamy.php');
            exit();          
        }
    }

}   else {
        header('Location: index.php');
        exit();
    }
?>