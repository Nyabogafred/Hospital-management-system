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

$maxRows_appointments = 10;
$pageNum_appointments = 0;
if (isset($_GET['pageNum_appointments'])) {
  $pageNum_appointments = $_GET['pageNum_appointments'];
}
$startRow_appointments = $pageNum_appointments * $maxRows_appointments;

mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_appointments = "SELECT * FROM appointments";
$query_limit_appointments = sprintf("%s LIMIT %d, %d", $query_appointments, $startRow_appointments, $maxRows_appointments);
$appointments = mysql_query($query_limit_appointments, $nyamira_hospital) or die(mysql_error());
$row_appointments = mysql_fetch_assoc($appointments);

if (isset($_GET['totalRows_appointments'])) {
  $totalRows_appointments = $_GET['totalRows_appointments'];
} else {
  $all_appointments = mysql_query($query_appointments);
  $totalRows_appointments = mysql_num_rows($all_appointments);
}
$totalPages_appointments = ceil($totalRows_appointments/$maxRows_appointments)-1;

$colname_appointments_search = "-1";
if (isset($_POST['searchID'])) {
  $colname_appointments_search = $_POST['searchID'];
}
mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_appointments_search = sprintf("SELECT * FROM appointments WHERE fname LIKE %s", GetSQLValueString("%" . $colname_appointments_search . "%", "text"));
$appointments_search = mysql_query($query_appointments_search, $nyamira_hospital) or die(mysql_error());
$row_appointments_search = mysql_fetch_assoc($appointments_search);
$totalRows_appointments_search = mysql_num_rows($appointments_search);

$queryString_appointments = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_appointments") == false && 
        stristr($param, "totalRows_appointments") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_appointments = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_appointments = sprintf("&totalRows_appointments=%d%s", $totalRows_appointments, $queryString_appointments);

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
      
       <button type="button" class="btn btn-success"> Entries found <span class="badge"><?php echo $totalRows_appointments_search ?></span></button>
       </div>
      </div>
      <form action="" method="post" name="search">
      <div class="col-sm-4">
         <form action="" method="post" name="search">
      <div class="col-sm-4">
        <select class="form-control" name="name">
  <option value="Patients Name"> First Name</option>
  <option value="Ward"> Last Name</option>
  <option value="Bed"> phone_no</option>
  <option value="Doctor_in_charge"> Doctor_to_consult</option>
  <option value="date"> date_of_appointment</option>
  <option value="Time"> Time_of_appointment</option>
   <?php
do {  
?>
<option value="<?php echo $First_Name['fname']?>"><?php echo $row_First_Name['fname']?> <?php echo $row_First_Name['lname']?></option>
  <?php
} while ($row_First_Name = mysql_fetch_assoc($First_Name));
  $rows = mysql_num_rows($First_Name);
  if($rows > 0) {
      mysql_data_seek($First_Name, 0);
    $row_First_Name = mysql_fetch_assoc($First_Name);
  }
?>
 <?php
do {  
?>
<option value="<?php echo $row_Last_Name['fname']?>"><?php echo $row_Last_Name['fname']?> <?php echo $row_Last_Name['fname']?></option>
  <?php
} while ($row_Last_Name = mysql_fetch_assoc($Last_Name));
  $rows = mysql_num_rows($Last_NameName);
  if($rows > 0) {
      mysql_data_seek($Last_Name, 0);
    $row_Last_Name = mysql_fetch_assoc($Last_Name);
  }
?>
 <?php
do {  
?>
<option value="<?php echo $row_phone_no['fname']?>"><?php echo $row_phone_no['fname']?> <?php echo $row_phone_no['phone_no']?></option>
  <?php
} while ($row_phone_no = mysql_fetch_assoc($phone_no));
  $rows = mysql_num_rows($phone_no);
  if($rows > 0) {
      mysql_data_seek($phone_no, 0);
    $row_phone_no = mysql_fetch_assoc($phone_no);
  }
?>
 <?php
do {  
?>
<option value="<?php echo $row_Doctor_to_consult['fname']?>"><?php echo $row_Doctor_to_consult['fname']?> <?php echo $row_Doctor_to_consult['lname']?></option>
  <?php
} while ($row_Doctor_to_consult = mysql_fetch_assoc($row_Doctor_to_consult));
  $rows = mysql_num_rows($row_Doctor_to_consult);
  if($rows > 0) {
      mysql_data_seek($row_Doctor_to_consult, 0);
    $row_Doctor_to_consult = mysql_fetch_assoc($row_Doctor_to_consult);
  }
?>
 <?php
do {  
?>
<option value="<?php echo $row_date_of_appointment['date']?>"><?php echo $row_date_of_appointment['date']?> <?php echo $row_date_of_appointment['date']?></option>
  <?php
} while ($row_date_of_appointment = mysql_fetch_assoc($row_date_of_appointment));
  $rows = mysql_num_rows($row_date_of_appointment);
  if($rows > 0) {
      mysql_data_seek($row_date_of_appointment, 0);
    $row_date_of_appointment = mysql_fetch_assoc($row_date_of_appointment);
  }
?>
 <?php
do {  
?>
<option value="<?php echo $row_Time_of_appointment['time']?>"><?php echo $row_Time_of_appointment['time']?> <?php echo $row_Time_of_appointment['time']?></option>
  <?php
} while ($row_Time_of_appointment = mysql_fetch_assoc($row_Time_of_appointment));
  $rows = mysql_num_rows($row_Time_of_appointment);
  if($rows > 0) {
      mysql_data_seek($row_Time_of_appointment, 0);
    $row_Time_of_appointment = mysql_fetch_assoc($row_Time_of_appointment);
  }
?>
</select>
</div>
<input name="searchID" class="form-control input-sm" placeholder=""  type="search"> 
      </div>
      <div class="col-sm-2">
<input name="go" type="submit" value="Go" class="btn btn-primary"/>
      </div>

      </form>
<input name="searchID" class="form-control input-sm" placeholder=""  type="search"> 
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
              <th>Phone Number</th>
              <th>Doctor to Consult</th>
              <th>Date of appointment</th>
              <th>Time of Appointment</th>

            </tr>
          </thead>
          <tbody>
            <?php do { ?>
            <tr>
              <td><?php echo $row_appointments_search['userId']; ?></td>
              <td><?php echo $row_appointments_search['fname']; ?></td>
              <td><?php echo $row_appointments_search['lname']; ?></td>
              <td><?php echo $row_appointments_search['phone']; ?></td>
              <td><?php echo $row_appointments_search['doctor']; ?></td>
              <td><?php echo $row_appointments_search['date']; ?></td>
              <td><?php echo $row_appointments_search['time']; ?></td>
              <td><a href="edit_appointments.php?fname=<?php echo $row_appointments_search['fname']; ?>">Edit</a></td>
              <td><a href="delete_appointments.php?fname=<?php echo $row_appointments_search['fname']; ?>">Delete</a></td>
            </tr>
            <?php } while ($row_appointments_search = mysql_fetch_assoc($appointments_search)); ?>
          
          </tbody>
        </table>
    
      </div>
  </div>
</div>
<!--search end-->










  
  <div class="col-xs-12">
    
        <h2>Appointments</h2>
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
              <th>Phone Number</th>
              <th>Doctor to Consult</th>
              <th>Date of appointment</th>
              <th>Time of Appointment</th>
             

            </tr>
          </thead>
          <tbody>
         
            <?php do { ?>
            <tr>
              <td><?php echo $row_appointments['userId']; ?></td>
              <td><?php echo $row_appointments['fname']; ?></td>
              <td><?php echo $row_appointments['lname']; ?></td>
              <td><?php echo $row_appointments['phone']; ?></td>
              <td><?php echo $row_appointments['doctor']; ?></td>
              <td><?php echo $row_appointments['date']; ?></td>
              <td><?php echo $row_appointments['time']; ?></td>
            </tr>
            <?php } while ($row_appointments = mysql_fetch_assoc($appointments)); ?>
             
          </tbody>
        </table>
     
<!--paging-->
        <div class="row">
          <div class="col-sm-5"> Showing <?php echo ($startRow_appointments + 1) ?> to <?php echo min($startRow_appointments + $maxRows_appointments, $totalRows_appointments) ?> of <?php echo $totalRows_appointments ?> entries </div>
          <div class="col-sm-7">
            <div class="dataTables_paginate ">
              <ul class="pagination">
                <a href="<?php printf("%s?pageNum_appointments=%d%s", $currentPage, max(0, $pageNum_appointments - 1), $queryString_appointments); ?>">
                <?php if ($pageNum_appointments > 0) { // Show if not first page ?>
                  Previous
  <?php } // Show if not first page ?>
                </a>
                <a href="<?php printf("%s?pageNum_appointments=%d%s", $currentPage, min($totalPages_appointments, $pageNum_appointments + 1), $queryString_appointments); ?>">
                <?php if ($pageNum_appointments < $totalPages_appointments) { // Show if not last page ?>
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
mysql_free_result($appointments);

mysql_free_result($appointments_search);
?>
