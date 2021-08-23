<?php
session_start();

require "../config/connect.php";
global $connect;

$comment_id = $_GET['id'];

$sql_request = "delete from comments where id = '$comment_id'";
mysqli_query($connect, $sql_request);

header("Location: ". $_SERVER['HTTP_REFERER']);