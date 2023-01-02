<?php
   include "../dbconnect.php";
   session_start();
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

<body>
<?php
    $message = '';

    if(isset($_SESSION['username']))
        $message = $_SESSION['username'];
?>

<?php
   $user_id = $_SESSION['user_id'];
   $projectID = $_SESSION['projectID'];
   $projectName = $_SESSION['projectName'];
   $name = $description = $priority = $status = $date = $errmsg = $msg = '';
   if(isset($_POST['update_project']))
   {
      $name = htmlspecialchars($_POST['update_name']);
      $description = htmlspecialchars($_POST['update_des']);
      $date = $_POST['new_date'];

      if($name)
      {
        if($name != $projectName)
        {
          $fetchProj = mysqli_query($conn, "SELECT * FROM projects WHERE projname = '$name' AND user_id = $user_id");
          if(mysqli_num_rows($fetchProj) > 0)
          {
            $errmsg = "This project already exists.";
          }
          else
          {
            $updateProjName = mysqli_query($conn, "UPDATE `projects` SET `projname`='$name' WHERE proj_id = $projectID");
            $_SESSION['projectName'] = $name;
            header('Location: '.$_SERVER['PHP_SELF'].'?success');
          }
        }
        
      }
      if(!$errmsg){
        if($description)
        {
          $updateProjDes = mysqli_query($conn, "UPDATE `projects` SET `projdescription`='$description' WHERE proj_id = $projectID");
          header('Location: '.$_SERVER['PHP_SELF'].'?success');
        }

        if(isset($_POST['priority']))
        {
          $priority = $_POST['priority'];
          $updateProjName = mysqli_query($conn, "UPDATE `projects` SET `priority`='$priority' WHERE proj_id = $projectID");
          header('Location: '.$_SERVER['PHP_SELF'].'?success');
        }

        if(isset($_POST['status']))
        {
          $status = $_POST['status'];
          $updateProjStatus = mysqli_query($conn, "UPDATE `projects` SET `projstatus`='$status' WHERE proj_id = $projectID");
          header('Location: '.$_SERVER['PHP_SELF'].'?success');
        }

        if($date)
        {
          $updateDate = mysqli_query($conn, "UPDATE `projects` SET `due`='$date' WHERE proj_id = $projectID");
          header('Location: '.$_SERVER['PHP_SELF'].'?success');
        }
      }
      
   }
?>

<section class="container">
   
    <!-- side nav bar begin here -->
    <div class="sidebar">
    <div class="logo-details">
      <!-- <i class='bx bxl-c-plus-plus icon'></i> -->
        <div class="logo_name">EnzOrg</div>
        <i class='bx bx-menu' id="btn" ></i>
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
         <i class='bx bx-user' ></i>
         <span class="links_name">My Profile</span>
       </a>
       <span class="tooltip">My Profile</span>
     </li>
     <li>
       <a href="../mytasks/index.php">
         <i class='bx bx-task' ></i>
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
     <li class="go_back">
       <a href="../projectpageadmin/index.php">
         <i class='bx bx-arrow-back'></i>
         <span class="links_name">Go Back</span>
       </a>
       <span class="tooltip">Go Back</span>
     </li>
     
    </ul>
  </div>
<!-- add section here-->
  <script>
  let sidebar = document.querySelector(".sidebar");
  let closeBtn = document.querySelector("#btn");
  let searchBtn = document.querySelector(".bx-search");

  closeBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    menuBtnChange();
  });

  searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
    sidebar.classList.toggle("open");
    menuBtnChange(); 
  });


  function menuBtnChange() {
   if(sidebar.classList.contains("open")){
     closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");//replacing the iocns class
   }else {
     closeBtn.classList.replace("bx-menu-alt-right","bx-menu");//replacing the iocns class
   }
  }
  </script>




    <!--  nav bar begins here -->
    <nav>
    <div class="project__name"><b><?php echo $_SESSION['projectName'] ?> -> Settings</b></div>
      <!-- <div class="project__name"><b><?php echo $_SESSION['projectName'] ?></b></div> -->
        <div class="nav-links">
            <ul>
                <!-- elements of nav bar  -->
                <li><a href="../Homepage/index.php">HOME</a></li>
                <li><a href="../login/index.php">LOG OUT</a></li>
                <!-- Write profile name here -->
                <?php echo '<li><a href="../profile/index.php">'.$message.'</a></li>';?>
                <li><a href="../about/index.php">ABOUT</a></li>
                <li><a href="../contact/index.php">CONTACT</a></li>
            </ul>
        </div>
    </nav>

<div class="update-profile">
<!-- php code user information -->
<p><?php echo $msg?$msg:null; ?></p>

   <?php

      $select = mysqli_query($conn, "SELECT * FROM projects WHERE proj_id = '$projectID'") or die('query failed');
      if(mysqli_num_rows($select) > 0)
      {
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>
<div class="update-profile-form">
   <form action="" method="POST" enctype="multipart/form-data" class="update_form">
      

      
      <div class="flex">
         <div class="inputBox">
            <span>Update Project Name </span>
            <!-- put values here from database -->
            <input type="text" name="update_name" value="<?php echo $fetch['projname'];?>" class="box">
            <p class="error_message_proname"><?php echo $errmsg?$errmsg:null; ?></p>
            <span>Update Project Description </span>
            <input type="text" name="update_des" value="<?php echo $fetch['projdescription'];?>" class="box">
            <span>Update Priority :</span>
            <select class="box" id="priority" name="priority">
                    <option disabled selected hidden><?php echo $fetch['priority']; ?></option>
                    <option >Low</option>
                    <option >Medium</option>
                    <option >High</option>
            </select>
         </div>
         <div class="inputBox">
            <span>Update Status </span>
            <select class="box" id="status" name="status">
                    <option disabled selected hidden><?php echo $fetch['projstatus']; ?></option>
                    <option>Completed</option>
                    <option>In Progress</option>
                    <option>Future</option>
            </select>
            <span>Update Due Date </span>
            <input type="date" name="new_date"  class="box" value="<?php echo $fetch['due'];?>">
            
         </div>
      </div>
      <div class="buttons">
         <input type="submit" value="Update Project" name="update_project" class="btn">
      </div>
      
   </form>
    </div>
</div>
</section>

</body>
</html>