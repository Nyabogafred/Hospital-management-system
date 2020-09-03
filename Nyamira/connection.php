<?php
$connect = mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("nyamira_hospital",$connect) or die(mysql_error());


?>