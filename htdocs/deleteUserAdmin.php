<?php
    require '../connection.php';
    include ('includes/header.php');
    
    if(empty($_GET['id']) && $_SESSION['level'] != 1 ){
        header("Location: index.php");
    }else{
        $query = "delete from users where userId =" . $_GET['id'];
        $result = mysqli_query($con, $query);
        
        if(mysqli_affected_rows($con) == 1){
            header("Location: viewUsers.php?msg=User successfully deleted");
        }else{
            header("Location: viewUsers.php?msg=User was NOT deleted");
        }
    }
?>
