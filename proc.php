<?php require_once('Connections/badell.php'); ?>

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form3")) {
  $insertSQL = sprintf("REPLACE  INTO usuario_has_tag (usuario_id, tag_id) VALUES (%s, %s)",
                       GetSQLValueString($_POST['usuario_id'], "int"),
                       GetSQLValueString($_POST['tag_id'], "int"));

  mysql_select_db($database_badell, $badell);
  $Result1 = mysql_query($insertSQL, $badell) or die(mysql_error());

  $insertGoTo = "ingreso.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php

include 'conexion.php';

$q=$_POST['q'];
$con=conexion();

$sql="SELECT * FROM tag  where tag LIKE '".$q."%'";
$res=mysql_query($sql,$con);

if(mysql_num_rows($res)==0){

echo '<b>No hay sugerencias</b>';

}else{

echo '<b>Sugerencias:</b><br />';

while($fila=mysql_fetch_array($res)){

echo $fila['tag'].'<br />';


}


}



?>

<?php 





$a_tag = "";

  $a_tag = $q;


mysql_select_db($database_badell, $badell);
$query_tag = sprintf("SELECT * FROM tag WHERE tag.tag = %s", GetSQLValueString($a_tag, "text"));
$tag = mysql_query($query_tag, $badell) or die(mysql_error());
$row_tag = mysql_fetch_assoc($tag);
$totalRows_tag = mysql_num_rows($tag);
?>
<form action="<?php echo $editFormAction; ?>" method="post" name="form3" id="form3">
  
      
      <input type="hidden" name="usuario_id" value="<?php echo  ObtenerIdUsuario($_SESSION['MM_Username']); ?>" size="32" />
      <input type="hidden" name="tag_id" value="<?php echo $row_tag['id']; ?>" size="32" />
 
      <?php if ($totalRows_tag==1){
	   ?>

     <input class="btn btn-default btn-block" type="submit" value="Comparte tus gustos" />
    <input type="hidden" name="MM_insert" value="form3" />
</form>
<?php }?>
<p>&nbsp;</p>
</body>
</html>
<?php

mysql_free_result($tag);
?>
