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
  <title><?php echo $nombrenegocio; ?> | Administrable</title>
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
        <span class="logo-mini"><b>AD</b></span>
        <b><?php echo $nombrenegocio; ?></b>
        <!-- logo for regular state and mobile devices -->
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

            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-calendar"></i>
                <span class="label label-danger" id="documentosp"></span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">Documentos Pendientes <span class="label label-danger" id="documentosp2"></span></li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu" id="DocumentosPendientes">

                  </ul>
                </li>
              </ul>
            </li>

            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-flag-o"></i>
                <span class="label label-success" id="creditop"></span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">Créditos Pendientes <span class="label label-success" id="creditosp2"></span></li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu" id="CreditosPendientes">

                  </ul>
                </li>
                <li class="footer">
                  <a href="cuentasxcobrar.php">Ver Todos</a>
                </li>
              </ul>
            </li>

            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning" id="totalstockbajo"></span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">Productos bajos en Existencia <span class="label label-warning" id="totalstockbajo2"></span></li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu" id="StocksBajos">

                  </ul>
                </li>
                <li class="footer"><a href="producto.php">Ver Todos</a></li>
              </ul>
            </li>

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
                    Sistema de Control y Facturacón
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
            echo '<li class="treeview" id="navAlmacen">
              <a href="#">
                <i class="fa fa-laptop"></i>
                <span>Almacén</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" id="navAlmacen">
                <li id="navProducto"><a href="producto.php" id="navProducto"><i class="fa fa-plus-circle"></i> Productos</a></li>
                <li id="navCategoria"><a href="categoria.php"><i class="fa fa-plus-circle"></i> Categorías</a></li>
                <li id="navUnidadMedida"><a href="unidadmedida.php"><i class="fa fa-plus-circle"></i> Unidad de Medida</a></li>
                <li id="navmarca"><a href="marca.php"><i class="fa fa-plus-circle"></i> Marca </a></li>
              </ul>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['compras'] == 1) {
            echo '<li class="treeview" id="navCompras">
              <a href="#">
                <i class="fa fa-th"></i>
                <span>Compras</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="navCompra"><a href="compra.php"><i class="fa fa-plus-circle"></i> Compras</a></li>
                <li id="navProveedor"><a href="proveedor.php"><i class="fa fa-plus-circle"></i> Proveedores</a></li>
              </ul>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['ventas'] == 1) {
            echo '<li class="treeview" id="navCajaChica">
              <a href="cajachica.php">
                <i class="fa fa-usd"></i>
                <span>Caja Chica</span>
              </a>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['ventas'] == 1) {
            echo '<li class="treeview" id="navCuentasPorCobrar">
              <a href="cuentasxcobrar.php">
                <i class="fa fa-list-ul"></i>
                <span>Cuentas por Cobrar</span>
              </a>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['ventas'] == 1) {
            echo '<li class="treeview" id="navVentasV">
              <a href="#">
                <i class="fa fa-shopping-cart"></i>
                <span>Ventas</span>
                 <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="navCotizacionesLi"><a href="cotizaciones.php"><i class="fa fa-plus-circle"></i> Cotizaciones</a></li>
                <li id="navVentasLi"><a href="venta.php"><i class="fa fa-plus-circle"></i> Ventas</a></li>
                <li id="navNCreditosLi"><a href="notascredito.php"><i class="fa fa-plus-circle"></i> Notas de Crédito</a></li>
                <li id="navClientesLi"><a href="cliente.php"><i class="fa fa-plus-circle"></i> Clientes</a></li>
              </ul>
            </li>';
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
                <li id="navPersonalLi"><a href="empleado.php"><i class="fa fa-plus-circle"></i> Personal</a></li>
                <li id="navUsuarioLi"><a href="usuario.php"><i class="fa fa-plus-circle"></i> Usuarios</a></li>
                <li id="navPermisoLi"><a href="permiso.php"><i class="fa fa-plus-circle"></i> Permisos</a></li>
                
              </ul>
            </li>';
          }
          ?>

          <!-- NUEEVA OPCION PARA SUPERVISION -->
          <?php
          if ($_SESSION['inicio'] == 1) {
            echo '<li class="treeview" id="navSupervision">
              <a href="#">
                <i class="fa fa-user"></i> <span>Ficha de Supervisión</span>
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
                <i class="fa fa-cog"></i> <span>Configuracion</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">

                <li id="navConfiguracionLi"><a href="negocio.php"><i class="fa fa-circle-o"></i> Datos Generales</a></li>
                
              </ul>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['consultac'] == 1) {
            echo '<li class="treeview" id="navConsultaC">
              <a href="#">
                <i class="fa fa-pie-chart"></i> <span>Consulta Compras</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="navConsultaCLi"><a href="comprasfecha.php"><i class="fa fa-plus-circle"></i> Consulta Compras</a></li>                
              </ul>
            </li>';
          }
          ?>

          <?php
          if ($_SESSION['consultav'] == 1) {
            echo '<li class="treeview" id="navConsultaV">
              <a href="#">
                <i class="fa fa-pie-chart"></i> <span>Consulta Ventas</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                <li id="navConsultaVLi"><a href="ventasfechacliente.php"><i class="fa fa-plus-circle"></i> Consulta Ventas x Cliente</a></li>                
              </ul>
              <ul class="treeview-menu">
                <li id="navConsultaVentasVLi"><a href="ventasfechavendedor.php"><i class="fa fa-plus-circle"></i> Consulta Ventas x Vendedor</a></li>                
              </ul>
              <ul class="treeview-menu">
                <li id="navConsultaProductoVLi"><a href="ventasfechaproducto.php"><i class="fa fa-plus-circle"></i> Consulta Ventas x Producto</a></li>                
              </ul>
            </li>';
          }
          ?>

          <li>
            <a href="acerca.php">
              <i class="fa fa-info-circle treeview active" id="liAcerca"></i> <span>Acerca De...</span>
              <small class="label pull-right bg-yellow">SOL</small>
            </a>
          </li>

        </ul>
      </section>
      <!-- /.sidebar -->
    </aside>