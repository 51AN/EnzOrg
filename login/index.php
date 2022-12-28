<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Login Form</title>
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
        $password = $_POST['password'];
        $conn = new mysqli('localhost','root','','spl');

        if($conn -> connect_error){
            die('Connection Failed : ' .$conn->connect_error);
        }
        else{
            $sql ="SELECT * FROM users WHERE `username` = ? LIMIT 1";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "There was an error in preparing";
                exit();
            }
            else{
                mysqli_stmt_bind_param($stmt,"s",$username);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if(!$row=mysqli_fetch_assoc($result)){
                    $error = 'Invalid username!';
                }
                else
                {
                    if(password_verify($password,$row['password']))
                    {
                        if($row['is_verified']==1)
                        {
                            $_SESSION['username'] = $username;
                            $_SESSION['user_id'] = $row['id'];
                            header('location: ../Homepage/index.php');
                        }
                        else
                        {
                            $error = 'Account is not verified!';
                        }
                    }
                    else{
                        $error = 'Invalid password!';
                    }
                }
                $conn -> close();
            }
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
                <input type="text" id="username" class="form__input" autofocus placeholder="Enter Username" name="username" required>
                <div class="form__input-error-message"></div>
            </div>
            <div class="form__input-group">
                <input type="password" id="password" class="form__input" autofocus placeholder="Enter Password" name="password" required>
                <div class="form__input-error-message">
                    <?php echo $error ? $error : null; ?>
                </div>
            </div>
            <button class="form__button" type="submit" name="submit">Continue</button>
            <?php 
            if(isset($_GET["newpassword"]))
            {
                if($_GET["newpassword"]=="passwordUpdated"){
                    echo'<p>Your password has been reset.</p>';
                }
            }
            if(isset($_GET["user_create"]))
            {
                if($_GET["user_create"]=="success"){
                    echo'<p>Check your email for email verification.</p>';
                }
            }
            if(isset($_GET["token"]))
            {
                if(isset($_GET["create_user"])){
                    $conn = new mysqli('localhost','root','','spl');
                    if($conn -> connect_error){
                        die('Connection Failed : ' .$conn->connect_error);
                    }
                    else{
                        $user_name = $_GET["create_user"];
                        $stmt = $conn->prepare("update users set is_verified = 1 where token=? and username = ?");
                        $stmt ->bind_param("ss",$_GET["token"],$user_name);
                        $stmt -> execute();
                        if(mysqli_affected_rows($conn)<=0)
                            echo'<p>There was an error while creating your account and the link is now Invalid. Try to create your account again!</p>';
                        else{
                            echo'<p>Your accout has been registered! You may now log in.</p>';
                        }
                        $stmt -> close();
                        $conn -> close();
                    }
                }
            }
            ?>
            <p class="form__text">
                <a href="../forgotpassword/index.php" class="form__link" class="form__link">Forgot your password?</a>
            </p>
            <p class="form__text">
                <a class="form__link" href="../register/index.php" id="linkCreateAccount">Don't have an account? Create account</a>
            </p>
            <p class="form__text">
                <a class="form__link" href="../Homepage/index.php" id="linkHomepage">Go back to Homepage</a>
            </p>
        </form>
    
    </div>
    <!-- <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script> -->
    <!-- <script src="./src/main.js"></script> -->
</body>
