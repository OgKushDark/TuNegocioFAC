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
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="../public/css/ticket.css" rel="stylesheet" type="text/css">
</head>
<body onload="window.print();">
<?php

//Incluímos la clase Venta
require_once "../modelos/Venta.php";
require_once "Letras.php";
$V=new EnLetras(); 
//Instanaciamos a la clase con el objeto venta
$venta = new Venta();
//En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
$rspta = $venta->ventacabecera($_GET["id"]);
//Recorremos todos los valores obtenidos
$reg = $rspta->fetch_object();

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
$imagen = $regn->logo;

?>
<div class="zona_impresion">
<!-- codigo imprimir -->
<br>
<table border="0" align="center" width="300px">

    <td colspan="4" align="center">        
        <br>

        <img src="../reportes/<?php echo $imagen; ?>" width="100" height="100">
        
        <br><br>
    </td>

    <tr>
        <td align="center">

        <!-- Mostramos los datos de la empresa en el documento HTML -->
        <strong> <h2><?php echo $empresa; ?></h2></strong><br>    
        <?php echo $ndocumento; ?>: <?php echo $documento; ?><br>
        <?php echo $direccion; ?><br>
        <?php echo 'Celular: '. $telefono; ?><br>
        </td>
    </tr>
    <tr>
        <td align="center">

            <strong><font size="3"><?php echo $reg->tipo_comprobante; ?> de Venta<br>
                
             <?php echo $reg->serie_comprobante." - ".$reg->num_comprobante ; ?>  
                
                </font></strong>
       </td>
    </tr>
    <tr>
        
    </tr>
    <tr>
      <td align="center"></td>
    </tr>
    <tr>
        <!-- Mostramos los datos del cliente en el documento HTML -->
        <td>Legajo: 0000<?php echo $reg->idcliente; ?></td>
    </tr>
    <tr>
        <!-- Mostramos los datos del cliente en el documento HTML -->
        <td>Fecha: <?php echo $reg->fecha; ?></td>
    </tr>
    <tr>
        <!-- Mostramos los datos del cliente en el documento HTML -->
        <td>Cliente: <?php echo $reg->cliente; ?></td>
    </tr>
    <tr>
        <!-- Mostramos los datos del cliente en el documento HTML -->
        <td>Dirección: <?php echo $reg->direccion; ?></td>
    </tr>
    <tr>
        <td><?php echo $reg->tipo_documento.": ".$reg->num_documento; ?></td>
    </tr>
    <tr>
        
    </tr>    
</table>
<br>
<!-- Mostramos los detalles de la venta en el documento HTML -->
<table border="0" align="center" width="320px">
    <tr>
        <td><b>CANT.</b></td>
        <td><b>DESCRIPCIÓN</b></td>
        <td><b>P. UNIT</b></td>
        <td align="right"><b>IMPORTE</b></td>
    </tr>
    <tr>
      <td colspan="4">=============================================</td>
    </tr>
    <?php
    $rsptad = $venta->ventadetalle($_GET["id"]);
    $cantidad=0;
    $total = 0;
    $subtotal = 0;
    while ($regd = $rsptad->fetch_object()) {
        echo "<tr>";
        echo "<td>".$regd->cantidad."</td>";
        echo "<td>".$regd->producto;
        echo "<td>".$regd->precio_venta;
        echo "<td align='right'>S/ ".$regd->subtotal."</td>";
        echo "</tr>";
        $cantidad+=$regd->cantidad;
        $subtotal+=$regd->subtotal;
    }
    ?>
    <!-- Mostramos los totales de la venta en el documento HTML -->

    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><b>SUBTOTAL:</b></td>
    <td align="right"><b>S/  <?php
        echo $subtotal;  
        ?></b>
    </td>
    </tr>

    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><b>DESCUENTO:</b></td>
    <td align="right"><b>S/  <?php
        $xd=round(($subtotal-(($reg->total_venta))),2); 
        echo $xd;  
        ?></b>
    </td>
    </tr>

    <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><b>OP. GRAV:</b></td>
    <td align="right"><b>S/  <?php
        $xd=round(($reg->total_venta*(($reg->impuesto)/($reg->impuesto+100))),2); 
        echo $reg->total_venta-$xd;  
        ?></b>
    </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><b>IGV(18%):</b></td>
        <td align="right"><b>S/  <?php
          $igv=round(($reg->total_venta*(($reg->impuesto)/($reg->impuesto+100))),2);
          echo $igv;
        ?></b>
        </td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><b>TOTAL:</b></td>
        <td align="right"><b>S/  <?php echo $reg->total_venta;  ?></b>
        </td>
    </tr>

    <tr>
        <td colspan="4">
        <br> 
                        SON: <?php 
                        echo $con_letra=strtoupper($V->ValorEnLetras($reg->total_venta,"NUEVOS SOLES")); 
                        ?> 
        </td>
    </tr>

    <tr>
    <td colspan="4" align="center">rZXl92gf7fJ+YiH4XBq4wh/mcg0=        
        <br><img src="../files/qr/2031.png" width="50" height="50">
    </td>
    </tr>

    <tr>
      <td colspan="3">Nº de productos: <?php echo $cantidad; ?></td>
    </tr>
    <tr>
      <td colspan="4" align="center">&nbsp;</td>
    </tr>      
    <tr>
      <td colspan="4" align="center"><b>¡Gracias por su compra!</b></td>
    </tr>
    <tr>
      <td colspan="4" align="center">Tu Negocio</td>
    </tr>
    <tr>
      <td colspan="4" align="center">Lima - Perú</td>
    </tr>
    
</table>
<br>
</div>
<p>&nbsp;</p>

</body>
</html>
<?php 
}
else
{
  echo 'No tiene permiso para visualizar el reporte';
}

}
ob_end_flush();
?>