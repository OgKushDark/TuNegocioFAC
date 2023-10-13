<?php
require 'modulos/header.php';

require_once "../modelos/Consultas.php";



?>
<!--Contenido-->
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <section class="content-header">
    <br>
    <ol class="breadcrumb">

      <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

      <li class="active">Panel de control</li>

    </ol>
  </section>

  <section class="content">

    <div class="row">
      <div class="col-md-12 col-lg-12 col-xs-12">
        <!-- AREA CHART -->
        <div class="box box-primary">
          <div class="box-header with-border">
            <h3 class="box-title" style="font-size:17px;">Derechos de Autor:</h3>
            <div class="box-tools pull-right">
              <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
              <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
          </div>
          <div class="box-body">
            <h4>Proyecto: </h4>
            <p>Sistema de Ventas, Compras y Almacén</p>
            <h4>Desarrollado por: </h4>
            <p>------</p>
            <p>------</p>
          </div><!-- /.box-body -->
        </div><!-- /.box -->


      </div><!-- /.col (RIGHT) -->
    </div><!-- /.row -->

  </section>




</div><!-- /.row -->
<!--Fin-Contenido-->
<?php
require 'modulos/footer.php';
?>

<script type="text/javascript" src="js/stocksbajos.js"></script>