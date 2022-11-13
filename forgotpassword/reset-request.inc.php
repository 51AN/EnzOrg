<?php
session_start();
include "testMail.php";
if(isset($_POST["reset-request-submit"])){
$selector = bin2hex(random_bytes(8));
$token = random_bytes(32);
$binToken = bin2hex($token);
$url = "http://localhost:3000/forgotpassword/create-new-password.php?selector=". urlencode($selector) . "&validator=" . urlencode($binToken);
$expires = date("U")+300;

$conn = mysqli_connect('localhost','root','','spl');
if(!$conn){
    die("Connection Failed: ".mysqli_connect_error());
}

$userEmail = $_POST["email"];
$sql = "DELETE FROM passwordreset WHERE passwordResetEmail=?";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
echo "There was an error 1";
exit();
}
else{
    mysqli_stmt_bind_param($stmt,"s",$userEmail);
    mysqli_stmt_execute($stmt);
}
$sql = "INSERT INTO passwordreset(passwordResetEmail,passwordResetSelector,passwordResetToken,passwordResetExpires) VALUES (?,?,?,?);";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt,$sql)){
echo "There was an error 2";
exit();
}
else{
    $hashedToken = password_hash($token,PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt,"ssss",$userEmail, $selector, $hashedToken, $expires);
    mysqli_stmt_execute($stmt);
}
mysqli_stmt_close($stmt);
mysqli_close($conn);

$to = $userEmail;
$subject = 'Reset you password';
$message = '<p>We recieved a password reset request. The link to reset your password is given below. If you did not make this request, you can ignore this email</p>';
$message .= '<p>Here is you password reset link: </br>';
$message .='<a href="'.$url.'">'.$url.'</a?></p>';

if(send_mail($to,$subject,$message))
{
    echo"Message sent";
}
else{
    echo"Message not sent";
}
header("location: ./index.php?reset=success");

}
else{
    header("location: ../Homepage/index.php");
}

?>