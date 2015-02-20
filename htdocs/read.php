<?php
    require '../connection.php';
    $pageTitle = 'Time to Study';
    include ('includes/header.php');
    
    
    echo '<div id="contentCentered"><div class="panel panel-default"><div class="panel-body">';
    $query = "select title, body from lectures where lectureId =" . $_GET['lec'];
    $result = mysqli_query($con, $query) or trigger_error("Query is wrong!");
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    echo "<h1>" . $row['title'] . "</h1>";
    echo $row['body'];
    
    mysqli_free_result($result);
    echo '</div></div></div>';
    include ('includes/footer.php');
?>