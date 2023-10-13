<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
  header("Location: ../index.php");
} else {
  require 'modulos/header.php';

  if ($_SESSION['compras'] == 1) {
?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <section class="content-header">
        <br>
        <ol class="breadcrumb">

          <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

          <li class="active">Administrar compras</li>

        </ol>
      </section>
      <section class="content">
        <div class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">
          <div class="panel-heading">
            <div class="box-header with-border">
              <h1 class="box-title">Compras</h1>
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
            <button class="btn btn-primary" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus"> Nuevo</i>
            </button>
            <a href="../reportes/rptcompras.php" target="_blank"><button class="btn btn-danger"><i class="fa fa-file"></i> Reporte</button></a>
            <br><br>
            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" width="100%">
              <thead>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Personal</th>
                <th>Documento</th>
                <th>Número</th>
                <th>Total Compra</th>
                <th>Estado</th>
                <th>Acciones</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Personal</th>
                <th>Documento</th>
                <th>Número</th>
                <th>Total Compra</th>
                <th>Estado</th>
                <th>Acciones</th>
              </tfoot>
            </table>
          </div>

          <div class="panel-body" id="formularioregistros">
            <form name="formulario" id="formulario" method="POST">

              <div class="form-group col-lg-4 col-md-8 col-sm-8 col-xs-12">
                <label>Personal:</label>
                <div class="input-group">

                  <span class="input-group-addon"><i class="fa fa-user"></i></span>

                  <input style="border-color: #FFC7BB; text-align:center" type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
                </div>
              </div>

              <div class="form-group col-lg-5 col-md-8 col-sm-8 col-xs-12">
                <label>Proveedor:</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-users"></i></span>
                  <input type="hidden" name="idcompra" id="idcompra">

                  <select id="idproveedor" name="idproveedor" class="form-control selectpicker" data-live-search="true" title="Seleccione Proveedor" required>

                  </select>

                </div>
              </div>

              <div class="form-group col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <label>Fecha:</label>
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input style="border-color: #99C0E7; text-align:center" class="form-control pull-right" type="date" name="fecha" id="fecha" required>
                </div>
              </div>

              <div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12">

                <label>Tipo Comprobante:</label>
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-file"></i></span>
                  <select name="tipo_comprobante" id="tipo_comprobante" class="form-control selectpicker" required="">
                    <option value="Boleta">Boleta</option>
                    <option value="Factura">Factura</option>
                    <option value="Ticket">Ticket</option>
                  </select>
                </div>
              </div>

              <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <label>Serie:</label>
                <input style="border-color: #FFC7BB; text-align:center" type="text" class="form-control" name="serie_comprobante" id="serie_comprobante" maxlength="7" placeholder="Serie">
              </div>

              <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <label>Número:</label>
                <input style="border-color: #99C0E7; text-align:center" type="text" class="form-control" name="num_comprobante" id="num_comprobante" maxlength="10" placeholder="Número" required="">
              </div>

              <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <label>Impuesto:</label>
                <div class="input-group date">
                  <div class="input-group-addon">%
                  </div>
                  <input style="border-color: #FFC7BB; text-align:center" type="text" class="form-control" name="impuesto" id="impuesto" required="">
                </div>
              </div>


              <div class="form-group col-lg-12 col-md-3 col-sm-6 col-xs-12">
                <a data-toggle="modal" href="#myModal">
                  <center>
                    <button id="btnAgregarArt" type="button" class="btn btn-blue"><span class="fa fa-plus"></span> Añadir Productos</button>
                  </center>
                </a>
              </div>

              <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <table id="detalles" class="table table-striped table-bordered table-condensed table-hover text-center" width="100%">
                  <thead>
                    <th>Producto</th>
                    <th>UM</th>
                    <th>Cantidad</th>
                    <th>Precio Compra</th>
                    <th>Precio Venta</th>
                    <th>Subtotal</th>
                    <th>Opciones</th>
                  </thead>
                  <tfoot>

                  </tfoot>
                  <tbody>

                  </tbody>
                </table>
              </div>

              <!---->

              <div class="col-sm-8 col-sm-offset-3 col-lg-8 col-lg-offset-2 main">
                <div class="row">
                  <div class="col-lg-4 left">
                    <div class="input-group has-error">
                      <div id="Subtotal" class="input-group-addon">S/ Sub Total:</div>

                      <h8 align="center" class="form-control input-lg" id="most_total" readonly></h8>


                    </div>
                  </div>
                  <div class="col-lg-4 left  has-error">
                    <div class="input-group">
                      <div id="IGV" class="input-group-addon">S/ IGV 18.00%:</div>
                      <h8 align="center" class="form-control input-lg" id="most_imp" placeholder="Impuesto" readonly></h8>

                    </div>
                  </div>

                  <div class="col-lg-4 left has-error">
                    <div class="input-group">
                      <div id="Total" class="input-group-addon">Total:</div>
                      <h8 align="center" class="form-control input-lg" id="total" readonly></h8>
                      <input type="hidden" name="total_compra" id="total_compra">

                    </div>
                  </div>
                </div>
              </div>

              <!---->

              <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <br>
                <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                <button id="btnCancelar" class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-remove"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </section>
    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Seleccione un Producto</h4>
          </div>
          <div class="modal-body" class="panel-body table-responsive">
            <table id="tblarticulos" class="table table-striped table-bordered table-condensed table-hover" width="100%">
              <thead>
                <th>Nombre</th>
                <th>UM</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Acciones</th>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
                <th>Nombre</th>
                <th>UM</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Acciones</th>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <!-- Fin modal -->

    <!-- Modal -->
    <div id="getCodeModal" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content panel panel-primary">

          <div class="modal-header panel-heading">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><span id="titulo-formulario">Vista</span> de Compra</h4>
          </div>
          <div class="modal-body panel-body">
            <input type="hidden" id="txtCodigoSeleccionado">

            <div class="form-group col-lg-5">
              <label class="col-form-label">Proveedor (*)</label>
              <input class="form-control" type="hidden" name="idcompra" id="idcompra">
              <input class="form-control" type="text" name="idproveedorm" id="idproveedorm" readonly>
            </div>
            <div class="form-group col-lg-3">
              <label class="col-form-label">Personal (*)</label>
              <input type="text" class="form-control" id="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
            </div>
            <div class="form-group col-lg-4">
              <label class="col-form-label">Fecha (*)</label>
              <input class="form-control pull-right" type="text" name="fecha_horam" id="fecha_horam" readonly>
            </div>
            <div class="form-group col-lg-3">
              <label class="col-form-label">Comprobante (*)</label>
              <input class="form-control" type="text" name="tipo_comprobantem" id="tipo_comprobantem" maxlength="7" readonly>
            </div>
            <div class="form-group col-lg-3">
              <label class="col-form-label">Serie (*)</label>
              <input class="form-control" type="text" name="serie_comprobantem" id="serie_comprobantem" maxlength="7" readonly>
            </div>
            <div class="form-group col-lg-3">
              <label class="col-form-label">Número (*)</label>
              <input class="form-control" type="text" name="num_comprobantem" id="num_comprobantem" maxlength="10" readonly>
            </div>
            <div class="form-group col-lg-3">
              <div class="input-group">
                <label class="col-form-label">Impuesto (*)</label>
                <input class="form-control" type="text" name="impuestom" id="impuestom" readonly>
              </div>
            </div>
            <div class="form-group col-lg-12 col-md-12 col-xs-12">
              <table id="detallesm" class="table table-striped table-bordered table-condensed table-hover" width="100%">
                <tbody>

                </tbody>
              </table>
            </div>
          </div>
          <div class="modal-footer panel-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cancelar</button>
          </div>
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
  <script type="text/javascript" src="js/compra.js"></script>
  <script type="text/javascript" src="js/stocksbajos.js"></script>
<?php
}
ob_end_flush();
?>