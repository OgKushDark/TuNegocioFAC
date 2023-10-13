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

                    <li class="active">Ficha de supervisión</li>

                </ol>

            </section>

            <section class="content">
                <div class="row">

                    <div class="col-md-12">

                        <div class="panel panel-default" style="border-color: #666; border-width: 3px; border-style: double;">

                            <div class="panel-heading">
                                <div class="box-header with-border">
                                    <h1 class="box-title">Ficha de supervisión</h1>
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
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="panel-heading"><h2><b>FICHA DE SUPERVISIÓN Nº: <span>147</span></b></h2></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b><h3>1.- DATOS DE LOS RESPONSABLES</h3></b></label>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label><b><h3>2.- DATOS DEL COMITÉ VASO DE LECHE</h3></b></label>
                                            </div>
                                            <br><br>
                                            <div class="col-md-4">
                                                <label>2.1 TOTAL DE BENEFICIARIOS: </label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" name="txtBeneficiarios" id="txtBeneficiarios" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label>2.2 TOTAL DE MADRES RESPONSABLES: </label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" name="txtMadresBeneficiarias" id="txtMadresBeneficiarias" required>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>2.3 RACIONES DISTRIBUIDAS DURANTE LA VISITA: </label>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" class="form-control" name="txtRacionesDistribuidas" id="txtRacionesDistribuidas" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label><b><h3>3.- CONTROL DE STOCK EN ALMACÉN</h3></b></label>
                                            </div>
                                            <br><br>
                                            <div class="col-md-12">
                                                <div class="col-md-4">
                                                    <label>RUBROS</label>
                                                </div>
                                                <div class="col-md-2">
                                                <label>LECHE EVAPORADA ENTERA GLORIA</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <label>HOJUELAS DE KIWICHA,AVENA,CEBADA,QUINUA AZUCARADA, CON VITAMINAS Y MINIRALES PRECODIDOS</label>
                                                </div>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>3.2 RACIÓN DIARIA</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" type="number" name="txtRacionLeche" id="txtRacionLeche" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" type="number" step="0.01" name="txtRacionHojuelas" id="txtRacionHojuelas" required>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>3.3 Nº DE DÍAS PREPARADOS</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" type="number" name="txtDias" id="txtDias" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" type="number" step="0.01" name="txtDiasHojuelas" id="txtDiasHojuelas" required>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>3.4 CANTIDAD UTILIZADA</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" type="number" name="txtCantidad" id="txtCantidad" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" type="number" step="0.01" name="txtCantidadHojuelas" id="txtCantidadHojuelas" required>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>3.5 STOCK QUE DEBE TENER</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" type="number" name="txtStock" id="txtStock" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" type="number" step="0.01" name="txtStockHojuelas" id="txtStockHojuelas" required>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>3.6 STOCK EN DÍA DE LA VISITA</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" type="number" name="txtStockVisita" id="txtStockVisita" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" type="number" step="0.01" name="txtStockVisitaHojuelas" id="txtStockVisitaHojuelas" required>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>3.7 CANTIDAD FALTANTE</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" type="number" name="txtCantidadFaltante" id="txtCantidadFaltante" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" type="number" step="0.01" name="txtFaltanteHojuelas" id="txtFaltanteHojuelas" required>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>3.8 CANTIDAD SOBRANTE</label>
                                            </div>
                                            <div class="col-md-2">
                                                <input class="form-control" type="number" name="txtCantidadSobrante" id="txtCantidadSobrante" required>
                                            </div>
                                            <div class="col-md-6">
                                                <input class="form-control" type="number" step="0.01" name="txtSobranteHojuelas" id="txtSobranteHojuelas" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label><b><h3>4.- CONDICIONES DE HIGIENE Y PREPARACIÓN</h3></b></label>
                                            </div>
                                            <br><br>
                                            <div class="col-md-6">
                                                <label class="col-md-4">RUBROS</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label>OBSERVACIONES</label>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label">4.1 CONDICIONES DEL PRODUCTO</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="cbxCondicionProducto" id="cbxCondicionProducto"
                                                    class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control" rows="2" name="txtObservacionProducto" id="txtObservacionProducto"></textarea>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label class="control-label">4.2 CONDICIONES DE HIGIENE DE LA PREPARACIÓN</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="cbxCondicionPreparacion" id="cbxCondicionPreparacion"
                                                    class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control" rows="2" name="txtObservacionPreparacion" id="txtObservacionPreparacion"></textarea>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label class="control-label">4.3 ESTADO DE HIGIENE DE LOS UTENSILIOS</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="cbxHigieneUtensilios" id="cbxHigieneUtensilios"
                                                    class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control" rows="2" name="txtObservacionUtensilios" id="txtObservacionUtensilios"></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label><b><h3>5.- ALMACENAMIENTO DE LOS ALIMENTOS EN LOS ALIMENTOS DE LOS COMITES DE VASO DE LECHE</h3></b></label>
                                            </div>
                                            <br><br>
                                            <div class="col-md-6">
                                                <label class="col-md-4">RUBROS</label>
                                            </div>
                                            <div class="col-md-6">
                                                <label>OBSERVACIONES</label>
                                            </div>
                                            <div class="col-md-4">
                                                <label>5.1 APILADO</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="cbxApilado" id="cbxApilado"
                                                    class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control" rows="2" name="txtObservacionApilado" id="txtObservacionApilado"></textarea>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>5.2 HUMEDAD</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="cbxHumedad" id="cbxHumedad"
                                                    class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control" rows="2" name="txtObservacionHumedad" id="txtObservacionHumedad"></textarea>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>5.3 SEGURIDAD</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="cbxSeguridad" id="cbxSeguridad"
                                                    class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control" rows="2" name="txtObservacionSeguridad" id="txtObservacionSeguridad"></textarea>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>5.4 VENTILACIÓN</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="cbxVentilacion" id="cbxVentilacion"
                                                    class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control" rows="2" name="txtObservacionVentilacion" id="txtObservacionVentilacion"></textarea>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>5.5 ILUMINACIÓN</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="cbxIluminacion" id="cbxIluminacion"
                                                    class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control" rows="2" name="txtObservacionIluminacion" id="txtObservacionIluminacion"></textarea>
                                            </div>
                                            <br><br><br>
                                            <div class="col-md-4">
                                                <label>5.6 LIMPIEZA</label>
                                            </div>
                                            <div class="col-md-2">
                                                <select name="cbxLimpieza" id="cbxLimpieza"
                                                    class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <textarea class="form-control" rows="2" name="txtObservacionLimpieza" id="txtObservacionLimpieza"></textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label><b><h3>6.- DE LA IDENTIFICACIÓN<h3></b></label>
                                            </div>
                                            <br><br>
                                            <div class="col-md-8">
                                                <label>6.1 RESOLUCIÓN MUNICIPAL</label>
                                            </div>
                                            <div class="col-md-2">
                                                SI&nbsp;<label class="cr-styled" for="rdbResolucionMunicipalSi">
                                                    <input type="radio" name="rdbResolucionMunicipalSiNo" id="rdbResolucionMunicipalSi" value="1"><i
                                                        class="fa"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                NO&nbsp;<label class="cr-styled" for="rdbResolucionMunicipalNo">
                                                    <input type="radio" name="rdbResolucionMunicipalSiNo" id="rdbResolucionMunicipalNo" value="0"><i
                                                        class="fa"></i>
                                                </label>
                                            </div>
                                            <br>
                                            <div class="col-md-8">
                                                <label>6.2 ACTA DE INSTALACIÓN DEL COMITE</label>
                                            </div>
                                            <div class="col-md-2">
                                                SI&nbsp;<label class="cr-styled" for="rdbActaInstalacionSi">
                                                    <input type="radio" name="rdbActaInstalacionSiNo" id="rdbActaInstalacionSi" value="1"><i
                                                        class="fa"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                NO&nbsp;<label class="cr-styled" for="rdbActaInstalacionNo">
                                                    <input type="radio" name="rdbActaInstalacionSiNo" id="rdbActaInstalacionNo" value="0"><i
                                                        class="fa"></i>
                                                </label>
                                            </div>
                                            <br>
                                            <div class="col-md-8">
                                                <label>6.3 LIBRO DE ACTAS</label>
                                            </div>
                                            <div class="col-md-2">
                                                SI&nbsp;<label class="cr-styled" for="rdbLibroActasSi">
                                                    <input type="radio" name="rdbLibroActasSiNo" id="rdbLibroActasSi" value="1"><i
                                                        class="fa"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                NO&nbsp;<label class="cr-styled" for="rdbLibroActasNo">
                                                    <input type="radio" name="rdbLibroActasSiNo" id="rdbLibroActasNo" value="0"><i
                                                        class="fa"></i>
                                                </label>
                                            </div>
                                            <br>
                                            <div class="col-md-8">
                                                <label>6.4 CARTEL DE IDENTIFICACIÓN, INDICANDO HORARIOS DE ATENCIÓN</label>
                                            </div>
                                            <div class="col-md-2">
                                                SI&nbsp;<label class="cr-styled" for="rdbCartelIdentificacionSi">
                                                    <input type="radio" name="rdbCartelIdentificacionSiNo" id="rdbCartelIdentificacionSi" value="1"><i
                                                        class="fa"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                NO&nbsp;<label class="cr-styled" for="rdbCartelIdentificacionNo">
                                                    <input type="radio" name="rdbCartelIdentificacionSiNo" id="rdbCartelIdentificacionNo" value="0"><i
                                                        class="fa"></i>
                                                </label>
                                            </div>
                                            <br>
                                            <div class="col-md-8">
                                                <label>6.5 SELLO DE COMITE U OTROS</label>
                                            </div>
                                            <div class="col-md-2">
                                                SI&nbsp;<label class="cr-styled" for="rdbSelloComiteSi">
                                                    <input type="radio" name="rdbSelloComiteSiNo" id="rdbSelloComiteSi" value="1"><i
                                                        class="fa"></i>
                                                </label>
                                            </div>
                                            <div class="col-md-2">
                                                NO&nbsp;<label class="cr-styled" for="rdbSelloComiteNo">
                                                    <input type="radio" name="rdbSelloComiteSiNo" id="rdbSelloComiteNo" value="0"><i
                                                        class="fa"></i>
                                                </label>
                                            </div>
                                        </div>
                                        <br>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label><b><h3>7.- CONTROL DE DOCUMENTACIÓN</h3></b></label>
                                            </div>
                                            <br><br>
                                            <div class="col-md-8">
                                                <label>7.1 CONTROL DE PREPARACIÓN DIARIA</label>
                                            </div>                                      
                                            <div class="col-md-4">
                                                <select name="cbxControlDocumentacion" id="cbxControlDocumentacion"
                                                class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <br><br>
                                            <div class="col-md-8">
                                                <label>7.2 CONTROL DIARIO DE BENEFICIARIOS</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="cbxControlBeneficiarios" id="cbxControlBeneficiarios"
                                                class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <br><br>
                                            <div class="col-md-8">
                                                <label>7.3 PARTICIPACIÓN Y ROL DE COCINA</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="cbxParticipacion" id="cbxParticipacion"
                                                class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <br><br>
                                            <div class="col-md-8">
                                                <label>7.4 APOYO EN GASTOS EN PREPARACIÓN DE PRODUCTO</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="cbxApoyoGastos" id="cbxApoyoGastos"
                                                class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <br><br>
                                            <div class="col-md-8">
                                                <label>7.5 ASISTENCIA DE ASAMBLEA CIVIL</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="cbxAsistenciaAsamblea" id="cbxAsistenciaAsamblea"
                                                class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <br><br>
                                            <div class="col-md-8">
                                                <label>7.6 ASISTENCIA EN ACTIVIDAD DE MDC</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="cbxAsistenciaActividad" id="cbxAsistenciaActividad"
                                                class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                            <br><br>
                                            <div class="col-md-8">
                                                <label>7.7 DESARROLLO O PARTICIPACIÓN EN OTRAS ACTIVIDADES DE MDC</label>
                                            </div>
                                            <div class="col-md-4">
                                                <select name="cbxDesarrolloParticipacion" id="cbxDesarrolloParticipacion"
                                                class="form-control selectpicker" data-live-search="true" title="Seleccione opción" required>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label><b><h3>8.- OBSERVACIONES Y RECOMENDACIONES GENERALES DE LA SUPERVISIÓN</h3></b></label>
                                                    <textarea name="txtObservacion" id="txtObservacion"
                                                    class="form-control" rows="3"
                                                    style="border:solid 1px">
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
            </section>


        </div>
    <?php
    } else {
        require 'noacceso.php';
    }

    require 'modulos/footer.php';
    ?>
    <script type="text/javascript" src="js/fichasupervision.js"></script>
<?php
}
ob_end_flush();
?>