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

      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
	    <h4><b>Search Filters</b></h4>
      </div>

	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">   	    
       	    
	<form action="filter.php" action = "" method="post">
	
	<p>Client:<br>
	<select name="formPatient">
	<option value="select">--SELECT--</option>
	<?php
	$sql = "SELECT * FROM Patient ORDER BY Lname, Fname, ID";
	$result = mysqli_query($db,$sql);
	while ($row = mysqli_fetch_assoc($result)) {
	    echo "<option value=\"" . $row['ID'] . "\">" . $row['Lname'] . ", " . $row['Fname'] . "</option>";
	}
	?>
	</select><br>
	
	<p>Clinician:<br>
	<select name="formClinician">
	<option value="select">--SELECT--</option>
	<?php
	$sql = "SELECT * FROM Clinician ORDER BY Lname, Fname, ID";
	$result = mysqli_query($db,$sql);
	while ($row = mysqli_fetch_assoc($result)) {
	    echo "<option value=\"" . $row['ID'] . "\">" . $row['Lname'] . ", " . $row['Fname'] . "</option>";
	}
	?>
	</select><br>
       
	<p>Room:<br>
	<select name="formRoom">
	<option value="select">--SELECT--</option>
	<?php
	$sql = "SELECT * FROM Room ORDER BY Room";
	$result = mysqli_query($db,$sql);
	while ($row = mysqli_fetch_assoc($result)) {
	    echo "<option value=\"" . $row['ID'] . "\">" . $row['Room'] . "</option>";
	}
	?>
	</select><br>
	
	<p>Date:<br>
	<input type="date" name="formDate" id="formDate">
	
	<br><br><input type="submit" name="button" value="Run Search"/></form>
	
	<form action="welcome.php">
	    <input type="submit" value="Return to All" />
	</form>
	 
	</div>
	    
    </div>
    
    </br>
    <div class="container-custom">
    	<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
	<?php
	
	    if ($user['Role'] == 4) {
	    
	    echo "Please ask administrator for video access.";
	    
	    } else {
	   
	    
	    if ($user['Role'] == 3) {
	  
	    $sql = "SELECT * FROM Session WHERE Clinician = " . $user['ID']. " ORDER BY Timestamp DESC";
	    
	    } else if ($user['Role'] == 2) {
	    
	    $sql = "SELECT * FROM Session INNER JOIN Clinician ON Session.Clinician = Clinician.ID WHERE Clinician.Supervisor = " . $user['ID']. " ORDER BY Timestamp DESC";
	    
	    } else if ($user['Role'] == 1) {
	
	    $sql = "SELECT * FROM Session ORDER BY Timestamp DESC";
	    
	    }
	    
	    $result = mysqli_query($db,$sql);
	    $count = -1;
	    
	    while ($row = mysqli_fetch_assoc($result))
	    {
	
		$originalDate = substr($row['Title'],5,8);
		$newDate = date("m/d/Y", strtotime($originalDate));
		
		$tim1 = substr($row['Title'],14,2);
		$tim2 = substr($row['Title'],17,2);
		$tim3 = $tim1 . ":" . $tim2;
		
		$originalTime = $tim3 . " " . $newDate;
		$newTime = date('h:i A m/d/Y', strtotime($originalTime));

		$dat = substr($newTime,9,10);
		$tim = substr($newTime,0,8);
		
		$sql = "SELECT * FROM Patient WHERE ID = " . $row['Patient'];
		$z = mysqli_query($db,$sql);
		$patient = mysqli_fetch_assoc($z);
		$lastname = substr($patient['Lname'],0,3);
		$firstinit = substr($patient['Fname'],0,1);
		
		$count = $count + 1;
		$xyz = fmod($count,30);
		
		if (($xyz == 0) && ($count != 0)){
		
		echo "</div>";
		echo "<div class=\"col-xs-3 col-sm-3 col-md-3 col-lg-3\">";
		echo "<p><a href = \"playback.php?vid=" . $row['ID'] . "\">" . $lastname . ", " . $firstinit . " --- " . $dat . " --- " . $tim . "</a></p>";
		
		} else {
	    
		echo "<p><a href = \"playback.php?vid=" . $row['ID'] . "\">" . $lastname . ", " . $firstinit . " --- " . $dat . " --- " . $tim . "</a></p>";
		
		}
	
	    }
	    
	    if ($count == 0){
	        echo "No results.";
	    }
	    }
	    
	?>

	</div>	
    </div> <!-- /container -->


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>