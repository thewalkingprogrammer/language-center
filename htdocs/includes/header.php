<?php
    ob_start();
    session_start();
    
    if(!isset($pageTitle)){
        $pageTitle = 'User Registration';
    }
?>

<html>
    <head>
        <title><?php echo $pageTitle; ?></title>
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

        <!-- Optional theme -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
        <style>
            #contentCentered{
                width: 50%;
                margin-top: 50px;
                margin-left: auto;
                margin-right: auto;
            }
            
            table{
                border-collapse: separate;
                border-spacing: 10px;
            }
            
            input[type="radio"] {
                margin-left: 10px;
            }
        </style>
        
        <script src="validate.js"></script>
    </head>
    
    <body>
                <nav class="navbar navbar-inverse" role="navigation">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="index.php">Foreign Language Center</a>
                    </div>
                    
                    <div>                        
                    <ul class="nav navbar-nav">
                    <li><a href="index.php" title="Home Page">Home</a></li>
                <?php
                if(isset($_SESSION['userId'])){
                    echo '<li><a href="lecture.php?lang=1" title="Japanese">Japanese </a></li>';
                    echo '<li><a href="lecture.php?lang=2" title="Korean">Korean </a></li>';
                    if($_SESSION['level'] == 1){
                        echo '<li><a href="viewUsers.php" title="Users">View / Edit Users </a></li>';
                        echo '<li><a href="viewLectures.php" title="Lectures">View / Edit Lectures </a></li>';
                        echo '<li><a href="viewRequests.php" title="Requests">Requests </a></li>';
                    }
                    if($_SESSION['level'] == 0){
                        echo '<li><a href="sendRequest.php" title="Lectures">Send Request </a></li>';
                    }
                    echo '<li><a href="contact.php" title="Contact">Contact </a></li>';
                    echo '<li><a href="updateProfile.php" title="Update Profile">Update Profile </a></li>';
                    echo '<li><a href="logout.php" title="Logout">Logout </a></li>';
                }else{
                    echo '<li><a href="login.php" title="Login">Login </a></li>';
                    echo '<li><a href="registration.php" title="Register">Register </a></li>';
                    echo '<li><a href="contact.php" title="Contact">Contact </a></li>';
                    echo '<li><a href="forgotPassword.php" title="Forgot Password">Forgot Password </a></li>';
                }
                ?>
                    </div>
                </nav>      