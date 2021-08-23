<?php
session_start();

unset($_SESSION['user']);

//$_SESSION = array();
//session_destroy();

header("Location: ../index.php");