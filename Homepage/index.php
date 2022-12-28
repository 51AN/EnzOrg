<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
    <title>Homepage</title>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
</head>

<?php
    session_start();
    $message = '';

    if(isset($_SESSION['username']))
        $message = $_SESSION['username'];
?>

<body>
    <section class="header"> 
        <nav>
            <!--<div class="title__name">EnzOrg</div>-->
            <div class="nav-links">
                <ul>
                    <li><a href="#">HOME</a></li>
                    <li><a href="<?php echo $message ? '../Homepage/logout.php' : '../login/index.php';?>"><?php echo $message ? 'LOG OUT' : 'LOG IN';?></a></li>
                    <li><a href="<?php echo !$message ? '../register/index.php' : '../profile/index.php';?>"><?php echo $message ? $message : 'SIGN UP';?></a></li>
                    <li><a href="../about/index.php">ABOUT</a></li>
                    <li><a href="#">CONTACT</a></li>
                </ul>
            </div>
        </nav>

    <div class="text-box">
        <h1>Organize Your Life with EnzOrg</h1>
        <p> A powerful project management tool to get you involved with your everyday tasks<br>
        </p>
        <a href="<?php echo $message ? '../dashboard/index.php' : '../login/index.php';?>" class="start--btn">Get Started</a>
    </div>
    <section>

</body>
</html>