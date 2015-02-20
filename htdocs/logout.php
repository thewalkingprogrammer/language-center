<?php
    require '../connection.php';
    include ('includes/header.php');
    if(!isset($_SESSION['userId'])){
        header("Location: index.php");
    }else{
        $_SESSION =array();
        session_destroy();
        header("Location: index.php");
    }
?>
