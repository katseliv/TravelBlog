<?php

session_start();

require "../config/connect.php";
global $connect;

$post_id = $_POST['post_id'];
$title = $_POST['title'];
$text = $_POST['text'];

if ($_FILES['image']['error'] == 4) {
    $path = $_POST['old_image'];
    $sql_request = "update posts set title = '$title', image = '$path', text = '$text' WHERE posts.id = '$post_id'";
    mysqli_query($connect, $sql_request);
} else {
    $path = "../images/" . time() . "_" . $_FILES['image']['name'];
    if (!move_uploaded_file($_FILES['image']['tmp_name'], $path)) {
        $_SESSION['error'] = "Error while uploading photo";
    } else {
        $sql_request = "update posts set title = '$title', image = '$path', text = '$text' WHERE posts.id = '$post_id'";
        mysqli_query($connect, $sql_request);
    }
}
header("Location: ../templates/page_of_post.php?id=" . $post_id);
