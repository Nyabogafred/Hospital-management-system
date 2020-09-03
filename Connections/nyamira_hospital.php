<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_nyamira_hospital = "localhost";
$database_nyamira_hospital = "nyamira_hospital";
$username_nyamira_hospital = "root";
$password_nyamira_hospital = "";
$nyamira_hospital = mysql_pconnect($hostname_nyamira_hospital, $username_nyamira_hospital, $password_nyamira_hospital) or trigger_error(mysql_error(),E_USER_ERROR); 
?>