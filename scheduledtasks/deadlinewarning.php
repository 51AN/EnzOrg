<?php
include "../forgotpassword/testMail.php";
$conn = mysqli_connect('localhost', 'root', '', 'spl');
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
date_default_timezone_set('Asia/Dhaka');
$d = date('Y-m-d', time());
// echo $d;
$date = date('Y-m-d', strtotime($d . ' +1 day'));
$date2 = date($date);
echo $date2;
// echo $date;
// $sql = "select * from users,tasks,taskmembers where users.id = taskmembers.userID and taskmembers.taskID = tasks.taskID and tasks.due = $date and tasks.status != 'Completed'";
$sql = "select * from users,tasks,taskmembers where users.id = taskmembers.userID and taskmembers.taskID = tasks.taskID and tasks.status != 'Completed';";
// echo DATE_FORMAT($date,'%m-%d');
$fetch = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($fetch)) {
    $due_date = date("Y-m-d", strtotime($row["due"])); // suppose $row['send_date']'s value is '2016-10-17 15:00'

    // echo $due_date;
    // echo $date;

    if ($date == $due_date){
        // echo "userid";
        // echo $row["id"];
        // echo "username";
        // echo $row["username"];
        // echo "taskname";
        // echo $row["taskName"];
        // echo "due date";
        // echo $row["due"];
        // echo "email";
        // echo $row["email"];
        // echo "status";
        // echo $row["status"];
        // echo "Ekta row shesh... now new row";
        $to = $row["email"];
        $subject = "Deadline warning for the task: " . $row["taskName"] . ".";
        $message="Dear " . $row["username"]. ",\n" . "Please have your task, ". $row["taskName"] . " completed by tomorrow."; 
        send_mail($to,$subject,$message);
    }
}
