<?php

session_start();

require "../config/connect.php";
global $connect;

$login = $_POST['login'];
$password = $_POST['password'];
//$password = md5($password);

$sql_request = mysqli_query($connect, "select * from users where login = '$login' and password = '$password'");
$user = mysqli_fetch_assoc($sql_request);

if (mysqli_num_rows($sql_request) > 0) {
    $_SESSION['user'] = [
        "login" => $user['login'],
        "email" => $user['email'],
        "password" => $user['password'],
        "privilege" => $user['privilege']
    ];
    header("Location: ../templates/news_feed.php");
} else {
    $_SESSION['error'] = "Login or Password entered incorrectly";
    header("Location: ../templates/authorization.php");
}
