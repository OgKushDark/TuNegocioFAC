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
if ($_SESSION['compras']==1)
{
//Incluímos el archivo compra.php
require('Compra.php');

//datos de la empresa
require_once "../modelos/Negocio.php";
$cnegocio = new Negocio();
$rsptan = $cnegocio->listar();
$regn=$rsptan->fetch_object();
$empresa = $regn->nombre;
$ndocumento = $regn->ndocumento;
$documento = $regn->documento;
$direccion = $regn->direccion;
$telefono = $regn->telefono;
$email = $regn->email;
$pais = $regn->pais;
$ciudad = $regn->ciudad;
$logo = $regn->logo;

//Obtenemos los datos de la cabecera de la venta actual
require_once "../modelos/Compra.php";
$compra= new Compra();
$rsptav = $compra->ingresocabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();

//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();

//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete(utf8_decode($empresa),
                  utf8_decode("").utf8_decode($documento)."\n" .
                  utf8_decode("").utf8_decode($direccion)."\n".
                  utf8_decode("Teléfono: ").$telefono."\n" .
                  "Email : ".$email,$logo,$ext_logo);
$pdf->fact_dev( "$regv->tipo_comprobante ", "$regv->serie_comprobante-$regv->num_comprobante" );
$pdf->temporaire( "" );
$pdf->addDate( $regv->fecha);

//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse(utf8_decode($regv->proveedor),"Domicilio: ".utf8_decode($regv->direccion),$regv->tipo_documento.": ".$regv->num_documento);

$pdf->SetFontSize(10);
$pdf->SetFillColor(240,240,240);
$pdf->SetTextColor(40,40,40);
$pdf->SetDrawColor(255,255,255);
$pdf->SetLineWidth(0.02);
$pdf->SetFont('Arial','B');
$pdf->Cell(23,7,'CODIGO',0,0,'C',1);
$pdf->Cell(108,7,'DESCRIPCION',0,0,'C',1);
$pdf->Cell(10,7,'CANT.',0,0,'C',1);
$pdf->Cell(15,7,'P.C.',0,0,'C',1);
$pdf->Cell(15,7,'P.V.',0,0,'C',1);
$pdf->Cell(21,7,'SUBTOTAL',0,0,'C',1);
$pdf->SetLineWidth(0.02);

$pdf->SetFont('Arial','');
$pdf->SetFillColor(250,250,250);
$pdf->SetTextColor(40,40,40);
$pdf->SetDrawColor(88,88,88);
$pdf->Ln();

//Obtenemos todos los detalles de la venta actual
$rsptad = $compra->ingresodetalle($_GET["id"]);

$descuento = 0;

while ($regd = $rsptad->fetch_object()) {

            $pdf->Cell(20,7,"$regd->codigo",1,0,'C',1);
            $pdf->Cell(110,7,utf8_decode("$regd->producto - $regd->unidadmedida"),1,0,'L',1);
            $pdf->Cell(10,7,"$regd->cantidad",1,0,'C',1);
            $pdf->Cell(15,7,"$regd->precio_compra",1,0,'C',1);
            $pdf->Cell(15,7,"$regd->precio_venta",1,0,'C',1);
            $pdf->Cell(20,7,"$regd->subtotal",1,0,'C',1);
            $pdf->Ln();

            $subtotal+=$regd->subtotal;

            $descuento+=$regd->descuento;

}

$pdf->SetLineWidth(0.8);

$pdf->SetFont('Arial','B');
$pdf->Cell(54,65, 'IMPORTE TOTAL CON LETRAS:',0,0,'C');
$pdf->SetFont('Arial','B');
$pdf->Cell(201,10, 'SUBTOTAL:',0,0,'C');
$pdf->SetFont('Arial','');
$pdf->Cell(-150,10, $subtotal,0,0,'C');

$pdf->Ln();

$pdf->SetFont('Arial','');
$pdf->Cell(77,2, '',0,0,'C');
$pdf->SetFont('Arial','B');
$pdf->Cell(152,2, 'DESCUENTO:',0,0,'C');
$pdf->SetFont('Arial','');
$pdf->Cell(-98,2, $descuento,0,0,'C');

$pdf->Ln();

$pdf->SetFont('Arial','');
$pdf->Cell(77,2, '',0,0,'C');
$pdf->SetFont('Arial','B');
$pdf->Cell(152,9, 'IGV:',0,0,'C');
$pdf->SetFont('Arial','');
$pdf->Cell(-98,9, $igv = round((($regv->total_compra)*(($regv->impuesto)/($regv->impuesto+100))),2),0,0,'C');

$pdf->Ln();

$pdf->SetFont('Arial','B');
$pdf->Cell(54,10, '',0,0,'C');
$pdf->SetFont('Arial','B');
$pdf->Cell(191,3, 'TOTAL A PAGAR:',0,0,'C');
$pdf->SetFont('Arial','');
$pdf->Cell(-130,3, round(($regv->total_compra),2),0,0,'C');

$pdf->Ln();

$pdf->SetFont('Arial','');
$pdf->Cell(77,2, '',0,0,'C');
$pdf->SetFont('Arial','B');

//Convertimos el total en letras
require_once "Letras.php";
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->total_compra,"NUEVOS SOLES"));

$pdf->SetFont('Arial','');
$pdf->Cell(-25,28, "--- ".$con_letra,0,0,'C');

//Mostramos el impuesto
$pdf->Output('Reporte de Venta','I');


}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>