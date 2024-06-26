<?php
    include "../dbconnect.php";
    session_start();
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
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    </head>


<body>
<?php
    
    $message = '';

    if(isset($_SESSION['username']))
        $message = $_SESSION['username'];
?>

<?php
    $projID =  $_SESSION["projectID"];
    $userId = $_SESSION['user_id'];
    if(isset($_POST['update']))
    {
        if(isset($_POST['task_name']))
        {
            $selectedtask = htmlspecialchars($_POST['task_name']);
            $selectedStatus = htmlspecialchars($_POST['status']);
            $viewAssignedTasks = mysqli_query($conn, "SELECT tasks.taskID, `taskName`, `taskDes`, `priority`, taskmembers.status, `due`, `projID` 
                                                        FROm tasks INNER JOIN taskmembers
                                                        ON tasks.taskID = taskmembers.taskID
                                                        WHERE taskmembers.userID = $userId and projID = $projID");
            while($rowAT = mysqli_fetch_assoc($viewAssignedTasks))
            {
                if($rowAT['taskName'] == $selectedtask)
                {
                    $tId = $rowAT['taskID'];
                    if($selectedStatus){
                    $updateSql = "UPDATE `taskmembers` SET `status`='$selectedStatus' WHERE taskID = $tId AND userID = $userId";
                    $executeUpdate = mysqli_query($conn, $updateSql); }
                    $tuser = mysqli_query($conn, "SELECT COUNT(userID) AS totaluser FROM taskmembers WHERE taskID = $tId");
                    $ttluser = mysqli_fetch_assoc($tuser);
                    $totaluser = $ttluser['totaluser'];
                    $tuserC = mysqli_query($conn, "SELECT COUNT(userID) AS totaluserC FROM taskmembers WHERE taskID = $tId AND taskmembers.status = 'Completed'");
                    $ttluserC = mysqli_fetch_assoc($tuserC);
                    $totaluserC = $ttluserC['totaluserC'];  

                    if($totaluser == $totaluserC)
                    {
                      $updateSqltasks = "UPDATE `tasks` SET `status`='$selectedStatus' WHERE taskID = $tId";
                      $executeUpdatee = mysqli_query($conn, $updateSqltasks); 
                      $updateSqltasksPriority = "UPDATE `tasks` SET `priority`='Low' WHERE taskID = $tId";
                      $executeUpdateePriority = mysqli_query($conn, $updateSqltasksPriority);
                    }
                    else
                    {
                      $updateSqltasks = "UPDATE `tasks` SET `status`='In progress' WHERE taskID = $tId";
                      $executeUpdatee = mysqli_query($conn, $updateSqltasks); 
                    }
                    header('Location: '.$_SERVER['PHP_SELF'].'?success');
                    break;
                }
            }
        }
    }
?>

<?php
    $fetch = mysqli_query($conn, "(SELECT tasks.taskID, `taskName`, `taskDes`, `priority`, taskmembers.status, `due`, `projID` 
                                  FROm tasks INNER JOIN taskmembers
                                  ON tasks.taskID = taskmembers.taskID
                                  WHERE taskmembers.userID = $userId AND tasks.priority = 'High' and tasks.projID = $projID and tasks.status != 'Completed')
                                  UNION
                                  (SELECT tasks.taskID, `taskName`, `taskDes`, `priority`, taskmembers.status, `due`, `projID` 
                                  FROm tasks INNER JOIN taskmembers
                                  ON tasks.taskID = taskmembers.taskID
                                  WHERE taskmembers.userID = $userId AND tasks.priority = 'Medium' and tasks.projID = $projID and tasks.status != 'Completed')
                                  UNION
                                  (SELECT tasks.taskID, `taskName`, `taskDes`, `priority`, taskmembers.status, `due`, `projID` 
                                  FROm tasks INNER JOIN taskmembers
                                  ON tasks.taskID = taskmembers.taskID
                                  WHERE taskmembers.userID = $userId AND tasks.priority = 'Low' and tasks.projID = $projID and tasks.status != 'Completed')
                                  UNION
                                  (SELECT tasks.taskID, `taskName`, `taskDes`, `priority`, taskmembers.status, `due`, `projID` 
                                  FROm tasks INNER JOIN taskmembers
                                  ON tasks.taskID = taskmembers.taskID
                                  WHERE taskmembers.userID = $userId AND tasks.priority = 'High' and tasks.projID = $projID and tasks.status = 'Completed')
                                  UNION
                                  (SELECT tasks.taskID, `taskName`, `taskDes`, `priority`, taskmembers.status, `due`, `projID` 
                                  FROm tasks INNER JOIN taskmembers
                                  ON tasks.taskID = taskmembers.taskID
                                  WHERE taskmembers.userID = $userId AND tasks.priority = 'Medium' and tasks.projID = $projID and tasks.status = 'Completed')
                                  UNION
                                  (SELECT tasks.taskID, `taskName`, `taskDes`, `priority`, taskmembers.status, `due`, `projID` 
                                  FROm tasks INNER JOIN taskmembers
                                  ON tasks.taskID = taskmembers.taskID
                                  WHERE taskmembers.userID = $userId AND tasks.priority = 'Low' and tasks.projID = $projID and tasks.status = 'Completed')");
    
    $tasks = mysqli_fetch_all($fetch, MYSQLI_ASSOC);
?>
<!--  section of the whole page -->
<section class="header">

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
       <a href="../dashboard/index.php">
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
        <div class="project__name"><b>Project -> <?php echo $_SESSION['projectName'] ?></b></div>
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

    <!-- task entry form here  -->
<div class="row_project">
    <div class="col_task_update"> 
    <h1 class="task_title"> Update Task </h1>   
        <form action="" class="project_form" method="POST" id="">
            <!-- project name add here  -->
            
            <div class="project_input_group">
                <!-- <input type="text" class="project_input" autofocus placeholder="Priority" id="priority" name="priority" require> -->
                <select class="project_input" id="task_name" name="task_name" >
                    <option disabled selected hidden>Select Task</option>
                    <?php foreach($tasks as $values):?>
                            <option value="<?php echo $values['taskName'];?>"><?php echo $values['taskName'];?></option>
                    <?php endforeach;?>
                </select>
            </div>
            <div class="project_input_group">
                <!-- <input type="text" class="project_input" autofocus placeholder="Status" id="stautus" name="status" require> -->
                <select class="project_input" id="status" name="status">
                    <option disabled selected hidden>Status</option>
                    <option>Completed</option>
                    <option>In Progress</option>
                </select>
            </div>
            <button class="project_button" type="button" name="update" onclick="openPopupAdd()"> UPDATE </button>
            <div class="popup_add"  id="popup_add">
                <img src="./images/question.png">
                <h2>Update?</h2>
                <p>Do you want to Update this task's status?</p>
                <div class="popup_button_space">
                    <button type="submit" class="project_button_popup" name="update">Confirm</button>
                </div>
                    <button type="button" class="project_button_delete_popup" onclick="closePopupAdd()">Cancel</button>
                
            </div>

        </form>
    </div>


    <div class="col_project_list">
        <h1>Task list</h1>
        <div style="height: 300px; overflow: auto" class="table_div">
            <table border="0" width="1000"  height="" class="project_show_table" >
                <tr>
                    <th>Task name</th>
                    <th>Priority</th>
                    <th>Members</th>
                    <th>Status</th>
                    <th>Due</td>
                </tr>
            
                <?php foreach($tasks as $task):?>
                    <tr align="center">
                        <td><?php echo $task['taskName']?></td>
                        <td><?php echo $task['priority']?></td>
                        <td>
                        <?php
                            $id = $task['taskID'];
                            $fetchmembers = mysqli_query($conn, "SELECT COUNT(taskID) AS totalmember FROM taskmembers WHERE taskID = $id");
                            $membercount = mysqli_fetch_assoc($fetchmembers);
                            echo $membercount['totalmember'];
                        ?>
                        </td>
                        <td><?php echo $task['status']?></td>
                        <td><?php echo $task['due']?></td>
    
                        
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
</div>


    


</section>



    
<script>


let popupOpen = document.getElementById("popup_add");

function openPopupAdd(){
    popupOpen.classList.add("open-popup-add");
}
function closePopupAdd(){
    popupOpen.classList.remove("open-popup-add");
}



let popup = document.getElementById("popup_delete");

function openPopup(){
    popup.classList.add("open-popup");
}
function closePopup(){
    popup.classList.remove("open-popup");
}





</script>



</body>







</html>