<?php

include('config.php');

//$value = date("F d Y H:i:s.", fileatime($filename));

//get the 10-digit UNIX timestamp that cron.php was last run

$last  = (int)file_get_contents('/home/northe10/public_html/timestamp.txt');

//update with current time

file_put_contents('/home/northe10/public_html/timestamp.txt', time());

//get videos that have been added since last run

$files = glob("/home/northe10/public_html/images/*.mkv");
$num = sizeof($files);
$count = 0;

while ($count < $num) {

    $filename = $files[$count];
    echo filesize($filename);
    
    if (filemtime($filename) > $last) {
    
        $value = substr($filename,34);
        $uploadtime = filemtime($filename);
        $size = filesize($filename);
        $sql = "INSERT INTO `Session` (`ID`, `Title`, `Room`, `Timestamp`, `Length`, `Patient`, `Clinician`) VALUES (NULL, '$value', '8', '$uploadtime', '$size', '2', '4');";
        mysqli_query($db,$sql);
        
    }
    
    $count++;
}

?>
