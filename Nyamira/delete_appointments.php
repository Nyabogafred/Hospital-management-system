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

if ((isset($_POST['hiddenField'])) && ($_POST['hiddenField'] != "")) {
  $deleteSQL = sprintf("DELETE FROM appointments WHERE userId=%s",
                       GetSQLValueString($_POST['hiddenField'], "text"));

  mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
  $Result1 = mysql_query($deleteSQL, $nyamira_hospital) or die(mysql_error());

  $deleteGoTo = "appointments_details.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_delete = "-1";
if (isset($_GET['fname'])) {
  $colname_delete = $_GET['fname'];
}
mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_delete = sprintf("SELECT * FROM appointments WHERE fname = %s", GetSQLValueString($colname_delete, "text"));
$delete = mysql_query($query_delete, $nyamira_hospital) or die(mysql_error());
$row_delete = mysql_fetch_assoc($delete);
$totalRows_delete = mysql_num_rows($delete);
?>
<html>
<head>
	<title></title>
<link rel="stylesheet" type="text/css" href="css/bootsrap.min.css">
</head>
<body>
  <h3>Are you sure you want to delete this record?</h3>
<form id="form1" name="form1" method="post" action="">
<span class="style3">
<input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_delete['userId']; ?>"  />
</span>
 <table class="table table-hover">
          <thead>
  <tr>
    <td>#</td>
    <td><?php echo $row_delete['userId']; ?></td>
  </tr>
     </thead>
  <tr>
    <td>First Name</td>
    <td><?php echo $row_delete['fname']; ?></td>
  </tr>
  <tr>
    <td>Last Name</td>
    <td><?php echo $row_delete['lname']; ?></td>
  </tr>
  <tr>
    <td>Phone number</td>
    <td><?php echo $row_delete['phone']; ?></td>
  </tr>
  <tr>
    <td>Doctor to consult</td>
    <td><?php echo $row_delete['doctor']; ?></td>
  </tr>
  <tr>
    <td>Date of appointment</td>
    <td><?php echo $row_delete['date']; ?></td>
  </tr>
  <tr>
    <td>Time of appointment</td>
    <td><?php echo $row_delete['time']; ?></td>
  </tr>
  <tr>
    <td colspan="2">	<div align="center">
		<input type="submit" name="submit" id="submit" value="Delete" />
       <button type="button" class="btn btn-success"> <a href="appointments_details.php">Cancel</a></button> </div></td>
  </tr>

          <tbody>
</table>
</form>


</body>
</html>
<?php
mysql_free_result($delete);
?>
