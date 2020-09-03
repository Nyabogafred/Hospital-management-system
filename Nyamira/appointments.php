<?php require_once('../Connections/nyamira_hospital.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
  
}
}

mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_doctor = "SELECT * FROM doctors";
$doctor = mysql_query($query_doctor, $nyamira_hospital) or die(mysql_error());
$row_doctor = mysql_fetch_assoc($doctor);
$totalRows_doctor = mysql_num_rows($doctor);

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
<title>Appointments</title>

<!-- Bootstrap -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/styles.css">

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>


	
<style>
#snackbar {
    visibility: hidden;
    min-width: 250px;
    margin-left: -250px;
    background-color: #1d89da;
    color: #fff;
    text-align: center;
    border-radius: 2px;
    padding: 16px;
    position: fixed;
    z-index: 1;
    left: 50%;
    bottom: 30px;
    font-size: 17px;
}

#snackbar.show {
    visibility: visible;
    -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
    from {bottom: 0; opacity: 0;} 
    to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
    from {bottom: 0; opacity: 0;}
    to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
    from {bottom: 30px; opacity: 1;} 
    to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
    from {bottom: 30px; opacity: 1;}
    to {bottom: 0; opacity: 0;}
}
</style>



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
       
      </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['fname']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
    </div>
  </div>
</nav>

<div class="container">
<h3 id="Structural">Appointment Booking</h3>
	<div class="jumbotron">
		<form method="POST" action="appointments.php" name="appointments">
<div class="row">
<div class="col-md-6">
  <label class="control-label ">First Name</label>
<input type="text" class="form-control" name="fname" placeholder="First Name">
</div>
<div class="col-md-6">
  <label class="control-label ">Last Name</label>
<input type="text" class="form-control" name="lname" placeholder="Last Name">
</div>
</div>

<div class="row">
  <div class="col-md-6">
  <label class="control-label ">Phone</label>
<input type="text" class="form-control" name="phone" placeholder="Phone Number">
</div>
<div class="col-md-6">
  <label class="control-label ">Doctor to consult</label>
<select class="form-control" name="doctor">
  <option value="">Select Doctor</option>
  <?php
do {  
?>
  <option value="<?php echo $row_doctor['fname']?>"><?php echo $row_doctor['fname']?></option>
  <?php
} while ($row_doctor = mysql_fetch_assoc($doctor));
  $rows = mysql_num_rows($doctor);
  if($rows > 0) {
      mysql_data_seek($doctor, 0);
	  $row_doctor = mysql_fetch_assoc($doctor);
  }
?>
</select>
</div>
</div>
<div class="row">
<div class="col-md-6">
  <label class="control-label ">Date of Appointment</label>
<input type="text" class="form-control" name="date" placeholder="Date of appointment (YYYY/MM/DD)">
</div>



<div class="col-md-6">
  <label class="control-label ">Time of Appointment</label>
 <input type="text" class="form-control" name="time" placeholder="Time of Appointment (e.g. 11 am)"/>
</div>

</div>




	
<div class="padding-top-10">
<input name="Submit" type="submit" value="Book Appointment" class="btn btn-primary">
</div>

      </form>
      <div class="padding-top-10">
<a href="appointments_details.php"><button class="btn btn-default">View appointment Details</button></a>
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

<?php
mysql_free_result($doctor);

$connect=mysqli_connect("localhost","root","","nyamira_hospital") or die("can't connect to the localhost");
mysqli_select_db($connect,"nyamira_hospital") or die("can't connect to the database");

echo '<div id="snackbar">Appointment Booked Successfully</div>';

$fname=@$_POST['fname'];
$lname=@$_POST['lname'];
$phone=@$_POST['phone'];
$doctor=@$_POST['doctor'];
$date=@$_POST['date'];
$time=@$_POST['time'];



if(isset($_POST['Submit'])){
     if($query=mysqli_query($connect,"insert into appointments(`fname`,`lname`,`phone`,`doctor`,`date`,`time`) 
          values('".$fname."','".$lname."','".$phone."','".$doctor."','".$date."','".$time."')")){
            echo '<script>';
            echo 'var x = document.getElementById("snackbar")
                                                      x.className = "show";
                                                      setTimeout(function(){ x.className = x.className.replace("show",
                                                      ""); }, 5000);
                                                      ';
            echo '</script>';
          }else{
            echo 'failed';
          }
}

?>
