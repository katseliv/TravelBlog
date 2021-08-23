<?php

session_start();

require "../config/connect.php";
global $connect;

$login = $_SESSION['user']['login'];
$post_id = $_POST['id'];
$comment = $_POST['comment'];
$today = date("Y-m-d");

$sql_request = "insert into comments(login, post_id, comment, date) values('$login', '$post_id', '$comment', '$today')";
mysqli_query($connect, $sql_request);

header("Location: ". $_SERVER['HTTP_REFERER']);
