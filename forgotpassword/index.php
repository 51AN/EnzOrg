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
// session_start();
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\Exception;

// function send_password($get_username,$get_email,$get_password){
//     $mail = new PHPMailer(true);

// try {
//     //Server settings
//     $mail->isSMTP();                                            //Send using SMTP
//     $mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
//     $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
//     $mail->Username   = 'user@example.com';                     //SMTP username
//     $mail->Password   = 'secret';                               //SMTP password
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
//     $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

//     //Recipients
//     $mail->setFrom('nazmul4532@gmail.com', $get_email);
//     $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
//     $mail->addAddress('ellen@example.com');               //Name is optional
//     $mail->addReplyTo('info@example.com', 'Information');
//     $mail->addCC('cc@example.com');
//     $mail->addBCC('bcc@example.com');

//     //Attachments
//     $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
//     $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

//     //Content
//     $mail->isHTML(true);                                  //Set email format to HTML
//     $mail->Subject = 'Here is the subject';
//     $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
//     $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

//     $mail->send();
//     echo 'Message has been sent';
// } catch (Exception $e) {
//     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// }

  
// }

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
        <form action="http://localhost:3000/forgotpassword/reset-request.inc.php" method="POST" class="form" id="forgotAccount">
            <h1 class="form__title">Reset Password</h1>
            <div class="form__message form__message--error"></div>
            <div class="form__input-group">
                <input type="text" class="form__input" autofocus placeholder="Email Address" name="email" required>
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
