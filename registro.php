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

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="correoRepetido.php";
  $loginUsername = $_POST['correo'];
  $LoginRS__query = sprintf("SELECT correo FROM usuario WHERE correo=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_badell, $badell);
  $LoginRS=mysql_query($LoginRS__query, $badell) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "forms1")) {
  $insertSQL = sprintf("INSERT INTO usuario (correo, nombre, apellido, fecha_nacimiento, pass) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['fecha_nacimiento'], "date"),
                       GetSQLValueString($_POST['pass'], "text"));

  mysql_select_db($database_badell, $badell);
  $Result1 = mysql_query($insertSQL, $badell) or die(mysql_error());
}
?>
 <?php
//Llamar procedure
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
$apellido =  $_POST['apellido'];
$nombre =  $_POST['nombre'];
$pass = $_POST['pass'];
$fechas = $_POST['fecha_nacimiento'];
$email = $_POST['correo'];
 $insertSQL = sprintf("CALL registrarse('$email', '$nombre','$apellido','$fechas','$pass')");
 mysql_select_db($database_badell, $badell);
  $Result1 = mysql_query($insertSQL, $badell) or die(mysql_error());
  $MM_redirectLoginSuccess = "index.php";
   header("Location: " . $MM_redirectLoginSuccess );
  
}
?> 

<?php
// ************* Mostrar error si viene de un login errado
if (isset($_GET['notRegistered'])){
  $error = "Usuario no registrado por favor registrese para poder disfrutar de la red social";
}else{
  $error = null;
}

?>

<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/login.dwt.php" codeOutsideHTMLIsLocked="false" --><head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>

<body class="hold-transition login-page">
<!-- InstanceBeginEditable name="EditRegion3" -->
<div class="register-box">
  <div class="register-logo">
    <a href="../../index2.html"><b>Admin</b>LTE</a>
  </div>

  <?php
    if($error != null){
       echo '<p style="padding:1em" class="bg-danger">' . $error . '</p>';
    }
    ?>

  <div class="register-box-body">
    
    
    <p class="login-box-msg">Registrate y se un nuevo miembro</p>

    <form method="post" name="form1" id="registration_form" action="<?php echo $editFormAction; ?>">
      <div class="form-group has-feedback">
        <input type="text" name="nombre" required class="form-control" placeholder="Nombre"
        data-required-error="El nombre es requerido"
        data-error="Por favor coloque su nombre"
        maxlength="45"
        minlength="2"
        >
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
        <input type="text" name="apellido" required class="form-control" placeholder="Apellido"
        data-required-error="El nombre es requerido"
        data-error="Por favor coloque su apellido"
        maxlength="45"
        minlength="2"
        >
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
        <input type="email" name="correo" class="form-control" placeholder="CorreoElectronico"
        data-validate="true"
        maxlength="250"
        data-required-error="El correo electronico es requerido"
        data-error="Escriba una direccion de correo válida"
        data-match-error="Escriba una direccion de correo válida"
        >
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">

        <input type="password" required name="pass" id="pass" class="form-control" placeholder="Password"
        maxlength="250"
        minlength="8"
        data-minlength-error="debe contener al menos 8 caracteres"
        
        >
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
        <input type="password" required class="form-control" placeholder="Repita su password"
        data-repeatpass="true"
        >
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="form-group has-feedback">
        <input type="date" name="fecha_nacimiento" class="form-control" required placeholder="Fecha de nacimiento">
        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        <div class="help-block with-errors"></div>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
          
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Registrate</button>
        </div>
        <!-- /.col -->
      </div>
      <input type="hidden" name="MM_insert" value="form1">
    </form>

    <div class="social-auth-links text-center">
      
    </div>

    <a href="index.php" class="text-center">Ya eres miebro</a>
  </div>
  <!-- /.form-box -->
</div>

<script src="dist/js/jquery.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>

<script src="dist/js/validator.js"></script>
<script>
  $(document).ready(function() {
    $('#registration_form').validator({
      custom: {
        repeatpass: function($el) {
          var pass = $('#pass').val();
          if($el.val() !== pass){
            return 'Contraseñas no coinciden';
          }
        }
      }
    });
  });
</script>

</body>
<!-- InstanceEnd --></html>
