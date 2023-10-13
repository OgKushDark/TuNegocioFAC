<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: ../index.php");
} else {
  require 'modulos/header.php';

  if ($_SESSION['consultac'] == 1) {
?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content-header">
        <br>
        <ol class="breadcrumb">

          <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

          <li class="active">Administrar Consultas de Stock</li>

        </ol>
      </section>
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">
              <div class="panel-heading">
                <div class="box-header with-border">
                  <h1 class="box-title">Consulta de Stock de Productos</h1>
                  <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse">
                      <i class="fa fa-minus"></i>
                    </button>
                    <button class="btn btn-box-tool" data-widget="remove">
                      <i class="fa fa-times"></i>
                    </button>
                  </div>

                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body table-responsive" id="listadoregistros">

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Fecha Inicio</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                  </div>
                </div>

                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <label>Fecha Fin</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
                  </div>
                </div>
                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" width="100%">
                  <thead>
                    <th>Fecha</th>
                    <th>Personal</th>
                    <th>Proveedor</th>
                    <th>Comprobante</th>
                    <th>Número</th>
                    <th>Total Compra</th>
                    <th>Impuesto</th>
                    <th>Estado</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>Fecha</th>
                    <th>Personal</th>
                    <th>Proveedor</th>
                    <th>Comprobante</th>
                    <th>Número</th>
                    <th>Total Compra</th>
                    <th>Impuesto</th>
                    <th>Estado</th>
                  </tfoot>
                </table>
              </div>

              <!--Fin centro -->
            </div><!-- /.box -->
          </div><!-- /.col -->
        </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
  <?php
  } else {
    require 'noacceso.php';
  }

  require 'modulos/footer.php';
  ?>
  <script type="text/javascript" src="js/comprasfecha.js"></script>
<?php
}
ob_end_flush();
?>