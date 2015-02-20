<?php
require '../connection.php';
$pageTitle = 'Register a New User';
include ('includes/header.php');

if ($_SESSION['level'] == 1) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

            $query = "select userId "
                    . "from users "
                    . "where email = '$email'";
            $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

            if (mysqli_num_rows($result) == 0) {
                $query = "insert into users (fName, lName, email, pass) "
                        . "values('$fName', '$lName', '$email', '$password')";
                $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

                if (mysqli_affected_rows($con) == 1) {
                    header("Location: viewUsers.php?msg3=You succesfully added a new user.");
                    exit();
                } else {
                    echo '<div class="alert alert-danger" role="alert">Something went wrong, try again.</div>';
                }
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

<form name="frmAddUser" action="addUser.php" method="post" onsubmit="return validateAddUser()">
    <fieldset>
        <div id="contentCentered">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Add User</h3>
                </div>

                <div class="panel-body">
                    <table>
                        <tr>
                            <td>
                                First Name:
                            </td>
                            <td>
                                <input type="text" name="firstName" size="20" maxlength="30" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Last Name:
                            </td>
                            <td>
                                <input type="text" name="lastName" size="20" maxlength="30" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Email:
                            </td>

                            <td>
                                <input type="text" name="email" size="20" maxlength="100" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Password:
                            </td>

                            <td>
                                <input type="password" name="password1" size="20" maxlength="20" />
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><input type="submit" class="btn btn-success" value="Add User" /></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </fieldset>
</form>

<?php include ('includes/footer.php'); ?>