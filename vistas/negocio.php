<?php
//activamos almacenamiento en el buffer
ob_start();
session_start();
if (!isset($_SESSION['nombre'])) {
  header("Location: ../index.php");
} else {

  require 'modulos/header.php';
  if ($_SESSION['configuracion'] == 1) {
?>

    <div class="content-wrapper">

      <section class="content-header">

        <br>
        <ol class="breadcrumb">

          <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

          <li class="active">Administrar Datos</li>

        </ol>
      </section>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        <div class="row">

          <div class="col-md-12">

            <div class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">

              <div class="panel-heading">
                <div class="box-header with-border">
                  <h1 class="box-title">Datos de la Empresa</h1>
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

              <!--centro-->
              <div class="panel-body table-responsive" id="listadoregistros">

                <button class="btn btn-primary" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus"></i> Agregar</button>

                <br><br>

                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">

                  <thead>
                    <th>logo</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>E-mail</th>
                    <th>Pais/Ciudad</th>
                    <th>Impuesto</th>
                    <th>Moneda</th>
                    <th>Opcion</th>
                  </thead>
                  <tbody>
                  </tbody>
                  <tfoot>
                    <th>logo</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>E-mail</th>
                    <th>Pais/Ciudad</th>
                    <th>Impuesto</th>
                    <th>Moneda</th>
                    <th>Opcion</th>
                  </tfoot>
                </table>
              </div>
              <div class="panel-body" id="formularioregistros">
                <form action="" name="formulario" id="formulario" method="POST">

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">

                    <label for="name" class="col-sm-2 control-label">Imagen:</label>
                    <input type="file" class="form-control" name="imagen" id="imagen">
                    <input type="hidden" name="imagenactual" id="imagenactual">
                    <img src="" class="img-thumbnail" id="imagenmuestra" width="100px">

                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Nombre(*):</label>
                    <input class="form-control" type="hidden" name="id_negocio" id="id_negocio">
                    <input class="form-control" type="text" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Nombre del documento:(*)</label>
                    <input class="form-control" type="text" name="ndocumento" placeholder="RUC" id="ndocumento" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Documento:(*)</label>
                    <input class="form-control" type="text" name="documento" id="documento" required>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-xs-12">
                    <label for="">Dirección(*):</label>
                    <input class="form-control" type="text" name="direccion" id="direccion" maxlength="256" placeholder="Dirección" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Pais:</label>
                    <input class="form-control" type="text" name="pais" id="pais">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Telefono(*):</label>
                    <input class="form-control" type="text" name="telefono" id="telefono" required>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">E-mail:</label>
                    <input class="form-control" type="email" name="email" id="email">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Ciudad:</label>
                    <input class="form-control" type="text" name="ciudad" id="ciudad">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-xs-12">
                    <label for="">Datos Financieros</label>
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-xs-12">
                    <label for="">Nombre Imp:</label>
                    <input class="form-control" type="text" name="nombre_impuesto" id="nombre_impuesto" placeholder="IVA - IGV">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-xs-12">
                    <label for="">Monto (%):</label>
                    <input class="form-control" type="text" name="monto_impuesto" id="monto_impuesto">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-xs-12">
                    <label for="">Moneda:</label>
                    <input class="form-control" type="text" name="moneda" id="moneda" placeholder="SOLES - Dolares">
                  </div>
                  <div class="form-group col-lg-3 col-md-3 col-xs-12">
                    <label for="">Simbolo:</label>
                    <input class="form-control" type="text" name="simbolo" id="simbolo" placeholder="s/ - $">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-xs-12">
                    <label for="">Usuario y Password SOL - SUNAT</label>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Usuario Sol:</label>
                    <input class="form-control" type="text" name="usuario_sol" id="usuario_sol" placeholder="Usuario Secundario o Sol">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Contraseña Sol:</label>
                    <input class="form-control" type="text" name="clave_sol" id="clave_sol" placeholder="Contraseña">
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-xs-12">
                    <label for="">Certificado Electrónico y Password</label>
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">

                    <label for="name">Certificado Digital:</label>
                    <input type="file" class="form-control" name="ruta_certificado" id="ruta_certificado">

                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="">Contraseña de tu Certificado</label>
                    <input class="form-control" type="text" name="clave_certificado" id="clave_certificado" placeholder="Contraseña">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-xs-12">
                    <label for="name" class="control-label">Estado Certificado: </label>
                    <select class="form-control select-picker" name="estado_certificado" id="estado_certificado" required>
                      <option value="BETA">BETA</option>
                      <option value="PRODUCCION">PRODUCCIÓN</option>
                    </select>
                  </div>
                  <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                    <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                  </div>
                </form>
              </div>

              <!--fin centro-->
            </div>
          </div>
        </div>
        <!-- /.box -->

      </section>
      <!-- /.content -->
    </div>

  <?php

  } else {

    require 'noacceso.php';
  }

  require 'modulos/footer.php'

  ?>
  <script src="../public/js/JsBarcode.all.min.js"></script>
  <script src="../public/js/jquery.PrintArea.js"></script>
  <script src="js/negocio.js"></script>
  <script type="text/javascript" src="js/stocksbajos.js"></script>

<?php
}

ob_end_flush();
?>