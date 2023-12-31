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
    

?>
<html>
    <!--Contenido-->
    <div class="content-wrapper">
      <!-- Main content -->

      <section class="content-header">


        <br>
        <ol class="breadcrumb">

          <li><a href="inicio.php"><i class="fa fa-dashboard"></i> Inicio</a></li>

          <li class="active">Panel de control</li>

        </ol>
        <div class="panel-body">
    <!-- Otro contenido aquí -->

    <!-- Inserción de la imagen -->
    <div style="display: flex; justify-content: center; align-items: center; height: 100vh;">
    <img src="../files/img/fondo.jpg" alt="Descripción de la imagen" width="800" height="700">
</div>


    <!-- Más contenido aquí -->
</div>
      </section>

      
      
    </div>
    <!--Fin-Contenido-->
</html>
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


<script type="text/javascript" src="js/inicio.js"></script>