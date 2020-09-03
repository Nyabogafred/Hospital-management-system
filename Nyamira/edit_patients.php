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
  $updateSQL = sprintf("UPDATE patients SET fname=%s, lname=%s, email=%s, phone=%s, address=%s, date_of_birth=%s, gender=%s, blood_group=%s, diagnosis=%s WHERE userId=%s",
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['date_of_birth'], "date"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['blood_group'], "text"),
                       GetSQLValueString($_POST['diagnosis'], "text"),
                       GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
  $Result1 = mysql_query($updateSQL, $nyamira_hospital) or die(mysql_error());

  $updateGoTo = "patients_details.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_update = "-1";
if (isset($_GET['email'])) {
  $colname_update = $_GET['email'];
}
mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_update = sprintf("SELECT * FROM patients WHERE email = %s", GetSQLValueString($colname_update, "text"));
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
    <td>Email</td>
    <td><input name="email" type="text" class="form-control" value="<?php echo $row_update['email']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Phone Number</td>
    <td><input name="phone" type="text" class="form-control" value="<?php echo $row_update['phone']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Address</td>
    <td><input name="address" type="text" class="form-control" value="<?php echo $row_update['address']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Date of birth</td>
    <td><input name="date_of_birth" type="text" class="form-control" value="<?php echo $row_update['date_of_birth']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Gender</td>
    <td><input name="gender" type="text" class="form-control" value="<?php echo $row_update['gender']; ?>" >&nbsp;</td>
  </tr>
   <tr>
    <td>Blood Group</td>
    <td><input name="blood_group" type="text" class="form-control" value="<?php echo $row_update['blood_group']; ?>" >&nbsp;</td>
  </tr>
   <tr>
    <td>Diagnosis</td>
    <td><input name="diagnosis" type="text" class="form-control" value="<?php echo $row_update['diagnosis']; ?>" >&nbsp;</td>
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
		</div>
</div>
</form>
</body>
</html>
<?php
mysql_free_result($update);
?>
