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

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_patient_details = 10;
$pageNum_patient_details = 0;
if (isset($_GET['pageNum_patient_details'])) {
  $pageNum_patient_details = $_GET['pageNum_patient_details'];
}
$startRow_patient_details = $pageNum_patient_details * $maxRows_patient_details;

mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_patient_details = "SELECT * FROM patients";
$query_limit_patient_details = sprintf("%s LIMIT %d, %d", $query_patient_details, $startRow_patient_details, $maxRows_patient_details);
$patient_details = mysql_query($query_limit_patient_details, $nyamira_hospital) or die(mysql_error());
$row_patient_details = mysql_fetch_assoc($patient_details);

if (isset($_GET['totalRows_patient_details'])) {
  $totalRows_patient_details = $_GET['totalRows_patient_details'];
} else {
  $all_patient_details = mysql_query($query_patient_details);
  $totalRows_patient_details = mysql_num_rows($all_patient_details);
}
$totalPages_patient_details = ceil($totalRows_patient_details/$maxRows_patient_details)-1;

$colname_patients_search = "-1";
if (isset($_POST['searchID'])) {
  $colname_patients_search = $_POST['searchID'];
}
mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_patients_search = sprintf("SELECT * FROM patients WHERE email LIKE %s", GetSQLValueString("%" . $colname_patients_search . "%", "text"));
$patients_search = mysql_query($query_patients_search, $nyamira_hospital) or die(mysql_error());
$row_patients_search = mysql_fetch_assoc($patients_search);
$totalRows_patients_search = mysql_num_rows($patients_search);

$queryString_patient_details = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_patient_details") == false && 
        stristr($param, "totalRows_patient_details") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_patient_details = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_patient_details = sprintf("&totalRows_patient_details=%d%s", $totalRows_patient_details, $queryString_patient_details);

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

<div class="container-fluid">
<!--search begin-->
<div class="col-xs-12">
    
         <div class="padding-top-10">
            <div class="x_panel">
      <div class="x_title">
        <div class="row">

          <div class="col-sm-6">
        <h2>Searched Records</h2>
        <div class="col-md-4">
      
       <button type="button" class="btn btn-success"> Entries found <span class="badge"><?php echo $totalRows_patients_search ?> </span></button>
       </div>
      </div>
      <form action="" method="post" name="search">
      <div class="col-sm-4">
        <form action="" method="post" name="search">
      <div class="col-sm-4">
        <select class="form-control" name="name">
  <option value="Patients Name"> Patients Name</option>
  <option value="Ward"> Ward</option>
  <option value="Bed"> Bed</option>
  <option value="Doctor_in_charge"> Doctor_in_charge</option>
  <option value="date"> date</option>
  <option value="Time"> Time</option>
   <?php
do {  
?>
<option value="<?php echo $row_patients['fname']?>"><?php echo $row_patients['fname']?> <?php echo $row_patients['lname']?></option>
  <?php
} while ($row_patients = mysql_fetch_assoc($patients));
  $rows = mysql_num_rows($patients);
  if($rows > 0) {
      mysql_data_seek($patients, 0);
    $row_patients = mysql_fetch_assoc($patients);
  }
?>
 <?php
do {  
?>
<option value="<?php echo $row_ward['fname']?>"><?php echo $row_ward['fname']?> <?php echo $row_ward['fname']?></option>
  <?php
} while ($row_ward = mysql_fetch_assoc($ward));
  $rows = mysql_num_rows($ward);
  if($rows > 0) {
      mysql_data_seek($ward, 0);
    $row_ward = mysql_fetch_assoc($ward);
  }
?>
 <?php
do {  
?>
<option value="<?php echo $row_bed['fname']?>"><?php echo $row_bed['fname']?> <?php echo $row_bed['lname']?></option>
  <?php
} while ($row_bed = mysql_fetch_assoc($bed));
  $rows = mysql_num_rows($bed);
  if($rows > 0) {
      mysql_data_seek($bed, 0);
    $row_bed = mysql_fetch_assoc($bed);
  }
?>
 <?php
do {  
?>
<option value="<?php echo $row_doctor_in_charge['fname']?>"><?php echo $row_doctor_in_charge['fname']?> <?php echo $row_doctor_in_charge['lname']?></option>
  <?php
} while ($row_doctor_in_charge = mysql_fetch_assoc($row_doctor_in_charge));
  $rows = mysql_num_rows($row_doctor_in_charge);
  if($rows > 0) {
      mysql_data_seek($row_doctor_in_charge, 0);
    $row_doctor_in_charge = mysql_fetch_assoc($row_doctor_in_charge);
  }
?>
 <?php
do {  
?>
<option value="<?php echo $row_date['date']?>"><?php echo $row_date['date']?> <?php echo $row_date['date']?></option>
  <?php
} while ($row_date = mysql_fetch_assoc($row_date));
  $rows = mysql_num_rows($row_date);
  if($rows > 0) {
      mysql_data_seek($row_date, 0);
    $row_date = mysql_fetch_assoc($row_date);
  }
?>
 <?php
do {  
?>
<option value="<?php echo $row_time['fname']?>"><?php echo $row_time['fname']?> <?php echo $row_time['lname']?></option>
  <?php
} while ($row_time = mysql_fetch_assoc($row_time));
  $rows = mysql_num_rows($row_time);
  if($rows > 0) {
      mysql_data_seek($row_time, 0);
    $row_time = mysql_fetch_assoc($row_time);
  }
?>
<input name="searchID" class="form-control input-sm" placeholder="Search by Email"  type="search"> 
      </div>
      <div class="col-sm-2">
<input name="go" type="submit" value="Go" class="btn btn-primary"/>
      </div>

      </form>
     







    </div>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table class="table table-hover">
          <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>Address</th>
                <th>Date of Birth</th>
                 <th>Gender</th>
                  <th>Blood Group</th>
                  <th>Diagnosis</th>
                   <th>Date_of_admission</th>

            </tr>
          </thead>
          <tbody>
         
               <?php do { ?>
    <tr>
      <td><?php echo $row_patients_search['userId']; ?></td>
      <td><?php echo $row_patients_search['fname']; ?></td>
      <td><?php echo $row_patients_search['lname']; ?></td>
      <td><?php echo $row_patients_search['email']; ?></td>
      <td><?php echo $row_patients_search['phone']; ?></td>
      <td><?php echo $row_patients_search['address']; ?></td>
      <td><?php echo $row_patients_search['date_of_birth']; ?></td>
      <td><?php echo $row_patients_search['gender']; ?></td>
      <td><?php echo $row_patients_search['blood_group']; ?></td>
      <td><?php echo $row_patients_search['diagnosis']; ?></td>
      <td><?php echo $row_patients_search['date_of_admission']; ?></td>
      <td><a href="edit_patients.php?email=<?php echo $row_patients_search['email']; ?>">Edit</a></td>
	  <td><a href="delete_patients.php?email=<?php echo $row_patients_search['email']; ?>">Delete</a></td>
    </tr>
    <?php } while ($row_patients_search = mysql_fetch_assoc($patients_search)); ?>
</table>
          
          </tbody>
        </table>
       
      </div>
  </div>
</div>
<!--search end-->

<div class="col-xs-12">
    
        <h2>Patients' Details</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
          </li>
        </ul>
        <div class="clearfix"></div>
    </div>
      <div class="x_content">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Address</th>
              <th>Date of Birth</th>
               <th>Gender</th>
                <th>Blood Group</th>
                <th>Diagnosis</th>
                <th>Date_of_admission</th>

            </tr>
          </thead>
          <tbody>
         
               <?php do { ?>
            <tr>
              <td><?php echo $row_patient_details['userId']; ?></td>
              <td><?php echo $row_patient_details['fname']; ?></td>
              <td><?php echo $row_patient_details['lname']; ?></td>
              <td><?php echo $row_patient_details['email']; ?></td>
              <td><?php echo $row_patient_details['phone']; ?></td>
              <td><?php echo $row_patient_details['address']; ?></td>
              <td><?php echo $row_patient_details['date_of_birth']; ?></td>
              <td><?php echo $row_patient_details['gender']; ?></td>
              <td><?php echo $row_patient_details['blood_group']; ?></td>
              <td><?php echo $row_patient_details['diagnosis']; ?></td>
               <td><?php echo $row_patient_details['date_of_admission']; ?></td>
            </tr>
            <?php } while ($row_patient_details = mysql_fetch_assoc($patient_details)); ?>
             
          </tbody>
        </table>
        
        
        
        
        

        <!--paging-->
        <div class="row">
          <div class="col-sm-5"> Showing <?php echo ($startRow_patient_details + 1) ?> to <?php echo min($startRow_patient_details + $maxRows_patient_details, $totalRows_patient_details) ?> of <?php echo $totalRows_patient_details ?> entries </div>
          <div class="col-sm-7">
            <div class="dataTables_paginate ">
              <ul class="pagination">
                <a href="<?php printf("%s?pageNum_patient_details=%d%s", $currentPage, max(0, $pageNum_patient_details - 1), $queryString_patient_details); ?>">
                <?php if ($pageNum_patient_details > 0) { // Show if not first page ?>
                  Previous
  <?php } // Show if not first page ?>
                </a>
                <a href="<?php printf("%s?pageNum_patient_details=%d%s", $currentPage, min($totalPages_patient_details, $pageNum_patient_details + 1), $queryString_patient_details); ?>">
                <?php if ($pageNum_patient_details < $totalPages_patient_details) { // Show if not last page ?>
                  Next
  <?php } // Show if not last page ?>
                </a>
              </ul>
            </div>
          </div>
        </div>
      <!--end of paging-->


      </div>
    </div>
  </div>
</div>
</div>
</div>
</body>
</html>
<?php
mysql_free_result($patient_details);

mysql_free_result($patients_search);
?>
