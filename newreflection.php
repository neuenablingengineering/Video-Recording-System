<?php
   ob_start(); // ensures changes will be saved before page reload
   
   include('session.php'); 
   $message1 = mysqli_real_escape_string($db,$_POST['message1']);
   $message2 = mysqli_real_escape_string($db,$_POST['message2']);
   $message3 = mysqli_real_escape_string($db,$_POST['message3']);
   $myusername = $_SESSION['login_user'];
   $vid = $_GET['vid'];
   $timestamp = time();
    
   $sql = "SELECT ID FROM Clinician WHERE Email = '$myusername'";
   $result = mysqli_query($db,$sql);
   $userID = mysqli_fetch_array($result);
   
   $sql = "INSERT INTO `Reflection` (`ID`, `Session`, `Clinician`, `Timestamp`, `Text1`, `Text2`, `Text3`) VALUES (NULL, '$vid', '$userID[0]', '$timestamp', '$message1', '$message2', '$message3')";
   $result = mysqli_query($db,$sql);
   mysqli_fetch_assoc($result);
   
   $sql2 = "UPDATE `Session` SET Reflection = 'Y' WHERE ID = '$vid'";
   $result2 = mysqli_query($db,$sql2);
   mysqli_fetch_assoc($result2);
   
   $url = "http://northeasternslhc.com/playback.php?vid=". $vid ."";
   
   // clear out the output buffer
   while (ob_get_status()) 
   {
       ob_end_clean();
   }
   
   header("Location: $url");
?>