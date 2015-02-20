<?php
require '../connection.php';
$pageTitle = 'View / Edit Profile';
include ('includes/header.php');

if (isset($_SESSION['fName'])) {


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $trimmed = array_map('trim', $_POST);
        $fName = $lName = $email = $password = false;

        if (!empty($_POST['firstName'])) {
            $fName = mysqli_real_escape_string($con, $_POST['firstName']);
        } else {
            $fName = false;
            echo '<div class="alert alert-danger" role="alert">First name is required</div>';
        }

        if (!empty($_POST['lastName'])) {
            $lName = mysqli_real_escape_string($con, $_POST['lastName']);
        } else {
            $lName = false;
            echo '<div class="alert alert-danger" role="alert">Last name is required</div>';
        }

        if (!empty($_POST['email'])) {
            $email = mysqli_real_escape_string($con, $_POST['email']);
        } else {
            $email = false;
            echo '<div class="alert alert-danger" role="alert">Email is required</div>';
        }

        if (!empty($_POST['password1'])) {
            $password = mysqli_real_escape_string($con, $_POST['password1']);
        } else {
            $password = false;
            echo '<div class="alert alert-danger" role="alert">Password is required</div>';
        }

        if ($fName && $lName && $email && $password) {
            $query = "update users "
                    . "set fName = '$fName', lName = '$lName', email = '$email', pass = '$password' "
                    . "where userId = " . $_SESSION['userId'];
            $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

            if (mysqli_affected_rows($con) == 1) {
                $_SESSION['fName'] = $fName;
                $_SESSION['lName'] = $lName;
                $_SESSION['email'] = $email;
                $_SESSION['pass'] = $password;
                header("Location: index.php?msg3=Profile successfully updated");
            } else {
                echo '<div class="alert alert-danger" role="alert">Email already exists.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Something is not right.</div>';
        }
    }
} else {
    header("Location: index.php");
}
?>

<form action="updateProfile.php" method="post">
    <fieldset>
        <div id="contentCentered">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Update Profile</h3>
                </div>

                <div class="panel-body">
                    <table>
                        <tr>
                            <td>
                                First Name:
                            </td>
                            <td>
                                <input type="text" name="firstName" size="20" maxlength="30" value="<?php echo $_SESSION['fName']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Last Name:
                            </td>
                            <td>
                                <input type="text" name="lastName" size="20" maxlength="30" value="<?php echo $_SESSION['lName']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Email:
                            </td>

                            <td>
                                <input type="text" name="email" size="20" maxlength="100" value="<?php echo $_SESSION['email']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Password:
                            </td>

                            <td>
                                <input type="password" name="password1" size="20" maxlength="20" value="<?php echo $_SESSION['pass']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><input type="submit" class="btn btn-success" value="Update Profile" /></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<?php include ('includes/footer.php'); ?>