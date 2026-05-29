<?php
session_start();
$role_user = isset($_SESSION['role']) ? $_SESSION['role'] : '';
$_SESSION = [];
session_unset();
session_destroy();
if ($role_user === 'admin') {
    header("Location: login.php");
} else {
    header("Location: index.php");
}
exit;
?>