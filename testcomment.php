<?php
session_start() ;
// Redirect the user if not logged in
if ( !isset( $_SESSION[ 'user_id' ] ) ) {
require ( 'login.php' ) ; load() ; }
?>



<!DOCTYPE html>
<html lang="en">

<head>

    <!-- required meta tags -->
    <meta charset="utf-8">

    <meta name="description" content="Northeastern Speech and Hearing Learning Center">
    <meta name="keywords" content="">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- title -->
    <title>NEU SLHC | VIEWER </title>

    <!-- favicon -->
    <link rel="shortcut icon" href="img/favicon.ico">

    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Parisienne" rel="stylesheet">


    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- style CSS -->
    <link rel="stylesheet" href="css/loginpage.css">

    <!-- responsive CSS -->
    <!-- JS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</head>

<body data-spy="scroll" data-target=".navbar-fixed-top" data-offset="65">

<!--Video Navbar -->
<nav class="navbar navbar-inverse containerfluid">
    <div class="container-fluid">
           <div class="navbar-header">
      <a class="navbar-brand" href="#">NEU SLHC</a>
            <ul class="nav navbar-nav navbar-right">
      <li><a href="home.php"><span><i class="fa fa-home topbar-icon"></i></span>Home</a></li>
        </ul>
    </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><span><i class="fa fa-file-text topbar-icon"></i></span>Information</a></li>

        <li><a href="#" data-toggle="modal" data-target="#addcommentModalLong"><span><i class="fa fa-bookmark topbar-icon"></i></span>Markers</a></li>
            <li><a href="#"><span><i class="fa fa-file-pdf-o topbar-icon"></i></span>Export</a></li>
            <li><a href="#"><span><i class="fa fa-link topbar-icon"></i></span>Share</a></li>
            <li><a href="#"><span><i class="fa fa-download topbar-icon"></i></span>Download</a></li>
        </ul>
        
    </div>
</nav>

<div class="container-fluid">


        <?php
        require ( 'mysqli_connect.php' ) ;
        if ( isset( $_GET['id'] ) ) $id = $_GET['id'] ;
        {
        echo '<div class="row">';
   		echo '<div class="col-xs-12 col-md-8">';
      	echo '<a href="video_library.php" class ="link-heading"><span><i class="fa fa-arrow-left"></i></span>Video Library</a>';
         echo '<br>';
         echo '<br>';


         echo '<div>';
         echo '<video id="myVideo" style="width:100%; height:100%" controls>';

        
        $q = "SELECT * FROM Session WHERE ID = $id" ;
        $result = mysqli_query($dbcon, $q);
        if ( mysqli_num_rows( $result ) == 1 )
        {
           $row = mysqli_fetch_array( $result, MYSQLI_ASSOC );
             echo
     '<source src=" '. $row['video_thumbnail'] .' " type="video/mp4"> Your browser does not support HTML5 video.';
        }else
        {
        echo '<p>Apologies, Video is currently unavailable</p>';
        }     
        
        echo '</video>';
    	echo '</div>';


       echo '<h1>Hi Test!</h1>';
       echo '<button onclick="getCurTime()" type="button" class="btn btn-primary">Add Comment</button>';
    	
    
    	echo '</div>';
    
 
    

    
    echo '<div class="col-xs-12 col-md-4 comment-section">';
    echo '<div class="comment-scroll">';
    echo '<h3>Comment Section</h3>';
      


    $query ="SELECT * FROM comments WHERE comment_post_id = '$id'";
    $select_comments = @mysqli_query ($dbcon, $query);
    
    while($row = mysqli_fetch_assoc($select_comments)){
        $comment_id = $row['comment_id'];
        $comment_post_id = $row['comment_post_id'];
        $comment_author= $row['comment_author'];
        $comment_content = $row['comment_content'];
        $comment_vidtime = $row['comment_vidtime'];
        $comment_date = $row['comment_date'];
        $time = $row['comment_time'];


        echo '<div class="container-comment">';
        echo "<a href='comments.php?source=edit_post&p_id={$comment_id}' class='span-right'><span><i class='fa fa-pencil-square-o topbar-icon'></i></span>Edit</a> ";
        echo "<h5>$comment_author</h5>";
        echo "<p>At $comment_vidtime sec: $comment_content</p>";
        echo "<span class='span-left'>Posted on $comment_date by $time </span>";
        echo "<a onclick='viewreplies()' class='span-right'><span><i class='fa fa-angle-double-down topbar-icon'></i></span>View Replies</a>";
        echo "<a onclick='replycomment()' class='span-right'><span><i class='fa fa-reply topbar-icon'></i></span>Reply </a>";
        echo "</div>";
        echo "<div id='viewreplies'>Viewing all replies to comment</div>";
        echo "<div id='replycomment'>Add Form to reply to comment</div>";

    }
}
?>

     

    


    
    </div>
        <div class="comment-entry">
            

            <!--    NEW  COMMENT  -->

 <?php
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id = $user_id ";
        $select_username = @mysqli_query ($dbcon, $query);
        while($row = mysqli_fetch_assoc($select_username)){
          $comment_author = $row['username'] . ' ' . $row['lastname'];
         }


    if(isset($_POST['create_comment'])){
        $the_post_id = $_GET['id'];
    
    $comment_vidtime= $_POST['comment_vidtime'];
    $comment_content= $_POST['comment_content'];
    
    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_content, comment_vidtime, comment_date, comment_time)";
    $query .= "VALUES ($the_post_id, '{$comment_author}', '{$comment_content}', '{$comment_vidtime}',now(),now())";
            $create_comment_query = mysqli_query($dbcon,$query);
        if(!$create_comment_query){
            die('QUERY FAILED' . mysqli_error($dbcon));
        }
    }
    
    
?>
<div class="well">
    <h4>Leave a comment:</h4>

    <form action="" method="post" role="form">

        <div class="form-group">
           <label for="video_time">Video Time</label>
           <!--p><div id="VidTime">00:00</div>sec<p-->
            <input type="number" id='VidTime' class="form-control" name="comment_vidtime" >
        </div>
        <div class="form-group">
           <label for="comment">Your Comment</label>
            <textarea name="comment_content" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" name="create_comment" class="btn btn-primary">Submit</button>
    </form>
</div>
    
     </div>  
</div>

     
     
<!-- ADD COMMENT Modal -->
<div class="modal fade" id="addcommentModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLongTitle">Add new comment</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <h4>Video you,s.3/14/19@2:15</h4>
        <p>Time from video: 10:14</p>
        <div class="form-group">
          <label for="comment">Comment:</label>
          <textarea class="form-control" rows="3" id="comment"></textarea>
        </div>
      </div>
      <div class="modal-footer">
       <button class="btn btn-default" type="submit">Add comment</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
  </div>     
</div> 


<script>
var video = document.getElementById("myVideo");
function getCurTime() { 
    video.pause();
    document.getElementById("VidTime").value = Math.round(video.currentTime);
} 

function viewreplies() {
  var viewrep = document.getElementById("viewreplies");
  if (viewrep.style.display === "block") {
    viewrep.style.display = "none";
  } else {
    viewrep.style.display = "block";
  }
}
    
function replycomment() {
  var repcom = document.getElementById("replycomment");
  if (repcom.style.display === "block") {
    repcom.style.display = "none";
  } else {
    repcom.style.display = "block";
  }
}
    
</script>
</body>

</html>

