<?php

    $username = '';
    $email = '';
    $password = '';
    if(isset($_POST['submit'])){
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=$_POST['password'];
    }

    $conn = new mysqli('localhost','root','','spl');

    if($conn -> connect_error){
        die('Connection Failed : ' .$conn->connect_error);
    }
    else{
        // $SQL="INSERT INTO `users`(`username`, `email`, `password`) VALUES ('$username','$email','$password')";
        // $result=mysqli_query($conn,$SQL);
        $stmt = $conn->prepare("insert into users(username,email,password) values(?,?,?)");
        $stmt ->bind_param("sss",$username, $email, $password);
        $stmt -> execute();
        header('location: ../Homepage/index.html');
        $stmt -> close();
        $conn -> close();
    }


?>