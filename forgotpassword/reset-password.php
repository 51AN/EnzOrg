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
        $email = $_SESSION[$userEmail];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPass'];

        $conn = new mysqli('localhost','root','','spl');
        $query = $conn->query("SELECT * FROM users WHERE `email` = '$email';");


        if($password != $confirmPassword)
            $passError = "Passwords don't match";
        if(strlen($password) < 8 || ctype_upper($password) || ctype_lower($password))
            $passError1 = "Password must be atleast 8 character long and contain uppercase and lowercase";
        if(empty($passError) && empty($passError1))
        {
            if($conn -> connect_error){
                die('Connection Failed : ' .$conn->connect_error);
            }
            else{
                // $SQL="INSERT INTO `users`(`username`, `email`, `password`) VALUES ('$username','$email','$password')";
                // $result=mysqli_query($conn,$SQL);
                $stmt = $conn->prepare("insert into users(password) values(?)");
                $stmt ->bind_param("s", md5($password));
                $stmt -> execute();
                header('location: ../login/index.php');
                $stmt -> close();
                $conn -> close();
            } 
        }
    }

?>

<body>
    
    <div class="container">


        <!--Reset Password form-->
        <form action="http://localhost:3000/forgotpassword/reset-request.inc.php" method="POST" class="form" id="forgotAccount">
            <h1 class="form__title">Reset Password</h1>
            <div class="form__message form__message--error"></div>
            <div class="form__input-group">
                <input type="password" class="form__input" autofocus placeholder="Password" name="password" required>
                <div class="form__input-error-message">
                <?php echo $passError1? $passError1 : null; ?>
                </div>
            </div>
            <div class="form__input-group">
                <input type="password" class="form__input" autofocus placeholder="Confirm password" name="confirmPass" required>
                <div class="form__input-error-message">
                    <?php echo $passError? $passError : null; ?>
                </div>
            </div>
            <button class="form__button" type="submit" name="reset-request-submit">Continue</button>
            <p></br></p>
            <p class="form__text">
                <a href="../login/index.php" class="form__link">Back to log in.</a>
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
