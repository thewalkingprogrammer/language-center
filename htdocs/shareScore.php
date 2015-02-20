<?php
require '../connection.php';
ob_start();
session_start();

if (isset($_SESSION['fName'])) {
    $query = "insert into wall (score, userId)"
            . " values('" . $_GET['score'] . "', '" . $_GET['userId'] . "')";
    $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

    if (mysqli_affected_rows($con) == 1) {
        header("Location: index.php?msg2=Your score has been shared");
        exit();
    } else {
        echo '<div class="alert alert-danger" role="alert">Something went wrong, try again.</div>';
    }
} else {
    header("Location: index.php");
}
?>