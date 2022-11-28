<?php
session_start();
include "../forgotpassword/testMail.php";
$username = $email = $passError = $passError1 = $emailError = $userError = $password = $confirmPassword = '';

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPass'];
        $image = '';
        $token = bin2hex(random_bytes(16));
        $conn = new mysqli('localhost','root','','spl');
        $query = $conn->query("SELECT * FROM users WHERE `username` = '$username';");


        if($password != $confirmPassword)
            $passError = "Passwords don't match";
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            $emailError = "Invalid Email";
        if($query->num_rows > 0)
            $userError = "Username already exists";
        if(strlen($password) < 8 || ctype_upper($password) || ctype_lower($password))
            $passError1 = "Password must be atleast 8 character long and contain uppercase and lowercase";
        if(empty($passError) && empty($emailError) && empty($userError) && empty($passError1))
        {
            if($conn -> connect_error){
                die('Connection Failed : ' .$conn->connect_error);
            }
            else{
                // $SQL="INSERT INTO `users`(`username`, `email`, `password`, `token`) VALUES ('$username','$email','$password','$token')";
                // $result=mysqli_query($conn,$SQL);
                $stmt = $conn->prepare("insert into users(username,email,password,image,token) values(?,?,?,?,?)");
                $stmt ->bind_param("sssss",$username, $email, password_hash($password,PASSWORD_DEFAULT), $image,$token);
                $stmt -> execute();
                $stmt -> close();
                $conn -> close();
                $url = "http://localhost:3000/login/index.php?token=" . urlencode($token)."&create_user=".urlencode($username);
                $to = $email;
                $subject = 'Confirm Account Creation!';
                $message = '<p>Welcome to EnzOrg. Organize your work, the smart way! Before we can begin, we must first confirm your email. This will allow us to help you recover your account when you forget your password or keep others from registering under your email. If you did not make this request, you can ignore this email</p>';
                $message .= '<p>Here is the account creation confirmation link: </br>';
                $message .='<a href="'.$url.'">'.$url.'</a?></p>';

                if(send_mail($to,$subject,$message))
                {
                    echo "Check your Mail";
                }
                else{
                    echo"Mail not sent";
                }
                header("location: ../login/index.php?user_create=success");
            }
        }
        else{
            if(!empty($userError)){
                header("location: ../register/index.php?userError=".$userError);
            }
            else if(!empty($emailError)){
                header("location: ../register/index.php?emailError=".$emailError);
            }
            else if(!empty($passError)){
                
                header("location: ../register/index.php?passError=".$passError);
            }
            else if(!empty($passError1)){
                header("location: ../register/index.php?passError1=".$passError1);
            }

        }
    }
?>