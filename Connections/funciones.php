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


//***************************************************
//***************************************************
//***************************************************

function ObtenerNombreUsuario($identificador)
{

	global $database_badell, $badell;
	mysql_select_db($database_badell, $badell);
	$query_ConsultaFuncion = sprintf("SELECT nombre FROM usuario WHERe correo = %s",GetSQLValueString($identificador,"text"));
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion,$badell) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['nombre']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
//***************************************************

//***************************************************
//***************************************************
//***************************************************
//$_SESSION['MM_Username'];

function ObtenerApellidoUsuario($identificador)
{

	global $database_badell, $badell;
	mysql_select_db($database_badell, $badell);
	$query_ConsultaFuncion = sprintf("SELECT apellido FROM usuario WHERe correo = %s",GetSQLValueString($identificador,"text"));
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion,$badell) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['apellido']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
//***************************************************
//***************************************************
//***************************************************
//***************************************************

function ObtenerIdUsuario($identificador)
{

	global $database_badell, $badell;
	mysql_select_db($database_badell, $badell);
	$query_ConsultaFuncion = sprintf("SELECT id FROM usuario WHERE correo = %s",GetSQLValueString($identificador,"text"));
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion,$badell) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['id']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
//***************************************************
//***************************************************
//***************************************************
//***************************************************

function ObtenerNombreIdUsuario($identificador)
{

	global $database_badell, $badell;
	mysql_select_db($database_badell, $badell);
	$query_ConsultaFuncion = sprintf("SELECT nombre FROM usuario WHERE id = %s",GetSQLValueString($identificador,"text"));
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion,$badell) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['nombre']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
//***************************************************
//***************************************************
//***************************************************
//***************************************************

function ObtenerApellidoIdUsuario($identificador)
{

	global $database_badell, $badell;
	mysql_select_db($database_badell, $badell);
	$query_ConsultaFuncion = sprintf("SELECT apellido FROM usuario WHERE id = %s",GetSQLValueString($identificador,"text"));
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion,$badell) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['apellido']; 
	mysql_free_result($ConsultaFuncion);
}
//***************************************************
//***************************************************
//***************************************************
//***************************************************

function ObtenerperfilIdUsuario($identificador)
{

	global $database_badell, $badell;
	mysql_select_db($database_badell, $badell);
	$query_ConsultaFuncion = sprintf("SELECT perfil FROM usuario WHERE id = %s",GetSQLValueString($identificador,"text"));
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion,$badell) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['perfil']; 
	mysql_free_result($ConsultaFuncion);
}

//***************************************************
//***************************************************
//***************************************************
//***************************************************

function ObtenerperfilCorreoUsuario($identificador)
{

	global $database_badell, $badell;
	mysql_select_db($database_badell, $badell);
	$query_ConsultaFuncion = sprintf("SELECT perfil FROM usuario WHERE correo = %s",GetSQLValueString($identificador,"text"));
	$ConsultaFuncion = mysql_query($query_ConsultaFuncion,$badell) or die(mysql_error());
	$row_ConsultaFuncion = mysql_fetch_assoc($ConsultaFuncion);
	$totalRows_ConsultaFuncion = mysql_num_rows($ConsultaFuncion);
	
	return $row_ConsultaFuncion['perfil']; 
	mysql_free_result($ConsultaFuncion);
}
//***************************************************
//***************************************************
//***************************************************
//***************************************************

