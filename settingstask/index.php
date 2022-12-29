<?php
$conn = new mysqli('localhost', 'root', '', 'spl');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="utf-8">
  <title>Settings</title>
  <link rel="shortcut icon" href="/assets/favicon.ico">
  <link rel="stylesheet" href="./styles.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
</head>

<?php
session_start();
$taskID =  $_SESSION['taskID'];
$user_id = $_SESSION['user_id'];
$name = $_SESSION['taskName'];
$projectID =  $_SESSION['projectID'];

if (isset($_POST['update_task_button'])) {
  $taskName = htmlspecialchars($_POST['update_task_name']);
  $taskDes = htmlspecialchars($_POST['update_task_description']);
  $due = $_POST['update_due'];
      if($taskName)
      {
        if($taskName != $name)
        {
          $fetchTask = mysqli_query($conn, "SELECT * FROM tasks WHERE taskName = '$taskName' AND projID = $projectID");
          if(mysqli_num_rows($fetchTask) > 0)
          {
            $errmsg = "This task already exists in this project.";
          }
          else
          {
            $updateTaskName = mysqli_query($conn, "UPDATE `tasks` SET `taskName`='$taskName' WHERE taskID = $taskID");
            $_SESSION['taskName'] = $taskName;
            header('Location: '.$_SERVER['PHP_SELF'].'?success');
          }
        }
      }
      if(!$errmsg){
        if($taskDes)
        {
          $updateTaskDes = mysqli_query($conn, "UPDATE `tasks` SET `taskDes`='$taskDes' WHERE taskID = $taskID");
          header('Location: '.$_SERVER['PHP_SELF'].'?success');
        }

        if(isset($_POST['priority']))
        {
          $priority = $_POST['priority'];
          $updateTaskPriority = mysqli_query($conn, "UPDATE `tasks` SET `priority`='$priority' WHERE taskID = $taskID");
          header('Location: '.$_SERVER['PHP_SELF'].'?success');
        }

        if(isset($_POST['status']))
        {
          $status = $_POST['status'];
          $updateTaskStatus = mysqli_query($conn, "UPDATE `tasks` SET `status`='$status' WHERE taskID = $taskID");
          $updateTaskStatusMT = mysqli_query($conn, "UPDATE `taskmembers` SET `status`='$status' WHERE taskID = $taskID");
        }

        if($due)
        {
          $updateDate = mysqli_query($conn, "UPDATE `tasks` SET `due`='$due' WHERE taskID = $taskID");
          header('Location: '.$_SERVER['PHP_SELF'].'?success');
        }
      }
}
?>

<body>
  <?php
  $message = '';

  if (isset($_SESSION['username']))
    $message = $_SESSION['username'];
  ?>
  <section class="container">

    <!-- side nav bar begin here -->
    <div class="sidebar">
      <div class="logo-details">
        <!-- <i class='bx bxl-c-plus-plus icon'></i> -->
        <div class="logo_name">EnzOrg</div>
        <i class='bx bx-menu' id="btn"></i>
      </div>
      <ul class="nav-list">
        <!-- <li>
          <i class='bx bx-search' ></i>
         <input type="text" placeholder="Search...">
         <span class="tooltip">Search</span>
      </li> -->
        <li>
          <a href="../dashboard/index.php">
            <i class='bx bx-grid-alt'></i>
            <span class="links_name">Dashboard</span>
          </a>
          <span class="tooltip">Dashboard</span>
        </li>
        <li>
          <a href="../profile/index.php">
            <i class='bx bx-user'></i>
            <span class="links_name">My Profile</span>
          </a>
          <span class="tooltip">My Profile</span>
        </li>
        <li>
          <a href="../mytasks/index.php">
            <i class='bx bx-task'></i>
            <span class="links_name">My Tasks</span>
          </a>
          <span class="tooltip">My Tasks</span>
        </li>
        <!-- <li>
       <a href="#">
         <i class='bx bx-pie-chart-alt-2' ></i>
         <span class="links_name">Analytics</span>
       </a>
       <span class="tooltip">Analytics</span>
     </li>
     <li>
       <a href="#">
         <i class='bx bx-folder' ></i>
         <span class="links_name">File Manager</span>
       </a>
       <span class="tooltip">Files</span>
     </li>
     <li>
       <a href="#">
         <i class='bx bx-cart-alt' ></i>
         <span class="links_name">Order</span>
       </a>
       <span class="tooltip">Order</span>
     </li> -->
        <li>
          <a href="../helpandsupport/index.php">
            <i class='bx bx-support'></i>
            <span class="links_name">Help & Support</span>
          </a>
          <span class="tooltip">Help & Support</span>
        </li>
        <li>
          <a href="../contact/index.php">
            <i class='bx bxs-contact'></i>
            <span class="links_name">Contact</span>
          </a>
          <span class="tooltip">Contact</span>
        </li>

      </ul>
    </div>
    <!-- add section here-->
    <script>
      let sidebar = document.querySelector(".sidebar");
      let closeBtn = document.querySelector("#btn");
      let searchBtn = document.querySelector(".bx-search");

      closeBtn.addEventListener("click", () => {
        sidebar.classList.toggle("open");
        menuBtnChange();
      });

      searchBtn.addEventListener("click", () => { // Sidebar open when you click on the search iocn
        sidebar.classList.toggle("open");
        menuBtnChange();
      });


      function menuBtnChange() {
        if (sidebar.classList.contains("open")) {
          closeBtn.classList.replace("bx-menu", "bx-menu-alt-right"); //replacing the iocns class
        } else {
          closeBtn.classList.replace("bx-menu-alt-right", "bx-menu"); //replacing the iocns class
        }
      }
    </script>




    <!--  nav bar begins here -->
    <nav>
      <!-- <div class="project__name"><b><?php echo $_SESSION['projectName'] ?></b></div> -->
      <div class="nav-links">
        <ul>
          <!-- elements of nav bar  -->
          <li><a href="../Homepage/index.php">HOME</a></li>
          <li><a href="../login/index.php">LOG OUT</a></li>
          <!-- Write profile name here -->
          <?php echo '<li><a href="../profile/index.php">' . $message . '</a></li>'; ?>
          <li><a href="../about/index.php">ABOUT</a></li>
          <li><a href="../contact/index.php">CONTACT</a></li>
        </ul>
      </div>
    </nav>

    <div class="update-profile">
      <!-- php code user information -->

      <?php

      $select = mysqli_query($conn, "SELECT * FROM tasks WHERE taskID = '$taskID'") or die('query failed');
      if (mysqli_num_rows($select) > 0) {
        $fetch = mysqli_fetch_assoc($select);
      }
      ?>

      <form action="" method="POST" enctype="multipart/form-data">
        <div class="flex">
          <div class="inputBox">
            <span>Update Task Name </span>
            <!-- put values here from database -->
            <input type="text" name="update_task_name" value="<?php echo $fetch['taskName']; ?>" class="box">
            <span>Update Task Description </span>
            <input type="text" name="update_task_description" value="<?php echo $fetch['taskDes']; ?>" class="box">
            <span>Update Priority :</span>
            <select class="box" id="priority" name="priority">
              <option disabled selected hidden><?php echo $fetch['priority']; ?></option>
              <option>Low</option>
              <option>Medium</option>
              <option>High</option>
            </select>
          </div>
          <div class="inputBox">
            <span>Update Status </span>
            <select class="box" id="status" name="status">
              <option disabled selected hidden><?php echo $fetch['status']; ?></option>
              <option>Completed</option>
              <option>In Progress</option>
              <option>Future</option>
            </select>
            <span>Update Due Date </span>
            <input type="date" name="update_due" class="box" value="<?php echo $fetch['due']; ?>">
          </div>
        </div>
        <div class="buttons">
          <input type="submit" value="Update Task" name="update_task_button" class="btn">
        </div>
        <div class="buttons">
          <a href="../taskpageadmin/index.php"><input type="button" value="Go Back" name="go_back" class="btn"></a>
        </div>
      </form>

    </div>
  </section>

</body>

</html>