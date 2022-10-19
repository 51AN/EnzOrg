<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Login / Sign Up Form</title>
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="./src/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
</head>

<?php
    session_start();

    $username = $password = $error = '';

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $conn = new mysqli('localhost','root','','spl');

        if($conn -> connect_error){
            die('Connection Failed : ' .$conn->connect_error);
        }
        else{
            $query = $conn->query("SELECT * FROM users WHERE `username` = '$username' AND `password` = '$password';");

            if($query->num_rows > 0)
            {
                $row = mysqli_fetch_assoc($query);
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['id'];
                header('location: ../Homepage/index.php');
            }    
            else
                $error = 'Invalid username/password!';
            //echo "Login successful!";
            $conn -> close();
    
        }

    }
?>

<body>
    <!--Login form-->
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="form" id="login">
            <h1 class="form__title">Login</h1>
            <div class="form__message form__message--error"></div>
            <div class="form__input-group">
                <input type="text" id="username" class="form__input" autofocus placeholder="Username or email" name="username" required>
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" id="password" class="form__input" autofocus placeholder="Password" name="password" required>
                <div class="form__input-error-message">
                    <?php echo $error ? $error : null; ?>
                </div>
            </div>
            <button class="form__button" type="submit" name="submit">Continue</button>
            <p class="form__text">
                <a href="../forgotpassword/index.php" class="form__link" class="form__link">Forgot your password?</a>
            </p>
            <p class="form__text">
                <a class="form__link" href="../register/index.php" id="linkCreateAccount">Don't have an account? Create account</a>
            </p>
        </form>
    
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script> -->
    <!-- <script src="./src/main.js"></script> -->
</body>
