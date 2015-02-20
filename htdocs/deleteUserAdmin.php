<?php

ob_start();
session_start();

if (empty($_GET['id']) && $_SESSION['level'] != 1) {
    header("Location: index.php");
} else {
    require '../connection.php';
    $query = "delete from users "
            . "where userId = " . $_GET['id'];
    $result = mysqli_query($con, $query);

    if (mysqli_affected_rows($con) == 1) {
        header("Location: viewUsers.php?msg=User successfully deleted");
    } else {
        header("Location: viewUsers.php?msg=User was NOT deleted");
    }
}
?>
