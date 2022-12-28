<?php
include "../forgotpassword/testMail.php";
$conn = mysqli_connect('localhost', 'root', '', 'spl');
if (!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}
date_default_timezone_set('Asia/Dhaka');
$d = date('Y-m-d', time());
$date = DateTime::createFromFormat("Y-m-d", $d);
$sql = "select * from users,tasks,taskmembers where users.id = taskmembers.userID and taskmembers.taskID = tasks.taskID and tasks.status != 'Completed';";
$fetch = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($fetch)) {
    $due = date("Y-m-d", strtotime($row["due"]));
    $due_date = DateTime::createFromFormat("Y-m-d", $due);
    $days_left = ($date)->diff($due_date)->days;

    if ($days_left <=3 && $days_left >=0){
        $to = $row["email"];
        $subject = "Deadline warning for the task: " . $row["taskName"] . ".";
        $message="Dear " . $row["username"]. ",\n" . "Please have your task, ". $row["taskName"] . " completed as soon as possible.". $days_left. " days remain till the due date. The task priority has been adjusted accordingly."; 
        send_mail($to,$subject,$message);
    }
}
?>