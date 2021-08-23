<?php
session_start();

require "../config/connect.php";
global $connect;

$post_id = $_GET['id'];
$post = mysqli_query($connect, "select * from posts where id = '$post_id'");

if (mysqli_num_rows($post) == 0) {
    header("Location: ../templates/news_feed.php");
}

$post = mysqli_fetch_assoc($post);

$comments = mysqli_query($connect, "select * from comments where post_id = '$post_id'");
$comments = mysqli_fetch_all($comments);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Post</title>
    <link rel="stylesheet" href="../assets/style/comments.css">
    <link rel="stylesheet" href="../assets/style/post.css">
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

<div class="container p-5 overflow-hidden">
    <div class="row d-sm-flex">
        <div class="p-5 col">
            <p class="display-5 text-center fw-bold"><?= $post['title'] ?></p>
        </div>
    </div>
</div>

<div class="container p-5">
    <img src="<?= $post['image'] ?>" class="mx-auto d-block" alt=""
         style="width: 100%; max-width: 880px; height: auto;"
         sizes="(max-width: 320px) 100vw, 320px"/>
</div>

<div class="container p-5 align-items-center overflow-hidden">
    <div class="row d-sm-flex">
        <?= $post['text'] ?>
    </div>
</div>

<?php
if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['privilege'] == 1) {
        ?>
        <div class="container p-5 overflow-hidden">
            <div class="form-floating">
                <div class="d-md-flex justify-content-md-end">
                    <h4 class="px-2">
                        <a class="link-danger" href="../vendor/delete_post.php?id=<?= $post['id'] ?>">
                            <p class="text-center">Delete</p>
                        </a>
                    </h4>
                    <h4 class="px-2">
                        <a class="link-success" href="../templates/post_editor.php?id=<?= $post['id'] ?>">
                            <p class="text-center">Edit</p>
                        </a>
                    </h4>
                </div>
            </div>
        </div>
        <?php
    }
}
?>

<div class="container overflow-hidden">
    <div class="row p-5 d-sm-flex">
        <a id="anchor"></a>
        <h1 class="text-center fw-bold">Comments</h1>
    </div>
</div>

<?php
foreach ($comments as $comment) {
    ?>
    <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center py-3 w-100">
        <div class="comment" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="rounded me-2 bi-person-fill align-content-center" style="color: seagreen"></i>
                <strong class="me-auto"><?= $comment[1] ?></strong>
                <small><?= date_format(date_create($comment[4]), 'j F Y') ?></small>
                <?php
                if (isset($_SESSION['user'])) {
                    if ($_SESSION['user']['privilege'] == 1) {
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Закрыть"
                                onclick="document.location='../vendor/delete_comment.php?id=<?= $comment[0] ?>'">
                        </button>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="toast-body"><?= $comment[3] ?></div>
        </div>
    </div>
    <?php
}

if (isset($_SESSION['user'])) {
    ?>
    <form method="post" action="../vendor/add_new_comment.php">
        <div class="container p-5 overflow-hidden">
            <div class="form-floating">
                <input type="hidden" name="id" value="<?= $post_id ?>">
                <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" name="comment"
                          style="height: 100px"></textarea>
                <label for="floatingTextarea2"><?= $_SESSION['user']['login'] ?>, write a comment ...</label>
                <div class="py-4 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-success mb-3">Send</button>
                </div>
            </div>
        </div>
    </form>
    <?php
} else {
    ?>
    <div class="container py-5 w-25">
        <div class="container text-center">
            <h6><a href="registration.php" class="user-link text-success w-25 ">Sign up to post a comment</a></h6>
        </div>
    </div>
    <?php
}
?>
</body>
</html>