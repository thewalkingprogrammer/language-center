<?php
require '../connection.php';
$pageTitle = 'Update User';
include ('includes/header.php');

if ($_SESSION['level'] == 1) {
    
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
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
            echo '<p class="error">First name is required</p>';
        }

        if (!empty($_POST['lastName'])) {
            $lName = mysqli_real_escape_string($con, $_POST['lastName']);
        } else {
            $lName = false;
            echo '<p class="error">Last name is required</p>';
        }

        if (!empty($_POST['email'])) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $email = mysqli_real_escape_string($con, $_POST['email']);
            }else{
                $email = false;
                echo '<p class="error">Not right format for email</p>';
            }
        } else {
            $email = false;
            echo '<p class="error">Email is required</p>';
        }

        if ($fName && $lName && $email) {
            if($_SESSION['tempEmail'] == $email){
                $query = "update users set fName = '$fName', lName ='$lName' where userId=" . $_SESSION['tempId'];
            }else{
                $query = "update users set fName = '$fName', lName ='$lName', email ='$email' where userId=" . $_SESSION['tempId'];
            }
            
            $result = mysqli_query($con, $query) or trigger_error('Query is wrong!');

            if (mysqli_affected_rows($con) == 1) {
                header("Location: viewUsers.php?msg2=User successfully updated");
            } else {
                echo '<p class="error">Email already exists.</p>';
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
<form name="frmEditUserAdmin" action="editUserAdmin.php" method="post" onsubmit="validateEditUser()">
    <fieldset>
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
                <td><input type="submit" value="Update Profile" /></td>
            </tr>
        </table>
    </fieldset>
</form>

<?php include ('includes/footer.php'); ?>