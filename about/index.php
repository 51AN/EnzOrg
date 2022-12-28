<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
    <title>About Us</title>
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
                    <li><a href="../contact/index.php">CONTACT</a></li>
                </ul>
            </div>
        </nav>
        <section>
            <section class="about">
                <div class="main">
                    <img src="images/EnzOrg.png">
                    <div class="about-text">
                        <h1> About Us</h1>
                        <h5>Organize Your Work,<span> The Smart Way</span></h5>
                        <p>EnzOrg is a task/project management website which enables users to maintain and monitor everyday tasks both on a personal and group level. Collaborate, manage projects, and become more organized with EnzOrg.</p>
                        <a href="<?php echo $message ? '../Homepage/index.php' : '../login/index.php';?>" class="start--btn">Let's Begin</a>
                    </div>
                </div>
            </section>

</body>

</html>