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
        <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
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
            $query = mysqli_query($conn, "INSERT INTO `projects` (`projname`, `projdescription`, `priority`, `projstatus`, `due`, `user_id`) VALUES ('$projname', '$projdes', '$priority', '$projstatus', '$due', '$userId')");
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

<?php
    if(isset($_POST['viewprojectsubmit']))
    {
        $selectedview = htmlspecialchars($_POST['viewproj']);
        $view = mysqli_query($conn, "SELECT * FROM `projects` WHERE projname = '$selectedview' AND user_id = $userId");
        $row = mysqli_fetch_assoc($view);
        $_SESSION['projectName'] = $row['projname'];
        $_SESSION['projectID'] = $row['proj_id'];
        header('Location: ../projectpageadmin/index.php');
    }
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
        <a href="#">
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
       <a href="#">
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
       <a href="#">
         <i class='bx bx-support'></i>
         <span class="links_name">Help & Support</span>
       </a>
       <span class="tooltip">Help & Support</span>
     </li>
     <li>
       <a href="#">
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

  closeBtn.addEventListener("click", ()=>{
    sidebar.classList.toggle("open");
    menuBtnChange();//calling the function(optional)
  });

  searchBtn.addEventListener("click", ()=>{ // Sidebar open when you click on the search iocn
    sidebar.classList.toggle("open");
    menuBtnChange(); //calling the function(optional)
  });

  // following are the code to change sidebar button(optional)
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
                <select class="project_input" id="priority" name="priority">
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
            <button class="project_button" type="button" onclick="openPopupAdd()"> ADD </button>
            <div class="popup_add"  id="popup_add">
                <img src="./images/question.png">
                <h2>Add?</h2>
                <p>Do you want to add this project?</p>
                <div class="popup_button_space">
                    <button type="submit" class="project_button" name="addprojectsubmit">Confirm</button>
                </div>
                    <button type="button" class="project_button" onclick="closePopupAdd()">Cancel</button>
                
            </div>

        </form>
    </div>


    <div class="col_project_list">
        <h1>Project list</h1>
        <div style="height: 300px; overflow: auto">
            <table border="1" width="1000"  height="400" class="project_show_table" >
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
                        <td>
                        <?php
                            $id = $project['proj_id'];
                            $fetchTasks = mysqli_query($conn, "SELECT COUNT(taskID) AS totaltask FROM tasks WHERE projID = $id");
                            $taskcount = mysqli_fetch_assoc($fetchTasks);
                            echo $taskcount['totaltask'];
                        ?>
                        </td>
                        <td><?php echo $project['projstatus']?></td>
                        <td><?php echo $project['due']?></td>
    
                        
                    </tr>
                <?php endforeach;?>
            </table>
        </div>
    </div>
</div>
<div class="row_project_1">
    <div class="col_project_delete">
        <form action="" class="project_form" method="POST" id="">
            <h1>Delete Project</h1>
            <div class="project_input_group">
                    <!-- <input type="text" class="project_input" autofocus placeholder="Priority" id="priority" name="priority" require> -->
                    <select class="project_input" id="delproj" name="delproj" >
                        <?php foreach($projects as $values):?>
                            <option value="<?php echo $values['projname'];?>"><?php echo $values['projname'];?></option>
                        <?php endforeach;?>
                    </select>
            </div>
            <button class="project_button" type="button" onclick="openPopup()"> DELETE </button>
            <div class="popup_delete"  id="popup_delete">
                <img src="./images/cross.png">
                <h2>Delete?</h2>
                <p>Are you sure about deleting this project?</p>
                <div class="popup_button_space">
                    <button type="submit" class="project_button" name="deleteprojectsubmit">Confirm</button>
                </div>
                    <button type="button" class="project_button" onclick="closePopup()">Cancel</button>
                
            </div>
        </form>

    </div>

    <div class="col_project_veiw">
        <form action="" class="project_form" method="POST" id="">
            <h1>View Project</h1>
            <div class="project_input_group">
                    <!-- <input type="text" class="project_input" autofocus placeholder="Priority" id="priority" name="priority" require> -->
                    <select class="project_input" id="viewproj" name="viewproj" >
                        <?php foreach($projects as $values):?>
                            <option value="<?php echo $values['projname'];?>"><?php echo $values['projname'];?></option>
                        <?php endforeach;?>
                    </select>
            </div>
            <button class="project_button" type="submit" name="viewprojectsubmit"> VIEW </button>
            
        </form>
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