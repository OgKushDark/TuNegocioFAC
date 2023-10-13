<?php
header("Content-type: text/html; charset=utf8");
require_once 'vendor/autoload.php';
use Greenter\Model\Client\Client;

use Greenter\Model\Company\Address;

use Greenter\Model\Company\Company;

use Greenter\Model\Sale\FormaPagos\FormaPagoContado;

use Greenter\Model\Sale\Cuota;

use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;

use Greenter\Model\Sale\Invoice;

use Greenter\Model\Sale\SaleDetail;

use Greenter\Model\Sale\Legend;

use Greenter\Ws\Services\SunatEndpoints;

date_default_timezone_set('America/Lima');

$idVenta = $_GET['idventa'];
$codColab = $_GET['codColab'];
$ruta =1;

$util = Util::getInstance();
$conexion = $util->abrirConexion();   
if ($conexion)
{

    $resultado = mysqli_query($conexion,"SELECT v.idventa, v.serie_comprobante as serieDOC, v.num_comprobante as numDoc,
    c.num_documento as numDocClie,c.nombre as clien,c.direccion as direcClien, 
    v.fecha_hora as fechaVen,cast((v.total_venta) as DECIMAL(11,2)) as importe, v.impuesto as igv, v.ventacredito
    from venta v
    inner join persona c on c.idpersona=v.idcliente
    WHERE v.idventa='".$idVenta."'");
    
    $resultadoexonerada = mysqli_query($conexion,"SELECT cast(sum((dv.precio_venta*dv.cantidad)-dv.descuento) as DECIMAL(11,2)) as importe
    from detalle_venta dv
    inner join producto p on p.idproducto=dv.idproducto
    WHERE dv.idventa='".$idVenta."' and p.proigv='No Gravada'");
    
   // echo ( $idVenta );
  $IdDOV='';
  $mm = "";
 /// echo $resultado;
      if ($resultado) {  
          foreach ($resultado as $column) {
            $IdDOV=$column['idventa'];
            $numeroDOC=$column['numDoc'];
            $serieDOC=$column['serieDOC'];
            $clienNumero=$column['numDocClie'];
            $clien=$column['clien'];
            $direClie=$column['direcClien'];
            $fechaVenta=$column['fechaVen'];
            $importe=$column['importe'];
            $igv=$column['igv'];
            $ventacredito=$column['ventacredito'];
        }   
    }
    $importeNograbada = 0 ;
    if ($resultadoexonerada) {  
          foreach ($resultadoexonerada as $column) {
            $importeNograbada=$column['importe'];
        }   
    }
        $total = $importe;
        $importe = ($importe - $importeNograbada) / 1.18;
        $importeGeneralVentas = ($total - $importeNograbada) - $importe ;

// ECHO $total;
$fg = new FuncionesGlobales();

if (strlen($clienNumero) == 8)
{
    $tdClie='1';
}
else
{
    $tdClie='4';
}

    // Cliente

    $client = new Client();

    $client->setTipoDoc($tdClie)

    ->setNumDoc($clienNumero)

    ->setRznSocial($clien);

    $Ubigeo="150108";
    $Distrito="LIMA";
    $Provincia="LIMA";
    $Departamento="LIMA";
    $Direccion="CAL.LOS NOGALES MZA. C6 LOTE. 8 URB. PASEO DE LA REPUBLICA LIMA - LIMA - CHORRILLOS";
    
    $companyAdress = new Address();
    $companyAdress->setUbigueo($Ubigeo)
        ->setDistrito($Distrito)
        ->setProvincia($Provincia)
        ->setDepartamento($Departamento)
        ->setUrbanizacion('-')
        ->setCodLocal('0000')
        ->setDireccion($Direccion);

    $empresadatos = mysqli_query($conexion,"SELECT * from datos_negocio");
            
    if ($empresadatos) {  
      foreach ($empresadatos as $column) {
        $ruc=$column['documento'];
        $razonSocial=$column['nombre'];
        $NombreComercial=$column['nombre'];
        $estadocertificado=$column['estado_certificado'];
        }   
    }
    
    $company = new Company();
    $company->setRuc($ruc)
    ->setNombreComercial($NombreComercial)
    ->setRazonSocial($razonSocial)
    ->setAddress($companyAdress);

    $resultado2 = mysqli_query($conexion,"SELECT p.idproducto as COD, p.nombre as nombreProd, p.proigv as proigv,
    CASE WHEN p.proigv = 'No Gravada' THEN dv.precio_venta-dv.descuento ELSE CAST((dv.precio_venta-dv.descuento)/1.18 AS DECIMAL(11,2)) END as valorUnitario,
    CAST((dv.precio_venta - dv.descuento) AS DECIMAL(11,2)) AS precioUnitario,
    CAST(dv.cantidad AS DECIMAL(11,3)) as cantidad,
    CASE WHEN p.proigv = 'No Gravada' THEN cast((dv.precio_venta-dv.descuento)*dv.cantidad as DECIMAL(11,2)) ELSE cast((dv.precio_venta-dv.descuento)/ 1.18*dv.cantidad as DECIMAL(11,2)) END as importe,
    CASE WHEN p.proigv = 'No Gravada' THEN '0' ELSE CAST(((dv.precio_venta-dv.descuento)-((dv.precio_venta-dv.descuento)/ 1.18))*dv.cantidad AS DECIMAL(11,2)) END as Igv, dv.descuento

    FROM detalle_venta dv 

    inner join producto p on p.idproducto=dv.idproducto

    WHERE dv.idventa='".$idVenta."'");

    $i=0;

    $invoicbper=0;

    foreach ($resultado2 as $column)
    {
        //echo($column['cantidad']);
        if ($column['nombreProd']=="BOLSA") {
            $item = new SaleDetail();
            $item->setCodProducto($column['COD'])
            ->setUnidad('NIU')
            ->setCantidad($column['cantidad'])
            ->setDescripcion(utf8_decode($column['nombreProd']))
            ->setMtoValorUnitario($column['valorUnitario']) // Sin IGV
            ->setMtoPrecioUnitario($column['precioUnitario']) // Inclui IGV
            ->setMtoValorVenta($column['importe'])
            ->setTipAfeIgv('10')
            ->setMtoBaseIgv($column['importe'])
            ->setPorcentajeIgv(18)
            ->setIgv($column['Igv'])
            ->setIcbper($column['cantidad']*$column['precioUnitario']) // (cantidad)*(factor ICBPER)
            ->setFactorIcbper($column['precioUnitario'])
            ->setTotalImpuestos(($column['cantidad']*$column['precioUnitario'])+$column['Igv']);
    
            $arrayItem[$i] = $item;

            $invoicbper=$column['cantidad']*0.30;

        }
        else{
            
            if  ($column['proigv'] == "Gravada"){
                
                $tipoafecto="10";
                $igv="18";
                $totalImpuestos=$column['Igv'];
                $setIgv=$column['Igv'];
                
            }else if($column['proigv'] == "No Gravada"){

                $tipoafecto="20";
                $igv="0";
                $totalImpuestos="0";
                $setIgv="0";

            }

            $item = new SaleDetail();
                $item->setCodProducto($column['COD'])
                ->setUnidad('NIU')
                ->setCantidad($column['cantidad'])
                ->setDescripcion($column['nombreProd'])
                ->setMtoBaseIgv($column['importe'])
                ->setPorcentajeIgv($igv)
                ->setIgv($setIgv)
                ->setTipAfeIgv($tipoafecto)
                ->setTotalImpuestos($totalImpuestos)
                ->setMtoValorVenta($column['importe'])
                ->setMtoValorUnitario($column['valorUnitario'])
                ->setMtoPrecioUnitario($column['precioUnitario']);
    
            $arrayItem[$i] = $item;
        }

        $i++;
    
    }
    // Venta
    if($ventacredito=="Si"){
        $deuda=mysqli_query($conexion,"SELECT * FROM cuentas_por_cobrar WHERE idventa='".$idVenta."'");

        if($deuda){

            foreach ($deuda as $column){

                $saldo=$column["deudatotal"]-$column["abonototal"];

                $item = new Cuota();

                    $item->setMonto($column["deudatotal"]-$column["abonototal"])
                    ->setFechaPago(new DateTime($column["fechavencimiento"].'-05:00'));
        
                $arrayCuota[$i] = $item;

            }

        }
    }
    $importevalorventa = $importe + $importeNograbada;
    $invoice = new Invoice();
    
    $invoice
    ->setUblVersion('2.1')
    ->setTipoOperacion('0101')
    ->setTipoDoc('03')
    ->setSerie($serieDOC)
    ->setCorrelativo($numeroDOC)
    ->setFechaEmision(new DateTime($fechaVenta));
    if($ventacredito=="No"){

        $invoice->setFormaPago(new FormaPagoContado());

    }else if($ventacredito=="Si"){

        $invoice->setFormaPago(new FormaPagoCredito($saldo));

        $invoice->setCuotas(
            $arrayCuota
        );
    }
    $invoice->setTipoMoneda('PEN')
    ->setClient($client)
    ->setMtoOperExoneradas($importeNograbada)
    ->setMtoOperGravadas($importe)
    ->setMtoIGV($importeGeneralVentas)
    ->setIcbper($invoicbper)
    ->setTotalImpuestos($importeGeneralVentas)
    ->setValorVenta($importevalorventa)
    ->setSubTotal($total)
    ->setMtoImpVenta($total)
    ->setCompany($company);
   // echo("exonerada "+$importeNograbada+" --- Gravada"+$importe);

    mysqli_close($conexion);
$manuel = $fg->numletras($total);
    $legend = new Legend();
    //$legend->setCode('1000')->setValue("UNO CON 00/100 SOLES");

    $legend->setCode('1000')->setValue($manuel);


    $invoice->setDetails($arrayItem);
    
    $invoice->setLegends([$legend]);


        // Envio a SUNAT.

   if  ($estadocertificado=="BETA"){
        $see = $util->getSee(SunatEndpoints::FE_BETA);
    }elseif($estadocertificado=="PRODUCCION"){
        $see = $util->getSee(SunatEndpoints::FE_PRODUCCION);
    }
    $res = $see->send($invoice);
    $util->writeXml($invoice, $see->getFactory()->getLastXml());

    if ($res->isSuccess()) 
    {
        $cdr = $res->getCdrResponse();
        $util->writeCdr($invoice, $res->getCdrZip());

        $util->showResponse($invoice, $cdr,$IdDOV,'DocVenta',$codColab);

        $code = (int)$cdr->getCode();

        if ($code === 0) {
            echo 'ESTADO: ACEPTADA'.PHP_EOL;
            if (count($cdr->getNotes()) > 0) {
                echo 'OBSERVACIONES:'.PHP_EOL;
                // Corregir estas observaciones en siguientes emisiones.
                var_dump($cdr->getNotes());
            }  
        } else if ($code >= 2000 && $code <= 3999) {
            echo 'ESTADO: RECHAZADA'.PHP_EOL;
        } else {
            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
            /*code: 0100 a 1999 */
            echo 'Excepción';
        }

        echo $cdr->getDescription().PHP_EOL;

    } else {

        echo $util->getErrorResponse($res->getError());

    }


        //echo "</br>Conexión Finalizada";
    
}
else{
    echo 'error al conectar';
}

class FuncionesGlobales{
    function IndiceDocumentVenta($Num)
    {
        $newNum='';
        if (($Num/100)>=1) {
            return 'F'.$Num;
        }
        elseif (($Num/10)>=1) {
            $newNum='F0'.$Num;
            return $newNum;
        }
        else{
            $newNum='F00'.$Num;
            return $newNum;
        }
    }

     function numletras($numero)
    {
        $tempnum = explode('.',$numero);

        if ($tempnum[0] !== ""){
            $numf = self::milmillon($tempnum[0]);
            /*if ($numf == "UNO")
            {
                $numf = substr($numf, 0, -1);
            }*/
        if ($numf == "") 
            { 
                $numf = "CERO"; 
            }

            $TextEnd = $numf.' CON ';
        //$TextEnd .= $_nommoneda.' CON ';
        }
        if ($tempnum[0] == "" || $tempnum[0] >= 100)
        {
            $tempnum[0] = "0" ;
        }
        if (empty($tempnum[1])) //empty: Determina si una variable es considerada vac�a. Una variable se considera vac�a si no existe o si su valor es igual a FALSE. empty() no genera una advertencia si la variable no existe.
        {
            $TextEnd .= "00/100 SOLES";
        }
    else if(substr($tempnum[1], 0, -1)!="0" && $tempnum[1] <= "9")
    {
        $TextEnd .= $tempnum[1] ;
            $TextEnd .= "0/100 SOLES";
    }
        else
        {
            $TextEnd .= $tempnum[1] ;
            $TextEnd .= "/100 SOLES";
        }

        return $TextEnd;
    }

    function unidad($numuero){ 
        switch ($numuero) 

        { 

            case 9: 
            {
                $numu = "NUEVE"; 
                break; 
            }
            case 8: 

            { 

                $numu = "OCHO"; 

                break; 

            } 

            case 7: 

            { 

                $numu = "SIETE"; 

                break; 

            } 

            case 6: 

            { 

                $numu = "SEIS"; 

                break; 

            } 

            case 5: 

            { 

                $numu = "CINCO"; 

                break; 

            } 

            case 4: 

            { 

                $numu = "CUATRO"; 

                break; 

            } 

            case 3: 

            { 

                $numu = "TRES"; 

                break; 

            } 

            case 2: 

            { 

                $numu = "DOS"; 

                break; 

            } 

            case 1: 

            {

                $numu = "UNO"; 

                break; 

            } 

            case 0: 

            { 

                $numu = ""; 

                break; 

            } 

        } 

        return $numu; 

    } 



    function decena($numdero){ 



        if ($numdero >= 90 && $numdero <= 99) 

        { 

            $numd = "NOVENTA "; 

            if ($numdero > 90) 

                $numd = $numd."Y ".(self::unidad($numdero - 90)); 

        } 

        else if ($numdero >= 80 && $numdero <= 89) 

        { 

            $numd = "OCHENTA "; 

            if ($numdero > 80) 

                $numd = $numd."Y ".(self::unidad($numdero - 80)); 

        } 

        else if ($numdero >= 70 && $numdero <= 79) 

        { 

            $numd = "SETENTA "; 

            if ($numdero > 70) 

                $numd = $numd."Y ".(self::unidad($numdero - 70)); 

        } 

        else if ($numdero >= 60 && $numdero <= 69) 

        { 

            $numd = "SESENTA "; 

            if ($numdero > 60) 

                $numd = $numd."Y ".(self::unidad($numdero - 60)); 

        } 

        else if ($numdero >= 50 && $numdero <= 59) 

        { 

            $numd = "CINCUENTA "; 

            if ($numdero > 50) 

                $numd = $numd."Y ".(self::unidad($numdero - 50)); 

        } 

        else if ($numdero >= 40 && $numdero <= 49) 

        { 

            $numd = "CUARENTA "; 

            if ($numdero > 40) 

                $numd = $numd."Y ".(self::unidad($numdero - 40)); 

        } 

        else if ($numdero >= 30 && $numdero <= 39) 

        { 

            $numd = "TREINTA "; 

            if ($numdero > 30) 

                $numd = $numd."Y ".(self::unidad($numdero - 30)); 

        } 

        else if ($numdero >= 20 && $numdero <= 29) 

        { 

            if ($numdero == 20) 

                $numd = "VEINTE "; 

            else 

                $numd = "VEINTI".(self::unidad($numdero - 20)); 

        } 

        else if ($numdero >= 10 && $numdero <= 19) 

        { 

            switch ($numdero){ 

                case 10: 

                { 

                    $numd = "DIEZ "; 

                    break; 

                } 

                case 11: 

                { 

                    $numd = "ONCE "; 

                    break; 

                } 

                case 12: 

                { 

                    $numd = "DOCE "; 

                    break; 

                } 

                case 13: 

                { 

                    $numd = "TRECE "; 

                    break; 

                } 

                case 14: 

                { 

                    $numd = "CATORCE "; 

                    break; 

                } 

                case 15: 

                { 

                    $numd = "QUINCE "; 

                    break; 

                } 

                case 16: 

                { 

                    $numd = "DIECISEIS "; 

                    break; 

                } 

                case 17: 

                { 

                    $numd = "DIECISIETE "; 

                    break; 

                } 

                case 18: 

                { 

                    $numd = "DIECIOCHO "; 

                    break; 

                } 

                case 19: 

                { 

                    $numd = "DIECINUEVE "; 

                    break; 

                } 

            } 

        } 

        else 

            $numd = self::unidad($numdero); 

        return $numd; 

    } 



    function centena($numc){ 

        if ($numc >= 100) 

        { 

            if ($numc >= 900 && $numc <= 999) 

            { 

                $numce = "NOVECIENTOS "; 

                if ($numc > 900) 

                    $numce = $numce.(self::decena($numc - 900)); 

            } 

            else if ($numc >= 800 && $numc <= 899) 

            { 

                $numce = "OCHOCIENTOS "; 

                if ($numc > 800) 

                    $numce = $numce.(self::decena($numc - 800)); 

            } 

            else if ($numc >= 700 && $numc <= 799) 

            { 

                $numce = "SETECIENTOS "; 

                if ($numc > 700) 

                    $numce = $numce.(self::decena($numc - 700)); 

            } 

            else if ($numc >= 600 && $numc <= 699) 

            { 

                $numce = "SEISCIENTOS "; 

                if ($numc > 600) 

                    $numce = $numce.(self::decena($numc - 600)); 

            } 

            else if ($numc >= 500 && $numc <= 599) 

            { 

                $numce = "QUINIENTOS "; 

                if ($numc > 500) 

                    $numce = $numce.(self::decena($numc - 500)); 

            } 

            else if ($numc >= 400 && $numc <= 499) 

            { 

                $numce = "CUATROCIENTOS "; 

                if ($numc > 400) 

                    $numce = $numce.(self::decena($numc - 400)); 

            } 

            else if ($numc >= 300 && $numc <= 399) 

            { 

                $numce = "TRESCIENTOS "; 

                if ($numc > 300) 

                    $numce = $numce.(self::decena($numc - 300)); 

            } 

            else if ($numc >= 200 && $numc <= 299) 

            { 

                $numce = "DOSCIENTOS "; 

                if ($numc > 200) 

                    $numce = $numce.(self::decena($numc - 200)); 

            } 

            else if ($numc >= 100 && $numc <= 199) 

            { 

                if ($numc == 100) 

                    $numce = "CIEN "; 

                else 

                    $numce = "CIENTO ".(self::decena($numc - 100)); 

            } 

        } 

        else 

            $numce = self::decena($numc); 



        return $numce; 

    } 



    function miles($nummero){ 

        if ($nummero >= 1000 && $nummero < 2000){ 

            $numm = "MIL ".(self::centena($nummero%1000)); 

        } 

        if ($nummero >= 2000 && $nummero <10000){ 

            $numm = self::unidad(Floor($nummero/1000))." MIL ".(self::centena($nummero%1000)); 

        } 

        if ($nummero < 1000) 

            $numm = self::centena($nummero); 



        return $numm; 

    } 



    function decmiles($numdmero){ 

        if ($numdmero == 10000) 

            $numde = "DIEZ MIL"; 

        if ($numdmero > 10000 && $numdmero <20000){ 

            $numde = self::decena(Floor($numdmero/1000))."MIL ".(self::centena($numdmero%1000)); 

        } 

        if ($numdmero >= 20000 && $numdmero <100000){ 

            $numde = self::decena(Floor($numdmero/1000))." MIL ".(self::miles($numdmero%1000)); 

        } 

        if ($numdmero < 10000) 

            $numde = self::miles($numdmero); 



        return $numde; 

    } 



    function cienmiles($numcmero){ 

        if ($numcmero == 100000) 

            $num_letracm = "CIEN MIL"; 

        if ($numcmero >= 100000 && $numcmero <1000000){ 

            $num_letracm = self::centena(Floor($numcmero/1000))." MIL ".(self::centena($numcmero%1000)); 

        } 

        if ($numcmero < 100000) 

            $num_letracm = self::decmiles($numcmero); 

        return $num_letracm; 

    } 



    function millon($nummiero){ 

        if ($nummiero >= 1000000 && $nummiero <2000000){ 

            $num_letramm = "UN MILLON ".(self::cienmiles($nummiero%1000000)); 

        } 

        if ($nummiero >= 2000000 && $nummiero <10000000){ 

            $num_letramm = self::unidad(Floor($nummiero/1000000))." MILLONES ".(self::cienmiles($nummiero%1000000)); 

        } 

        if ($nummiero < 1000000) 

            $num_letramm = self::cienmiles($nummiero); 



        return $num_letramm; 

    } 



    function decmillon($numerodm){ 

        if ($numerodm == 10000000) 

            $num_letradmm = "DIEZ MILLONES"; 

        if ($numerodm > 10000000 && $numerodm <20000000){ 

            $num_letradmm = self::decena(Floor($numerodm/1000000))."MILLONES ".(self::cienmiles($numerodm%1000000)); 

        } 

        if ($numerodm >= 20000000 && $numerodm <100000000){ 

            $num_letradmm = self::decena(Floor($numerodm/1000000))." MILLONES ".(self::millon($numerodm%1000000)); 

        } 

        if ($numerodm < 10000000) 

            $num_letradmm = self::millon($numerodm); 



        return $num_letradmm; 

    } 



    function cienmillon($numcmeros){ 

        if ($numcmeros == 100000000) 

            $num_letracms = "CIEN MILLONES"; 

        if ($numcmeros >= 100000000 && $numcmeros <1000000000){ 

            $num_letracms = self::centena(Floor($numcmeros/1000000))." MILLONES ".(self::millon($numcmeros%1000000)); 

        } 

        if ($numcmeros < 100000000) 

            $num_letracms = self::decmillon($numcmeros); 

        return $num_letracms; 

    } 



    function milmillon($nummierod){ 

        if ($nummierod >= 1000000000 && $nummierod <2000000000){ 

            $num_letrammd = "MIL ".(self::cienmillon($nummierod%1000000000)); 

        } 

        if ($nummierod >= 2000000000 && $nummierod <10000000000){ 

            $num_letrammd = self::unidad(Floor($nummierod/1000000000))." MIL ".(self::cienmillon($nummierod%1000000000)); 

        } 

        if ($nummierod < 1000000000) 

            $num_letrammd = self::cienmillon($nummierod); 



        return $num_letrammd; 

    }

}
