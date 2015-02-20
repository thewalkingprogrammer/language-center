<?php
require '../connection.php';
$pageTitle = 'Update User';
include ('includes/header.php');

if ($_SESSION['level'] == 1) {

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $_SESSION['tempfName'] = $_GET['fName'];
        $_SESSION['templName'] = $_GET['lName'];
        $_SESSION['tempEmail'] = $_GET['email'];
        $_SESSION['tempId'] = $_GET['id'];
    }

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
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $email = mysqli_real_escape_string($con, $_POST['email']);
            } else {
                $email = false;
                echo '<div class="alert alert-danger" role="alert">Not right format for email</div>';
            }
        } else {
            $email = false;
            echo '<div class="alert alert-danger" role="alert">Email is required</div>';
        }

        if ($fName && $lName && $email) {
            if ($_SESSION['tempEmail'] == $email) {
                $query = "update users "
                        . "set fName = '$fName', lName = '$lName' "
                        . "where userId = " . $_SESSION['tempId'];
            } else {
                $query = "update users set "
                        . "fName = '$fName', lName = '$lName', email = '$email' "
                        . "where userId = " . $_SESSION['tempId'];
            }

            $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

            if (mysqli_affected_rows($con) == 1) {
                header("Location: viewUsers.php?msg2=User successfully updated");
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

<form name="frmEditUserAdmin" action="editUserAdmin.php" method="post" onsubmit="validateEditUser()">
    <fieldset>
        <div id="contentCentered">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit User</h3>
                </div>

                <div class="panel-body">
                    <table>
                        <tr>
                            <td>
                                First Name:
                            </td>
                            <td>
                                <input type="text" name="firstName" size="20" maxlength="30" value="<?php echo $_SESSION['tempfName']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Last Name:
                            </td>
                            <td>
                                <input type="text" name="lastName" size="20" maxlength="30" value="<?php echo $_SESSION['templName']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Email:
                            </td>

                            <td>
                                <input type="text" name="email" size="20" maxlength="100" value="<?php echo $_SESSION['tempEmail']; ?>" />
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