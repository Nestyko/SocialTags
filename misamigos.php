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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE usuario SET correo=%s, nombre=%s, apellido=%s, fecha_nacimiento=%s, pass=%s, educacion=%s,perfil=%s, destresas=%s WHERE id=%s",
                       GetSQLValueString($_POST['correo'], "text"),
                       GetSQLValueString($_POST['nombre'], "text"),
                       GetSQLValueString($_POST['apellido'], "text"),
                       GetSQLValueString($_POST['fecha_nacimiento'], "date"),
                       GetSQLValueString($_POST['pass'], "text"),
                       GetSQLValueString($_POST['educacion'], "text"),
					   GetSQLValueString($_POST['img'], "text"),
                       GetSQLValueString($_POST['destresas'], "text"),
                       GetSQLValueString($_POST['id'], "int"));

  mysql_select_db($database_badell, $badell);
  $Result1 = mysql_query($updateSQL, $badell) or die(mysql_error());
}

mysql_select_db($database_badell, $badell);
$query_Recordset1 = "SELECT * FROM comentario";
$Recordset1 = mysql_query($query_Recordset1, $badell) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$a_actualiar = "0";
if (isset($_GET["id"])) {
  $a_actualiar = $_GET["id"];
}
$a_actualiar = $_SESSION['MM_Username'];
$a_actualiar = "0";
if (isset($_GET["id"])) {
  $a_actualiar = ObtenerIdUsuario($_SESSION['MM_Username']);
}
mysql_select_db($database_badell, $badell);
$query_actualiar = sprintf("SELECT * FROM usuario WHERE usuario.id = %s", GetSQLValueString($a_actualiar, "int"));
$actualiar = mysql_query($query_actualiar, $badell) or die(mysql_error());
$row_actualiar = mysql_fetch_assoc($actualiar);
$totalRows_actualiar = mysql_num_rows($actualiar);

$a_Recordset2 = "0";
if (isset($_GET["id"])) {
  $a_Recordset2 = $_GET["id"];
}
$a_Recordset2 = ObtenerIdUsuario($_SESSION['MM_Username']);

mysql_select_db($database_badell, $badell);
$query_Recordset2 = sprintf("SELECT * FROM publicacion WHERE publicacion.usuario = %s", GetSQLValueString($a_Recordset2, "int"));
$Recordset2 = mysql_query($query_Recordset2, $badell) or die(mysql_error());
$row_Recordset2 = mysql_fetch_assoc($Recordset2);
$totalRows_Recordset2 = mysql_num_rows($Recordset2);

$a_elfinal = "0";
if (isset($_GET["id"])) {
  $a_elfinal = 2;
}

mysql_select_db($database_badell, $badell);
$query_elfinal = sprintf("SELECT * FROM usuario WHERE usuario.id = %s", GetSQLValueString($a_elfinal, "int"));
$elfinal = mysql_query($query_elfinal, $badell) or die(mysql_error());
$row_elfinal = mysql_fetch_assoc($elfinal);
$totalRows_elfinal = mysql_num_rows($elfinal);

$a_tag = "0";
if (isset($_GET["id"])) {
  $a_tag = $_GET["id"];
}
$a_tag = ObtenerIdUsuario($_SESSION['MM_Username']);

mysql_select_db($database_badell, $badell);
$query_tag = sprintf("SELECT * from tag inner join usuario_has_tag inner join usuario ON tag.id = usuario_has_tag.tag_id and usuario_has_tag.usuario_id = usuario.id where usuario.id = %s", GetSQLValueString($a_tag, "int"));
$tag = mysql_query($query_tag, $badell) or die(mysql_error());
$row_tag = mysql_fetch_assoc($tag);
$totalRows_tag = mysql_num_rows($tag);

?>

<html> 
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
                    <a href="misamigos.php">Amigos</a>
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
          <input type="email" name="c" id="c" class="form-control" placeholder="Buscar...">
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
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="Img_Perfil/<?php echo $row_actualiar['perfil']; ?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo ObtenerNombreUsuario($_SESSION['MM_Username']); ?> &nbsp;<?php echo ObtenerApellidoUsuario($_SESSION['MM_Username']) ?></h3>

              <p class="text-muted text-center">Hola Bienvenido a mi perfil</p>

              <ul class="list-group list-group-unbordered">
                
                
                <li class="list-group-item">
                  <b>Crea</b> <a href="tendencia.php" class="pull-right">Tendencia</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Acerca de mi</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-book margin-r-5"></i> Educacion</strong>

              <p class="text-muted">
               <?php echo $row_actualiar['educacion']; ?>
              </p>

              <hr>        

              <hr>

              <strong><i class="fa fa-pencil margin-r-5"></i> Describete</strong>

              <?php do { ?>
                <p>
                  <span class="label label-primary"><?php echo $row_tag['tag']; ?></span><br/>
                </p>
                <?php } while ($row_tag = mysql_fetch_assoc($tag)); ?>
<hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Notes</strong>

              <p>Manten segura tu informacion no publique tus cosas mas peronales.</p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul align="center"><a>MIS AMIGOS</a></br>
            
				
				<?php 
				$link = mysql_connect("localhost", "root"); 
				mysql_select_db("red", $link); 
				$result = mysql_query("SELECT usuario.nombre, usuario.apellido, usuario.correo, usuario.perfil FROM usuario_has_usuario
				INNER JOIN usuario
				ON usuario_has_usuario.usuario=usuario.id
				WHERE usuario_has_usuario.usuario1=27;", $link); 
				if ($row = mysql_fetch_array($result)){ 
   				echo "<table align = 'center' border = '1'> \n"; 
   				echo "<tr><td>Nombre</td><td>Apellido</td><td>Correo</td></tr>\n"; 
   				do { 
      			echo "<tr><td>".$row["nombre"]."</td><td>".$row["apellido"]."</td><td>".$row["correo"]."</td></tr> \n"; 
   				} while ($row = mysql_fetch_array($result)); 
   				echo "</table> \n"; 
				} else { 
				echo "¡ No se ha encontrado ningún registro !"; 
				} 
				?> 

              
             
            </ul>
            <div class="tab-content">
            <?php if ($totalRows_Recordset2>0){ ?>
              <?php do { ?>
                <div class="active tab-pane" id="activity">
                  <!-- Post -->
                  <div class="post">
                    <div class="user-block">
                      <img class="img-circle img-bordered-sm" src="Img_Perfil/<?php echo $row_actualiar['perfil']; ?>" alt="user image">
                      <span class="username">
                        <a href="#"> <?php echo ObtenerNombreUsuario($_SESSION['MM_Username']) ?> &nbsp; <?php echo ObtenerApellidoUsuario($_SESSION['MM_Username']) ?></a>
                        <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a>
                        </span>
                      <span class="description">Fecha de publicacion- <?php echo $row_Recordset2['fecha']; ?> </span>
                      </div>
                    <!-- /.user-block -->
                    <p>
                      <?php echo $row_Recordset2['contenido']; ?>
                      </p>
                    <ul class="list-inline">
                      <li>
                        </li>
                      <li class="pull-right">
                        <a href="comentarios.php?id=<?php echo $row_Recordset2['idp']; ?>" class="link-black text-sm"><i class="fa fa-comments-o margin-r-5"></i> Comentarios</a></li>
                      </ul>
                    
                    
                    </div>
                  <!-- Post -->
                  
                  <!-- /.post -->
                </div>
                <?php } while ($row_Recordset2 = mysql_fetch_assoc($Recordset2)); ?>
				<?php }?>
<!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                <!-- The timeline -->
                <ul class="timeline timeline-inverse">
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-red">
                          10 Feb. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-envelope bg-blue"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

                      <h3 class="timeline-header"><a href="#">Support Team</a> sent you an email</h3>

                      <div class="timeline-body">
                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                        weebly ning heekya handango imeem plugg dopplr jibjab, movity
                        jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                        quora plaxo ideeli hulu weebly balihoo...
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-primary btn-xs">Read more</a>
                        <a class="btn btn-danger btn-xs">Delete</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-user bg-aqua"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 5 mins ago</span>

                      <h3 class="timeline-header no-border"><a href="#">Sarah Young</a> accepted your friend request
                      </h3>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-comments bg-yellow"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 27 mins ago</span>

                      <h3 class="timeline-header"><a href="#">Jay White</a> commented on your post</h3>

                      <div class="timeline-body">
                        Take me to your leader!
                        Switzerland is small and neutral!
                        We are more like Germany, ambitious and misunderstood!
                      </div>
                      <div class="timeline-footer">
                        <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <!-- timeline time label -->
                  <li class="time-label">
                        <span class="bg-green">
                          3 Jan. 2014
                        </span>
                  </li>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <li>
                    <i class="fa fa-camera bg-purple"></i>

                    <div class="timeline-item">
                      <span class="time"><i class="fa fa-clock-o"></i> 2 days ago</span>

                      <h3 class="timeline-header"><a href="#">Mina Lee</a> uploaded new photos</h3>

                      <div class="timeline-body">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                        <img src="http://placehold.it/150x100" alt="..." class="margin">
                      </div>
                    </div>
                  </li>
                  <!-- END timeline item -->
                  <li>
                    <i class="fa fa-clock-o bg-gray"></i>
                  </li>
                </ul>
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="settings">
                <form id="perfil_form" method="post" name="form1" action="<?php echo $editFormAction; ?>" class="form-horizontal">
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label"
                    
                    >CorreoElectronico</label>

                    <div class="col-sm-10">
                      <input class="form-control" type="email" name="correo" value="<?php echo htmlentities($row_actualiar['correo'], ENT_COMPAT, 'utf-8'); ?>" size="32"
                      required
                    data-required-error="El Correo Electronico es requerido"
                    data-error="Verifique el Correo Electronico"
                    minlength="7"
                      >
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Nombre</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" name="nombre" 
                      required
                      data-required-error="El nombre es requerido"
                      data-error="Por favor coloque su nombre"
                      maxlength="45"
                      minlength="2"
                      value="<?php echo htmlentities($row_actualiar['nombre'], ENT_COMPAT, 'utf-8'); ?>" size="32">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Apellido</label>

                    <div class="col-sm-10">
                      <input class="form-control" type="text" 
                      required
                      name="apellido"
                      data-required-error="El nombre es requerido"
                      data-error="Por favor coloque su apellido"
                      maxlength="45"
                      minlength="2"
                       value="<?php echo htmlentities($row_actualiar['apellido'], ENT_COMPAT, 'utf-8'); ?>" size="32">
                       <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label  for="inputExperience" class="col-sm-2 control-label">Fecha de Nacimiento</label>

                    <div class="col-sm-10">
                      
                      <input class="form-control" type="text"
                      required name="fecha_nacimiento" value="<?php echo htmlentities($row_actualiar['fecha_nacimiento'], ENT_COMPAT, 'utf-8'); ?>" size="32">
                      <div class="help-block with-errors"></div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Contraseña</label>

                    <div class="col-sm-10">
                     <input class="form-control" type="password"
                     required  name="pass"
                     maxlength="250"
                    minlength="8"
                    data-minlength-error="debe contener al menos 8 caracteres"
                      value="<?php echo htmlentities($row_actualiar['pass'], ENT_COMPAT, 'utf-8'); ?>" size="32">
                    </div>
                    <div class="help-block with-errors"></div>
                  </div>
                  <div class="form-group">
                    <label for="inputSkills" class="col-sm-2 control-label">Educacion</label>

                    <div class="col-sm-10">
                     <input class="form-control" type="text" name="educacion" value="<?php echo htmlentities($row_actualiar['educacion'], ENT_COMPAT, 'utf-8'); ?>" size="32">
                    </div>
                  </div>
                  <div class="form-group">
                    

                    <div class="col-sm-10">
                     <input class="form-control" type="hidden" name="destresas" value="<?php echo htmlentities($row_actualiar['destresas'], ENT_COMPAT, 'utf-8'); ?>" size="32">
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                    <input class="form-control" value="<?php echo htmlentities($row_actualiar['perfil'], ENT_COMPAT, 'utf-8'); ?>" placeholder="imagen" type="hidden" name="img" value="" size="32">
                    <input class="form-control"  type="button" name="button" id="button" value="Imagen de Perfil" onclick="javascript:subirimagen();">
                     
                    </div>
                  </div>
                  
                 
<div id="resultadoBusqueda"></div>
                  
                  
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn  btn-danger">Actualizar Perfil</button>
                    </div>
                  </div>
                <input type="hidden" name="MM_update" value="form1">
 				<input type="hidden" name="id" value="<?php echo $row_actualiar['id']; ?>">
                </form>
                Comparte tus gustos con el mundo <input value="#" type="text" id="bus" name="bus" onkeyup="loadXMLDoc()" required />

<div id="myDiv"></div>
                
               
                
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <script>
function subirimagen()
{
	self.name = 'opener';
	remote = open('gestionimagen.php', 'remote', 'width=400,height=150,location=no,scrollbars=yes,menubars=no,toolbars=no,resizable=yes,fullscreen=no, status=yes');
 	remote.focus();
	}

</script>

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
    $('#perfil_form').validator();
  });
</script>

</body>
<!-- InstanceEnd --></html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($actualiar);

mysql_free_result($Recordset2);

mysql_free_result($elfinal);

mysql_free_result($tag);
?>



  
</body> 
</html>