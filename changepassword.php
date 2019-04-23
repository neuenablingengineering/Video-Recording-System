<?php
   ob_start(); // ensures changes will be saved before page reload
   
   include('session.php'); 
   $message1 = mysqli_real_escape_string($db,$_POST['box1']);
   $message2 = mysqli_real_escape_string($db,$_POST['box2']);
   $message3 = mysqli_real_escape_string($db,$_POST['box3']);
   $myusername = $_SESSION['login_user'];
    
   $sql = "SELECT * FROM Clinician WHERE Email = '$myusername'";
   $result = mysqli_query($db,$sql);
   $user = mysqli_fetch_array($result);
   
   $test = password_verify($message1, $user['Password']);
   
   if (($test) AND ($message2 == $message3)) {
   
   $newpassword = password_hash($message2, PASSWORD_DEFAULT);
   
   $sql2 = "UPDATE `Clinician` SET Password = '$newpassword' WHERE Email = '$myusername'";
   $result2 = mysqli_query($db,$sql2);
   mysqli_fetch_assoc($result2);
   
   } else {
   
   echo "error";
   
   }
   
   $url = "http://northeasternslhc.com/settings.php";
   
   // clear out the output buffer
   while (ob_get_status()) 
   {
       ob_end_clean();
   }
   
   header("Location: $url");
?>