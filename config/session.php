<?php
// Functionality to safely start a session without warnings
function init_session()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Redirect if not logged in
function require_login()
{
    init_session();
    if (!isset($_SESSION["login"])) {
        header("Location: index.php");
        exit();
    }
}

// Ensure the user has admin role (1 = Admin, 2 = User)
function require_admin()
{
    require_login();
    if ($_SESSION["role"] != 1) {
        header("Location: userDashboard.php");
        exit();
    }
}
?>