<?php
session_start();
require "config/connect.php";
global $connect;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Travel Blog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
            crossorigin="anonymous"></script>
</head>
<body>
<header>
    <div class="container p-5 overflow-hidden bg-light">
        <div class="row gy-100 d-sm-flex align-items-center text-center bg-light">
            <div class="col-9">
                <div class="p-4">
                    <a class="nav-link link-dark" href="index.php">
                        <p class="display-1">See the World on Click</p>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <div class="p-4">
                    <a href="index.php">
                        <i class="bi-globe align-content-center" style="font-size: 100px; color: seagreen"></i>
                    </a>
                </div>
            </div>

            <div class="col">
                <div class="p-3">
                    <h4 class="fw-light"><a class="nav-link link-dark" href="templates/news_feed.php">News feed</a>
                    </h4>
                </div>
            </div>
            <div class="col">
                <div class="p-3">
                    <h4 class="fw-light"><a class="nav-link link-dark" href="templates/about_me_page.php">About
                            me</a>
                    </h4>
                </div>
            </div>
            <?php
            if (isset($_SESSION['user'])) {
                if ($_SESSION['user']['privilege'] == 1) {
                    ?>
                    <div class="col">
                        <div class="p-3">
                            <h4 class="fw-light"><a class="nav-link link-dark"
                                                    href="templates/page_of_users.php">Users</a>
                            </h4>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="col">
                <div class="p-3">
                    <h4 class="fw-light">
                        <?php
                        if (isset($_SESSION['user'])) {
                            ?> User: <?= $_SESSION['user']['login'] ?><?php
                        } else {
                            ?><a class="nav-link link-dark" href="templates/registration.php">Sign Up</a><?php
                        }
                        ?>
                    </h4>
                </div>
            </div>
            <div class="col">
                <div class="p-3">
                    <?php
                    if (isset($_SESSION['user'])) {
                        ?>
                        <button type="button" class="btn btn-outline-danger btn-lg fw-light"
                                onclick="document.location='vendor/sign_out.php'">
                            <a class="nav-link link-dark">Sign Out</a>
                        </button>
                        <?php
                    } else {
                        ?>
                        <button type="button" class="btn btn-outline-success btn-lg fw-light"
                                onclick="document.location='templates/authorization.php'">
                            <a class="nav-link link-dark">Sign In</a>
                        </button>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container p-3 overflow-hidden">
    <div class="row d-sm-flex">
        <div class="p-5 col">
            <p class="display-4 text-center fw-bold">Hello, My Friend !</p>
        </div>
    </div>
</div>

<div class="container p-5 overflow-hidden">
    <div class="row d-sm-flex">
        <div class="p-5 col">
            <p class="display-6 text-center">Hope, You will like my blog, because here you will find a lot of things
                which will help you with your traveling. You get there a pile of advice, funny stories, or knowledgeable
                content.</p>
            <p class="display-6 text-center"> And.. you can write me an email and ask some questions. Go down and you
                will see a form where you
                can write your questions</p>
        </div>
    </div>
</div>
</body>
</html>