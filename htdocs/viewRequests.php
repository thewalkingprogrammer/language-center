<?php
    require '../connection.php';
    include 'includes/header.php';
    
    if($_SESSION['level'] == 1){
        $query = "select langRequest, reason from requests";
        $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

        if (mysqli_num_rows($result) > 0) {
            echo '<div id="contentCentered"><div class="panel panel-default"><div class="panel-body">';
            
            echo '<table class="table"><tr><td><b>Language</b></td><td><b>Reason</b></td></tr>';
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo '<tr>'
                . '<td>' . $row['langRequest'] . '</td>'
                . '<td>' . $row['reason'] . '</td></tr>';        
            }
            echo '</table></div></div></div>';
        } else {
            echo 'No users available.';
        }
    }else{
        header("Location: index.php");
    }
?>
