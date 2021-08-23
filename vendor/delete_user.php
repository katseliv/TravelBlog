<?php
session_start();

require "../config/connect.php";
global $connect;

$user_login = $_GET['id'];

$sql_request = "delete from users where login = '$user_login'";
mysqli_query($connect, $sql_request);

header("Location: ". $_SERVER['HTTP_REFERER']);