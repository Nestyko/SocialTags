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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO comentario (fecha, contenido, publicacion, usuario) VALUES (now(), %s, %s, %s)",
                       GetSQLValueString($_POST['contenido'], "text"),
                       GetSQLValueString($_POST['publicacion'], "int"),
                       GetSQLValueString($_POST['usuario'], "int"));

  mysql_select_db($database_badell, $badell);
  $Result1 = mysql_query($insertSQL, $badell) or die(mysql_error());
}

$a_publicacion = "0";
if (isset($_GET["id"])) {
  $a_publicacion = $_GET["id"];
}
mysql_select_db($database_badell, $badell);
$query_publicacion = sprintf("SELECT * from publicacion inner join usuario on publicacion.usuario = usuario.id  WHERE publicacion.idp = %s", GetSQLValueString($a_publicacion, "int"));
$publicacion = mysql_query($query_publicacion, $badell) or die(mysql_error());
$row_publicacion = mysql_fetch_assoc($publicacion);
$totalRows_publicacion = "0";
if (isset($_GET["id"])) {
  $totalRows_publicacion = $_GET["id"];
}
$a_publicacion = "0";
if (isset($_GET["id"])) {
  $a_publicacion = $_GET["id"];
}
mysql_select_db($database_badell, $badell);
$query_publicacion = sprintf("SELECT * FROM publicacion inner join usuario on publicacion.usuario = usuario.id WHERE publicacion.idp = %s", GetSQLValueString($a_publicacion, "int"));
$publicacion = mysql_query($query_publicacion, $badell) or die(mysql_error());
$row_publicacion = mysql_fetch_assoc($publicacion);
$totalRows_publicacion = mysql_num_rows($publicacion);

$b_Recordset1 = "0";
if (isset($_GET["id"])) {
  $b_Recordset1 = $_GET["id"];
}
mysql_select_db($database_badell, $badell);
$query_Recordset1 = sprintf("SELECT * FROM comentario WHERE comentario.publicacion = %s", GetSQLValueString($b_Recordset1, "int"));
$Recordset1 = mysql_query($query_Recordset1, $badell) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html>
<html><!-- InstanceBegin template="/Templates/todas.dwt.php" codeOutsideHTMLIsLocked="false" -->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Base de Datos Red Social</title>
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
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="file:///C|/xampp/htdocs/index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>R</b>ED</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Red</b>Social</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         
		 
          
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="Img_Perfil/<?php echo ObtenerperfilCorreoUsuario($_SESSION['MM_Username']) ?>" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo ObtenerNombreUsuario($_SESSION['MM_Username']) ?> &nbsp; <?php echo ObtenerApellidoUsuario($_SESSION['MM_Username']) ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="Img_Perfil/<?php echo ObtenerperfilCorreoUsuario($_SESSION['MM_Username']) ?>" class="img-circle" alt="User Image">

                <p>
                  <?php echo ObtenerNombreUsuario($_SESSION['MM_Username']) ?> &nbsp; <?php echo ObtenerApellidoUsuario($_SESSION['MM_Username']) ?>
                  <small></small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Amigos</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="perfil.php?id=<?php echo $_SESSION['MM_Username']  ?>" class="btn btn-default btn-flat">Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="salir.php" class="btn btn-default btn-flat">Salir</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="Img_Perfil/<?php echo ObtenerperfilCorreoUsuario($_SESSION['MM_Username']) ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
         <?php echo ObtenerNombreUsuario($_SESSION['MM_Username']) ?> &nbsp; <?php echo ObtenerApellidoUsuario($_SESSION['MM_Username']) ?>
          <a href="perfil.php?id=<?php echo $_SESSION['MM_Username']; ?>"><i class="fa fa-circle text-success"></i> Perfil</a>
        </div>
      </div>
      <!-- search form -->
      <form action="personas.php" method="post" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="c" id="c" class="form-control" placeholder="Buscar...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
       <li>
          <a href="ingreso.php">
            <i class="fa fa-th"></i> <span>Inicio</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">Publicaciones</small>
            </span>
          </a>
        </li>
        
      
       
        
        
        <li>
          <a href="calendar.html">
            <i class="fa fa-calendar"></i> <span>Amigos Con intereces comunes</span>
            <span class="pull-right-container">
              
            </span>
          </a>
        </li>
       
        
        
            
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content"><!-- InstanceBeginEditable name="EditRegion3" -->
	 <section class="content">
        <div class="row">
        <div class="post">
                  <div class="user-block">
                    <img class="img-circle img-bordered-sm" src="Img_Perfil/<?php echo $row_publicacion['perfil']; ?>" alt="user image">
                        <span class="username">
                          <a href="#"><?php echo $row_publicacion['nombre']; ?> <?php echo $row_publicacion['apellido'] ?></a>
                          <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                    <span class="description">Fecha de publicacion - <?php echo $row_publicacion['fecha']; ?></span>
                  </div>
                  <!-- /.user-block -->
                  <p>
                    <?php echo $row_publicacion['contenido']; ?>
                  </p>
                  <ul class="list-inline">
                  </ul>
          </div>
          <div class="box box-success">
            <div class="box-header">
              <i class="fa fa-comments-o"></i>

              <h3 class="box-title">Comentarios</h3>

              <div class="box-tools pull-right" data-toggle="tooltip" title="Status">
                <div class="btn-group" data-toggle="btn-toggle">
                  
                </div>
              </div>
            </div>
            <?php if ($totalRows_Recordset1>0){ ?>
            <?php do { ?>
            <div class="box-body chat" id="chat-box">
              <!-- chat item -->
              <div class="item">
                <img src="Img_Perfil/<?php echo ObtenerperfilIdUsuario($row_Recordset1['usuario']) ?>" alt="user image" class="online">
                  
                <p class="message">
                  <a href="#" class="name">
                    <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?php echo $row_Recordset1['fecha']; ?></small>
                    <?php echo ObtenerNombreIdUsuario($row_Recordset1['usuario'])
  ?><?php echo ObtenerApellidoIdUsuario($row_Recordset1['usuario']) ?>
                  </a>
                  <?php echo $row_Recordset1['contenido']; ?>
                </p>
                </div>
              </div>
              
        <hr><?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
        <?php }?></div>
         <form class="form-validate" method="post" name="form1" action="<?php echo $editFormAction; ?>">
                  <input required name="contenido" class="form-control input-sm" type="text" 
                  minlength="2"
                  maxlength="256"
                  data-minlength-error="Debe tener al menos 2 caracteres"
                  data-maxlength-error="No debe contener mas de 256 caracteres"
                  placeholder="Escriba su comentario">
                  <div class="help-block with-errors"></div>
                  <input type="submit" class="btn btn-default" value="AgregarComentario">
                <input type="hidden" name="publicacion" value="<?php echo $row_publicacion['idp']; ?>" size="32">
 				<input type="hidden" name="usuario" value="<?php echo ObtenerIdUsuario($_SESSION['MM_Username']) ?>" size="32">
      			<input type="hidden" name="MM_insert" value="form1">
                </form>
     </section>
	<!-- InstanceEndEditable -->


    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      
    </div>
    <strong>Copyright &copy; 2016 <a>Social Red</a>.</strong> Todos los derechos reservados Agradecimientos especiales the black cat
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>

      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="ajax.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<script src="dist/js/validator.js"></script>
<script>
  $(document).ready(function() {
    $('.form-validate').validator();
  });
</script>
</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($publicacion);

mysql_free_result($Recordset1);
?>
