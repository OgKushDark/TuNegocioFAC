<?php

ob_start();
session_start();
//si la ariable de sesion no existe
if (!isset($_SESSION["idpersonal"])) {
  header("Location: ../index.php");
} else {

  require 'modulos/header.php';
  require_once "../modelos/Negocio.php";

  $cnegocio = new Negocio();
  $rsptan = $cnegocio->listar();
  $regn = $rsptan->fetch_object();

  require_once "../modelos/Consultas.php";

  if ($_SESSION['inicio'] == 1) {

    $consulta = new Consultas();

    $rsptav = $consulta->totalstock();
    $regv = $rsptav->fetch_object();
    $totalstock = $regv->totalstock;
    $cap_almacen = 300000;

    $rsptav = $consulta->cantidadcategorias();
    $regv = $rsptav->fetch_object();
    $totalcategorias = $regv->totalca;

    $rsptav = $consulta->cantidadarticulos();
    $regv = $rsptav->fetch_object();
    $totalarticulos = $regv->totalar;

    //Datos para mostrar el gráfico de barras de las compras
    $compras10 = $consulta->comprasultimos_10dias();
    $fechasc = '';
    $totalesc = '';
    while ($regfechac = $compras10->fetch_object()) {
      $fechasc = $fechasc . '"' . $regfechac->fecha . '",';
      $totalesc = $totalesc . $regfechac->total . ',';
    }
    //Quitamos la última coma
    $fechasc = substr($fechasc, 0, -1);
    $totalesc = substr($totalesc, 0, -1);

    //Datos para mostrar el gráfico de barras de las ventas
    $ventas12 = $consulta->ventasultimos_12meses();
    $fechasv = '';
    $totalesv = '';
    while ($regfechav = $ventas12->fetch_object()) {
      $fechasv = $fechasv . '"' . $regfechav->fecha . '",';
      $totalesv = $totalesv . $regfechav->total . ',';
    }
    //Quitamos la última coma
    $fechasv = substr($fechasv, 0, -1);
    $totalesv = substr($totalesv, 0, -1);

    //Datos para mostrar el grafico de barras de los productos mas vendidos

    $productosV = $consulta->productosmasvendidos();
    $nombreV = '';
    $productosm = '';
    while ($regnombreV = $productosV->fetch_object()) {
      $nombreV = $nombreV . '"' . $regnombreV->nombre . '",';
      $productosm = $productosm . $regnombreV->cantidad . ',';
    }
    //Quitamos la última coma
    $nombreV = substr($nombreV, 0, -1);
    $productosm = substr($productosm, 0, -1);


?>
    <!--Contenido-->
    <div class="content-wrapper">
      <!-- Main content -->
      <section class="content-header">
        <br>
        <ol class="breadcrumb">

          <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

          <li class="active">Panel de control</li>

        </ol>
      </section>

      <section class="content" style="margin-bottom: -60px;">
        <div class="row">
          <div class="col-md-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <div class="box-header">
                  <h1 class="box-title">A continuación puedes seleccionar los criterios para mostrar el resumen</h1>

                </div>
              </div>

              <div class="panel-body">

                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                  <label>Fecha Inicio</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" class="form-control" name="fecha_inicio" id="fecha_inicio" value="<?php echo date("Y-m-d"); ?>">
                  </div>
                </div>

                <div class="form-group col-lg-4 col-md-6 col-sm-6 col-xs-12">
                  <label>Fecha Fin</label>
                  <div class="input-group date">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" value="<?php echo date("Y-m-d"); ?>">
                  </div>
                </div>

                <div class="col-lg-4 left">
                  <label id="lblSucursal2">Vendedor:</label>
                  <div class="form-group has-success">

                    <div class="input-group">
                      <select name="idvendedor" id="idvendedor" class="form-control" data-live-search="true" required>
                      </select>
                      <span class="input-group-btn">
                        <button class="btn btn-success" onclick="listar()"><i class="fa fa-search"></i> Mostrar</button>
                      </span>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </section>

      <section class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="box">
              <div class="box-header with-border">
                <h1 class="box-title">Inicio </h1>
                <small>Panel de control</small>
                <div class="box-tools pull-right">
                  <button class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button class="btn btn-box-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <!-- /.box-header -->
              <!-- centro -->
              <div class="panel-body">

                <?php

                if (empty($regn)) {
                ?>

                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="alert alert-danger alert-dismissible text-center small-box">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <div class="inner">
                        <h4 style="font-size: 17px;">
                          <i class="fa fa-warning"></i> Alert!
                        </h4>
                        <h4>Configura los datos de tu Empresa</h4>
                      </div>
                      <a href="negocio.php" class="small-box-footer">Configurar <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>

                <?php
                } else {

                  $nombrenegocio = $regn->nombre;
                  $smoneda = $regn->simbolo;
                  $logo = $regn->logo;

                ?>

                  <div class="box-header with-border text-center" id="datos_negocio">
                    <?php echo "<img src='../reportes/" . $logo . "' height='50px' width='50px' alt=''>"; ?>
                    <h1 class="box-title"><?php echo $nombrenegocio; ?></h1>
                  </div>

                <?php

                }

                ?>

                <div class="row">


                  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="small-box bg-aqua">
                      <div class="inner">
                        <h4 style="font-size:20px;">
                          <strong id="lblComprasHoy">0.00</strong>
                        </h4>
                        <p>Compras de Hoy </p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-cart-plus"></i>
                      </div>
                      <a href="compra.php" class="small-box-footer">Lista de Compras <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>

                  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="small-box bg-green">
                      <div class="inner">
                        <h4 style="font-size:20px;">
                          <strong id="lblVentasHoy">0.00</strong>
                        </h4>
                        <p>Ventas de Hoy al Contado </p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                      </div>
                      <a href="venta.php" class="small-box-footer">Lista de Ventas <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>

                  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="small-box bg-yellow">
                      <div class="inner">
                        <h4 style="font-size:20px;">
                          <strong id="lblEmpleados">0.00</strong>
                        </h4>
                        <p>Empleados </p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-user"></i>
                      </div>
                      <a href="empleado.php" class="small-box-footer">Lista de Empleados <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>

                  <div class="col-lg-3 col-md-3 col-sm-6 col-xs-6">
                    <div class="small-box bg-red">
                      <div class="inner">
                        <h4 style="font-size:20px;">
                          <strong id="lblProveedores"></strong>
                        </h4>
                        <p>Proveedores </p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-users"></i>
                      </div>
                      <a href="proveedor.php" class="small-box-footer">Lista de Proveedores <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>



                </div>

                <div class="row">

                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="small-box bg-red">
                      <div class="inner">
                        <h4 style="font-size:20px;">
                          <strong id="lblTotalVentasC">0.00</strong>
                        </h4>
                        <p>Ventas de Hoy al Crédito </p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-shopping-cart"></i>
                      </div>
                      <a href="venta.php" class="small-box-footer">Lista de Ventas <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>

                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <div class="small-box bg-primary">
                      <div class="inner">
                        <h4 style="font-size:20px;">
                          <strong id="lblCuentasCobrar">0.00</strong>
                        </h4>
                        <p>Cuentas por Cobrar </p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-usd"></i>
                      </div>
                      <a href="cuentasxcobrar.php" class="small-box-footer">Lista de Cuentas por Cobrar <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>


                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="info-box bg-purple">
                    <span class="info-box-icon"><i class="fa fa-files-o"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Categorias</span>
                      <span class="info-box-number"><?php echo $totalcategorias; ?></span>

                      <div class="progress">
                        <?php $porcentcate = (100 * $totalcategorias) / 100; ?>
                        <?php echo '<div class="progress-bar" style="width: ' . $porcentcate . '%"></div>'; ?>
                      </div>
                      <span class="progress-description">
                        <?php echo $porcentcate; ?>% total de categorias
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                  <div class="info-box bg-gray">
                    <span class="info-box-icon"><i class="fa fa-copy"></i></span>

                    <div class="info-box-content">
                      <span class="info-box-text">Productos</span>
                      <span class="info-box-number"><?php echo $totalarticulos; ?></span>

                      <div class="progress">
                        <?php $porcentart = (100 * $totalstock) / $cap_almacen; ?>
                        <?php echo '<div class="progress-bar" style="width: ' . $porcentart . '%"></div>'; ?>

                      </div>
                      <span class="progress-description">
                        <?php echo round($porcentart, 2); ?>% de la capacidad de almacen
                      </span>
                    </div>
                    <!-- /.info-box-content -->
                  </div>
                </div>


                <!--Fin centro -->
              </div><!-- /.box -->
            </div><!-- /.col -->

            <!--------------------->

            <div class="row">
              <div class="col-md-6">
                <!-- AREA CHART -->
                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title" style="font-size:17px;">Compras - Últimos 10 días</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                  <div class="box-body">
                    <canvas id="compras" width="400" height="300"></canvas>
                  </div><!-- /.box-body -->
                </div><!-- /.box -->

                <!-- DONUT CHART -->
                <div class="box box-danger">
                  <div class="box-header with-border">
                    <h3 class="box-title" style="font-size:17px;">Productos más vendidos</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                  <div class="box-body">
                    <canvas id="pieChart" width="300" height="200"></canvas>
                  </div><!-- /.box-body -->
                </div><!-- /.box -->

              </div><!-- /.col (LEFT) -->
              <div class="col-md-6">
                <!-- LINE CHART -->
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title" style="font-size:17px;">Ventas - Últimos 12 meses</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                  <div class="box-body">
                    <canvas id="ventas" width="400" height="300"></canvas>
                  </div><!-- /.box-body -->
                </div><!-- /.box -->

                <!-- BAR CHART -->
                <div class="box box-success">
                  <div class="box-header with-border">
                    <h3 class="box-title" style="font-size:17px;">Stock Bajo - Productos</h3>
                    <div class="box-tools pull-right">
                      <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                      <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                  <div class="panel-body table-responsive" id="listadoregistros">

                    <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover" width="100%">
                      <thead>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                      </tfoot>
                    </table>
                  </div>
                </div><!-- /.box -->

              </div><!-- /.col (RIGHT) -->
            </div>

            <!------------------->


          </div><!-- /.row -->


      </section>

    </div>
    <!--Fin-Contenido-->

  <?php
  } else {
    require 'noacceso.php';
  }
  require 'modulos/footer.php';
  ?>
<?php
}
ob_end_flush();
?>

<script src="../public/js/Chart.js"></script>
<script src="../public/js/Chart.bundle.min.js"></script>
<script type="text/javascript">
  var ctx = document.getElementById("compras").getContext('2d');
  var compras = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [<?php echo $fechasc; ?>],
      datasets: [{
        label: 'Compras en S/ de los últimos 10 días',
        data: [<?php echo $totalesc; ?>],
        backgroundColor: [
          'rgba(215, 40, 40, 0.6)',
          'rgba(255, 143, 35, 0.6)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)'
        ],
        borderColor: [
          'rgba(255,99,132,1)',
          'rgba(255, 143, 35, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)'
        ],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          }
        }]
      }
    }
  });

  var ctx = document.getElementById("ventas").getContext('2d');
  var ventas = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: [<?php echo $fechasv; ?>],
      datasets: [{
        label: 'Ventas en S/ de los últimos 12 meses',
        data: [<?php echo $totalesv; ?>],
        backgroundColor: [
          'rgba(49, 148, 77, 0.6)',
          'rgba(190, 103, 89, 0.6)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)',
          'rgba(255, 99, 132, 0.2)',
          'rgba(54, 162, 235, 0.2)',
          'rgba(255, 206, 86, 0.2)',
          'rgba(75, 192, 192, 0.2)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
          'rgba(49, 164, 89, 1)',
          'rgba(190, 103, 89, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 1)',
          'rgba(255, 159, 64, 1)',
          'rgba(255,99,132,1)',
          'rgba(54, 162, 235, 1)',
          'rgba(255, 206, 86, 1)',
          'rgba(75, 192, 192, 1)',
          'rgba(153, 102, 255, 0.2)',
          'rgba(255, 159, 64, 0.2)'
        ],
        borderWidth: 2
      }]
    },
    options: {
      scales: {
        yAxes: [{
          stacked: true
        }]
      }
    }
  });

  var ctx = document.getElementById("pieChart").getContext('2d');
  var compras = new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: [<?php echo $nombreV; ?>],
      datasets: [{
        label: 'Productos más Vendidos',
        data: [<?php echo $productosm; ?>],
        backgroundColor: [
          'rgba(215, 40, 40, 0.9)',
          'rgba(97, 103, 225, 0.9)',
          'rgba(255, 159, 65, 0.9)'
        ],
        borderColor: [
          'rgba(215, 40, 40, 1)',
          'rgba(97, 103, 225, 1)',
          'rgba(255, 159, 65, 1)'
        ]
      }]
    },
    options: {

    }
  });
</script>
<script type="text/javascript" src="js/stockproducto.js"></script>
<script type="text/javascript" src="js/stocksbajos.js"></script>
<script type="text/javascript" src="js/inicio.js"></script>