<?php
   ob_start(); // ensures changes will be saved before page reload
   
   include('session.php'); 
   $message = mysqli_real_escape_string($db,$_POST['message']);
   $myusername = $_SESSION['login_user'];
   $vid = $_GET['vid'];
   $minsec = $_POST['VidTime'];
   $timestamp = time();
    
   $sql = "SELECT ID FROM Clinician WHERE Email = '$myusername'";
   $result = mysqli_query($db,$sql);
   $userID = mysqli_fetch_array($result);
   
   $sql = "INSERT INTO `Comment` (`ID`, `Session`, `Clinician`, `Time`, `Message`, `Timestamp`) VALUES (NULL, '$vid', '$userID[0]', '$minsec', '$message', '$timestamp')";
   $result = mysqli_query($db,$sql);
   mysqli_fetch_assoc($result);
   
   $url = "http://northeasternslhc.com/playback.php?vid=". $vid ."";
   
   // clear out the output buffer
   while (ob_get_status()) 
   {
       ob_end_clean();
   }
   
   header("Location: $url");
?>