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
    <link href="signin.css" rel="stylesheet">
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
    $sql = "SELECT * FROM Clinician WHERE Email = '$myusername'";
    $result = mysqli_query($db,$sql);
    $user = mysqli_fetch_assoc($result);
    
    ?>
    
    <div class="container-custom">
      <div class="page-header col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-left">Welcome,<?php echo " " . $user['Fname']?></h3>
      </div>
      
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
	<h4><b>My Playlists</b></h4>

      <?php
			
	 $sql = "SELECT * FROM Playlist WHERE Clinician = '" . $user['ID'] . "'";
	 $result = mysqli_query($db,$sql);
	    
	 while ($row = mysqli_fetch_assoc($result))
	 {
	    echo "<p><a href=\"playlist.php?id=" . $row['ID'] . "\">" . $row['Name'] . "</a></p>";
	 }
      ?>

	<h4><b>New Playlist</b></h4>
 
      <form action="newplaylist.php" action = "" method="post">
		
      <p>Playlist Name:<br>
      <input type="text" name="formName" id="formName">
	
      <br><br><input type="submit" name="button" value="Create"/></form>

      <h4><b>Delete Playlist</b></h4>

      <form action="deleteplaylist.php" action = "" method="post">
      <select name="formDelete">
      <option value="select">--SELECT--</option>
      <?php
			
	 $sql = "SELECT * FROM Playlist WHERE Clinician = '" . $user['ID'] . "'";
	 $result = mysqli_query($db,$sql);
	    
	 while ($row = mysqli_fetch_assoc($result))
	 {
	    echo "<option value=\"" . $row['ID'] . "\">" . $row['Name'] . "</option>";
	 }
      ?>
      </select><br>
      <br><input type="submit" name="button" value="Delete"/></form>
      </div>
      
      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      <h4><b>Add Videos</b></h4>
      <form action="addtoplaylist.php" action = "" method="post">
      <select name="formAdd">
      <option value="select">--SELECT--</option>
      
      <?php
      		
	 $sql = "SELECT * FROM Playlist WHERE Clinician = '" . $user['ID'] . "'";
	 $result = mysqli_query($db,$sql);
	    
	 while ($row = mysqli_fetch_assoc($result))
	 {
	    echo "<option value=\"" . $row['ID'] . "\">" . $row['Name'] . "</option>";
	 }
 
      ?>
      
      </select><br>
      <br><input type="submit" name="button" value="Add"/></form>
      </div>
      
    </div> <!-- /container -->

    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>



