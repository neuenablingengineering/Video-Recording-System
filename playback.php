<?php
   include('session.php'); 
?>

<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>NEU SLHC | Home</title>

    <!-- Bootstrap core CSS-->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS files -->

    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Sticky Footer CSS -->
    <link href="css/sticky-footer.css" rel="stylesheet">
    <!-- Personal Custom styles -->
    <link href="css/custom.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="https://bouve.northeastern.edu/assets/uploads/2014/05/favicon.png">
    
    <!-- Custom styles for this template -->
    <link href="css/loginpage.css" rel="stylesheet">
  </head>

  <body>
  
    <!-- Top of Page Navigation Panel-->  
    <header>
      <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container-fluid">

          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <a class="navbar-brand" href="welcome.php">Northeastern University | Speech-Language & Hearing Center&nbsp;&nbsp;<span class="glyphicon glyphicon-home" aria-hidden="true"></span></a>
          </div> <!-- Navbar-header -->

	<!-- Collect the nav links and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
              <li><a href="playlists.php">Playlists&nbsp;&nbsp;<span class="glyphicon glyphicon-list" aria-hidden="true"></span></a></li>
              <li><a href="https://bouve.northeastern.edu/csd/clinic/">About Us&nbsp;&nbsp;<span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span></a></li>
              <li><a href="settings.php">Settings&nbsp;&nbsp;<span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a></li>
              <li><a href="logout.php">Sign Out&nbsp;&nbsp;<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span></a></li>
            </ul>
	  </div><!-- /.navbar-collapse -->  
	      
        </div><!-- /.container-fluid -->
      </nav>      
    </header>

    <!-- BEGIN PAGE CONTENT -->
    <!-- Main component for a primary marketing message or call to action -->
    
    <?php
    $myusername = $_SESSION['login_user'];
    $select = "SELECT * FROM Clinician WHERE Email = '$myusername'";
    $run = mysqli_query($db,$select);
    $user = mysqli_fetch_assoc($run);
    
    $vid = $_GET['vid'];
    $sql = "SELECT Title FROM Session WHERE ID = '$vid'";
    $result = mysqli_query($db,$sql);
    $session = mysqli_fetch_array($result);
    
    $sql = "SELECT * FROM Session WHERE ID = '$vid'";
    $result = mysqli_query($db,$sql);
    $session = mysqli_fetch_array($result);
    
    ?>
    
    <div class="container-custom">
    
    	<div style="padding-bottom:65px;" class="col-xs-8 col-sm-8 col-md-8 col-lg-8"> 
    		<video id="myVideo" height="570" width="760" controls>
  			<source src="images/<?php echo $session['Title']; ?>" type="video/mp4">
  			<source src="movie.mkv" type="video/mkv">
			Your browser does not support the video tag.
		</video>

    	<?php
    	
    	if ($user['Role'] == 3 AND $session['Reflection'] == 'N'){
	
	echo "<form action=\"reflection.php?vid=$vid\" method=\"post\">";
	echo "<br><button type='submit' name='submit'>Start Student Reflection for this Session</button>";
	echo "</form>";
	echo "</div>";

	} else {
	
	echo "<br><button onclick=\"getCurTime()\" type=\"button\" class=\"btn btn-primary\">Add Comment at this Second</button>";
	echo "</div>";
	echo "<div style=\"padding-bottom:65px\" class=\"col-xs-4 col-sm-4 col-md-4 col-lg-4\">";
	echo "<div class=\"row\">";
    	echo "<div class=\"comment-scroll\">";
    	
    	$sql = "SELECT * FROM Comment WHERE Session = '$vid' ORDER BY Time";
    	$result = mysqli_query($db,$sql);
    	
    	while ($row = mysqli_fetch_array($result)) {
    	   
    	$ID = $row['Clinician'];
    	$sql = "SELECT * FROM Clinician WHERE ID = '$ID'";
    	$clinician = mysqli_query($db,$sql);
    	$user = mysqli_fetch_array($clinician);

        $comment_id = $row['ID'];
        $comment_post_id = $row['Session'];
        $comment_author= $user['Fname'] . " " . $user['Lname'];
        $comment_content = $row['Message'];
        $comment_vidtime = $row['Time'];
        $comment_date = date("m/d/Y", $row['Timestamp']);
        $time = date("h:i A", $row['Timestamp']);
	

        echo '<div class="container-comment">';
        //echo "<a href='comments.php?source=edit_post&p_id={$comment_id}' class='span-right'><span><i class='fa fa-pencil-square-o topbar-icon'></i></span>Edit</a> ";
        echo "<h5>$comment_author</h5>";
        echo "<p>$comment_vidtime sec: $comment_content</p>";
        echo "<span class='span-left'>$comment_date at $time </span>";
        echo "<a onclick='viewreplies()' class='span-right'><span><i class='fa fa-angle-double-down topbar-icon'></i></span>View Replies</a>";
        echo "<a onclick='replycomment()' class='span-right'><span><i class='fa fa-reply topbar-icon'></i></span>Reply </a>";
        echo "</div>";
        echo "<div id='viewreplies'>Viewing all replies to comment</div>";
        echo "<div id='replycomment'>Add Form to reply to comment</div>";

        }
?>
</div>

<div class="well">
    <h4>Leave a comment:</h4>

    <form action="newcomment.php?vid=<?php echo $vid; ?>" method="post">


           <label for="video_time">Video Second</label>
           <!--p><div id="VidTime">00:00</div>sec<p-->
            <input type="number" id='VidTime' class="form-control" name="VidTime" >

           <label for="comment">Your Comment</label>
            <textarea name="message" class="form-control" rows="3"></textarea>
           
           <button type='submit' name='submit'>Submit</button>
           
    </form>
</div>
</div>  
</div>

<?php
}
?>
     
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
