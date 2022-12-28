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
    $user_name = $userID = $errorMsg = '';
    $taskID = $_SESSION['taskID'];
    if(isset($_POST['addusersubmit']))
    {
        $user_name = htmlspecialchars($_POST['username']);
        if(!empty($user_name))
        {
            $fetchuser = mysqli_query($conn, "SELECT * FROM users WHERE `username` = '$user_name'");
            if(mysqli_num_rows($fetchuser) > 0)
            {
              $user = mysqli_fetch_assoc($fetchuser);
              $userID = $user['id'];
              $check = mysqli_query($conn, "SELECT * FROM taskmembers WHERE taskID = $taskID AND userID = $userID");

              if(mysqli_num_rows($check) > 0)
                  $errorMsg = 'The user is already a member.';
              if($user_name == $message)
                  $errorMsg = "You can't add yourself to your task.";
            }
            else
              $errorMsg = "User doesn't exist.";

            if(!$errorMsg)
            {
                $query = mysqli_query($conn, "INSERT INTO `taskmembers`(`userID`, `taskID`) VALUES ('$userID','$taskID')");
                header('Location: '.$_SERVER['PHP_SELF'].'?success');
            }
        }  
    }
?>

<?php
    $projID = $_SESSION['projectID'];
    $sql = "SELECT * FROM users INNER JOIN taskmembers 
            ON users.id = taskmembers.userID
            WHERE taskmembers.taskID = $taskID";

    $sqlproj ="SELECT * FROM users INNER JOIN projmembers 
                ON users.id = projmembers.userID
                WHERE projmembers.projID = $projID";

    $fetch = mysqli_query($conn, $sql);
    $members = mysqli_fetch_all($fetch, MYSQLI_ASSOC);

    $fetchprojmems = mysqli_query($conn, $sqlproj);
    $projmembers = mysqli_fetch_all($fetchprojmems, MYSQLI_ASSOC);
?>

<?php
    if(isset($_POST['deleteusersubmit']))
    {
        $selected = htmlspecialchars($_POST['deluser']);
        $fetchuserdlt = mysqli_query($conn, "SELECT * FROM users WHERE `username` = '$selected'");
        $userdlt = mysqli_fetch_assoc($fetchuserdlt);
        $dltuserID = $userdlt['id'];
        $del = mysqli_query($conn, "DELETE FROM `taskmembers` WHERE userID = $dltuserID");
        header('Location: '.$_SERVER['PHP_SELF'].'?success');
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
    <div class="task__name"><b><?php echo $_SESSION['taskName'] ?></b></div>
        <!-- <div class="title__name">Dash Board</div> -->
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

    <!-- task entry form here  -->
<div class="row_project">

    <div class="col_member_operations">
        <div class="row_member_entry">
            <form action="" class="project_form" method="POST" id="">
                    <h1 class="project_title"> Add Member </h1>
                    <!-- project name add here  -->
                    <div class="project_input_group">
                        <select class="project_input" id="username" name="username" >
                            <?php foreach($projmembers as $values):?>
                                <option value="<?php echo $values['username'];?>"><?php echo $values['username'];?></option>
                            <?php endforeach;?>
                        </select>

                    </div>
                    <button class="project_button" type="button" onclick="openPopupAdd()"> ADD </button>
                    <div class="popup_add"  id="popup_add">
                        <img src="./images/question.png">
                        <h2>Add?</h2>
                        <p>Do you want to add this user?</p>
                        <div class="popup_button_space">
                            <button type="submit" class="project_button" name="addusersubmit">Confirm</button>
                        </div>
                            <button type="button" class="project_button_delete" onclick="closePopupAdd()">Cancel</button>
                        
                    </div>
                </form>
        </div>
        <div class="row_member_delete">
            <form action="" class="project_form" method="POST" id="">
                <h1>Remove Member</h1>
                <div class="project_input_group">
                        <!-- <input type="text" class="project_input" autofocus placeholder="Priority" id="priority" name="priority" require> -->
                        <select class="project_input" id="deluser" name="deluser" >
                            <?php foreach($members as $values):?>
                                <option value="<?php echo $values['username'];?>"><?php echo $values['username'];?></option>
                            <?php endforeach;?>
                        </select>
                </div>
                <button class="project_button_delete" type="button" onclick="openPopup()"> Remove </button>
                <div class="popup_delete"  id="popup_delete">
                    <img src="./images/cross.png">
                    <h2>Remove?</h2>
                    <p>Are you sure about removing this user?</p>
                    <div class="popup_button_space">
                        <button type="submit" class="project_button" name="deleteusersubmit">Confirm</button>
                    </div>
                        <button type="button" class="project_button_delete" onclick="closePopup()">Cancel</button>
                    
                </div>
            </form>
        </div>
    </div>

    <div class="col_member_list">
    <h1>Assigned Members</h1>
        <div style="height: 300px; overflow: auto">
            <table border="1" width="990"  height="400" class="project_show_table" >
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            
                <?php foreach($members as $member):?>
                    <tr align="center">
                        <td><?php echo $member['username']?></td>
                        <td><?php echo $member['email']?></td>
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