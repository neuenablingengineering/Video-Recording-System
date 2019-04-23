<?php
   ob_start(); // ensures changes will be saved before page reload
   
   include('session.php'); 
   $PID = $_POST['formDelete'];
   $myusername = $_SESSION['login_user'];
    
   $sql = "SELECT ID FROM Clinician WHERE Email = '$myusername'";
   $result = mysqli_query($db,$sql);
   $userID = mysqli_fetch_array($result);
   
   $sql = "DELETE FROM `Playlist` WHERE `Playlist`.`ID` = '$PID'";
   $result = mysqli_query($db,$sql);
   mysqli_fetch_assoc($result);
   
   $url = 'http://northeasternslhc.com/playlists.php';
   
   // clear out the output buffer
   while (ob_get_status()) 
   {
       ob_end_clean();
   }
   
   header("Location: $url");
?>