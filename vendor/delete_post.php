<?php
session_start();

require "../config/connect.php";
global $connect;

$post_id = $_GET['id'];

mysqli_query($connect, "delete from posts WHERE posts.id = '$post_id'");

header("Location: ../templates/news_feed.php");
