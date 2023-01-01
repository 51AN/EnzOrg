<?php
include "testMail.php";
// send_mail($recipient,$subject,$message);
if(send_mail("nazmulhossain@iut-dhaka.edu","test mail","This is a test email for the mail server"))
{
    echo"Message sent";
}
else{
    echo"Message not sent";
}
?>
