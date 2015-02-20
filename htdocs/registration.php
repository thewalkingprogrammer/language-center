<?php
require '../connection.php';
$pageTitle = 'Register';
include ('includes/header.php');

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
            $query = "insert into users (fName, lName, email, pass)"
                    . " values('$fName', '$lName', '$email', '$password')";
            $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

            if (mysqli_affected_rows($con) == 1) {
                echo '<div class="alert alert-success" role="alert">Thank you for registering, you can now login.</div>';
                include ('includes/footer.php');
                exit();
            } else {
                echo '<div class="alert alert-danger" role="alert">Something went wrong, try again.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Email already exists.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Try again!.</div>';
    }
}
?>

<form name="frmRegistration" action="registration.php" method="post" onsubmit="return validateRegistration()">
    <fieldset>
        <div id="contentCentered">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Registration Page</h3>
                </div>

                <div class="panel-body">
                    <table>
                        <tr>
                            <td>
                                First Name:
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="First Name" name="firstName" size="20" maxlength="30" value="<?php if (isset($trimmed['firstName'])) echo $trimmed['firstName']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Last Name:
                            </td>
                            <td>
                                <input type="text" class="form-control" placeholder="Last Name" name="lastName" size="20" maxlength="30" value="<?php if (isset($trimmed['lastName'])) echo $trimmed['lastName']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Email:
                            </td>

                            <td>
                                <input type="text" class="form-control" placeholder="Email" name="email" size="20" maxlength="100" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Password:
                            </td>

                            <td>
                                <input type="password" class="form-control" placeholder="Password" name="password1" size="20" maxlength="20" />
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><input type="submit" class="btn btn-success" value="Register" /></td>
                        </tr>
                    </table>
                </div
            </div>
        </div>    
    </fieldset>
</form>

<?php include ('includes/footer.php'); ?>