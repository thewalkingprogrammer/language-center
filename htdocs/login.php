<?php
require '../connection.php';
$pageTitle = 'Login';
include ('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['email'])) {
        $email = mysqli_real_escape_string($con, $_POST['email']);
    } else {
        $email = false;
        echo '<div class="alert alert-danger" role="alert">Email is required</div>';
    }

    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($con, $_POST['password']);
    } else {
        $password = false;
        echo '<div class="alert alert-danger" role="alert">Password is required</div>';
    }

    if ($email && $password) {
        $query = 'select userId, fName, lName, email, pass, level, dateRegistered ' .
                'from users where email="' . $email . '" and pass="' . $password . '"';
        $result = mysqli_query($con, $query) or trigger_error("Wrong query");

        if (mysqli_num_rows($result) == 1) {
            $_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
            header("Location: index.php");
        } else {
            echo '<div class="alert alert-danger" role="alert">Email or password incorrect</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Something went wrong try again later</div>';
    }
}
?>

<form action="login.php" method="post">
    <fieldset>
        <div id="contentCentered">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Login Page</h3>
                </div>

                <div class="panel-body">
                    <table>
                        <tr>
                            <td>Email: </td>
                            <td><input type="text" class="form-control" placeholder="Email" name="email" /></td>
                        </tr>
                        <tr>
                            <td>Password: </td>
                            <td><input type="password" class="form-control" placeholder="Password" name="password" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" class="btn btn-success" value="Login"</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>            
    </fieldset>
</form>

<?php include ('includes/footer.php'); ?>