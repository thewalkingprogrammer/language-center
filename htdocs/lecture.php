<?php
    require '../connection.php';
    if($_GET['lang'] == 1){             
        $pageTitle = 'Japanese Lectures';
        include ('includes/header.php');
        echo '<div id="contentCentered"><div class="panel panel-default"><div class="panel-body"><h1>Japanese Lectures</h1>';        
    }else if($_GET['lang'] == 2){
        $pageTitle = 'Korean Lectures';     
        include ('includes/header.php');
        echo '<div id="contentCentered"><div class="panel panel-default"><div class="panel-body"><h1>Korean Lectures</h1>';          
    }
    
    $query = "select title,lectureId from lectures where langId =" . $_GET['lang'];
    $result = mysqli_query($con, $query);
    
    if (mysqli_num_rows($result) > 0) {
        echo "<table class=\"table\"><tr><td><b>Lecture #</b></td><td><b>Title</b></td></tr>";
        $lecNumber = 1;
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo "<tr><td>" . $lecNumber . "</td>" . "<td><a href=\"read.php?lec=" . $row['lectureId'] . "\">" . $row['title'] . "</a></td></tr>";
                $lecNumber++;
            }
        echo '</table>';

        echo "<a href=\"test.php?lang=" .$_GET['lang'] ."\">" . "Take the test!</a>";
        
        echo '</div></div></div>';
        mysqli_free_result($result);
    }else{
        echo 'No lectures available.</div></div></div>';
    }
    
    
    include ('includes/footer.php'); 
?>