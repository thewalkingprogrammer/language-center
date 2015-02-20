<?php
    define('USER', 'root');
    define('PASSWORD', '');
    define('HOST', 'localhost');
    define('DATABASE', 'foreignlanguagecenter');
    
    $con = @mysqli_connect(HOST, USER, PASSWORD, DATABASE);
    
    if(!$con){
        trigger_error('Connection to the database was not possible!');       
    }else{
        mysqli_set_charset($con, 'utf8');
    }

