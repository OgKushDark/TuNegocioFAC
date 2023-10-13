<?php 
require_once "../modelos/Venta.php";
if (strlen(session_id())<1) 
session_start();

$venta = new Venta();

$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idpersonal=$_SESSION["idpersonal"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";

$tipopago=isset($_POST["tipopago"])? limpiarCadena($_POST["tipopago"]):"";
$formapago=isset($_POST["formapago"])? limpiarCadena($_POST["formapago"]):"";
$nroOperacion=isset($_POST["nroOperacion"])? limpiarCadena($_POST["nroOperacion"]):"";
$fechaDepostivo=isset($_POST["fechaDepostivo"])? limpiarCadena($_POST["fechaDepostivo"]):"";
$porcentaje=isset($_POST["porcentaje"])? limpiarCadena($_POST["porcentaje"]):"";
$totalrecibido=isset($_POST["totalrecibido"])? limpiarCadena($_POST["totalrecibido"]):"";
$vuelto=isset($_POST["vuelto"])? limpiarCadena($_POST["vuelto"]):"";

$fechaOperacion=isset($_POST["fechaOperacion"])? limpiarCadena($_POST["fechaOperacion"]):"";
$montoDeuda=isset($_POST["montoDeuda"])? limpiarCadena($_POST["montoDeuda"]):"";
$montoPagado=isset($_POST["montoPagado"])? limpiarCadena($_POST["montoPagado"]):"";

$idmotivo=isset($_POST["idmotivo"])? limpiarCadena($_POST["idmotivo"]):"";

$comprobanteReferencia=isset($_POST["comprobanteReferencia"])? limpiarCadena($_POST["comprobanteReferencia"]):"";

$observaciones=isset($_POST["observaciones"])? limpiarCadena($_POST["observaciones"]):"";

require_once "../modelos/Persona.php";

$persona=new Persona();

$idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
$tipo_persona=isset($_POST["tipo_persona"])? limpiarCadena($_POST["tipo_persona"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";

switch ($_GET["op"]) {

	case 'guardaryeditar':

	if (empty($idventa)) {
		$rspta=$venta->insertar($idcliente,$idpersonal,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha,$impuesto,$total_venta,$tipopago,$formapago,$nroOperacion,$fechaDepostivo,$porcentaje,$totalrecibido,$vuelto,$_POST["idproducto"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"],$fechaOperacion,$montoDeuda,$montoPagado,$comprobanteReferencia,$idmotivo,$observaciones); 
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
		$rspta=$venta->editar($idventa,$idcliente,$idpersonal,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha,$impuesto,$total_venta,$tipopago,$formapago,$nroOperacion,$fechaDepostivo,$porcentaje,$totalrecibido,$vuelto,$_POST["idproducto"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"],$fechaOperacion,$montoDeuda,$montoPagado,$estado,$comprobanteReferencia);
        echo $rspta ? "Venta actuzalizada" : "Venta no se puedo actualizar";
	}
	
	break;

	case 'guardarCliente':
		if (empty($idpersona)){
			$rspta=$persona->insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$fecha_hora);
			echo $rspta ? "Cliente registrado" : "Cliente no se pudo registrar";
		}
	break;
	

	case 'anular':
		$rspta=$venta->anular($idventa);
		echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el ingreso";
		break;
	
	case 'mostrar':
		$rspta=$venta->mostrar($idventa);
		echo json_encode($rspta);
		break;

		case 'mostrardetalle':

		//recibimos el idventa
		$id=$_GET['id'];

		$rspta=$venta->mostrardetalle($id);
		$total=0;
		$c=1;
		while ($reg=$rspta->fetch_object()) {

			if($c == 1){

				echo 'Pedido N° ';

				echo $reg->num_comprobante;

				echo ', CLIENTE: ';

				echo $reg->cliente;

				echo ',  LISTA DE PEDIDO: ';

			}

			echo '('.$c.')';
			echo '. '.$reg->nombre. ',  CANTIDAD:  ' .$reg->cantidad. '     ';
			$c=$c+1;
		}

		break;

		//_______________________________________________________________________________________________________
	//opcion para mostrar la numeracion y la serie_comprobante de la factura
	case 'mostrarf':
	//mostrando el numero de factura de la tabla comprobantes
	require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->mostrar_numero_factura();
			$data=Array();
			while ($reg=$rspta->fetch_object()) {
				$data[]=array(
            	$num_comp=$reg->num_comprobante
              	);
				}
				$numero_fac_comp = (int)$num_comp;
//fin de mostrar numero de factura de la tabla comprobantes

			$rspta=$venta->numero_venta();
			$data=Array();
			$numerof=$numero_fac_comp;
			while ($reg=$rspta->fetch_object()) {
				$data[]=array(
            	$numerof=$reg->num_comprobante
              	);
				}
				$numero_factura = (int)$numerof;
				$new_factura='';

		if($numero_factura==9999999 or empty($numerof)){
			$new_factura='0000001';
			$numero_nuevo = (int)$new_factura;
			echo json_encode($numero_nuevo);
		}elseif($numerof==9999999){
			$new_factura='0000001';
			$numero_nuevo = (int)$new_factura;
			echo json_encode($numero_nuevo);

		}else{
			$sumafact=$numero_factura+1;
			echo json_encode($sumafact);
		} 
		//$num = (int)$numerof; 
		//echo json_encode($numerof);
		break;

	case 'mostrars':

	//mostrando el numero de factura de la tabla comprobantes
	require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->mostrar_serie_factura();
			$data=Array();
			while ($reg=$rspta->fetch_object()) {
				$data[]=array(
				$serie_comp=$reg->serie_comprobante,
				$num_comp=$reg->num_comprobante
              	);
				}
				$serie_fac_comp = (int)$serie_comp;
				$num_fac_comp = (int)$num_comp;
//fin de mostrar numero de factura de la tabla comprobantes
				$rspta=$venta->numero_serie(); 
				$data=Array();
				$numeros=$serie_fac_comp;
				$numerofa=$num_fac_comp;

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            $numeros=$reg->serie_comprobante,
            $numerofa=$reg->num_comprobante
              );
		}
		$nums = (int)$numeros;
		$nuew_serie=0;
		$numf = (int)$numerofa;
		if($numf==9999999 or empty($numerofa)){
			$nuew_serie=$nums+1;
			echo json_encode($nuew_serie);
		}else{
			echo json_encode($nums);
		} 
		break;//opcion para mostrar la numeracion y la serie_comprobante de la factura

		//opcion para mostrar la numeracion y la serie_comprobante de la boleta
		case 'mostrar_num_boleta':
		//mostrando el numero de boleta de la tabla comprobantes
			require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->mostrar_numero_boleta();
			$data=Array();
			while ($reg=$rspta->fetch_object()) {
				$data[]=array(
            	$num_comp=$reg->num_comprobante
              	);
				}
				$numero_bol_comp = (int)$num_comp;
		//fin de mostrar numero de boleta de la tabla comprobantes

		$rspta=$venta->numero_venta_boleta();
		$data=Array();
		$numerob=$numero_bol_comp;

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            $numerob=$reg->num_comprobante
              );
		}
		$numero_boleta = (int)$numerob;
		$new_boleta='';

		if($numero_boleta==9999999 or empty($numerob)){
			$new_boleta='0000001';
			echo json_encode($new_boleta);
		}elseif($numerob==9999999){
			$new_boleta='0000001';
			echo json_encode($new_boleta);

		}else{
			$sumabol=$numero_boleta+1;
			echo json_encode($sumabol);
		} 
		//$num = (int)$numerof; 
		//echo json_encode($numerof);
		break;
		case 'mostrar_serie_boleta':
		//mostrando el numero de factura de la tabla comprobantes
	require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->mostrar_serie_boleta();
			$data=Array();
			while ($reg=$rspta->fetch_object()) {
				$data[]=array(
				$serie_comp_bol=$reg->serie_comprobante,
				$num_comp_bol=$reg->num_comprobante
              	);
				}
				$serie_bol_comp = (int)$serie_comp_bol;
				$num_bol_comp = (int)$num_comp_bol;
//fin de mostrar numero de factura de la tabla comprobantes
		$rspta=$venta->numero_serie_boleta();
		$data=Array();
		$numero_s_bol=$serie_bol_comp;
		$numero_bol=$num_bol_comp;

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            $numero_s_bol=$reg->serie_comprobante,
            $numero_bol=$reg->num_comprobante
              );
		}
		$nums_bol = (int)$numero_s_bol;
		$nuew_serie_bol=0;
		$numb = (int)$numero_bol;
		if($numb==9999999 or empty($numero_s_bol)){
			$nuew_serie_bol=$nums_bol+1;
			echo json_encode($nuew_serie_bol);
		}else{
			echo json_encode($nums_bol);
		} 
		break;//fin de opcion de mostrar num_comprobante y serie_comprobante de boleta

		//opcion para mostrar la numeracion y la serie_comprobante de la ticket
		case 'mostrar_num_ticket':
		//mostrando el numero de boleta de la tabla comprobantes
			require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->mostrar_numero_ticket();
			$data=Array();
			while ($reg=$rspta->fetch_object()) {
				$data[]=array(
            	$num_comp_tic=$reg->num_comprobante
              	);
				}
				$numero_tic_comp = (int)$num_comp_tic;
		//fin de mostrar numero de boleta de la tabla comprobantes
		$rspta=$venta->numero_venta_ticket();
		$data=Array();
		$numerot=$numero_tic_comp;

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            $numerot=$reg->num_comprobante
              );
		}
		$numero_ticket = (int)$numerot;
		$new_ticket='';

		if($numero_ticket==9999999 or empty($numerot)){
			$new_ticket='0000001';
			echo json_encode($new_ticket);
		}elseif($numerot==9999999){
			$new_ticket='0000001';
			echo json_encode($new_ticket);

		}else{
			$sumatic=$numero_ticket+1;
			echo json_encode($sumatic);
		} 
		//$num = (int)$numerof; 
		//echo json_encode($numerof);
		break;
	case 'mostrar_s_ticket':
	//mostrando el numero de factura de la tabla comprobantes
	require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->mostrar_serie_ticket();
			$data=Array();
			while ($reg=$rspta->fetch_object()) {
				$data[]=array(
				$serie_comp_tic=$reg->serie_comprobante,
				$num_comp_tic=$reg->num_comprobante
              	);
				}
				$serie_tic_comp = (int)$serie_comp_tic;
				$num_tic_comp = (int)$num_comp_tic;
//fin de mostrar numero de factura de la tabla comprobantes
		$rspta=$venta->numero_serie_ticket();
		$data=Array();
		$numero_s_tic=$serie_tic_comp;
		$numero_bolet=$num_tic_comp;

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            $numero_s_tic=$reg->serie_comprobante,
            $numero_bolet=$reg->num_comprobante
              );
		}
		$num_s_ticket = (int)$numero_s_tic;
		$nuew_serie_ticket=0;
		$numbo = (int)$numero_bolet;
		if($numbo==9999999 or empty($numero_s_tic)){
			$nuew_serie_ticket=$num_s_ticket+1;
			echo json_encode($nuew_serie_ticket);
		}else{
			echo json_encode($num_s_ticket);
		} 
		break;//fin de opcion de mostrar num_comprobante y serie_comprobante del ticket

		//opcion para mostrar la numeracion y la serie_comprobante de la boleta
		case 'mostrar_num_nc':
		//mostrando el numero de boleta de la tabla comprobantes
			require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->mostrar_numero_nc();
			$data=Array();
			while ($reg=$rspta->fetch_object()) {
				$data[]=array(
            	$num_comp=$reg->num_comprobante
              	);
				}
				$numero_bol_comp = (int)$num_comp;
		//fin de mostrar numero de boleta de la tabla comprobantes

		$rspta=$venta->numero_venta_nc();
		$data=Array();
		$numerob=$numero_bol_comp;

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            $numerob=$reg->num_comprobante
              );
		}
		$numero_boleta = (int)$numerob;
		$new_boleta='';

		if($numero_boleta==9999999 or empty($numerob)){
			$new_boleta='0000001';
			echo json_encode($new_boleta);
		}elseif($numerob==9999999){
			$new_boleta='0000001';
			echo json_encode($new_boleta);

		}else{
			$sumabol=$numero_boleta+1;
			echo json_encode($sumabol);
		} 
		//$num = (int)$numerof; 
		//echo json_encode($numerof);
		break;

		case 'mostrar_serie_nc':
			//mostrando el numero de factura de la tabla comprobantes
		require_once "../modelos/Comprobantes.php";
				$comprobantes=new Comprobantes();
	
				$rspta=$comprobantes->mostrar_serie_nc();
				$data=Array();
				while ($reg=$rspta->fetch_object()) {
					$data[]=array(
					$serie_comp_bol=$reg->serie_comprobante,
					$num_comp_bol=$reg->num_comprobante
					  );
					}
					$serie_bol_comp = (int)$serie_comp_bol;
					$num_bol_comp = (int)$num_comp_bol;
	//fin de mostrar numero de factura de la tabla comprobantes
			$rspta=$venta->numero_serie_nc();
			$data=Array();
			$numero_s_bol=$serie_bol_comp;
			$numero_bol=$num_bol_comp;
	
			while ($reg=$rspta->fetch_object()) {
				$data[]=array(
				$numero_s_bol=$reg->serie_comprobante,
				$numero_bol=$reg->num_comprobante
				  );
			}
			$nums_bol = (int)$numero_s_bol;
			$nuew_serie_bol=0;
			$numb = (int)$numero_bol;
			if($numb==9999999 or empty($numero_s_bol)){
				$nuew_serie_bol=$nums_bol+1;
				echo json_encode($nuew_serie_bol);
			}else{
				echo json_encode($nums_bol);
			} 
			break;//fin de opcion de mostrar num_comprobante y serie_comprobante de boleta

			//opcion para mostrar la numeracion y la serie_comprobante de la boleta
		case 'mostrar_num_ncb':
			//mostrando el numero de boleta de la tabla comprobantes
				require_once "../modelos/Comprobantes.php";
				$comprobantes=new Comprobantes();
	
				$rspta=$comprobantes->mostrar_numero_ncb();
				$data=Array();
				while ($reg=$rspta->fetch_object()) {
					$data[]=array(
					$num_comp=$reg->num_comprobante
					  );
					}
					$numero_bol_comp = (int)$num_comp;
			//fin de mostrar numero de boleta de la tabla comprobantes
	
			$rspta=$venta->numero_venta_ncb();
			$data=Array();
			$numerob=$numero_bol_comp;
	
			while ($reg=$rspta->fetch_object()) {
				$data[]=array(
				$numerob=$reg->num_comprobante
				  );
			}
			$numero_boleta = (int)$numerob;
			$new_boleta='';
	
			if($numero_boleta==9999999 or empty($numerob)){
				$new_boleta='0000001';
				echo json_encode($new_boleta);
			}elseif($numerob==9999999){
				$new_boleta='0000001';
				echo json_encode($new_boleta);
	
			}else{
				$sumabol=$numero_boleta+1;
				echo json_encode($sumabol);
			} 
			//$num = (int)$numerof; 
			//echo json_encode($numerof);
			break;
	
			case 'mostrar_serie_ncb':
				//mostrando el numero de factura de la tabla comprobantes
			require_once "../modelos/Comprobantes.php";
					$comprobantes=new Comprobantes();
		
					$rspta=$comprobantes->mostrar_serie_ncb();
					$data=Array();
					while ($reg=$rspta->fetch_object()) {
						$data[]=array(
						$serie_comp_bol=$reg->serie_comprobante,
						$num_comp_bol=$reg->num_comprobante
						  );
						}
						$serie_bol_comp = (int)$serie_comp_bol;
						$num_bol_comp = (int)$num_comp_bol;
		//fin de mostrar numero de factura de la tabla comprobantes
				$rspta=$venta->numero_serie_ncb();
				$data=Array();
				$numero_s_bol=$serie_bol_comp;
				$numero_bol=$num_bol_comp;
		
				while ($reg=$rspta->fetch_object()) {
					$data[]=array(
					$numero_s_bol=$reg->serie_comprobante,
					$numero_bol=$reg->num_comprobante
					  );
				}
				$nums_bol = (int)$numero_s_bol;
				$nuew_serie_bol=0;
				$numb = (int)$numero_bol;
				if($numb==9999999 or empty($numero_s_bol)){
					$nuew_serie_bol=$nums_bol+1;
					echo json_encode($nuew_serie_bol);
				}else{
					echo json_encode($nums_bol);
				} 
				break;//fin de opcion de mostrar num_comprobante y serie_comprobante de boleta
		
		//______________________________________________________________________________________________


	case 'listarDetalle':

		require_once "../modelos/Negocio.php";
		  $cnegocio = new Negocio();
		  $rsptan = $cnegocio->listar();
		  $regn=$rsptan->fetch_object();
		  if (empty($regn)) {
		    $smoneda='Simbolo de moneda';
		  }else{
		    $smoneda=$regn->simbolo;
		    $nom_imp=$regn->nombre_impuesto;
		};

		//recibimos el idventa
		$id=$_GET['id'];

		$rspta=$venta->listarDetalle($id);
		$total=0;
		echo ' <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Venta</th>
        <th>Descuento</th>
        <th>Subtotal</th>
       </thead>';
		while ($reg=$rspta->fetch_object()) {
			echo '<tr class="filas">
			<td></td>
			<td>'.$reg->nombre.'</td>
			<td>'.$reg->cantidad.'</td>
			<td>'.$reg->precio_venta.'</td>
			<td>'.$reg->descuento.'</td>
			<td>'.$reg->subtotal.'</td></tr>';
			$total=$reg->total_venta;

		}

		echo '<tfoot>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th>TOTAL</th>
         <th><h4 id="total">'.$smoneda.' '.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th>
       </tfoot>';

		break;

    case 'listar':

    	$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$estado=$_REQUEST["estado"];

		$rspta=$venta->listar($fecha_inicio,$fecha_fin,$estado);
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
                 	$url1='../reportes/exTicket.php?id=';
                    $url2='../reportes/exFactura.php?id=';

        	$ruta='../public/FACT_WebService/Facturacion/files/'.$reg->dov_Nombre.'.xml';

        	$rutaCdr='../public/FACT_WebService/Facturacion/files/R-'.$reg->dov_Nombre.'.zip';

        	if ($reg->tipo_comprobante == 'Boleta') {

            	$enviarSunat='<a data-toggle="tooltip" title="" data-original-title="Enviar a Sunat" onclick="EnviarSunat(1,'.$reg->idventa.','.$reg->idpersonal.');"> <button class="btn btn-primary btn-xs"><i class="fa fa-upload"></i></button></a> '
            	.'<a href="'.$ruta.'" data-toggle="tooltip" title="" data-original-title="Enviar a Sunat" style="pointer-events: none;"> <button class="btn btn-warning btn-xs"><i class="fa fa-file"></i></button></a> '.'<a href="'.$rutaCdr.'" data-toggle="tooltip" title="" data-original-title="Cdr" style="pointer-events: none;"> <button class="btn btn-danger btn-xs"><i class="fa fa-archive"></i></button></a> ';

            	$pdf='<a target="_blank" data-toggle="tooltip" title="" target="blanck" data-original-title="PDF" onclick="PDF(1,'.$reg->idventa.','.$reg->idpersonal.')"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>';

            	$ticket='<a target="_blank" data-toggle="tooltip" title="" target="blanck" data-original-title="Ticket" onclick="Ticket(1,'.$reg->idventa.','.$reg->idpersonal.')"> <button class="btn btn-primary btn-xs"><i class="fa fa-file-text"></i></button></a>';

            }else{
            	$enviarSunat='<a data-toggle="tooltip" title="" data-original-title="Enviar a Sunat" onclick="EnviarSunat(2,'.$reg->idventa.','.$reg->idpersonal.');"> <button class="btn btn-primary btn-xs"><i class="fa fa-upload"></i></button></a> '
            	.'<a href="'.$ruta.'" data-toggle="tooltip" title="" data-original-title="Enviar a Sunat" style="pointer-events: none;"> <button class="btn btn-warning btn-xs"><i class="fa fa-file"></i></button></a> '.'<a href="'.$rutaCdr.'" data-toggle="tooltip" title="" data-original-title="Cdr" style="pointer-events: none;"> <button class="btn btn-danger btn-xs"><i class="fa fa-archive"></i></button></a> ';

            	$pdf='<a target="_blank" data-toggle="tooltip" title="" target="blanck" data-original-title="PDF" onclick="PDF(2,'.$reg->idventa.','.$reg->idpersonal.')"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>';

            	$ticket='<a target="_blank" data-toggle="tooltip" title="" target="blanck" data-original-title="Ticket" onclick="Ticket(2,'.$reg->idventa.','.$reg->idpersonal.')"> <button class="btn btn-primary btn-xs"><i class="fa fa-file-text"></i></button></a>';
            }

        	$urlComprobarEstado='../public/FACT_WebService/Facturacion/consultacdr.php?idventa='.$reg->idventa.'&codColab='.$reg->idpersonal.'';

            if($reg->estado=='Aceptado'){
            	$estado='<span class="badge bg-green">ACEPTADO</span>';
            	$pdf='<a target="_blank" href="'.$url2.$reg->idventa.'" data-toggle="tooltip" title="" target="blanck" data-original-title="PDF"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>';
            	$ticket='<a target="_blank" href="'.$url1.$reg->idventa.'" data-toggle="tooltip" title="" target="blanck" data-original-title="Ticket"> <button class="btn btn-primary btn-xs"><i class="fa fa-file-text"></i></button></a>';

            }else if($reg->estado=='Por Enviar'){
            	$estado='<span class="badge bg-yellow">POR ENVIAR</span>';
            }else if($reg->estado=='Anulado'){
            	$estado='<span class="badge bg-red">ANULADO</span>';
            }else if($reg->estado=='Nota Credito'){
            	$estado='<span class="badge bg-red">NOTA DE CRÉDITO</span>';
            	$pdf='<a target="_blank" href="'.$url2.$reg->idventa.'" data-toggle="tooltip" title="" target="blanck" data-original-title="PDF"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>';
            	$ticket='<a target="_blank" href="'.$url1.$reg->idventa.'" data-toggle="tooltip" title="" target="blanck" data-original-title="Ticket"> <button class="btn btn-primary btn-xs"><i class="fa fa-file-text"></i></button></a>';
            }else if($reg->estado=='Rechazado'){
            	$estado='<span class="badge bg-red">RECHAZADO</span>';
            	$pdf='<a target="_blank" href="'.$url2.$reg->idventa.'" data-toggle="tooltip" title="" target="blanck" data-original-title="PDF"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>';
            	$ticket='<a target="_blank" href="'.$url1.$reg->idventa.'" data-toggle="tooltip" title="" target="blanck" data-original-title="Ticket"> <button class="btn btn-primary btn-xs"><i class="fa fa-file-text"></i></button></a>';
            }else{
            	$estado='<span class="badge bg-blue">ACTIVADO</span>';
            	$pdf='<a target="_blank" href="'.$url2.$reg->idventa.'" data-toggle="tooltip" title="" target="blanck" data-original-title="PDF"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>';
            	$ticket='<a target="_blank" href="'.$url1.$reg->idventa.'" data-toggle="tooltip" title="" target="blanck" data-original-title="Ticket"> <button class="btn btn-primary btn-xs"><i class="fa fa-file-text"></i></button></a>';
            }

            if($reg->estado=='Por Enviar'){

            	$sunat=$enviarSunat;

            }else if($reg->estado=='Activado' || $reg->estado=='Anulado'){

            	$sunat='<a data-toggle="tooltip" title="" data-original-title="Enviar a Sunat" style="pointer-events: none;"> <button class="btn btn-primary btn-xs"><i class="fa fa-upload"></i></button></a> '.'<a href="'.$ruta.'" data-toggle="tooltip" title="" data-original-title="Enviar a Sunat" style="pointer-events: none;"> <button class="btn btn-warning btn-xs"><i class="fa fa-file"></i></button></a> '.'<a href="'.$rutaCdr.'" data-toggle="tooltip" title="" data-original-title="Cdr" style="pointer-events: none;"> <button class="btn btn-danger btn-xs"><i class="fa fa-archive"></i></button></a> ';

            }else{
            	$sunat='<a data-toggle="tooltip" title="" data-original-title="Enviar a Sunat" style="pointer-events: none;"> <button class="btn btn-primary btn-xs"><i class="fa fa-upload"></i></button></a>'.'<a href="'.$ruta.'" data-toggle="tooltip" title="" data-original-title="XML" target="_blank"> <button class="btn btn-warning btn-xs"><i class="fa fa-file"></i></button></a> '.'<a href="'.$rutaCdr.'" data-toggle="tooltip" title="" data-original-title="Cdr"> <button class="btn btn-danger btn-xs"><i class="fa fa-archive"></i></button></a> ';
            }

            if($reg->tipo_comprobante=='Nota'){
            	$comprobarEstado='<center><a href="'.$urlComprobarEstado.'" data-toggle="tooltip" title="" data-original-title="Comprobar Estado" style="pointer-events: none;"> <button class="btn btn-warning btn-xs" onclick="ComprobarEstado('.$reg->idventa.')"><i class="fa fa-exclamation"></i></button></a></center>';
            }else{
            	$comprobarEstado='<center><a data-toggle="tooltip" title="" data-original-title="Comprobar Estado" onclick="comprobarEstado('.$reg->idventa.','.$reg->idpersonal.');"> <button class="btn btn-warning btn-xs"><i class="fa fa-exclamation"></i></button></a></center>';
            }

			$data[]=array(
            "0"=>$reg->fecha,
            "1"=>$reg->cliente,
            "2"=>$reg->tipo_comprobante,
            "3"=>$reg->serie_comprobante. '-' .$reg->num_comprobante,
            "4"=>$reg->total_venta,
            "5"=>($reg->ventacredito=='Si')?'<center><span class="badge bg-red">Crédito</span></center>':'<center><span class="badge bg-primary">Contado</span></center>',
            "6"=>$estado,
            "7"=>$sunat,
            "8"=>$comprobarEstado,
            "9"=>(($reg->estado=='Activado')?
            '<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>':
            '<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>').
            $pdf.
            $ticket.
            '<a target="_blank" data-toggle="tooltip" title="" target="blanck" data-original-title="Enviar Comprobantes"> <button class="btn btn-success btn-xs" onclick="EnviarComprobante('.$reg->idventa.')"><i class="fa fa-whatsapp"></i></button></a>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectCliente':
			require_once "../modelos/Persona.php";
			$persona = new Persona();

			$rspta = $persona->listarc();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idpersona.'>'.$reg->nombre. ' - ' .$reg->num_documento.'</option>';
			}
		break;

		case 'listarNC':

		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];
		$estado=$_REQUEST["estado"];

		$rspta=$venta->listarNC($fecha_inicio,$fecha_fin,$estado);
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
                 	$url1='../reportes/exTicket.php?id=';
                    $url2='../reportes/exFactura.php?id=';

            if ($reg->tipo_comprobante == 'NC' || $reg->tipo_comprobante == 'NCB') {
            	$urlFac='../public/FACT_WebService/Facturacion/NotaCredito.php?idnc='.$reg->idventa.'&codColab='.$reg->idpersonal.'';
            }

        	$ruta='../public/FACT_WebService/Facturacion/files/'.$reg->dov_Nombre.'.xml';

        	$rutaCdr='../public/FACT_WebService/Facturacion/files/R-'.$reg->dov_Nombre.'.zip';

        	$pdf='<a target="_blank" data-toggle="tooltip" title="" target="blanck" data-original-title="PDF" onclick="PDFNC('.$reg->idventa.','.$reg->idpersonal.')"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>';

            $ticket='<a target="_blank" data-toggle="tooltip" title="" target="blanck" data-original-title="Ticket" onclick="TicketNC('.$reg->idventa.','.$reg->idpersonal.')"> <button class="btn btn-primary btn-xs"><i class="fa fa-file-text"></i></button></a>';

            if($reg->estado=='Aceptado'){
            	$estado='<span class="badge bg-green">ACEPTADO</span>';
            	$pdf='<a target="_blank" href="'.$url2.$reg->idventa.'" data-toggle="tooltip" title="" target="blanck" data-original-title="PDF"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>';
            	$ticket='<a target="_blank" href="'.$url1.$reg->idventa.'" data-toggle="tooltip" title="" target="blanck" data-original-title="Ticket"> <button class="btn btn-primary btn-xs"><i class="fa fa-file-text"></i></button></a>';
            	
            }else if($reg->estado=='Por Enviar'){
            	$estado='<span class="badge bg-yellow">POR ENVIAR</span>';
            }else if($reg->estado=='Anulado'){
            	$estado='<span class="badge bg-red">ANULADO</span>';
            }else if($reg->estado=='Rechazado'){
            	$estado='<span class="badge bg-red">RECHAZADO</span>';
            }else{
            	$estado='<span class="badge bg-blue">ACTIVADO</span>';
            }

            if($reg->estado=='Por Enviar'){
            	$sunat='<a data-toggle="tooltip" title="" data-original-title="Enviar a Sunat" onclick="EnviarSunat(3,'.$reg->idventa.','.$reg->idpersonal.');"> <button class="btn btn-primary btn-xs"><i class="fa fa-upload"></i></button></a> '.'<a href="'.$ruta.'" data-toggle="tooltip" title="" data-original-title="Enviar a Sunat" style="pointer-events: none;"> <button class="btn btn-warning btn-xs"><i class="fa fa-file"></i></button></a> '.'<a href="'.$rutaCdr.'" data-toggle="tooltip" title="" data-original-title="Cdr" style="pointer-events: none;"> <button class="btn btn-danger btn-xs"><i class="fa fa-archive"></i></button></a> ';
            }else if($reg->estado=='Activado' || $reg->estado=='Anulado'){

            	$sunat='<a href="'.$urlFac.'" data-toggle="tooltip" title="" data-original-title="Enviar a Sunat" style="pointer-events: none;"> <button class="btn btn-primary btn-xs"><i class="fa fa-upload"></i></button></a> '.'<a href="'.$ruta.'" data-toggle="tooltip" title="" data-original-title="Enviar a Sunat" style="pointer-events: none;"> <button class="btn btn-warning btn-xs"><i class="fa fa-file"></i></button></a> '.'<a href="'.$rutaCdr.'" data-toggle="tooltip" title="" data-original-title="Cdr" style="pointer-events: none;"> <button class="btn btn-danger btn-xs"><i class="fa fa-archive"></i></button></a> ';

            }else{
            	$sunat='<a href="'.$urlFac.'" data-toggle="tooltip" title="" data-original-title="Enviar a Sunat" style="pointer-events: none;"> <button class="btn btn-primary btn-xs"><i class="fa fa-upload"></i></button></a>'.'<a href="'.$ruta.'" data-toggle="tooltip" title="" data-original-title="XML" target="_blank"> <button class="btn btn-warning btn-xs"><i class="fa fa-file"></i></button></a> '.'<a href="'.$rutaCdr.'" data-toggle="tooltip" title="" data-original-title="Cdr"> <button class="btn btn-danger btn-xs"><i class="fa fa-archive"></i></button></a> ';
            }

			$data[]=array(
            "0"=>$reg->fecha,
            "1"=>$reg->cliente,
            "2"=>$reg->tipo_comprobante,
            "3"=>$reg->serie_comprobante. '-' .$reg->num_comprobante,
            "4"=>$reg->total_venta,
            "5"=>($reg->ventacredito=='Si')?'<center><span class="badge bg-red">Crédito</span></center>':'<center><span class="badge bg-primary">Contado</span></center>',
            "6"=>$estado,
            "7"=>$sunat,
            "8"=>(($reg->estado=='Activado')?
            '<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>'.' '.'<button class="btn btn-danger btn-xs" onclick="anular('.$reg->idventa.')"><i class="fa fa-close"></i></button>':
            '<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idventa.')"><i class="fa fa-eye"></i></button>').
            $pdf.
            $ticket.
            '<a target="_blank" data-toggle="tooltip" title="" target="blanck" data-original-title="Enviar Comprobantes"> <button class="btn btn-success btn-xs" onclick="EnviarComprobante('.$reg->idventa.')"><i class="fa fa-whatsapp"></i></button></a>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectCliente':
			require_once "../modelos/Persona.php";
			$persona = new Persona();

			$rspta = $persona->listarc();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idpersona.'>'.$reg->nombre. ' - ' .$reg->num_documento.'</option>';
			}
		break;

		case 'selectProducto':
			require_once "../modelos/Producto.php";
			$persona = new Producto();

			$rspta = $persona->listar();

			echo '<option value="Todos">Todos</options>';

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idproducto.'>'.$reg->nombre. '</option>';
			}
		break;

		case 'selectProductoDesempaquetar':
			require_once "../modelos/Producto.php";
			$persona = new Producto();

			$rspta = $persona->listar();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idproducto.'>'.$reg->nombre. ' - '.$reg->unidad.'</option>';
			}
		break;

		case 'selectVendedor':
			require_once "../modelos/Persona.php";
			$persona = new Persona();

			$rspta = $persona->listarv();

			echo '<option value="Todos">Todos</options>';

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idpersonal.'>'.$reg->nombre.'</option>';
			}
		break;

			case 'listarArticulos':
			require_once "../modelos/Producto.php";
			$producto=new Producto();

				$rspta=$producto->listarActivosVenta();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>(($reg->stock==0)?'<button class="btn btn-danger" onclick="nostock()"> <span class="fa fa-shopping-cart"></span></button>':'<button class="btn btn-success" onclick="agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\',1,0,\''.$reg->precio_venta.'\',\''.$reg->precioB.'\',\''.$reg->precioC.'\',\''.$reg->precioD.'\',\''.$reg->stock.'\',\''.$reg->proigv.'\',\''.$reg->unidadmedida.'\')"><span class="fa fa-shopping-cart"></span></button>'),
            "1"=>$reg->nombre,
            "2"=>$reg->unidadmedida,
            "3"=>$reg->categoria,
            "4"=>$reg->codigo,
            "5"=>$reg->stock,
            "6"=>$reg->precio_venta,
            "7"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px'>"
          
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);

				break;

	case 'selectComprobante':
			require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->select();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->nombre.'>'.$reg->nombre.'</option>';
			}
			break;

	case 'selectComprobante2':
			require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->selectNC();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->nombre.'>'.$reg->nombre.'</option>';
			}
	break;

	case 'selectDocumentos':
			require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->selectDocumentos();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idventa.'>'.$reg->serie_comprobante.'-'.$reg->num_comprobante.'</option>';
			}
	break;

	case 'selectMotivos':
			require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->selectMotivos();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->id.'>'.$reg->descripcion.'</option>';
			}
	break;

	case 'buscarProducto':

		$codigo=$_REQUEST["codigo"];

		$rspta=$venta->buscarProducto($codigo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);

	break;

	case 'listarDetalleVenta':

		$rspta=$venta->ventadetalle($idventa);

		$data=Array();

 		while ($reg=$rspta->fetch_object()) {

				$data[]=array(
					"0"=>$reg->idproducto,
					"1"=>$reg->producto,
					"2"=>$reg->cantidad,
					"3"=>$reg->descuento,
					"4"=>$reg->precio_venta,
					"5"=>$reg->stock,
					"6"=>$reg->proigv
				);
			}

			echo json_encode($data);


	break;

}
 ?>