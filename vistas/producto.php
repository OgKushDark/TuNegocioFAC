<?php
ob_start();
session_start();
//si la ariable de sesion no existe
if (!isset($_SESSION["idpersonal"])) {
  header("Location: ../index.php");
} else {
  require 'modulos/header.php';
  if ($_SESSION['almacen'] == 1) {
?>
    <!--Contenido-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

      <section class="content-header">
        <br>
        <ol class="breadcrumb">

          <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

          <li class="active">Administrar Productos</li>

        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">

          <div class="panel-heading">
            <div class="box-header with-border">
              <h1 class="box-title">Productos</h1>
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
            <a href="../reportes/rptproductos.php" target="_blank"><button class="btn btn-danger"><i class="fa fa-file"></i> Reporte</button></a>

            <a data-toggle="modal" data-target="#desempaquetar" target="_blank"><button class="btn btn-success" style="float: right; margin-left: 5px;" onclick="llenarProductos()"><i class="fa fa-file"></i> Desempaquetar</button></a>

            <a href="../reportes/rptproductoscompra.php" target="_blank" style="float: right"><button class="btn btn-info"><i class="fa fa-file"></i> Inversión x Producto</button></a>

            <br><br>
            <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" width="100%">
              <thead>
                <th>Nombre</th>
                <th>Unidad de Medida</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Estado</th>
                <th>Acciones</th>
                <th>Marca</th>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                <th>Nombre</th>
                <th>Unidad de Medida</th>
                <th>Categoría</th>
                <th>Código</th>
                <th>Stock</th>
                <th>Imagen</th>
                <th>Estado</th>
                <th>Acciones</th>
                <th>Marca</th>
              </tfoot>
            </table>
          </div>
        </div>
      </section>

    </div><!-- /.content-wrapper -->
    <!--Fin-Contenido-->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog">

      <div class="modal-dialog" style="width: 650px">

        <div class="modal-content">
          <!-- form -->
          <form class="form-horizontal" role="form" name="formulario" id="formulario" method="POST">

            <div class="modal-header" style="background:#3c8dbc; color:white">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="limpiar()">&times;</button>
              <h4 class="modal-title">
                Productos</h4>
            </div>

            <div class="modal-body">

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">Nombre:</label>
                <div class="col-sm-4">
                  <input type="hidden" name="idproducto" id="idproducto">
                  <input type="text" class="form-control" name="nombre" id="nombre" maxlength="100" placeholder="Nombre" required>
                </div>

                <label for="name" class="col-sm-2 control-label">Categoría: </label>
                <div class="col-sm-4">
                  <select id="idcategoria" name="idcategoria" class="form-control selectpicker" data-live-search="true" title="Seleccione Categoría" required></select>
                </div>
              </div>

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">Unidad de Medida </label>
                <div class="col-sm-4">
                  <select id="idunidad_medida" name="idunidad_medida" class="form-control selectpicker" data-live-search="true" title="Seleccione Unidad de Medida" required></select>
                </div>

                <label for="name" class="col-sm-2 control-label">Stock:</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" name="stock" id="stock" required>
                </div>

              </div>

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">Marca:</label>
                <div class="col-sm-4">
                <select id="idmarca" name="idmarca" class="form-control selectpicker" data-live-search="true" title="Marca" required></select>
                </div>

                <label for="name" class="col-sm-2 control-label">Descripción: </label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="descripcion" id="descripcion" maxlength="256" placeholder="Descripción">
                </div>

              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Imagen:</label>
                <div class="col-sm-7">
                  <input type="file" class="form-control" name="imagen" id="imagen">
                  <input type="hidden" name="imagenactual" id="imagenactual">
                  <img src="" class="img-thumbnail" id="imagenmuestra" width="100px">
                </div>
                
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Código:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="codigo" id="codigo" maxlength = "100" placeholder="Código Barras">
                  <button class="btn btn-success" type="button" onclick="generarbarcode()">Generar</button>
                  <button class="btn btn-info" type="button" onclick="imprimir()"><i class="fa fa-print"></i></button>
                  <div id="print">
                    <svg id="barcode"></svg>
                  </div>
                </div>

                <label for="name" class="col-sm-2 control-label">Stock Min:</label>
                  <div class="col-sm-4">
                     <input type="number" class="form-control" name="stockminimo" id="stockminimo" required>
                  </div>

              </div>

              <div class="form-group col-12">
                <label for="name" class="col-sm-2 control-label">Precio de Venta</label>
                <div class="col-sm-4">
                  <input type="number" step="any" class="form-control" name="precio" id="precio" required>
                </div>

                <label for="name" class="col-sm-2 control-label">Precio de Compra:</label>
                <div class="col-sm-4">
                  <input type="number" step="any" class="form-control" name="precioCompra" id="precioCompra" required>
                </div>

              </div>

              <div class="form-group col-12" hidden>

                <label for="name" class="col-sm-2 control-label">N° Serie:</label>
                <div class="col-sm-4">
                  <input type="text" class="form-control" name="nserie" id="nserie" placeholder="Ingrese N° serie">
                </div>


              </div>

              <div class="form-group col-12">

                <label for="name" class="col-sm-2 control-label">Precio B:</label>
                <div class="col-sm-2">
                  <input type="number" step="any" class="form-control" name="precioB" id="precioB">
                </div>

                <label for="name" class="col-sm-2 control-label">Precio C:</label>
                <div class="col-sm-2">
                  <input type="number" step="any" class="form-control" name="precioC" id="precioC">
                </div>

                <label for="name" class="col-sm-2 control-label">Precio D:</label>
                <div class="col-sm-2">
                  <input type="number" step="any" class="form-control" name="precioD" id="precioD">
                </div>

              </div>

              <div class="form-group col-6">

                <label for="name" class="col-sm-2 control-label">Fecha de Vencimiento:</label>
                <div class="col-sm-4">
                  <input style="border-color: #99C0E7; text-align:center" class="form-control pull-right" type="date" name="fecha_hora" id="fecha_hora">
                </div>

                <label for="name" class="col-sm-2 control-label">Tipo Igv:</label>
                <div class="col-sm-4">
                  <div class="input-group">
                    <select id="tipoigv" name="tipoigv" class="form-control" data-live-search="true" required>
                      <option value="Gravada">Gravada</option>
                      <option value="No Gravada">No Gravada</option>
                    </select>
                  </div>
                </div>

              </div>

            </div>

            <div class="modal-footer">
              <button type="button" onclick="cancelarform()" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              <button class="btn btn-primary" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Importar Productos -->

    

    <!-- Fin modal -->

    <div class="modal fade" id="desempaquetar" tabindex="-1" role="dialog">

      <div class="modal-dialog" style="width: 800px">

        <div class="modal-content">
          <!-- form -->
          <form class="form-horizontal" role="form" name="formularioDesempaquetar" id="formularioDesempaquetar" method="POST">

            <div class="modal-header" style="background:#3c8dbc; color:white">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">
                DESEMPAQUETAR PRODUCTOS</h4>
            </div>

            <div class="modal-body">
              <div class="alert" style="background: #E0F7FA;">
                <strong><i class="fa fa-info"></i> Info!</strong> DESEMPAQUETAR: <label for="documento" id="documento"></label> Para hacer uso de este módulo <label for="deudaTotal" id="deutaTotal"></label>, debe tener en claro el producto empaquetado y el producto al cual se le va a asignar lo desempaquetado.</i></a>
              </div>

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">Producto a Desempaquetar: </label>
                <div class="col-sm-4">
                  <select id="idproductoE" name="idproductoE" class="form-control selectpicker" data-live-search="true" title="Seleccione Producto" onchange="stockProductoE()" required></select>
                </div>

                <label for="name" class="col-sm-2 control-label">Producto Asignado: </label>
                <div class="col-sm-4">
                  <select id="idproductoD" name="idproductoD" class="form-control selectpicker" data-live-search="true" title="Seleccione Producto" onchange="stockProductoD()" required></select>
                </div>

              </div>

              <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Cantidad a Desempaquetar:</label>
                <div class="col-sm-4">
                  <input type="hidden" name="productoE" id="productoE">
                  El Producto tiene <label id="productoDesempaquetar" name="productoDesempaquetar">0</label>
                  <input type="text" class="form-control" name="cantidadE" id="cantidadE" placeholder="Cantidad" required>
                </div>
                
              </div>

              <div class="form-group">

                <label for="name" class="col-sm-2 control-label">¿Cuántos Productos Contiene?</label>
                <div class="col-sm-4">
                  <input type="hidden" name="productoD" id="productoD">
                  <input type="text" class="form-control" name="cantidadD" id="cantidadD" placeholder="Cantidad" required>
                </div>
              </div>

            </div>

            <div class="modal-footer">
              <button type="button" onclick="limpiarDesempaquetado()" class="btn btn-danger pull-left" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Guardar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  <?php
  } else {
    require 'noacceso.php';
  }
  require 'modulos/footer.php';
  ?>
  <script type="text/javascript" src="../public/js/JsBarcode.all.min.js"></script>
  <script type="text/javascript" src="../public/js/jquery.PrintArea.js"></script>
  <script type="text/javascript" src="js/producto.js"></script>
  <script type="text/javascript" src="js/stocksbajos.js"></script>
  <script>
    document.getElementById("txt_archivo").addEventListener("change", () => {

      var fileName = document.getElementById("txt_archivo").value;
      var idxDot = fileName.lastIndexOf(".") + 1;
      var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
      if (extFile == "xlsx" || extFile == "xlsb") {

      } else {
        swal({
          title: "Error al subir el archivo",
          text: "Solo se acpetan archivos excel",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
        document.getElementById("txt_archivo").value = "";
      }

    });
  </script>
<?php
}
ob_end_flush();
?>