<?php

session_start();

require "../config/connect.php";
global $connect;

$title = $_POST['title'];
$text = $_POST['text'];

$path = "../images/" . time() . "_" . $_FILES['image']['name'];

if (!move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
    $_SESSION['error'] = "Error while uploading photo";
} else {
    $today = date("Y-m-d");
    $sql_request = mysqli_query($connect,
        "insert into posts(title, image, text, date) values('$title', '$path', '$text', '$today')");
    if (!$sql_request) {
        $_SESSION['error'] = "Fill in all fields";
    }
}

header("Location: " . $_SERVER['HTTP_REFERER']);
