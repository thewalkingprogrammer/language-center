<?php
require '../connection.php';
$pageTitle = 'Add a New Lecture';
include ('includes/header.php');

if ($_SESSION['level'] == 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $body = $language = false;

        if (!empty($_POST['title'])) {
            $title = $_POST['title'];
        } else {
            $title = false;
            echo '<p class="error">Title is required</p>';
        }

        if (!empty($_POST['body'])) {
            $body = $_POST['body'];
        } else {
            $body = false;
            echo '<p class="error">Body is required</p>';
        }

        if (isset($_POST['language'])) {
            $language = $_POST['language'];
        } else {
            $language = false;
            echo '<p class="error">Language is required</p>';
        }

        if ($title && $body) {
            $query = "insert into lectures (title, body, langId)"
                    . " values('$title', '$body', '$language')";
            $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

            if (mysqli_affected_rows($con) == 1) {
                echo '<h3>Thank you for the new lecture!</h3>';
                header("Location: viewLectures.php?msg3=You succesfully added a new lecture.");
                exit();
            } else {
                echo '<p class="error">Something went wrong, try again.</p>';
            }
        } else {
            echo '<p class="error">Addition of lecture could not be complete.</p>';
        }

        mysqli_close($con);
    }
}else{
    header("Location: index.php");
}
?>

<form action="addLecture.php" method="post">
    <fieldset>
        <div id="contentCentered">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Lecture</h3>
                </div>
                
                <div class="panel-body">
                <?php
                $query = "select langId, langName from languages";
                $result = mysqli_query($con, $query);
                if (mysqli_num_rows($result) > 0) {
                    echo "<p>Languages: <select name=\"language\">";
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo '<option value="' . $row['langId'] . '">' . $row['langName'];
                    }
                } else {
                    echo 'No lectures available.';
                }
                echo '</select></p>';
                mysqli_free_result($result);
                ?>
                    <table>
                        <tr>
                            <td>
                                Title:
                            </td>
                            <td>
                                <input type="text" name="title" size="20" maxlength="50" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Body:
                            </td>
                            <td>
                                <textarea name="body"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" class="btn btn-success" value="Add Lecture" /></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<?php include ('includes/footer.php'); ?>