<?php

require_once "../modelos/Negocio.php";
$cnegocio = new Negocio();
$rsptan = $cnegocio->listar();
$regn = $rsptan->fetch_object();
if (empty($regn)) {
  $nombrenegocio = 'Configurar datos de su Empresa';
} else {
  $nombrenegocio = $regn->nombre;
};

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $nombrenegocio; ?> | Sistema Vaso de Leche</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="../public/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../public/css/font-awesome.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../public/css/_all-skins.min.css">
  <link rel="apple-touch-icon" href="../public/img/apple-touch-icon.png">

  <!-- DATATABLES -->
  <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
  <link href="../public/datatables/buttons.dataTables.min.css" rel="stylesheet" />
  <link href="../public/datatables/responsive.dataTables.min.css" rel="stylesheet" />

  <link rel="stylesheet" type="text/css" href="../public/css/bootstrap-select.min.css">

  <!-- sweetalert2 -->
  <link rel="stylesheet" href="../public/css/sweetalert.min.css" />

  <!-- Switchery -->
  <link rel="stylesheet" href="../public/css/switchery.css">

  <script src="../public/js/switchery.js"></script>

</head>

<body class="hold-transition skin-blue sidebar-mini">

  <div class="wrapper">

    <header class="main-header">

      <!-- Logo -->
      <a href="#" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b><img src="../files/img/fondo.jpg" width="50" height="60"></b></span>
        
        <img src="../files/img/logos.png" alt="Descripción de la imagen" width="200" height="50">
        <!--<b><?php echo "aaa"; ?></b>
         logo for regular state and mobile devices -->
        <!-- <img src="../files/AgroNegocios.png"> -->
      </a>

      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <span class="sr-only">Navegación</span>
        </a>

        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav ml-auto">

           

           

           

            <!-- User Account: style can be found in dropdown.less -->
            <li class="dropdown user user-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="../files/personal/<?php echo $_SESSION['imagen']; ?>" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $_SESSION['nombre']; ?></span>
                <b class="caret"></b>
              </a>
              <ul class="dropdown-menu">
                <li class="user-header">

                  <p style="margin-top: 50px;">
                    Sistema de Vaso de Leche
                    <small>Version 2.0</small>
                  </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">

                  <div class="pull-right">
                    <a href="../controladores/usuario.php?op=salir" class="btn btn-default btn-flat"><i class="fa fa-lock"></i> Cerrar sesión</a>
                  </div>
                </li>
              </ul>
            </li>
            <!-- Control Sidebar Toggle Button -->

          </ul>
        </div>

      </nav>


    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
      <!-- sidebar: style can be found in sidebar.less -->
      <section class="sidebar">
        <!-- Sidebar user panel -->
        <br>
        <div class="user-panel">
          <div class="pull-left image">
            <img src="../files/personal/<?php echo $_SESSION['imagen']; ?>" class="img-circle" alt="User Image">
          </div>
          <div class="pull-left info">
            <p><?php echo $_SESSION['nombre']; ?></p>
            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
          </div>
        </div>
        <br>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          <li class="header text-center">MENÚ DE NAVEGACIÓN</li>

          <?php
          if ($_SESSION['inicio'] == 1) {
            echo '<li id="navInicio">
              <a href="inicio.php">
                <i class="fa fa-home"></i> <span>Inicio</span>
              </a>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['almacen'] == 1) {
           
          }
          ?>

          <?php
          if ($_SESSION['ventas'] == 1) {
            
          }
          ?>

          <?php
          if ($_SESSION['ventas'] == 1) {
            
          }
          ?>

          <?php
          if ($_SESSION['ventas'] == 1) {
           
          }
          ?>

          <?php
          if ($_SESSION['personal'] == 1) {

            echo '<li class="treeview" id="navPersonal">
              <a href="#">
                <i class="fa fa-user"></i> <span>Personal</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="navSupervisorLi"><a href="empleado.php"><i class="fa fa-plus-circle"></i>Supervisor</a></li>
              </ul>

              <ul class="treeview-menu">
                <li id="navUsuarioLi"><a href="usuario.php"><i class="fa fa-plus-circle"></i>Usuario</a></li>
              </ul>

            </li>';
          }
          ?>

          <!-- NUEVA OPCION PARA SUPERVISION -->
          <?php
          if ($_SESSION['Supervisor'] == 1) {
            echo '<li class="treeview" id="navSupervision">
              <a href="#">
                <i class="fa fa-user"></i> <span>Ficha de Supervisión</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="navSupervisionLi"><a href="ficha_supervision.php"><i class="fa fa-plus-circle"></i> Ficha de Supervisión</a></li>
              </ul>

             

            </li>';
          }
          ?>
          <!-- fin NUEEVA OPCION PARA SUPERVISION -->



          <?php
          if ($_SESSION['configuracion'] == 1) {
            echo '<li class="treeview" id="navConfiguracion">
              <a href="#">
                <i class="fa fa-cog"></i> <span>Mantenimiento</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">

                <li id="navConfiguracionLi"><a href="negocio.php"><i class="fa fa-circle-o"></i> Datos Generales</a></li>
              </ul>

              <ul class="treeview-menu">
                <li id="navZonaLi"><a href="zona.php"><i class="fa fa-plus-circle"></i> Zona</a></li>
              </ul>

              <ul class="treeview-menu">
                <li id="navOpcionesLi"><a href="opciones.php"><i class="fa fa-plus-circle"></i> Opciones</a></li>
              </ul>

              <ul class="treeview-menu">
                <li id="navComiteLi"><a href="comite.php"><i class="fa fa-plus-circle"></i> Comite</a></li>
              </ul>

              <ul class="treeview-menu">
                <li id="navBeneLi"><a href="ListaBeneficiarios.php"><i class="fa fa-plus-circle"></i> Beneficiario</a></li>
              </ul>


                
              
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['consultac'] == 1) {
            
          }
          ?>

          <?php
          if ($_SESSION['consultav'] == 1) {
            echo '<li class="treeview" id="navConsultaV">
              <a href="#">
                <i class="fa fa-pie-chart"></i> <span>Consultas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              
              <ul class="treeview-menu">
                <li id="navConsultaVentasVLi"><a href="ListaBeneficiarios.php"><i class="fa fa-plus-circle"></i>Lista Beneficiario</a></li>                
              </ul>
             
            </li>';
          }
          ?>

        

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>