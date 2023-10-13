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
if ($_SESSION['ventas']==1)
{
//Incluímos el archivo Factura.php
require('Factura.php');

//Establecemos los datos de la empresa

$logo2 = "2031.png";
$ext_logo2 = "png";

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
require_once "../modelos/Cotizaciones.php";
$venta= new Cotizacion();
$rsptav = $venta->ventacabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();

//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();

//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete(utf8_decode($empresa),
                  $documento."\n" .
                  utf8_decode("").utf8_decode($direccion)."\n".
                  utf8_decode("Teléfono: ").$telefono."\n" .
                  "Email : ".$email,$logo,$ext_logo);
$pdf->fact_dev( utf8_decode("$regv->tipo_comprobante "), "$regv->serie_comprobante-$regv->num_comprobante" );
$pdf->temporaire( "" );
$pdf->addDate( $regv->fecha);

//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse(utf8_decode($regv->cliente),utf8_decode($regv->tipo_documento).": ".$regv->num_documento,"Domicilio: ".utf8_decode($regv->direccion));

$pdf->SetFontSize(10);
$pdf->SetFillColor(240,240,240);
$pdf->SetTextColor(40,40,40);
$pdf->SetDrawColor(255,255,255);
$pdf->SetLineWidth(0.02);
$pdf->SetFont('Arial','B');
$pdf->Cell(23,7,'CODIGO',0,0,'C',1);
$pdf->Cell(108,7,'DESCRIPCION',0,0,'C',1);
$pdf->Cell(21,7,'IMG.',0,0,'C',1);
$pdf->Cell(10,7,'CANT.',0,0,'C',1);
$pdf->Cell(15,7,'P.U.',0,0,'C',1);
$pdf->Cell(15,7,'SUBT.',0,0,'C',1);
$pdf->SetLineWidth(0.02);

$pdf->SetFont('Arial','');
$pdf->SetFillColor(250,250,250);
$pdf->SetTextColor(40,40,40);
$pdf->SetDrawColor(88,88,88);
$pdf->Ln();

//Actualizamos el valor de la coordenada "y", que será la ubicación desde donde empezaremos a mostrar los datos
$y= 68;

//Obtenemos todos los detalles de la venta actual
$rsptad = $venta->ventadetalle($_GET["id"]);

$con=0;

$descuento = 0;

while ($regd = $rsptad->fetch_object()) {
  
            $pdf->Cell(20,7,"$regd->codigo",1,0,'C',1);
            $pdf->Cell(110,7,utf8_decode("$regd->producto - $regd->unidadmedida"),1,0,'L',1);
            $pdf->Cell(20,7, $pdf->Image("../files/productos/"."$regd->imagen", $pdf->GetX()+6, $pdf->GetY()-1, 8.2) ,1,"C");
            $pdf->Cell(10,7,"$regd->cantidad",1,0,'C',1);
            $pdf->Cell(15,7,"$regd->precio_venta",1,0,'C',1);
            $pdf->Cell(15,7,"$regd->subtotal",1,0,'C',1);
            $pdf->Ln();

            $subtotal+=$regd->subtotal;
            $con += 1;

            $descuento+=$regd->descuento;
}

// "IMAGEN" => $pdf->AddImage(,$con)
$pdf->SetLineWidth(0.8);

$pdf->SetFont('Arial','B');
$pdf->Cell(54,65, 'IMPORTE TOTAL CON LETRAS:',0,0,'C');
$pdf->SetFont('Arial','B');
$pdf->Cell(200,10, 'SUBTOTAL:',0,0,'C');
$pdf->SetFont('Arial','');
$pdf->Cell(-144,10, $subtotal,0,0,'C');

$pdf->Ln();

//Convertimos el total en letras
require_once "Letras.php";
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->total_venta,"NUEVOS SOLES"));

$pdf->SetFont('Arial','');
$pdf->Cell(77,2, '',0,0,'C');
$pdf->SetFont('Arial','B');
$pdf->Cell(152,2, 'DESCUENTO:',0,0,'C');
$pdf->SetFont('Arial','');
$pdf->Cell(-94,2, $descuento,0,0,'C');

$pdf->Ln();

$pdf->SetFont('Arial','B');
$pdf->Cell(54,10, '',0,0,'C');
$pdf->SetFont('Arial','B');
$pdf->Cell(191,10, 'TOTAL A PAGAR:',0,0,'C');
$pdf->SetFont('Arial','');
$pdf->Cell(-126,10, round(($regv->total_venta),2),0,0,'C');

$pdf->Ln();

$pdf->SetFont('Arial','');
$pdf->Cell(77,2, '',0,0,'C');
$pdf->SetFont('Arial','B');

$pdf->Ln();

$pdf->SetFont('Arial','');
$pdf->Cell(110,25, "--- ".$con_letra,0,0,'L');

// //Mostramos el impuesto
// $pdf->addTVAs( $regv->impuesto, $subtotal ,$regv->total_venta,"S/ ");
// $pdf->addCadreEurosFrancs("IGV"." $regv->impuesto %");
$pdf->Output("documentos/".utf8_decode("Cotizacion")."-".$regv->num_comprobante.".pdf","F");
$pdf->Output("documentos/".utf8_decode("Cotizacion")."-".$regv->num_comprobante.".pdf","I");



}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>