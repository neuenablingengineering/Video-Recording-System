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
    $vid = $_GET['vid'];
    
    ?>
    
    <div class="container-custom">
      
      <div class="page-header col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <h3 class="text-left">Welcome,<?php echo " " . $user['Fname']?></h3>
      </div>

      <?php
      
      	$sql = "SELECT * FROM Reflection WHERE Session = '$vid'";
      	$result = mysqli_query($db,$sql);
      	$reflection = mysqli_fetch_assoc($result);
      	
      	$sql = "SELECT * FROM Session WHERE ID = '$vid'";
      	$result = mysqli_query($db,$sql);
      	$row = mysqli_fetch_assoc($result);

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
      
      	$instructions = "Use the sections on this form to comment on the client’s performance, your performance, and what you might do in the next session based on this information. Present your ideas in a logical, sequential manner. Check your work for grammar, presentation, and spelling. You can use the following questions to guide your Self-Evaluation:";
      	$q1 = "1. Describe at least three things that you thought went well in the session and why.";
      	$q2 = "2. Describe at least three things that you’d like to improve upon or do differently in the session and why.";
      	$q3 = "3. How did you feel about what happened? Why do you think you acted as you did?";
      	$q4 = "4. What do you need to learn or do to be better equipped for the things that happened in the session?";
      	$q5 = "Client’s Performance:";
      	$q6 = "Clinician's Performance:";
      	$q7 = "What to change/continue doing in the next session:";

      	echo "<div class=\"col-xs-11 col-sm-11 col-md-11 col-lg-11\">";
      	echo "<br><b>";
      	echo "Reflection completed on ";
      	echo date("m/d/Y", $reflection['Timestamp']);
      	echo " for session with client " . $lastname . ", " . $firstinit . " on " . $dat . " at " . $tim;
      	echo "</b><br>";
      	echo "<br>";
      	echo "<p>";
      	echo $instructions;
      	echo "<br>";
      	echo "<br>";
      	echo $q1;
      	echo "<br>";
      	echo $q2;
      	echo "<br>";
      	echo $q3;
      	echo "<br>";
      	echo $q4;
      	echo "<br>";
      	echo "<br>";
      	echo $q5;
      	echo "<br><b>";
      	echo $reflection['Text1'];
      	echo "</b><br>";
      	echo $q6;
      	echo "<br><b>";
      	echo $reflection['Text2'];
      	echo "</b><br>";
      	echo $q7;
      	echo "<br><b>";
      	echo $reflection['Text3'];
      	echo "</b><br>";
      	?>

    </div> <!-- /container -->

    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>



