<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
    <title>Help and Support</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
</head>

<?php
session_start();
include "../forgotpassword/testMail.php";
$message = '';

if (isset($_SESSION['username']))
    $message = $_SESSION['username'];

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mes = $_POST['mes'];
    $to = "enzorg4532@gmail.com";
    $subject = "Help and Support Request From ".$name.".\n";
    $request = $name." has reached out for help.\n";
    $request .= "The email ID they provided is: ".$email."\n";
    $request .= "The message they left: \n".$mes;
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailError = "Invalid Email";
            echo $emailError;
    }
    else
    {
        send_mail($to,$subject,$request);
    }
}
?>

<body>
    <section class="header">
        <nav>
            <!--<div class="title__name">EnzOrg</div>-->
            <div class="nav-links">
                <ul>
                    <li><a href="../Homepage/index.php">HOME</a></li>
                    <li><a href="<?php echo $message ? '../Homepage/logout.php' : '../login/index.php'; ?>"><?php echo $message ? 'LOG OUT' : 'LOG IN'; ?></a></li>
                    <li><a href="<?php echo !$message ? '../register/index.php' : '../profile/index.php'; ?>"><?php echo $message ? $message : 'SIGN IN'; ?></a></li>
                    <li><a href="../about/index.php">ABOUT</a></li>
                    <li><a href="../contact/index.php">CONTACT</a></li>
                </ul>
            </div>
        </nav>
        <section>
            <section class="support">
                <div class="main">
                    <div class="support-text">
                        <h1> Help and<span> Support</span></h1>    
                                          
                        
                    </div>
                </div>
                <div class = "container">
                <div class ="supportForm">
                <h4>For any type of query, please leave us a message.</h4> 
                <h4>A support agent will reach out within 1-2 business days.</h4>  
                            <form method="POST">
                                <div class="inputBox">
                                    <input type= "text" autofocus placeholder="Full Name" name ="name"  required="required">
                                </div>
                                <div class="inputBox">
                                    <input type= "text"autofocus placeholder="Email Address" name ="email" required="required">
                                </div>
                                <div class="inputBox">
                                    <textarea name ="mes" autofocus placeholder="Type Your Message" required="required"></textarea>
                                </div>
                                <div class="inputBox">
                                    <button type="submit" name="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                </div>
            </section>
        </section>

</body>

</html>