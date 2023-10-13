<?php
ob_start();
session_start();
//si la ariable de sesion no existe
if (!isset($_SESSION["idpersonal"])) {
  header("Location: ../index.php");
} else {
  require 'modulos/header.php';
  //Usuario revisa el contenido
  if ($_SESSION['personal'] == 1) {
?>

    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content-header">
        <br>
        <ol class="breadcrumb">

          <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

          <li class="active">Administrar Usuarios</li>

        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">
          <div class="panel-heading">
            <div class="box-header with-border">
              <h1 class="box-title">Usuarios</h1>
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
            <br><br>
            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" width="100%">
              <thead>
                <th>Empleado</th>
                <th>Login</th>
                <th>Estado</th>
                <th>Acciones</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>Empleado</th>
                <th>Login</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tfoot>
            </table>
          </div>
        </div>
      </section>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">

      <div class="modal-dialog">

        <div class="modal-content">
          <!-- form -->
          <form class="form-horizontal" role="form" name="formulario" id="formulario" method="POST">

            <div class="modal-header" style="background:#3c8dbc; color:white">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">
                Usuarios</h4>
            </div>

            <div class="modal-body">

              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Personal:</label>
                <div class="col-sm-6">
                  <input type="hidden" name="idusuario" id="idusuario">
                  <select id="idpersonal" name="idpersonal" class="form-control selectpicker" data-live-search="true" title="Seleccione Trabajador" required></select>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Login: </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="login" id="login" maxlength="20" placeholder="Login" required>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Clave:</label>
                <div class="col-sm-6">
                  <input type="password" class="form-control" name="clave" id="clave" maxlength="64" placeholder="Clave" required>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Permisos:</label>
                <div class="col-sm-6">
                  <ul style="list-style: none;" id="permisos">

                  </ul>
                </div>
              </div>

            </div>

            <div class="modal-footer">
              <button type="button" onclick="cancelarform()" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
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
  <script type="text/javascript" src="js/usuario.js"></script>
  <script type="text/javascript" src="js/stocksbajos.js"></script>

<?php
}
ob_end_flush();
?>