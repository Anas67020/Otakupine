<?php
session_start();

// Destroy the session and remove the login cookie
session_unset();
session_destroy();
setcookie('user_login', '', time() - 3600, '/'); // Remove the cookie

header("Location: ../home/home.php");
exit();
?>