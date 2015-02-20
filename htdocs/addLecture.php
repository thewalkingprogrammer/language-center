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
            echo '<div class="alert alert-danger" role="alert">Title is required</div>';
        }

        if (!empty($_POST['body'])) {
            $body = $_POST['body'];
        } else {
            $body = false;
            echo '<div class="alert alert-danger" role="alert">Body is required</div>';
        }

        if (isset($_POST['language'])) {
            $language = $_POST['language'];
        } else {
            $language = false;
            echo '<div class="alert alert-danger" role="alert">Language is required</div>';
        }

        if ($title && $body) {
            $query = "insert into lectures (title, body, langId) "
                    . "values('$title', '$body', '$language')";
            $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

            if (mysqli_affected_rows($con) == 1) {
                header("Location: viewLectures.php?msg3=You succesfully added a new lecture.");
                exit();
            } else {
                echo '<div class="alert alert-danger" role="alert">Something went wrong, try again.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Addition of lecture could not be complete.</div>';
        }
    }
} else {
    header("Location: index.php");
}
?>

<form name="frmAddLecture" action="addLecture.php" method="post" onsubmit="return validateAddLecture()">
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