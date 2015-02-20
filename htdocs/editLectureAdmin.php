<?php
require '../connection.php';
$pageTitle = 'Update Lecture';
include ('includes/header.php');

if ($_SESSION['level'] == 1) {
    
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $_SESSION['tempLecId'] = $_GET['id'];
        $_SESSION['tempTitle'] = $_GET['title'];        
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $body = false;

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

        if ($title && $body) {
            $query = "update lectures set title = '$title', body ='$body' where lectureId=" . $_SESSION['tempLecId'];
            $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

            if (mysqli_affected_rows($con) == 1) {
                header("Location: viewLectures.php?msg2=Lecture successfully updated");
            } else {
                echo '<p class="error">Lecture was not updated.</p>';
            }
        } else {
            echo '<p class="error">Something is not right.</p>';
        }

        mysqli_close($con);
    }
} else {
    header("Location: index.php");
}
?>

<h1>Register</h1>
<form action="editLectureAdmin.php" method="post">
    <fieldset>
        <table>
            <tr>
                <td>
                    Title:
                </td>
                <td>
                    <input type="text" name="title" size="20" maxlength="50" value="<?php echo $_SESSION['tempTitle']; ?>" />
                </td>
            </tr>

            <tr>
                <td>
                    Body:
                </td>
                <td>
                    <textarea name="body">
                        <?php
                            $query = "select body from lectures where lectureId =" . $_SESSION['tempLecId'];
                            $result = mysqli_query($con, $query) or trigger_error("Query is wrong!");
                            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                            echo $row['body'];
                        ?>
                    </textarea>
                </td>
            </tr>

            <tr>
                <td></td>
                <td><input type="submit" value="Update Lecture" /></td>
            </tr>
        </table>
    </fieldset>
</form>

<?php include ('includes/footer.php'); ?>