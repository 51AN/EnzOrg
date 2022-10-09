<?php

    if(isset($_POST['login'])){

        $conn = new mysqli('localhost','root','','spl');
        $username = $conn->real_escape_string($_POST['usernamephp']);
        $password = $conn->real_escape_string($_POST['passwordphp']);

        if($conn -> connect_error){
            die('Connection Failed : ' .$conn->connect_error);
        }
        else{
            $query = $conn->query("SELECT * FROM users WHERE `username` = '$username' AND `password` = '$password';");

            if($query->num_rows > 0)
            {
                //header('location: ../Homepage/index.html');
                exit("success");
            }    
            else
                exit("failed");
            //echo "Login successful!";
            $conn -> close();
    
        }

    }

?>