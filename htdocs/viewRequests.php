<?php

require '../connection.php';
$pageTitle = "View Requests";
include 'includes/header.php';

if ($_SESSION['level'] == 1) {

    $display = 5;

    if (isset($_GET['p']) && is_numeric($_GET['p'])) {
        $pages = $_GET['p'];
    } else {
        $query = "select count(requestId) "
                . "from requests";
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

    $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'langRequest';

    switch ($sort) {

        case 'langRequest':
            $orderBy = 'langRequest asc';
            break;

        case 'reason':
            $orderBy = 'reason asc';
            break;

        default:
            $orderBy = 'langRequest desc';
            $sort = 'langRequest';
            break;
    }

    $query = "select langRequest, reason "
            . "from requests "
            . "order by $orderBy limit $start, $display";
    $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

    if (mysqli_num_rows($result) > 0) {
        echo '<div id="contentCentered">'
        . '<div class="panel panel-default">'
        . '<div class="panel-body">';

        echo '<table class="table"><tr>'
        . '<td><b><a href="viewRequests.php?sort=langRequest">Language</a></b></td>'
        . '<td><b><a href="viewRequests.php?sort=reason">Reason</a></b></td>'
        . '</tr>';
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo '<tr>'
            . '<td>' . $row['langRequest'] . '</td>'
            . '<td>' . $row['reason'] . '</td>'
            . '</tr>';
        }
        echo '</table>';

        echo '<center>';

        if ($pages > 1) {
            $currentPage = ($start / $display) + 1;

            if ($currentPage != 1) {
                echo '<a href="viewRequests.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
            }

            for ($i = 1; $i <= $pages; $i++) {
                if ($i != $currentPage) {
                    echo '<a href="viewRequests.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

            if ($currentPage != $pages) {
                echo '<a href="viewRequests.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
            }
        }

        echo '</center>';

        echo '</div></div></div>';
    } else {
        echo '<div id="contentCentered">'
        . '<div class="panel panel-default">'
        . '<div class="panel-body">No users available.</div></div></div>';
    }
} else {
    header("Location: index.php");
}
?>
