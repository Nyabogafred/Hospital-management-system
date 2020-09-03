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
  $updateSQL = sprintf("UPDATE billing SET name=%s, gender=%s, `number`=%s, discharged=%s, room=%s, medicine=%s, amount=%s WHERE userId=%s",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['number'], "text"),
                       GetSQLValueString($_POST['discharged'], "text"),
                       GetSQLValueString($_POST['room'], "text"),
                       GetSQLValueString($_POST['medicine'], "text"),
                       GetSQLValueString($_POST['amount'], "text"),
                       GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_kerugoya_hospital, $kerugoya_hospital);
  $Result1 = mysql_query($updateSQL, $kerugoya_hospital) or die(mysql_error());

  $updateGoTo = "billing_details.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_update = "-1";
if (isset($_GET['name'])) {
  $colname_update = $_GET['name'];
}
mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_update = sprintf("SELECT * FROM billing WHERE name = %s", GetSQLValueString($colname_update, "text"));
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
    <td>Patient's Name</td>
    <td><input name="name" type="text" class="form-control" value="<?php echo $row_update['name']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Gender</td>
    <td><input name="gender" type="text" class="form-control" value="<?php echo $row_update['gender']; ?>" >&nbsp;</td>
  </tr>
   <tr>
    <td>Phone number</td>
    <td><input name="number" type="text" class="form-control" value="<?php echo $row_update['number']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Date Discharged</td>
    <td><input name="discharged" type="text" class="form-control" value="<?php echo $row_update['discharged']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Room charges</td>
    <td><input name="room" type="text" class="form-control" value="<?php echo $row_update['room']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Medicine charges</td>
    <td><input name="medicine" type="text" class="form-control" value="<?php echo $row_update['medicine']; ?>" >&nbsp;</td>
  </tr>
  <tr>
    <td>Total amount</td>
    <td><input name="amount" type="text" class="form-control" value="<?php echo $row_update['amount']; ?>" >&nbsp;</td>
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
		<input type="hidden" name="MM_update" value="form1">
		</div>
</div>
		</div>
</div>
</form>
</body>
</html>
<?php
mysql_free_result($update);
?>
