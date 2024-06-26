<?php
include "../dbconnect.php";
?>
<?php
if(isset($_POST["reset-password-submit"])){
$selector = $_POST["selector"];
$validator = $_POST["validator"];
$password = $_POST["password"];
$confirmPassword = $_POST["confirmPassword"];

if($password!=$confirmPassword){
    header("location: create-new-password.php?newpassword=passwordnotsame&selector=".$selector."&validator=".$validator);
    exit();
}else if(strlen($password) < 8){
    header("location: create-new-password.php?newpassword=error1&selector=".$selector."&validator=".$validator);
    exit();
}else if(ctype_upper($password) || ctype_lower($password)){
    header("location: create-new-password.php?newpassword=error2&selector=".$selector."&validator=".$validator);
    exit();
}
$currentDate = date("U");
$sql = "SELECT * FROM passwordreset WHERE passwordResetSelector = ? AND passwordResetExpires >= ?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
    echo "There was an error.";
    exit();
}else{
    mysqli_stmt_bind_param($stmt,"ss",$selector,$currentDate);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
    if(!$row=mysqli_fetch_assoc($result)){
        header("location: index.php?reset=tokenExpired");
        exit();
    }else{
        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin,$row["passwordResetToken"]);
        if($tokenCheck === false){
            header("location: index.php?reset=tokenFail");
            exit();
        }elseif($tokenCheck ===true){
            $tokenEmail = $row["passwordResetEmail"];
            $sql = "SELECT * FROM users WHERE email=?;";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt,$sql)){
                echo "There was an error . no row again";
                    exit();
            }else{
                mysqli_stmt_bind_param($stmt,"s",$tokenEmail);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if(!$row=mysqli_fetch_assoc($result)){
                    header("location: index.php?reset=userdoesnotexist");
                    exit();
                }else{
                    $sql="UPDATE users SET password=? WHERE email=?";
                    $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt,$sql)){
                            echo "There was an error.";
                            exit();
                        }else{
                            // $newPasswordHash = password_hash($password,PASSWORD_DEFAULT);
                            mysqli_stmt_bind_param($stmt,"ss",password_hash($password,PASSWORD_DEFAULT), $tokenEmail);
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
                            $conn->close();
                        }
                    }
                }
            }
    }
}
}else{
    $conn->close(); 
    header("location: ../Homepage/index.php");
}
?>