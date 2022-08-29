<?php

require 'app/helpers.php';

session_start();

redirect_unauthorized(false, './signin.php');

if (validate_csrf() && isset($_GET['pid']) && is_numeric($_GET['pid'])) {

    $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PWD, MYSQL_DB);

    $pid = filter_input(INPUT_GET, 'pid', FILTER_SANITIZE_NUMBER_INT);
    $pid = mysqli_real_escape_string($link, $pid);

    if ($pid) {

        $uid = $_SESSION['user_id'];
        $sql = "DELETE FROM posts WHERE id = $pid AND user_id = $uid";
        mysqli_query($link, $sql);
    }
}

header('location: ./blog.php');
exit();

