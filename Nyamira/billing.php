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
$query_patients = "SELECT * FROM patients";
$patients = mysql_query($query_patients, $nyamira_hospital) or die(mysql_error());
$row_patients = mysql_fetch_assoc($patients);
$totalRows_patients = mysql_num_rows($patients);

$colname_form_fill = "-1";
if (isset($_SESSION['userId'])) {
  $colname_form_fill = $_SESSION['userId'];
}
mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_form_fill = sprintf("SELECT * FROM patients WHERE userId = %s", GetSQLValueString($colname_form_fill, "int"));
$form_fill = mysql_query($query_form_fill, $nyamira_hospital) or die(mysql_error());
$row_form_fill = mysql_fetch_assoc($form_fill);
$totalRows_form_fill = mysql_num_rows($form_fill);

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
<title>Billing</title>

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
<h3 id="Structural">Patient Billing</h3>
	<div class="jumbotron">
		<form method="POST" action="billing.php" name="billing">
<div class="row">
  <div class="col-md-6">
  <label class="control-label ">Patient's Name</label>
 <select class="form-control" name="name" id="name">
   <option value="select patient">select patient</option>
   <?php
do {  
?>
   <option><?php echo $row_patients['fname']?> <?php echo $row_patients['lname']?></option>
   <?php
} while ($row_patients = mysql_fetch_assoc($patients));
  $rows = mysql_num_rows($patients);
  if($rows > 0) {
      mysql_data_seek($patients, 0);
	  $row_patients = mysql_fetch_assoc($patients);
  }
?>
 </select>
  </div>
<div class="col-md-6">
  <label class="control-label ">Gender</label>

<select class="form-control" name="gender">
<option>Male</option>
<option>Female</option>
</select>
</div>

</div>

<div class="row">
<div class="col-md-6">
  <label class="control-label ">Phone number</label>
 <input name="number" type="text" class="form-control" id="number" value="<?php echo $row_form_fill['phone']; ?>"/>
 </div>

<div class="col-md-6">
  <label class="control-label ">Date Discharged</label>
<input type="text" class="form-control" name="discharged" placeholder="Date Discharged (YYYY/MM/DD)"/>
</div>


</div>

<div class="row">
<div class="col-md-6">
  <label class="control-label ">Room Charges</label>
<input type="text" class="form-control" name="room" placeholder="room charges"/>
</div>

<div class="col-md-6">
  <label class="control-label ">Medicine Charges</label>
 <input type="text" class="form-control" name="medicine" placeholder="Medicine Charges"/>
</div>

</div>
<div class="row">
<div class="col-md-6">
  <label class="control-label ">Total Amount (Ksh)</label>
 <input type="text" class="form-control" name="amount" placeholder="Amount"/>
</div>
</div>
	
<div class="padding-top-10">
<input name="Submit" type="submit" value="Bill Patient" class="btn btn-primary">
</div>

      </form>
      <div class="padding-top-10">
<a href="billing_details.php"><button class="btn btn-default">View Billed Patients</button></a>
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
mysql_free_result($patients);

mysql_free_result($form_fill);

$connect=mysqli_connect("localhost","root","","nyamira_hospital") or die("can't connect to the localhost");
mysqli_select_db($connect,"nyamira_hospital") or die("can't connect to the database");

echo '<div id="snackbar">Patient Billed Successfully</div>';

$name=@$_POST['name'];
$gender=@$_POST['gender'];
$number=@$_POST['number'];
$discharged=@$_POST['discharged'];
$room=@$_POST['room'];
$medicine=@$_POST['medicine'];
$amount=@$_POST['amount'];



if(isset($_POST['Submit'])){
     if($query=mysqli_query($connect,"insert into billing(`name`,`gender`,`number`,`discharged`,`room`,`medicine`,`amount`) 
          values('".$name."','".$gender."','".$number."','".$discharged."','".$room."','".$medicine."','".$amount."')")){
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
