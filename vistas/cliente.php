<?php
ob_start();
session_start();
//si la ariable de sesion no existe
if (!isset($_SESSION["idpersonal"])) {
  header("Location: ../index.php");
} else {
  require 'modulos/header.php';
  //Usuario revisa el contenido
  if ($_SESSION['ventas'] == 1) {
?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content-header">
        <br>
        <ol class="breadcrumb">

          <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

          <li class="active">Administrar Clientes</li>

        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div dixv class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">
          <div class="panel-heading">
            <div class="box-header with-border">
              <h1 class="box-title">Clientes</h1>
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

          <div class="panel-body table-responsive" class="box-body" id="listadoregistros">
            <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"> Nuevo</i>
            </button>
            <a href="../reportes/rptclientes.php" target="_blank"><button class="btn btn-danger"><i class="fa fa-file"></i> Reporte</button></a>
            <br><br>
            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" width="100%">
              <thead>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Número</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Fecha Nacimiento</th>
                <th>Acciones</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Número</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Fecha Nacimiento</th>
                <th>Acciones</th>
              </tfoot>
            </table>
          </div>
        </div>
      </section>
    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">
          <!-- form -->
          <form class="form-horizontal" role="form" name="formulario" id="formulario" method="POST">

            <div class="modal-header" style="background:#3c8dbc; color:white">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">
                Clientes</h4>
            </div>

            <div class="modal-body panel-body" style="padding: 20px">

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Nombre:</label>
                <div class="col-sm-4">
                  <input type="hidden" name="idpersona" id="idpersona">
                  <input type="hidden" name="tipo_persona" id="tipo_persona" value="Cliente">
                  <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre del Cliente" required>
                </div>

                <label for="name" class="col-sm-2 control-label">Tipo Documento: </label>
                <div class="col-sm-4">
                  <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>
                    <option value="DNI">DNI</option>
                    <option value="RUC">RUC</option>
                    <option value="CEDULA">CEDULA</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Número Documento:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="Documento">
                </div>

                <label for="name" class="col-sm-2 control-label">Dirección: </label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="direccion" id="direccion" maxlength="70" placeholder="Dirección">
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Teléfono:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="telefono" id="telefono" maxlength="20" placeholder="Teléfono">
                </div>

                <label for="name" class="col-sm-2 control-label">Email:</label>
                <div class="col-sm-4">
                  <input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Email">
                </div>
              </div>

              <div class="form-group col-12">

                <label for="name" class="col-sm-2 control-label">Fecha de Nacimiento:</label>
                <div class="col-sm-4">
                  <input style="border-color: #99C0E7; text-align:center" class="form-control pull-right" type="date" name="fecha_hora" id="fecha_hora">
                </div>

              </div>

            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" onclick="cancelarform()" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
            </div>

          </form>
        </div>
      </div>
    </div>
    <!-- Fin modal -->
  <?php
  } else {
    require 'noacceso.php';
  }
  require 'modulos/footer.php';
  ?>
  <script type="text/javascript" src="js/cliente.js"></script>
  <script type="text/javascript" src="js/stocksbajos.js"></script>
<?php
}
ob_end_flush();
?>