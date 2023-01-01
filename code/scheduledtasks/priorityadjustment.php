<?php
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
    $taskID = $row["taskID"];
    $days_left = ($date)->diff($due_date)->days;
    if($days_left <=3 && $days_left>=0)
    {
        if($row["priority"]=="Low")
        {
            $sql = "UPDATE `tasks` SET `priority`='Medium' WHERE `taskID` = $taskID";
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
              } else {
                echo "Error updating record: " . $conn->error;
              }
        }
        else if($row["priority"]=="Medium")
        {
            $sql = "UPDATE `tasks` SET `priority`='High' WHERE `taskID` = $taskID";
            if ($conn->query($sql) === TRUE) {
                echo "Record updated successfully";
              } else {
                echo "Error updating record: " . $conn->error;
              }
        }
    }
}
?>