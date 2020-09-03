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

$maxRows_doctor_details = 10;
$pageNum_doctor_details = 0;
if (isset($_GET['pageNum_doctor_details'])) {
  $pageNum_doctor_details = $_GET['pageNum_doctor_details'];
}
$startRow_doctor_details = $pageNum_doctor_details * $maxRows_doctor_details;

mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_doctor_details = "SELECT * FROM doctors";
$query_limit_doctor_details = sprintf("%s LIMIT %d, %d", $query_doctor_details, $startRow_doctor_details, $maxRows_doctor_details);
$doctor_details = mysql_query($query_limit_doctor_details, $nyamira_hospital) or die(mysql_error());
$row_doctor_details = mysql_fetch_assoc($doctor_details);

if (isset($_GET['totalRows_doctor_details'])) {
  $totalRows_doctor_details = $_GET['totalRows_doctor_details'];
} else {
  $all_doctor_details = mysql_query($query_doctor_details);
  $totalRows_doctor_details = mysql_num_rows($all_doctor_details);
}
$totalPages_doctor_details = ceil($totalRows_doctor_details/$maxRows_doctor_details)-1;

$colname_doctor_search = "-1";
if (isset($_POST['searchID'])) {
  $colname_doctor_search = $_POST['searchID'];
}
mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_doctor_search = sprintf("SELECT * FROM doctors WHERE username LIKE %s", GetSQLValueString("%" . $colname_doctor_search . "%", "text"));
$doctor_search = mysql_query($query_doctor_search, $nyamira_hospital) or die(mysql_error());
$row_doctor_search = mysql_fetch_assoc($doctor_search);
$totalRows_doctor_search = mysql_num_rows($doctor_search);

$colname_patient_incharge = "-1";
if (isset($_POST['name'])) {
  $colname_patient_incharge = $_POST['name'];
}
mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_patient_incharge = sprintf("SELECT * FROM admissions WHERE name LIKE %s", GetSQLValueString("%" . $colname_patient_incharge . "%", "text"));
$patient_incharge = mysql_query($query_patient_incharge, $nyamira_hospital) or die(mysql_error());
$row_patient_incharge = mysql_fetch_assoc($patient_incharge);
$totalRows_patient_incharge = mysql_num_rows($patient_incharge);

$queryString_doctor_details = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_doctor_details") == false && 
        stristr($param, "totalRows_doctor_details") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_doctor_details = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_doctor_details = sprintf("&totalRows_doctor_details=%d%s", $totalRows_doctor_details, $queryString_doctor_details);

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
<title>Doctors</title>

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
      
       <button type="button" class="btn btn-success"> Entries found <span class="badge"><?php echo $totalRows_doctor_search ?> </span></button>
       </div>
      </div>
      <form action="" method="post" name="search">
      <div class="col-sm-4">
<input name="searchID" class="form-control input-sm" placeholder="Search by Username"  type="search"> 
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
               <th>Speciality</th>
                <th>Department</th>
                <th>Username</th>
                


            </tr>
          </thead>
          <tbody>
         
         <?php do { ?>
    <tr>
      <td><?php echo $row_doctor_search['userId']; ?></td>
      <td><?php echo $row_doctor_search['fname']; ?></td>
      <td><?php echo $row_doctor_search['lname']; ?></td>
      <td><?php echo $row_doctor_search['email']; ?></td>
      <td><?php echo $row_doctor_search['phone']; ?></td>
      <td><?php echo $row_doctor_search['address']; ?></td>
      <td><?php echo $row_doctor_search['date_of_birth']; ?></td>
      <td><?php echo $row_doctor_search['speciality']; ?></td>
      <td><?php echo $row_doctor_search['department']; ?></td>
      <td><?php echo $row_doctor_search['username']; ?></td>
      <td><a href="edit_doctors.php?username=<?php echo $row_doctor_search['username']; ?>">Edit</a></td>
       <td><a href="delete_doctors.php?username=<?php echo $row_doctor_search['username']; ?>">Delete</a></td>
     
    </tr>
    <?php } while ($row_doctor_search = mysql_fetch_assoc($doctor_search)); ?>
          
          </tbody>
        </table>
        

     
    </div>
  </div>
</div>
<!--search end-->

<div class="col-xs-12">
    
        <h2>Doctors' Details</h2>
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
               <th>Speciality</th>
                <th>Department</th>
                <th>Username</th>
               

            </tr>
          </thead>
          <tbody>
         
             <?php do { ?>
            <tr>
              <td><?php echo $row_doctor_details['userId']; ?></td>
              <td><?php echo $row_doctor_details['fname']; ?></td>
              <td><?php echo $row_doctor_details['lname']; ?></td>
              <td><?php echo $row_doctor_details['email']; ?></td>
              <td><?php echo $row_doctor_details['phone']; ?></td>
              <td><?php echo $row_doctor_details['address']; ?></td>
              <td><?php echo $row_doctor_details['date_of_birth']; ?></td>
              <td><?php echo $row_doctor_details['speciality']; ?></td>
              <td><?php echo $row_doctor_details['department']; ?></td>
              <td><?php echo $row_doctor_details['username']; ?></td>
              
              
            </tr>
            <?php } while ($row_doctor_details = mysql_fetch_assoc($doctor_details)); ?>
             
          </tbody>
        </table>
        
<!--paging-->
        <div class="row">
          <div class="col-sm-5"> Showing <?php echo ($startRow_doctor_details + 1) ?> to <?php echo min($startRow_doctor_details + $maxRows_doctor_details, $totalRows_doctor_details) ?> of <?php echo $totalRows_doctor_details ?> entries </div>
          <div class="col-sm-7">
            <div class="dataTables_paginate ">
              <ul class="pagination">
                <a href="<?php printf("%s?pageNum_doctor_details=%d%s", $currentPage, max(0, $pageNum_doctor_details - 1), $queryString_doctor_details); ?>">
                <?php if ($pageNum_doctor_details > 0) { // Show if not first page ?>
                  Previous
  <?php } // Show if not first page ?>
                </a>
                <a href="<?php printf("%s?pageNum_doctor_details=%d%s", $currentPage, min($totalPages_doctor_details, $pageNum_doctor_details + 1), $queryString_doctor_details); ?>">
                <?php if ($pageNum_doctor_details < $totalPages_doctor_details) { // Show if not last page ?>
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
mysql_free_result($doctor_details);

mysql_free_result($doctor_search);

mysql_free_result($patient_incharge);
?>
