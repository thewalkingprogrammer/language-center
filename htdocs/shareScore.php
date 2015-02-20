<?php
    require '../connection.php';
    include 'includes/header.php';
    
    $query = "insert into wall (score, userId)"
                        . " values('" . $_GET['score'] . "', '" . $_GET['userId'] . "')";
    $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

    if (mysqli_affected_rows($con) == 1) {
        header("Location: index.php?msg2=Your score has been shared");
        exit();
    } else {
        echo '<p class="error">Something went wrong, try again.</p>';
    }
