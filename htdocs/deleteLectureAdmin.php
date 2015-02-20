<?php

ob_start();
session_start();

if (empty($_GET['id']) && $_SESSION['level'] != 1) {
    header("Location: index.php");
} else {
    require '../connection.php';
    $query = "delete from lectures "
            . "where lectureId = " . $_GET['id'];
    $result = mysqli_query($con, $query);

    if (mysqli_affected_rows($con) == 1) {
        header("Location: viewLectures.php?msg=Lecture successfully deleted");
    } else {
        header("Location: viewLectures.php?msg=Lecture was NOT deleted");
    }
}
?>
