<!DOCTYPE html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Reset Password</title>
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="./src/main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
</head>
<!--Forgot Password form-->
        
<?php
        $passError = $passError1 =$password = $confirmPassword = '';
        $selector= $validator = 'muri';
        $selector =$_GET['selector'];
        $validator = $_GET['validator'];
        if(empty($selector)||empty($validator)){
            echo"Could not validate your request!";
        }else{
            if(ctype_xdigit($selector)!==false && ctype_xdigit($validator)!==false){
                if(isset($_POST['reset-password-submit'])){
                    $password = $_POST['password'];
                    $confirmPassword = $_POST['confirmPassword'];
            
                    $conn = new mysqli('localhost','root','','spl');
            
            
                    if($password != $confirmPassword)
                        $passError = "Passwords don't match";
                    if(strlen($password) < 8 || ctype_upper($password) || ctype_lower($password))
                        $passError1 = "Password must be atleast 8 character long and contain uppercase and lowercase";
        
                }
                ?>
                <body>
                <div class="container">
                <h1 class="form__title">Reset Password</h1>
                <div class="form__message form__message--error"></div>
                <form action="reset-password.inc.php" method="POST">
                        <input type ="hidden" name="selector" value="<?php echo $selector; ?>">
                        <input type ="hidden" name="validator" value="<?php echo $validator; ?>">
                        <div class="form__input-group">
                        <div class="form__input-group">
                <input type="password" class="form__input" autofocus placeholder="Enter a New Password" name="password" required>
                <div class="form__input-error-message">
                <?php echo $passError1? $passError1 : null; ?>
                </div>
            </div>
            <div class="form__input-group">
                <input type="password" class="form__input" autofocus placeholder="Confirm New Password" name="confirmPassword" required>
                <div class="form__input-error-message">
                    <?php echo $passError? $passError : null; ?>
                </div>
            </div>
                        <button class="form__button" type="submit" name="reset-password-submit">Continue</button>
                </form>
                </div>
                </body>
            </main>
                <?php
            }
        }
        ?>

        