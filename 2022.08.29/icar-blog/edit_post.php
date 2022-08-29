<?php
session_start();
require_once './app/helpers.php';

redirect_unauthorized(false, './signin.php');


$link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);
$post = null;

if (isset($_GET['pid']) && is_numeric($_GET['pid'])) {

    $pid = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_NUMBER_INT);
    $pid = mysqli_real_escape_string($link, $pid);

    if ($pid) {

        $uid = $_SESSION['user_id'];
        $sql = "SELECT * FROM posts WHERE id = $pid AND user_id = $uid";
        $result = mysqli_query($link, $sql);

        if ($result && mysqli_num_rows($result)) {
            $post = mysqli_fetch_assoc($result);
        }
    }
}

if (!isset($post)) {
    header('location: ./blog.php');
    exit();
}


if (validate_csrf() && isset($_POST['submit'])) {
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $article = filter_input(INPUT_POST, 'article', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $is_form_valid = true;

    if (!$title || mb_strlen($title) <=  2) {
        $is_form_valid = false;
        $errors['title'] = '* Title is required for minimum of 2 characters';
    }

    if (!$article || mb_strlen($article) <=  2) {
        $is_form_valid = false;
        $errors['article'] = '* Article is required for minimum of 2 characters';
    }


    if ($is_form_valid) {

        $uid = $_SESSION['user_id'];

        $title = mysqli_real_escape_string($link, $title);
        $article = mysqli_real_escape_string($link, $article);

        $sql = "UPDATE posts SET title='$title', article='$article' WHERE id = $pid AND user_id = $uid";
        $result = mysqli_query($link, $sql);

        if ($result && mysqli_affected_rows($link) === 1) {
            header('location: ./blog.php');
            exit;
        }
    }
}


$page_title = "EDIT POST";
include './tpl/header.php';
?>


<main class="container flex-fill">

    <!-- PAGE HEADER -->
    <section id="main-content-top">
        <div class="row">
            <div class="col-12 mt-5 text-center">
                <h1 class="display-3 text-primary">
                    Edit Post
                </h1>
            </div>
        </div>
    </section>

    <!-- PAGE CONTENT -->
    <section id="main-content" class="container">
        <div class="row mb-2">

            <div class="col-12 col-md-6 mx-auto">
                <form action="" method="POST" novalidate="novalidate" autocomplete="off">

                    <input type="hidden" name="<?= csrf_name(); ?>" value="<?= csrf(); ?>" />

                    <div class=" form-group mt-3">
                        <label for="title">
                            <span class="text-danger">*</span>
                            Title
                        </label>
                        <input type="text" name="title" value="<?= old_field_value('title') ? old_field_value('title') : htmlentities($post['title']); ?>" id="title" class="form-control">
                        <?= field_error('title'); ?>
                    </div>

                    <div class="form-group mt-3">
                        <label for="article">
                            <span class="text-danger">*</span>
                            Article
                        </label>
                        <textarea name="article" rows="10" id="article" class="form-control"><?= old_field_value('article') ? old_field_value('article') : htmlentities($post['article']); ?></textarea>
                        <?= field_error('article'); ?>
                    </div>

                    <div class="d-flex my-3">
                        <input type="submit" name="submit" value="Update Post" class="btn btn-primary">

                        <a href="./blog.php" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                </form>
            </div>

        </div>
    </section>


</main>

<?php include './tpl/footer.php'; ?>