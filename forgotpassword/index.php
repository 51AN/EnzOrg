<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Forgot Password</title>
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="./src/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
</head>

<?php

    $username = $email = $passError = $passError1 = $emailError = $userError = $password = $confirmPassword = '';

    if(isset($_POST['submit'])){
        $conn = new mysqli('localhost','root','','spl');
    //     $email = mysqli_real_escape_string($conn,$_POST['email']);
    //     $token = md5(rand());

    //     $query = $conn->query("SELECT * FROM users WHERE `email` = '$email' LIMIT 1");
    //     $check_query = mysqli_query($conn,$query);
    //     if(mysqli_num_rows($check_query)>0)
    //     {
    //         $row = mysqli_fetch_array($check_query);
    //         $get_username = $row['username'];
    //         $get_email = $row['email'];
    //         $get_password = $row['password'];

    //         $update_token= "UPDATE users SET verify_token='$token' WHERE email='$get_email' LIMIT 1";
    //         $update_token_run=mysqli_query($conn,$update_token);
    //         if($update_token_run)
    //         {
    //             send_password($get_username,$get_email,$get_password);
    //             $_SESSION['status']="We sent you an email with the password";
    //             header('location: ../forgotpassword/index.php');
    //             exit(0);
    //         }
    //         else
    //         {
    //             $_SESSION['status']="Something went wrong. #1";
    //             header('location: ../forgotpassword/index.php');
    //             exit(0);
    //         }
    //     }
    //     else
    //     {
    //         $_SESSION['status']="No Email Found";
    //         header('location: ../forgotpassword/index.php');
    //     }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL))
            $emailError = "Invalid Email";
        if(empty($emailError))
        {
            if($conn -> connect_error){
                die('Connection Failed : ' .$conn->connect_error);
            }
            else{//Update here
                // $SQL="INSERT INTO `users`(`username`, `email`, `password`) VALUES ('$username','$email','$password')";
                // $result=mysqli_query($conn,$SQL);
                // $stmt = $conn->prepare("insert into users(username,email,password) values(?,?,?)");
                // $stmt ->bind_param("sss",$username, $email, md5($password));
                // $stmt -> execute();
                // header('location: ../login/index.php');
                // $stmt -> close();
                // $conn -> close();

                $query = $conn->query("SELECT * FROM users WHERE `email` = '$email' LIMIT 1");
                $check_query = mysqli_query($conn,$query);
                if(mysqli_num_rows($check_query)>0)
                {
                    $row = mysqli_fetch_array($check_query);
                    $get_username = $row['username'];
                    $get_email = $row['email'];
                    $get_password = $row['password'];
                    $_SESSION['password']="$get_password";
                } 
            }
        }
    }

?>

<body>
    
    <div class="container">


        <!--Forgot Password form-->
        <form action="reset-request.inc.php" method="POST" class="form" id="forgotAccount">
            <h1 class="form__title">Forgot Password?</h1>
            <h6>An e-mail will be sent to you about resetting your password shortly.</h6>
            <div class="form__message form__message--error"></div>
            <div class="form__input-group">
                <input type="text" class="form__input" autofocus placeholder="Enter Your Email Address" name="email" required>
                <div class="form__input-error-message">
                    <?php echo $emailError ? $emailError : null; ?>
                </div>
            </div> 
            <button class="form__button" type="submit" name="reset-request-submit">Continue</button>
            <p class="form__text">
                <a class="form__link" href="../login/index.php" id="linkLogin">Remember account details? Sign in</a>
            </p>
        </form>
        <?php
        if(isset($_GET["reset"])){
            if($_GET["reset"]=="success"){
                echo'<p class="form__message form__message--error">Check your Email</p>';
            }
        }
        ?>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- <script src="./src/main.js"></script> -->
</body>
