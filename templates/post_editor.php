<?php
session_start();
require "../config/connect.php";
global $connect;

if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['privilege'] != 1) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}
$post_id = $_GET['id'];
$post = mysqli_query($connect, "select * from posts where id = '$post_id'");
$post = mysqli_fetch_assoc($post);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8"
            crossorigin="anonymous"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js"></script>
</head>
<body>
<header>
    <div class="container p-5 overflow-hidden bg-light">
        <div class="row gy-100 d-sm-flex align-items-center text-center bg-light">
            <div class="col-9">
                <div class="p-4">
                    <a class="nav-link link-dark" href="../index.php">
                        <p class="display-1">See the World on Click</p>
                    </a>
                </div>
            </div>
            <div class="col-3">
                <div class="p-4">
                    <a href="../index.php">
                        <i class="bi-globe align-content-center" style="font-size: 100px; color: seagreen"></i>
                    </a>
                </div>
            </div>

            <div class="col">
                <div class="p-3">
                    <h4 class="fw-light"><a class="nav-link link-dark" href="../templates/news_feed.php">News feed</a>
                    </h4>
                </div>
            </div>
            <div class="col">
                <div class="p-3">
                    <h4 class="fw-light"><a class="nav-link link-dark" href="../templates/about_me_page.php">About
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
                                                    href="../templates/page_of_users.php">Users</a>
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
                            ?>User: <?= $_SESSION['user']['login'] ?><?php
                        } else {
                            ?><a class="nav-link link-dark" href="../templates/registration.php">Sign Up</a><?php
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
                                onclick="document.location='../vendor/sign_out.php'">
                            <a class="nav-link link-dark">Sign Out</a>
                        </button>
                        <?php
                    } else {
                        ?>
                        <button type="button" class="btn btn-outline-success btn-lg fw-light"
                                onclick="document.location='../templates/authorization.php'">
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
            <p class="display-4 text-center fw-bold">Editor</p>
        </div>
    </div>
</div>

<form action="../vendor/update_post.php" method="post" enctype="multipart/form-data">
    <div class="container p-5 overflow-hidden">
        <div class="form-floating">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Enter title</label>
                <input class="form-control" id="title" type="text" name="title" value="<?= $post['title'] ?>">
            </div>
            <input type="hidden" name="old_image" value="<?= $post['image'] ?>">
            <div class="mb-3">
                <label for="formFile" class="form-label">Upload the main picture</label>
                <input class="form-control" id="formFile" type="file" name="image"
                       accept="image/jpeg, image/png, image/gif"">
            </div>
            <div class="mb-3">
                <label class="py-2" for="editor"></label>
                <textarea class="py-3 form-control" id="editor" name="text" placeholder="Write a text here"
                          style="height: 100px">
                    <?= $post['text'] ?>
                </textarea>
            </div>
            <?php
            if (isset($_SESSION['error'])) {
                ?>
                <div id="passwordHelpBlock" class="error form-text text-danger text-center">
                    <?php
                    echo $_SESSION['error'];
                    ?>
                </div>
                <?php
            }
            unset($_SESSION['error']);
            ?>
            <div class="py-4 d-md-flex justify-content-md-end">
                <button class="btn btn-success mb-3" type="submit">Edit</button>
            </div>
        </div>
    </div>
</form>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'))
        .catch(error => {
            console.error(error);
        });
</script>
</body>
</html>
