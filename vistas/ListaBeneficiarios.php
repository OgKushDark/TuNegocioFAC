<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: ../index.php");
} else {
  require 'modulos/header.php';

  if ($_SESSION['configuracion'] == 1) {
?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content-header">
        <br>
        <ol class="breadcrumb">

          <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

          <li class="active">Administrar Beneficiarios:</li>

        </ol>
      </section>
      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">
              <div class="panel-heading">
                <div class="box-header with-border">
                  <h1 class="box-title">Lista de Beneficiarios</h1>
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
               <div class="panel-body table-responsive" id="listadoregistros">
                <!-- Agrega el id "btnReporte" al botón -->
                <a href="../reportes/rptbeneficiarios.php" target="_blank" id="btnReporte" class="btn btn-danger">
                    <i class="fa fa-file"></i> Reporte
                </a>
    
                </div>

                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                  <label>Zona</label>
                    <select id="idzona" name="idzona" class="form-control selectpicker" data-live-search="true" title="Seleccione zona" required></select>
                </div>

                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                  <label>Comite</label>
                    <select id="cbxComite" name="cbxComite" class="form-control selectpicker" data-live-search="true" title="Seleccione comite" required></select>
                </div>

                <div class="col-lg-4 left">
                 
                  <div class="form-group has-success">

                    <div class="input-group">
                      
                      <span class="input-group-btn">
                        <button class="btn btn-success" onclick="listar()" style="margin-top: 23px;"><i class="fa fa-search"></i> Mostrar</button>
                      </span>
                    </div>
                  </div>
                </div>



                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                  <thead>
                    <th>NOMBRE</th>
                    <th>DNI</th>
                    <th>EDAD</th>
                    <th>TIPO</th>
                    <th>RESPONSABLE</th>
                    <th>DNI RESP..</th>
                    <th>ESTADO</th>
                    <th>ACCIÓN</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>NOMBRE</th>
                    <th>DNI</th>
                    <th>EDAD</th>
                    <th>TIPO</th>
                    <th>RESPONSABLE</th>
                    <th>DNI RESP..</th>
                    <th>ESTADO</th>
                    <th>ACCIÓN</th>
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
                <label for="beneficiario" class="col-sm-2 control-label">Beneficiario:</label>
                <div class="col-sm-10">
                  <input type="hidden" name="idbeneficiario" id="idbeneficiario">
                  <input type="text" class="form-control" name="beneficiario" id="beneficiario" maxlength="500" placeholder="beneficiario" required>
                </div>
              </div>

              <div class="form-group">
                <label for="DNI" class="col-sm-2 control-label">DNI:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="DNI" id="DNI" maxlength="8" placeholder="DNI" required>
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
                <label for="responsable" class="col-sm-2 control-label">Reponsable:</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="responsable" id="responsable" maxlength="500" placeholder="responsable" required>
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
  <script type="text/javascript" src="js/ListaBeneficiarios.js"></script>
<?php
}
ob_end_flush();
?>

<script>
    $(document).ready(function() {
        // Evento que se ejecuta cuando cambia la selección en el select
        $("#cbxComite").change(function() {
            // Obtén el valor seleccionado
            var idComite = $(this).val();

            // Actualiza el enlace del botón de Reporte
            actualizarEnlaceReporte(idComite);
        });
    });

    // Función para actualizar el enlace del botón de Reporte
    function actualizarEnlaceReporte(idComite) {
        // Construye el enlace con el idComite seleccionado
        var enlaceReporte = "../reportes/rptbeneficiarios.php?idcomite=" + idComite;

        // Actualiza el atributo href del botón de Reporte
        $("#btnReporte").attr("href", enlaceReporte);
    }
</script>
