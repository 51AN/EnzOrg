<?php
if(isset($_POST["reset-password-submit"])){
$selector = $_POST["selector"];
$validator = $_POST["validator"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];
if(empty($password)||empty($confirmPassword)){
    header("location: create-new-password.php?newpassword=empty");
    exit();
}else if($password!=$confirmPassword){
    header("location: create-new-password.php?newpassword=passwordnotsame");
    exit();
}
$currentDate = date("U");
$conn = new mysqli('localhost','root','','spl');

$sql = "SELECT * FROM passwordreset WHERE passwordResetSelector = ? AND passwordResetExpires >= ?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error. prepare failed";
    exit();
}else{
    mysqli_stmt_bind_param($stmt,"ss",$selector,$currentDate);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if(!$row=mysqli_fetch_assoc($result)){
        echo "You need to resubmit your reset request. no row";
        exit();
    }else{
        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin,$row["passwordResetToken"]);
        if($tokenCheck === false){
            echo "You need re-submit your reset request. token check failed";
            exit();
        }elseif($tokenCheck ===true){
            $tokenEmail = $row["passwordResetEmail"];
            $sql = "SELECT * FROM users WHERE email=?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "There was an error. prepare failed..";
                exit();
            }else{
                mysqli_stmt_bind_param($stmt,"s",$tokenEmail);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if(!$row=mysqli_fetch_assoc($result)){
                    echo "There was an error . no row again";
                    exit();
                }else{
                    $sql="UPDATE users SET password=? WHERE email=?";
                    $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            echo "There was an error. 4";
                            exit();
                        }else{
                            // $newPasswordHash = password_hash($password,PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt,"ss",md5($password), $tokenEmail);
                            mysqli_stmt_execute($stmt);

                            $sql ="DELETE FROM passwordreset WHERE passwordResetEmail=?";
                            $stmt = mysqli_stmt_init($conn);
                            if(!mysqli_stmt_prepare($stmt,$sql)){
                                echo "There was an error 6";
                                exit();
                            }
                            else{
                                mysqli_stmt_bind_param($stmt,"s",$tokenEmail);
                                mysqli_stmt_execute($stmt);
                                header("location: ../login/index.php?newpassword=passwordUpdated");
                            }
                        }
                    }
                }
            }
    }
}
}else{
    header("location: ../Homepage/index.php");
}
?>