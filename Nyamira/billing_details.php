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

$maxRows_billing = 10;
$pageNum_billing = 0;
if (isset($_GET['pageNum_billing'])) {
  $pageNum_billing = $_GET['pageNum_billing'];
}
$startRow_billing = $pageNum_billing * $maxRows_billing;

mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_billing = "SELECT * FROM billing";
$query_limit_billing = sprintf("%s LIMIT %d, %d", $query_billing, $startRow_billing, $maxRows_billing);
$billing = mysql_query($query_limit_billing, $nyamira_hospital) or die(mysql_error());
$row_billing = mysql_fetch_assoc($billing);

if (isset($_GET['totalRows_billing'])) {
  $totalRows_billing = $_GET['totalRows_billing'];
} else {
  $all_billing = mysql_query($query_billing);
  $totalRows_billing = mysql_num_rows($all_billing);
}
$totalPages_billing = ceil($totalRows_billing/$maxRows_billing)-1;

$colname_billing_search = "-1";
if (isset($_POST['searchID'])) {
  $colname_billing_search = $_POST['searchID'];
}
mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_billing_search = sprintf("SELECT * FROM billing WHERE name LIKE %s", GetSQLValueString("%" . $colname_billing_search . "%", "text"));
$billing_search = mysql_query($query_billing_search, $nyamira_hospital) or die(mysql_error());
$row_billing_search = mysql_fetch_assoc($billing_search);
$totalRows_billing_search = mysql_num_rows($billing_search);

$queryString_billing = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_billing") == false && 
        stristr($param, "totalRows_billing") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_billing = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_billing = sprintf("&totalRows_billing=%d%s", $totalRows_billing, $queryString_billing);

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
      
       <button type="button" class="btn btn-success"> Entries found <span class="badge"><?php echo $totalRows_billing_search ?></span></button>
       </div>
      </div>
      <form action="" method="post" name="search">
      <div class="col-sm-4">
         <form action="" method="post" name="search">
      <div class="col-sm-4">
        <select class="form-control" name="name">
  <option value="Patients Name"> Patients Name</option>
  <option value="Ward"> phone no</option>
  <option value="Bed"> Date_discharged</option>
 
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
<option value="<?php echo $row_phone_no['fname']?>"><?php echo $row_phone_no['fname']?> <?php echo $row_phone_no['fname']?></option>
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
<option value="<?php echo $row_Date_discharged['fname']?>"><?php echo $row_Date_discharged['fname']?> <?php echo $row_Date_discharged['lname']?></option>
  <?php
} while ($row_Date_discharged = mysql_fetch_assoc($Date_discharged));
  $rows = mysql_num_rows($bed);
  if($rows > 0) {
      mysql_data_seek($Date_discharged, 0);
    $row_Date_discharged = mysql_fetch_assoc($Date_discharged);
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
<input name="searchID" class="form-control input-sm" placeholder="Search by name"  type="search"> 
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
              <th>Patient's Name</th>
              <th>Gender</th>
              <th>Phone Number</th>
              <th>Date Discharged</th>
              <th>Room Charges</th>
              <th>Medicine Charges</th>
               <th>Total Amount</th>
                
            </tr>
          </thead>
          <tbody>
         
             
       <?php do { ?>
            <tr>
              <td><?php echo $row_billing_search['userId']; ?></td>
              <td><?php echo $row_billing_search['name']; ?></td>
              <td><?php echo $row_billing_search['gender']; ?></td>
              <td><?php echo $row_billing_search['number']; ?></td>
              <td><?php echo $row_billing_search['discharged']; ?></td>
              <td><?php echo $row_billing_search['room']; ?></td>
              <td><?php echo $row_billing_search['medicine']; ?></td>
              <td><?php echo $row_billing_search['amount']; ?></td>
              <td><a href="edit_billing.php?name=<?php echo $row_billing_search['name']; ?>">Edit</a></td>
              <td><a href="delete_billing.php?name=<?php echo $row_billing_search['name']; ?>">Delete</a></td>
            </tr>
            <?php } while ($row_billing_search = mysql_fetch_assoc($billing_search)); ?>
   
</table>
          
          </tbody>
        </table>
       
      </div>
  </div>
</div>
<!--search end-->

<div class="col-xs-12">
    
        <h2>Patients' Billing Details</h2>
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
              <th>Patient's Name</th>
              <th>Gender</th>
              <th>Phone Number</th>
              <th>Date Discharged</th>
              <th>Room Charges</th>
              <th>Medicine Charges</th>
               <th>Total Amount</th>
                

            </tr>
          </thead>
          <tbody>
         
            
      <?php do { ?>
            <tr>
              <td><?php echo $row_billing['userId']; ?></td>
              <td><?php echo $row_billing['name']; ?></td>
              <td><?php echo $row_billing['gender']; ?></td>
              <td><?php echo $row_billing['number']; ?></td>
              <td><?php echo $row_billing['discharged']; ?></td>
              <td><?php echo $row_billing['room']; ?></td>
              <td><?php echo $row_billing['medicine']; ?></td>
              <td><?php echo $row_billing['amount']; ?></td>
            </tr>
            <?php } while ($row_billing = mysql_fetch_assoc($billing)); ?>
             
          </tbody>
        </table>
        
<!--paging-->
        <div class="row">
          <div class="col-sm-5"> Showing <?php echo ($startRow_billing + 1) ?> to <?php echo min($startRow_billing + $maxRows_billing, $totalRows_billing) ?> of <?php echo $totalRows_billing ?> entries </div>
          <div class="col-sm-7">
            <div class="dataTables_paginate ">
              <ul class="pagination">
                <a href="<?php printf("%s?pageNum_billing=%d%s", $currentPage, max(0, $pageNum_billing - 1), $queryString_billing); ?>">
                <?php if ($pageNum_billing > 0) { // Show if not first page ?>
                  Previous
  <?php } // Show if not first page ?>
                </a>
                <a href="<?php printf("%s?pageNum_billing=%d%s", $currentPage, min($totalPages_billing, $pageNum_billing + 1), $queryString_billing); ?>">
                <?php if ($pageNum_billing < $totalPages_billing) { // Show if not last page ?>
                  Next
  <?php } // Show if not last page ?>
                </a>
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
mysql_free_result($billing);

mysql_free_result($billing_search);
?>
