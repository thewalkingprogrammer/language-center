<?php

require '../connection.php';

if ($_GET['lang'] == 1) {
    $pageTitle = 'Japanese Lectures';
    include ('includes/header.php');
    echo '<div id="contentCentered"><div class="panel panel-default"><div class="panel-body"><h1>Japanese Lectures</h1>';
} else if ($_GET['lang'] == 2) {
    $pageTitle = 'Korean Lectures';
    include ('includes/header.php');
    echo '<div id="contentCentered"><div class="panel panel-default"><div class="panel-body"><h1>Korean Lectures</h1>';
}

if (isset($_SESSION['fName'])) {


    $display = 3;

    if (isset($_GET['p']) && is_numeric($_GET['p'])) {
        $pages = $_GET['p'];
    } else {
        $query = "select count(langId) "
                . "from lectures "
                . "where langId = " . $_GET['lang'];
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

    $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'lectureId';

    switch ($sort) {

        case 'lectureId':
            $orderBy = 'lectureId asc';
            break;

        case 'title':
            $orderBy = 'title asc';
            break;

        default:
            $orderBy = 'lectureId desc';
            $sort = 'lectureId';
            break;
    }

    $query = "select title, lectureId "
            . "from lectures "
            . "where langId = " . $_GET['lang'] . " "
            . "order by $orderBy limit $start, $display";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table"><tr>'
        . '<td><b><a href="lecture.php?sort=lectureId&lang=' . $_GET['lang'] . '">Lecture #</a></b></td>'
        . '<td><b><a href="lecture.php?sort=title&lang=' . $_GET['lang'] . '">Title</a></b></td>'
        . '</tr>';
        $lecNumber = 1;
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            echo '<tr><td>' . $lecNumber . '</td>'
            . '<td><a href="read.php?lec=' . $row['lectureId'] . '">' . $row['title'] . '</a></td>'
            . '</tr>';
            $lecNumber++;
        }
        echo '</table>';

        echo '<center>';
        if ($pages > 1) {
            $currentPage = ($start / $display) + 1;

            if ($currentPage != 1) {
                echo '<a href="lecture.php?lang=' . $_GET['lang'] . '&s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
            }

            for ($i = 1; $i <= $pages; $i++) {
                if ($i != $currentPage) {
                    echo '<a href="lecture.php?lang=' . $_GET['lang'] . '&s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

            if ($currentPage != $pages) {
                echo '<a href="lecture.php?lang=' . $_GET['lang'] . '&s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
            }
        }
        echo '</center>';

        echo "<p><a href=\"test.php?lang=" . $_GET['lang'] . "\">" . "Take the test!</a></p>";

        echo '</div></div></div>';
    } else {
        echo 'No lectures available.</div></div></div>';
    }
    include ('includes/footer.php');
} else {
    header("Location: index.php");
}
?>