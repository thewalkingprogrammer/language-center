<?php

require '../connection.php';
$pageTitle = "View / Delete / Update Lectures";
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
        $query = "select count(lectureId) "
                . "from lectures";
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

    $sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'l.langId';

    switch ($sort) {

        case 'l.title':
            $orderBy = 'l.title asc';
            break;

        case 'ls.langName':
            $orderBy = 'ls.langName asc';
            break;

        default:
            $orderBy = 'l.langId asc';
            $sort = 'l.langId';
            break;
    }

    $query = "select distinct l.lectureId, l.title, ls.langName "
            . "from lectures l, languages ls "
            . "where l.langId = ls.langId "
            . "order by $orderBy limit $start, $display";
    $result = mysqli_query($con, $query);

    echo '<div id="contentCentered">'
    . '<div class="panel panel-default">'
    . '<div class="panel-body">'
    . '<center><p><a href="addLecture.php">Add a Lecture</a></p></center>';

    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table"><tr>'
        . '<td><b><a href="viewLectures.php?sort=l.title">Title</a></b></td>'
        . '<td><b><a href="viewLectures.php?sort=ls.langName">Language</a></b></td>'
        . '<td></td><td></td>'
        . '</tr>';
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            echo '<tr>'
            . '<td>' . $row[1] . '</td>'
            . '<td>' . $row[2] . '</td>'
            . '<td><a href="editLectureAdmin.php?id=' . $row[0] . '&title=' . $row[1] . '">Edit' . '</a></td>'
            . '<td><a href="deleteLectureAdmin.php?id=' . $row[0] . '">Delete' . '</td>'
            . '</tr>';
        }
        echo '</table>';

        echo '<center>';

        if ($pages > 1) {
            $currentPage = ($start / $display) + 1;

            if ($currentPage != 1) {
                echo '<a href="viewLectures.php?s=' . ($start - $display) . '&p=' . $pages . '&sort=' . $sort . '">Previous</a> ';
            }

            for ($i = 1; $i <= $pages; $i++) {
                if ($i != $currentPage) {
                    echo '<a href="viewLectures.php?s=' . (($display * ($i - 1))) . '&p=' . $pages . '&sort=' . $sort . '">' . $i . '</a> ';
                } else {
                    echo $i . ' ';
                }
            }

            if ($currentPage != $pages) {
                echo '<a href="viewLectures.php?s=' . ($start + $display) . '&p=' . $pages . '&sort=' . $sort . '">Next</a>';
            }
        }

        echo '</center>';

        echo '</div></div></div>';
    } else {
        echo '<div id="contentCentered">'
        . '<div class="panel panel-default">'
        . '<div class="panel-body">';
        echo 'No lectures available.';
        echo '</div></div></div>';
    }
    mysqli_free_result($result);
} else {
    header("Location: index.php");
}

include ('includes/footer.php');
?>