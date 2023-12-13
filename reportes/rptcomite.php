<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1) 
  session_start();

if (!isset($_SESSION["nombre"]))
{
  echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
}
else
{
if ($_SESSION['configuracion']==1)
{

//Inlcuímos a la clase PDF_MC_Table
require('PDF_MC_Table.php');
 
//Instanciamos la clase para generar el documento pdf
$pdf=new PDF_MC_Table();
 
//Agregamos la primera página al documento pdf
$pdf->AddPage();
 
//Seteamos el inicio del margen superior en 25 pixeles 
$y_axis_initial = 25;
 
//Seteamos el tipo de letra y creamos el título de la página. No es un encabezado no se repetirá
$pdf->SetFont('Arial','B',12);

$pdf->Cell(40,6,'',0,0,'C');
$pdf->Cell(100,6,'LISTA DE COMITE',1,0,'C'); 
$pdf->Ln(10);
 
//Creamos las celdas para los títulos de cada columna y le asignamos un fondo gris y el tipo de letra
$pdf->SetFillColor(232,232,232); 
$pdf->SetFont('Arial','B',10);
$pdf->Cell(58,6,'Nombre',1,0,'C',1);
$pdf->Cell(30,6,'Direccion',1,0,'C',1);
$pdf->Cell(35,6,'Responsable',1,0,'C',1);
$pdf->Cell(32,6,'DNI',1,0,'C',1);
$pdf->Cell(32,6,'Zona',1,0,'C',1);
 
$pdf->Ln(10);
//Comenzamos a crear las filas de los registros según la consulta mysql
require_once "../modelos/Comite.php";
$comite = new Comite();

$rspta = $comite->listar();

//Table with filas y columnas
$pdf->SetWidths(array(58,30,35,32,32));

while($reg= $rspta->fetch_object())
{  
    $nombre = $reg->nombre;
    $direccion=$reg->direccion;
    $responsable=$reg->responsable;
    $DNI=$reg->DNI;
    $Zona=$reg->Zona;
 	
 	$pdf->SetFont('Arial','',10);
    $pdf->Row(array(utf8_decode($nombre),$direccion,$responsable,$DNI,$Zona));
}
 
//Mostramos el documento pdf
$pdf->Output();

?>
<?php
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>