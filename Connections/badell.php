<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_badell = "localhost";
$database_badell = "red";
$username_badell = "root";
$password_badell = "";
$badell = mysql_pconnect($hostname_badell, $username_badell, $password_badell) or trigger_error(mysql_error(),E_USER_ERROR);
?>
<?php if (!isset($_SESSION)) {
  session_start();
}
?>
<?php include "funciones.php"; ?>