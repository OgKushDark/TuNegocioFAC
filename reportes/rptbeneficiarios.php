<?php
//Activamos el almacenamiento en el buffer
ob_start();
//Comenzamos a crear las filas de los registros según la consulta mysql
    require_once "../modelos/Consultas.php";
    $consulta = new Consultas();

    // Capturamos el valor del idcomite desde la URL
    $idcomite = isset($_GET['idcomite']) ? $_GET['idcomite'] : null;

    // Validamos que el idcomite sea un número válido
    if ($idcomite === null || !is_numeric($idcomite)) {
      die('Error: El parámetro idcomite no es válido.');
    }
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
  if ($_SESSION['configuracion'] == 1)
  {

    //Incluímos a la clase PDF_MC_Table
    require('PDF_MC_Table.php');

    //Instanciamos la clase para generar el documento pdf
    $pdf = new PDF_MC_Table();

    //Agregamos la primera página al documento pdf
    $pdf->AddPage();

    //Seteamos el inicio del margen superior en 25 pixeles 
    $y_axis_initial = 25;

    //Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
    $pdf->SetFont('Arial', 'B', 14);

    $pdf->Cell(40, 6, '', 0, 0, 'C');
    $pdf->Cell(100, 6, 'LISTA DE BENEFICIARIOS', 1, 0, 'C');
    $pdf->Ln(10);


    $rsptas = $consulta->ListaBeneficiarioComite($idcomite);

    //Table with filas y columnas
    $pdf->SetWidths(array(187));

    while ($reg = $rsptas->fetch_object())
    {
      $nombres = $reg->nombre;
      

      $pdf->SetFont('Arial', 'B', 13);
      $pdf->Row(array(utf8_decode("Comite: " .$nombres)));
    }

    //Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
    $pdf->SetFillColor(232, 232, 232);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(58, 6, 'Nombre', 1, 0, 'C', 1);
    $pdf->Cell(30, 6, 'DNI', 1, 0, 'C', 1);
    $pdf->Cell(35, 6, 'Tipo', 1, 0, 'C', 1);
    $pdf->Cell(32, 6, 'Responsable', 1, 0, 'C', 1);
    $pdf->Cell(32, 6, 'DNI', 1, 0, 'C', 1);

    $pdf->Ln(10);

    

    $rspta = $consulta->ListaBeneficiario($idcomite);

    //Table with filas y columnas
    $pdf->SetWidths(array(58, 30, 35, 32, 32));

    while ($reg = $rspta->fetch_object())
    {
      $nombre = $reg->nombre;
      $direccion = $reg->direccion;
      $DNI = $reg->DNI;
      $tipo = $reg->tipo;
      $responsable = $reg->responsable;
      $DNIr = $reg->DNIr;
      $Zona = $reg->Zona;

      $pdf->SetFont('Arial', '', 10);
      $pdf->Row(array(utf8_decode($nombre), $DNI, $tipo, $responsable, $DNIr));
    }

    // Mostramos el documento pdf
    $pdf->Output();
  }
  else
  {
    echo 'No tiene permiso para visualizar el reporte';
  }
}
ob_end_flush();
?>
