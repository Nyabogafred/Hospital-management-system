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
<title>Patients</title>

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
<h3 id="Structural">Patient Registration</h3>
	<div class="jumbotron">
		<form method="POST" action="patients.php" name="patients">
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
  <label class="control-label ">Email</label>
 <input type="text" class="form-control" name="email" placeholder="Email"/>
</div>
<div class="col-md-6">
  <label class="control-label ">Phone</label>
<input type="text" class="form-control" name="phone" placeholder="Phone">
</div>
</div>

<div class="row">
<div class="col-md-6">
  <label class="control-label ">Address</label>
 <input type="text" class="form-control" name="address" placeholder="Address"/>
</div>
<div class="col-md-6">
  <label class="control-label ">Date of Birth</label>
<input type="text" class="form-control" name="date_of_birth" placeholder="YYYY/MM/DD">
</div>
</div>

<div class="row">
<div class="col-md-6">
  <label class="control-label ">Gender</label>

<select class="form-control" name="gender">
            <option>Male</option>
            <option>Female</option>  
        </select>
</div>
<div class="col-md-6">
  <label class="control-label ">Blood Group</label>
<input type="text" class="form-control" name="blood_group" placeholder="Blood Group">
</div>
</div>


	<div class="row">

          <div class="col-md-6">
<label class="control-label ">Diagnosis</label>
<textarea id="diagnosis" name="diagnosis" class="form-control" placeholder="Give your diagnosis"></textarea>
</div>
<div class="row">

          <div class="col-md-6">
<label class="control-label ">Date_of_admission</label>
<textarea id="diagnosis" name="diagnosis" class="form-control" placeholder="YYYY/MM/DD"></textarea>
</div>
</div>
<div class="padding-top-10">
<input name="Submit" type="submit" value="Register" class="btn btn-block btn-primary">
 <input name="view" type="submit" value="View Patient Details" class="btn btn-block btn-primary">
</div>
</form>
<!--
<div class="padding-top-10">
  <a href="patients_details.php"><button class="btn btn-default">View patient details</button></a>
</div>
-->
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
$connect=mysqli_connect("localhost","root","","nyamira_hospital") or die("can't connect to the localhost");
mysqli_select_db($connect,"nyamira_hospital") or die("can't connect to the database");

echo '<div id="snackbar">Patient Registered Successfully</div>';

$fname=@$_POST['fname'];
$lname=@$_POST['lname'];
$email=@$_POST['email'];
$phone=@$_POST['phone'];
$address=@$_POST['address'];
$date_of_birth=@$_POST['date_of_birth'];
$gender=@$_POST['gender'];
$blood_group=@$_POST['blood_group'];
$diagnosis=@$_POST['diagnosis'];

if(isset($_POST['view'])){
  header("Location: patients_details.php");
}

if(isset($_POST['Submit'])){
     if($query=mysqli_query($connect,"insert into patients(`fname`,`lname`,`email`,`phone`,`address`,`date_of_birth`,`gender`,`blood_group`,`diagnosis`) 
          values('".$fname."','".$lname."','".$email."','".$phone."','".$address."','".$date_of_birth."','".$gender."','".$blood_group."','".$diagnosis."')")){
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
