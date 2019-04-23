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
      
      <?php
      	if ($user['Role'] == 1){
      ?>
      
      <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
      <h4><b>Change Password</b></h4>
      <form action="changepassword.php" method="post">
      	<b>Old password:</b>
	<input type="password" id="inputPassword" name="box1" class="form-control" placeholder="Password" required>
	<b>New password:</b>
	<input type="password" id="inputPassword" name="box2" class="form-control" placeholder="Password" required>
	<b>Confirm new password:</b>
	<input type="password" id="inputPassword" name="box3" class="form-control" placeholder="Password" required>
	<br><button type='submit' name='submit'>Change Password</button>
      </form>
      </div>

      <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
      
      <h4><b>Create User</b></h4>
	
      <form action="newclinician.php" action = "" method="post">
      <input type="submit" name="button" value="New SLHC User"/></form>
      
      <form action="newpatient.php" action = "" method="post">
      <input type="submit" name="button" value="New Client"/></form>
	
      <h4><b><br>Delete User</b></h4>
	
      <form action="deleteclinician.php" action = "" method="post">
      <input type="submit" name="button" value="Deactivate SLHC Account"/></form>
      
      <form action="deletepatient.php" action = "" method="post">
      <input type="submit" name="button" value="Deactivate Client Account"/></form>
	
      </div>
      
      <div class="col-xs-5 col-sm-5 col-md-5 col-lg-5">
      
      <h4><b>Update Relationship</b></h4>
      
      <form action="relationship1.php" action = "" method="post">
      <input type="submit" name="button" value="Client-Clinician"/></form>
      
      <form action="relationship2.php" action = "" method="post">
      <input type="submit" name="button" value="Clinician-Supervisor"/></form>
      
      </div>
      
      <?php
      	}

      	elseif ($user['Role'] == 2){
      	
      ?>
      
      <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
      <h4><b>Change Password</b></h4>
      <form action="changepassword.php" method="post">
      	<b>Old password:</b>
	<input type="password" id="inputPassword" name="box1" class="form-control" placeholder="Password" required>
	<b>New password:</b>
	<input type="password" id="inputPassword" name="box2" class="form-control" placeholder="Password" required>
	<b>Confirm new password:</b>
	<input type="password" id="inputPassword" name="box3" class="form-control" placeholder="Password" required>
	<br><button type='submit' name='submit'>Change Password</button>
      </form>
      </div>
      
      <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
      
      <h4><b>My Students</b></h4>
      
      Total assigned:
      
      	<?php
      	
      	$a = "SELECT COUNT(*) as total FROM Clinician WHERE Supervisor = " . $user['ID'];
      	$ab = mysqli_query($db,$a);
      	$abc = mysqli_fetch_array($ab);
      	echo $abc['total'];
      	
	$sql = "SELECT * FROM Clinician WHERE Supervisor = " . $user['ID'] . " ORDER BY Lname, Fname, ID";
	$result = mysqli_query($db,$sql);
	
	echo "<br>";
	while ($row = mysqli_fetch_assoc($result)) {
	    echo "<br>" . $row['Lname'] . ", " . $row['Fname'];
	}
	echo "<br>";
	echo "<br>";
	?>
	
      <h4><b>My Clients</b></h4>
      
      Total assigned:
      
      	<?php
      	
      	$a = "SELECT COUNT(*) as total FROM Patient INNER JOIN Clinician ON Patient.Clinician = Clinician.ID WHERE Clinician.Supervisor = " . $user['ID'];
      	$ab = mysqli_query($db,$a);
      	$abc = mysqli_fetch_array($ab);
      	echo $abc['total'];
      	
	$sql = "SELECT Patient.Fname, Patient.Lname FROM Patient INNER JOIN Clinician ON Patient.Clinician = Clinician.ID WHERE Clinician.Supervisor = " . $user['ID'] . " ORDER BY Patient.Lname, Patient.Fname, Patient.ID";
	$result = mysqli_query($db,$sql);
	
	echo "<br>";
	while ($row = mysqli_fetch_assoc($result)) {
	    echo "<br>" . $row['Lname'] . ", " . $row['Fname'];
	}
	echo "<br>";
	echo "<br>";
	?>
      
      </div>
      
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
      
      <h4><b>Past Reflections</b></h4>
      
      <?php
      $sql = "SELECT * FROM Session INNER JOIN Clinician ON Session.Clinician = Clinician.ID WHERE Reflection = 'Y' AND Clinician.Supervisor = " . $user['ID']. " ORDER BY Timestamp DESC";
      $result = mysqli_query($db,$sql);
      $count = 0;
      
      while ($row = mysqli_fetch_assoc($result)) {
      
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
		
		echo "<p><a href = \"oldreflection.php?vid=" . $row['ID'] . "\">" . $lastname . ", " . $firstinit . " --- " . $dat . " --- " . $tim . "</a></p>";
		$count = $count + 1;
	}
	
	if ($count == 0){
	        echo "No results.";
	}
	?>
      
      </div>
      
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
      
      <h4><b>Incomplete Reflections</b></h4>
      
      <?php
      $sql = "SELECT * FROM Session INNER JOIN Clinician ON Session.Clinician = Clinician.ID WHERE Reflection = 'N' AND Clinician.Supervisor = " . $user['ID']. " ORDER BY Timestamp DESC";
      $result = mysqli_query($db,$sql);
      $count = 0;
      
      while ($row = mysqli_fetch_assoc($result)) {
      
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
		
		echo "<p><a href = \"playback.php?vid=" . $row['ID'] . "\">" . $lastname . ", " . $firstinit . " --- " . $dat . " --- " . $tim . "</a></p>";
		$count = $count + 1;
	}
	
	if ($count == 0){
	        echo "No results.";
	}
	?>
      
      </div>

      <?php
      	}

      	elseif ($user['Role'] == 3){
      ?>

      <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
      <h4><b>Change Password</b></h4>
      <form action="changepassword.php" method="post">
      	<b>Old password:</b>
	<input type="password" id="inputPassword" name="box1" class="form-control" placeholder="Password" required>
	<b>New password:</b>
	<input type="password" id="inputPassword" name="box2" class="form-control" placeholder="Password" required>
	<b>Confirm new password:</b>
	<input type="password" id="inputPassword" name="box3" class="form-control" placeholder="Password" required>
	<br><button type='submit' name='submit'>Change Password</button>
      </form>
      </div>
      
      <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
      
      <h4><b>My Supervisor</b></h4>
      
      <?php
      
      $x = "SELECT * FROM Clinician WHERE ID = " . $user['Supervisor'];
      $xy = mysqli_query($db,$x);
      $xyz = mysqli_fetch_array($xy);
      
      echo $xyz['Fname'] . " " . $xyz['Lname'];
      echo "<br>";
      
      echo $xyz['Email'];
      echo "<br><br>";
      
      ?>
      
      <h4><b>My Clients</b></h4>
      
      Total assigned:
      
      	<?php
      	
      	$a = "SELECT COUNT(*) as total FROM Patient WHERE Clinician = " . $user['ID'];
      	$ab = mysqli_query($db,$a);
      	$abc = mysqli_fetch_array($ab);
      	echo $abc['total'];
      	
	$sql = "SELECT * FROM Patient WHERE Clinician = " . $user['ID'] . " ORDER BY Lname, Fname, ID";
	$result = mysqli_query($db,$sql);
	
	echo "<br>";
	while ($row = mysqli_fetch_assoc($result)) {
	    echo "<br>" . $row['Lname'] . ", " . $row['Fname'];
	}
	echo "<br>";
	echo "<br>";
	?>
      
      </div>
      
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
      
      <h4><b>Past Reflections</b></h4>
      
      <?php
      $sql = "SELECT * FROM Session WHERE Reflection = 'Y' AND Clinician = " . $user['ID']. " ORDER BY Timestamp DESC";
      $result = mysqli_query($db,$sql);
      $count = 0;
      
      while ($row = mysqli_fetch_assoc($result)) {
      
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
		
		echo "<p><a href = \"oldreflection.php?vid=" . $row['ID'] . "\">" . $lastname . ", " . $firstinit . " --- " . $dat . " --- " . $tim . "</a></p>";
		$count = $count + 1;
	}
	
	if ($count == 0){
	        echo "No results.";
	}
	?>
      
      </div>
      
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
      
      <h4><b>Incomplete Reflections</b></h4>
      
      <?php
      $sql = "SELECT * FROM Session WHERE Reflection = 'N' AND Clinician = " . $user['ID']. " ORDER BY Timestamp DESC";
      $result = mysqli_query($db,$sql);
      $count = 0;
      
      while ($row = mysqli_fetch_assoc($result)) {
      
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
		
		echo "<p><a href = \"playback.php?vid=" . $row['ID'] . "\">" . $lastname . ", " . $firstinit . " --- " . $dat . " --- " . $tim . "</a></p>";
		$count = $count + 1;
	}
	
	if ($count == 0){
	        echo "No results.";
	}
	?>
      
      </div>
      
      <?php
      	}

      	else {
      		echo "You do not have access to this page.";
      	}
      ?>
      
    </div> <!-- /container -->

    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>



