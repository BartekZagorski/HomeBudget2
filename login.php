<?php
    session_start();
    
    if (!isset($_POST['login'])) {
        header('Location: logowanie.php');
        exit();
    }

    require_once "dbconnect.php";

    $login = filter_input(INPUT_POST, 'login');
    $password = filter_input(INPUT_POST, 'password');

    $query = $dbConnection->prepare('SELECT id, password FROM users WHERE login = :login');
    $query->bindValue(':login', $login, PDO::PARAM_STR);
    $query->execute();

    $user = $query->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['loggedInUserId'] = $user['id'];
        $_SESSION['login'] = $login;
        unset($_SESSION['badAttempt']);
        header('Location: menuGlowne.php');
        exit();
    } else {
        $_SESSION['badAttempt'] = $login;
        header('Location: logowanie.php');
        exit();
    }

?>