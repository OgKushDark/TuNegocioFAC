<?php
//Activamos el almacenamiento en el buffer
ob_start();
session_start();

if (!isset($_SESSION["nombre"])) {
	header("Location: ../index.php");
} else {
	require 'modulos/header.php';

	if ($_SESSION['ventas'] == 1) {
?>

		<div class="content-wrapper">

			<!-- Main content -->

			<section class="content-header">

				<br>

				<ol class="breadcrumb">

					<li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

					<li class="active">Caja Chica</li>

				</ol>

			</section>

			<section class="content">

				<div class="row">

					<div class="col-md-12">

						<div class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">

							<div class="panel-heading">
								<div class="box-header with-border">
									<h1 class="box-title">Caja Chica</h1>
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

							<!-- centro -->
							<div class="panel-body">

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

								<ul class="nav nav-tabs">
									<li class="active"><a data-toggle="tab" href="#home">Caja Chica</a></li>
									<li><a data-toggle="tab" href="#menu1">Ingresos / Egresos</a></li>
								</ul>

							</div>

							<div class="tab-content">

								<div id="home" class="tab-pane fade in active">

									<section class="content table-responsive">

										<table id="tablaCaja" class="table table-striped table-sm table-hover table-lg table-responsive table-bordered" style="width: 100%;">

											<thead style="background: #3C8DBC; color: white;">

												<th style="text-align: center; width: 600px;">
													Comprobantes
												</th>

												<th style="text-align: center; width: 500px;">
													Cash/Efectivo
												</th>

												<th style="text-align: center; width: 500px;">
													Tarjeta / Transferencia
												</th>

												<th style="text-align: center; width: 300px;">
													Total
												</th>

											</thead>

											<tbody id="tblCompraS">

												<tr>
													<td><img src="https://protechperu.com/sys_fe/img/factura.svg" style="width: 25px;margin-left: 30px;"> Facturas
														<span id="boleta_total_documentos_fac" class="badge badge-success"></span>
													</td>
													<td style="text-align: center;"><label for="facturas" id="facturas">0</label></td>
													<td style="text-align: center;"><label for="facturasT" id="facturasT">0</label></td>
													<td style="text-align: center;"><label for="totalF" id="totalF">0.00</label></td>
												</tr>

												<tr>
													<td><img src="https://protechperu.com/sys_fe/img/boleta.svg" style="width: 25px;margin-left: 30px;"> Boletas
														<span id="boleta_total_documentos_bol" class="badge badge-success"></span>
													</td>
													<td style="text-align: center;"><label for="boletas" id="boletas">0</label></td>
													<td style="text-align: center;"><label for="boletasT" id="boletasT">0</label></td>
													<td style="text-align: center;"><label for="totalB" id="totalB">0.00</label></td>
												</tr>

												<tr>
													<td><img src="https://protechperu.com/sys_fe/public/img/svg/nota_venta2.svg" style="width: 25px;margin-left: 30px;"> Notas de Venta
														<span id="boleta_total_documentos_not" class="badge badge-success"></span>
													</td>
													<td style="text-align: center;"><label for="notasVenta" id="notasVenta">0</label></td>
													<td style="text-align: center;"><label for="notasVentaT" id="notasVentaT">0</label></td>
													<td style="text-align: center;"><label for="totalNotas" id="totalNotas">0.00</label></td>
												</tr>

												<tr>
													<td><img src="../files/plantilla/download.svg" style="width: 25px;margin-left: 30px;"> Cuentas x Cobrar
														<span id="boleta_total_documentos_cuentas" class="badge badge-success"></span>
													</td>
													<td style="text-align: center;"><label for="cuentasCobrar" id="cuentasCobrar">0</label></td>
													<td style="text-align: center;"><label for="cuentasCobrarT" id="cuentasCobrarT">0</label></td>
													<td style="text-align: center;"><label for="totalCuentasCobrar" id="totalCuentasCobrar">0.00</label></td>
												</tr>

												<tr>
													<td><img src="https://protechperu.com/sys_fe/public/img/svg/subtotales.svg" style="width: 25px;margin-left: 30px;"> SubTotales</td>
													<td style="text-align: center;"><label for="totalEfectivo" id="totalEfectivo">0</label></td>
													<td style="text-align: center;"><label for="totalTransferencia" id="totalTransferencia">0</label></td>
													<td style="text-align: center;"><label for="totalT" id="totalT">0.00</label></td>
												</tr>

												<tr>
													<td colspan="3" class="text-right" style="color: green;"><strong>Ingresos Caja:</strong></td>
													<td style="text-align: center;"><label for="totalI" id="totalI">0.00</label></td>
												</tr>

												<tr>
													<td colspan="3" class="text-right" style="color: red;"><strong>Egresos Caja:</strong></td>
													<td style="text-align: center;"><label for="totalE" id="totalE">0.00</label></td>
												</tr>

												<tr>
													<td colspan="3" class="text-right" style="color: blue;"><strong>Total en Caja:</strong></td>
													<td style="text-align: center;"><label for="totalEC" id="totalEC">0.00</label></td>
												</tr>

											</tbody>

										</table>


									</section>

								</div>

								<div id="menu1" class="tab-pane fade">


									<div class="panel-body table-responsive" id="listadoregistros">
										<button class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="float: right"><i class="fa fa-plus"> Crear Movimiento</i>
										</button>
										<br><br><br>
										<table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" width="100%">
											<thead>
												<th>Fecha</th>
												<th>Descripción</th>
												<th>Tipo</th>
												<th>Monto</th>
												<th>Acciones</th>
											</thead>
											<tbody>
											</tbody>
											<tfoot>
												<th>Fecha</th>
												<th>Descripción</th>
												<th>Tipo</th>
												<th>Monto</th>
												<th>Acciones</th>
											</tfoot>
										</table>
									</div>


								</div>

							</div>

						</div>

					</div>

			</section>


		</div>

		<div class="modal fade" id="myModal" tabindex="-1" role="dialog">

			<div class="modal-dialog modal-md">

				<!-- Modal content-->
				<div class="modal-content panel panel-primary">

					<form role="form" name="formulario" id="formulario" method="POST">

						<div class="modal-header panel-heading">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Movimiento</h4>
						</div>

						<div class="modal-body panel-body">

							<input type="hidden" name="idmovimiento" id="idmovimiento">

							<div class="form-group col-lg-6 text-danger" style="text-align: center;">

								<input type="radio" id="egresos" name="opcionEI" value="Egresos" checked="">
								<label for="male">Egresos (-)</label><br>

							</div>

							<div class="form-group col-lg-6 text-success" style="text-align: center;">

								<input type="radio" id="ingresos" name="opcionEI" value="Ingresos">
								<label for="male">Ingresos (+)</label><br>

							</div>

							<div class="form-group col-lg-12">
								<label for="name" class="control-label">Vendedor: </label>
								<input style="border-color: #FFC7BB; text-align:center" type="text" class="form-control" id="nuevoVendedor" name="nuevoVendedor" value="<?php echo $_SESSION["nombre"]; ?>" readonly>
							</div>
							<div class="form-group col-lg-4">
								<label class="col-form-label">Monto:</label>
								<input type="number" step="any" class="form-control" id="montoPagar" name="montoPagar" required="">
							</div>
							<div class="form-group col-lg-8">
								<label class="col-form-label">Descripción:</label>
								<input class="form-control pull-right" type="text" name="descripcion" id="descripcion">
							</div>
						</div>
						<div class="modal-footer panel-footer">
							<button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="limpiar();"><i class="fa fa-times"></i> Cancelar</button>

							<button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>
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
	<script type="text/javascript" src="js/cajachica.js"></script>
	<script type="text/javascript" src="js/stocksbajos.js"></script>
<?php
}
ob_end_flush();
?>