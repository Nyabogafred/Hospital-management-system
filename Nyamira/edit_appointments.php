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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE appointments SET fname=%s, lname=%s, phone=%s, doctor=%s, `date`=%s, `time`=%s WHERE userId=%s",
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['doctor'], "text"),
                       GetSQLValueString($_POST['date'], "date"),
                       GetSQLValueString($_POST['time'], "text"),
                       GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
  $Result1 = mysql_query($updateSQL, $nyamira_hospital) or die(mysql_error());

  $updateGoTo = "appointments_details.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_update = "-1";
if (isset($_GET['fname'])) {
  $colname_update = $_GET['fname'];
}
mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_update = sprintf("SELECT * FROM appointments WHERE fname = %s", GetSQLValueString($colname_update, "text"));
$update = mysql_query($query_update, $nyamira_hospital) or die(mysql_error());
$row_update = mysql_fetch_assoc($update);
$totalRows_update = mysql_num_rows($update);
?>
<html>
<head>
	<title>Edit</title>
  <link rel="stylesheet" type="text/css" href="css/bootsrap.min.css">
</head>
<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
		 <table class="table table-hover">
          <thead>
  <tr>
    <td>#</td>
    <td><?php echo $row_update['userId']; ?></td>
  </tr>
</thead>
  <tr>
    <td>First Name</td>
    <td><input name="fname" type="text" class="form-control" value="<?php echo $row_update['fname']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Last Name</td>
    <td><input name="lname" type="text" class="form-control" value="<?php echo $row_update['lname']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Phone Number</td>
    <td><input name="phone" type="text" class="form-control" value="<?php echo $row_update['phone']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Doctor to consult</td>
    <td><input name="doctor" type="text" class="form-control" value="<?php echo $row_update['doctor']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Date of appointment</td>
    <td><input name="date" type="text" class="form-control" value="<?php echo $row_update['date']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Time of appointment</td>
    <td><input name="time" type="text" class="form-control" value="<?php echo $row_update['time']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">	<div align="center">
		<input type="submit" name="submit" id="submit" value="Update" />
	</div></td>
  </tr>
</table>
		<div align="center"><input type="hidden" name="id" />
		  <input name="id" type="hidden" value="<?php echo $row_update['userId']; ?>" />
		</div>
		<input type="hidden" name="MM_update" value="form1"></div>
</form>
</body>
</html>
<?php
mysql_free_result($update);
?>
