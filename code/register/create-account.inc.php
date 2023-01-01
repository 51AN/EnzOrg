<?php
session_start();
include "../forgotpassword/testMail.php";
$username = $email = $passError = $passError1 = $emailError=$emailError1 = $userError = $password = $confirmPassword = '';

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPass'];
        $image = '';
        $token = random_bytes(16);
        $binToken = bin2hex($token);
        $conn = new mysqli('localhost','root','','spl');
        // $query = $conn->query("SELECT * FROM users WHERE `username` = '$username';");
        

        // $sql = "INSERT INTO passwordreset(passwordResetEmail,passwordResetSelector,passwordResetToken,passwordResetExpires) VALUES (?,?,?,?);";
        $sql = "SELECT * FROM users WHERE username = ?;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "There was an error preparing.";
        exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
        }



        $sql = "SELECT * FROM users WHERE email = ? AND is_verified = 0;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "There was an error preparing.";
        exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s",$email);
            mysqli_stmt_execute($stmt);
            $qry = mysqli_stmt_get_result($stmt);
            if(mysqli_num_rows($qry) > 0)
            {
                $sql1 = "DELETE FROM users WHERE email = ? AND is_verified = 0;";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt,$sql1)){
                echo "There was an error preparing.";
                exit();
                }
                else{
                    mysqli_stmt_bind_param($stmt,"s",$email);
                    mysqli_stmt_execute($stmt);
                }
            }
        }


        $sql = "SELECT * FROM users WHERE email = ? AND is_verified = 1;";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt,$sql)){
        echo "There was an error preparing.";
        exit();
        }
        else{
            mysqli_stmt_bind_param($stmt,"s",$email);
            mysqli_stmt_execute($stmt);
            $query = mysqli_stmt_get_result($stmt);
        }


        if($password != $confirmPassword)
            $passError = "Passwords don't match";
        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            $emailError = "Invalid Email";
        if(mysqli_num_rows($result) > 0)
            $userError = "Username already exists";
        if(strlen($password) < 8 || ctype_upper($password) || ctype_lower($password))
            $passError1 = "Password must be atleast 8 character long and contain uppercase and lowercase";
        if(mysqli_num_rows($query) > 0){
            $emailError1 = "An account already exists under this email in our database";
        }
        if(empty($passError) && empty($emailError) && empty($userError) && empty($passError1) && empty($emailError1))
        {
            if($conn -> connect_error){
                die('Connection Failed : ' .$conn->connect_error);
            }
            else{
                // $SQL="INSERT INTO `users`(`username`, `email`, `password`, `token`) VALUES ('$username','$email','$password','$token')";
                // $result=mysqli_query($conn,$SQL);
                $stmt = $conn->prepare("insert into users(username,email,password,image,token) values(?,?,?,?,?)");
                $stmt ->bind_param("sssss",$username, $email, password_hash($password,PASSWORD_DEFAULT), $image,$binToken);
                $stmt -> execute();
                $stmt -> close();
                $conn -> close();
                $url = "http://localhost:3000/login/index.php?token=" . urlencode($binToken)."&create_user=".urlencode($username);
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
            else if(!empty($emailError1)){
                header("location: ../register/index.php?emailError1=".$emailError1);
            }
            else if(!empty($passError)){
                
                header("location: ../register/index.php?passError=".$passError);
            }
            else if(!empty($passError1)){
                header("location: ../register/index.php?passError1=".$passError1);
            }
            else{
                header("location: ../register/index.php?unknownError=bhai_eikhane_ki_hoise_ami_jani_na");
            }
            

        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
?>