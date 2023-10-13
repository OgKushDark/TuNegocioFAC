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
require_once "../modelos/Venta.php";
$venta= new Venta();
$rsptav = $venta->ventacabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$regv = $rsptav->fetch_object();

//Obtenemos los datos de la cabecera de la venta actual
require_once "../modelos/CuentasCobrar.php";
$cc= new CuentasCobrar();
$rsptacc = $cc->mostrarDeuda($_GET["id"]);
//Recorremos todos los valores obtenidos
$regcc = $rsptacc->fetch_object();

//Establecemos la configuración de la factura
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();

//Enviamos los datos de la empresa al método addSociete de la clase Factura
$pdf->addSociete(utf8_decode($empresa),
                  $documento."\n" .
                  utf8_decode("").utf8_decode($direccion)."\n".
                  utf8_decode("Teléfono: ").$telefono."\n" .
                  "Email : ".$email,$logo,$ext_logo);
$pdf->fact_dev( "$regv->tipo_comprobante ", "$regv->serie_comprobante-$regv->num_comprobante" );
$pdf->temporaire( "" );
$pdf->addDate( $regv->fecha);

//Enviamos los datos del cliente al método addClientAdresse de la clase Factura
$pdf->addClientAdresse(utf8_decode($regv->cliente),$regv->tipo_documento.": ".$regv->num_documento,"DOMICILIO: ".utf8_decode($regv->direccion));

if($regv->ventacredito == "Si"){
  $formaPago="CRÉDITO";
}else{
  $formaPago="CONTADO";
}

if($regv->ventacredito == "Si"){
  $pdf->addClientAdresse2(utf8_decode("OBSERVACIONES: "), "- Forma de Pago: ". utf8_decode($formaPago));
  $pdf->addClientAdresse3("- Cuota 1: ". "S/.".utf8_decode($regcc->deudatotal-$regcc->abonototal));
  $pdf->addClientAdresse4("- Fecha de Pago: ". utf8_decode($regcc->fechavencimiento));
  $pdf->Ln();  
}else{
  $pdf->addClientAdresse2(utf8_decode("OBSERVACIONES: "), "- Forma de Pago: ". utf8_decode($formaPago));
  $pdf->Ln();
  $pdf->Ln();
}
$pdf->Ln();


$pdf->SetFontSize(10);
$pdf->SetFillColor(240,240,240);
$pdf->SetTextColor(40,40,40);
$pdf->SetDrawColor(255,255,255);
$pdf->SetLineWidth(0.02);
$pdf->SetFont('Arial','B');
$pdf->Cell(23,7,'CODIGO',0,0,'C',1);
$pdf->Cell(108,7,'DESCRIPCION',0,0,'C',1);
$pdf->Cell(10,7,'CANT.',0,0,'C',1);
$pdf->Cell(15,7,'P.U.',0,0,'C',1);
$pdf->Cell(15,7,'DESC.',0,0,'C',1);
$pdf->Cell(21,7,'SUBTOTAL',0,0,'C',1);
$pdf->SetLineWidth(0.02);

$pdf->SetFont('Arial','');
$pdf->SetFillColor(250,250,250);
$pdf->SetTextColor(40,40,40);
$pdf->SetDrawColor(88,88,88);
$pdf->Ln();


//Obtenemos todos los detalles de la venta actual
$rsptad = $venta->ventadetallePDF($_GET["id"]);

$descuento = 0;

while ($regd = $rsptad->fetch_object()) {

            if($regd->proigv=="No Gravada"){
                $exonerado=$regd->cantidad*$regd->precio_venta;
            }else{
                $exonerado=0;
            }

            $pdf->Cell(30,7,"$regd->codigo",1,0,'C',1);
            $pdf->Cell(102,7,utf8_decode("$regd->producto - $regd->unidadmedida"),1,0,'L',1);
            $pdf->Cell(10,7,"$regd->cantidad",1,0,'C',1);
            $pdf->Cell(15,7,"$regd->precio_venta",1,0,'C',1);
            $pdf->Cell(15,7,"$regd->descuento",1,0,'C',1);
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

$xd=round((($regv->total_venta-$exonerado)*(($regv->impuesto)/($regv->impuesto+100))),2);

$pdf->SetFont('Arial','');
$pdf->Cell(77,2, '',0,0,'C');
$pdf->SetFont('Arial','B');
$pdf->Cell(150,10, 'OP GRAVADA:',0,0,'C');
$pdf->SetFont('Arial','');
$pdf->Cell(-94,10, ($regv->total_venta-$exonerado)-$xd,0,0,'C');

$pdf->Ln();

$pdf->SetFont('Arial','');
$pdf->Cell(77,2, '',0,0,'C');
$pdf->SetFont('Arial','B');
$pdf->Cell(151,2, 'EXONERADO:',0,0,'C');
$pdf->SetFont('Arial','');
$pdf->Cell(-96,2, $exonerado,0,0,'C');

$pdf->Ln();

$pdf->SetFont('Arial','');
$pdf->Cell(77,2, '',0,0,'C');
$pdf->SetFont('Arial','B');
$pdf->Cell(152,9, 'IGV:',0,0,'C');
$pdf->SetFont('Arial','');
$pdf->Cell(-98,9, $igv = round((($regv->total_venta-$exonerado)*(($regv->impuesto)/($regv->impuesto+100))),2),0,0,'C');

$pdf->Ln();

$pdf->SetFont('Arial','B');
$pdf->Cell(54,10, '',0,0,'C');
$pdf->SetFont('Arial','B');
$pdf->Cell(191,3, 'TOTAL A PAGAR:',0,0,'C');
$pdf->SetFont('Arial','');
$pdf->Cell(-130,3, round(($regv->total_venta),2),0,0,'C');

$pdf->Ln();

$pdf->SetFont('Arial','');
$pdf->Cell(77,2, '',0,0,'C');
$pdf->SetFont('Arial','B');

$pdf->Ln();
$pdf->Ln();

if($regv->tipo_comprobante=='Boleta'){
    $iddoc='01';
    $iddocCliente='6';
}else if($regv->tipo_comprobante=='Factura'){
    $iddoc="03";
    if(strlen($regv->num_documento)==8){
      $iddocCliente="1";
    }else{
      $iddocCliente="4";
    }
}else{
    $iddoc='07';
    $iddocCliente='6';
}

$texto= $documento."|".$iddoc."|".$regv->serie_comprobante."|".$regv->num_comprobante."|".$igv."|".$regv->total_venta."|".$regv->fecha."|".$iddocCliente."|".$regv->num_documento."|";

if(file_exists("../phpqrcode/qrlib.php")){
    require "../phpqrcode/qrlib.php";

    $ruta_qr = 'qr/'.'img2.png';

    $tamaño = 10;

    $level = "Q";

    $framSize = 3;

    QRcode::png($texto, $ruta_qr, $level, $tamaño, $framSize);

    if(file_exists($ruta_qr)){
        $error=0;
        $mensaje="Archivo QR, generado";
    }

}else{
    $error=1;
    $mensaje="No Existe la libreria";
}

$pdf->Image("./qr/img2.png", $pdf->GetX(), $pdf->GetY()+5, 30);
$pdf->SetFont('Arial','');
$pdf->Cell(76,72, utf8_decode('Representación Impresa de la ') .$regv->tipo_comprobante . utf8_decode(" Electrónica"),0,0,'C');

//Convertimos el total en letras
require_once "Letras.php";
$V=new EnLetras(); 
$con_letra=strtoupper($V->ValorEnLetras($regv->total_venta,"NUEVOS SOLES"));

$pdf->SetFont('Arial','');
$pdf->Cell(-40,-5, "--- ".$con_letra,0,0,'C');

$pdf->Output("documentos/".utf8_decode($regv->tipo_comprobante)."-".$regv->num_comprobante.".pdf","F");
$pdf->Output("documentos/".utf8_decode($regv->tipo_comprobante)."-".$regv->num_comprobante.".pdf","I");



}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>