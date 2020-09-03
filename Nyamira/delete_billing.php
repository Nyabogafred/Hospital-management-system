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
  $deleteSQL = sprintf("DELETE FROM billing WHERE userId=%s",
                       GetSQLValueString($_POST['hiddenField'], "text"));

  mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
  $Result1 = mysql_query($deleteSQL, $nyamira_hospital) or die(mysql_error());

  $deleteGoTo = "billing_details.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_delete = "-1";
if (isset($_GET['name'])) {
  $colname_delete = $_GET['name'];
}
mysql_select_db($database_nyamira_hospital, $nyamira_hospital);
$query_delete = sprintf("SELECT * FROM billing WHERE name = %s", GetSQLValueString($colname_delete, "text"));
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
    <td>Patient's Name</td>
    <td><?php echo $row_delete['name']; ?></td>
  </tr>
  <tr>
    <td>Gender</td>
    <td><?php echo $row_delete['gender']; ?></td>
  </tr>
  <tr>
    <td>Phone Number</td>
    <td><?php echo $row_delete['number']; ?></td>
  </tr>
  <tr>
    <td>Date discharged</td>
    <td><?php echo $row_delete['discharged']; ?></td>
  </tr>
  <tr>
    <td>Room charges</td>
    <td><?php echo $row_delete['room']; ?></td>
  </tr>
  <tr>
    <td>Medicine charges</td>
    <td><?php echo $row_delete['medicine']; ?></td>
  </tr>
  <tr>
    <td>Total amount</td>
    <td><?php echo $row_delete['amount']; ?></td>
  </tr>
  
  <tr>
    <td colspan="2">	<div align="center">
		<input type="submit" name="submit" id="submit" value="Delete" />
       <button type="button" class="btn btn-success"> <a href="doctors_details.php">Cancel</a></button> </div></td>
  </tr>

          <tbody>
</table>
</form>


</body>
</html>
<?php
mysql_free_result($delete);
?>
