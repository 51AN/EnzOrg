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
<body>
<section class="container">
<div class="update-profile">
<!-- php code user information -->

   <?php
     /* $select = mysqli_query($conn,  "SELECT * FROM `user_form` WHERE id = '$user_id'") or die('query failed');
      if(mysqli_num_rows($select) > 0){
         $fetch = mysqli_fetch_assoc($select);
      }*/
   ?>

   <form action="" method="POST" enctype="multipart/form-data">

      <?php
      /* if($fetch['image'] == ''){
               echo '<img src="images/default-avatar.png">'; // gives a stock image if no profile picture is found
            }else{
               echo '<img src="uploaded_img/'.$fetch['image'].'">';
            }
            if(isset($message)){
               foreach($message as $message){
                  echo '<div class="message">'.$message.'</div>';
               }
            } */ 
            
      ?> 

      
      <div class="flex">
         <div class="inputBox">
            <span>username :</span>
            <!-- put values here from database -->
            <input type="text" name="update_name" value="" class="box">
            <span>your email :</span>
            <input type="email" name="update_email" value="" class="box">
            <span>update your pic :</span>
            <input type="file" name="update_image" accept="image/jpg, image/jpeg, image/png" class="box">
         </div>
         <div class="inputBox">
            <input type="hidden" name="old_pass" value="">
            <span>old password :</span>
            <input type="password" name="update_pass" placeholder="enter previous password" class="box">
            <span>new password :</span>
            <input type="password" name="new_pass" placeholder="enter new password" class="box">
            <span>confirm password :</span>
            <input type="password" name="confirm_pass" placeholder="confirm new password" class="box">
         </div>
      </div>
      <input type="submit" value="update profile" name="update_profile" class="btn">
      <a href="home.php" class="delete-btn">go back</a>
   </form>

</div>
</section>

</body>
</html>