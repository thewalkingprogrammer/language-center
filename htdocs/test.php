<?php
    require '../connection.php';
    if(@$_GET['lang'] == 1){            
        $pageTitle = 'Japanese Test';
        include ('includes/header.php');
        echo '<div id="contentCentered"><div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">Good Luck!</h3>'
        . '</div><div class="panel-body"><h1>Japanese Test</h1>';
    }else if(@$_GET['lang'] == 2){
        $pageTitle = 'Korean Test';        
        include ('includes/header.php');
        echo '<div id="contentCentered"><div class="panel panel-primary"><div class="panel-heading"><h3 class="panel-title">Good Luck!</h3>'
        . '</div><div class="panel-body"><h1>Korean Test</h1>';
    }
   
    if($_SERVER['REQUEST_METHOD'] == "GET"){
        $_SESSION['tempLangIdTest'] = $_GET['lang'];
        $query = "select questionId, a1, a2, a3, ca, question from questions where langId = " . $_SESSION['tempLangIdTest'];
        $result = mysqli_query($con, $query);
        $score;
        $questionNumber = 1;
       
        if (mysqli_num_rows($result) > 0) {
            echo '<form action="test.php" method="post">';
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                echo '<h3>Question # ' . $questionNumber . '<br />' . $row['question'] . '</h3>';
                echo '<input type="radio" value="' . $row['a1'] . '" name="' . $row['questionId'] . '">' . $row['a1'];
                echo '<input type="radio" value="' . $row['a2'] . '" name="' . $row['questionId'] . '">' . $row['a2'];
                echo '<input type="radio" value="' . $row['a3'] . '" name="' . $row['questionId'] . '">' . $row['a3'];
                $questionNumber++;
            }
            echo '<input type="hidden" name="lang" value="'.$_SESSION['tempLangIdTest'].'">';
            echo '<input type="hidden" name="user" value="'.$_SESSION['userId'].'">';
            echo '<p><br /><input type="submit" class="btn btn-success" name="submit_test" action="test.php" value="Submit Test" /></p></form>';
        }else{
            echo 'No tests available.';
        }
        mysqli_free_result($result);
        
        echo '</div></div></div>';
    }
 
    if (isset($_POST['submit_test'])){
        include ('includes/header.php');
        $query = "select questionId, ca, question from questions where langId = ".$_POST['lang'];
        $result = mysqli_query($con, $query);
        $score = 0;
        $questionNumber = 1;
        
        echo '<div id="contentCentered"><div class="panel panel-default"><div class="panel-body">';
        
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                if (isset($_POST[$row['questionId']])){
                    if ($row['ca'] == $_POST[$row['questionId']]){
                        echo "Question #".$row['questionId']." - ".$row['question']." is correct!<br/>";
                        $score++;
                    }
                    else
                    {
                        echo "Question #".$row['questionId']." - ".$row['question']." not correct! The right answer is: ".$row['ca']."<br/>";
                    }
                }
                $questionNumber++;
            }
            echo 'Your total score is: '.$score;
            $query = "insert into scores (score, userId) values ( {$score}, {$_POST['user']})";
            $result = mysqli_query($con, $query);
            
            echo '<p><a href="shareScore.php?score=' . $score . '&userId=' . $_POST['user'] . '"\>Share your score</a></p>';
        }
        
        echo '</div></div></div>';
    }
   
    include ('includes/footer.php');
?>