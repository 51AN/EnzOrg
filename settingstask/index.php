<?php
   $conn = new mysqli('localhost','root','','spl');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <title>Profile</title>
    <link rel="shortcut icon" href="/assets/favicon.ico">
    <link rel="stylesheet" href="./styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;600;700&display=swap" rel="stylesheet">
</head>

<?php
   session_start();
   $user_id = $_SESSION['user_id'];
   if(isset($_POST['update_profile']))
   {
      $username = $_POST['update_name'];
      $email = $_POST['update_email'];

      mysqli_query($conn, "UPDATE `users` SET username = '$username', email = '$email' WHERE id = '$user_id'") or die('query failed');
      
      $old_pass = $_POST['old_pass'];
      $update_pass = md5($_POST['update_pass']);
      $temp_pass = $_POST['new_pass'];
      $new_pass = md5($_POST['new_pass']);
      $confirm_pass = md5($_POST['confirm_pass']);
   
      if(!empty($update_pass) || !empty($new_pass) || !empty($confirm_pass)){
         if($update_pass != $old_pass){
            $message[] = 'old password not matched!';
         }elseif($new_pass != $confirm_pass){
            $message[] = 'confirm password not matched!';
         }else if(strlen($temp_pass) < 8 || ctype_upper($temp_pass) || ctype_lower($temp_pass)){
            $message[] = "Password must be atleast 8 character long and contain uppercase and lowercase";
         }else{
            mysqli_query($conn, "UPDATE `users` SET password = '$confirm_pass' WHERE id = '$user_id'") or die('query failed');
            $message[] = 'password updated successfully!';
         }
      }

      $image = $_FILES['update_image']['name'];
      $imageSize = $_FILES['update_image']['size'];
      $imageTempName = $_FILES['update_image']['tmp_name'];
      $imageFolder = 'upload/'. $image;
   
      if(!empty($image))
      {
         if($imageSize > 2000000)
            $message[] = "Image is too large";
         else
         {
            $imageUpdateQuery = mysqli_query($conn, "UPDATE users SET image = '$image' WHERE id = '$user_id'") or die("query failed");
         
            if($imageUpdateQuery)
            {
               move_uploaded_file($imageTempName, $imageFolder);
            }
            $message[] = "Image updated successfully";   
         }
      }
   }
?>

<body>
<section class="container">
<div class="update-profile">
<!-- php code user information -->

   <?php

      $select = mysqli_query($conn, "SELECT * FROM USERS WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0)
      {
         $fetch = mysqli_fetch_assoc($select);
      }
   ?>

   <form action="" method="POST" enctype="multipart/form-data">
      <div class="image">
      <?php
      if(empty($fetch['image']))
      {
         echo '<img src="images/profile.jpg">';
      }
      else
      {
         echo '<img src = "upload/'.$fetch['image'].'">';
      }
      if(isset($message)){
         foreach($message as $message){
            echo '<div class="message">'.$message.'</div>';
         }
      }
            
      ?> 
      </div>

      
      <div class="flex">
         <div class="inputBox">
            <span>Update Task Name:</span>
            <!-- put values here from database -->
            <input type="text" name="update_name" value="<?php echo $fetch['username'];?>" class="box">
            <span>Your Email :</span>
            <input type="email" name="update_email" value="<?php echo $fetch['email'];?>" class="box">
            <span>Update Your Profile Picture :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="<?php echo $fetch['password']; ?>">
            <span>Old Password :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>New Password :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>Confirm Password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <div class="buttons">
         <input type="submit" value="Update Task" name="update_profile" class="btn">
      </div>
      <div class="buttons">
      <a href="../taskpageadmin/index.php"><input type="button" value="Go Back" name="go_back" class="btn"></a>
      </div>
   </form>

</div>
</section>

</body>
</html>