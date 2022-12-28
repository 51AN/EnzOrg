
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
    <title>Contact</title>
    <script src="https://kit.fontawesome.com/0bf31d5ed0.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
</head>

<?php
session_start();
$message = '';

if (isset($_SESSION['username']))
    $message = $_SESSION['username'];
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
                    <li><a href="#">CONTACT</a></li>
                </ul>
            </div>
        </nav>
        <section>
            <section class="contact">
                <div class="main">
                    
                    <div class="contact-text">
                        <h1> Contact<span> US</span></h1>
                    </div>
                </div>
                <div class="container">
                <img src="images/EnzOrg.png">
                    <div class="contactInfo">
                        <div class="box">
                            <div class="icon"><i class="fa fa-code" aria-hidden="true"></i></div>
                            <div class="text">
                                <h1>Sian Ashsad</h1>
                                <p>Lead Frontend Developer</p>
                                <p>Email: sianashsad@iut-dhaka.edu</p>
                                <p>Mobile: 01834464662</p>
                            </div>
                        </div>
                        <div class="box">
                            <div class="icon"><i class="fa fa-cog" aria-hidden="true"></i></div>
                            <div class="text">
                                <h1>Rhidwan Rashid</h1>
                                <p>Lead Backend Developer</p>
                                <p>Email: rhidwanrashid@iut-dhaka.edu</p>
                                <p>Mobile: 01643422862</p>
                            </div>
                        </div>
                        <div class="box">
                            <div class="icon"><i class="fa fa-code-fork" aria-hidden="true"></i></div>
                            <div class="text">
                                <h1>Nazmul Hossain</h1>
                                <p>Web Service and Quality Assurance</p>
                                <p>Email: nazmulhossain@iut-dhaka.edu</p>
                                <p>Mobile: 01533074149</p>
                            </div>
                        </div>
                        <div class="box">
                            <!-- <div class="icon"><i class="fa fa-cog" aria-hidden="true"></i></div> -->
                            <div class="icon"><i class="fa fa-user-secret" aria-hidden="true"></i></div>
                            <div class="text">
                                <h1>Md. Saidul Islam</h1>
                                <p>Supervisor</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </section>

</body>

</html>