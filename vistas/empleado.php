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

          <li class="active">Administrar Personal</li>

        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">
          <div class="panel-heading">
            <div class="box-header with-border">
              <h1 class="box-title">Supervisor</h1>
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
            <a href="../reportes/rptusuarios.php" target="_blank"><button class="btn btn-danger"><i class="fa fa-file"></i> Reporte</button></a>
            <br><br>
            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" width="100%">
              <thead>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Número</th>
                <th>Foto</th>
                <th>Estado</th>
                <th>Acciones</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Número</th>
                <th>Foto</th>
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
                Supervisor</h4>
            </div>

            <div class="modal-body">

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Nombre:</label>
                <div class="col-sm-10">
                  <input type="hidden" name="idpersonal" id="idpersonal">
                  <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre y Apellidos" required oninput="this.setCustomValidity(''); if (!/^[A-Za-záéíóúÁÉÍÓÚüÜ\s]+$/.test(this.value)) this.setCustomValidity('Solo se permiten letras y espacios');">
                </div>

              </div>

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">Tipo Documento: </label>
                <div class="col-sm-4">
                  <select class="form-control select-picker" name="tipo_documento" id="tipo_documento" required>
                    <option value="DNI">DNI</option>
                    <option value="RUC">RUC</option>
                    <option value="CEDULA">CEDULA</option>
                  </select>
                </div>


                <label for="name" class="col-sm-2 control-label">Número:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="num_documento" id="num_documento" maxlength="20" placeholder="Documento" required oninput="this.setCustomValidity(''); if (!/^\d+$/.test(this.value)) this.setCustomValidity('Solo se permiten números');">
                </div>
              </div>

                        
              <!-- Zona -->
              <div class="form-group">

                <label for="idzona1" class="col-sm-2 control-label">Zona 01: </label>
                  <div class="col-sm-4">
                    <select id="idzona1" name="idzona1" class="form-control selectpicker" data-live-search="true" title="Seleccione zona 01" ></select>
                  </div>

                <label for="idzona2" class="col-sm-2 control-label">Zona 02: </label>
                  <div class="col-sm-4">
                    <select id="idzona2" name="idzona2" class="form-control selectpicker" data-live-search="true" title="Seleccione zona 02" ></select>
                  </div>
              </div>

              <div class="form-group">

                <label for="idzona3" class="col-sm-2 control-label">Zona 03: </label>
                  <div class="col-sm-4">
                    <select id="idzona3" name="idzona3" class="form-control selectpicker" data-live-search="true" title="Seleccione zona 03" ></select>
                  </div>
                
              </div>
              <!-- Zona -->
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Imagen:</label>
                <div class="col-sm-6">
                  <input type="file" class="form-control" name="imagen" id="imagen">
                  <input type="hidden" name="imagenactual" id="imagenactual">
                  <img src="" class="img-thumbnail" id="imagenmuestra" width="100px">
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
  <script type="text/javascript" src="js/empleado.js"></script>
<?php
}
ob_end_flush();
?>
<script>
$(document).ready(function () {
  var selectedValues = {}; // Cambiado a objeto para un mejor manejo

  // Agrega un evento change a todos los selects con clase selectpicker
  $('.selectpicker').change(function () {
    // Obtiene el valor seleccionado
    var selectedValue = $(this).val();

    // Habilita todas las opciones en todos los selects
    $('.selectpicker option').prop('disabled', false);

    // Almacena la selección actual en el objeto
    selectedValues[$(this).attr('id')] = selectedValue;

    // Itera sobre los selects y deshabilita las opciones seleccionadas previamente
    $.each(selectedValues, function (key, value) {
      $('.selectpicker').not('#' + key).find('option[value="' + value + '"]').prop('disabled', true);
    });

    // Actualiza la apariencia del selectpicker
    $('.selectpicker').selectpicker('refresh');
  });
});
</script>


