<?php
    $conn = new mysqli('localhost','root','','spl');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="with=device-width, initial-scale=1.0">
                <title>Project Board</title>
                <link rel="stylesheet" href="styles.css">
                <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
    </head>


<body>

<?php
    session_start();
    $message = '';

    if(isset($_SESSION['username']))
        $message = $_SESSION['username'];
?>

<?php
    $projname = $projdes = $priority = $projstatus = $due = '';
    $userId = $_SESSION['user_id'];
    if(isset($_POST['addprojectsubmit']))
    {
        $projname = htmlspecialchars($_POST['projectname']);
        $projdes = htmlspecialchars($_POST['description']);
        $priority = $_POST['priority'];
        $projstatus = $_POST['status'];
        $due = $_POST['duetime'];

        if(!empty($projname) && !empty($projdes) && !empty($priority) && !empty($projstatus))
        {
            $query = mysqli_query($conn, "INSERT INTO `projects` (`projname`, `projdescription`, `priority`, `projstatus`, `tasks`, `due`, `user_id`) VALUES ('$projname', '$projdes', '$priority', '$projstatus', '1', '$due', '$userId')");
            header('Location: '.$_SERVER['PHP_SELF'].'?success');
        }  
    }
?>

<?php
    $fetch = mysqli_query($conn, "SELECT * FROM projects WHERE user_id = $userId");
    $projects = mysqli_fetch_all($fetch, MYSQLI_ASSOC);
?>

<?php
    if(isset($_POST['deleteprojectsubmit']))
    {
        $selected = htmlspecialchars($_POST['delproj']);
        $del = mysqli_query($conn, "DELETE FROM `projects` WHERE projname = '$selected' AND user_id = $userId");
        header('Location: '.$_SERVER['PHP_SELF'].'?success');
    }
?>

<!--  section of the whole page -->
<section class="header">
    <!--  nav bar begins here -->
    <nav>
    <div class="task__name"><b>Task Name</b></div>
        <!--<div class="title__name">EnzOrg</div>-->
        <div class="nav-links">
            <ul>
                <!-- elements of nav bar  -->
                <li><a href="../Homepage/index.php">HOME</a></li>
                <li><a href="../login/index.php">LOG OUT</a></li>
                <!-- Write profile name here -->
                <?php echo '<li><a href="../profile/index.php">'.$message.'</a></li>';?>
                <li><a href="../about/index.php">ABOUT</a></li>
                <li><a href="#">CONTACT</a></li>
                <li><a href="../settingstask/index.php">SETTINGS</a></li>
            </ul>
        </div>
    </nav>


</section>

</body>
</html>