<?php

require '../connection.php';
$pageTitle = "View / Delete / Update Users";
include ('includes/header.php');

if ($_SESSION['level'] == 1) {
    $query = "select userId, fName, lName, email from users where level = 0";
    $result = mysqli_query($con, $query);

    if (!empty(@$_GET['msg'])) {
        echo '<p class="success">' . $_GET['msg'] . '</p>';
    }

    if (!empty(@$_GET['msg2'])) {
        echo '<p class="success">' . $_GET['msg2'] . '</p>';
    }

    if (!empty(@$_GET['msg3'])) {
        echo '<p class="success">' . $_GET['msg3'] . '</p>';
    }

    echo '<div id="contentCentered"><div class="panel panel-default"><div class="panel-body">'
    . '<center><p><a href="addUser.php">Add a user</a></p></center>';

    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table"><tr><td><b>First Name</b></td><td><b>Last Name</b></td><td><b>Email</b></td><td></td><td></td></tr>';
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo '<tr>'
            . '<td>' . $row['fName'] . '</td>'
            . '<td>' . $row['lName'] . '</td>'
            . '<td>' . $row['email'] . '</td>'
            . '<td>'
            . '<a href="editUserAdmin.php?id=' . $row['userId']
            . '&fName=' . $row['fName']
            . '&lName=' . $row['lName']
            . '&email=' . $row['email']
            . '">Edit' . '</a></td>'
            . '<td>' . '<a href="deleteUserAdmin.php?id=' . $row['userId'] . '">Delete' . '</td></tr>';
        }
        echo '</table></div></div></div>';
    } else {
        echo '<div id="contentCentered"><div class="panel panel-default"><div class="panel-body">';
        echo 'No users available.';
        echo '</div></div></div>';
    }
    mysqli_free_result($result);
}else{
    header("Location: index.php");
}

include ('includes/footer.php');
?>