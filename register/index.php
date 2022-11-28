<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Sign Up Form</title>
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="./src/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
</head>

<?php
    $username = $email = $passError = $passError1 = $emailError = $userError = $password = $confirmPassword = '';
    if(isset($_GET['userError'])){
        $userError =  $_GET['userError'];
    }
    if(isset($_GET['emailError'])){
        $emailError =  $_GET['emailError'];
    }

    if(isset($_GET['passError'])){
        $passError =  $_GET['passError'];
    }

    if(isset($_GET['emailError1'])){
        $emailError =  $_GET['emailError1'];
    }

    if(isset($_GET['passError1'])){
        $passError1 =  $_GET['passError1'];
    }
?>
<body>
    
    <div class="container">


        <!--Registration form-->
        <form action="create-account.inc.php" method="POST" class="form" id="createAccount">
            <h1 class="form__title">Create Account</h1>
            <div class="form__message form__message--error"></div>
            <div class="form__input-group">
                <input type="text" id="signupUsername" class="form__input" autofocus placeholder="Username" name="username" required>
                <div class="form__input-error-message">
                    <?php echo $userError ? $userError : null; ?>
                </div>
            </div>
            <div class="form__input-group">
                <input type="text" class="form__input" autofocus placeholder="Email Address" name="email" required>
                <div class="form__input-error-message">
                    <?php echo $emailError ? $emailError : null; ?>
                </div>
            </div> 
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

            <button class="form__button" type="submit" name="submit">Continue</button>
            <p class="form__text">
                <a class="form__link" href="../login/index.php" id="linkLogin">Already have an account? Sign in</a>
            </p>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <!-- <script src="./src/main.js"></script> -->
</body>
