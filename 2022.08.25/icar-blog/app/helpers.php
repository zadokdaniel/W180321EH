<?php
require_once 'db_config.php';


if (!function_exists('old_field_value')) {

    function old_field_value($field_name)
    {
        return isset($_REQUEST[$field_name]) ? $_REQUEST[$field_name] : '';
    }
}

if (!function_exists('user_auth')) {

    function user_auth()
    {
        if (
            isset($_SESSION['user_id']) &&
            isset($_SESSION['user_ip']) &&
            $_SESSION['user_ip'] === $_SERVER['REMOTE_ADDR'] &&
            isset($_SESSION['user_agent']) &&
            $_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT'] &&
            isset($_SESSION['user_browser']) &&
            $_SESSION['user_browser'] === $_SERVER['HTTP_SEC_CH_UA']
        ) {
            return true;
        }

        return false;
    }
}

if (!function_exists('field_error')) {

    $errors = [];

    function field_error($field_name)
    {
        global $errors;

        if (isset($errors) && !empty($errors[$field_name])) {
            return '<span class="text-danger">' . $errors[$field_name] . '</span>';
        }
    }
}

if (!function_exists('login_user')) {

    function login_user($uid, $name, $proflie,  $location = null)
    {

        $_SESSION['user_id'] = $uid;
        $_SESSION['user_name'] = $name;
        $_SESSION['profile_image'] = $proflie;

        // digital finger print
        $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['user_browser'] = $_SERVER['HTTP_SEC_CH_UA'];

        if (isset($location)) {
            header("location: $location");
            exit;
        }
    }
}

if (!function_exists('redirect_unauthorized')) {

    function redirect_unauthorized($redirect_if_is_logged = false, $location = './')
    {

        if (
            ($redirect_if_is_logged && user_auth()) ||
            (!$redirect_if_is_logged && !user_auth())
        ) {
            header("location: $location");
            exit;
        }
    }
}

if (!function_exists('email_exists')) {

    function email_exists($link, $email)
    {
        $email = mysqli_real_escape_string($link, $email);
        $sql = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = mysqli_query($link, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            return true;
        }

        return false;
    }
}


// if (!function_exists('redirect_unauthorized')) {

//     define('REDIRECT_UNAUTHORIZED_LOGGED', 1);
//     define('REDIRECT_UNAUTHORIZED_NOT_LOGGED', 2);

//     function redirect_unauthorized($location = './', $flag = REDIRECT_UNAUTHORIZED_LOGGED)
//     {

//         if (
//             ($flag === REDIRECT_UNAUTHORIZED_LOGGED && user_auth()) ||
//             ($flag === REDIRECT_UNAUTHORIZED_NOT_LOGGED && !user_auth())
//         ) {
//             header("location: $location");
//             exit;
//         }
//     }
// }




if (!function_exists('csrf_name')) {

    function csrf_name()
    {
        return 'csrf_token';
    }
}

if (!function_exists('csrf')) {

    function csrf()
    {
        $token = sha1(rand(1, 1000000000) . '$$' . rand(1, 1000000) . 'icar');
        $_SESSION[csrf_name()] = $token;
        return $token;
    }
}


if (!function_exists('validate_csrf')) {

    function validate_csrf()
    {
        if (isset($_REQUEST[csrf_name()]) && isset($_SESSION[csrf_name()])) {
            return $_REQUEST[csrf_name()] === $_SESSION[csrf_name()];
        }

        return false;
    }
}
