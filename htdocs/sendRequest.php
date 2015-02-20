<?php
require '../connection.php';
include 'includes/header.php';

if ($_SESSION['level'] == 0) {

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $query = "insert into requests (langRequest, reason)"
                . " values('" . $_POST['langRequest'] . "', '" . $_POST['reason'] . "')";
        $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

        if (mysqli_affected_rows($con) == 1) {
            header("Location: index.php?msg=Request send successfully!");
            exit();
        } else {
            echo '<div class="alert alert-danger" role="alert">Something went wrong, try again.</div>';
        }
    }
} else {
    header("Location: index.php");
}
?>

<form action="sendRequest.php" method="post">
    <div id="contentCentered">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Send Request</h3>
            </div>

            <div class="panel-body">
                <table>
                    <tr>
                        <td>Language:</td>
                        <td><input type="text" name="langRequest"/></td>
                    </tr>

                    <tr>
                        <td>Reason:</td>
                        <td><input type="text" name="reason" /></td>
                    </tr>

                    <tr>
                        <td><input type="submit" class="btn btn-success" value="Send Request"></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</form>

<?php
include ('includes/footer.php');
?>