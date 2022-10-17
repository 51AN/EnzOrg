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

    if(isset($_SESSION['username']))
        echo '<h1>Welcome ' . $_SESSION['username'] . '!</h1>';
    else
        echo '<h1>Welcome Guest!</h1>';
?>

<body>
    <a href="logout.php"><h3>Logout</h3></a>
    <section class="header"> 
        <nav>
            <!--<div class="title__name">EnzOrg</div>-->
            <div class="nav-links">
                <ul>
                    <li><a href="#">HOME</a></li>
                    <li><a href="../login/index.php">LOG IN</a></li>
                    <li><a href="../register/index.php">SIGN IN</a></li>
                    <li><a href="#">ABOUT</a></li>
                    <li><a href="#">CONTACT</a></li>
                </ul>
            </div>
        </nav>

    <div class="text-box">
        <h1>Organize your Life with EnzOrg</h1>
        <p> A powerful project management tool to get you involved with your everyday tasks<br>
        </p>
        <a href="../dashboard/index.php" class="start--btn">Get Started</a>
    </div>
    <section>

</body>
</html>