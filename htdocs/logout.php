<?php

require '../connection.php';
ob_start();
session_start();
if (!isset($_SESSION['userId'])) {
    header("Location: index.php");
} else {
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
}
?>
