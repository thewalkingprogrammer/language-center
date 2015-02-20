<?php
require '../connection.php';
$pageTitle = 'Forgot Password';
include ('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $random = substr(str_shuffle($chars), 0, 10);
    $query = "update users "
            . "set pass = '" . $random . "' "
            . "where email = '" . $_POST['email'] . "'";
    $result = mysqli_query($con, $query) or trigger_error("Wrong query");

    if (mysqli_affected_rows($con) == 1) {
        try {
            mail($_POST['email'], 'New Password', $random);
            echo '<div class="alert alert-success" role="alert">Password updated, check email.</div>';
        } catch (Exception $ex) {
            echo '<div class="alert alert-danger" role="alert">Error sending email.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Wrong!</div>';
    }
}
?>

<form action="forgotPassword.php" method="post">
    <fieldset>
        <div id="contentCentered">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Forgot Password</h3>
                </div>

                <div class="panel-body">
                    <table>
                        <tr>
                            <td>Email:</td>
                            <td><input type="text" class="form-control" placeholder="Email: " name="email"/></td>
                        </tr>

                        <tr>
                            <td><input type="submit" class="btn btn-success" value="Send new password"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </fieldset>    
</form>

