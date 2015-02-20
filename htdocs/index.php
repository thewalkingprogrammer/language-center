<?php

require '../connection.php';
$pageTitle = 'Welcome';
include ('includes/header.php');

if (isset($_SESSION['fName'])) {

    if (!empty(@$_GET['msg'])) {
        echo '<div class="alert alert-success" role="alert">' . $_GET['msg'] . '</div>';
    }

    if (!empty(@$_GET['msg2'])) {
        echo '<div class="alert alert-success" role="alert">' . $_GET['msg2'] . '</div>';
    }

    if (!empty(@$_GET['msg3'])) {
        echo '<div class="alert alert-success" role="alert">' . $_GET['msg3'] . '</div>';
    }

    echo '<div id="contentCentered">'
    . '<div class="panel panel-default">'
    . '<div class="panel-body">'
    . '<center><h1>Welcome, ' . $_SESSION ['fName'] . '</h1></center>';

    echo '<h3>Shared by users</h3>';
    $query = "select u.fName, w.score, date "
            . "from users u, wall w "
            . "where u.userId = w.userId "
            . "order by date desc";
    $result = mysqli_query($con, $query);


    if (mysqli_num_rows($result) > 0) {
        echo "<textarea cols=\"60\" rows=\"10\" readonly>";
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            echo $row[0] . " scored " . $row[1] . " on " . $row[2] . "&#13;&#10;";
        }
    } else {
        echo 'Nobody has shared yet.';
    }
    echo '</textarea><br /><br />';

    echo '<h3>Top learners</h3>';
    $query = "select u.fName, u.lName, w.score "
            . "from users u, wall w "
            . "where u.userId = w.userId "
            . "order by w.score desc "
            . "limit 5";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        echo "<table class=\"table\"><tr>"
        . "<td>Name</td>"
        . "<td>Surname</td>"
        . "<td>Score</td>"
        . "</tr>";
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            echo "<tr>"
            . "<td>" . $row [0] . "</td>"
            . "<td>" . $row [1] . "</td>"
            . "<td>" . $row[2] . "</td>"
            . "</tr>";
        }
        echo '</table>';
    } else {
        echo '<tr>'
        . '<td>Nobody has done the test yet.</td>'
        . '</tr>';
    }
    echo '</div></div></div>';
} else {
    echo '<div id="contentCentered">'
    . '<div class="panel panel-default">'
    . '<div class="panel-body">'
    . '<center><h1>Welcome to our language center</h1></center>'
    . '</div></div></div>';
}
?>

<?php include 'includes/footer.php'; ?>