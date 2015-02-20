<?php

require '../connection.php';
$pageTitle = "View / Delete / Update Lectures";
include ('includes/header.php');

if ($_SESSION['level'] == 1) {
    $query = "select distinct l.lectureId, l.title, ls.langName from lectures l, languages ls where l.langId = ls.langId order by ls.langName desc";
    $result = mysqli_query($con, $query);

    echo '<div id="content">';

    if (!empty(@$_GET['msg'])) {
        echo '<div class="alert alert-success" role="alert">' . $_GET['msg'] . '</div>';
    }

    if (!empty(@$_GET['msg2'])) {
        echo '<div class="alert alert-success" role="alert">' . $_GET['msg2'] . '</div>';
    }

    if (!empty(@$_GET['msg3'])) {
        echo '<div class="alert alert-success" role="alert">' . $_GET['msg3'] . '</div>';
    }
    
    
    echo '<div id="contentCentered"><div class="panel panel-default"><div class="panel-body">'
    . '<center><p><a href="addLecture.php">Add a Lecture</a></p></center>';

    if (mysqli_num_rows($result) > 0) {
        echo '<table class="table"><tr><td><b>Title</b></td><td><b>Language</b></td><td></td><td></td></tr>';
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            echo '<tr>'
            . '<td>' . $row[1] . '</td>'
            . '<td>' . $row[2] . '</td>'
            . '<td>'
            . '<a href="editLectureAdmin.php?id=' . $row[0] . '&title=' . $row[1] . '">Edit' . '</a></td>'
            . '<td>' . '<a href="deleteLectureAdmin.php?id=' . $row[0] . '">Delete' . '</td></tr>';
        }
        echo '</table></div></div></div>';
    } else {
        echo '<div id="contentCentered"><div class="panel panel-default"><div class="panel-body">';
        echo 'No lectures available.';
        echo '</div></div></div>';
    }
    mysqli_free_result($result);
}else{
    header("Location: index.php");
}

include ('includes/footer.php');
?>