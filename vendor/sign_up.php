<?php
session_start();

require "../config/connect.php";
global $connect;

$login = $_POST['login'];
$email = $_POST['email'];
$password = $_POST['password'];
$password_confirm = $_POST['password_confirm'];

if ($password == $password_confirm) {
//    $password = md5($password);
    $sql_request = mysqli_query($connect,
        "insert into users(login, email, password, privilege) values('$login', '$email', '$password', 0)");
    if ($sql_request) {
        $_SESSION['user'] = [
            "login" => $login,
            "email" => $email,
            "password" => $password,
            "privilege" => 0
        ];
        header("Location: ../templates/news_feed.php");
    } else {
        $_SESSION['error'] = "Login is already taken";
        header("Location: ../templates/registration.php");
    }
} else {
    $_SESSION['error'] = "Passwords mismatch";
    header("Location: ../templates/registration.php");
}
