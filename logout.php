<?php
session_start();

session_unset();

session_destroy();

// session destroy
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        "",
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// redirect
header("Location: index.php");
exit();
?>
