<?php
//Activamos el almacenamiento en el buffer
ob_start();
if (strlen(session_id()) < 1)
    session_start();

if (!isset($_SESSION["nombre"])) {
    echo 'Debe ingresar al sistema correctamente para visualizar el reporte';
} else {
    if ($_SESSION['ventas'] == 1) {
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
            $V = new EnLetras();
            //Instanaciamos a la clase con el objeto venta
            $venta = new Venta();
            //En el objeto $rspta Obtenemos los valores devueltos del método ventacabecera del modelo
            $rspta = $venta->ventacabecera($_GET["id"]);
            //Recorremos todos los valores obtenidos
            $reg = $rspta->fetch_object();

            //Obtenemos los datos de la cabecera de la venta actual
            require_once "../modelos/CuentasCobrar.php";
            $cc = new CuentasCobrar();
            $rsptacc = $cc->mostrarDeuda($_GET["id"]);
            //Recorremos todos los valores obtenidos
            $regcc = $rsptacc->fetch_object();

            if ($reg->ventacredito == "Si") {
                $formaPago = "CRÉDITO";
            } else {
                $formaPago = "CONTADO";
            }

            //datos de la empresa
            require_once "../modelos/Negocio.php";
            $cnegocio = new Negocio();
            $rsptan = $cnegocio->listar();
            $regn = $rsptan->fetch_object();
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
                <table border="0" align="center" width="300px">

                    <td colspan="4" align="center">

                        <img src="../reportes/<?php echo $imagen; ?>" width="100" height="100">

                    </td>

                    <tr>
                        <td align="center">

                            <!-- Mostramos los datos de la empresa en el documento HTML -->
                            <strong>
                                <h2><?php echo $empresa; ?></h2>
                            </strong><br>
                            <?php echo $ndocumento; ?>: <?php echo $documento; ?><br>
                            <?php echo $direccion; ?><br>
                            <?php echo 'Celular: ' . $telefono; ?><br>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">

                            <?php

                            if ($reg->tipo_comprobante == "NC") {

                            ?>

                                <strong>
                                    <font size="3">Nota de Crédito<br>

                                        <?php echo $reg->serie_comprobante . " - " . $reg->num_comprobante; ?>

                                    </font>
                                </strong>


                            <?php

                            } else if ($reg->tipo_comprobante == "Boleta") {

                            ?>

                                <strong>
                                    <font size="3"><?php echo $reg->tipo_comprobante; ?> de Venta Electrónica<br>

                                        <?php echo $reg->serie_comprobante . " - " . $reg->num_comprobante; ?>

                                    </font>
                                </strong>


                            <?php

                            } else {


                            ?>

                                <strong>
                                    <font size="3"><?php echo $reg->tipo_comprobante; ?> Electrónica<br>

                                        <?php echo $reg->serie_comprobante . " - " . $reg->num_comprobante; ?>

                                    </font>
                                </strong>

                            <?php


                            }

                            ?>


                        </td>
                    </tr>
                    <tr>

                    </tr>
                    <tr>
                        <td align="center"></td>
                    </tr>
                    <tr>
                        <!-- Mostramos los datos del cliente en el documento HTML -->
                        <td>FECHA: <?php echo $reg->fecha; ?></td>
                    </tr>
                    <tr>
                        <!-- Mostramos los datos del cliente en el documento HTML -->
                        <td>CLIENTE: <?php echo $reg->cliente; ?></td>
                    </tr>
                    <tr>
                        <!-- Mostramos los datos del cliente en el documento HTML -->
                        <td>DIRECCIÓN: <?php echo $reg->direccion; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $reg->tipo_documento . ": " . $reg->num_documento; ?></td>
                    </tr>
                    <tr>
                        <td>FORMA DE PAGO: <?php echo $formaPago; ?></td>
                    </tr>
                    <?php

                    if ($regcc != "") {

                    ?>

                        <tr>
                            <td>DEUDA: S/. <?php echo $regcc->deudatotal - $regcc->abonototal; ?></td>
                        </tr>

                    <?php

                    }

                    ?>
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
                    $cantidad = 0;
                    $total = 0;
                    $subtotal = 0;
                    $descuento = 0;
                    while ($regd = $rsptad->fetch_object()) {
                        if ($regd->proigv == "No Gravada") {
                            $exonerado = $regd->cantidad * $regd->precio_venta;
                        } else {
                            $exonerado = 0;
                        }
                        echo "<tr>";
                        echo "<td>" . $regd->cantidad . "</td>";
                        echo "<td>" . $regd->producto . " - " . $regd->unidadmedida;
                        echo "<td>" . $regd->precio_venta;
                        echo "<td align='right'>S/ " . $regd->subtotal . "</td>";
                        echo "</tr>";
                        $cantidad += $regd->cantidad;
                        $subtotal += $regd->subtotal;
                        $descuento += $regd->descuento;
                    }
                    ?>
                    <!-- Mostramos los totales de la venta en el documento HTML -->

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right"><b>SUBTOTAL:</b></td>
                        <td align="right"><b>S/ <?php
                                                echo $subtotal;
                                                ?></b>
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right"><b>DESCUENTO:</b></td>
                        <td align="right"><b>S/ <?php
                                                echo $descuento;
                                                ?></b>
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right"><b>OP. GRAV:</b></td>
                        <td align="right"><b>S/ <?php
                                                $xd = round((($reg->total_venta - $exonerado) * (($reg->impuesto) / ($reg->impuesto + 100))), 2);
                                                echo ($reg->total_venta - $exonerado) - $xd;
                                                ?></b>
                        </td>
                    </tr>

                    <?php

                    if ($exonerado != 0) {



                    ?>



                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td align="right"><b>EXONERADO:</b></td>
                            <td align="right"><b>S/ <?php
                                                    echo $exonerado;
                                                    ?></b>
                            </td>
                        </tr>



                    <?php
                    }

                    ?>

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right"><b>IGV(18%):</b></td>
                        <td align="right"><b>S/ <?php
                                                $igv = round((($reg->total_venta - $exonerado) * (($reg->impuesto) / ($reg->impuesto + 100))), 2);
                                                echo $igv;
                                                ?></b>
                        </td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td align="right"><b>TOTAL:</b></td>
                        <td align="right"><b>S/ <?php echo $reg->total_venta;  ?></b>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4">
                            <br>
                            SON: <?php
                                    echo $con_letra = strtoupper($V->ValorEnLetras($reg->total_venta, "NUEVOS SOLES"));
                                    ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="4" align="center">
                            <?php

                            if ($reg->tipo_comprobante == 'Boleta') {
                                $iddoc = '01';
                                $iddocCliente = '6';
                            } else if ($reg->tipo_comprobante == 'Factura') {
                                $iddoc = "03";
                                if (strlen($reg->num_documento) == 8) {
                                    $iddocCliente = "1";
                                } else {
                                    $iddocCliente = "4";
                                }
                            } else {
                                $iddoc = '07';
                                $iddocCliente = '6';
                            }

                            $texto = $documento . "|" . $iddoc . "|" . $reg->serie_comprobante . "|" . $reg->num_comprobante . "|" . $igv . "|" . $reg->total_venta . "|" . $reg->fecha . "|" . $iddocCliente . "|" . $reg->num_documento . "|";

                            if (file_exists("../phpqrcode/qrlib.php")) {
                                require "../phpqrcode/qrlib.php";

                                $ruta_qr = 'qr/' . 'img.png';

                                $tamaño = 10;

                                $level = "Q";

                                $framSize = 3;

                                QRcode::png($texto, $ruta_qr, $level, $tamaño, $framSize);

                                if (file_exists($ruta_qr)) {
                                    $error = 0;
                                    $mensaje = "Archivo QR, generado";
                                }
                            } else {
                                $error = 1;
                                $mensaje = "No Existe la libreria";
                            }

                            ?>
                            <br><img src="qr/img.png" width="140" height="140">
                            <br>


                            <?php

                            if ($reg->tipo_comprobante != "Nota") {

                            ?>

                                Representación Impresa de la <?php echo $reg->tipo_comprobante; ?> Electrónica

                            <?php

                            }

                            ?>


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

                </table>
                <br>
            </div>
            <p>&nbsp;</p>

        </body>

        </html>
<?php
    } else {
        echo 'No tiene permiso para visualizar el reporte';
    }
}
ob_end_flush();
?>