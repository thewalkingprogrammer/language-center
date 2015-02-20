<?php

require '../connection.php';
$pageTitle = "View / Delete / Update Users";
include ('includes/header.php');

if ($_SESSION['level'] == 1) {
    if (!empty(@$_GET['msg'])) {
        echo '<div class="alert alert-success" role="alert">' . $_GET['msg'] . '</div>';
    }

    if (!empty(@$_GET['msg2'])) {
        echo '<div class="alert alert-success" role="alert">' . $_GET['msg2'] . '</div>';
    }

    if (!empty(@$_GET['msg3'])) {
        echo '<div class="alert alert-success" role="alert">' . $_GET['msg3'] . '</div>';
    }

    $display = 5;

    if (isset($_GET['p']) && is_numeric($_GET['p'])) {
        $pages = $_GET['p'];
    } else {
        $query = "select count(userId) "
                . "from users "
                . "where level = 0";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result, MYSQLI_NUM);
        $records = $row[0];

        if ($records > $display) {
            $pages = ceil($records / $display);
        } else {
            $pages = 1;
        }
    }

    if (isset($_GET['s']) && is_numeric($_GET['s'])) {
        $start = $_GET['s'];
    } else {
        $start = 0;
    }

    $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'userId';

    switch ($sort) {

        case 'fName':
            $orderBy = 'fName asc';
            break;

        case 'lName':
            $orderBy = 'lName asc';
            break;

        case 'email':
            $orderBy = 'email asc';
            break;

        default:
            $orderBy = 'userId asc';
            $sort = 'userId';
            break;
    }

    $query = "select userId, fName, lName, email "
            . "from users "
            . "where level = 0 " .
            "order by $orderBy limit $start, $display";
    $result = mysqli_query($con, $query);

    echo '<div id="contentCentered">'
    . '<div class="panel panel-default">'
    . '<div class="panel-body">'
    . '<center><p><a href="addUser.php">Add a user</a></p></center>';

    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table"><tr>'
        . '<td><b><a href="viewUsers.php?sort=fName">First Name</a></b></td>'
        . '<td><b><a href="viewUsers.php?sort=lName">Last Name</a></b></td>'
        . '<td><b><a href="viewUsers.php?sort=email">Email</a></b></td>'
        . '<td></td><td></td></tr>';
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
        echo '</table>';

        echo '<center>';

        if ($pages > 1) {
            $currentPage = ($start / $display) + 1;

            if ($currentPage != 1) {
                echo '<a href="viewUsers.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
            }

            for ($i = 1; $i <= $pages; $i++) {
                if ($i != $currentPage) {
                    echo '<a href="viewUsers.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

            if ($currentPage != $pages) {
                echo '<a href="viewUsers.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
            }
        }

        echo '</center>';

        echo '</div></div></div>';
    } else {
        echo '<div id="contentCentered">'
        . '<div class="panel panel-default">'
        . '<div class="panel-body">';
        echo 'No users available.';
        echo '</div></div></div>';
    }
    mysqli_free_result($result);
} else {
    header("Location: index.php");
}

include ('includes/footer.php');
?>