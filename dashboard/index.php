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
        // $projname = $_POST['projectname'];
        $projname = filter_var($_POST['projectname'], FILTER_SANITIZE_STRING);
        $projdes = $_POST['description'];
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
    if(isset($_POST['delete_button'])){
        // $delete = mysqli_query($conn, "DELETE FROM `projects` WHERE user_id = $userId");
        // header('Location: '.$_SERVER['PHP_SELF'].'?success');
        echo "working";
    }
?>

<?php
    $fetch = mysqli_query($conn, "SELECT * FROM projects WHERE user_id = $userId");
    $projects = mysqli_fetch_all($fetch, MYSQLI_ASSOC);
?>
<!--  section of the whole page -->
<section class="header">
    <!--  nav bar begins here -->
    <nav>
        <!--<div class="title__name">EnzOrg</div>-->
        <div class="nav-links">
            <ul>
                <!-- elements of nav bar  -->
                <li><a href="../Homepage/index.php">HOME</a></li>
                <li><a href="../login/index.php">LOG OUT</a></li>
                <!-- Write profile name here -->
                <?php echo '<li><a href="../profile/index.php">'.$message.'</a></li>';?>
                <li><a href="#">ABOUT</a></li>
                <li><a href="#">CONTACT</a></li>
            </ul>
        </div>
    </nav>

    <!-- task entry form here  -->
<div class="row_project">
    <div class="col_project_entry">    
        <form action="" class="project_form" method="POST" id="">
            <h1 class="project_title"> Add Project </h1>
            <!-- project name add here  -->
            <div class="project_input_group">
                <input type="text" class="project_input" autofocus placeholder="Project Name" id="projectname" name="projectname">

            </div>
            <!--  project description add here -->
            <div class="project_input_group">
                <input type="text" class="project_input" autofocus placeholder="Description" id="description" name="description" require>
            </div>
            <div class="project_input_group">
                <!-- <input type="text" class="project_input" autofocus placeholder="Priority" id="priority" name="priority" require> -->
                <select class="project_input" id="priority" name="priority" >
                    <option disabled selected hidden>Priority</option>
                    <option >Low</option>
                    <option >Medium</option>
                    <option >High</option>
                </select>
            </div>
            <div class="project_input_group">
                <!-- <input type="text" class="project_input" autofocus placeholder="Status" id="stautus" name="status" require> -->
                <select class="project_input" id="status" name="status">
                    <option disabled selected hidden>Status</option>
                    <option>Completed</option>
                    <option>In Progress</option>
                    <option>Future</option>
                </select>
            </div>
            <!-- project due date -->
            <div class="project_input_group">
                <input type="date" class="project_input" autofocus placeholder="Due Date" id="duetime" name="duetime" require>
            </div>
            <button class="project_button" type="submit" name="addprojectsubmit"> ADD </button>

        </form>
    </div>


    <div class="col_project_list">
        <h1>Project list</h1>
        <table border="1" width="1000"  height="200" class="project_show_table">
            <tr>
                <th>Project name</th>
                <th>Priority</th>
                <th>Tasks</th>
                <th>Status</th>
                <th>Due</td>
            </tr>

            <?php foreach($projects as $project):?>
                <tr align="center">
                    <td><?php echo $project['projname']?></td>
                    <td><?php echo $project['priority']?></td>
                    <td><?php echo $project['tasks']?></td>
                    <td><?php echo $project['projstatus']?></td>
                    <td><?php echo $project['due']?></td>
   
                    
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>
<div class="row_project_1">
    <div class="col_project_delete">
        <form action="" class="project_form" method="POST" id="">
            <h1>Delete Project</h1>
            <div class="project_input_group">
                    <!-- <input type="text" class="project_input" autofocus placeholder="Priority" id="priority" name="priority" require> -->
                    <select class="project_input" id="priority" name="priority" >
                        <option >Choose Project to Delete</option>
                        
                    </select>
            </div>
            <button class="project_button" type="submit" name="deleteprojectsubmit"> DELETE </button>
        </form>

    </div>
</div>



</section>



    




</body>







</html>