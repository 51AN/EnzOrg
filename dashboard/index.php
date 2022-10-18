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
                <li><a href="#">ABOUT</a></li>
                <li><a href="#">CONTACT</a></li>
            </ul>
        </div>
    </nav>

    <!-- task entry form here  -->
    <div class="task_entry">
        <form action="" class="add_task_form" method="POST" id="">
        <h1 class="add_task_title"> Add Project </h1>
        <!-- task name add here  -->
        <div class="add_task_input_group">
            <input type="text" class="add_task_input" autofocus placeholder="Project Name" id="taskname" name="taskname">

        </div>
        <!--  task description add here -->
        <div class="add_task_input_group">
            <input type="text" class="add_task_input" autofocus placeholder="Description" id="description" name="description">
        </div>
        <!-- task due date -->
        <div class="add_task_input_group">
            <input type="datetime-local" class="add_task_input" autofocus placeholder="Due Date" id="duetime" name="duetime">
        </div>
        <button class="add_task_button" type="submit" name="addtasksubmit"> ADD </button>

        


        </form>
    </div>
    <div>
        <h1>Project list</h1>
        <table>
            <tr>
                <td>Project name</td>
                <td>Priority</td>
                <td>Tasks</td>
                <td>Status</td>
                <td>Due</td>
            </tr>
        </table>
    </div>
</section>



    




</body>







</html>