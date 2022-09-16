<?php
    
    $username = '';
    $password = '';
    if(isset($_POST['submit'])){
        $username=$_POST['username'];
        $password=$_POST['password'];

    }

    $conn = new mysqli('localhost','root','','spl');

    if($conn -> connect_error){
        die('Connection Failed : ' .$conn->connect_error);
    }
    else{
        $query = "SELECT * FROM users WHERE `username` = '$username' AND `password` = '$password';";
        $result = mysqli_query($conn, $query);
        //echo "Login successful!";
        header('location: ../Homepage/index.html');
        $conn -> close();

    }

    ?>