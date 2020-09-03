 <?php
 ob_start();
  session_start();
  require_once 'dbconnect.php';
  
  // if session is not set this will redirect to login page
  if( !isset($_SESSION['user']) ) {
    header("Location: login.php");
    exit;
  }
  // select loggedin users detail
  $res=mysql_query("SELECT * FROM doctors WHERE userId=".$_SESSION['user']);
  $userRow=mysql_fetch_array($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Home</title>

<!-- Bootstrap -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/styles.css">

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>


	
 
</head>
<body>
 
<nav class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
       </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-left">
        <li><a href="index.php">Home</a></li>
		  <li><a href="patients.php">Patients</a></li>
		  <li><a href="doctors_details.php">Doctors</a></li>
		  <li><a href="admissions.php">Admissions</a></li>
		  <li><a href="appointments.php">Appointments</a></li>
      </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['fname']; ?>&nbsp;<ul class="dropdown-menu"><span class="caret"></span></a>
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
    </div>
  </div>
</nav>

<div class="container text-center bg-grey">
<h2>Nyamira Hospital Management System</h2>

<div class="row">
  <div class="col-md-6">
<div class="thumbnail">
<img src="20190606_215142.png">
</div>
</div>


<div class="col-md-6">
<div class="row">
  <div class="col-md-6">
     <div class="thumbnail">
<a href="patients.php"><button class="btn btn btn-block btn-primary"><h4>Patients</h4></button></a>
</div>
</div>
<div class="col-md-6">
   <div class="thumbnail">
<a href="doctors_details.php"><button class="btn btn btn-block btn-primary"><h4>Doctors</h4></button></a>
</div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="thumbnail">
<a href="admissions.php"><button class="btn btn btn-block btn-primary"><h4>Admissions</h4></button></a>
</div>
</div>
<div class="col-md-6">
   <div class="thumbnail">
<a href="appointments.php"><button class="btn btn btn-block btn-primary"><h4>Appointments</h4></button></a>
</div>
</div>
</div>

<div class="row">
<div class="col-md-6">
  <div class="thumbnail">
<a href="billing.php"><button class="btn btn btn-block btn-primary"><h4>Billing</h4></button></a>
</div>
</div>
<div class="col-md-6">
   <div class="thumbnail">
</div>
</div>
</div>

</div>

</div>



</div>




</div>
</div>
</body>
</html>