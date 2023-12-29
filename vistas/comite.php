<?php
ob_start();
session_start();
//si la ariable de sesion no existe
if (!isset($_SESSION["idpersonal"])) {
  header("Location: ../index.php");
} else {
  require 'modulos/header.php';
  //Usuario revisa el contenido
  if ($_SESSION['configuracion'] == 1) {
?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <div class="content-wrapper">
      <section class="content-header">
        <br>
        <ol class="breadcrumb">

          <li><a href="inicio
        .php"><i class="fa fa-dashboard"></i> Inicio</a></li>

          <li class="active">Administrar Comite</li>

        </ol>
      </section>
      <section class="content">
        <div class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">
          <div class="panel-heading">
            <div class="box-header with-border">
              <h1 class="box-title">Comite</h1>
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
            <a href="../reportes/rptcomite.php" target="_blank"><button class="btn btn-danger"><i class="fa fa-file"></i> Reporte</button></a>
            <br><br>
            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" width="100%">
              <thead>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Responsable</th>
                <th>DNI</th>
                <th>Dir. Responsable</th>
                <th>Cocinero</th>
                <th>DNI Cocinero</th>
                <th>Zona</th>
                <th>Estado</th>
                <th>Acciones</th>
                <th>Beneficiario</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>Responsable</th>
                <th>DNI</th>
                <th>Dir. Responsable</th>
                <th>Cocinero</th>
                <th>DNI Cocinero</th>
                <th>Zona</th>
                <th>Estado</th>
                <th>Acciones</th>
                <th>Beneficario</th>
              </tfoot>
            </table>
          </div>
        </div>
      </section>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">

      <div class="modal-dialog" style="width: 480px">

        <div class="modal-content">
          <!-- form -->
          <form class="form-horizontal" role="form" name="formulario" id="formulario" method="POST">

            <div class="modal-header" style="background:#3c8dbc; color:white">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">
                Comite</h4>
            </div>

            <div class="modal-body">
                          
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Comite:</label>
                <div class="col-sm-10">
                  <input type="hidden" name="idcomite" id="idcomite">
                  <input type="text" class="form-control" name="nombre" id="nombre" maxlength="500" placeholder="comite" required>
                </div>
              </div>
              
            
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">AAHH:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="direccion" id="direccion" maxlength="500" placeholder="Dirección" required>
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Presidente:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="responsable" id="responsable" maxlength="500" placeholder="Responsable" required oninput="this.setCustomValidity(''); if (!/^[A-Za-záéíóúÁÉÍÓÚüÜ\s]+$/.test(this.value)) this.setCustomValidity('Solo se permiten letras y espacios');">
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">DNI:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="DNI" id="DNI" maxlength="8" placeholder="DNI" required oninput="this.setCustomValidity(''); if (!/^\d+$/.test(this.value)) this.setCustomValidity('Solo se permiten números');">
                </div>
              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Dirección:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="dirresponsable" id="dirresponsable" maxlength="500" placeholder="Dirección" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Cocinero:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="cocinero" id="cocinero" maxlength="500" placeholder="cocinero" required oninput="this.setCustomValidity(''); if (!/^[A-Za-záéíóúÁÉÍÓÚüÜ\s]+$/.test(this.value)) this.setCustomValidity('Solo se permiten letras y espacios');">
                </div>
              </div>

              <div class="form-group">
                <label for="DNIc" class="col-sm-2 control-label">DNI:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="DNIc" id="DNIc" maxlength="8" placeholder="DNI Cocinero" required oninput="this.setCustomValidity(''); if (!/^\d+$/.test(this.value)) this.setCustomValidity('Solo se permiten números');">
                </div>
              </div>

              <div class="form-group">
                <label for="idzona" class="col-sm-2 control-label">Zona: </label>
                  <div class="col-sm-10">
                    <select id="idzona" name="idzona" class="form-control selectpicker" data-live-search="true" title="Seleccione zona" required></select>
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


    <!-- Modal Beneficiario -->
    <div class="modal fade" id="myModalB" tabindex="-1" role="dialog">

      <div class="modal-dialog" style="width: 480px">

        <div class="modal-content">
          <!-- form -->
          <form class="form-horizontal" role="form" name="formularioB" id="formularioB" method="POST">

            <div class="modal-header" style="background:#3c8dbc; color:white">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">
                Beneficiario</h4>
            </div>

            <div class="modal-body">
                          
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Comite:</label>
                <div class="col-sm-10">
                  <input type="hidden" name="idcomites" id="idcomites">
                  <input type="text" class="form-control" name="nombres" id="nombres" maxlength="500" placeholder="comite" required>
                </div>
              </div>
              
            
              <div class="form-group">
                <label for="beneficiario" class="col-sm-2 control-label">Beneficiario:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="beneficiario" id="beneficiario" maxlength="500" placeholder="beneficiario" required>
                </div>
              </div>

              <div class="form-group">
                <label for="DNIb" class="col-sm-2 control-label">DNI:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="DNIb" id="DNIb" maxlength="8" placeholder="DNI" required>
                </div>
              </div>

              <div class="form-group">
                <label for="edad" class="col-sm-2 control-label">Edad:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="edad" id="edad" maxlength="8" placeholder="Edad" required>
                </div>
              </div>

              <div class="form-group">
                <label for="tipo_opcion" class="col-sm-2 control-label">Tipo: </label>
                  <div class="col-sm-10">
                    <select class="form-control select-picker" name="tipo_opcion" id="tipo_opcion" required>
                      <option value="Primera Prioridad">Primera Prioridad</option>
                      <option value="Segunda Prioridad">Segunda Prioridad</option>
                      <option value="Tercera Prioridad">Tercera Prioridad</option>
                    </select>
                  </div>
              </div>

              <div class="form-group">
                <label for="responsableB" class="col-sm-2 control-label">Reponsable:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="responsableB" id="responsableB" maxlength="500" placeholder="responsable" required>
                </div>
              </div>
              <div class="form-group">
                <label for="DNIr" class="col-sm-2 control-label">DNI:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="DNIr" id="DNIr" maxlength="8" placeholder="DNI Responsable" required>
                </div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" onclick="cancelarform()" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              <button class="btn btn-primary" type="submit" id="btnGuardarB"><i class="fa fa-save"></i> Guardar</button>
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
  <script type="text/javascript" src="js/comite.js"></script>
<?php
}
ob_end_flush();
?>